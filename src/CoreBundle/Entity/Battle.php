<?php
namespace CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Battle Entity
 *
 * Battle definition. Match details.
 *
 * @package     CoreBundle\Controller
 * @category    classes
 * @author      Mavillaz Remi <remi.mavillaz@live.fr>
 *
 * @ORM\Table(name="battle")
 * @ORM\Entity(repositoryClass="CoreBundle\Repository\BattleRepository")
 * @ExclusionPolicy("all")
 *
 */

class Battle
{	

    use TimestampableEntity;

	/**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @expose
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\Account", cascade={"persist"})
     * @ORM\JoinColumn(name="player_one_id", referencedColumnName="id")
     * @expose
     */
    private $playerOne;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\Account", cascade={"persist"})
     * @ORM\JoinColumn(name="player_two_id", referencedColumnName="id")
     * @expose
     */
    private $playerTwo;

    /**
     * @var bool Match playerOne ready
     *
     * @ORM\Column(name="ready_player_one", type="boolean")
     * @expose
     */
    private $readyPlayerOne;

    /**
     * @var bool Match playerTwo ready
     *
     * @ORM\Column(name="ready_player_two", type="boolean")
     * @expose
     */
    private $readyPlayerTwo;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\Account", cascade={"persist"})
     * @ORM\JoinColumn(name="winner_id", referencedColumnName="id")
     * @expose
     */
    private $winner;

    /**
     * @ORM\ManyToOne(targetEntity="CoreBundle\Entity\Tournament", cascade={"persist"})
     * @ORM\JoinColumn(name="tournament_id", referencedColumnName="id")
     */
    private $tournament;

    /**
     * @ORM\Column(name="number",type="integer", length=25, nullable=false)
     * @expose
     */
    protected $number;

    /**
     * @ORM\Column(name="round",type="integer", length=25, nullable=false)
     * @expose
     */
    protected $round;
    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set readyPlayerOne
     *
     * @param boolean $readyPlayerOne
     *
     * @return Battle
     */
    public function setReadyPlayerOne($readyPlayerOne)
    {
        $this->readyPlayerOne = $readyPlayerOne;

        return $this;
    }

    /**
     * Get readyPlayerOne
     *
     * @return boolean
     */
    public function getReadyPlayerOne()
    {
        return $this->readyPlayerOne;
    }

    /**
     * Set readyPlayerTwo
     *
     * @param boolean $readyPlayerTwo
     *
     * @return Battle
     */
    public function setReadyPlayerTwo($readyPlayerTwo)
    {
        $this->readyPlayerTwo = $readyPlayerTwo;

        return $this;
    }

    /**
     * Get readyPlayerTwo
     *
     * @return boolean
     */
    public function getReadyPlayerTwo()
    {
        return $this->readyPlayerTwo;
    }

    /**
     * Set playerOne
     *
     * @param \UserBundle\Entity\Account $playerOne
     *
     * @return Battle
     */
    public function setPlayerOne(\UserBundle\Entity\Account $playerOne = null)
    {
        $this->playerOne = $playerOne;

        return $this;
    }

    /**
     * Get playerOne
     *
     * @return \UserBundle\Entity\Account
     */
    public function getPlayerOne()
    {
        return $this->playerOne;
    }

    /**
     * Set playerTwo
     *
     * @param \UserBundle\Entity\Account $playerTwo
     *
     * @return Battle
     */
    public function setPlayerTwo(\UserBundle\Entity\Account $playerTwo = null)
    {
        $this->playerTwo = $playerTwo;

        return $this;
    }

    /**
     * Get playerTwo
     *
     * @return \UserBundle\Entity\Account
     */
    public function getPlayerTwo()
    {
        return $this->playerTwo;
    }

    /**
     * Set tournament
     *
     * @param \CoreBundle\Entity\Tournament $tournament
     *
     * @return Battle
     */
    public function setTournament(\CoreBundle\Entity\Tournament $tournament = null)
    {
        $this->tournament = $tournament;

        return $this;
    }

    /**
     * Get tournament
     *
     * @return \CoreBundle\Entity\Tournament
     */
    public function getTournament()
    {
        return $this->tournament;
    }

    /**
     * Set winner
     *
     * @param \UserBundle\Entity\Account $winner
     *
     * @return Battle
     */
    public function setWinner(\UserBundle\Entity\Account $winner = null)
    {
        $this->winner = $winner;

        return $this;
    }

    /**
     * Get winner
     *
     * @return \UserBundle\Entity\Account
     */
    public function getWinner()
    {
        return $this->winner;
    }

    /**
     * Set number
     *
     * @param integer $number
     *
     * @return Battle
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number
     *
     * @return integer
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set round
     *
     * @param integer $round
     *
     * @return Battle
     */
    public function setRound($round)
    {
        $this->round = $round;

        return $this;
    }

    /**
     * Get round
     *
     * @return integer
     */
    public function getRound()
    {
        return $this->round;
    }
}
