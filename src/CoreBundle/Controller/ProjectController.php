<?php
/**
 * Controller for project entity
 */
namespace CoreBundle\Controller;

use CoreBundle\Entity\Promise;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use CoreBundle\Entity\Project;
use JMS\SecurityExtraBundle\Annotation\Secure;
use FOS\RestBundle\Controller\Annotations as FOSRest;
use FOS\RestBundle\Request\ParamFetcherInterface;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use UserBundle\Entity\Account;

/**
 * Class ProjectController
 *
 * Manage all action in relation with association entity
 *
 * @package     CoreBundle\Controller
 * @category    controllers
 * @author      Mavillaz Remi <remi.mavillaz@live.fr>
 * @author      Laouiti Elias <elias@laouiti.me>
 *
 */
class ProjectController extends Controller implements ClassResourceInterface
{
    /**
     * @ApiDoc(
     *  description="Create a project",
     *  input="Your\Namespace\Form\Type\YourType",
     *  output="CoreBundle/Entity/Project"
     * )
     */

    /**
     * Create a project
     *
     * @param ParamFetcherInterface $paramFetcher Contain all body parameters received
     * @return JsonResponse Return 201 and empty array if account was linked OR 400 and error message JSON if error
     *
     * @ApiDoc(
     *  section="Projects",
     *  description="Create project",
     *  resource = true,
     *  statusCodes = {
     *     201 = "Returned when successful",
     *     400 = "Returned when already have project",
     *   }
     * )
     * @FOSRest\RequestParam(name="name", nullable=false, description="Project's name")
     * @FOSRest\RequestParam(name="description", nullable=false, description="Project's description")
     * @FOSRest\FileParam(name="banner", image=true, default="noPicture")
     *
     */
	public function postAction(ParamFetcherInterface $paramFetcher){
		$account = $this->getUser();
        $association = $this->getDoctrine()->getRepository('UserBundle:Association')->findOneBy(["account" => $account]);
		// TODO : Date publication

        $waitingProject = $this->getDoctrine()->getRepository('CoreBundle:Project')->getByState($association);
        if($waitingProject > 0){
            $resp = array("message" => "You already have a project pending validation");
            return new JsonResponse($resp, 200);
        }

        $date = new \DateTime();
        $project = new Project();
        $banner = $paramFetcher->get('banner');
        $fileName = $this->get('projects.banners_uploader')->upload("banner", $banner);
        $project->setBanner($fileName);

 
        $project->setAssociation($association);
        $project->setName($paramFetcher->get('name'));
        $project->setDescription($paramFetcher->get('description'));
        $project->setVisibility(0);
		$project->setState(1);
        $project->setdatePublication($date);

        $em = $this->getDoctrine()->getManager();
        $em->persist($project);
        $em->flush();

        return new JsonResponse(null, 201);
    }

	/**
	 * Update a project
	 *
	 * @param Project               $project
	 * @param ParamFetcherInterface $paramFetcher Contain all body parameters received
	 *
	 * @return JsonResponse Return 201 and empty array if project was updated OR 400 and error message JSON if error
	 *
	 * @ApiDoc(
	 *  section="Projects",
	 *  description="Update a project",
	 *  resource = true,
	 *  statusCodes = {
	 *     201 = "Returned when successful",
	 *   }
	 * )
	 * @FOSRest\RequestParam(name="name", nullable=true, description="Project's name")
	 * @FOSRest\RequestParam(name="description", nullable=true, description="Project's description")
     *
     * @Secure(roles="ROLE_ADMIN")
	 */
    public function patchAction(Project $project, ParamFetcherInterface $paramFetcher){
        $account = $this->getUser();
        // TODO : validation
        $project->setName($paramFetcher->get('name'));
        $project->setDescription($paramFetcher->get('description'));        
        $em = $this->getDoctrine()->getManager();
        $em->persist($project);
        $em->flush();
        return new JsonResponse(null, 201);
    }

    /**
     * Validate a project
     *
     * @param Project               $project
     * @param ParamFetcherInterface $paramFetcher Contain all body parameters received
     *
     * @return JsonResponse Return 200 and empty array if project is validate OR 400 and error message JSON if error
     *
     * @ApiDoc(
     *  section="Projects",
     *  description="Validate a project",
     *  resource = true,
     *  statusCodes = {
     *     200 = "Returned when successful",
     *   }
     * )
     * @FOSRest\RequestParam(name="state", requirements="(open|refused)", nullable=false, description="Project's validation")
     *
     * @Secure(roles="ROLE_ADMIN")
     */
    public function patchValidateAction(Project $project, ParamFetcherInterface $paramFetcher){

        if($project->getState() == "waiting validation"){
            $project->setState($paramFetcher->get('state'));
            $project->setVisibility(1);
        } else {
            $resp = array("message" => "This project is not in waiting validation");
            return new JsonResponse($resp, 400);
        }
        
        $em = $this->getDoctrine()->getManager();
        $em->persist($project);
        $em->flush();
        return new JsonResponse(null, 200);
    }

