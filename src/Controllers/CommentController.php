<?php

namespace App\Controllers;

use App\Data\Managers\CommentManager;
use App\Data\Models\CommentModel;
use App\Forms\CommentForm;
use App\Request;
use App\Response;
use App\Session;

class CommentController extends Controller
{
    private CommentManager $commentManager;

    public function __construct()
    {
        parent::__construct();
        $this->commentManager = new CommentManager();
    }

    public function insert(int $id, Request $request, Response $response)
    {
            $commentForm = new CommentForm();
            $commentModel = new CommentModel();
            $body = $request->getBody();
            $commentForm->objectifyForm($body);
            if($commentForm->validate())
            {
                $commentModel->setIdPost($id);
                var_dump(Session::getSession());
                $commentModel->setUsername(Session::getSession()['auth']['username'] ?? $commentForm->getAuthor());
                $commentModel->setContent($commentForm->getContent());
                $commentModel->setCreatedAt((new \DateTimeImmutable('now', new \DateTimeZone('Europe/Paris'))));
                $this->commentManager->save($commentModel);
                Session::setFlash('success', 'Votre commentaire apparaitra quand il sera approuvé par un administrateur');
                $response->redirect("/blog/$id");
            }
            $response->redirect("/blog/$id");
    }
}
