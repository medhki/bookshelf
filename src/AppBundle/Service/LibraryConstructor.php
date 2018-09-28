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

class LibraryConstructor
{
    private $em;

    private $user;

    private $booksSearcher;

    /**
     * LibraryConstructor constructor.
     * @param $em
     * @param $user
     */
    public function __construct(EntityManagerInterface $em , TokenStorageInterface $tokenStorage, GoogleBooksSearcher $booksSearcher)
    {
        $this->em = $em;
        $this->user = $tokenStorage->getToken()->getUser();
        $this->booksSearcher = $booksSearcher;
    }


    public function checkBookInDatabase($apiId){
        $repository = $this->em->getRepository(Book::class);
        $book = $repository->findOneBy(array('apiId'=>$apiId));
        return $book;
    }

    public function checkBookInLibrary($apiId){
        $book=$this->checkBookInDatabase($apiId);

        if (!$book){
            return null;
        }
        $library = $this->user->getLibrary();
        $repository = $this->em->getRepository(LibraryBook::class);
        $libraryBook= $repository->findOneBy(array('book'=>$book , 'library' => $library));

        return $libraryBook;
    }

    public function addBookToDatabase($apiId){
        $book = $this->checkBookInDatabase($apiId);
        if (!$book){
            $items = $this->booksSearcher->apiSearchResult(array('id'=>$apiId));
            if (!$items) {
                return null;
            }
            $book = new Book();

            $book->setTitre($items[0]['volumeInfo']['title']  ?? null);
            $book->setAnneePublication(\DateTime::createFromFormat('Ymd', str_pad(str_replace('-','',$items[0]['volumeInfo']['publishedDate']),8,'01')) ?? null);
            $book->setLanguage($items[0]['volumeInfo']['language'] ?? null);
            $book->setPageCount($items[0]['volumeInfo']['pageCount'] ?? null);
            $book->setSearchInfo($items[0]['searchInfo']['textSnippet'] ?? null);
            $book->setApiId($items[0]['id'] ?? null);
            $book->setDescription($items[0]['volumeInfo']['description'] ?? null);
            $book->setCategory($items[0]['volumeInfo']['categories'][0] ?? null);
            $book->setThumbnail($items[0]['volumeInfo']['imageLinks']['thumbnail'] ?? null);
            $book->setRating($items[0]['volumeInfo']['averageRating'] ?? null);
            $book->setRatingCount($items[0]['volumeInfo']['ratingsCount'] ?? null);
            $book->setIsbn($items[0]['volumeInfo']['industryIdentifiers'][0]['identifier'] ?? null);
            $authors=$items[0]['volumeInfo']['authors'] ?? null;
            if ($authors){
                $tabAuthor = [];
                $tabAuthorBook = [];
                foreach ($authors as $key => $author){
                    $authorExist = $this->em->getRepository(Author::class)->findOneBy(array('nom' => $author));
                    $tabAuthorBook[$key] = new AuthorBook();
                    if ($authorExist){
                        $tabAuthorBook[$key]->setAuthor($authorExist)->setBook($book);
                    }else{
                        $tabAuthor[$key] = new Author();
                        $tabAuthor[$key]->setNom($author);
                        $tabAuthorBook[$key]->setAuthor($tabAuthor[$key])->setBook($book);
                        $this->em->persist($tabAuthor[$key]);
                    }
                    $this->em->persist($tabAuthorBook[$key]);
                }
            }
            $this->em->persist($book);
            $this->em->flush();
        }
        return $book;
    }

    public function addBookToLibrary($apiId){
        $libraryBook = $this->checkBookInLibrary($apiId);
        if (!$libraryBook){
            $book= $this->addBookToDatabase($apiId);
            if (!$book){
                return 0;
            }
            $library = $this->user->getLibrary();
            $newLibraryBook = new LibraryBook();
            $newLibraryBook->setBook($book);
            $newLibraryBook->setLibrary($library);
            $this->em->persist($newLibraryBook);
            $this->em->flush();
            return 1;
        }
        return 2;
    }

}