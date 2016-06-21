<?php

namespace CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Receive Entity
 *
 * Receive definition. Transaction details between association and an announcement.
 *
 * @package     CoreBundle\Controller
 * @category    classes
 * @author      Mavillaz Remi <remi.mavillaz@live.fr>
 * @author      Laouiti Elias <elias@laouiti.me>
 *
 * @ORM\Table(name="receive")
 * @ORM\Entity(repositoryClass="CoreBundle\Repository\ReceiveRepository")
 */
class Receive
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="quantity", type="integer")
     */
    private $quantity;

    /**
     * @var string
     *
     * @ORM\Column(name="message", type="text", nullable=true)
     */
    private $message;

    /** 
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\Association", inversedBy="announcementReceive") 
     * @ORM\JoinColumn(name="association_id", referencedColumnName="id", nullable=false) 
     */
    protected $association;

    /** 
     * @ORM\ManyToOne(targetEntity="Announcement", inversedBy="announcementReceive") 
     * @ORM\JoinColumn(name="announcement_id", referencedColumnName="id", nullable=false) 
     */
    protected $announcement;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set quantity
     *
     * @param integer $quantity
     *
     * @return Receive
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set association
     *
     * @param \UserBundle\Entity\Association $association
     *
     * @return Receive
     */
    public function setAssociation(\UserBundle\Entity\Association $association)
    {
        $this->association = $association;

        return $this;
    }

    /**
     * Get association
     *
     * @return \UserBundle\Entity\Association
     */
    public function getAssociation()
    {
        return $this->association;
    }

    /**
     * Set announcement
     *
     * @param \CoreBundle\Entity\Announcement $announcement
     *
     * @return Receive
     */
    public function setAnnouncement(\CoreBundle\Entity\Announcement $announcement)
    {
        $this->announcement = $announcement;

        return $this;
    }

    /**
     * Get announcement
     *
     * @return \CoreBundle\Entity\Announcement
     */
    public function getAnnouncement()
    {
        return $this->announcement;
    }

    /**
     * Set message
     *
     * @param string $message
     *
     * @return Receive
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
}
