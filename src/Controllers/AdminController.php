<?php

namespace App\Controllers;

use App\View\View;
use App\Helper\PathHelper;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\User;

class AdminController {
    public function index() {
        $userModel = new User();
        $totalUsers = $userModel->getUserCount();

        $quizModel = new Quiz();
        $totalQuizzes = $quizModel->getQuizCount();

        $questionModel = new Question();
        $totalQuestions = $questionModel->getQuestionCount();

        $recentQuizzes = $quizModel->getRecentQuizzes(5);

        $view = new View(
            PathHelper::view('admin/dashboard.php'),
            PathHelper::layout('admin/admin.php')
        );

        $view->with([
            'totalUsers' => $totalUsers,
            'totalQuizzes' => $totalQuizzes,
            'totalQuestions' => $totalQuestions,
            'recentQuizzes' => $recentQuizzes
        ])->render();
    }

    public function quizzes($page) {
        $quizModel = new Quiz();
        $quizzesPerPage = 12;
        $offset = ($page - 1) * $quizzesPerPage;
        $quizzes = $quizModel->getAllQuizzesPaginated($quizzesPerPage, $offset);
        $totalQuizzes = $quizModel->getQuizCount();
        $totalPages = ceil($totalQuizzes / $quizzesPerPage);

        $view = new View(
            PathHelper::view('admin/quizzes/quizzes.php'),
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