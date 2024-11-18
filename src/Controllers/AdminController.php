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
}