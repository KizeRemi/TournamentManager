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

	use Symfony\Component\EventDispatcher\EventSubscriberInterface;
	use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
	use UserBundle\Event\ResetPasswordEvent;

	/**
	 * Class ResetListener
	 * @package FOS\UserBundle\EventListener
	 */
	class ResetPasswordListener implements EventSubscriberInterface
	{
		/**
		 * ResetPasswordListener constructor.
		 */
		public function __construct()
		{
		}
		
		/**
		 * @return array
		 */
		public static function getSubscribedEvents()
		{
			return array(
				ResetPasswordEvent::NAME => 'resetToken',
			);
		}

		/**
		 * @param ResetPasswordEvent $event
		 */
		public function resetToken(ResetPasswordEvent $event)
		{
			/** @var $account \FOS\UserBundle\Model\UserInterface */
			$account = $event->getAccount();
			$account->setConfirmationToken(null);
			$account->setPasswordRequestedAt(null);
			$account->setEnabled(true);
			
			
			
		}
	}
