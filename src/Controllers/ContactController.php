<?php

namespace App\Controllers;

class ContactController extends Controller
{

    public function show()
    {
        echo $this->render('general/contact.html.twig');
    }

    public function handleContact()
    {
        return 'Traitement des données envoyées';
    }
}