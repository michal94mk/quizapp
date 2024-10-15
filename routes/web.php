<?php

use App\Controllers\HomeController;
use App\Controllers\AdminController;
use App\Controllers\AuthController;
use App\Controllers\UserController;
use App\Controllers\QuizController;
use App\Controllers\QuestionController;
use App\Controllers\AnswerController;
use App\Middlewares\AdminMiddleware;

$router->get('/about', [HomeController::class, 'about']);
$router->get('/best-results/all', [HomeController::class, 'showTop10Results']);
$router->get('/best-results/quiz/', [HomeController::class, 'showTop10ResultsForQuiz']);

$router->get('/admin', [AdminController::class, 'index']);
$router->paginate('/admin/quizzes', AdminController::class, 'quizzes');
$router->get('/admin/add-quiz-form', [QuizController::class, 'addQuizForm']);
$router->post('/admin/add-quiz', [QuizController::class, 'addQuiz']);
$router->get('/admin/update-quiz-form/{id}', [QuizController::class, 'updateQuizForm']);
$router->post('/admin/update-quiz', [QuizController::class, 'updateQuiz']);
$router->post('/admin/delete-quiz', [QuizController::class, 'deleteQuiz']);

$router->paginate('/admin/questions', QuestionController::class, 'showAllQuestions');
$router->get('/admin/add-question-form', [QuestionController::class, 'addQuestionForm']);
$router->post('/admin/add-question', [QuestionController::class, 'addQuestion']);
$router->get('/admin/update-question-form/{id}', [QuestionController::class, 'updateQuestionForm']);
$router->post('/admin/update-question', [QuestionController::class, 'updateQuestion']);
$router->post('/admin/delete-question', [QuestionController::class, 'deleteQuestion']);

$router->get('/admin/answers/{id}', [AnswerController::class, 'getAnswersForQuestion']);
$router->get('/admin/add-answer-form/{id}', [AnswerController::class, 'addAnswerForm']);
$router->post('/admin/add-answer', [AnswerController::class, 'addAnswer']);
$router->get('/admin/update-answer-form/{id}', [AnswerController::class, 'updateAnswerForm']);
$router->post('/admin/update-answer', [AnswerController::class, 'updateAnswer']);
$router->post('/admin/delete-answer', [AnswerController::class, 'deleteAnswer']);

$router->paginate('/admin/users', UserController::class, 'showAllUsers');
$router->get('/admin/add-user-form', [UserController::class, 'addUserForm']);
$router->post('/admin/add-user', [UserController::class, 'addUser']);
$router->get('/admin/update-user-form/{id}', [UserController::class, 'updateUserForm']);
$router->post('/admin/update-user', [UserController::class, 'updateUser']);
$router->post('/admin/delete-user', [UserController::class, 'deleteUser']);

$router->get('/register-form', [AuthController::class, 'showRegisterForm']);
$router->post('/register', [AuthController::class, 'register']);
$router->get('/login-form', [AuthController::class, 'showLoginForm']);
$router->post('/login', [AuthController::class, 'login']);
$router->get('/logout', [AuthController::class, 'logout']);

$router->paginate('/', QuizController::class, 'showAllQuizzesPaginated');
$router->get('/quiz/{id}', [QuizController::class, 'showQuiz']);
$router->post('/submit-quiz', [QuizController::class, 'submitQuiz']);
$router->get('/quiz-result/{id}', [QuizController::class, 'showQuizResult']);

// Definiowanie grupy middleware dla tras zaczynających się od '/admin'
$router->middlewareGroup('/admin', [AdminMiddleware::class]);