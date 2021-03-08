<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Post;
use App\Form\PostType;

class PostController extends AbstractController
{
    #[Route('/post', name: 'post')]
    public function index(): Response
    {
        $repo = $this->getDoctrine()->getRepository(Post::class);
        $posts = $repo->findAll();

        return $this->render('post/index.html.twig', [
            'posts' => $posts,
        ]);
    }

    #[Route('/post/create', name: 'post_create')]
    public function create(Request $request): Response
    {
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $post->setCreatedAt(new \DateTime());
            $post->setIsPublished(true);
            $post->setIsDeleted(false);

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
    public function show(int $id): Response
    {
        $repo = $this->getDoctrine()->getRepository(Post::class);
        $post = $repo->find($id);

        return $this->render('post/show.html.twig', [
            'post' => $post,
        ]);
    }
}
