<?php

namespace App\Controllers;

use App\Forms\ContactForm;
use App\Request;
use App\Response;
use App\Session;

class ContactController extends Controller
{
    public function handleContact(Request $request, Response $response)
    {
        $body = $request->getBody();
        $contactForm = new ContactForm();
        $contactForm->objectifyForm($body);
        if ($contactForm->validate())
        {
            // envoi du mail ici
            Session::setFlash('success', 'Le message a été envoyé avec succes');
            $response->redirect('/', 302);
        }
        $errors = $contactForm->getErrors();
        echo $this->render('general/home.html.twig', compact('errors', 'contactForm'));
    }

}