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

    public function getQuestionsByQuizId($quizId) {
        $stmt = $this->conn->prepare("SELECT * FROM questions WHERE quiz_id = ?");
        $stmt->execute([$quizId]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    public function createQuestion($quizId, $questionText, $questionType) {
        $query = "INSERT INTO questions (quizId, questionText, questionType) VALUES (?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$quizId, $questionText, $questionType]);
    }
}
