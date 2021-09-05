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
            $registerModel->hydrate($body);
            //$registerModel->validate();
            // TODO: Generer formulaire a partir du php
            // TODO: Envoyer l'objet registerModel a la vue pour le generer?
            // TODO: Ou seulement afficher mes erreurs en js
            if ($registerModel->validate() && $this->userManager->save($registerModel)) {
//                Application::$app->session->setFlash('success', 'Thanks for registering');
//                Application::$app->response->redirect('/');
                return 'Show success page';
            }
//            var_dump($registerModel->getErrors());
            $errors = $registerModel->getErrors();
            echo $this->render('auth/register.html.twig', compact('errors'));
        }

        if ($request->getMethod() == 'get'){
            echo $this->render('auth/register.html.twig');
        }
    }
}