<?php

namespace App\Controllers;

use App\Forms\ContactForm;
use App\Mails\ContactMail;
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
        if ($contactForm->validate()) {
            $mail = new ContactMail();
            $mail->setSubject($contactForm->getSubject());
            $mail->setFrom($contactForm->getEmail());
            $mail->setMessage($contactForm->getMessage());
            try {
                $mail->sendMail();
                Session::setFlash('success', 'Le message a été envoyé avec succes');
                $response->redirect('/', 302);
            } catch (\Exception $e) {
                if ($_ENV['ENV'] === 'dev') {
                    echo $e;
                    die();
                } elseif ($_ENV['ENV'] === 'prod') {
                    Session::setFlash('error', "Une erreur interne s'est produite");
                    $response->redirect('/');
//                $this->render('/general/_500.html.twig');
                }
            }
        }
        $errors = $contactForm->getErrors();
        $this->render('general/home.html.twig', compact('errors', 'contactForm'));
    }
}
