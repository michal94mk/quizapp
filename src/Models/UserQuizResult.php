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

    public function getTop10BestResults($limit, $offset) {
      $query = "
          SELECT 
              q.title AS quiz_title, 
              u.username AS user_name, 
              ur.score AS highest_score
          FROM 
              user_quiz_results ur
          JOIN 
              quizzes q ON ur.quiz_id = q.id
          JOIN 
              users u ON ur.user_id = u.id
          ORDER BY 
              ur.score DESC
          LIMIT 
              :limit 
          OFFSET 
              :offset
      ";
  
      $stmt = $this->conn->prepare($query);
      $stmt->bindParam(':limit', $limit, \PDO::PARAM_INT);
      $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
      $stmt->execute();
      
      return $stmt->fetchAll(\PDO::FETCH_ASSOC);
  }
  
  
  public function getTop10ResultsForQuiz($quizId) {
    $query = "
        SELECT 
            u.username AS user_name, 
            ur.score AS highest_score
        FROM 
            user_quiz_results ur
        JOIN 
            users u ON ur.user_id = u.id
        WHERE 
            ur.quiz_id = :quiz_id
        ORDER BY 
            ur.score DESC
        LIMIT 10
    ";
    
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':quiz_id', $quizId, \PDO::PARAM_INT);
    $stmt->execute();
    
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
}

  
  public function getResultCountForQuiz($quizId = null) {
      $query = "SELECT COUNT(DISTINCT ur.user_id, ur.quiz_id) as count FROM user_quiz_results ur";
  
      if ($quizId) {
          $query .= " WHERE ur.quiz_id = :quiz_id";
      }
  
      $stmt = $this->conn->prepare($query);
      
      if ($quizId) {
          $stmt->bindParam(':quiz_id', $quizId, \PDO::PARAM_INT);
      }
  
      $stmt->execute();
      return $stmt->fetch(\PDO::FETCH_ASSOC)['count'];
  }
  

    public function getResultCount() {
        $query = "SELECT COUNT(*) as count FROM user_quiz_results";
        $stmt = $this->conn->query($query);
        return $stmt->fetch(\PDO::FETCH_ASSOC)['count'];
    }
    
    public function getResult($userId, $quizId) {
      $query = "SELECT 
                  score, 
                  completed_at 
                FROM 
                  user_quiz_results 
                WHERE 
                  user_id = :user_id 
                  AND quiz_id = :quiz_id
                ORDER BY 
                  completed_at DESC 
                LIMIT 1";
  
      $stmt = $this->conn->prepare($query);
      
      $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
      $stmt->bindParam(':quiz_id', $quizId, \PDO::PARAM_INT);
      
      $stmt->execute();
      
      return $stmt->fetch(\PDO::FETCH_ASSOC);
  }  
}
