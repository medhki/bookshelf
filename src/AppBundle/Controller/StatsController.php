<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Author;
use AppBundle\Entity\Book;
use AppBundle\Entity\LibraryBook;
use AppBundle\Entity\Review;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class StatsController extends Controller
{
    /**
     * @param int $limit
     */
    public function popularCategoriesAction(int $limit)
    {
        $repo = $this->getDoctrine()->getManager()->getRepository(Book::class);
        $poplarCategories = $repo->popularCategories($limit);
        return $this->render(':Stats:popularCategories.html.twig', array('poplarCategories' => $poplarCategories));
    }

    public function popularBooksAction(int $limit){
        $repo = $this->getDoctrine()->getManager()->getRepository(Book::class);
        $poplarBooks = $repo->popularBooks($limit);
        return $this->render(':Stats:popularBooks.html.twig', array('poplarBooks' => $poplarBooks));
    }

    public function latestReviewsAction(int $limit){
        $repo = $this->getDoctrine()->getManager()->getRepository(Review::class);
        $latestReview = $repo->latestReviews($limit);
    }

    public function lastAddedBooksAction(int $limit){
        $repo = $this->getDoctrine()->getManager()->getRepository(LibraryBook::class);
        $libraryBooks = $repo->lastAddedBooks($limit);
        return $this->render(':Stats:lastAddedBooks.html.twig' , array('lastAddedBooksByUsers' => $libraryBooks));
    }


    public function mostViewedBooksAction(int $limit){
        $repo = $this->getDoctrine()->getManager()->getRepository(Book::class);
        $books = $repo->popularBooks($limit);
        return $this->render(':Stats:mostViewedBooks.html.twig' , array('mostViewedBooks' => $books));
    }

    public function randomBooksAction(int $limit){
        $repo = $this->getDoctrine()->getManager()->getRepository(Book::class);
        $books = $repo->randomBooks($limit);
        return $this->render(':Stats:randomBooks.html.twig' , array('randomBooks' => $books));
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/books/list" , name="books_full_list")
     */
    public function bookFullListAction(Request $request){
        $letter = $request->query->get('letter');
        $repo = $this->getDoctrine()->getManager()->getRepository(Book::class);
        $books = $repo->booksList($letter);
        if(!$books) {
            $books = $repo->findAll();
        }
        return $this->render(':Books:booksFullList.htm.twig' , array('books' => $books));
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/authors/list" , name="authors_full_list")
     */
    public function authorsFullListAction(Request $request){
        $letter = $request->query->get('letter');
        $repo = $this->getDoctrine()->getManager()->getRepository(Author::class);
        $authors = $repo->authorsList($letter);
        if(!$authors) {
            $authors = $repo->findAll();
        }
        return $this->render(':Stats:authorsFullList.html.twig' , array('authors' => $authors));
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/categories/list" , name="categories_full_list")
     */
    public function categoriesFullListAction(Request $request){
        $letter = $request->query->get('letter');
        $repo = $this->getDoctrine()->getManager()->getRepository(Book::class);
        $categories = $repo->categoriesList($letter);
        if(!$categories) {
            $categories = $repo->findAll();
        }
        return $this->render(':Stats:categoriesFullList.html.twig' , array('categories' => $categories));
    }

    /**
     * @param $category
     * @Route("books/categories/{category}" , name="books_in_category")
     */
    public function booksInCategoryAction($category){
        $repo = $this->getDoctrine()->getManager()->getRepository(Book::class);
        $books = $repo->findBy(array('category' => $category));
        return $this->render(':Books:bookInCategory.html.twig', array('category' => $category , 'books' => $books));
    }

}
