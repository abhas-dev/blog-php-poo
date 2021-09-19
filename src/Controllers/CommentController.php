<?php

namespace App\Controllers;

use App\Data\Managers\CommentManager;
use App\Data\Models\CommentModel;
use App\Request;
use App\Response;

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
        try {
            $comment = new CommentModel();
            $body = $request->getBody();
            $comment->objectifyForm($body);
            $comment->setIdPost($id);
            $this->commentManager->save($comment);
            $response->redirect('/blog/$id');
        } catch (\Exception $e) {
            var_dump($e);
        }
    }
}