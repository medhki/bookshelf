<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity
 * @ORM\Table(name="`user`")
 * @ORM\HasLifecycleCallbacks()
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @var bool
     * @ORM\Column(name="deleted", name="deleted", type="boolean" , nullable=true)
     */
    private $deleted = false;

    /**
     * @var
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Library", cascade={"persist" , "remove"})
     */
    private $library;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message="Please enter your phone number.", groups={"Registration", "Profile"})
     * @Assert\Length(
     *     min=7,
     *     max=25,
     *     minMessage="The phone number is too short.",
     *     maxMessage="The phone number is too long.",
     *     groups={"Registration", "Profile"})
     */
    protected $phoneNumber;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Please enter your prenom.", groups={"Registration", "Profile"})
     * @Assert\Length(
     *     min=3,
     *     max=55,
     *     minMessage="The prenom is too short.",
     *     maxMessage="The prenom is too long.",
     *     groups={"Registration", "Profile"}
     * )
     */
    protected $prenom;

    /**
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Adresse")
     */
    private $adresse;


    public function getId()
    {
        return $this->id;
    }


    /**
     * Set library
     * @param \AppBundle\Entity\Library $library
     * @ORM\PrePersist
     * @return User
     */
    public function setLibrary()
    {
        $this->library = new Library();
        $this->library->setDesignation($this->getUsername());
        return $this;
    }

    /**
     * Get library
     *
     * @return \AppBundle\Entity\Library
     */
    public function getLibrary()
    {
        return $this->library;
    }

    /**
     * Set adresse
     *
     * @param \AppBundle\Entity\Adresse $adresse
     *
     * @return User
     */
    public function setAdresse(\AppBundle\Entity\Adresse $adresse = null)
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * Get adresse
     *
     * @return \AppBundle\Entity\Adresse
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * Set deleted
     *
     * @param boolean $deleted
     *
     * @return User
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;

        return $this;
    }

    /**
     * Get deleted
     *
     * @return boolean
     */
    public function getDeleted()
    {
        return $this->deleted;
    }

    /**
     * Set phoneNumber
     *
     * @param string $phoneNumber
     *
     * @return User
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * Get phoneNumber
     *
     * @return string
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * Set prenom
     *
     * @param string $prenom
     *
     * @return User
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }
}
