<?php

namespace App\Controllers;

use App\Request;
use App\Response;

class ErrorController extends Controller
{
    public function show(Request $request, Response $response)
    {
        $this->render('/general/_500.html.twig');
    }
}