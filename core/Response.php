<?php

namespace App;

class Response
{
    public function setStatusCode(int $code)
    {
        http_response_code($code);
    }

    public function redirect(string $url, int $statuscode = 303)
    {
        header('Location: ' . $url,true, $statuscode);
        exit;
    }
}