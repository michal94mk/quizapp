<?php

use App\Controllers\HomeController;
use App\Controllers\AdminController;
use App\Controllers\AuthController;
use App\Controllers\QuizController;
use App\Controllers\QuestionController;
use App\Middlewares\AdminMiddleware;

$router->get('/about', [HomeController::class, 'about']);

$router->get('/admin', [AdminController::class, 'index']);
$router->paginate('/admin/quizzes', AdminController::class, 'quizzes');
$router->get('/admin/add-quiz-form', [QuizController::class, 'addQuizForm']);
$router->post('/admin/add-quiz', [QuizController::class, 'addQuiz']);
$router->get('/admin/update-quiz-form/{id}', [QuizController::class, 'updateQuizForm']);
$router->post('/admin/update-quiz', [QuizController::class, 'updateQuiz']);
$router->post('/admin/delete-quiz', [QuizController::class, 'deleteQuiz']);

$router->get('/register-form', [AuthController::class, 'showRegisterForm']);
$router->post('/register', [AuthController::class, 'register']);
$router->get('/login-form', [AuthController::class, 'showLoginForm']);
$router->post('/login', [AuthController::class, 'login']);
$router->get('/logout', [AuthController::class, 'logout']);

$router->paginate('/', QuizController::class, 'showAllQuizzes');
$router->get('/quiz/{id}', [QuizController::class, 'showQuiz']);
$router->post('/submit-quiz', [QuizController::class, 'submitQuiz']);
$router->get('/quiz-result/{quiz_id}', [QuizController::class, 'showQuizResult']);

// Definiowanie grupy middleware dla tras zaczynających się od '/admin'
$router->middlewareGroup('/admin', [AdminMiddleware::class]);