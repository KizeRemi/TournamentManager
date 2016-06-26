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
use CoreBundle\Event\BattleEvent;
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
     * @FOSRest\Post("/battle/{id}/win")
     */
    public function postWinAction(ParamFetcherInterface $paramFetcher, Battle $battle)
    {
        $account = $this->getUser();

        if($account != $battle->getPlayerOne() && $account != $battle->getPlayerTwo()){
            $resp = array("message" => "this battle is not yours");
            return new JsonResponse($resp, 400);
        };

        if($battle->getReadyPlayerOne() == false || $battle->getReadyPlayerTwo() == false){
            $resp = array("message" => "You can't win a battle if the 2 players are not ready ");
            return new JsonResponse($resp, 400);      
        }

        if($account == $battle->getPlayerOne()){
            $battle->setResultPlayerOne(true);
        } else {
            $battle->setResultPlayerTwo(true);
        }

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
     * @FOSRest\Post("/battle/{id}/ready")
     */
    public function postReadyAction(ParamFetcherInterface $paramFetcher, Battle $battle)
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
}