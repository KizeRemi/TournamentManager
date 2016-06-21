<?php

namespace CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Promise Entity
 *
 * Promise definition. A promise is a donation from an account for a project
 *
 * @package     CoreBundle\Controller
 * @category    classes
 * @author      Mavillaz Remi <remi.mavillaz@live.fr>
 * @author      Laouiti Elias <elias@laouiti.me>
 *
 * @ORM\Table(name="Promise")
 * @ORM\Entity(repositoryClass="CoreBundle\Repository\PromiseRepository")
 */
class Promise
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
     * @var float
     *
     * @ORM\Column(name="amount", type="float")
     */
    private $amount;

    /**
     * @var bool
     *
     * @ORM\Column(name="user_hidden", type="boolean")
     */
    private $userHidden;

    /** 
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\Account", inversedBy="projectPromise") 
     * @ORM\JoinColumn(name="account_id", referencedColumnName="id", nullable=false) 
     */
    protected $account;

    /** 
     * @ORM\ManyToOne(targetEntity="Project", inversedBy="projectPromise") 
     * @ORM\JoinColumn(name="project_id", referencedColumnName="id", nullable=false) 
     */
    protected $project;


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
     * Set amount
     *
     * @param float $amount
     *
     * @return promise
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set userHidden
     *
     * @param boolean $userHidden
     *
     * @return promise
     */
    public function setUserHidden($userHidden)
    {
        $this->userHidden = $userHidden;

        return $this;
    }

    /**
     * Get userHidden
     *
     * @return bool
     */
    public function getUserHidden()
    {
        return $this->userHidden;
    }

    /**
     * Set account
     *
     * @param \UserBundle\Entity\Account $account
     *
     * @return Promise
     */
    public function setAccount(\UserBundle\Entity\Account $account)
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
     * Set project
     *
     * @param \CoreBundle\Entity\Project $project
     *
     * @return Promise
     */
    public function setProject(\CoreBundle\Entity\Project $project)
    {
        $this->project = $project;

        return $this;
    }

    /**
     * Get project
     *
     * @return \CoreBundle\Entity\Project
     */
    public function getProject()
    {
        return $this->project;
    }
}
