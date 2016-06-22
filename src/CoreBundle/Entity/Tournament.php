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
 * Tournament Entity
 *
 * Tournament definition. Tournament details.
 *
 * @package     CoreBundle\Controller
 * @category    classes
 * @author      Mavillaz Remi <remi.mavillaz@live.fr>
 *
 * @ORM\Table(name="tournament")
 * @ORM\Entity(repositoryClass="UserBundle\Repository\TournamentRepository")
 * @ExclusionPolicy("all")
 *
 */

class Tournament
{	

    use TimestampableEntity;

	/**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="name",type="string", length=25, nullable=false)
     * @expose
     */
    protected $name;

    /**
     * @ORM\Column(name="game", type="string", length=60, nullable=false)
     * @expose
     */
    protected $game;

    /**
     * @ORM\Column(name="dateBegin",type="date", length=25, nullable=false)
     */
    protected $dateBegin;

    /**
     * @ORM\Column(name="duration_between_round",type="integer", length=25, nullable=false)
     */
    protected $durationBetweenRound;

    /**
     * @ORM\Column(name="player_max",type="integer", length=25, nullable=false)
     */
    protected $playerMax;

  /**
   * @ORM\ManyToMany(targetEntity="UserBundle\Entity\Account", cascade={"persist"})
   */

  private $accounts;

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
     * Set name
     *
     * @param string $name
     *
     * @return Tournament
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set game
     *
     * @param string $game
     *
     * @return Tournament
     */
    public function setGame($game)
    {
        $this->game = $game;

        return $this;
    }

    /**
     * Get game
     *
     * @return string
     */
    public function getGame()
    {
        return $this->game;
    }

    /**
     * Set dateBegin
     *
     * @param \DateTime $dateBegin
     *
     * @return Tournament
     */
    public function setDateBegin($dateBegin)
    {
        $this->dateBegin = $dateBegin;

        return $this;
    }

    /**
     * Get dateBegin
     *
     * @return \DateTime
     */
    public function getDateBegin()
    {
        return $this->dateBegin;
    }

    /**
     * Set durationBetweenRound
     *
     * @param \number $durationBetweenRound
     *
     * @return Tournament
     */
    public function setDurationBetweenRound(\number $durationBetweenRound)
    {
        $this->durationBetweenRound = $durationBetweenRound;

        return $this;
    }

    /**
     * Get durationBetweenRound
     *
     * @return \number
     */
    public function getDurationBetweenRound()
    {
        return $this->durationBetweenRound;
    }

    /**
     * Set playerMax
     *
     * @param \int $playerMax
     *
     * @return Tournament
     */
    public function setPlayerMax(\int $playerMax)
    {
        $this->playerMax = $playerMax;

        return $this;
    }

    /**
     * Get playerMax
     *
     * @return \int
     */
    public function getPlayerMax()
    {
        return $this->playerMax;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->accounts = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add account
     *
     * @param \UserBundle\Entity\Account $account
     *
     * @return Tournament
     */
    public function addAccount(\UserBundle\Entity\Account $account)
    {
        $this->accounts[] = $account;

        return $this;
    }

    /**
     * Remove account
     *
     * @param \UserBundle\Entity\Account $account
     */
    public function removeAccount(\UserBundle\Entity\Account $account)
    {
        $this->accounts->removeElement($account);
    }

    /**
     * Get accounts
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAccounts()
    {
        return $this->accounts;
    }
}
