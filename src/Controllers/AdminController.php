<?php

namespace App\Controllers;

use App\View\View;
use App\Helper\PathHelper;
use App\Models\Quiz;

class AdminController {
    public function index() {
        $quizModel = new Quiz();
        $quizzes = $quizModel->getAllQuizzes();

        $view = new View(
            PathHelper::view('admin/quizzes.php'),
            PathHelper::layout('admin/admin.php')
        );

        $view->with([
            'title' => 'Admin Page',
            'header' => 'Welcome to admin page',
            'quizzes' => $quizzes
        ])->render();
    }
}