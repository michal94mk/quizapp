<?php

namespace App\Models;

use App\Database\Database;

class UserAnswer {
    private $conn;
    public $user_id;
    public $question_id;
    public $answer_id;

    public function __construct()
    {
        try {
            $db = new Database();
            $this->conn = $db->getPdo();
        } catch (\Exception $e) {
            throw new \Exception('Database connection failed: ' . $e->getMessage());
        }
    }

    public function save()
    {
        if (is_null($this->user_id) || is_null($this->question_id) || is_null($this->answer_id)) {
            throw new \InvalidArgumentException("All fields (user_id, question_id, answer_id) must be set.");
        }
    
        $query = "INSERT INTO user_answers (user_id, question_id, answer_id, answered_at) VALUES (:user_id, :question_id, :answer_id, NOW())";
        $stmt = $this->conn->prepare($query);
    
        $stmt->bindParam(':user_id', $this->user_id);
        $stmt->bindParam(':question_id', $this->question_id);
        $stmt->bindParam(':answer_id', $this->answer_id);
    
        $stmt->execute();
    }      
}
