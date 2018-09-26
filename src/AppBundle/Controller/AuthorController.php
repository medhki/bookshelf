<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Author;
use AppBundle\Entity\AuthorBook;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AuthorController
 * @package AppBundle\Controller
 * @Route("/author")
 */
class AuthorController extends Controller
{
    /**
     * @param $name
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/{id}", name="author_profile")
     */
    public function authorProfileAction($id)
    {
        $repoAuthor = $this->getDoctrine()->getManager()->getRepository(Author::class);
        $author = $repoAuthor->find($id);
        if ($author != null){
            $repoAuthorBook = $this->getDoctrine()->getManager()->getRepository(AuthorBook::class);
            $authorBooks = $repoAuthorBook->findBy(array('author'=>$author));
            return $this->render(':Author:authorProfile.html.twig', array('author' => $author , 'authorBooks' => $authorBooks));
        }
        return $this->redirectToRoute('decouvrir');
    }
}
