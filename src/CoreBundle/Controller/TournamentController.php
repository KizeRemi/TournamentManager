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
use CoreBundle\Entity\Battle;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use CoreBundle\Event\BattleEvent;
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
     * Update a tournament
     * @return JsonResponse Return 200 and Account array if account was founded OR 404 and error message JSON if error
     *
     * @ApiDoc(
     *  section="Tournaments",
     *  description="Get choosen tournament",
     *  resource = true,
     *  statusCodes = {
     *     200 = "Returned when successful",
     *     400 = "Returned when tournament is not yours"
     *   }
     * )
     * @FOSRest\RequestParam(name="description", nullable=true, description="Tournament's description")
     * @FOSRest\RequestParam(name="date_begin", requirements=@CoreBundle\Validator\Constraints\Date, nullable=false, description="Tournament's begin date")
     * @Security("has_role('ROLE_USER')")
    */
    public function patchAction(ParamFetcherInterface $paramFetcher,Tournament $tournament)
    {
        $account = $this->getUser();

        if($tournament->getAccount() != $account){
            $resp = array("message" => "this tournament is not yours");
            return new JsonResponse($resp, 400);
        }

        $tournament->setDescription($paramFetcher->get('description'));
        $dateBegin = new \DateTime($paramFetcher->get('date_begin'));
        $tournament->setDateBegin($dateBegin);

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
     * register to a match
     *
     * @param Tournament $tournament
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
	public function postRegisterAction(ParamFetcherInterface $paramFetcher, Tournament $tournament)
    {
		$account = $this->getUser();

		$registers = $tournament->getAccounts();
        $playerMax = $tournament->getPlayerMax();
		if(count($registers) >= $playerMax){
            $resp = array("message" => "this tournament already has the maximum number of required players");
            return new JsonResponse($resp, 400);
		};
		if($registers->contains($account)){
            $resp = array("message" => "You are already registered in this tournament");
            return new JsonResponse($resp, 400);
		}
       	$tournament->addAccount($account); 
        if(count($registers) == $playerMax){
            $tournament->setState(2);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($tournament);
        $em->flush();

        return new JsonResponse(null, JsonResponse::HTTP_CREATED);
    }

    /**
     * get registered to tournaments
     *
     * @param ParamFetcherInterface $paramFetcher Contain all body parameters received
     * @return JsonResponse Return 200 or empty array if tournament has no registers
     *
     * @ApiDoc(
     *  section="Tournaments",
     *  description="get registered to tournaments",
     *  resource = true,
     *  statusCodes = {
     *     200 = "Returned when successful",
     *   }
     * )
     * @Security("has_role('ROLE_USER')")
     */
	public function getRegisterAction(ParamFetcherInterface $paramFetcher, Tournament $tournament)
    {
		return $tournament->getAccounts();
    }

    /**
     * Validate all registers for a tournament
     *
     * @param Tournament $tournament
     * @param ParamFetcherInterface $paramFetcher Contain all body parameters received
     * @return JsonResponse Return 201 and empty array if tournament was created OR 400 and error message JSON if error
     *
     * @ApiDoc(
     *  section="Tournaments",
     *  description="Validate registers for a tournament",
     *  resource = true,
     *  statusCodes = {
     *     201 = "Returned when successful",
     *     400 = "Returned when invalid tournament"
     *   }
     * )
     */
    public function postValidateAction(ParamFetcherInterface $paramFetcher, Tournament $tournament)
    {
        $account = $this->getUser();
        if($account != $tournament->getAccount()){
            $resp = array("message" => "this tournament is not yours");
            return new JsonResponse($resp, 400);
        };
        if($tournament->getState() != "Complet"){
            $resp = array("message" => "this tournament is already validate");
            return new JsonResponse($resp, 400);      
        }
        $registers = $tournament->getAccounts($account);
        $playerMax = $tournament->getPlayerMax();
        if(count($registers) != $playerMax){
            $resp = array("message" => "This tournament cannot be validate");
            return new JsonResponse($resp, 400);
        }
        $tournament->setState(3); 


        $registers = $registers->toArray();
        $this->get("event_dispatcher")->dispatch(BattleEvent::NAME, new BattleEvent($registers, $tournament));
        $em = $this->getDoctrine()->getManager();
        $em->persist($tournament);
        $em->flush($tournament);

        return new JsonResponse(null, JsonResponse::HTTP_CREATED);
    }

   /**
     * Get all battles for a tournament
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
    public function getBattlesAction(Tournament $tournament)
    {
        $em = $this->getDoctrine()->getRepository("CoreBundle:Battle");
        $battles = $em->findByTournament($tournament);
        return $battles;
    }


    /**
     * Get current tournament for an account
     * @return JsonResponse Return 200 and Tournament array if tournament was founded OR 200 and error message JSON if error
     *
     * @ApiDoc(
     *  section="Tournaments",
     *  description="Get current tournament for an account",
     *  resource = true,
     *  statusCodes = {
     *     200 = "Returned when successful",
     *     200 = "Returned when tournament is not found"
     *   }
     * )
     * @Security("has_role('ROLE_USER')")
    */
    public function getCurrentMeAction()
    {
        $account = $this->getUser();

        $em = $this->getDoctrine()->getRepository("CoreBundle:Tournament");
        $tournament = $em->findCurrentTournamentForAccount($account);
        return $tournament;
    }

    /**
     * Get all registered tournaments
     * @return JsonResponse Return 200 and Tournament array if tournament was founded OR 200 and error message JSON if error
     *
     * @ApiDoc(
     *  section="Tournaments",
     *  description="Get all registered tournaments",
     *  resource = true,
     *  statusCodes = {
     *     200 = "Returned when successful",
     *     200 = "Returned when tournament is not found"
     *   }
     * )
     * @Security("has_role('ROLE_USER')")
    */
    public function getRegisteredAction()
    {
        $account = $this->getUser();
        $em = $this->getDoctrine()->getRepository("CoreBundle:Tournament");
        $tournaments = $em->getRegisteredTournamentForAccount($account);
        return $tournaments;
    }
}
