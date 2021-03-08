<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Post;

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
