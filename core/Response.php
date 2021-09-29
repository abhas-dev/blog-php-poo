<?php

namespace App;

class Response
{
    public function setStatusCode(int $code): void
    {
        http_response_code($code);
    }

    public function redirect(string $url, int $statuscode = 303): void
    {
        header('Location: ' . $url,true, $statuscode);
        exit;
    }
}