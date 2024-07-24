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
        return $stmt->fetch();
    }

    public function createQuiz($title, $description) {
        $query = "INSERT INTO quizzes (title, description) VALUES (?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$title, $description]);
    }
}
