<?php

namespace App\Models;

use App\Database\Database;

class UserQuizResult {
    private $conn;
    public $user_id;
    public $quiz_id;
    public $score;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getPdo();
    }

    public function createResult($userId, $quizId, $score) {
    
        $query = "INSERT INTO user_quiz_results (user_id, quiz_id, score) VALUES (:user_id, :quiz_id, :score)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
        $stmt->bindParam(':quiz_id', $quizId, \PDO::PARAM_INT);
        $stmt->bindParam(':score', $score, \PDO::PARAM_INT);
    
        return $stmt->execute();
    }
    
    public function getResult($userId, $quizId) {
        $query = "SELECT * FROM user_quiz_results WHERE user_id = :user_id AND quiz_id = :quiz_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
        $stmt->bindParam(':quiz_id', $quizId, \PDO::PARAM_INT);
        $stmt->execute();
    
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        
        return $result;
    }

    public function getResultByQuizAndUser($quiz_id, $user_id) {
        $query = "SELECT * FROM user_quiz_results WHERE user_id = ? AND quiz_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$quiz_id, $user_id]);
        return $stmt->fetch();
    }
}
