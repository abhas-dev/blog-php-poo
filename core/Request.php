<?php

namespace App;

class Request
{

    public function __construct()
    {
        $this->bootstrapSelf();
    }

    private function bootstrapSelf()
    {
        // Quid des performances de cette methode?
        foreach($_SERVER as $key => $value)
        {
            $this->{$this->toCamelCase($key)} = $value;
        }
    }

    private function toCamelCase(string $string): string
    {
        $result = strtolower($string);

        preg_match_all('/_[a-z]/', $result, $matches);

        foreach($matches[0] as $match)
        {
            $c = str_replace('_', '', strtoupper($match));
            $result = str_replace($match, $c, $result);
        }

        return $result;
    }

    /**
     * Recupere le chemin demandé dans la requete sans les params
     *
     * @return string
     */
    public function getPath(): string
    {
        var_dump($this->requestUri);
        $path = $this->requestUri ?? '/';
        $position = strpos($path, '?');
        if($position === false){
            return $path;
        }

        return substr($path, 0, $position);
    }

    /**
     * Recupere la methode HTTP de la requete
     *
     * @return string
     */
    public function getMethod(): string
    {
        return strtolower($this->requestMethod);
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