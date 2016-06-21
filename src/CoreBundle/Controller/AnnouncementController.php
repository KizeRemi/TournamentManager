<?php

/**
 * Announcement Controller
 */
namespace CoreBundle\Controller;

	use CoreBundle\Entity\Announcement;
	use FOS\RestBundle\Request\ParamFetcherInterface;
	use FOS\RestBundle\Routing\ClassResourceInterface;
	use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
	use Symfony\Bundle\FrameworkBundle\Controller\Controller;
	use Symfony\Component\HttpFoundation\JsonResponse;
	use Symfony\Component\Validator\Constraints\DateTime;
	use UserBundle\Entity\Account;
	use FOS\RestBundle\Controller\Annotations as FOSRest;
	use JMS\SecurityExtraBundle\Annotation\Secure;
	use Nelmio\ApiDocBundle\Annotation\ApiDoc;
	use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
	use CoreBundle\Entity\Receive;
	/**
	 * Class AnnouncementController
	 *
	 * Manage all action in relation with announcement entity
	 *
	 * @package     CoreBundle\Controller
	 * @category    controllers
	 * @author      Laouiti Elias <elias@laouiti.me>
	 *
	 */
	class AnnouncementController extends Controller implements ClassResourceInterface
	{

	/**
	 * Announcement Controller
	 * Create an anouncement
	 *
	 * @param ParamFetcherInterface $paramFetcher Contain all body parameters received
	 * @return JsonResponse Return 201 and empty array if announcement was created OR 400 and error message JSON if error
	 *
	 * @ApiDoc(
	 *  section="Announcement",
	 *  description="Create new announcement",
	 *  resource = true,
	 *  statusCodes = {
	 *     201 = "Returned when successful",
	 *     400 = "Returned when required param is empty"
	 *   }
	 * )
	 * @FOSRest\RequestParam(name="name", nullable=false, description="Announcement name")
	 * @FOSRest\RequestParam(name="description", nullable=false, description="Announcement description")
	 * @FOSRest\RequestParam(name="dateBegin", nullable=false, description="[Timestamp] Announcement start date")
	 * @FOSRest\RequestParam(name="dateEnd", nullable=true, description="[Timestamp] Announcement stop date")
	 * @FOSRest\RequestParam(name="city", nullable=false, description="Announcement city ")
	 * @FOSRest\RequestParam(name="address", nullable=false, description="Announcement address")
	 * @FOSRest\RequestParam(name="contactName", nullable=false, description="Announcement contact name")
	 * @FOSRest\RequestParam(name="contactEmail", nullable=true, requirements=@CoreBundle\Validator\Constraints\Email, description="Announcement contact email")
	 * @FOSRest\RequestParam(name="contactPhone", nullable=true, description="Announcement contact phone")
	 * @FOSRest\RequestParam(name="type", nullable=false, description="Announcement type : 'exchange', 'donate', 'collect'")
	 * @FOSRest\RequestParam(name="stock", nullable=true, description="Announcement quantity")
	 * @FOSRest\RequestParam(name="minCollect", nullable=true, requirements=@CoreBundle\Validator\Constraints\Number, description="Announcement minimum collect")
	 * @FOSRest\RequestParam(name="maxCollect", nullable=true, requirements=@CoreBundle\Validator\Constraints\Number, description="Announcement maximum collect")
	 * @FOSRest\RequestParam(name="shipping", nullable=false, requirements=@CoreBundle\Validator\Constraints\Boolean, description="Object can be shipped ?")
	 */
	public function postAction(ParamFetcherInterface $paramFetcher)
	{
		$announcement = new Announcement();
		$announcement->setAccountId($this->getUser());
		$announcement->setName($paramFetcher->get("name"));
		$announcement->setDescription($paramFetcher->get("description"));
		$dateBegin = new \DateTime();
		// TODO : check use timestamp
		$dateBegin->setTimestamp($paramFetcher->get("dateBegin"));
		$announcement->setDateBegin($dateBegin);
		$announcement->setCity($paramFetcher->get("city"));
		$announcement->setAddress($paramFetcher->get("address"));
		$announcement->setContactName($paramFetcher->get("contactName"));
		$announcement->setType($paramFetcher->get("type"));
		$announcement->setShipping($paramFetcher->get("shipping"));

		if(!is_null($timestampFinish = $paramFetcher->get("dateEnd"))){
			$dateFinish = new \DateTime();
			$dateFinish->setTimestamp($timestampFinish);
			$announcement->setDateEnd($dateFinish);
		}

		if(!is_null($contactPhone = $paramFetcher->get("contactPhone"))){
			$announcement->setContactPhone($contactPhone);
		}

		if(!is_null($contactEmail = $paramFetcher->get("contactEmail"))){
			$announcement->setContactEmail($contactEmail);
		}

		if(!is_null($minCollect = $paramFetcher->get("minCollect"))){
			$announcement->setMinCollect($minCollect);
		}

		if(!is_null($maxCollect = $paramFetcher->get("maxCollect"))){
			$announcement->setMaxCollect($maxCollect);
		}

		if(!is_null($stock = $paramFetcher->get("stock"))){
			$announcement->setStock($stock);
		}

		$em = $this->getDoctrine()->getManager();
		$em->persist($announcement);
		$em->flush();

			return new JsonResponse(null, 201);
		}

	/**
	 * Update an anouncement
	 *
	 * @param ParamFetcherInterface $paramFetcher Contain all body parameters received
	 * @return JsonResponse Return 204 and empty array if announcement was created OR 400 and error message JSON if error
	 *
	 * @ApiDoc(
	 *  section="Announcement",
	 *  description="Update an announcement",
	 *  resource = true,
	 *  statusCodes = {
	 *     204 = "Returned when successful",
	 *     400 = "Returned when required param is empty"
	 *   }
	 * )
	 * @FOSRest\RequestParam(name="description", nullable=false, description="Announcement description")
	 * @FOSRest\RequestParam(name="dateBegin", nullable=false, description="[Timestamp] Announcement start date")
	 * @FOSRest\RequestParam(name="dateEnd", nullable=true, description="[Timestamp] Announcement stop date")
	 * @FOSRest\RequestParam(name="city", nullable=false, description="Announcement city ")
	 * @FOSRest\RequestParam(name="address", nullable=false, description="Announcement address")
	 * @FOSRest\RequestParam(name="contactName", nullable=false, description="Announcement contact name")
	 * @FOSRest\RequestParam(name="contactEmail", nullable=true, requirements=@CoreBundle\Validator\Constraints\Email, description="Announcement contact email")
	 * @FOSRest\RequestParam(name="contactPhone", nullable=true, description="Announcement contact phone")
	 * @FOSRest\RequestParam(name="type", nullable=false, description="Announcement type : 'exchange', 'donate', 'collect'")
	 * @FOSRest\RequestParam(name="stock", nullable=true, description="Announcement quantity")
	 * @FOSRest\RequestParam(name="minCollect", nullable=true, requirements=@CoreBundle\Validator\Constraints\Number, description="Announcement minimum collect")
	 * @FOSRest\RequestParam(name="maxCollect", nullable=true, requirements=@CoreBundle\Validator\Constraints\Number, description="Announcement maximum collect")
	 * @FOSRest\RequestParam(name="shipping", nullable=false, requirements=@CoreBundle\Validator\Constraints\Boolean, description="Object can be shipped ?")
	 */
	public function patchAction(ParamFetcherInterface $paramFetcher, Announcement $announcement)
	{
		
		$announcement->setDescription($paramFetcher->get("description"));
		$dateBegin = new \DateTime();
		$dateBegin->setTimestamp($paramFetcher->get("dateBegin"));
		$announcement->setDateBegin($dateBegin);
		$announcement->setCity($paramFetcher->get("city"));
		$announcement->setAddress($paramFetcher->get("address"));
		$announcement->setContactName($paramFetcher->get("contactName"));
		$announcement->setType($paramFetcher->get("type"));
		$announcement->setShipping($paramFetcher->get("shipping"));

		if(!is_null($timestampFinish = $paramFetcher->get("dateEnd"))){
			$dateFinish = new \DateTime();
			$dateFinish->setTimestamp($timestampFinish);
			$announcement->setDateEnd($dateFinish);
		}

		if(!is_null($contactPhone = $paramFetcher->get("contactPhone"))){
			$announcement->setContactPhone($contactPhone);
		}

		if(!is_null($contactEmail = $paramFetcher->get("contactEmail"))){
			$announcement->setContactEmail($contactEmail);
		}

		if(!is_null($minCollect = $paramFetcher->get("minCollect"))){
			$announcement->setMinCollect($minCollect);
		}

		if(!is_null($maxCollect = $paramFetcher->get("maxCollect"))){
			$announcement->setMaxCollect($maxCollect);
		}

		if(!is_null($stock = $paramFetcher->get("stock"))){
			$announcement->setStock($stock);
		}

		$em = $this->getDoctrine()->getManager();
		$em->persist($announcement);
		$em->flush();

		return new JsonResponse(new \DateTime(), 204);
	}


	/**
	 * Get all announcements
	 *
	 * @return Announcement Empty Announcement array if no project founded
	 *
	 * @ApiDoc(
	 *  section="Announcement",
	 *  description="Get all announcement",
	 *  resource = true,
	 *  statusCodes = {
	 *     200 = "Returned when successful",
	 *   }
	 * )
	 **/
	public function cgetAction(){
		$annoncements = $this->getDoctrine()->getRepository('CoreBundle:Announcement')->findAll();
		return $annoncements;
	}

	/**
	 * Get an announcement
	 * @param Announcement $announcement
	 * @return JsonResponse Return 200 and Announcement array if announcement was founded OR 404 and error message JSON if error
	 *
	 * @ApiDoc(
	 *  section="Announcement",
	 *  description="Get an Announcement",
	 *  resource = true,
	 *  statusCodes = {
	 *     200 = "Returned when successful",
	 *     404 = "Returned when account is not found"
	 *   }
	 * )
	 * @ParamConverter("announcement", class="CoreBundle:Announcement")
	 *
	 * @Secure(roles="ROLE_ASSO")
	 */
	public function getAction(Announcement $announcement){
		return $announcement;
	}

	/**
	 * Create a receive
	 *
	 * @param ParamFetcherInterface $paramFetcher Contain all body parameters received
	 * @param Announcement              $Announce
	 *
	 * @return JsonResponse Return 201 if receive is created OR 400 and error message JSON if error
	 *
	 * @ApiDoc(
	 *  section="Announcement",
	 *  description="Create receive",
	 *  resource = true,
	 *  statusCodes = {
	 *     201 = "Returned when successful",
	 *   }
	 * )
	 *
	 * @FOSRest\RequestParam(name="quantity", nullable=false, requirements="\d+", description="Receive's quantity")
	 */
    public function postReceiveAction(ParamFetcherInterface $paramFetcher, Announcement $announce){
        $account = $this->getUser();
        $receive = new Receive();

        if (!$announce) {
            $resp = array("message" => "This announcement does not exist");
            return new JsonResponse($resp, 400);
        }
		$em = $this->getDoctrine()->getRepository("UserBundle:Association");

        $asso = $em->findOneByAccount($account);

        $em = $this->getDoctrine()->getRepository("CoreBundle:Receive");
        if($em->getById($asso, $announce)){
            $resp = array("message" => "You have already a request for this announce");
            return new JsonResponse($resp, 400);
        }

        $quantity = $paramFetcher->get('quantity');
        $receive->setAssociation($asso);
        $receive->setAnnouncement($announce);
        $receive->setQuantity($quantity);

        if($announce->getMinCollect() > $quantity){
        	$resp = array("message" => "The minimum amount is ".$announce->getMinCollect()." for this announce");
        	return new JsonResponse($resp, 400);
        }

        if($announce->getMaxCollect() < $quantity){
        	$resp = array("message" => "The maximum amount is ".$announce->getMaxCollect()." for this announce");
        	return new JsonResponse($resp, 400);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($receive);
        $em->flush();

        return new JsonResponse(null, 201);
    }

	/**
	 * Update a receive
	 *
	 * @param ParamFetcherInterface $paramFetcher Contain all body parameters received
	 * @param Announcement $Announce
	 * @param Receive $Receive
	 *
	 * @return JsonResponse Return 201 if receive is updated OR 401 for unauthorized OR 400 and error message JSON if error
	 *
	 * @ApiDoc(
	 *  section="Announcement",
	 *  description="Update receive",
	 *  resource = true,
	 *  statusCodes = {
	 *     201 = "Returned when successful",
	 *   }
	 * )
	 *
	 * @FOSRest\RequestParam(name="quantity", nullable=false, requirements="\d+", description="Receive's quantity")
	 * @FOSRest\RequestParam(name="message", nullable=true, description="Receive's message")
	 */
    public function patchReceiveAction(ParamFetcherInterface $paramFetcher, Announcement $announce, Receive $receive){
        $account = $this->getUser();

        if (!$announce) {
            $resp = array("message" => "This announcement does not exist");
            return new JsonResponse($resp, 400);
        }
        if (!$receive) {
            $resp = array("message" => "This receive does not exist");
            return new JsonResponse($resp, 400);
        }
        if($account != $receive->getAssociation()->getAccount()){
            $resp = array("message" => "You don't have the permission to update this receive");
            return new JsonResponse($resp, 401);
        }

        $quantity = $paramFetcher->get('quantity');
        $receive->setMessage($paramFetcher->get('message'));
        $receive->setQuantity($quantity);

        if($announce->getMinCollect() > $quantity){
        	$resp = array("message" => "The minimum amount is ".$announce->getMinCollect()." for this announce");
        	return new JsonResponse($resp, 400);
        }

        if($announce->getMaxCollect() < $quantity){
        	$resp = array("message" => "The maximum amount is ".$announce->getMaxCollect()." for this announce");
        	return new JsonResponse($resp, 400);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($receive);
        $em->flush();

        return new JsonResponse(null, 201);
    }

	/**
	 * Get a receive
	 *
	 * @param Announce $announce
	 * @param Receive $receive
	 *
	 * @return Receive Empty Receive array if no project founded
	 *
	 * @ApiDoc(
	 *  section="Announcement",
	 *  description="Get a receive for an announce",
	 *  resource = true,
	 *  statusCodes = {
	 *     200 = "Returned when successful",
	 *   }
	 * )
	 */
    public function getReceiveAction(Announcement $announce, Receive $receive){
        return $receive;
    }
}
