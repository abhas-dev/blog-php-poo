<?php

namespace App\Controllers;

use App\Application;
use App\Data\Managers\PostManager;
use App\Data\Models\PostModel;
use App\Request;
use App\Response;
use App\Session;

class PostController extends Controller
{
    private PostManager $postManager;

    public function __construct()
    {
        $this->postManager = new PostManager();
    }

    public function index()
    {
        unset($_SESSION['flash_messages']);
        $posts = $this->postManager->findAll();
        echo $this->render('blog/index.html.twig', compact('posts'));
    }

    public function show(int $id)
    {
        $id = intval($id);
        $post = $this->postManager->findPostBySlugWithValidatedComments($id);
        echo $this->render('blog/show.html.twig', compact('post'));
    }
}