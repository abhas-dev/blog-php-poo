<?php

namespace App\Controllers;

use App\Application;
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
        unset($_SESSION['error']);
        $loginModel = new LoginModel();
        if ($request->getMethod() == 'post') {
            $body = $request->getBody();
//            $body['password'] = password_hash($body['password'], PASSWORD_ARGON2I);
            $loginModel->objectifyForm($body);
            if ($loginModel->validate()) {
                $user = $this->userManager->findBy(['email' => $loginModel->getEmail()]);
                if(!$user)
                {
                    // TODO: faire une fonction setError dans Session
                    $_SESSION['error']['login'] = "L'adresse et/ou le mot de passe est incorrect ";
                    $response->redirect('/login');
                    exit;
                }
                if(password_verify($loginModel->getPassword(), $user->getPassword()))
                {
                    Session::setUserSession($user);
                    $response->redirect('/');

                } else{
                    // Mauvais mot de passe
                    // TODO: faire une fonction setError dans Session
                    $_SESSION['error'] = "L'adresse et/ou le mot de passe est incorrect ";
                    Application::$app->response->redirect('/login');
                }
            }
            $errors = $loginModel->getErrors();
            echo $this->render('auth/login.html.twig', compact('errors', 'loginModel'));
        }
        if ($request->getMethod() == 'get') {
            echo $this->render('auth/login.html.twig');
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
                $response->redirect('/');
            }

            $errors = $registerModel->getErrors();
            echo $this->render('auth/register.html.twig', compact('errors', 'registerModel'));
        }

        if ($request->getMethod() == 'get'){
            echo $this->render('auth/register.html.twig');
        }
    }

    public function logout(Request $request,Response $response)
    {
        unset($_SESSION['auth']);
        // On redirige a l'endroit ou on se trouvais lors de la deconnexion
        $response->redirect($request->getReferer());
    }
}