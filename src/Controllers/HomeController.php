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

    public function showTop10Results($page = 1) {
        $resultModel = new UserQuizResult();
        $quizModel = new Quiz();
        $limit = 10;
        $offset = ($page - 1) * $limit;
        $totalResults = $resultModel->getResultCount();
        $totalPages = ceil($totalResults / $limit);
        
        $quizzes = $quizModel->getAllQuizzes();
        
        $selectedQuizId = isset($_GET['quiz_id']) ? $_GET['quiz_id'] : null;
    
        if ($selectedQuizId) {
            $results = $resultModel->getTop10ResultsForQuiz($selectedQuizId);
        } else {
            $results = $resultModel->getTop10BestResults($limit, $offset);
        }
    
        $view = new View(
            PathHelper::view('all_best_results.php'),
            PathHelper::layout('app.php')
        );
        
        $view->with([
            'title' => 'All Best Results',
            'results' => $results,
            'quizzes' => $quizzes,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'selectedQuizId' => $selectedQuizId
        ])->render();
    }

    public function showTop10ResultsForQuiz() {
        $resultModel = new UserQuizResult();
        $quizModel = new Quiz();
    
        $quizId = isset($_GET['quiz_id']) ? $_GET['quiz_id'] : null;
    
        if (!$quizId) {
            throw new \Exception('Quiz not selected.');
        }
    
        $results = $resultModel->getTop10ResultsForQuiz($quizId);
    
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
