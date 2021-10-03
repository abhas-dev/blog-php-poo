<?php

namespace App\Controllers;

use App\Request;

class BlogController extends Controller
{
    public function index()
    {
        unset($_SESSION['flash_messages']);
        $this->render('general/home.html.twig');
    }
}