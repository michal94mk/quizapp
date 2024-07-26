<?php

namespace App\Models;

use App\Database\Database;

class Quiz {
    private $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->getPdo();
    }
    public function getAllQuizzes() {
        $query = "SELECT * FROM quizzes";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getQuizById($id) {
        $query = "SELECT * FROM quizzes WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function getQuestions($quizId) {
        $query = "SELECT q.id, q.question_text, a.id AS correct_answer_id
                  FROM questions q
                  JOIN answers a ON q.id = a.question_id
                  WHERE q.quiz_id = :quiz_id AND a.is_correct = 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':quiz_id', $quizId);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    public function createQuiz($title, $description) {
        $query = "INSERT INTO quizzes (title, description) VALUES (?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$title, $description]);
    }
}
