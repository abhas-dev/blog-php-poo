<?php

namespace App;

class Request
{
    private array $post;
    private array $get;
    private array $files;
    private array $request;
    private array $server;

    public function __construct()
    {
        $this->post = $_POST;
        $this->get = $_GET;
        $this->files = $_FILES;
        $this->request = $_REQUEST;
        $this->server = $_SERVER;
    }

    public function getUri()
    {
        return $this->server["REQUEST_URI"];
    }

    /**
     * Recupere la methode HTTP de la requete
     *
     * @return string
     */
    public function getMethod(): string
    {
        return strtolower($this->server['REQUEST_METHOD']);
    }

    public function getCookie()
    {
        return $_COOKIE;
    }

    public function getBody(): array
    {
        $body = [];
        if($this->getMethod() === 'get'){
            foreach ($_GET as $key => $value){
                $body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
        if($this->getMethod() === 'post'){
            foreach ($_POST as $key => $value){
                $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }

        return $body;
    }

    public function getReferer()
    {
        return $this->server['HTTP_REFERER'];
    }
}
//
//    public function setCookie($key, $value, $exp)
//    {
//        setcookie($key, $value, $exp);
//    }
//

//
//    public function isGet(): bool
//    {
//        return $this->getMethod() === 'get';
//    }
//
//    public function isPost(): bool
//    {
//        return $this->getMethod() === 'post';
//    }
