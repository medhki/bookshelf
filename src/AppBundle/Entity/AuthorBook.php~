<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AuthorBook
 *
 * @ORM\Table(name="author_book")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AuthorBookRepository")
 */
class AuthorBook
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Book")
     * @ORM\JoinColumn(nullable=false)
     */
    private $book;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Author")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

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
     * Set book.
     *
     * @param \AppBundle\Entity\Book $book
     *
     * @return AuthorBook
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
     * Set author.
     *
     * @param \AppBundle\Entity\Author $author
     *
     * @return AuthorBook
     */
    public function setAuthor(\AppBundle\Entity\Author $author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author.
     *
     * @return \AppBundle\Entity\Author
     */
    public function getAuthor()
    {
        return $this->author;
    }
}
