<?php

namespace App\Controllers\Admin;

use App\Controllers\AdminController;
use App\Data\Managers\CommentManager;
use App\Data\Managers\PostManager;
use App\Data\Managers\UserManager;
use App\Data\Models\PostModel;
use App\Request;
use App\Response;
use App\Session;

class PostAdminController extends AdminController
{
    public function __construct()
    {
        $this->postManager = new PostManager();
    }

    public function index(Request $request, Response $response)
    {
        unset($_SESSION['flash_messages']);
        if ($this->isAdmin($response)) {
            $posts = $this->postManager->findAll();
            echo $this->render('/admin/posts.html.twig', compact('posts'));
        } else {
            Session::setFlash('error', "Vous n'etes pas autorisés à acceder a cette page");
            $response->redirect('/');
        }
    }

    public function insert(Request $request, Response $response)
    {
        if ($this->isAdmin($response)) {
            if ($request->getMethod() == 'post') {
                try {
                    $post = new PostModel();
                    $body = $request->getBody();
                    $post->objectifyForm($body);
                    $post->setIdUser($_SESSION['auth']['id']);
                    if (!$post->validate()) {
                        $errors = $post->getErrors();
                        echo $this->render('/blog/postForm.html.twig', compact('errors', 'post'));
                    } else {
                        $this->postManager->save($post);
                        Session::setFlash('success', "L'article a été crée avec succes");
                        $response->redirect('/secadmin/posts');
                    }
                } catch (\Exception $e) {
                    var_dump($e);
                }
            }
            if ($request->getMethod() == 'get') {
                echo $this->render('blog/postForm.html.twig');
            }
        }
    }

    public function modify(int $id, Request $request, Response $response)
    {
        if ($this->isAdmin($response)) {
            $id = intval($id);
            $post = new PostModel();
            $post = $this->postManager->find($id);
            if (!$post) {
                Session::setFlash('error', "Ce post n'existe pas");
                $response->redirect('/', 404);
            }
            if ($post->getIdUser() !== $_SESSION['auth']['id'] && !$_SESSION['auth']['admin']) {
                Session::setFlash('error', "Vous n'avez pas acces à cette page");
                $response->redirect('/');
            }

            if ($request->getMethod() == 'post') {
                $body = $request->getBody();
                $updatedPost = new PostModel();
                $updatedPost->objectifyForm($body);
                $updatedPost->setIntroduction('aaa');
                $updatedPost->setId($post->getId());
                $updatedPost->setIdUser($post->getIdUser());
                $updatedPost->setCreatedAt($post->getCreatedAt());
                $updatedPost->setUpdatedAt((new \DateTimeImmutable('now', new \DateTimeZone('Europe/Paris'))));
                if ($updatedPost->validate()) {
                    $this->postManager->update($updatedPost);
                    Session::setFlash('success', "L'article a été modifié avec succes");
                    $response->redirect('/secadmin/posts');
//                    echo $this->render('blog/index.html.twig', compact('post'));
                }
            }
            if ($request->getMethod() == 'get') {
                echo $this->render('blog/postForm.html.twig', compact('post'));
            }
        } else {
            Session::setFlash('error', "Vous n'etes pas autorisés à acceder a cette page");
            $response->redirect('/', 401);
        }
    }

    public function remove(int $id, Request $request, Response $response)
    {
        if ($this->isAdmin($response)) {
            $this->postManager->delete($id);
            Session::setFlash('success', "L'article à été supprimé avec succes");
            $response->redirect('/secadmin/posts');
        } else {
            Session::setFlash('error', "Vous n'etes pas autorisés à acceder a cette page");
            $response->redirect('/', 401);
        }
    }
}
