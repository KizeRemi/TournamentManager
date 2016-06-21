<?php

/**
 * Controller for user entity
 */
namespace UserBundle\Controller;

use FOS\RestBundle\Routing\ClassResourceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use UserBundle\Entity\User;
use FOS\RestBundle\Controller\Annotations as FOSRest;
use FOS\RestBundle\Request\ParamFetcherInterface;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Class UserController
 *
 * Manage all action in relation with association entity
 *
 * @package     UserBundle\Controller
 * @category    controllers
 * @author      Mavillaz Remi <remi.mavillaz@live.fr>
 *
 */
class UserController extends Controller implements ClassResourceInterface
{
    const ROLE_USER = "ROLE_USER";
    /**
     * @ApiDoc(
     *  description="Link account with an user",
     *  input="Your\Namespace\Form\Type\YourType",
     *  output="UserBundle/Entity/User"
     * )
     */

    /**
     * Link account with user
     *
     * @param ParamFetcherInterface $paramFetcher Contain all body parameters received
     * @return JsonResponse Return 201 and empty array if account was linked OR 400 and error message JSON if error
     *
     * @ApiDoc(
     *  section="Users",
     *  description="Create User",
     *  resource = true,
     *  statusCodes = {
     *     201 = "Returned when successful",
     *   }
     * )
     * @FOSRest\RequestParam(name="name", nullable=false, description="User's name")
     * @FOSRest\RequestParam(name="lastname", nullable=false, description="User's lastname")
     * @FOSRest\RequestParam(name="birth_date", nullable=false, description="User's birth date")
     *
     */
    public function postAction(ParamFetcherInterface $paramFetcher){
		$account = $this->getUser();
		
        $user = new User();
        $user->setName($paramFetcher->get('name'));
        $user->setLastname($paramFetcher->get('lastname'));
        $birthDate = new \DateTime($paramFetcher->get('birth_date'));
        $user->setBirthDate($birthDate);
		$user->setAccount($account);
        $account->setRoles(array(static::ROLE_USER));
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        return new JsonResponse(null, 201);
    }

    /**
     * Get all users
     *
     * @return User Empty User array if no user founded
     *
     * @ApiDoc(
     *  section="Users",
     *  description="Get all users",
     *  resource = true,
     *  statusCodes = {
     *     200 = "Returned when successful",
     *   }
     * )
     * @Security("has_role('ROLE_ADMIN')")
     **/
    public function cgetAction(){
        $users = $this->getDoctrine()->getRepository('UserBundle:User')->findAll();
        return $users;
    }

    /**
     * Update User of an account
     *
     * @param ParamFetcherInterface $paramFetcher Contain all body parameters received
     * @return JsonResponse Return 201 and empty array if account was linked OR 400 and error message JSON if error
     *
     * @ApiDoc(
     *  section="Users",
     *  description="Update User",
     *  resource = true,
     *  statusCodes = {
     *     204 = "Returned when successful",
     *   }
     * )
     * @FOSRest\RequestParam(name="name", nullable=false, requirements=@CoreBundle\Validator\Constraints\Name, description="User's name")
     * @FOSRest\RequestParam(name="lastname", nullable=false, requirements=@CoreBundle\Validator\Constraints\Name   ,description="User's lastname")
     * @FOSRest\RequestParam(name="birth_date", nullable=false, requirements=@CoreBundle\Validator\Constraints\Date, description="User's birth date")
     *
     */
    public function patchAction(ParamFetcherInterface $paramFetcher){
        $account = $this->getUser();
        
        $em = $this->getDoctrine()->getRepository("UserBundle:User");
        $user = $em->findOneByAccount($account);
        
        $user->setName($paramFetcher->get('name'));
        $user->setLastname($paramFetcher->get('lastname'));
        $birthDate = new \DateTime($paramFetcher->get('birth_date'));
        $user->setBirthDate($birthDate);
        
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        return new JsonResponse(null, 204);
    }
}