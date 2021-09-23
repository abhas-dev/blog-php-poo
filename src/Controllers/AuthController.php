<?php

namespace App\Controllers;

use App\Data\Managers\UserManager;
use App\Data\Models\LoginModel;
use App\Data\Models\UserModel;
use App\Request;
use App\Response;
use App\Session;

class AuthController extends Controller
{
    private UserManager $userManager;

    public function __construct()
    {
        parent::__construct();
        $this->userManager = new UserManager();
    }

    public function login(Request $request, Response $response)
    {
        if(!isset($_SESSION['auth'])){
            unset($_SESSION['flash_messages']['error']);
            $loginModel = new LoginModel();
            if ($request->getMethod() == 'post' && $_SESSION['token'] === $_POST['token']) {
                $body = $request->getBody();
//            $body['password'] = password_hash($body['password'], PASSWORD_ARGON2I);
                $loginModel->objectifyForm($body);
                if ($loginModel->validate()) {
                    $user = $this->userManager->findBy(['email' => $loginModel->getEmail()]);
                    if(!$user)
                    {
                        Session::setFlash('error',"L'adresse et/ou le mot de passe est incorrect ");
                        $response->redirect('/login');
                    }
                    if(password_verify($loginModel->getPassword(), $user->getPassword()))
                    {
                        Session::setUserSession($user);
                        Session::setFlash('success', 'Bienvenue '. $user->getUsername());
                        $response->redirect('/',302);

                    } else{
                        // Mauvais mot de passe
                        Session::setFlash('error',"L'adresse et/ou le mot de passe est incorrect " );
                        $response->redirect('/login');
                    }
                }
                $errors = $loginModel->getErrors();
                echo $this->render('auth/login.html.twig', compact('errors', 'loginModel'));
            }
            if ($request->getMethod() == 'get') {
                echo $this->render('auth/login.html.twig');
            }
        }
        else{
            $response->redirect('/');
        }

    }

    public function register(Request $request, Response $response)
    {
        $registerModel = new UserModel();

        if ($request->getMethod() == 'post') {
            $body = $request->getBody();
            $registerModel->objectifyForm($body);
            if ($registerModel->validate()) {
                $this->userManager->save($registerModel);
                Session::setFlash('success', 'Le compte a bien été enregistré');
                $response->redirect('/');
            }

            $errors = $registerModel->getErrors();
            echo $this->render('auth/register.html.twig', compact('errors', 'registerModel'));
        }

        if ($request->getMethod() == 'get'){
            echo $this->render('auth/register.html.twig');
        }
    }
}