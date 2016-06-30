<?php
/**
 * Controller for notification entity
 */
namespace CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\Controller\Annotations as FOSRest;
use JMS\Serializer\SerializerBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use CoreBundle\Event\NextMatchEvent;
use UserBundle\Entity\Account;
use CoreBundle\Entity\Notification;

/*
* Class NotificationController
*
* Manage all action in relation with comment entity
*
* @package     CoreBundle\Controller
* @category    controllers
* @author      Remi Mavillaz <remi.mavillaz@live.fr>
*
*/

class NotificationController extends Controller implements ClassResourceInterface
{
	/**
     * Get last notification
     * @return JsonResponse Return 200 and Tournament array if tournament was founded OR 200 and error message JSON if error
     *
     * @ApiDoc(
     *  section="Notifications",
     *  description="Get notification for a user",
     *  resource = true,
     *  statusCodes = {
     *     200 = "Returned when successful",
     *     200 = "Returned when notification is not found"
     *   }
     * )
     * @Security("has_role('ROLE_USER')")
    */
    public function getLastAction()
    {
        $account = $this->getUser();
        $em = $this->getDoctrine()->getRepository("CoreBundle:Notification");
        $notif = $em->getLastNotif($account);
        return $notif;
    }
   	/**
     * Set seen for a notification
     * @return JsonResponse Return 200 and empty array if notification was seen OR 400 and error message JSON if error
     *
     * @ApiDoc(
     *  section="Notifications",
     *  description="Set seen for a notification",
     *  resource = true,
     *  statusCodes = {
     *     200 = "Returned when successful",
     *     400 = "Returned when notification is not found"
     *   }
     * )
     * @FOSRest\Post("/notification/{notification}/seen")
     * @Security("has_role('ROLE_USER')")
    */
    public function postAction(Notification $notification)
    {
        $account = $this->getUser();

        if($account != $notification->getAccount()){
        	$resp = array("message" => "this notification is not yours");
            return new JsonResponse($resp, 400); 
        }
        $notification->setIsSeen(1);

        $em = $this->getDoctrine()->getManager();
        $em->persist($notification);
        $em->flush();
    }
}