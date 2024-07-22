<?php

use App\Controllers\HomeController;
use App\Controllers\AdminController;


$router->get('/', [HomeController::class, 'index']);
$router->get('/about', [HomeController::class, 'about']);

$router->get('/admin', [AdminController::class, 'index']);