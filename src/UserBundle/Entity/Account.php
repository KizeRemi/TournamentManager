<?php
namespace UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Account Entity
 *
 * Account definition. Account details for an user or association.
 *
 * @package     CoreBundle\Controller
 * @category    classes
 * @author      Mavillaz Remi <remi.mavillaz@live.fr>
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
 * @UniqueEntity(
 *     fields={"nickname"},
 *     message="constraints.unique",
 * )
 */

// TODO : nullable = false et verifier champ validation
class Account extends BaseUser

{	const ROLE_SUPER_ADMIN = "ROLE_ADMIN";
	const ROLE_USER = "ROLE_USER";
	const ROLE_ORGA = "ROLE_ORGA";

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
     * @ORM\Column(name="nickname",type="string", length=25, nullable=true)
     * @expose
     */
    protected $nickname;

    /**
     * @ORM\Column(name="address", type="string", length=60, nullable=true)
     * @expose
     */
    protected $address;

    /**
     * @ORM\Column(name="name",type="string", length=25, nullable=true)
     * @expose
     */
    protected $name;

    /**
     * @ORM\Column(name="lastname",type="string", length=25, nullable=true)
     * @expose
     */
    protected $lastname;

    /**
     * @Gedmo\Slug(fields={"name", "lastname"}, updatable=true)
     * @ORM\Column(length=255, unique=true)
     */
    private $slug;

    /**
     * @ORM\Column(name="birth_date",type="date", length=25, nullable=true)
     * @expose
     */
    protected $birth_date;
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
     * @ORM\Column(name="region",type="string", nullable=true)
     * @expose
     */
    protected $region;

    /**
     * @ORM\Column(name="img", type="string", length=255, nullable=true)
     * @expose
     */

    protected $img;
    /**
     * @ORM\Column(name="banner", type="string", length=255, nullable=true)
     * @expose
     */
    protected $banner;

    /**
    * @ORM\OneToMany(targetEntity="CoreBundle\Entity\Tournament", mappedBy="Accounts", cascade={"remove", "persist"})
    */
    protected $tournaments;

    /**
     * Account constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->roles = array(static::ROLE_USER);
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


    /**
     * Set nickname
     *
     * @param string $nickname
     *
     * @return Account
     */
    public function setNickname($nickname)
    {
        $this->nickname = $nickname;

        return $this;
    }

    /**
     * Get nickname
     *
     * @return string
     */
    public function getNickname()
    {
        return $this->nickname;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Account
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
     * Set lastname
     *
     * @param string $lastname
     *
     * @return Account
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Account
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
     * Set birthDate
     *
     * @param \DateTime $birthDate
     *
     * @return Account
     */
    public function setBirthDate($birthDate)
    {
        $this->birth_date = $birthDate;

        return $this;
    }

    /**
     * Get birthDate
     *
     * @return \DateTime
     */
    public function getBirthDate()
    {
        return $this->birth_date;
    }

    /**
     * Set banner
     *
     * @param string $banner
     *
     * @return Account
     */
    public function setBanner($banner)
    {
        $this->banner = $banner;

        return $this;
    }

    /**
     * Get banner
     *
     * @return string
     */
    public function getBanner()
    {
        return $this->banner;
    }

    /**
     * Add tournament
     *
     * @param \CoreBundle\Entity\Tournament $tournament
     *
     * @return Account
     */
    public function addTournament(\CoreBundle\Entity\Tournament $tournament)
    {
        $this->tournaments[] = $tournament;

        return $this;
    }

    /**
     * Remove tournament
     *
     * @param \CoreBundle\Entity\Tournament $tournament
     */
    public function removeTournament(\CoreBundle\Entity\Tournament $tournament)
    {
        $this->tournaments->removeElement($tournament);
    }

    /**
     * Get tournaments
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTournaments()
    {
        return $this->tournaments;
    }
}
