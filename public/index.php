<?php

use App\Application;
use App\Controllers\Admin\CommentAdminController;
use App\Controllers\Admin\PostAdminController;
use App\Controllers\AdminController;
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

// Contact
$app->router->get('/contact', [ContactController::class, 'show']);
$app->router->post('/contact', [ContactController::class, 'handleContact']);
// Post
$app->router->get('/blog', [PostController::class, 'index']);
$app->router->get('/blog/:id', [PostController::class, 'show']);
$app->router->post('/blog/:id/comment', [CommentController::class, 'insert']);
// Auth
$app->router->get('/login', [AuthController::class, 'login']);
$app->router->post('/login', [AuthController::class, 'login']);
$app->router->get('/logout', [AuthController::class, 'logout']);
$app->router->get('/register', [AuthController::class, 'register']);
$app->router->post('/register', [AuthController::class, 'register']);
// Admin
$app->router->get('/secadmin', [AdminController::class, 'index']);
$app->router->get('/secadmin/users', [AdminController::class, 'users']);
// Admin Post
$app->router->get('/secadmin/posts', [PostAdminController::class, 'index']);
$app->router->get('/secadmin/post-create', [PostAdminController::class, 'insert']);
$app->router->post('/secadmin/post-create', [PostAdminController::class, 'insert']);
$app->router->get('/secadmin/:id/post-update', [PostAdminController::class, 'modify']);
$app->router->post('/secadmin/:id/post-update', [PostAdminController::class, 'modify']);
$app->router->post('/secadmin/:id/post-remove', [PostAdminController::class, 'remove']);
// Admin Comments
$app->router->get('/secadmin/comments', [CommentAdminController::class, 'index']);
$app->router->post('/secadmin/:id/comment-remove', [CommentAdminController::class, 'remove']);
// 404
$app->router->get('/404', [NotFoundController::class, 'show']);

try {
    $app->run();
} catch (Exception $exception){
    echo $exception->getMessage();
}