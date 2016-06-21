<?php
/**
 * Controller for association entity
 */
namespace UserBundle\Controller;

use FOS\RestBundle\Routing\ClassResourceInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use UserBundle\Entity\Account;
use UserBundle\Entity\Association;
use FOS\RestBundle\Controller\Annotations as FOSRest;
use FOS\RestBundle\Request\ParamFetcherInterface;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations\FileParam;
/**
 * Class AssociationController
 *
 * Manage all action in relation with association entity
 *
 * @package     UserBundle\Controller
 * @category    controllers
 * @author      Mavillaz Remi <remi.mavillaz@live.fr>
 *
 */
class AssociationController extends Controller implements ClassResourceInterface
{
    const ROLE_ASSO = "ROLE_ASSO";
    /**
     * @ApiDoc(
     *  description="Link account with an association",
     *  input="Your\Namespace\Form\Type\YourType",
     *  output="UserBundle/Entity/Association"
     * )
     */

    /**
     * Create an association and link current account with this association
     *
     * @param ParamFetcherInterface $paramFetcher Contain all body parameters received
     * @return JsonResponse Return 201 and empty array if account was linked OR 400 and error message JSON if error
     *
     * @ApiDoc(
     *  section="Associations",
     *  description="Create an association and link current account with this association",
     *  resource = true,
     *  statusCodes = {
     *     201 = "Returned when successful",
     *   }
     * )
     * @FileParam(name="files")
     * @FOSRest\RequestParam(name="code", nullable=false, description="Association's code")
     * @FOSRest\RequestParam(name="name", nullable=false, description="Association's name")
     * @FOSRest\RequestParam(name="description", nullable=false, description="Association's description")
     * @FOSRest\RequestParam(name="leader_name", nullable=false, description="Association's leader name")
     * @FOSRest\RequestParam(name="leader_phone", nullable=false, description="Association's leader phone")
     * @FOSRest\RequestParam(name="leader_email", nullable=false, description="Association's leader email")
     * @FOSRest\FileParam(name="asso_file", nullable=false, requirements={"mimeTypes"= {"image/png", "image/jpeg", "application/pdf", "image/bmp"}, "maxSize"="2000k"}, description="Association's document",strict=true)
     * @Security("has_role('ROLE_DEFAULT')")
     */
    public function postAction(ParamFetcherInterface $paramFetcher){

	    /** @var $account Account */
        $account = $this->getUser();
		
    	$association = new Association();
        $association->setCode($paramFetcher->get('code'));
        $association->setName($paramFetcher->get('name'));
        $association->setDescription($paramFetcher->get('description'));
        $association->setLeaderName($paramFetcher->get('leader_name'));
        $association->setLeaderPhone($paramFetcher->get('leader_phone'));
        $association->setLeaderEmail($paramFetcher->get('leader_email'));
		$association->setAccount($account);

		$account->addRole(Account::ROLE_ASSO);
        $file = $paramFetcher->get('asso_file');
        $fileName = $this->get('user.documents_uploader')->upload($paramFetcher->get('code'), $file);
        $association->setFiles($fileName);

	    $validator = $this->get("validator");
	    $errorsAccount = $validator->validate($account);
	    $errorsAssociation = $validator->validate($association);

	    if(count($errorsAccount) > 0){
		    return new JsonResponse(
			    "Oups, an error occured during the execution of the request",
			    JsonResponse::HTTP_BAD_REQUEST);
	    }
	    if(count($errorsAssociation) > 0) {
		    return new JsonResponse(
			    "Association already exist",
			    JsonResponse::HTTP_BAD_REQUEST);
	    }
        $em = $this->getDoctrine()->getManager();
        $em->persist($association);
        $em->flush();

	    $this->sendNewAccountMailToAdmin($account, $association);

        return new JsonResponse(null, JsonResponse::HTTP_CREATED);
    }
    
    /**
     * Get all associations
     *
     * @return Association Empty Association array if no association founded
     *
     * @ApiDoc(
     *  section="Associations",
     *  description="Get all associations",
     *  resource = true,
     *  statusCodes = {
     *     200 = "Returned when successful",
     *   }
     * )
     * @Security("has_role('ROLE_DEFAULT')")
     **/
    public function cgetAction(){
        $associations = $this->getDoctrine()->getRepository('UserBundle:Association')->findAll();
        return $associations;
    }

    /**
     * Update an association
     *
     * @param ParamFetcherInterface $paramFetcher Contain all body parameters received
     * @return JsonResponse Return 204 if account was updated OR 400 and error message JSON if error
     *
     * @ApiDoc(
     *  section="Associations",
     *  description="Update Association",
     *  resource = true,
     *  statusCodes = {
     *     204 = "Returned when successful",
     *   }
     * )
     * @FOSRest\RequestParam(name="description", nullable=false, description="Association's description")
     * @FOSRest\RequestParam(name="leader_name", nullable=false, description="Association's leader name")
     * @FOSRest\RequestParam(name="leader_phone", nullable=false, description="Association's leader phone")
     * @FOSRest\RequestParam(name="leader_email", nullable=false, requirements=@CoreBundle\Validator\Constraints\Email, description="Association's leader email")
     *
     */
    public function patchAction(ParamFetcherInterface $paramFetcher){
        $account = $this->getUser();

        $em = $this->getDoctrine()->getRepository("UserBundle:Association");

	    /** @var Association $association */
        $association = $em->findOneByAccount($account);

        $association->setDescription($paramFetcher->get('description'));
        $association->setLeaderName($paramFetcher->get('leader_name'));
        $association->setLeaderPhone($paramFetcher->get('leader_phone'));
        $association->setLeaderEmail($paramFetcher->get('leader_email'));

	    $validator = $this->get("validator");
	    $errors = $validator->validate($account);

	    if(count($errors) > 0){
		    return new JsonResponse(
			    "Oups, an error occured during the execution of the request",
			    JsonResponse::HTTP_BAD_REQUEST);
	    }

        $em = $this->getDoctrine()->getManager();
        $em->persist($association);
        $em->flush();

	    return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }

	/**
	 * @param Account     $account
	 * @param Association $association
	 */
	private function sendNewAccountMailToAdmin(Account $account, Association $association){

		$url = $this->getParameter("base_url").$this->getParameter("profile_url");

		$message = \Swift_Message::newInstance()
			->setSubject('Nouvelle association sur Colab!')
			->setFrom($this->getParameter('contact_email'))
			->setTo($this->getParameter('owner_email'))
			->setBody(
				$this->renderView(
					'UserBundle:Emails:SendNewAccountToAdmin.html.twig',
					array(
						'confirmationUrl' => $url."/".(int)$account->getId(),
						'assoName' => $association->getName()
					)
				),
				'text/html'
			);
		$this->get('mailer')->send($message);
	}
}