    /**
     * Done a project
     *
     * @param Project               $project
     * @param ParamFetcherInterface $paramFetcher Contain all body parameters received
     *
     * @return JsonResponse Return 200 and empty array if account was linked OR 400 and error message JSON if error
     *
     * @ApiDoc(
     *  section="Projects",
     *  description="Done a project",
     *  resource = true,
     *  statusCodes = {
     *     200 = "Returned when successful",
     *   }
     * )
     * @FOSRest\RequestParam(name="state", requirements="(done)", nullable=false, description="Project's done")
     *
     * @Secure(roles="ROLE_ASSO")
     */
    public function patchDoneAction(Project $project, ParamFetcherInterface $paramFetcher){
        $account = $this->getUser();
        $association = $this->getDoctrine()->getRepository('UserBundle:Association')->findOneByAccount($account);

        if($project->getAssociation() != $association){
            $resp = array("message" => "Access denied");
            return new JsonResponse($resp, 401);
        }
 
        if($project->getState() != "refused"){
            $project->setState($paramFetcher->get('state'));
            $project->setVisibility(3);
        } else {
            $resp = array("message" => "This project is not in waiting validation");
            return new JsonResponse($resp, 400);
        }
        
        $em = $this->getDoctrine()->getManager();
        $em->persist($project);
        $em->flush();
        return new JsonResponse(null, 200);
    }

	/**
	* Get all projects
	*
	* @return Project[] Empty Project array if no project founded
	*
	* @ApiDoc(
	*  section="Projects",
	*  description="Get all projects",
	*  resource = true,
	*  statusCodes = {
	*     200 = "Returned when successful",
	*   }
	* )
	**/
    public function cgetAction()
    {
        $account = $this->getUser();

        if ($account->hasRole(Account::ROLE_SUPER_ADMIN)) {
            $projects = $this->getDoctrine()->getRepository('CoreBundle:Project')->findAll();
        } elseif ($account->hasRole(Account::ROLE_DEFAULT)) {
            $projects = $this->getDoctrine()->getRepository('CoreBundle:Project')->findByVisibility(1);
        }
    	
    	return $projects;
    }

    /**
     * Get a project
     * @param Project $project
     * @return JsonResponse Return 200 and project array if project was founded OR 404 and error message JSON if error
     *
     * @ApiDoc(
     *  section="Projects",
     *  description="Get a project",
     *  resource = true,
     *  statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when account is not found"
     *   }
     * )
     * @ParamConverter("project", class="CoreBundle:Project")
     *
     * @Secure(roles="ROLE_USER")
     */
    public function getAction(Project $project){
        return $project;
    }

	/**
	 * Create a promise
	 *
	 * @param ParamFetcherInterface $paramFetcher Contain all body parameters received
	 * @param Project               $project
	 *
	 * @return JsonResponse Return 201 and empty array if account was linked OR 404 is project not exist
	 *
	 * @ApiDoc(
	 *  section="Projects",
	 *  description="Create promise",
	 *  resource = true,
	 *  statusCodes = {
	 *     201 = "Returned when successful",
	 *   }
	 * )
	 * @FOSRest\RequestParam(name="amount", nullable=false, requirements="\d+", description="Promise's amount")
	 * @FOSRest\RequestParam(name="userHidden", nullable=false, description="User hidden")
	 */
    public function postPromiseAction(ParamFetcherInterface $paramFetcher, Project $project){
        $account = $this->getUser();
        $promise = new Promise();;

        if (!$project) {
            $resp = array("message" => "This project does not exist");
            return new JsonResponse($resp, 400);
        }

        $paramFetcher->get('amount');
        $promise->setAccount($account);
        $promise->setProject($project);
        $promise->setAmount($paramFetcher->get('amount'));

        if($paramFetcher->get('userHidden') == true ){
            $promise->setUserHidden(true);
        } else{
            $promise->setUserHidden(false);
        }
        

        $em = $this->getDoctrine()->getManager();
        $em->persist($promise);
        $em->flush();
        return new JsonResponse(null, 201);
    }

	/**
	 * Get a promise
	 *
	 * @param Project $project
	 * @param Promise $promise
	 *
	 * @return Promise Empty Promise array if no project founded
	 *
	 * @ApiDoc(
	 *  section="Projects",
	 *  description="Get a promise for a project",
	 *  resource = true,
	 *  statusCodes = {
	 *     200 = "Returned when successful",
	 *   }
	 * )
	 */
    public function getPromiseAction(Project $project, Promise $promise){
        return $promise;
    }
}