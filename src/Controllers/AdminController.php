<?php

namespace App\Controllers;

use App\View\View;
use App\Helper\PathHelper;
use App\Models\Quiz;

class AdminController {

    public function index() {
        $view = new View(
            PathHelper::layout('admin/admin.php')
        );

        $view->with([
            'title' => 'Admin Page',
        ])->render();
    }

    public function quizzes() {
        $quizModel = new Quiz();
        $quizzes = $quizModel->getAllQuizzes();

        $view = new View(
            PathHelper::view('admin/quizzes.php'),
            PathHelper::layout('admin/admin.php')
        );

        $view->with([
            'title' => 'Quizzes',
            'quizzes' => $quizzes
        ])->render();
    }
}