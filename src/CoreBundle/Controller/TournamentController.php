<?php
/**
 * Controller for tournament entity
 */
namespace CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\Controller\Annotations as FOSRest;
use JMS\Serializer\SerializerBuilder;
use CoreBundle\Entity\Tournament;
use CoreBundle\Entity\Match;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
/*
* Class TournamentController
*
* Manage all action in relation with tournament entity
*
* @package     CoreBundle\Controller
* @category    controllers
* @author      Remi Mavillaz <remi.mavillaz@live.fr>
*
*/

class TournamentController extends Controller implements ClassResourceInterface
{

    /**
     * Create tournament
     *
     * @param ParamFetcherInterface $paramFetcher Contain all body parameters received
     * @return JsonResponse Return 201 and empty array if tournament was created OR 400 and error message JSON if error
     *
     * @ApiDoc(
     *  section="Tournaments",
     *  description="Create new tournament",
     *  resource = true,
     *  statusCodes = {
     *     201 = "Returned when successful",
     *     400 = "Returned when password and confirmation doesn't match"
     *   }
     * )
     * @FOSRest\RequestParam(name="name", nullable=false, requirements=@CoreBundle\Validator\Constraints\Name, description="Tournament's name")
     * @FOSRest\RequestParam(name="game", nullable=false, description="Tournament's game")
     * @FOSRest\RequestParam(name="date_begin", requirements=@CoreBundle\Validator\Constraints\Date, nullable=false, description="Tournament's begin date")
     * @FOSRest\RequestParam(name="duration_between_round", nullable=false, requirements=@CoreBundle\Validator\Constraints\Number, description="Tournament's duration between round")
     * @FOSRest\RequestParam(name="player_max", nullable=true, requirements=@CoreBundle\Validator\Constraints\Number, description="Maximum players of a tournament")
     */
	public function postAction(ParamFetcherInterface $paramFetcher)
    {
		$account = $this->getUser();

        $inProgressTournament = $this->getDoctrine()->getRepository('CoreBundle:Tournament')->getByState($account->getId());
        if($inProgressTournament > 0){
            $resp = array("message" => "You already have a tournament in progress");
            return new JsonResponse($resp, 200);
        }

        $tournament = new Tournament();
        $tournament->setName($paramFetcher->get('name'));
        $tournament->setGame($paramFetcher->get('game'));
        $dateBegin = new \DateTime($paramFetcher->get('date_begin'));
        $tournament->setDateBegin($dateBegin);
        $tournament->setDurationBetweenRound($paramFetcher->get('duration_between_round'));
        $tournament->setPlayerMax(8);
        $tournament->setState(1);
        $tournament->setAccount($account);
	    $validator = $this->get("validator");

	    $errors = $validator->validate($tournament);

        $em = $this->getDoctrine()->getManager();
        $em->persist($tournament);
        $em->flush();

        return new JsonResponse(null, JsonResponse::HTTP_CREATED);
    }

   /**
     * Get choosen tournament
     * @return JsonResponse Return 200 and Account array if account was founded OR 404 and error message JSON if error
     *
     * @ApiDoc(
     *  section="Tournaments",
     *  description="Get choosen tournament",
     *  resource = true,
     *  statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when tournament is not found"
     *   }
     * )
     * @Security("has_role('ROLE_USER')")
    */
    public function getAction(Tournament $tournament)
    {
        return $tournament;
    }
   /**
     * Get all tournaments
     * @return JsonResponse Return 200 and Account array if account was founded OR 404 and error message JSON if error
     *
     * @ApiDoc(
     *  section="Tournaments",
     *  description="Get all tournaments",
     *  resource = true,
     *  statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when tournament is not found"
     *   }
     * )
     * @Security("has_role('ROLE_USER')")
    */
    public function cgetAction()
    {
        $em = $this->getDoctrine()->getRepository("CoreBundle:Tournament");
        $tournaments = $em->findAll();
        return $tournaments;
    }

    /**
     * subscribe a match
     *
     * @param ParamFetcherInterface $paramFetcher Contain all body parameters received
     * @return JsonResponse Return 201 and empty array if tournament was created OR 400 and error message JSON if error
     *
     * @ApiDoc(
     *  section="Tournaments",
     *  description="Create new match for a tournament",
     *  resource = true,
     *  statusCodes = {
     *     201 = "Returned when successful",
     *   }
     * )
     */
	public function postSubscribeAction(ParamFetcherInterface $paramFetcher, Tournament $tournament)
    {
		$account = $this->getUser();

       	$match = new Match();
       	$tournament->addListAccount($account);

        $em = $this->getDoctrine()->getManager();
        $em->persist($tournament);
        $em->flush();

        return new JsonResponse(null, JsonResponse::HTTP_CREATED);
    }
}
