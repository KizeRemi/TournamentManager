<?php

	/*
	 * This file is part of the FOSUserBundle package.
	 *
	 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
	 *
	 * For the full copyright and license information, please view the LICENSE
	 * file that was distributed with this source code.
	 */

	namespace UserBundle\Mailer;

	use FOS\UserBundle\Mailer\MailerInterface;
	use FOS\UserBundle\Model\UserInterface;
	use Symfony\Component\Routing\Generator\UrlGeneratorInterface;


	/**
	 * Class UserMailer
	 * @package FOS\UserBundle\Mailer
	 */
	class UserMailer implements MailerInterface
	{
		protected $mailer;
		protected $router;
		protected $twig;
		protected $parameters;

		/**
		 * UserMailer constructor.
		 *
		 * @param \Swift_Mailer         $mailer
		 * @param \Twig_Environment     $twig
		 * @param array                 $parameters
		 */
		public function __construct(\Swift_Mailer $mailer,  \Twig_Environment $twig, array $parameters)
		{
			$this->mailer = $mailer;
			$this->twig = $twig;
			$this->parameters = $parameters;
		}

		/**
		 * @param UserInterface $user
		 */
		public function sendConfirmationEmailMessage(UserInterface $user)
		{
			$template = $this->parameters['template']['confirmation'];
			$url = $this->parameters['urls']["base"].$this->parameters['urls']["endpoint_signup"]."/".$user->getConfirmationToken();

			$context = array(
				'user' => $user,
				'confirmationUrl' => $url
			);

			$this->sendMessage($template, $context, $this->parameters['contact_email'], $user->getEmail());
		}

		/**
		 * @param UserInterface $user
		 */
		public function sendResettingEmailMessage(UserInterface $user)
		{
			$template = $this->parameters['template']['resetting'];
			$url = $this->parameters['urls']["base"].$this->parameters['urls']["reset_password"]."/".$user->getConfirmationToken();

			$context = array(
				'user' => $user,
				'confirmationUrl' => $url
			);

			$this->sendMessage($template, $context, $this->parameters['contact_email'], $user->getEmail());
		}

		/**
		 * @param string $templateName
		 * @param array  $context
		 * @param string $fromEmail
		 * @param string $toEmail
		 */
		protected function sendMessage($templateName, $context, $fromEmail, $toEmail)
		{
			$context = $this->twig->mergeGlobals($context);
			$template = $this->twig->loadTemplate($templateName);
			$subject = $template->renderBlock('subject', $context);
			$textBody = $template->renderBlock('body_text', $context);
			$htmlBody = $template->renderBlock('body_html', $context);

			$message = \Swift_Message::newInstance()
				->setSubject($subject)
				->setFrom($fromEmail)
				->setTo($toEmail);

			if (!empty($htmlBody)) {
				$message->setBody($htmlBody, 'text/html')
					->addPart($textBody, 'text/plain');
			} else {
				$message->setBody($textBody);
			}

			$this->mailer->send($message);
		}
	}
