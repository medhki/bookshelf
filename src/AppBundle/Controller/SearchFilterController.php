<?php

namespace AppBundle\Controller;

use AppBundle\Form\SearchFilterType;
use AppBundle\Service\GoogleBooksApiLinkGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SearchFilterController extends Controller
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/search" , name="book_search_filter")
     */
    public function searchBookAction(Request $request)
    {
        $form = $this->createForm(SearchFilterType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $linkGenerator= new GoogleBooksApiLinkGenerator();
            $link = $linkGenerator->ApiLink($form->getData());
            if ($link){
                $response = file_get_contents("https://www.googleapis.com/books/v1/volumes?q=$link");

                $data = json_decode($response,true);

                $items=$data['items']?? [];
                if ($items) {
                    return $this->render('@App/Book/bookSearchResults.html.twig', array('items' => $items));
                }
                $this->addFlash('error','pas de resultat');

            }

        }

        return $this->render('@App/Search/searchFilter.html.twig', array(
            'searchFilterForm' => $form->createView()
        ));
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("add/{id}" , name="add_to_my_library")
     */
    public function addToMyLibraryAction($id, Request $request)
    {

        $user = $this->getUser();
        dump($user); die();

        $response = file_get_contents("https://www.googleapis.com/books/v1/volumes?q=id:$id");

        $data = json_decode($response,true);

        $items=$data['items']?? [];
        if (!$items) {
            $this->addFlash('error','id livre errone');
        }
        dump($items);
        die();
        return $this->render('', array());
    }
}
