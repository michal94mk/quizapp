<?php

namespace App\Controllers;

use App\View\View;
use App\Helper\PathHelper;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\User;
use App\Models\UserQuizResult;

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

        public function stats() {
            $userModel = new User();
            $quizModel = new Quiz();
            $userQuizResultModel = new UserQuizResult();
    
            $userStats = $userModel->getRoleCounts();
    
            $quizStats = $quizModel->getQuizStats();
    
            $topQuizzes = $quizModel->getTopQuizzes(5);
    
            $dailyCompletions = $userQuizResultModel->getDailyQuizCompletions();
    
            $recentResults = $userQuizResultModel->getRecentQuizResults(5);
            $userAnswers = $userQuizResultModel->getUserAnswerStats();
            $quizPerformance = $quizModel->getQuizPerformance();
            $questionStats = $userQuizResultModel->getQuestionStats();
    
            $view = new View(
                PathHelper::view('admin/stats.php'),
                PathHelper::layout('admin/admin.php')
            );
    
            $view->with([
                'userStats' => $userStats,
                'quizStats' => $quizStats,
                'topQuizzes' => $topQuizzes,
                'dailyCompletions' => $dailyCompletions,
                'recentResults' => $recentResults,
                'userAnswers' => $userAnswers,
                'quizPerformance' => $quizPerformance,
                'questionStats' => $questionStats
            ])->render();
        }
}
