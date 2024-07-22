<?php

namespace App\Controllers;

use App\Models\User;
use App\Helper\PathHelper;
use App\View\View;

class AuthController {
    public function showRegisterForm() {
        $view = new View(
            PathHelper::view('register.php'),
            PathHelper::layout('app.php'),
        );

        $view->with([
            'title' => 'Admin Page',
        ])->render();
    }

    public function register() {
        // Sprawdza, czy dane są przesyłane metodą POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            $email = $_POST['email'] ?? '';

            // Tworzy instancję modelu użytkownika
            $user = new User();
            $message = $user->register($username, $password, $email);

            // Wyświetla odpowiedni widok na podstawie wyniku rejestracji
            if ($message === 'Registration successful.') {
                $view = new View(PathHelper::view('register_success.php'));
                $view->with(['username' => htmlspecialchars($username)])->render();
            } else {
                $view = new View(PathHelper::view('register.php'));
                $view->with(['error' => $message])->render();
            }
        } else {
            http_response_code(405);
            echo "Method Not Allowed";
        }
    }
}
