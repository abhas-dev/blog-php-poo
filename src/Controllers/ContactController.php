<?php

namespace App\Controllers;

use App\Request;

class ContactController extends Controller
{

    public function show()
    {
        echo $this->render('general/contact.html.twig');
    }

    public function handleContact()
    {
        $body = $this->request->getBody();
        var_dump($body);
        return 'Traitement des données envoyées';
    }
}