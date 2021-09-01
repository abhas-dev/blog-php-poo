<?php

namespace App\Controllers;

use App\Request;

class BlogController extends Controller
{
    public function index()
    {
        echo $this->render('general/home.html.twig');
    }
}