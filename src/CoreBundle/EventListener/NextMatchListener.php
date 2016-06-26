<?php
namespace CoreBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use CoreBundle\Event\NextMatchEvent;
use Doctrine\ORM\EntityManager;
use CoreBundle\Entity\Battle;

class NextMatchListener implements EventSubscriberInterface
{
	private $em;

    public function __construct(EntityManager $entityManager)
    {
    	 $this->em = $entityManager;
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
            $battle = new Battle();
            $battle->setPlayerOne($event->getBattleOne()->getWinner());
            $battle->setPlayerTwo($event->getBattleTwo()->getWinner());
            $battle->setReadyPlayerOne(false);
            $battle->setReadyPlayerTwo(false); 
            $battle->setNumber($event->getBattleTwo()->getNumber()/2);
            $battle->setRound($event->getBattleTwo()->getRound()/2);
            $battle->setTournament($event->getBattleTwo()->getTournament());  
            $this->em->persist($battle);     
            $this->em->flush($battle);
        }
    }
}
