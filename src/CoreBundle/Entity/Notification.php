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
 * Notification Entity
 *
 * Notification definition. Comment details.
 *
 * @package     CoreBundle\Controller
 * @category    classes
 * @author      Mavillaz Remi <remi.mavillaz@live.fr>
 *
 * @ORM\Table(name="notification")
 * @ORM\Entity(repositoryClass="CoreBundle\Repository\NotificationRepository")
 * @ExclusionPolicy("all")
 *
 */

class Notification
{	

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
    * @ORM\ManyToOne(targetEntity="UserBundle\Entity\Account")
    * @ORM\JoinColumn(name="account", referencedColumnName="id")
    * @expose
    */
    protected $account;

    /**
     * @ORM\Column(name="message",type="text", length=255, nullable=false)
     * @expose
     */
    protected $message;

    /**
     * @ORM\Column(name="type",type="string", length=255, nullable=false)
     * @expose
     */
    protected $type;
    /**
     * @ORM\ManyToOne(targetEntity="CoreBundle\Entity\Tournament", cascade={"persist"})
     * @ORM\JoinColumn(name="tournament_id", referencedColumnName="id", nullable=true)
     * @expose
     */
    private $tournament;

    /**
     * @ORM\ManyToOne(targetEntity="CoreBundle\Entity\Battle", cascade={"persist"})
     * @ORM\JoinColumn(name="battle_id", referencedColumnName="id", nullable=true)
     * @expose
     */
    private $battle;

    /**
     * @ORM\Column(name="seen",type="boolean", length=255, nullable=false)
     * @expose
     */
    private $isSeen;

    /**
     * @ORM\Column(name="created_at",type="datetime", length=25, nullable=false)
     * @expose
     */
    private $createdAt;

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
     * Set message
     *
     * @param string $message
     *
     * @return Notification
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Notification
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set account
     *
     * @param \UserBundle\Entity\Account $account
     *
     * @return Notification
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
     * Set tournament
     *
     * @param \CoreBundle\Entity\Tournament $tournament
     *
     * @return Notification
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
     * Set battle
     *
     * @param \CoreBundle\Entity\Battle $battle
     *
     * @return Notification
     */
    public function setBattle(\CoreBundle\Entity\Battle $battle = null)
    {
        $this->battle = $battle;

        return $this;
    }

    /**
     * Get battle
     *
     * @return \CoreBundle\Entity\Battle
     */
    public function getBattle()
    {
        return $this->battle;
    }

    /**
     * Set isSeen
     *
     * @param boolean $isSeen
     *
     * @return Notification
     */
    public function setIsSeen($isSeen)
    {
        $this->isSeen = $isSeen;

        return $this;
    }

    /**
     * Get isSeen
     *
     * @return boolean
     */
    public function getIsSeen()
    {
        return $this->isSeen;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Notification
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
}
