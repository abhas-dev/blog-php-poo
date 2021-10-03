<?php

namespace App\Controllers;

use App\Request;
use App\Response;

class NotFoundController extends Controller
{

    public function show(Request $request, Response $response)
    {
        http_response_code(404);
        $this->render('/general/_404.html.twig');
    }
}