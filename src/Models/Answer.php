<?php

namespace App\Models;

use App\Database\Database;

class Answer {
    private $conn;

    public $id;
    public $question_id;
    public $answer_id;
    public $is_correct;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getPdo();
    }

    public function getAnswerById($answerId) {
        $query = "SELECT * FROM answers WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $answerId, \PDO::PARAM_INT);
        $stmt->execute();
    
        $answer = $stmt->fetch(\PDO::FETCH_ASSOC);
   
        return $answer;
    }
    
    public function getAnswersByQuestionId($questionId) {
        $query = "SELECT * FROM answers WHERE question_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$questionId]);
        return $stmt->fetchAll();
    }

    public function createAnswer($questionId, $answerText, $isCorrect) {
        $query = "INSERT INTO answers (question_id, answer_text, is_correct) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$questionId, $answerText, $isCorrect]);
    }

    public function find($id) {
        $query = "SELECT * FROM answers WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    
}
