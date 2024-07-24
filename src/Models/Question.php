<?php

namespace App\Models;

use App\Database\Database;

class Question {
    private $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->getPdo();
    }

    public function getQuestionByQuizId($quizId) {
        $query = "SELECT * FROM questions WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$quizId]);
        return $stmt->fetch();
    }

    public function createQuestion($quizId, $questionText, $questionType) {
        $query = "INSERT INTO questions (quizId, questionText, questionType) VALUES (?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$quizId, $questionText, $questionType]);
    }
}
