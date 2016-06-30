<?php

namespace CoreBundle\Service;
use Symfony\Component\HttpFoundation\Response;
use UserBundle\Entity\Account;
use Doctrine\ORM\EntityManager;
use CoreBundle\Entity\Notification;
use CoreBundle\Entity\Tournament;
use CoreBundle\Entity\Battle;

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
    		$notification->setMessage("Votre inscription a été validé pour le tournoi");
    		$notification->setTournament($tournament);
    		$notification->setAccount($account);
    		$notification->setType(1);
            $notification->setIsSeen(false);
            $date = new \DateTime();
            $notification->setCreatedAt($date);
    		$this->em->persist($notification);
        	$this->em->flush();
		}
	}

    public function setNotificationBattleToAccount(Account $account, Battle $battle)
    {
        $notification = new Notification();
        $notification->setMessage("Votre prochain adverse est prêt.");
        $notification->setBattle($battle);
        $notification->setAccount($account);
        $notification->setType(2);
        $notification->setIsSeen(false);
        $date = new \DateTime();
        $notification->setCreatedAt($date);
        $this->em->persist($notification);
        $this->em->flush();
    }
}