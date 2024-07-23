<?php

namespace App\Middlewares;

class AdminMiddleware {
    public function handle($method, $path, $next) {
        if (isset($_SESSION['user_id']) && $_SESSION['user_role'] === 'admin') {
            return $next();
        } else {
            header('Location: /?message=accessdenied');
            exit();
        }
    }
}
