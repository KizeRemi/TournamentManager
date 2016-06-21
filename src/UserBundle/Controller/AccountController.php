<?php
/**
 * Controller for account entity
 */
namespace UserBundle\Controller;

use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\Routing\ClassResourceInterface;
use JMS\Serializer\SerializerBuilder;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use UserBundle\Entity\Account;
use FOS\RestBundle\Controller\Annotations as FOSRest;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use UserBundle\Entity\Association;
use UserBundle\Entity\User;
use UserBundle\Event\RegistrationEvent;
use UserBundle\Event\ResetPasswordEvent;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Model\UserInterface;
use UserBundle\EventListener\RegistrationListener;

/**
 * Class AccountController
 *
 * Manage all action in relation with account entity
 *
 * @package     UserBundle\Controller
 * @category    controllers
 * @author      Elias Cédric Laouiti <elias@laouiti.me>
 *
 */

class AccountController extends Controller implements ClassResourceInterface
{

    /**
     * Create account
     *
     * @param ParamFetcherInterface $paramFetcher Contain all body parameters received
     * @return JsonResponse Return 201 and empty array if account was created OR 400 and error message JSON if error
     *
     * @ApiDoc(
     *  section="Accounts",
     *  description="Create new account",
     *  resource = true,
     *  statusCodes = {
     *     201 = "Returned when successful",
     *     400 = "Returned when password and confirmation doesn't match"
     *   }
     * )
     * @FOSRest\RequestParam(name="email", nullable=false, requirements=@CoreBundle\Validator\Constraints\Email, description="Account's email")
     * @FOSRest\RequestParam(name="password", nullable=false, description="Account's password")
     * @FOSRest\RequestParam(name="password_confirmation", nullable=false, description="Password confirmation")
     */
	public function postAction(ParamFetcherInterface $paramFetcher)
    {
        // TODO : Validator
        if ($paramFetcher->get('password') !== $paramFetcher->get('password_confirmation')) {
            $resp = array("message" => "Password and confirmation password doesn't match");
            return new JsonResponse($resp, JsonResponse::HTTP_BAD_REQUEST);
        }

        $account = new Account();
        $account->setEmail($paramFetcher->get('email'));
        $account->setPlainPassword($paramFetcher->get('password'));
	    $validator = $this->get("validator");
	    $errors = $validator->validate($account);

	    if(count($errors) > 0){
		    return new JsonResponse("already exist email", JsonResponse::HTTP_BAD_REQUEST);
	    }

	    $userManager = $this->get("fos_user.user_manager");
        $userManager->updateUser($account);

	    /** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
	    $dispatcher = $this->get('event_dispatcher');
	    $dispatcher->dispatch(RegistrationEvent::NAME, new RegistrationEvent($account));

	    $em = $this->getDoctrine()->getManager();
	    $em->persist($account);
	    $em->flush();

        return new JsonResponse(null, JsonResponse::HTTP_CREATED);
    }

	/**
	 * Update an account's password
	 *
	 * @param ParamFetcherInterface $paramFetcherInterface Contain all body parameters received
	 *
	 * @return JsonResponse Return 204 and empty array if account was created OR 400 and error message JSON if error
	 *
	 * @ApiDoc(
	 *  section="Accounts",
	 *  description="Update an account",
	 *  resource = true,
	 *  statusCodes = {
	 *     204 = "Returned when successful",
	 *     400 = "Returned when password and confirmation doesn't match OR when email is already used"
	 *   }
	 * )
	 * @FOSRest\Patch("/accounts/me/password")
	 * @FOSRest\RequestParam(name="password", nullable=false, description="Account's password")
	 * @FOSRest\RequestParam(name="password_confirmation", nullable=false, description="Password confirmation")
	 *
	 * @Security("has_role('ROLE_DEFAULT')")
	 *
	 */
    public function patchPasswordAction(ParamFetcherInterface $paramFetcherInterface){
        $account = $this->getUser();

        if($paramFetcherInterface->get("password") != null){
            if($paramFetcherInterface->get("password") == $paramFetcherInterface->get("password_confirmation")){
                $account->setPlainPassword($paramFetcherInterface->get('password'));
                // TODO : Length constrainte
            } else {
                $resp = array("message" => "Password and confirmation password doesn't match");
                return new JsonResponse($resp, JsonResponse::HTTP_BAD_REQUEST);
            }
        }

        $userManager = $this->get("fos_user.user_manager");
        $userManager->updateUser($account);
        $em = $this->getDoctrine()->getManager();
        $em->persist($account);
        $em->flush();
	    return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }



    /**
     * Update account
     *
     * @param ParamFetcherInterface $paramFetcher Contain all body parameters received
     * @return JsonResponse Return 200 and empty array if account was updated OR 400 and error message JSON if error
     *
     * @ApiDoc(
     *  section="Accounts",
     *  description="Update my account",
     *  resource = true,
     *  statusCodes = {
     *     200 = "Returned when successful",
     *   }
     * )
     * @FOSRest\RequestParam(name="address", nullable=true, description="Account's address")
     * @FOSRest\RequestParam(name="region", nullable=true, description="Account's region")
     * @FOSRest\RequestParam(name="phone", nullable=true, description="Account's phone")
     * @FOSRest\RequestParam(name="city", nullable=true, description="Account's city")
     * @FOSRest\RequestParam(name="country", nullable=true, description="Account's country")
	 *
     * @FOSRest\Patch("/me")
     *
     */
	public function patchAction(ParamFetcherInterface $paramFetcher)
    {
        $account = $this->getUser();

        $account->setAddress($paramFetcher->get('address'));
        $account->setRegion($paramFetcher->get('region'));
        $account->setPhone($paramFetcher->get('phone'));
        $account->setCountry($paramFetcher->get('country'));
        $account->setCity($paramFetcher->get('city'));


	    $validator = $this->get("validator");
	    $errors = $validator->validate($account);

	    if(count($errors) > 0){
		    return new JsonResponse("already exist email", JsonResponse::HTTP_BAD_REQUEST);
	    }

	    $userManager = $this->get("fos_user.user_manager");
        $userManager->updateUser($account);

	    $em = $this->getDoctrine()->getManager();
	    $em->persist($account);
	    $em->flush();

        return new JsonResponse(null, JsonResponse::HTTP_CREATED);
    }

	/**
	 * Update an account's email
	 *
	 * @param ParamFetcherInterface $paramFetcherInterface Contain all body parameters received
	 *
	 * @return JsonResponse Return 204 and empty array if account was created OR 400 and error message JSON if error
	 *
	 * @ApiDoc(
	 *  section="Accounts",
	 *  description="Update an account email",
	 *  resource = true,
	 *  statusCodes = {
	 *     204 = "Returned when successful",
	 *     400 = "Returned when email is already used"
	 *   }
	 * )
	 * @FOSRest\Patch("/accounts/me/email")
	 * @FOSRest\RequestParam(name="email", nullable=false, description="Account's email")
	 *
	 * @Security("has_role('ROLE_DEFAULT')")
	 *
	 */
    public function patchEmailAction(ParamFetcherInterface $paramFetcherInterface){
        $account = $this->getUser();

	    if($paramFetcherInterface->get("email") != null){
		    $account->setEmail($paramFetcherInterface->get('email'));
		    // TODO : Unique constrainte
	    }

        $userManager = $this->get("fos_user.user_manager");
        $userManager->updateUser($account);
        $em = $this->getDoctrine()->getManager();
        $em->persist($account);
        $em->flush();
	    return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }

	/**
	 * Add image to account
	 *
	 * @param ParamFetcherInterface $paramFetcherInterface Contain all body parameters received
	 *
	 * @return JsonResponse Return 204 and empty array if account was created OR 400 and error message JSON if error
	 *
	 * @ApiDoc(
	 *  section="Accounts",
	 *  description="Add image to account",
	 *  resource = true,
	 *  statusCodes = {
	 *     201 = "Returned when successful"
	 *   }
	 * )
	 * @FOSRest\Post("/me/image")
	 * @FOSRest\FileParam(name="img", image=true, default="noPicture")
	 *
	 * @Security("has_role('ROLE_DEFAULT')")
	 *
	 */
    public function postImageAction(ParamFetcherInterface $paramFetcherInterface){
        $account = $this->getUser();

	    $img = $paramFetcherInterface->get("img");
	    
	    if($account->getImg() != null){
	    	unlink($this->container->getParameter('accounts_images_directory')."/".$account->getImg());    	
	    }

	    $fileName = $this->get('user.images_uploader')->upload("img", $img);
	    $account->setImg($fileName);

        $userManager = $this->get("fos_user.user_manager");
        $userManager->updateUser($account);
        $em = $this->getDoctrine()->getManager();
        $em->persist($account);
        $em->flush();

	    return new JsonResponse(null, 201);
    }

    /**
     * Get all accounts
     * @return JsonResponse Return 200 and Account array if account was founded OR 404 and error message JSON if error
     *
     * @ApiDoc(
     *  section="Accounts",
     *  description="Get all Account",
     *  resource = true,
     *  statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when account is not found"
     *   }
     * )
     *
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function cgetAction(){
        // TODO : Limit view to ROLE_ADMIN
        $em = $this->getDoctrine()->getRepository("UserBundle:Account");
        $accounts = $em->findAll();
        return $accounts;
    }

   /**
     * Get current user account 's
     * @return JsonResponse Return 200 and Account array if account was founded OR 404 and error message JSON if error
     *
     * @ApiDoc(
     *  section="Accounts",
     *  description="Get current user Account",
     *  resource = true,
     *  statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when account is not found"
     *   }
     * )
     * @FOSRest\Get("/me")
     * @Security("has_role('ROLE_DEFAULT')")
    */
    public function getMeAction(){
        return $this->getAccountInfos($this->getUser());
    }
    
    /**
     * Get an account
     * @param Account $account
     * @return JsonResponse Return 200 and Account array if account was founded OR 404 and error message JSON if error
     *
     * @ApiDoc(
     *  section="Accounts",
     *  description="Get an Account",
     *  resource = true,
     *  statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when account is not found"
     *   }
     * )
     * @ParamConverter("account", class="UserBundle:Account")
     *
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function getAction(Account $account)
    {
        // TODO : Limit view to ROLE_ADMIN
	    return $this->getAccountInfos($account);
    }

	/**
	 * Ask reset password token
	 *
	 * @param ParamFetcherInterface $paramFetcherInterface Contain all body parameters received
	 * @return JsonResponse Return 200 and empty array if account was created OR 400 and error message JSON if error
	 *
	 * @ApiDoc(
	 *  section="Accounts",
	 *  description="Ask a token to reset password",
	 *  resource = true,
	 *  statusCodes = {
	 *     200 = "Returned when successful",
	 *     404 = "Returned when email is unknown"
	 *   }
	 * )
	 * @FOSRest\RequestParam(name="email", nullable=false, description="Email")
	 * @FOSRest\Post("/accounts/reset_password")
	 */
	public function postResetPasswordAction (ParamFetcherInterface $paramFetcherInterface) {
		$email = $paramFetcherInterface->get('email');

		if (is_null($email)) {
			return new JsonResponse("unknown email", JsonResponse::HTTP_BAD_REQUEST);
		}

		/** @var $user \FOS\UserBundle\Model\UserInterface */
		$user = $this->get('fos_user.user_manager')->findUserByUsernameOrEmail($email);

		if (null === $user) {
			throw $this->createNotFoundException();
		}

		if ($user->isPasswordRequestNonExpired($this->getParameter('fos_user.resetting.token_ttl'))) {
			return new JsonResponse("resetting.password_already_requested", JsonResponse::HTTP_CONFLICT);
		}

		if (null === $user->getConfirmationToken()) {
			/** @var $tokenGenerator \FOS\UserBundle\Util\TokenGeneratorInterface */
			$tokenGenerator = $this->get('fos_user.util.token_generator');
			$user->setConfirmationToken($tokenGenerator->generateToken());
		}

		$this->get('user.mailer')->sendResettingEmailMessage($user);
		$user->setPasswordRequestedAt(new \DateTime());
		$this->get('fos_user.user_manager')->updateUser($user, true);
		
		return new JsonResponse([], JsonResponse::HTTP_OK);

	}

	/**
	 * Reset password with token
	 *
	 * @param ParamFetcherInterface $paramFetcherInterface Contain all body parameters received
	 * @param String                $token
	 *
	 * @return JsonResponse Return 200 and empty array if account was created OR 400 and error message JSON if error
	 *
	 * @ApiDoc(
	 *  section="Accounts",
	 *  description="Reset password with token",
	 *  resource = true,
	 *  statusCodes = {
	 *     200 = "Returned when successful",
	 *     400 = "Returned when password and confirmation doesn't match",
	 *     404 = "Returned when email is unknown"
	 *   }
	 * )
	 * @FOSRest\RequestParam(name="password", nullable=false, description="New password")
	 * @FOSRest\RequestParam(name="password_confirmation", nullable=false, description="New password confirmation")
	 * @FOSRest\Post("/accounts/reset_password/{token}")
	 */
	public function postChangePasswordAction (ParamFetcherInterface $paramFetcherInterface, $token){

		/** @var $user \FOS\UserBundle\Model\UserInterface */
		$user = $this->get('fos_user.user_manager')->findUserByConfirmationToken($token);

		$password = $paramFetcherInterface->get("password");
		$password_confirmation = $paramFetcherInterface->get("password_confirmation");

		if($password !== $password_confirmation){
			$resp = array("message" => "Password and confirmation password doesn't match");
			return new JsonResponse($resp, JsonResponse::HTTP_BAD_REQUEST);
		}

		if (null === $user) {
			throw $this->createNotFoundException();
		}

		if (!$user->isPasswordRequestNonExpired($this->getParameter('fos_user.resetting.token_ttl'))) {
			return new JsonResponse("resetting.password_request_expired", JsonResponse::HTTP_GONE);
		}

		/** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
		$dispatcher = $this->get('event_dispatcher');
		$event = new ResetPasswordEvent($user);
		$dispatcher->dispatch(ResetPasswordEvent::NAME, $event);

		$user->setPlainPassword($password);

		$userManager = $this->get("fos_user.user_manager");
		$userManager->updateUser($user);

		$em = $this->getDoctrine()->getManager();
		$em->persist($user);
		$em->flush();

		return new JsonResponse("", JsonResponse::HTTP_ACCEPTED);

	}

	/**
	 * Validate an account with token
	 *
	 * @param String $token
	 *
	 * @return JsonResponse Return 200 and empty array if account was activated OR 404 if account was not found
	 *
	 * @ApiDoc(
	 *  section="Accounts",
	 *  description="Validate account with token",
	 *  resource = true,
	 *  statusCodes = {
	 *     200 = "Returned when successful",
	 *     404 = "Returned when email is unknown"
	 *   }
	 * )
	 * @FOSRest\Post("/accounts/confirm_registration/{token}")
	 */
	public function postConfirmationRegistrationAction($token){
		/** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
		$userManager = $this->get('fos_user.user_manager');

		$user = $userManager->findUserByConfirmationToken($token);

		if (null === $user) {
			return new JsonResponse("", JsonResponse::HTTP_NOT_FOUND);
		}


		$user->setConfirmationToken(null);
		$user->setEnabled(true);

		$userManager->updateUser($user);

		return new JsonResponse("", JsonResponse::HTTP_ACCEPTED);
	}

	/**
	 * Get account info
	 *
	 * @param Account $account
	 *
	 * @return null|User|Association
	 */
	private function getAccountInfos(Account $account) {
		$resp   = null;
		$infos  = null;
		$table  = null;
		$em     = null;

		if ($account->hasRole(Account::ROLE_ASSO)) {
			$em = $this->getDoctrine()->getRepository("UserBundle:Association");
			$infos = $em->findOneByAccount($account);
		} elseif ($account->hasRole(Account::ROLE_USER)) {
			$em = $this->getDoctrine()->getRepository("UserBundle:User");
			$infos = $em->findOneByAccount($account);
		}

		if(!$infos){
			return new JsonResponse(null, JsonResponse::HTTP_NOT_FOUND);
		}
		/** @var  Association|User $infos */
		return $infos;
	}

}
