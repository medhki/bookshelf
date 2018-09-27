<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Book;
use AppBundle\Entity\LibraryBook;
use AppBundle\Entity\User;
use AppBundle\Form\SearchFilterType;
use AppBundle\Service\GoogleBooksSearcher;
use AppBundle\Service\LibraryConstructor;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class LibraryController extends Controller
{

    private $libraryConstructor;
    private $booksSearcher;

    /**
     * LibraryController constructor.
     * @param $libraryConstructor
     */
    public function __construct(LibraryConstructor $libraryConstructor , GoogleBooksSearcher $booksSearcher)
    {
        $this->libraryConstructor = $libraryConstructor;
        $this->booksSearcher = $booksSearcher;
    }



//    /**
//     * @param Request $request
//     * @return \Symfony\Component\HttpFoundation\Response
//     * @Route("/library/search" , name="book_api_search")
//     */
//    public function apiSearchBookAction(Request $request)
//    {
//        $form = $this->createForm(SearchFilterType::class);
//        $form->handleRequest($request);
//        $items=[];
//        if ($form->isSubmitted() && $form->isValid()) {
//            // the GoogleBooksSearcher generates the results from the google books api as an array
//            $items = $this->booksSearcher->apiSearchResult($form->getData());
//            if (!$items) {
//                $this->addFlash('error', 'pas de resultat');
//            }
//        }
//        return $this->render('@App/Book/bookSearchResults.html.twig', array(
//            'items' => $items,
//            'searchFilterForm' => $form->createView()
//        ));
//
//    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("add/{apiId}" , name="add_to_my_library")
     */
    public function addToMyLibraryAction($apiId, Request $request)
    {
        $result = $this->libraryConstructor->addBookToLibrary($apiId);
        if ($result ===0) {
            $this->addFlash('error', 'Id GoogleBooksApi errone');
            return $this->redirectToRoute('library_constructor');
        }elseif ($result ===2) {
            $this->addFlash('success', 'le livre existe deja dans votre bibliotheque');
        }else {
            $this->addFlash('success', 'le livre est ajoute avec succes');
        }
        $repository = $this->getDoctrine()->getManager()->getRepository(Book::class);
        $book = $repository->findOneBy(array('apiId'=>$apiId));

        return $this->redirectToRoute('book_show', array('id' => $book->getId()));
    }

    /**
     * @param Book $book
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("remove/{id}" , name="remove_from_my_library")
     */
    public function removeBookFromMyLibraryAction(LibraryBook $libraryBook , Request $request){
        $em = $this->getDoctrine()->getManager();
        $em->remove($libraryBook);
        $em->flush();
        $referer = $request->headers->get('referer');
        return $this->redirect($referer);
    }

    /**
     * @Route("/my-library")
     */
    public function LibraryBooksAction(){
        $myLibrary = $this->getUser()->getLibrary();
        $repository = $this->getDoctrine()->getManager()->getRepository(LibraryBook::class);
        $libraryBooks= $repository->findBy(array('library' => $myLibrary));
        return $this->render('@App/Book/bookList.html.twig', array(
            'libraryBooks' => $libraryBooks
        ));
    }

//    /**
//     * @Route("/library/{id}" , defaults={"id" = "0"})
//     */
//    public function userLibraryBooksAction($id){
//        if ($id == 0){
//            $user = $this->getUser();
//        }else{
//            $repository = $this->getDoctrine()->getManager()->getRepository(User::class);
//            $user = $repository->find($id);
//        }
//        if ($user != null){
//            $userLibrary = $user->getLibrary();
//            $repository = $this->getDoctrine()->getManager()->getRepository(LibraryBook::class);
//            $libraryBooks= $repository->findBy(array('library' => $userLibrary));
//        }else{
//            $libraryBooks = [];
//        }
//        return $this->render('@App/Book/libraryBooks.html.twig', array(
//            'libraryBooks' => $libraryBooks
//        ));
//    }
    /**
     * @param $apiId
     * @Route(name="check_book_in_library")
     */
    public function bookInLibrarayCheckerAction($apiId){
        $book = $this->libraryConstructor->checkBookInLibrary($apiId);
        return $this->render('@App/Book/bookInLibraryChecker.html.twig', array(
            'book' => $book,
            'apiId' => $apiId
        ));
    }

}
