<?php

namespace App\Controllers;

use App\Request;
use App\Response;

class NotFoundController extends Controller
{
    public function show(Request $request, Response $response)
    {
        $this->render('/general/_404.html.twig');
    }
}
