<?php

namespace App\Controllers\Admin;

use App\Controllers\AdminController;
use App\Data\Managers\CommentManager;
use App\Request;
use App\Response;
use App\Session;

class CommentAdminController extends AdminController
{
    private CommentManager $commentManager;

    public function __construct()
    {
        $this->commentManager = new CommentManager();
    }

    public function index(Request $request, Response $response)
    {
        unset($_SESSION['flash_messages']);
        if($this->redirectIfNotAdmin($response))
        {
            $comments = $this->commentManager->findAll();
            $this->render('/admin/comments.html.twig', compact('comments'));
        }
        else{
            Session::setFlash('error', "Vous n'etes pas autorisés à acceder a cette page");
            $response->redirect('/');
        }
    }

    public function approuve(int $id, Request $request, Response $response)
    {
        if($this->redirectIfNotAdmin($response))
        {
            if ($request->getMethod() == 'post' && isset($_POST['token']) && Session::getSession()['token'] === $_POST['token']) {
                $comment = $this->commentManager->find($id);
                $comment->setIsApprouved($comment->getIsApprouved() ? 0 : 1);
                $this->commentManager->update($comment);
                $response->redirect('/secadmin/comments');
            }
        }
    }

    public function remove(int $id, Request $request,Response $response)
    {
        if ($this->redirectIfNotAdmin($response)) {
            if ($request->getMethod() == 'post' && isset($_POST['token']) && Session::getSession()['token'] === $_POST['token']) {
                $this->commentManager->delete($id);
                Session::setFlash('success', "Le commentaire à été supprimé avec succes");
                $response->redirect('/secadmin/comments');
            }
        }
    }
}
