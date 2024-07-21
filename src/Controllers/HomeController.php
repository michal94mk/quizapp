<?php

namespace App\Controllers;

class HomeController
{
    public function index()
    {
        echo 'this is index function';
        // $data = [
        //     'title' => 'Witaj na stronie głównej',
        //     'content' => 'To jest treść strony głównej.',
        // ];

        // $this->loadView('app', $data);
    }

    public function about()
    {
        echo 'this is about function';
    }

    // private function loadView($viewName, $data)
    // {
    //     extract($data);
    //     require "src/Views/layouts/{$viewName}.php";
    // }
}
