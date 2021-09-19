<?php

namespace App\Controllers;

use App\Request;

class ContactController extends Controller
{

    public function show()
    {
        echo $this->render('general/contact.html.twig');
    }

    public function handleContact(Request $request)
    {
        $body = $request->getBody();
        return 'Traitement des données envoyées';
    }
}