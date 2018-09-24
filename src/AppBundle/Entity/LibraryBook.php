<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LibraryBook
 *
 * @ORM\Table(name="library_book")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\LibraryBookRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class LibraryBook
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
     * @ORM\Column(name="nbrCopies", type="integer")
     */
    private $nbrCopies=1;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Book")
     * @ORM\JoinColumn(nullable=false)
     */
    private $book;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Library")
     * @ORM\JoinColumn(nullable=false)
     */
    private $library;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_ajout", type="datetime")
     */
    private $dateAjout;

    /**
     * @var int
     * @ORM\Column(name="rating", type="integer" , nullable= true)
     */
    private $rating ;

    /**
     * @var bool
     * @ORM\Column(name="read_statut", type="boolean" )
     */
    private $readStatut = false;

    /**
     * @var bool
     * @ORM\Column(name="exchange", type="boolean" )
     */
    private $exchange = true;

    /**
     * @var bool
     * @ORM\Column(name="sell", type="boolean" )
     */
    private $sell = false;

    /**
     * @var bool
     * @ORM\Column(name="giveaway", type="boolean" )
     */
    private $giveaway = false;

    /**
     * @var float
     * @ORM\Column(name="price" , type="float" , nullable=true)
     */
    private $price;

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nbrCopies.
     *
     * @param int $nbrCopies
     *
     * @return LibraryBook
     */
    public function setNbrCopies($nbrCopies)
    {
        $this->nbrCopies = $nbrCopies;

        return $this;
    }

    /**
     * Get nbrCopies.
     *
     * @return int
     */
    public function getNbrCopies()
    {
        return $this->nbrCopies;
    }

    /**
     * Set book.
     *
     * @param \AppBundle\Entity\Book $book
     *
     * @return LibraryBook
     */
    public function setBook(\AppBundle\Entity\Book $book)
    {
        $this->book = $book;

        return $this;
    }

    /**
     * Get book.
     *
     * @return \AppBundle\Entity\Book
     */
    public function getBook()
    {
        return $this->book;
    }

    /**
     * Set library.
     *
     * @param \AppBundle\Entity\Library $library
     *
     * @return LibraryBook
     */
    public function setLibrary(\AppBundle\Entity\Library $library)
    {
        $this->library = $library;

        return $this;
    }

    /**
     * Get library.
     *
     * @return \AppBundle\Entity\Library
     */
    public function getLibrary()
    {
        return $this->library;
    }

    /**
     * @ORM\PrePersist
     */
    public function inLibraryCountPlus(){
        $this->book->setInLibraryCount($this->book->getInLibraryCount()+1);
    }

    /**
     * @ORM\PreRemove()
     */
    public function inLibraryCountMinus(){
        $this->book->setInLibraryCount($this->book->getInLibraryCount()-1);
    }



    /**
     * Set rating
     *
     * @param integer $rating
     *
     * @return LibraryBook
     */
    public function setRating($rating)
    {
        $this->rating = $rating;

        return $this;
    }

    /**
     * Get rating
     *
     * @return integer
     */
    public function getRating()
    {
        return $this->rating;
    }



    /**
     * Set dateAjout
     *
     * @return LibraryBook
     *
     * @ORM\PrePersist()
     */
    public function setDateAjout()
    {
        $this->dateAjout = new \Datetime();;

        return $this;
    }

    /**
     * Get dateAjout
     *
     * @return \DateTime
     */
    public function getDateAjout()
    {
        return $this->dateAjout;
    }



    /**
     * Set readStatut
     *
     * @param boolean $readStatut
     *
     * @return LibraryBook
     */
    public function setReadStatut($readStatut)
    {
        $this->readStatut = $readStatut;

        return $this;
    }

    /**
     * Get readStatut
     *
     * @return boolean
     */
    public function getReadStatut()
    {
        return $this->readStatut;
    }

    /**
     * Set exchange
     *
     * @param boolean $exchange
     *
     * @return LibraryBook
     */
    public function setExchange($exchange)
    {
        $this->exchange = $exchange;

        return $this;
    }

    /**
     * Get exchange
     *
     * @return boolean
     */
    public function getExchange()
    {
        return $this->exchange;
    }

    /**
     * Set price
     *
     * @param float $price
     *
     * @return LibraryBook
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set sell
     *
     * @param boolean $sell
     *
     * @return LibraryBook
     */
    public function setSell($sell)
    {
        $this->sell = $sell;

        return $this;
    }

    /**
     * Get sell
     *
     * @return boolean
     */
    public function getSell()
    {
        return $this->sell;
    }

    /**
     * Set giveaway
     *
     * @param boolean $giveaway
     *
     * @return LibraryBook
     */
    public function setGiveaway($giveaway)
    {
        $this->giveaway = $giveaway;

        return $this;
    }

    /**
     * Get giveaway
     *
     * @return boolean
     */
    public function getGiveaway()
    {
        return $this->giveaway;
    }
}
