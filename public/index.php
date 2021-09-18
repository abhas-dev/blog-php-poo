<?php

use App\Application;
use App\Controllers\AuthController;
use App\Controllers\BlogController;
use App\Controllers\CommentController;
use App\Controllers\ContactController;
use App\Controllers\NotFoundController;
use App\Controllers\PostController;
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


$app = new Application($twig);

$app->router->get('/', [BlogController::class, 'index']);

$app->router->get('/contact', [ContactController::class, 'show']);
$app->router->post('/contact', [ContactController::class, 'handleContact']);

$app->router->get('/blog', [PostController::class, 'index']);
$app->router->get('/blog/:id', [PostController::class, 'show']);
$app->router->post('/blog/:id/comment', [CommentController::class, 'insert']);
$app->router->get('/blog-create', [PostController::class, 'form']);
$app->router->post('/blog-create', [PostController::class, 'insert']);


$app->router->get('/login', [AuthController::class, 'login']);
$app->router->post('/login', [AuthController::class, 'login']);
$app->router->get('/register', [AuthController::class, 'register']);
$app->router->post('/register', [AuthController::class, 'register']);

$app->router->get('/404', [NotFoundController::class, 'show']);

try {
    $app->run();
} catch (Exception $exception) {
    echo $exception->getMessage();
}
