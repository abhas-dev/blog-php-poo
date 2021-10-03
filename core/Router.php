<?php

namespace App;

use Exception;
use Twig\Environment;

class Router
{
    public Request $request;
    public Response $response;
    private string $path;
    private array $routes = [];

    /**
     * @param Request $request
     * @param Response $response
     */
    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
        $this->path = $this->request->getUri();
    }


    public function get($path, $action)
    {
        // On push la route dans l'array des routes
        $route = new Route($path, $action);
        $this->routes['get'][] = $route;
        //this->routes['get'][$path] =$action;
    }

    // On push la route dans l'array des routes
    public function post($path, $action)
    {
        $route = new Route($path, $action);
        $this->routes['post'][] = $route;
//        $this->routes['post'][$path] = $action;
    }

    public function getRouteByRequest()
    {
        // Pour chaque route, on teste si elle correspond à la requête, si oui alors on renvoie cette route
        foreach($this->routes[$this->request->getMethod()] as $route) {
            if($route->match($this->path)){
                return $route;
            }
        }
        // Appel du controlleur pour la 404 qui doit etre la derniere route de la liste.
        return end($this->routes['get']);
    }

    /**
     * Analyse et traite la requete en trouvant le path et la methode pour diriger sur la bonne route
     * $method: Verbe HTTP
     * $path: Chemin dans l'url exemple /contact, /posts...
     *
     */
    public function resolve()
    {
        $method = $this->request->getMethod();

        if(!$this->routes[$method])
        {
            throw new RouterException("Aucun verbe ne correspond à cette requete !");
        }
        // On récupère la route correspondant à la requête
        $route = $this->getRouteByRequest();
        // On appelle dynamiquement le controlleur
        $route->call($route, $this->request, $this->response);

//        // Soit ca, On test si notre route se trouve dans l'array des routes sinon on renvoi false
//       $route = $this->routes[$method][$path] ?? false;
    }
}