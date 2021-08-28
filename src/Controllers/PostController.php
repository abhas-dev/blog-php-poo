<?php

namespace App\Controllers;

use App\Data\Managers\PostManager;
use App\Data\Models\PostModel;
use App\Request;

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

    public function form()
    {
        echo $this->render('blog/postForm.html.twig');
    }

    public function insert(Request $request){

        $post = new PostModel();
        $body = $request->getBody();
        $post
            ->setTitle($body['title'])
            ->setContent($body['content'])
            ->setCreatedAt(new \DateTimeImmutable());
        $this->postManager->create($post);
        header("Location:");
        return $this->render('blog/index.html.twig', compact('post'));
    }

}