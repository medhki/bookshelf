<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Book;
use AppBundle\Service\DatabaseBookSearch;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class databaseSearchController extends Controller
{
    private $databaseFilter;

    /**
     * databaseSearchController constructor.
     * @param $databaseFilter
     */
    public function __construct(DatabaseBookSearch $databaseFilter)
    {
        $this->databaseFilter = $databaseFilter;
    }

    /**
     * @Route("/owned/{searched}")
     */
    public function searchInDatabaseAction($searched ,Request $request)
    {
        $results = $this->databaseFilter->simpleSearchDatabase($searched);
        dump($results);die;
        // rendering results
    }


    public function popularCategoriesAction()
    {
        $repo = $this->getDoctrine()->getManager()->getRepository(Book::class);
        $poplarCategories = $repo->popularCategories(3);
        // rendering results
    }

}
