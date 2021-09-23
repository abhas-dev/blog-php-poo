<?php

namespace App;

class Route
{
    private string $path;
    private array $action;
    private array $params;

    public function __construct(string $path, array $action)
    {
        $this->path = trim($path, '/');
        $this->action = $action;
    }

    /**
     * On test si la route match avec l'URI
     *
     * @param string $requestUri
     * @return bool
     */
    public function match(string $requestUri): bool
    {
        $uri = trim($requestUri, '/');
        // Analyse $this->path(dans le lien donné au routeur) pour trouver pattern et remplacer par replacement
        // : suivi de nimporte quel caractere numerique repeté plusieurs fois, remplacé par nimporte quoi qui ne soit pas un /
        $path = preg_replace('#:([\w]+)#', '([^/]+)', $this->path);
        // On transforme le path en regex
        $pathToMatch = "#^$path$#i";
        // Si notre requete actuelle ne correspond pas à la regexp alons on renvoie false
        if(!preg_match($pathToMatch, $uri,$matches)){
           return false;
        }
        array_shift($matches);
        $this->params = $matches;
        return true;
    }

    /**
     * @param Route $route
     * @return false|mixed
     */
    public function call(self $route, Request $request, Response $response)
    {

        $controller = $this->action[0];
        $action = $this->action[1];
        // On instancie dynamiquement le contrôleur
        $controller = new $controller();
        $this->params[] = $request;
        // call_user_func_array permet d'appeler une méthode d'une classe et de lui passer des arguments
        return call_user_func_array([$controller, $action], $this->params);
    }


}