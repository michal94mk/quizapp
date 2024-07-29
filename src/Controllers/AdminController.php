<?php

namespace App\Controllers;

use App\View\View;
use App\Helper\PathHelper;
use App\Models\Quiz;
use App\Models\Question;


class AdminController {
    public function index() {
        $view = new View(
            PathHelper::layout('admin/admin.php')
        );

        $view->with([
            'title' => 'Admin Page',
        ])->render();
    }

    public function quizzes($page) {
        $quizModel = new Quiz();
        $quizzesPerPage = 10;
        $offset = ($page - 1) * $quizzesPerPage;
        $quizzes = $quizModel->getAllQuizzes($quizzesPerPage, $offset);
        $totalQuizzes = $quizModel->getQuizCount();
        $totalPages = ceil($totalQuizzes / $quizzesPerPage);

        $view = new View(
            PathHelper::view('admin/quizzes.php'),
            PathHelper::layout('admin/admin.php')
        );

        $view->with([
            'title' => 'List of Quizzes',
            'quizzes' => $quizzes,
            'currentPage' => $page,
            'totalPages' => $totalPages
        ])->render();
    }
}