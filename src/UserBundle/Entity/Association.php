<?php
/**
 * Entity account
 */
namespace UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 * Association
 *
 * @ORM\Table(name="association")
 * @ORM\Entity(repositoryClass="UserBundle\Repository\AssociationRepository")
 * @UniqueEntity(
 *     fields={"name"},
 *     message="constraints.unique",
 * )
 * @UniqueEntity(
 *     fields={"code"},
 *     message="constraints.unique",
 * )
 *
 * @ExclusionPolicy("all")
 */

class Association{

	/**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="code",type="string", length=25, nullable=true, unique=true)
     * @Expose
     */
    protected $code;

    /**
     * @ORM\Column(name="name",type="string", length=25, nullable=false, unique=true)
     * @Expose
     */
    protected $name;

    /**
     * @Gedmo\Slug(fields={"name"}, updatable=false)
     * @ORM\Column(length=255, unique=true)
     * @Expose
     */
    private $slug;

    /**
     * @ORM\Column(name="description",type="string", length=25, nullable=true)
     * @Expose
     */
    protected $description;

    /**
     * @ORM\Column(name="leader_name",type="string", length=25, nullable=true, unique=true)
     * @Expose
     */
    protected $leader_name;

    /**
     * @ORM\Column(name="leader_phone",type="string", length=25, nullable=true)
     * @Expose
     */
    protected $leader_phone;

    /**
     * @ORM\Column(name="leader_email",type="string", length=25, nullable=true)
     * @Expose
     */
    protected $leader_email;

    /**
     * @ORM\Column(name="validation",type="string", length=25, nullable=true)
     * @Expose
     */
    protected $validation;
    
    /**
     * @ORM\Column(name="files",type="string", nullable=true)
     * @Expose
     */
    protected $files;

    /**
    * @ORM\ManyToOne(targetEntity="Account")
    * @ORM\JoinColumn(name="account_id", referencedColumnName="id")
    * @Expose
    */
    protected $account;

    /**
     * @ORM\OneToMany(targetEntity="CoreBundle\Entity\Receive", mappedBy="association", cascade={"persist"})
     */
    private $announcementReceive;

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
     * Set code
     *
     * @param string $code
     *
     * @return Association
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Association
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
     * Set slug
     *
     * @param string $slug
     *
     * @return Association
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Association
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
     * Set leaderName
     *
     * @param string $leaderName
     *
     * @return Association
     */
    public function setLeaderName($leaderName)
    {
        $this->leader_name = $leaderName;

        return $this;
    }

    /**
     * Get leaderName
     *
     * @return string
     */
    public function getLeaderName()
    {
        return $this->leader_name;
    }

    /**
     * Set leaderPhone
     *
     * @param string $leaderPhone
     *
     * @return Association
     */
    public function setLeaderPhone($leaderPhone)
    {
        $this->leader_phone = $leaderPhone;

        return $this;
    }

    /**
     * Get leaderPhone
     *
     * @return string
     */
    public function getLeaderPhone()
    {
        return $this->leader_phone;
    }

    /**
     * Set leaderEmail
     *
     * @param string $leaderEmail
     *
     * @return Association
     */
    public function setLeaderEmail($leaderEmail)
    {
        $this->leader_email = $leaderEmail;

        return $this;
    }

    /**
     * Get leaderEmail
     *
     * @return string
     */
    public function getLeaderEmail()
    {
        return $this->leader_email;
    }

    /**
     * Set validation
     *
     * @param string $validation
     *
     * @return Association
     */
    public function setValidation($validation)
    {
        $this->validation = $validation;

        return $this;
    }

    /**
     * Get validation
     *
     * @return string
     */
    public function getValidation()
    {
        return $this->validation;
    }

    /**
     * Set account
     *
     * @param \UserBundle\Entity\Account $account
     *
     * @return Association
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
     * Constructor
     */
    public function __construct()
    {
        $this->announcementReceive = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add announcementReceive
     *
     * @param \CoreBundle\Entity\Receive $announcementReceive
     *
     * @return Association
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
     * Set files
     *
     * @param string $files
     *
     * @return Association
     */
    public function setFiles($files)
    {
        $this->files = $files;

        return $this;
    }

    /**
     * Get files
     *
     * @return string
     */
    public function getFiles()
    {
        return $this->files;
    }
}
