<?php

namespace App\Controllers;

use App\Models\User;
use App\Helper\PathHelper;
use App\View\View;

class AuthController {
    public function showRegisterForm() {
        $view = new View(
            PathHelper::view('register.php'),
            PathHelper::layout('app.php')
        );

        $error = $_SESSION['register_error'] ?? null;
        $success = $_SESSION['register_success'] ?? null;

        $view->with([
            'title' => 'Register',
            'error' => $error,
            'success' => $success
        ])->render();

        unset($_SESSION['register_error']);
        unset($_SESSION['register_success']);
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            $email = $_POST['email'] ?? '';

            $user = new User();
            $message = $user->register($username, $password, $email);

            if ($message === 'Registration successful.') {
                $_SESSION['register_success'] = 'Registration successful. You can now log in.';
            } elseif ($message === 'Username already exists.') {
                $_SESSION['register_error'] = 'Username already exists.';
            } elseif ($message === 'Email already exists.') {
                $_SESSION['register_error'] = 'Email already exists.';
            } else {
                $_SESSION['register_error'] = $message;
            }
            
            header('Location: /register-form');
            exit();
        } else {
            http_response_code(405);
            echo "Method Not Allowed";
        }
    }

    public function showLoginForm() {
        if (isset($_SESSION['user_id'])) {
            header('Location: /');
            exit();
        }

        $view = new View(
            PathHelper::view('login.php'),
            PathHelper::layout('app.php')
        );
        $view->render();
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            $user = new User();
            $message = $user->login($username, $password);

            if ($message === 'Login successful.') {
                $_SESSION['user_id'] = $username;
                $_SESSION['login_message'] = 'Logged in successfully.';
                header('Location: /');
            } else {
                $_SESSION['login_error'] = $message;
                header('Location: /login-form');
            }
            exit();
        } else {
            http_response_code(405);
            echo "Method Not Allowed";
        }
    }

    public function logout() {
        session_unset();
        session_destroy();
    
        header('Location: /?message=loggedout');
        exit();
    }
}
