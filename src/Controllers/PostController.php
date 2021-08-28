<?php

namespace App\Controllers;

use Twig\Environment;

class PostController extends Controller
{
    public function __construct(Environment $twig)
    {
        parent::__construct($twig);
    }

}