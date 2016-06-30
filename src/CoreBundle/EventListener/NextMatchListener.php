<?php
namespace CoreBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use CoreBundle\Event\NextMatchEvent;
use Doctrine\ORM\EntityManager;
use CoreBundle\Entity\Battle;
use CoreBundle\Service\SetNotification;

class NextMatchListener implements EventSubscriberInterface
{
	private $em;
    private $un;
    public function __construct(EntityManager $entityManager, SetNotification $setNotification)
    {
    	 $this->em = $entityManager;
         $this->un = $setNotification;
    }

    public static function getSubscribedEvents()
    {
        // Liste des évènements écoutés et méthodes à appeler
        return array(
           NextMatchEvent::NAME => 'create'
        );
    }

    public function create(NextMatchEvent $event)
    {
        if($event->getBattleTwo()->getWinner() != null && $event->getBattleOne()->getWinner() != null){
            $tournament = $event->getBattleTwo()->getTournament();
            $round = $event->getBattleTwo()->getRound()+1;
            $number = $event->getBattleTwo()->getNumber()/2;
            $battle = $this->em->getRepository('CoreBundle:Battle')->getByNumberAndTournament($number, $tournament, $round);
            $battle->setPlayerOne($event->getBattleOne()->getWinner());
            $battle->setPlayerTwo($event->getBattleTwo()->getWinner());
            $battle->setReadyPlayerOne(false);
            $battle->setReadyPlayerTwo(false); 
            $this->em->persist($battle);     
            $this->em->flush($battle);
            $this->un->setNotificationBattleToAccount($event->getBattleOne()->getWinner(), $battle);
            $this->un->setNotificationBattleToAccount($event->getBattleTwo()->getWinner(), $battle);
        }

    }
}
