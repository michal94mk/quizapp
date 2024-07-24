<?php

namespace App\Models;

use App\Database\Database;

class Answer {
    private $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->getPdo();
    }

    public function getQuestionByQuestionId($questionId) {
        $query = "SELECT * FROM questions WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$questionId]);
        return $stmt->fetch();
    }

    public function createQuestion($questionId, $answerText, $isCorrect) {
        $query = "INSERT INTO questions (title, description) VALUES (?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$questionId, $answerText, $isCorrect]);
    }
}
