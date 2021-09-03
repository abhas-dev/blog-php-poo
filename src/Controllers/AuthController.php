<?php

namespace App\Controllers;

use App\Data\Managers\UserManager;
use App\Data\Models\UserModel;
use App\Request;

class AuthController extends Controller
{
    private UserManager $userManager;

    public function __construct()
    {
        parent::__construct();
        $this->userManager = new UserManager();
    }

    public function login()
    {
        echo $this->render('auth/login.html.twig');
    }

    public function register(Request $request)
    {
        $registerModel = new UserModel();

        if ($request->getMethod() == 'post') {
            $body = $request->getBody();
            // TODO: Validation
            // TODO: check password and confirmation
            $registerModel->hydrate($body);
            //$registerModel->validate();
            if ($registerModel->validate() && $this->userManager->save($registerModel)) {
//                Application::$app->session->setFlash('success', 'Thanks for registering');
//                Application::$app->response->redirect('/');
                return 'Show success page';
            }
//            var_dump($registerModel->getErrors());
            $errors = $registerModel->getErrors();
            echo $this->render('auth/register.html.twig', compact('errors'));
        }
        //echo $this->render('auth/register.html.twig', compact('registerModel'));
    }
}