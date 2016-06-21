<?php

	/**
	 * Contain all generic routes
	 */
	namespace CoreBundle\Controller;

	use FOS\RestBundle\Controller\Annotations\Post;
	use FOS\RestBundle\Request\ParamFetcherInterface;
	use FOS\RestBundle\Routing\ClassResourceInterface;
	use Nelmio\ApiDocBundle\Annotation\ApiDoc;
	use Symfony\Bundle\FrameworkBundle\Controller\Controller;
	use Symfony\Component\HttpFoundation\JsonResponse;
	use FOS\RestBundle\Controller\Annotations as FOSRest;

	/**
	 * Class GenericController
	 *
	 * Contain all generic routes
	 *
	 * @package     CoreBundle\Controller
	 * @category    Controllers
	 * @author      Elias Cédric Laouiti <elias@laouiti.me>
	 *
	 */
	class GenericController extends Controller implements ClassResourceInterface
	{
		/**
		 * Send a message to the website administrator
		 *
		 * @param ParamFetcherInterface $paramFetcherInterface
		 *
		 * @return JsonResponse Return 200 and empty array if message was sent OR 400 and error message JSON if error
		 *
		 * @ApiDoc(
		 *  section="Generic",
		 *  description="Send an email to the website administrator",
		 *  resource = true,
		 *  statusCodes = {
		 *     201 = "Returned when successful",
		 *     400 = "Returned when an error occured"
		 *   }
		 * )
		 * @FOSRest\RequestParam(name="from", nullable=false, requirements=@CoreBundle\Validator\Constraints\Email,
		 *                                    description="Email of the person who complete the form")
		 * @FOSRest\RequestParam(name="subject", nullable=false, description="Subject")
		 * @FOSRest\RequestParam(name="message", nullable=false, description="Message")
		 * @Post("/contact")
		 */
		public function postContactAction(ParamFetcherInterface $paramFetcherInterface)
		{
			$message = \Swift_Message::newInstance()
				->setSubject('Formulaire de contact colab')
				->setFrom($this->getParameter('contact_email'))
				->setTo($this->getParameter('owner_email'))
				->setBody(
					$this->renderView(
						'CoreBundle:Emails:contact.html.twig',
						array(
							'fromEmail' => $paramFetcherInterface->get('from'),
							'subject'   => $paramFetcherInterface->get('subject'),
							'message'   => $paramFetcherInterface->get('message')
							)
					),
					'text/html'
				);
			$this->get('mailer')->send($message);

			return new JsonResponse(null, JsonResponse::HTTP_OK);
		}
	}
