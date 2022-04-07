<?php

declare(strict_types=1);

namespace App\Routing;

use App\Controller\Error404;
use App\Controller\Words;
use App\Controller\Controller;


class Router 
{
    private array $routes = [
        '/' => Words::class,
        '/404' => Error404::class,
    ];

    private string $path;

    private ?Router $router = null;

    public function __construct()
    {
        $this->path = $_SERVER['PATH_INFO'] ?? '/';
    }

    // public function getFromGlobals(): Router
    // {
    //     if (self::$router === null) {
    //         self::$router = new self();
    //     }

    //     return self::$router;
    // }
    public function getController(): void
    {
        $controllerClass = $this->routes[$this->path] ?? $this->routes['/404'];
        //$controllerClass = $this->routes[self::$path] ?? $this->routes['/404'];

        $controller = new $controllerClass();

        if (!$controller instanceof Controller) {
            throw new \LogicException("controller $controllerClass should implement " . Controller::class);
        }

        $controller->render();
    }

    
}
