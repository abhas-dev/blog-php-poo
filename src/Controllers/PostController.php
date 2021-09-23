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

    public function welcome()
    {
        echo $this->render('blog/welcome.html.twig');
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
        //$post = $this->postManager->find($id);
//        $comment = $this->commentManager->findByPostId($post_id, $page);
        // TODO: definir si les comments font partie du Post (methode getComment) ou si c'est independant et donc faire une sous vue
        echo $this->render('blog/show.html.twig', compact('post'));
    }

    public function insert(Request $request, Response $response){
        if(isset($_SESSION['auth']) && $_SESSION['auth']['id'] !== null)
        {
                if($request->getMethod() == 'post')
                {
                        try {
                            $post = new PostModel();
                            $body = $request->getBody();
                            $post->objectifyForm($body);
                            $post->setIdUser($_SESSION['auth']['id']);
                            if(!$post->validate())
                            {
                                $errors = $post->getErrors();
                                echo $this->render('/blog/postForm.html.twig', compact('errors', 'post'));
                            }
                            $this->postManager->save($post);
                            Session::setFlash('success', "L'article a été crée avec succes");
                            $response->redirect('/blog');

                        }
                        catch (\Exception $e)
                        {
                          var_dump($e);
                        }
                    }
                if($request->getMethod() == 'get')
                {
                    echo $this->render('blog/postForm.html.twig');
                }
            }
        else{
            Session::setFlash('error', "Vous n'etes pas autorisés à acceder a cette page");
            Application::$app->response->redirect('/', 401);
        }

        }


    public function modify(int $id, Request $request, Response $response)
    {
        if(isset($_SESSION['auth']) && $_SESSION['auth']['id'] !== null)
        {
            $id = intval($id);
            $post = new PostModel();
            $post = $this->postManager->findPostBySlugWithValidatedComments($id);
            if(!$post)
            {
                Session::setFlash('error', "Ce post n'existe pas");
                $response->redirect('/', 404);
            }
            if($post->getIdUser() !== $_SESSION['auth']['id'])
            {
                Session::setFlash('error', "Vous n'avez pas acces à cette page");
                $response->redirect('/');
            }

            if($request->getMethod() == 'post')
            {
                $body = $request->getBody();
                $updatedPost = new PostModel();
                $updatedPost->objectifyForm($body);
                $updatedPost->setId($post->getId());
                $updatedPost->setIdUser($post->getIdUser());
                if($updatedPost->validate())
                {
                    $this->postManager->update($updatedPost);
                    Session::setFlash('success', "L'article a été modifié avec succes");
                    echo $this->render('blog/index.html.twig', compact('post'));
                }

            }

            echo $this->render('blog/postForm.html.twig', compact('post'));

        }
        else{
            Session::setFlash('error', "Vous n'etes pas autorisés à acceder a cette page");
            Application::$app->response->redirect('/', 401);
        }

    }
}