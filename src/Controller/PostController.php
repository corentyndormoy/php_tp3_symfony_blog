<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use App\Entity\Post;
use App\Entity\Comment;
use App\Form\PostType;
use App\Form\CommentType;
use App\Repository\PostRepository;

class PostController extends AbstractController
{
    #[Route('/post', name: 'post')]
    /**
     * Affiche la liste des articles
     * 
     * @param PostRepository $postRepository
     * 
     * @return Response
     */
    public function index(PostRepository $postRepository): Response
    {
        $posts = $postRepository->findAll();

        return $this->render('post/index.html.twig', [
            'posts' => $posts,
        ]);
    }

    #[Route('/post/create', name: 'post_create')]
    /**
     * Crée un article
     * 
     * @param Request $request
     * @param Security $security
     * 
     * @return Response
     */
    public function create(Request $request, Security $security): Response
    {
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){

            $post->setCreatedAt(new \DateTime());
            $post->setIsPublished(true);
            $post->setIsDeleted(false);
            $post->setAuthor($security->getUser());

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($post);
            $manager->flush();
    
            return $this->redirectToRoute('post_show', ['id' => $post->getId()]);
        }

        return $this->render('post/create.html.twig', [
            'formPost' => $form->createView(),
        ]);
    }

    #[Route('/post/{id}', name: 'post_show')]
    /**
     * Affiche le contenu de l'article
     * 
     * @param int $id
     * @param PostRepository $postRepository
     * @param Request $request
     * @param Security $security
     * 
     * @return Response
     */
    public function show(int $id, PostRepository $postRepository, Request $request, Security $security): Response
    {
        $post = $postRepository->find($id);

        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){   
            $comment->setCreatedAt(new \DateTime())         
                    ->setPost($post)
                    ->setIsDeleted(false)
                    ->setAuthor($security->getUser());
    
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($comment);
            $manager->flush();
    
            return $this->redirectToRoute('post_show', ['id' => $post->getId()]);
        }
    
    

        return $this->render('post/show.html.twig', [
            'post' => $post,
            'formComment' => $form->createView()
        ]);
    }
}
