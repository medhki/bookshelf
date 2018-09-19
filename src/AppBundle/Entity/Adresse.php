<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Adresse
 *
 * @ORM\Table(name="adresse")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AdresseRepository")
 */
class Adresse
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
     * @var int
     *
     * @ORM\Column(name="codePostal", type="integer")
     */
    private $codePostal;

    /**
     * @var string
     *
     * @ORM\Column(name="ville", type="string", length=255)
     */
    private $ville;

    /**
     * @var string
     *
     * @ORM\Column(name="governorat", type="string", length=255)
     */
    private $governorat;

    /**
     * @var string
     *
     * @ORM\Column(name="shortAdresse", type="string", length=255)
     */
    private $shortAdresse;


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
     * Set codePostal
     *
     * @param integer $codePostal
     *
     * @return Adresse
     */
    public function setCodePostal($codePostal)
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    /**
     * Get codePostal
     *
     * @return int
     */
    public function getCodePostal()
    {
        return $this->codePostal;
    }

    /**
     * Set ville
     *
     * @param string $ville
     *
     * @return Adresse
     */
    public function setVille($ville)
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * Get ville
     *
     * @return string
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * Set governorat
     *
     * @param string $governorat
     *
     * @return Adresse
     */
    public function setGovernorat($governorat)
    {
        $this->governorat = $governorat;

        return $this;
    }

    /**
     * Get governorat
     *
     * @return string
     */
    public function getGovernorat()
    {
        return $this->governorat;
    }

    /**
     * Set shortAdresse
     *
     * @param string $shortAdresse
     *
     * @return Adresse
     */
    public function setShortAdresse($shortAdresse)
    {
        $this->shortAdresse = $shortAdresse;

        return $this;
    }

    /**
     * Get shortAdresse
     *
     * @return string
     */
    public function getShortAdresse()
    {
        return $this->shortAdresse;
    }
}
