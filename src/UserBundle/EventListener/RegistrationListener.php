<?php

	/*
	 * This file is part of the FOSUserBundle package.
	 *
	 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
	 *
	 * For the full copyright and license information, please view the LICENSE
	 * file that was distributed with this source code.
	 */

	namespace UserBundle\EventListener;

	use FOS\UserBundle\Mailer\MailerInterface;
	use FOS\UserBundle\Util\TokenGeneratorInterface;
	use Symfony\Component\EventDispatcher\EventSubscriberInterface;
	use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
	use UserBundle\Event\RegistrationEvent;

	/**
	 * Class RegistrationListener
	 * @package UserBundle\EventListener
	 */
	class RegistrationListener implements EventSubscriberInterface
	{
		private $mailer;
		private $tokenGenerator;

		/**
		 * RegistrationListener constructor.
		 *
		 * @param MailerInterface         $mailer
		 * @param TokenGeneratorInterface $tokenGenerator
		 */
		public function __construct(MailerInterface $mailer, TokenGeneratorInterface $tokenGenerator)
		{
			$this->mailer = $mailer;
			$this->tokenGenerator = $tokenGenerator;
		}

		/**
		 * @return array
		 */
		public static function getSubscribedEvents()
		{
			return array(
				RegistrationEvent::NAME => 'registrationSuccess',
			);
		}

		/**
		 * @param RegistrationEvent $event
		 */
		public function registrationSuccess(RegistrationEvent $event)
		{
			/** @var $account \FOS\UserBundle\Model\UserInterface */
			$account = $event->getAccount();

			$account->setEnabled(false);

			if (null === $account->getConfirmationToken()) {
				$account->setConfirmationToken($this->tokenGenerator->generateToken());
			}

			$this->mailer->sendConfirmationEmailMessage($account);
		}
	}
