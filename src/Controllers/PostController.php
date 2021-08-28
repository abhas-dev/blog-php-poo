<?php

namespace App\Controllers;

use App\Data\Managers\PostManager;

class PostController extends Controller
{
    private PostManager $postManager;

    public function __construct()
    {
        parent::__construct();
        $this->postManager = new PostManager();
    }

    public function welcome()
    {
        echo $this->render('blog/welcome.html.twig');
    }

    public function index()
    {
        $posts = $this->postManager->findAll();
        echo $this->render('blog/index.html.twig', compact('posts'));
    }

    public function show(int $id)
    {
        $post = $this->postManager->find($id);
        var_dump($post);
        echo $this->render('blog/show.html.twig', compact('post'));
    }

    public function insert(){

        $post = new PostModel();
        $post
            ->setTitle("Titre Test")
            ->setContent("Contenu du post")
            ->setCreatedAt(new \DateTimeImmutable());
        $this->postManager->create($post);
        echo $this->render('blog/formpost.html.twig', compact('post'));
    }

}