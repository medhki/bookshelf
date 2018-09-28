<?php

namespace AppBundle\Controller;

use AppBundle\Entity\AuthorBook;
use AppBundle\Entity\Review;
use AppBundle\Entity\User;
use AppBundle\Form\ReviewType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Book;
use AppBundle\Entity\LibraryBook;
use AppBundle\Form\SearchFilterType;
use AppBundle\Service\GoogleBooksSearcher;
use AppBundle\Service\LibraryConstructor;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class BookController
 * @package AppBundle\Controller
 * @Route("/book")
 */
class BookController extends Controller
{
    /**
     * @param Book $book
     * @Route("/{id}" , name="book_show" , requirements={"id":"\d+"})
     */
    public function showBookAction($id , Request $request){
        $repoBook = $this->getDoctrine()->getManager()->getRepository(Book::class);
        $book = $repoBook->find($id);
        $owned = false;

        if ($book) {
            $book->setViewsCount($book->getViewsCount() + 1);
            $user = $this->getUser();
            if ($user) {
                // test if the book is owned by current user
                $repoLibraryBook = $this->getDoctrine()->getManager()->getRepository(LibraryBook::class);
                $owned = boolval($repoLibraryBook->findBy(array(
                    'library' => $user->getLibrary() ,
                    'book' => $book
                )));


                $em = $this->getDoctrine()->getManager();
                $repository = $em->getRepository(Review::class);
                $review = $repository->findOneBy(array('book' => $book, 'user' => $user));
                $status = true;
                if (!$review ) {
                    $review = new Review();
                    $review->setUser($user)->setBook($book);
                    $em->persist($review);
                    $status = false;
                }
                $reviewForm = $this->createForm(ReviewType::class, $review, array(
                    'action' => $this->generateUrl('book_show', array('id' => $book->getId())),
                    'method' => 'POST',
                ));
                $reviewForm->handleRequest($request);

                if ($reviewForm->isSubmitted() && $reviewForm->isValid()) {
                    if ($status) {
                        $this->addFlash('success', 'review updated');
                    } else {
                        $this->addFlash('success', 'review added');
                    }
                    $em->flush();
                }
            }else{
                $reviewForm = $this->createForm(ReviewType::class);
                $status = false;
            }
            return $this->render(':Books:bookById.html.twig', array(
                'book' => $book,
                'reviewForm' => $reviewForm->createView(),
                'status' => $status,
                'owned' => $owned
            ));
        }

        return $this->redirectToRoute('decouvrir');
    }

