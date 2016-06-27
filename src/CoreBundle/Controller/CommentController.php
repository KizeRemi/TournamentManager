<?php
/**
 * Controller for comment entity
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
use CoreBundle\Entity\Comment;

/*
* Class CommentController
*
* Manage all action in relation with comment entity
*
* @package     CoreBundle\Controller
* @category    controllers
* @author      Remi Mavillaz <remi.mavillaz@live.fr>
*
*/

class CommentController extends Controller implements ClassResourceInterface
{
	/**
     * Post a comment in account profil
     *
     * @param Account $account
     * @param ParamFetcherInterface $paramFetcher Contain all body parameters received
     * @return JsonResponse Return 201 and empty array if comment was created OR 400 and error message JSON if error
     *
     * @ApiDoc(
     *  section="Comments",
     *  description="Post a comment in account profil",
     *  resource = true,
     *  statusCodes = {
     *     201 = "Returned when successful",
     *     400 = "Returned when invalid tournament"
     *   }
     * )
     * @FOSRest\RequestParam(name="message", nullable=false, description="Comment's message")
     */
    public function postAction(ParamFetcherInterface $paramFetcher, Account $account)
    {
    	$sendBy = $this->getUser();

    	$comment = new Comment();
    	$comment->setSendBy($sendBy);
    	$comment->setAccount($account);
    	$comment->setMessage($paramFetcher->get('message'));

    	$em = $this->getDoctrine()->getManager();
        $em->persist($comment);
        $em->flush($comment);

        return new JsonResponse(null, JsonResponse::HTTP_CREATED);
    }

    /**
     * Delete a comment in account profil
     *
     * @param Account $account
     * @param ParamFetcherInterface $paramFetcher Contain all body parameters received
     * @return JsonResponse Return 201 and empty array if comment was created OR 400 and error message JSON if error
     *
     * @ApiDoc(
     *  section="Comments",
     *  description="Post a comment in account profil",
     *  resource = true,
     *  statusCodes = {
     *     201 = "Returned when successful",
     *     400 = "Returned when invalid tournament"
     *   }
     * )
     */
    public function deleteAction(ParamFetcherInterface $paramFetcher, Comment $comment)
    {
    	$account = $this->getUser();

    	if($comment->getAccount() != $account){
    		$resp = array("message" => "this comment is not link with your account");
            return new JsonResponse($resp, 400);
    	}
    	$em = $this->getDoctrine()->getManager();
        $em->remove($comment);
        $em->flush($comment);

    }
}