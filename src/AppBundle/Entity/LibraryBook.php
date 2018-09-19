<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LibraryBook
 *
 * @ORM\Table(name="library_book")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\LibraryBookRepository")
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
    private $nbrCopies;

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
}
