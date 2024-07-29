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
            'method' => strtoupper($method),
            'path' => $path,
            'handler' => $handler
        ];
    }

    public function paginate($route, $controllerClass, $methodName) {
        $this->get($route, function() use ($controllerClass, $methodName) {
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $controller = new $controllerClass();
            $controller->$methodName($page);
        });
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

    private function matchRoute($method, $uri, &$params) {
        foreach ($this->routes as $route) {
            if ($route['method'] === strtoupper($method)) {
                $pattern = preg_replace('/\{[^\}]+\}/', '([^/]+)', $route['path']);
                $pattern = '#^' . $pattern . '$#';

                if (preg_match($pattern, $uri, $matches)) {
                    array_shift($matches);
                    $params = $matches;
                    return $route;
                }
            }
        }
        return null;
    }

    public function dispatch($method, $uri) {
        $parsedUrl = parse_url($uri);
        $path = $parsedUrl['path'] ?? $uri;
        $query = $parsedUrl['query'] ?? '';
    
        $params = [];
        parse_str($query, $params);
        
        $routeParams = [];
        $route = $this->matchRoute($method, $path, $routeParams);

    
        if ($route) {
            $handler = function() use ($route, $routeParams, $params) {
                if (is_callable($route['handler'])) {
                    return call_user_func_array($route['handler'], array_merge($routeParams, $params));
                } elseif (is_array($route['handler'])) {
                    [$controller, $method] = $route['handler'];
                    $controllerInstance = new $controller();
                    return call_user_func_array([$controllerInstance, $method], array_merge($routeParams, $params));
                }
            };
    
            $middlewares = $this->getMiddlewares($path);
    
            foreach ($middlewares as $middleware) {
                $middlewareInstance = new $middleware();
                $middlewareInstance->handle($method, $path, $handler);
                return;
            }
    
            return $handler();
        }
    
        http_response_code(404);
        echo "404 Not Found";
    }    
}
