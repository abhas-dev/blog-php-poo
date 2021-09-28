<?php

namespace App\Controllers;

use App\Application;
use App\Data\Managers\UserManager;
use App\Data\Models\UserModel;
use App\Forms\LoginForm;
use App\Forms\RegisterForm;
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

            if ($request->getMethod() == 'post' && $_SESSION['token'] === $_POST['token']) {
                $loginForm = new LoginForm();
                $body = $request->getBody();
                $loginForm->objectifyForm($body);

                if ($loginForm->validate()) {
                    $user = $this->userManager->findBy(['email' => $loginForm->getEmail()]);
                    if(!$user)
                    {
                        Session::setFlash('error',"L'adresse et/ou le mot de passe est incorrect ");
                        $response->redirect('/login');
                    }
                    if(password_verify($loginForm->getPassword(), $user->getPassword()))
                    {
                        Session::setUserSession($user);
                        Session::setFlash('success', 'Bienvenue '. $user->getUsername());
                        $response->redirect('/',302);

                    } else{
                        // Mauvais mot de passe
                        Session::setFlash('error',"L'adresse et/ou le mot de passe est incorrect " );
                        Application::$app->response->redirect('/login');
                    }
                }
                $errors = $loginForm->getErrors();
                echo $this->render('auth/login.html.twig', compact('errors', 'loginForm'));
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
        if ($request->getMethod() == 'post') {
            $registerForm = new RegisterForm();
            $body = $request->getBody();
            $registerForm->objectifyForm($body);
            if ($registerForm->validate()) {

                $registerModel = new UserModel();
                $registerModel->setFirstname($registerForm->getFirstname());
                $registerModel->setLastname($registerForm->getLastname());
                $registerModel->setUsername($registerForm->getUsername());
                $registerModel->setEmail($registerForm->getEmail());
                $registerModel->setPassword(password_hash($registerForm->getPassword(),PASSWORD_ARGON2I));
                $registerModel->setCreatedAt((new \DateTimeImmutable('now', new \DateTimeZone('Europe/Paris'))));

                $this->userManager->save($registerModel);
                Session::setFlash('success', 'Le compte a bien été enregistré');
                $response->redirect('/');
            }

            $errors = $registerForm->getErrors();
            echo $this->render('auth/register.html.twig', compact('errors', 'registerForm'));
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
//        $response->redirect('/');
    }
}
