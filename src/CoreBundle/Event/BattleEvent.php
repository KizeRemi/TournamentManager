<?php
namespace CoreBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use CoreBundle\Entity\Tournament;

class BattleEvent extends Event
{
    const NAME = 'tournament.battle_listener';
    /** @var string */
    protected $registers;
    protected $tournament;

    public function  __construct(Array $registers, Tournament $tournament)
    {
        $this->registers = $registers;
        $this->tournament = $tournament;
    }

    public function getRegisters()
    {
        return $this->registers;
    }
    public function getTournament()
    {
        return $this->tournament;
    }
}