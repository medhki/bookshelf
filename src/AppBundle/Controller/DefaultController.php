<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Book;
use AppBundle\Entity\LibraryBook;
use AppBundle\Entity\User;
use AppBundle\Form\SearchFilterType;
use AppBundle\Service\DatabaseBookSearch;
use AppBundle\Service\GoogleBooksSearcher;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    private $databaseSearch;
    private $booksSearcher;


    /**
     * DefaultController constructor.
     * @param $databaseSearch
     */
    public function __construct(DatabaseBookSearch $databaseSearch , GoogleBooksSearcher $booksSearcher)
    {
        $this->databaseSearch = $databaseSearch;
        $this->booksSearcher = $booksSearcher;

    }

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('accueil.html.twig');
    }

    /**
     * @Route("/home", name="accueil")
     */
    public function accueilAction()
    {

        return $this->render('accueil.html.twig');
    }


    /**
     * @Route("/browse", name="browse")
     */
    public function browseAction()
    {
        return $this->render('browse.html.twig');
    }

    /**
     * @Route("/market", name="decouvrir")
     */
    public function decouvrirAction(Request $request)
    {
        $searched = $request->query->get('q');
        if ($searched) {
            $books = $this->databaseSearch->simpleSearchDatabase($searched);
        } else {
            $books = [];
        }
        return $this->render('decouvrir.html.twig', array(
            'books' => $books,
            'searched' => $searched
        ));
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/constructor" , name="library_constructor")
     */
    public function apiSearchBookAction(Request $request)
    {
        $items = [];
        $data =  $request->query->get('app_bundle_search_filter_type');
        $form = $this->createForm(SearchFilterType::class);
        if ($data) {
            // the GoogleBooksSearcher generates the results from the google books api as an array
            $items = $this->booksSearcher->apiSearchResult(array_slice($data, 0, 4));
            if (!$items) {
                $this->addFlash('error', 'pas de resultat');
            }
        }
        return $this->render('constructLibrary.html.twig', array(
            'items' => $items,
            'searchFilterForm' => $form->createView()
        ));

    }
    /**
     * @Route ("/bridgeMeslivre",name="")
     */

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/library/{id}" , name="user_library", defaults={"id" = 0})
     */
    public function userLibraryBooksAction($id)
    {
        if (!$this->getUser()){
            return $this->redirectToRoute('fos_user_security_login');
        }
        $userBooks = [];
        if ($id == 0) {
            $user = $this->getUser();
        } else {
            $repository = $this->getDoctrine()->getManager()->getRepository(User::class);
            $user = $repository->find($id);
        }
        if ($user != null) {
            $userLibrary = $user->getLibrary();
            $repository = $this->getDoctrine()->getManager()->getRepository(LibraryBook::class);
            $userBooks = $repository->findBy(array('library' => $userLibrary));
        } else {
            return $this->redirectToRoute('user_library');
        }
        return $this->render('userLibrary.html.twig', array(
            'user' => $user,
            'userBooks' => $userBooks
        ));

    }
}
