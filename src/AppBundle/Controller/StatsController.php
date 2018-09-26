<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Book;
use AppBundle\Entity\Review;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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

    public function latestReviewsAction(){
        $repo = $this->getDoctrine()->getManager()->getRepository(Review::class);
        $latestReview = $repo->latestReviews(3);
    }


}
