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
        if($this->isAdmin($response))
        {
            echo $this->render('/admin/index.html.twig');
        }
    }

    public function posts(Request $request, Response $response)
    {
        $postManager = new PostManager();
        $posts = $postManager->findAll();
        echo $this->render('/admin/posts.html.twig', compact('posts'));

    }

    public function users(Request $request, Response $response)
    {
        $userManager = new UserManager();
        $users = $userManager->findAll();
        echo $this->render('/admin/users.html.twig', compact('users'));
    }

    public function comments(Request $request, Response $response)
    {
        $commentManager = new CommentManager();
        $comments = $commentManager->findAll();
        echo $this->render('/admin/users.html.twig', compact('comments'));
    }



    protected function isAdmin(Response $response)
    {
        if(isset($_SESSION['auth']) && $_SESSION['auth']['admin'] === 1)
        {
            return true;
        }
        else{
            Session::setFlash('error', "Vous n'etes pas autorisés à acceder a cette page");
            $response->redirect('/', 401);
        }
    }
}