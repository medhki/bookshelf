<?php
/**
 * Created by PhpStorm.
 * User: moham
 * Date: 18/09/2018
 * Time: 11:23
 */

namespace AppBundle\Service;


use AppBundle\Entity\Author;
use AppBundle\Entity\AuthorBook;
use AppBundle\Entity\Book;
use AppBundle\Entity\Library;
use AppBundle\Entity\LibraryBook;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class DatabaseBookSearch
{
    private $em;

    /**
     * DatabaseBookSearch constructor.
     * @param $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }


    public function simpleSearchDatabase($searched){

        $bookRepo = $this->em->getRepository(Book::class);
        $authorRepo = $this->em->getRepository(Author::class);

        $booksFound = $bookRepo->simpleSearch($searched);
        $authors = $authorRepo->simpleSearch($searched);
        $booksOfAuthorsFound = [];
        foreach ($authors as $author){
            $authorListOfBooks = $bookRepo->authorListOfBooks($author);
            $booksOfAuthorsFound = array_merge($booksOfAuthorsFound , $authorListOfBooks);
        }
        return array_merge($booksOfAuthorsFound , $booksFound);
    }
}