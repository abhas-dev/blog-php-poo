<?php

namespace App;

use Twig\Environment;

class Application
{
    public Router $router;
    public Request $request;
    public Response $response;
    public Session $session;
    public Environment $twig;
    public static Application $app;

    public function __construct(Environment $twig)
    {
        self::$app = $this;
        $this->session = new Session();
        $this->request = new Request();
        $this->response = new Response();
        $this->twig = $twig;
        $this->twig->addGlobal('session', $_SESSION);
        $this->router = new Router($this->request, $this->response);
    }

    public function run()
    {
        echo $this->router->resolve();
    }
}
