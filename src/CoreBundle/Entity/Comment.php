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
 * Comment Entity
 *
 * Comment definition. Comment details.
 *
 * @package     CoreBundle\Controller
 * @category    classes
 * @author      Mavillaz Remi <remi.mavillaz@live.fr>
 *
 * @ORM\Table(name="comment")
 * @ORM\Entity(repositoryClass="CoreBundle\Repository\CommentRepository")
 * @ExclusionPolicy("all")
 *
 */

class Comment
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
    * @ORM\ManyToOne(targetEntity="UserBundle\Entity\Account")
    * @ORM\JoinColumn(name="account", referencedColumnName="id")
    * @expose
    */
    protected $account;

    /**
    * @ORM\ManyToOne(targetEntity="UserBundle\Entity\Account")
    * @ORM\JoinColumn(name="sendBy", referencedColumnName="id")
    * @expose
    */
    protected $sendBy;

    /**
     * @ORM\Column(name="message",type="text", length=255, nullable=false)
     * @expose
     */
    protected $message;

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
     * @return Comment
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
     * Set account
     *
     * @param \UserBundle\Entity\Account $account
     *
     * @return Comment
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
     * Set sendBy
     *
     * @param \UserBundle\Entity\Account $sendBy
     *
     * @return Comment
     */
    public function setSendBy(\UserBundle\Entity\Account $sendBy = null)
    {
        $this->sendBy = $sendBy;

        return $this;
    }

    /**
     * Get sendBy
     *
     * @return \UserBundle\Entity\Account
     */
    public function getSendBy()
    {
        return $this->sendBy;
    }
}
