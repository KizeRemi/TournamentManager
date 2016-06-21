<?php
/**
 * Project entity
 */

namespace CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use UserBundle\Entity\Association;

/**
 * Project Entity
 *
 * Project definition. A project is a request for funds from a Charity association
 *
 * @package     CoreBundle\Controller
 * @category    classes
 * @author      Elias Cédric Laouiti <elias@laouiti.me>
 *
 * @ORM\Table (name = "project")
 * @ORM\Entity (repositoryClass = "CoreBundle\Repository\ProjectRepository")
 */
class Project
{
    /**
     * @var int Project ID
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string Project Name
     *
     * @ORM\Column(name="name", type="string", length=50)
     */
    private $name;

    /**
     * @var string Project description
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var date Project publication
     *
     * @ORM\Column(name="date_publication",type="date", length=25, nullable=false)
     */
    private $date_publication;

    /**
     * @var bool Project Visibility
     *
     * @ORM\Column(name="visibility", type="boolean")
     */
    private $visibility;

    /**
     * @var string Project state
     *
     * @ORM\Column(name="state", type="string", length=15, columnDefinition="enum('waiting validation','refused', 'open', 'done')")
     */
    private $state;

    /**
     * @var string Project banner image
     *
     * @ORM\Column(name="banner", type="string", nullable=true)
     */
    private $banner;

    /**
    * @var Association Association who has post the project
    *
    * @ORM\ManyToOne(targetEntity="\UserBundle\Entity\Association")
    * @ORM\JoinColumn(name="association_id", referencedColumnName="id")
    */
    private $association;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     * @ORM\OneToMany(targetEntity="CoreBundle\Entity\Promise", mappedBy="project", cascade={"persist"})
     */
    private $projectPromise;
    
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
     * @return Project
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
     * @return Project
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
     * Set visibility
     *
     * @param boolean $visibility
     *
     * @return Project
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
     * @return Project
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
     * Set banner
     *
     * @param binary $banner
     *
     * @return Project
     */
    public function setBanner($banner)
    {
        $this->banner = $banner;

        return $this;
    }

    /**
     * Get banner
     *
     * @return binary
     */
    public function getBanner()
    {
        return $this->banner;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->projectPromise = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set association
     *
     * @param \UserBundle\Entity\Association $association
     *
     * @return Project
     */
    public function setAssociation(\UserBundle\Entity\Association $association = null)
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
     * Add projectPromise
     *
     * @param \CoreBundle\Entity\Promise $projectPromise
     *
     * @return Project
     */
    public function addProjectPromise(\CoreBundle\Entity\Promise $projectPromise)
    {
        $this->projectPromise[] = $projectPromise;

        return $this;
    }

    /**
     * Remove projectPromise
     *
     * @param \CoreBundle\Entity\Promise $projectPromise
     */
    public function removeProjectPromise(\CoreBundle\Entity\Promise $projectPromise)
    {
        $this->projectPromise->removeElement($projectPromise);
    }

    /**
     * Get projectPromise
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProjectPromise()
    {
        return $this->projectPromise;
    }

    /**
     * Set datePublication
     *
     * @param \DateTime $datePublication
     *
     * @return Project
     */
    public function setDatePublication($datePublication)
    {
        $this->date_publication = $datePublication;

        return $this;
    }

    /**
     * Get datePublication
     *
     * @return \DateTime
     */
    public function getDatePublication()
    {
        return $this->date_publication;
    }
}
