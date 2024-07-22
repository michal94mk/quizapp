<?php

namespace App\Controllers;

use App\View\View;
use App\Helper\PathHelper;

class HomeController {
    public function index() {
        $view = new View(
            PathHelper::view('home.php'),
            PathHelper::layout('app.php')
        );

        $view->with([
            'title' => 'Home Page',
            'header' => 'Welcome',
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
        ])->render();
    }
}
