<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Book;
use AppBundle\Form\SearchFilterType;
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
    public function advancedSearchInDatabaseAction(Request $request)
    {
        $form = $this->createForm(SearchFilterType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $results = $this->databaseFilter->simpleSearchDatabase();
        }
        dump($results);die;
        // rendering results
    }

    public function simpleSearchInDatabaseAction(Request $request)
    {
        $form = $this->createForm(SearchFilterType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $results = $this->databaseFilter->simpleSearchDatabase();
        }
        dump($results);die;
        // rendering results
    }




}
