<?php

namespace App;

use Exception;
use Twig\Environment;

class Router
{
    public Request $request;
    public Response $response;
    private array $routes = [];
    private string $controller;
    private string $action;

    /**
     * @param Request $request
     * @param Response $response
     */
    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }


    public function get($path, $action)
    {
        // On push la route dans l'array des routes
        $route = new Route($path, $action);
        $this->routes['get'][$path] = $action;
    }

    // On push la route dans l'array des routes
    public function post($path, $action)
    {
        $route = new Route($path, $action);
        $this->routes['post'][$path] = $action;
    }

    /**
     * Analyse et traite la requete en trouvant le path et la methode pour diriger sur la bonne route
     * $method: Verbe HTTP
     * $path: Chemin dans l'url exemple /contact, /posts...
     *
     */
    public function resolve()
    {
        $path = $this->request->getPath();
        $method = $this->request->getMethod();

        if(!$method)
        {
            throw new RouterException("Cette route n'existe pas !");

        }

        // On test si notre route se trouve dans l'array des routes sinon on renvoi false
        $route = $this->routes[$method][$path] ?? false;

        // Sinon on soulève une erreur
        if($route === false){
            $this->response->setStatusCode(404);
            throw new RouterException("Cette route n'existe pas !");
        }

        $this->controller = $route[0];
        $this->action = $route[1];
        return $this->call();
    }

//    public function match($requestUri)
//    {
//        // On génère un nouveau chemin en remplaçant les paramètres par des regexp
//        $path = preg_replace_callback("/:(\w+)/", [$this, "parameterMatch"], $this->path);
//        // On échappe chaque "/" pour que notre regexp puisse reconnaître le "/"
//        $path = str_replace("/","\/", $path);
//        // Si notre requete actuelle ne correspond pas à la regexp alons on renvoie false
//        if(!preg_match("/^$path$/i", $requestUri, $matches)){
//            return false;
//        }
//        // Sinon on remplit notre tableau d'arguments avec les valeurs de chaque paramètre de notre route
//        $this->args = array_slice($matches,1);
//        $defaultsArgs = array_keys($this->defaults);
//        foreach($this->args as $key => &$value) {
//            $index = array_search($key,$defaultsArgs);
//            if($index !== FALSE && $value === ""){
//                $value = $this->defaults[$defaultsArgs[$index]];
//            }
//        }
//        return true;
//    }

    /**
     * Instancie le controller et execute la fonction necessaire
     *
     * @return false|mixed
     */
    public function call()
    {
        $controller = $this->controller;
        // On instancie dynamiquement le contrôleur
        $controller = new $controller();
        // call_user_func_array permet d'appeler une méthode d'une classe et de lui passer des arguments
        return call_user_func([$controller, $this->action], $this->request);
    }


}