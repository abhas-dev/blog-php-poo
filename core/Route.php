<?php

namespace App;

class Route
{
    private string $path;
    private array $action;

    public function __construct(string $path, array $action)
    {
        $this->path = trim($path, '/');
        $this->action = $action;
    }

    public function match(string $url)
    {
        $path = preg_replace('#:([\w]+)#', '([^/]+)', $this->path);
        $pathToMatch = "#^$path$#";
    }
}