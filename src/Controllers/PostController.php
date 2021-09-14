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
        $id = intval($id);
        $post = $this->postManager->findPostBySlugWithValidatedComments($id);
        //$post = $this->postManager->find($id);
//        $comment = $this->commentManager->findByPostId($post_id, $page);
        // TODO: definir si les comments font partie du Post (methode getComment) ou si c'est independant et donc faire une sous vue
        echo $this->render('blog/show.html.twig', compact('post'));
    }

    public function form()
    {
        echo $this->render('blog/postForm.html.twig');
    }

    public function insert(Request $request){
        try {
            $post = new PostModel();
            $body = $request->getBody();
            $post->objectifyForm($body);
//        $post->hydrate($body);
            $this->postManager->save($post);
            header("Location:/blog");
            echo $this->render('blog/index.html.twig', compact('post'));
        }catch (\Exception $e)
        {
            var_dump($e);
        }

    }

}