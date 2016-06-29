<?php
/**
 * Controller for battle entity
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
use CoreBundle\Event\NextMatchEvent;
/*
* Class BattleController
*
* Manage all action in relation with battle entity
*
* @package     CoreBundle\Controller
* @category    controllers
* @author      Remi Mavillaz <remi.mavillaz@live.fr>
*
*/

class BattleController extends Controller implements ClassResourceInterface
{
    /**
     * Set a win for a battle
     *
     * @param Tournament $tournament
     * @param ParamFetcherInterface $paramFetcher Contain all body parameters received
     * @return JsonResponse Return 201 and empty array if tournament was created OR 400 and error message JSON if error
     *
     * @ApiDoc(
     *  section="Battles",
     *  description="Set a win for a battle",
     *  resource = true,
     *  statusCodes = {
     *     201 = "Returned when successful",
     *     400 = "Returned when invalid tournament"
     *   }
     * )
     * @FOSRest\Post("/battle/{battle}/win")
     */
    public function postWinAction(ParamFetcherInterface $paramFetcher, Battle $battle)
    {
        $account = $this->getUser();
        $tournament = $battle->getTournament();
        $round = $battle->getRound();
        $bonus = 0;
        if($account != $battle->getPlayerOne() && $account != $battle->getPlayerTwo()){
            $resp = array("message" => "this battle is not yours");
            return new JsonResponse($resp, 400);
        };

        if($battle->getReadyPlayerOne() == false || $battle->getReadyPlayerTwo() == false){
            $resp = array("message" => "You can't win a battle if the 2 players are not ready ");
            return new JsonResponse($resp, 400);      
        }
        if($battle->getWinner() != null){
            $resp = array("message" => "The user ".$battle->getWinner()->getNickname()." has already winning. Send a message to organisator for contest");
            return new JsonResponse($resp, 400);   
        }
        $battle->setWinner($account);

        if($battle->getNumber() %2 == 0 && $battle->getRound() != 1){
            $number = $battle->getNumber()-1;
            $battleTwo = $this->getDoctrine()->getRepository('CoreBundle:Battle')->getByNumberAndTournament($number, $tournament, $round);
            $this->get("event_dispatcher")->dispatch(NextMatchEvent::NAME, new NextMatchEvent($battleTwo, $battle));
        } else if ($battle->getRound() != 1){
            $number = $battle->getNumber()+1;
            $battleTwo = $this->getDoctrine()->getRepository('CoreBundle:Battle')->getByNumberAndTournament($number, $tournament, $round);
            $this->get("event_dispatcher")->dispatch(NextMatchEvent::NAME, new NextMatchEvent($battle, $battleTwo));
        }
        if($battle->getRound() == 1){
            $bonus = 100;
        }
        $this->get('user.manage_experience')->setNotificationTournamentToAccount($account);

        $em = $this->getDoctrine()->getManager();
        $em->persist($battle);
        $em->flush($battle);

        return new JsonResponse(null, JsonResponse::HTTP_CREATED);
    }

    /**
     * Set ready for a battle
     *
     * @param Tournament $tournament
     * @param ParamFetcherInterface $paramFetcher Contain all body parameters received
     * @return JsonResponse Return 201 and empty array if tournament was created OR 400 and error message JSON if error
     *
     * @ApiDoc(
     *  section="Battles",
     *  description="Set ready for a battle",
     *  resource = true,
     *  statusCodes = {
     *     201 = "Returned when successful",
     *     400 = "Returned when invalid tournament"
     *   }
     * )
     * @FOSRest\Post("/battle/{battle}/ready")
     */
    public function postReadyAction(Battle $battle)
    {
        $account = $this->getUser();

        if($account != $battle->getPlayerOne() && $account != $battle->getPlayerTwo()){
            $resp = array("message" => "this battle is not yours");
            return new JsonResponse($resp, 400);
        };

        if($account == $battle->getPlayerOne()){
            $battle->setReadyPlayerOne(true);
        } else {
            $battle->setReadyPlayerTwo(true);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($battle);
        $em->flush($battle);

        return new JsonResponse(null, JsonResponse::HTTP_CREATED);
    }

    /**
     * Get a winner for a battle
     * @return JsonResponse Return 200 and winner array if account was founded OR 404 and error message JSON if error
     *
     * @ApiDoc(
     *  section="Battles",
     *  description="Get a winner for a battle",
     *  resource = true,
     *  statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when battle is not found"
     *   }
     * )
     * @FOSRest\Get("/battle/{battle}/winner")
     * @Security("has_role('ROLE_USER')")
    */
    public function getWinnerAction(Battle $battle)
    {
        return $battle->getWinner();
    }
}