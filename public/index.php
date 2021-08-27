<?php

use App\Application;
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

$app = new Application();

$app->router->get('/', function(){
    return 'Hello World';
});

$app->router->get('/users', function(){
    return 'Hello Users';
});

$app->router->get('/contact', function(){
    return 'Hello Contact';
});

$app->run();


//echo $twig->render('index.html', ['name' => 'Fabien']);