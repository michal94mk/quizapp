<?php

namespace App\Models;

use App\Database\Database;

class Question {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getPdo();
    }

    public function create($quizId, $questionText, $questionType) {
        $query = "INSERT INTO questions (quiz_id, question_text, question_type) VALUES (:quiz_id, :question_text, :question_type)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':quiz_id', $quizId, \PDO::PARAM_INT);
        $stmt->bindParam(':question_text', $questionText, \PDO::PARAM_STR);
        $stmt->bindParam(':question_type', $questionType, \PDO::PARAM_STR);
        $stmt->execute();
        return $this->conn->lastInsertId();
    }

    public function update($id, $questionText, $questionType) {
        $query = "UPDATE questions SET question_text = :question_text, question_type = :question_type WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->bindParam(':question_text', $questionText, \PDO::PARAM_STR);
        $stmt->bindParam(':question_type', $questionType, \PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function delete($id) {
        $query = "DELETE FROM questions WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function getQuestionsByQuizId($quizId) {
        $query = "SELECT * FROM questions WHERE quiz_id = :quiz_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':quiz_id', $quizId, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getQuestionCount() {
        $query = "SELECT COUNT(*) FROM questions";
        $stmt = $this->conn->query($query);
        return $stmt->fetchColumn();
    }
}
