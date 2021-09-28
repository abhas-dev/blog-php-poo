<?php

namespace App\Controllers\Admin;

use App\Controllers\AdminController;
use App\Data\Managers\PostManager;
use App\Data\Models\PostModel;
use App\Forms\PostForm;
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
            if ($request->getMethod() == 'post' && $_SESSION['token'] === $_POST['token']) {
                try {
                    $postModel = new PostModel();
                    $postForm = new PostForm();
                    $body = $request->getBody();
                    $postForm->objectifyForm($body);
                    if (!$postForm->validate()) {
                        $errors = $postForm->getErrors();
                        echo $this->render('/admin/postForm.html.twig', compact('errors', 'postForm'));
                    } else {
                        $postModel->setIdUser($_SESSION['auth']['id']);
                        $postModel->setTitle($postForm->getTitle());
                        $postModel->setIntroduction(substr($postForm->getContent(), 0, 100));
                        $postModel->setContent($postForm->getContent());
                        $postModel->setCreatedAt((new \DateTimeImmutable('now', new \DateTimeZone('Europe/Paris'))));

                        $this->postManager->save($postModel);
                        Session::setFlash('success', "L'article a été crée avec succes");
                        $response->redirect('/secadmin/posts');
                    }
                } catch (\Exception $e) {
                    echo $e;
                }
            }
            if ($request->getMethod() == 'get') {
                echo $this->render('/admin/postForm.html.twig');
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

            if ($request->getMethod() == 'post' && $_SESSION['token'] === $_POST['token']) {
                $body = $request->getBody();
                $updatedForm = new PostForm();
                $updatedForm->objectifyForm($body);

                if ($updatedForm->validate()) {
                    $post->setIntroduction(substr($updatedForm->getContent(), 0, 100));
                    $post->setTitle($updatedForm->getTitle());
                    $post->setContent($updatedForm->getContent());
                    $post->setUpdatedAt((new \DateTimeImmutable('now', new \DateTimeZone('Europe/Paris'))));

                    $this->postManager->update($post);
                    Session::setFlash('success', "L'article a été modifié avec succes");
                    $response->redirect('/secadmin/posts');
                }
            }
            if ($request->getMethod() == 'get') {
                echo $this->render('/admin/postForm.html.twig', compact('post'));
            }
        }
    }

    public function remove(int $id, Request $request, Response $response)
    {
        if ($this->isAdmin($response)) {
            if ($request->getMethod() == 'post' && $_SESSION['token'] === $_POST['token']) {
            $this->postManager->delete($id);
            Session::setFlash('success', "L'article à été supprimé avec succes");
            $response->redirect('/secadmin/posts');
            }
        }
    }
}
