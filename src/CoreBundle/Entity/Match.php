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
 * Match Entity
 *
 * Match definition. Match details.
 *
 * @package     CoreBundle\Controller
 * @category    classes
 * @author      Mavillaz Remi <remi.mavillaz@live.fr>
 *
 * @ORM\Table(name="match")
 * @ORM\Entity(repositoryClass="UserBundle\Repository\MatchRepository")
 * @ExclusionPolicy("all")
 *
 */

class Match
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
     * @ORM\OneToOne(targetEntity="UserBundle\Entity\Account", cascade={"persist"})
     */
    private $playerOne;

    /**
     * @ORM\OneToOne(targetEntity="UserBundle\Entity\Account", cascade={"persist"})
     */
    private $playerTwo;

    /**
     * @var bool Match playerOne ready
     *
     * @ORM\Column(name="ready_player_one", type="boolean")
     */
    private $readyPlayerOne;

    /**
     * @var bool Match playerTwo ready
     *
     * @ORM\Column(name="ready_player_two", type="boolean")
     */
    private $readyPlayerTwo;

    /**
     * @var bool Match playerOne result
     *
     * @ORM\Column(name="result_player_one", type="boolean")
     */
    private $resultPlayerOne;

    /**
     * @var bool Match playerOne result
     *
     * @ORM\Column(name="result_player_two", type="boolean")
     */
    private $resultPlayerTwo;

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
     * Set playerOne
     *
     * @param \UserBundle\Entity\Account $playerOne
     *
     * @return Match
     */
    public function setPlayerOne(\UserBundle\Entity\Account $playerOne = null)
    {
        $this->playerOne = $playerOne;

        return $this;
    }

    /**
     * Get playerOne
     *
     * @return \UserBundle\Entity\Account
     */
    public function getPlayerOne()
    {
        return $this->playerOne;
    }

    /**
     * Set playerTwo
     *
     * @param \UserBundle\Entity\Account $playerTwo
     *
     * @return Match
     */
    public function setPlayerTwo(\UserBundle\Entity\Account $playerTwo = null)
    {
        $this->playerTwo = $playerTwo;

        return $this;
    }

    /**
     * Get playerTwo
     *
     * @return \UserBundle\Entity\Account
     */
    public function getPlayerTwo()
    {
        return $this->playerTwo;
    }

    /**
     * Set readyPlayerOne
     *
     * @param boolean $readyPlayerOne
     *
     * @return Match
     */
    public function setReadyPlayerOne($readyPlayerOne)
    {
        $this->readyPlayerOne = $readyPlayerOne;

        return $this;
    }

    /**
     * Get readyPlayerOne
     *
     * @return boolean
     */
    public function getReadyPlayerOne()
    {
        return $this->readyPlayerOne;
    }

    /**
     * Set readyPlayerTwo
     *
     * @param boolean $readyPlayerTwo
     *
     * @return Match
     */
    public function setReadyPlayerTwo($readyPlayerTwo)
    {
        $this->readyPlayerTwo = $readyPlayerTwo;

        return $this;
    }

    /**
     * Get readyPlayerTwo
     *
     * @return boolean
     */
    public function getReadyPlayerTwo()
    {
        return $this->readyPlayerTwo;
    }

    /**
     * Set resultPlayerOne
     *
     * @param boolean $resultPlayerOne
     *
     * @return Match
     */
    public function setResultPlayerOne($resultPlayerOne)
    {
        $this->resultPlayerOne = $resultPlayerOne;

        return $this;
    }

    /**
     * Get resultPlayerOne
     *
     * @return boolean
     */
    public function getResultPlayerOne()
    {
        return $this->resultPlayerOne;
    }

    /**
     * Set resultPlayerTwo
     *
     * @param boolean $resultPlayerTwo
     *
     * @return Match
     */
    public function setResultPlayerTwo($resultPlayerTwo)
    {
        $this->resultPlayerTwo = $resultPlayerTwo;

        return $this;
    }

    /**
     * Get resultPlayerTwo
     *
     * @return boolean
     */
    public function getResultPlayerTwo()
    {
        return $this->resultPlayerTwo;
    }
}
