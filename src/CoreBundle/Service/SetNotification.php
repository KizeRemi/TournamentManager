<?php

namespace CoreBundle\Service;
use Symfony\Component\HttpFoundation\Response;
use UserBundle\Entity\Account;
use Doctrine\ORM\EntityManager;
use CoreBundle\Entity\Notification;
use CoreBundle\Entity\Tournament;


class SetNotification
{
	private $em;

    public function __construct(EntityManager $entityManager)
    {
    	 $this->em = $entityManager;
    }

	public function setNotificationTournamentToAccount(Array $accounts, Tournament $tournament)
	{
		foreach ($accounts as $account) {
    		$notification = new Notification();
    		$notification->setMessage("Votre inscription a été validé pour le tournoi ".$tournament->getName());
    		$notification->setTournament($tournament);
    		$notification->setAccount($account);
    		$notification->setType(1);
    		$this->em->persist($notification);
        	$this->em->flush();
		}
	}
}