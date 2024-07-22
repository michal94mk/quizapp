<?php

namespace App\Controllers;

use App\View\View;
use App\Helper\PathHelper;
use App\Models\Quiz;

class HomeController {
    public function index() {
        $quizModel = new Quiz();
        $quizzes = $quizModel->getAllQuizzes();

        $view = new View(
            PathHelper::view('home.php'),
            PathHelper::layout('app.php')
        );

        $view->with([
            'title' => 'Home Page',
            'header' => 'Welcome',
            'quizzes' => $quizzes
        ])->render();
    }

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
}