    /**
     * @param Book $book
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function bookUserInformationAction(Book $book){
        $library = $this->getUser()->getLibrary();
        $repository = $this->getDoctrine()->getManager()->getRepository(LibraryBook::class);
        $libraryBook= $repository->findOneBy(array('book'=>$book , 'library' => $library));
        return $this->render('@App/Book/userBookInformation.html.twig', array(
            'libraryBook' => $libraryBook
        ));
    }

    public function bookAuthorsListAction(Book $book){

        $repo = $this->getDoctrine()->getManager()->getRepository(AuthorBook::class);
        $results = $repo->bookAuthorsList($book);
        $authors=[];
        foreach ($results as $result){
            $authors[] = $result->getAuthor();
        }
        return $this->render(':Author:bookAuthorsList.html.twig', array('authors' => $authors));
    }

    public function bookSellExchangeGiveawayStatusAction(Book $book){
        $repo = $this->getDoctrine()->getManager()->getRepository(LibraryBook::class);
        $sellCount = count($repo->bookSellList($book));
        $exchangeCount = count($repo->bookEchangeList($book));
        $giveawayCount = count($repo->bookGiveawayList($book));
        return $this->render(':Books:bookSellExchangeGiveawayStatus.html.twig', array(
            'book' => $book,
            'sellCount' => $sellCount,
            'exchangeCount' => $exchangeCount,
            'giveawayCount' => $giveawayCount
        ));
    }

    /**
     * @param $id
     * @Route("/toggle/sell/{id}", name="sell_statut_toggle")
     */
    public function userBookSellToggle(LibraryBook $libraryBook , Request $request){
        $em = $this->getDoctrine()->getManager();
        if ($request->request->get('sellToggle')){
            if ($libraryBook->getSell()){
                $libraryBook->setSell(false);
            }else{
                $libraryBook->setSell(true);
                $libraryBook->setPrice($request->request->get('price'));
            }
        }elseif ($request->request->get('update')){
            $libraryBook->setPrice($request->request->get('price'));
        }
        $em->flush();
        return $this->redirectToRoute('book_show', array('id' => $libraryBook->getBook()->getId()));
    }
    /**
     * @param $id
     * @Route("/toggle/exchange/{id}",name="exchange_statut_toggle")
     */
    public function userBookExchangeToggle(LibraryBook $id, LibraryBook $libraryBook){
        $em = $this->getDoctrine()->getManager();
        if ($libraryBook->getExchange()){
            $libraryBook->setExchange(false);
        }else{
            $libraryBook->setExchange(true);
        }
        $em->flush();
        return $this->redirectToRoute('book_show', array('id' => $libraryBook->getBook()->getId()));
    }
    /**
     * @param $id
     * @Route("/toggle/giveaway/{id}", name="giveaway_statut_toggle")
     */
    public function userBookGiveawayToggle(LibraryBook $libraryBook){
        $em = $this->getDoctrine()->getManager();
        if ($libraryBook->getGiveaway()){
            $libraryBook->setGiveaway(false);
        }else{
            $libraryBook->setGiveaway(true);
        }
        $em->flush();
        return $this->redirectToRoute('book_show', array('id' => $libraryBook->getBook()->getId()));
    }

    /**
     * @Route("/exchangers/{id}" , requirements={"id" : "\d*"}  , name="book_exchangers_list")
     */
    public function exchangerListAction(Book $book){
        $repositoryLibraryBook = $this->getDoctrine()->getManager()->getRepository(LibraryBook::class);
        $bookExchangeList = $repositoryLibraryBook->findBy(array('book' => $book , 'exchange'=>true));
        return $this->render(':SellExchangeGiveawayLists:bookexchangersList.html.twig', array(
            'bookList' => $bookExchangeList
        ));
    }

    /**
     * @Route("/sellers/{id}",  requirements={"id" : "\d*"}  , name="book_sellers_list")
     */
    public function sellerListAction(Book $book){
        $repositoryLibraryBook = $this->getDoctrine()->getManager()->getRepository(LibraryBook::class);
        $bookSellersList = $repositoryLibraryBook->findBy(array('book' => $book , 'sell'=>true));
        return $this->render(':SellExchangeGiveawayLists:booksellersList.html.twig', array(
            'bookList' => $bookSellersList
        ));
    }

    /**
     * @Route("/givers/{id}",  requirements={"id" : "\d*"}  , name="book_givers_list")
     */
    public function giversListAction(Book $book){
        $repositoryLibraryBook = $this->getDoctrine()->getManager()->getRepository(LibraryBook::class);
        $bookGiversList = $repositoryLibraryBook->findBy(array('book' => $book , 'giveaway'=>true));
        return $this->render(':SellExchangeGiveawayLists:bookGiversList.html.twig', array(
            'bookList' => $bookGiversList
        ));
    }

    /**
     * @Route("/owners/{id}",   name="book_owners_list")
     */
    public function ownersListAction(Book $book){
        $repositoryLibraryBook = $this->getDoctrine()->getManager()->getRepository(LibraryBook::class);
        $bookOwnersList = $repositoryLibraryBook->findBy(array('book' => $book));
        return $this->render(':SellExchangeGiveawayLists:bookOwnersList.html.twig', array(
            'bookList' => $bookOwnersList
        ));
    }

    public function bookInLibraryOwnerAction(LibraryBook $libraryBook){
        $repo = $this->getDoctrine()->getManager()->getRepository(User::class);
        $owner = $repo->findOneBy(array('library' => $libraryBook->getLibrary()));
        return $this->render('bookOwnerName.html.twig', array('user' => $owner));
    }
}
