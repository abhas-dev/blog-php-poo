<?php

namespace App\Controllers;

use App\Request;
use App\Session;

class BlogController extends Controller
{
    public function index()
    {
//        unset($_SESSION['flash_messages']);
        Session::unsetSession('flash_messages');
        $this->render('general/home.html.twig');
    }
}
