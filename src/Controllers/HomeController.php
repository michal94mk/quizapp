<?php

namespace App\Controllers;

class HomeController
{
    public function index()
    {
        $data = [
            'title' => 'Witaj na stronie głównej',
            'content' => 'To jest treść strony głównej.',
        ];

        $this->loadView('home', $data);
    }

    private function loadView($viewName, $data)
    {
        extract($data);
        require "src/Views/{$viewName}.php";
    }
}