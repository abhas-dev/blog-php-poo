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
        $errors = [];
        $registerModel = new UserModel();

        if ($request->getMethod() == 'post') {
            $body = $request->getBody();
            // TODO: Validation
            // TODO: check password and confirmation
            unset($body['confirmationPassword']);
            $registerModel->hydrate($body);
            if ($registerModel->validate() && $this->userManager->save($registerModel)) {
//                Application::$app->session->setFlash('success', 'Thanks for registering');
//                Application::$app->response->redirect('/');
                return 'Show success page';
            }
            var_dump($registerModel);
            echo 'Show success page';
        }
        echo $this->render('auth/register.html.twig', compact('errors'));
    }
}