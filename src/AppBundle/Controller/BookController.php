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
        if ($book) {
            $book->setViewsCount($book->getViewsCount() + 1);
            $user = $this->getUser();
            if ($user) {
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
                'status' => $status
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
            'userBookInfo' => $libraryBook
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

//    /**
//     * @Route("/exchange/{id}", defaults={"id" = 0} , requirements={"id" : \d})
//     */
//    public function exchangeListAction($id){
//        $repositoryUser = $this->getDoctrine()->getManager()->getRepository(User::class);
//        $user = $repositoryUser->find($id);
//        $repositoryLibraryBook = $this->getDoctrine()->getManager()->getRepository(LibraryBook::class);
//        $bookList = $repositoryLibraryBook->exchangeList($user);
//        return $this->render('@App/Book/bookList.html.twig', array(
//            'bookList' => $bookList,
//        ));
//    }
//
//    /**
//     * @Route("/sell/{id}", defaults={"id" = 0} , requirements={"id" : \d})
//     */
//    public function sellListAction($id){
//        $repositoryUser = $this->getDoctrine()->getManager()->getRepository(User::class);
//        $user = $repositoryUser->find($id);
//        $repositoryLibraryBook = $this->getDoctrine()->getManager()->getRepository(LibraryBook::class);
//        $bookList = $repositoryLibraryBook->sellList($user);
//        return $this->render('@App/Book/bookList.html.twig', array(
//            'bookList' => $bookList,
//        ));
//    }
//
//    /**
//     * @Route("/giveaway/{id}", defaults={"id" = 0} , requirements={"id" : \d})
//     */
//    public function giveawayListAction($id){
//        $repositoryUser = $this->getDoctrine()->getManager()->getRepository(User::class);
//        $user = $repositoryUser->find($id);
//        $repositoryLibraryBook = $this->getDoctrine()->getManager()->getRepository(LibraryBook::class);
//        $bookList = $repositoryLibraryBook->giveawayList($user);
//        return $this->render('@App/Book/bookList.html.twig', array(
//            'bookList' => $bookList,
//        ));
//    }


}
