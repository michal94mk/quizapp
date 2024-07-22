<?php

namespace App\Models;

use App\Database\Database;

class Quiz {
    private $pdo;

    public function __construct() {
        $this->pdo = (new Database())->getPdo();
    }

    public function getAllQuizzes() {
        $stmt = $this->pdo->query('SELECT * FROM quizzes');
        $quizzes = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $quizzes;
    }
}
