<?php

use Symfony\Component\Dotenv\Dotenv;
use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;

require_once '../vendor/autoload.php';

define("ROOT", dirname(__DIR__));

$dotenv = new Dotenv();
$dotenv->load(ROOT .'/.env');
$loader = new FilesystemLoader(ROOT . '/templates');
$twig = new Environment($loader, [
    //'cache' => '/path/to/compilation_cache',
    'debug' => true
]);
$twig->addExtension(new DebugExtension());


echo $twig->render('index.html', ['name' => 'Fabien']);