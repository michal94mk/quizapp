<?php

use App\Controllers\HomeController;
use App\Controllers\AdminController;
use App\Controllers\AuthController;
use App\Controllers\QuizController;
use App\Middlewares\AdminMiddleware;

//$router->get('/', [HomeController::class, 'index']);
$router->get('/about', [HomeController::class, 'about']);

$router->get('/admin', [AdminController::class, 'index']);
$router->get('/admin/quizzes', [AdminController::class, 'quizzes']);

$router->get('/register-form', [AuthController::class, 'showRegisterForm']);
$router->post('/register', [AuthController::class, 'register']);
$router->get('/login-form', [AuthController::class, 'showLoginForm']);
$router->post('/login', [AuthController::class, 'login']);
$router->get('/logout', [AuthController::class, 'logout']);

$router->get('/', [QuizController::class, 'showAllQuizzes']);
$router->get('/quiz/{id}', [QuizController::class, 'showQuiz']);
$router->post('/submit-quiz', [QuizController::class, 'submitQuiz']);
$router->get('/quiz-result/{quiz_id}', [QuizController::class, 'showQuizResult']);


// Definiowanie grupy middleware dla tras zaczynających się od '/admin'
$router->middlewareGroup('/admin', [AdminMiddleware::class]);