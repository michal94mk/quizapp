<?php

namespace App;

use App\Router\Router;

class App {
    private $router;

    public function __construct() {
        $this->router = new Router();
        $this->loadRoutes();
    }

    private function loadRoutes() {
        $router = $this->router;
        require __DIR__ . '/../routes/web.php';
    }

    public function run() {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $this->router->dispatch($method, $uri);
    }
}
