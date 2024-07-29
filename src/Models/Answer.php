<?php

namespace App\Models;

use App\Database\Database;

class Answer {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getPdo();
    }

    public function create($questionId, $answerText, $isCorrect) {
        $query = "INSERT INTO answers (question_id, answer_text, is_correct) VALUES (:question_id, :answer_text, :is_correct)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':question_id', $questionId, \PDO::PARAM_INT);
        $stmt->bindParam(':answer_text', $answerText, \PDO::PARAM_STR);
        $stmt->bindParam(':is_correct', $isCorrect, \PDO::PARAM_INT);
        $stmt->execute();
        return $this->conn->lastInsertId();
    }

    public function update($id, $answerText, $isCorrect) {
        $query = "UPDATE answers SET answer_text = :answer_text, is_correct = :is_correct WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->bindParam(':answer_text', $answerText, \PDO::PARAM_STR);
        $stmt->bindParam(':is_correct', $isCorrect, \PDO::PARAM_BOOL);
        return $stmt->execute();
    }

    public function delete($id) {
        $query = "DELETE FROM answers WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function getAnswersByQuestionId($questionId) {
        $query = "SELECT * FROM answers WHERE question_id = :question_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':question_id', $questionId, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function find($id) {
        $query = "SELECT * FROM answers WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
}
