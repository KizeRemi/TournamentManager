<?php

namespace CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Announcement Entity
 *
 * Announcement definition. An announce allows a transaction between Charity association
 *
 * @package     CoreBundle\Controller
 * @category    classes
 * @author      Mavillaz Remi <remi.mavillaz@live.fr>
 * @author      Laouiti Elias <elias@laouiti.me>
 *
 * @ORM\Table(name="announcement")
 * @ORM\Entity(repositoryClass="CoreBundle\Repository\AnnouncementRepository")
 */
class Announcement
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=50)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_begin", type="datetime")
     */
    private $dateBegin;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_end", type="datetime", nullable=true)
     */
    private $dateEnd;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=50)
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=255)
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="contact_name", type="string", length=65)
     */
    private $contactName;

    /**
     * @var string
     *
     * @ORM\Column(name="contact_email", type="string", length=50, nullable=true)
     */
    private $contactEmail;

    /**
     * @var string
     *
     * @ORM\Column(name="contact_phone", type="string", length=15, nullable=true)
     */
    private $contactPhone;

    /**
     * @var bool
     *
     * @ORM\Column(name="visibility", type="boolean")
     */
    private $visibility;

    /**
     * @var string
     *
     * @ORM\Column(name="state", type="string", length=8, columnDefinition="enum('waiting','refused', 'open', 'done')")
     */
    private $state;
    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=8, columnDefinition="enum('exchange', 'donate', 'collect')")
     */
    private $type;

    /**
     * @var int
     *
     * @ORM\Column(name="stock", type="integer", nullable=true)
     */
    private $stock;

    /**
     * @var int
     *
     * @ORM\Column(name="min_collect", type="integer", nullable=true)
     */
    private $minCollect;

    /**
     * @var int
     *
     * @ORM\Column(name="max_collect", type="integer", nullable=true)
     */
    private $maxCollect;

    /**
     * @var bool
     *
     * @ORM\Column(name="shipping", type="boolean")
     */
    private $shipping;

    /**
    * @var \UserBundle\Entity\Account
    *
    * @ORM\ManyToOne(targetEntity="\UserBundle\Entity\Account")
    * @ORM\JoinColumn(name="account_id", referencedColumnName="id")
    */
    private $accountId;

    /**
     * @ORM\OneToMany(targetEntity="CoreBundle\Entity\Receive", mappedBy="announcement", cascade={"persist"})
     */
    private $announcementReceive;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->announcementReceive = new \Doctrine\Common\Collections\ArrayCollection();
        $this->visibility = 0;
        $this->state = 1;
    }

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
     * Set name
     *
     * @param string $name
     *
     * @return Announcement
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
     * Set description
     *
     * @param string $description
     *
     * @return Announcement
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

    /**
     * Set dateBegin
     *
     * @param \DateTime $dateBegin
     *
     * @return Announcement
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
     * Set dateEnd
     *
     * @param \DateTime $dateEnd
     *
     * @return Announcement
     */
    public function setDateEnd($dateEnd)
    {
        $this->dateEnd = $dateEnd;

        return $this;
    }

    /**
     * Get dateEnd
     *
     * @return \DateTime
     */
    public function getDateEnd()
    {
        return $this->dateEnd;
    }

    /**
     * Set city
     *
     * @param string $city
     *
     * @return Announcement
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set address
     *
     * @param string $address
     *
     * @return Announcement
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set contactName
     *
     * @param string $contactName
     *
     * @return Announcement
     */
    public function setContactName($contactName)
    {
        $this->contactName = $contactName;

        return $this;
    }

    /**
     * Get contactName
     *
     * @return string
     */
    public function getContactName()
    {
        return $this->contactName;
    }

    /**
     * Set contactEmail
     *
     * @param string $contactEmail
     *
     * @return Announcement
     */
    public function setContactEmail($contactEmail)
    {
        $this->contactEmail = $contactEmail;

        return $this;
    }

    /**
     * Get contactEmail
     *
     * @return string
     */
    public function getContactEmail()
    {
        return $this->contactEmail;
    }

    /**
     * Set contactPhone
     *
     * @param string $contactPhone
     *
     * @return Announcement
     */
    public function setContactPhone($contactPhone)
    {
        $this->contactPhone = $contactPhone;

        return $this;
    }

    /**
     * Get contactPhone
     *
     * @return string
     */
    public function getContactPhone()
    {
        return $this->contactPhone;
    }

    /**
     * Set visibility
     *
     * @param boolean $visibility
     *
     * @return Announcement
     */
    public function setVisibility($visibility)
    {
        $this->visibility = $visibility;

        return $this;
    }

    /**
     * Get visibility
     *
     * @return bool
     */
    public function getVisibility()
    {
        return $this->visibility;
    }

    /**
     * Set state
     *
     * @param string $state
     *
     * @return Announcement
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
     * Set stock
     *
     * @param integer $stock
     *
     * @return Announcement
     */
    public function setStock($stock)
    {
        $this->stock = $stock;

        return $this;
    }

    /**
     * Get stock
     *
     * @return int
     */
    public function getStock()
    {
        return $this->stock;
    }

    /**
     * Set minCollect
     *
     * @param integer $minCollect
     *
     * @return Announcement
     */
    public function setMinCollect($minCollect)
    {
        $this->minCollect = $minCollect;

        return $this;
    }

    /**
     * Get minCollect
     *
     * @return int
     */
    public function getMinCollect()
    {
        return $this->minCollect;
    }

    /**
     * Set maxCollect
     *
     * @param integer $maxCollect
     *
     * @return Announcement
     */
    public function setMaxCollect($maxCollect)
    {
        $this->maxCollect = $maxCollect;

        return $this;
    }

    /**
     * Get maxCollect
     *
     * @return int
     */
    public function getMaxCollect()
    {
        return $this->maxCollect;
    }

    /**
     * Set shipping
     *
     * @param boolean $shipping
     *
     * @return Announcement
     */
    public function setShipping($shipping)
    {
        $this->shipping = $shipping;

        return $this;
    }

    /**
     * Get shipping
     *
     * @return bool
     */
    public function getShipping()
    {
        return $this->shipping;
    }

    /**
     * Add announcementReceive
     *
     * @param \CoreBundle\Entity\Receive $announcementReceive
     *
     * @return Announcement
     */
    public function addAnnouncementReceive(\CoreBundle\Entity\Receive $announcementReceive)
    {
        $this->announcementReceive[] = $announcementReceive;

        return $this;
    }

    /**
     * Remove announcementReceive
     *
     * @param \CoreBundle\Entity\Receive $announcementReceive
     */
    public function removeAnnouncementReceive(\CoreBundle\Entity\Receive $announcementReceive)
    {
        $this->announcementReceive->removeElement($announcementReceive);
    }

    /**
     * Get announcementReceive
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAnnouncementReceive()
    {
        return $this->announcementReceive;
    }

    /**
     * Get announcementType
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set announcementType
     *
     * @param string $type
     * @return Announcement
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }


    /**
     * Set accountID
     *
     * @param \UserBundle\Entity\Account $accountId
     *
     * @return Announcement
     */
    public function setAccountId(\UserBundle\Entity\Account $accountId = null)
    {
        $this->accountId = $accountId;

        return $this;
    }

    /**
     * Get accountID
     *
     * @return \UserBundle\Entity\Account
     */
    public function getAccountId()
    {
        return $this->accountId;
    }
}
