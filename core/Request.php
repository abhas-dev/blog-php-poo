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
        //$this->bootstrapSelf();
    }

//    private function bootstrapSelf()
//    {
//        // Quid des performances de cette methode?
//        foreach($_SERVER as $key => $value)
//        {
//            $this->{$this->toCamelCase($key)} = $value;
//        }
//    }

    public function getUri()
    {
        return $this->server["REQUEST_URI"];
    }

    public function getCookie()
    {
        return $_COOKIE;
    }

    public function setCookie($key, $value, $exp)
    {
        setcookie($key, $value, $exp);
    }

    /**
     * @return array
     */
    public function getSession()
    {
        return $_SESSION;
    }

    public function setSession($key, $value)
    {
        $_SESSION[$key] = $value;
    }

//    private function toCamelCase(string $string): string
//    {
//        $result = strtolower($string);
//
//        preg_match_all('/_[a-z]/', $result, $matches);
//
//        foreach($matches[0] as $match)
//        {
//            $c = str_replace('_', '', strtoupper($match));
//            $result = str_replace($match, $c, $result);
//        }
//
//        return $result;
//    }

//    /**
//     * Recupere le chemin demandé dans la requete sans les params
//     *
//     * @return string
//     */
//    public function getPath(): string
//    {
//        return $this->getUri();
////        $position = strpos($path, '?');
////        if($position === false){
////            return $path;
////        }
////
////        return substr($path, 0, $position);
//    }

    /**
     * Recupere la methode HTTP de la requete
     *
     * @return string
     */
    public function getMethod(): string
    {
        return strtolower($this->server['REQUEST_METHOD']);
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


}