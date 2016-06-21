<?php
namespace UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 * Account Entity
 *
 * Account definition. Account details for an user or association.
 *
 * @package     CoreBundle\Controller
 * @category    classes
 * @author      Mavillaz Remi <remi.mavillaz@live.fr>
 * @author      Laouiti Elias <elias@laouiti.me>
 *
 * @ORM\Table(name="account")
 * @ORM\Entity(repositoryClass="UserBundle\Repository\AccountRepository")
 * @ExclusionPolicy("all")
 *
 * @UniqueEntity(
 *     fields={"username"},
 *     message="constraints.unique",
 * )
 * @UniqueEntity(
 *     fields={"email"},
 *     message="constraints.unique",
 * )
 */

// TODO : nullable = false et verifier champ validation
class Account extends BaseUser

{	const ROLE_SUPER_ADMIN = "ROLE_ADMIN";
	const ROLE_DEFAULT = "ROLE_DEFAULT";
	const ROLE_USER = "ROLE_USER";
	const ROLE_ASSO = "ROLE_ASSO";

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
     * @ORM\Column(name="address", type="string", length=60, nullable=true)
     * @expose
     */
    protected $address;

    /**
     * @ORM\Column(name="city",type="string", length=25, nullable=true)
     * @expose
     */
    protected $city;

    /**
     * @ORM\Column(name="country",type="string", length=25, nullable=true)
     * @expose
     */
    protected $country;

    /**
     * @ORM\Column(name="region",type="boolean", nullable=true)
     * @expose
     */
    protected $region;


    /**
     * @ORM\Column(name="phone", type="string", nullable=true)
     * @expose
     */
    protected $phone;

    /**
     * @ORM\Column(name="img", type="string", length=255, nullable=true)
     * @expose
     */
    protected $img;

    /**
     * @ORM\OneToMany(targetEntity="CoreBundle\Entity\Promise", mappedBy="account", cascade={"persist"})
     */
    protected $projectPromise;

    /**
     * Add projectPromise
     *
     * @param \CoreBundle\Entity\Promise $projectPromise
     *
     * @return Account
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
     * Account constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->roles = array(static::ROLE_DEFAULT);
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
     * Set address
     *
     * @param string $address
     *
     * @return Account
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
     * Set city
     *
     * @param string $city
     *
     * @return Account
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
     * Set country
     *
     * @param string $country
     *
     * @return Account
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set region
     *
     * @param boolean $region
     *
     * @return Account
     */
    public function setRegion($region)
    {
        $this->region = $region;

        return $this;
    }

    /**
     * Get region
     *
     * @return boolean
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return Account
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set img
     *
     * @param string $img
     *
     * @return Account
     */
    public function setImg($img)
    {
        $this->img = $img;

        return $this;
    }

    /**
     * Get img
     *
     * @return string
     */
    public function getImg()
    {
        return $this->img;
    }

	/**
	 * Set Email
	 * @param string $email
	 *
	 * @return $this|static
	 */
	public function setEmail($email)
    {
        $this->setUsername($email);
        return parent::setEmail($email);
    }

}
