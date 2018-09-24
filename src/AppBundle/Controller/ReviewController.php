<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Review;
use AppBundle\Form\ReviewType;
use Proxies\__CG__\AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Book;
use AppBundle\Entity\LibraryBook;
use AppBundle\Form\SearchFilterType;
use AppBundle\Service\GoogleBooksSearcher;
use AppBundle\Service\LibraryConstructor;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ReviewController extends Controller
{
    /**
     * @param Book $book
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route(name="book_reviews_list")
     */
    public function bookReviewsListAction(Book $book, Request $request){
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository(Review::class);
        $reviews = $repository->bookReviewsList($book , $user);
        return $this->render('@App/Review/reviewsList.html.twig', array(
            'reviews' => $reviews
        ));
    }
}
