<?php

	namespace UserBundle\Event;
	use FOS\UserBundle\Model\UserInterface;
	use Symfony\Component\EventDispatcher\Event;
	use UserBundle\Entity\Account;


	/**
	 * Class RegistrationEvent
	 * @package UserBundle\Event
	 */
	class RegistrationEvent extends Event
	{
		const NAME = 'user.register_listener';
		
		/**
		 * @var Account
		 */
		protected $account;

		/**
		 * RegistrationEvent constructor.
		 *
		 * @param UserInterface $account
		 */
		public function __construct(UserInterface $account)
		{
			$this->account = $account;
		}

		/**
		 * @return Account
		 */
		public function getAccount()
		{
			return $this->account;
		}
	}