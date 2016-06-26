<?php
namespace CoreBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use CoreBundle\Event\BattleEvent;
use Doctrine\ORM\EntityManager;
use CoreBundle\Entity\Battle;

class BattleListener implements EventSubscriberInterface
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
           BattleEvent::NAME => 'initialize'
        );
    }

    public function initialize(BattleEvent $event)
    {
        $registers = $event->getRegisters();
        $tournament = $event->getTournament();
        shuffle($registers);
        $j = 1;
        for($i=0;$i<$tournament->getPlayerMax();$i++){
            if($i%2 == 0){
            $battle = new Battle();
            $battle->setPlayerOne($registers[$i]);
            $battle->setPlayerTwo($registers[$i+1]);
            $battle->setReadyPlayerOne(false);
            $battle->setReadyPlayerTwo(false); 
            $battle->setNumber($j);
            $battle->setround($tournament->getPlayerMax()/2);
            $battle->setTournament($tournament);  
            $this->em->persist($battle);     
            $this->em->flush($battle);
            $j++;
            }

        }
    }
}