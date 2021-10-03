<?php

namespace App\Controllers;

use App\Data\Managers\CommentManager;
use App\Data\Managers\PostManager;
use App\Data\Managers\UserManager;
use App\Request;
use App\Response;
use App\Session;

class AdminController extends Controller
{
    public function index(Request $request, Response $response)
    {
        $this->redirectIfNotAdmin($response);
        $this->render('/admin/index.html.twig');
    }

    public function users(Request $request, Response $response)
    {
        $userManager = new UserManager();
        $users = $userManager->findAll();
        $this->render('/admin/users.html.twig', compact('users'));
    }

//    public function comments(Request $request, Response $response)
//    {
//        $commentManager = new CommentManager();
//        $comments = $commentManager->findAll();
//        echo $this->render('/admin/users.html.twig', compact('comments'));
//    }

// TODO: changement ici
    protected function redirectIfNotAdmin(Response $response)
    {
        if (isset(Session::getSession()['auth']) && Session::getSession()['auth']['admin'] === 1) {
            return true;
        }
        Session::setFlash('error', "Vous n'etes pas autorisés à acceder a cette page");
        $response->redirect('/');
    }
}
