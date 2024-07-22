<?php

use App\Controllers\HomeController;
use App\Controllers\AdminController;
use App\Controllers\AuthController;


$router->get('/', [HomeController::class, 'index']);
$router->get('/about', [HomeController::class, 'about']);

$router->get('/admin', [AdminController::class, 'index']);
$router->get('/admin/quizzes', [AdminController::class, 'quizzes']);

$router->get('/register-form', [AuthController::class, 'showRegisterForm']);
$router->post('/register', [AuthController::class, 'register']);