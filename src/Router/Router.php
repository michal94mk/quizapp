<?php

namespace App\Router;

class Router {
    private $routes = [];
    private $middlewareGroups = [];

    public function get($path, $handler) {
        $this->addRoute('GET', $path, $handler);
    }

    public function post($path, $handler) {
        $this->addRoute('POST', $path, $handler);
    }

    private function addRoute($method, $path, $handler) {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'handler' => $handler
        ];
    }

    public function middlewareGroup($groupName, $middlewareArray) {
        $this->middlewareGroups[$groupName] = $middlewareArray;
    }

    private function getMiddlewares($path) {
        foreach ($this->middlewareGroups as $prefix => $middlewares) {
            if (strpos($path, $prefix) === 0) {
                return $middlewares;
            }
        }
        return [];
    }

    public function dispatch($method, $uri) {
        foreach ($this->routes as $route) {
            if ($route['method'] === $method && $route['path'] === $uri) {
                $middlewares = $this->getMiddlewares($uri);

                $handler = function() use ($route) {
                    if (is_callable($route['handler'])) {
                        return call_user_func($route['handler']);
                    } elseif (is_array($route['handler'])) {
                        [$controller, $method] = $route['handler'];
                        $controllerInstance = new $controller();
                        return call_user_func([$controllerInstance, $method]);
                    }
                };

                foreach ($middlewares as $middleware) {
                    $middlewareInstance = new $middleware();
                    $middlewareInstance->handle($method, $uri, $handler);
                    return; // Middleware handles the response
                }

                // If no middleware, directly call the route handler
                return $handler();
            }
        }
        http_response_code(404);
        echo "404 Not Found";
    }
}
