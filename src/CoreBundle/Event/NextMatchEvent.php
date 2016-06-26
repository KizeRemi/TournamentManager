<?php
namespace CoreBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use CoreBundle\Entity\Battle;

class NextMatchEvent extends Event
{
    const NAME = 'tournament.nextmatch_listener';

    protected $battleOne;
    protected $battleTwo;

    public function  __construct(Battle $battleOne, Battle $battleTwo)
    {
        $this->battleOne = $battleOne;
        $this->battleTwo = $battleTwo;
    }

    public function getBattleOne()
    {
        return $this->battleOne;
    }
    public function getBattleTwo()
    {
        return $this->battleTwo;
    }
}