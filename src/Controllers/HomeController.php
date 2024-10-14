<?php

namespace App\Controllers;

use App\Models\UserQuizResult;
use App\Models\Quiz;
use App\View\View;
use App\Helper\PathHelper;

class HomeController {

    public function about() {
        $view = new View(
            PathHelper::view('about.php'),
            PathHelper::layout('app.php')
        );

        $view->with([
            'title' => 'About Us',
            'header' => 'About Us',
            'content' => 'This is the about page.'
        ])->render();
    }

    public function showAllBestResults() {
        $resultModel = new UserQuizResult();
        $quizModel = new Quiz();
        
        $quizzes = $quizModel->getAllQuizzes();
        
        $selectedQuizId = isset($_GET['quiz_id']) ? $_GET['quiz_id'] : null;
    
        if ($selectedQuizId) {
            $results = $resultModel->getBestResultsForQuiz($selectedQuizId);
        } else {
            $results = $resultModel->getAllBestResults();
        }
    
        $view = new View(
            PathHelper::view('all_best_results.php'),
            PathHelper::layout('app.php')
        );
        
        $view->with([
            'title' => 'All Best Results',
            'results' => $results,
            'quizzes' => $quizzes,
            'selectedQuizId' => $selectedQuizId
        ])->render();
    }

    public function showBestResultsForQuiz() {
        $resultModel = new UserQuizResult();
        $quizModel = new Quiz();
    
        $quizId = isset($_GET['quiz_id']) ? $_GET['quiz_id'] : null;
    
        if (!$quizId) {
            throw new \Exception('Quiz not selected.');
        }
    
        $results = $resultModel->getBestResultsForQuiz($quizId);
    
        $quiz = $quizModel->getQuizById($quizId);
        if (!$quiz) {
            throw new \Exception('Quiz not found.');
        }
        $quizTitle = $quiz['title'];
    
        $view = new View(
            PathHelper::view('quiz_best_results.php'),
            PathHelper::layout('app.php')
        );
        
        $view->with([
            'title' => 'Best Results for Quiz',
            'results' => $results,
            'quizTitle' => $quizTitle
        ])->render();
    }    
}
