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
 * @ORM\Entity(repositoryClass="CoreBundle\Repository\TournamentRepository")
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
     * @ORM\Column(name="date_begin",type="datetime", length=25, nullable=false)
     * @expose
     */
    protected $dateBegin;

    /**
     * @ORM\Column(name="duration_between_round",type="integer", length=25, nullable=false)
     * @expose
     */
    protected $durationBetweenRound;

    /**
     * @ORM\Column(name="player_max",type="integer", length=25, nullable=false)
     * @expose
     */
    protected $playerMax;

    /**
     * @ORM\Column(name="description",type="text", nullable=true)
     * @expose
     */
    protected $description;

    /**
     * @var string Tournament state
     *
     * @ORM\Column(name="state", type="string", length=15, columnDefinition="enum('Ouvert','Complet', 'En cours', 'Terminé')")
     * @expose
     */
    private $state;

    /**
     * @ORM\ManyToMany(targetEntity="UserBundle\Entity\Account", cascade={"persist"})
     * @expose
     */
    private $accounts;

    /**
    * @ORM\ManyToOne(targetEntity="UserBundle\Entity\Account")
    * @ORM\JoinColumn(name="account_id", referencedColumnName="id")
    * @expose
    */
    protected $account;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->accounts = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * @param integer $durationBetweenRound
     *
     * @return Tournament
     */
    public function setDurationBetweenRound($durationBetweenRound)
    {
        $this->durationBetweenRound = $durationBetweenRound;

        return $this;
    }

    /**
     * Get durationBetweenRound
     *
     * @return integer
     */
    public function getDurationBetweenRound()
    {
        return $this->durationBetweenRound;
    }

    /**
     * Set playerMax
     *
     * @param integer $playerMax
     *
     * @return Tournament
     */
    public function setPlayerMax($playerMax)
    {
        $this->playerMax = $playerMax;

        return $this;
    }

    /**
     * Get playerMax
     *
     * @return integer
     */
    public function getPlayerMax()
    {
        return $this->playerMax;
    }

    /**
     * Set state
     *
     * @param string $state
     *
     * @return Tournament
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return string
     */
    public function getState()
    {
        return $this->state;
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

    /**
     * Set account
     *
     * @param \UserBundle\Entity\Account $account
     *
     * @return Tournament
     */
    public function setAccount(\UserBundle\Entity\Account $account = null)
    {
        $this->account = $account;

        return $this;
    }

    /**
     * Get account
     *
     * @return \UserBundle\Entity\Account
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Tournament
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
}
