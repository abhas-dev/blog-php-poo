<?php

namespace App;

use Exception;
use Twig\Environment;

class Router
{
    public Request $request;
    public Response $response;
    protected array $routes = [];
    private string $controller;
    private string $action;
    private array $args = [];

    /**
     * @param Request $request
     */
    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    // On push la route dans l'array des routes
    public function get($path, $route)
    {
        $this->routes['get'][$path] = $route;
    }

    // On push la route dans l'array des routes
    public function post($path, $route)
    {
        $this->routes['post'][$path] = $route;
    }

    /**
     * Analyse et traite la requete en trouvant le path et la methode pour diriger sur la bonne route
     * $method: Verbe HTTP
     * $path: Chemin dans l'url exemple /contact, /posts...
     *
     * @return mixed
     */
    public function resolve(): mixed
    {
        $path = $this->request->getPath();
        $method = $this->request->getMethod();
        // On test si notre route se trouve dans l'array des routes sinon on renvoi false
        $route = $this->routes[$method][$path] ?? false;

        // Sinon on soulève une erreur
        if($route === false){
            $this->response->setStatusCode(404);
            // A finir
            throw new Exception("Cette route n'existe pas !");
        }
        $this->controller = $route[0];
        $this->action = $route[1];

        return $this->call();
    }

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

        return call_user_func_array([$controller, $this->action], $this->args);
    }


}