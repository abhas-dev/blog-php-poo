<?php

namespace App\Controllers;

use App\Application;
use App\Request;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

abstract class Controller
{
    protected Request $request;
    protected Environment $twig;


    protected function render(string $path, array $params = []): string
    {
        $this->twig = Application::$app->twig;

        try {
            return $this->twig->render($path, $params);
        } catch (LoaderError | RuntimeError | SyntaxError $e) {
            return $e->getMessage();
        }
    }
}