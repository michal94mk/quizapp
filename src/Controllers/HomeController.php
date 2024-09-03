<?php

namespace App\Controllers;

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
}
