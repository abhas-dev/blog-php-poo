<?php

namespace App\Controllers;

class AuthController extends Controller
{
    public function login()
    {
        echo $this->render('auth/login.html.twig');
    }

    public function register()
    {
        echo $this->render('auth/register.html.twig');
    }


}