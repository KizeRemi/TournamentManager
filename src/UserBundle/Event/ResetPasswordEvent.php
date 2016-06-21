<?php

namespace UserBundle\Event;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\EventDispatcher\Event;
use UserBundle\Entity\Account;


/**
 * Class ResetPasswordEvent
 * @package UserBundle\Event
 */
class ResetPasswordEvent extends Event
{
	const NAME = 'user.resetPassword';
	/**
	 * @var Account
	 */
	protected $account;

	/**
	 * ResetPasswordEvent constructor.
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