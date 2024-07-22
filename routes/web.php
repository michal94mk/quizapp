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
$router->get('/login-form', [AuthController::class, 'showLoginForm']);
$router->post('/login', [AuthController::class, 'login']);
$router->get('/logout', [AuthController::class, 'logout']);