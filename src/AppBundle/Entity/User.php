<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

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
     * @var
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Library", cascade={"persist" , "remove"})
     */
    private $library;

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
        $this->library->setDesignation('biliotheque de '.$this->getUsername());

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
}
