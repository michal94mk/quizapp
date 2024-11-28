<?php

namespace App\Models;

use App\Database\Database;
use PDO;
use PDOException;

class Question {
    private $conn;

    public function __construct()
    {
        try {
            $db = new Database();
            $this->conn = $db->getPdo();
        } catch (\Exception $e) {
            throw new \Exception('Database connection failed: ' . $e->getMessage());
        }
    }

    public function create($quizId, $questionText, $questionType)
    {
        $query = "SELECT COUNT(*) FROM quizzes WHERE id = :quiz_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':quiz_id', $quizId, PDO::PARAM_INT);
        $stmt->execute();
        $quizExists = $stmt->fetchColumn() > 0;
    
        if (!$quizExists) {
            throw new \Exception("Quiz with ID $quizId does not exist.");
        }
    
        $query = "INSERT INTO questions (quiz_id, question_text, question_type) VALUES (:quiz_id, :question_text, :question_type)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':quiz_id', $quizId, PDO::PARAM_INT);
        $stmt->bindParam(':question_text', $questionText, PDO::PARAM_STR);
        $stmt->bindParam(':question_type', $questionType, PDO::PARAM_STR);
        $stmt->execute();
    
        return (int) $this->conn->lastInsertId();
    }
    
    public function update($id, $quizId, $questionText, $questionType) {
        try {
            $query = "UPDATE questions SET quiz_id = :quiz_id, question_text = :question_text, question_type = :question_type WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':quiz_id', $quizId, PDO::PARAM_INT);
            $stmt->bindParam(':question_text', $questionText, PDO::PARAM_STR);
            $stmt->bindParam(':question_type', $questionType, PDO::PARAM_STR);
            $stmt->execute();
    
            if ($stmt->rowCount() === 0) {
                return false;
            }
    
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
    
    public function delete($id)
    {
        $query = "DELETE FROM questions WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    
        if ($stmt->rowCount() === 0) {
            throw new \Exception("Question with ID $id does not exist.");
        }
    
        return true;
    }       

    public function getAllQuestionsPaginated($limit, $offset) {
        try {
            $query = "
            SELECT q.*, qu.title AS quiz_title
            FROM questions q
            JOIN quizzes qu ON q.quiz_id = qu.id
            LIMIT :limit OFFSET :offset
            ";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
        } catch (PDOException $e) {
            return [];
        }
    }

    public function getQuestionById($id) {
        try {
            $query = "SELECT * FROM questions WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
        } catch (PDOException $e) {
            return null;
        }
    }

    public function getQuestionsByQuizId($quizId) {
        try {
            $query = "SELECT * FROM questions WHERE quiz_id = :quiz_id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':quiz_id', $quizId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
        } catch (PDOException $e) {
            return [];
        }
    }

    public function getQuestionCount() {
        try {
            $query = "SELECT COUNT(*) FROM questions";
            $stmt = $this->conn->query($query);
            return (int) $stmt->fetchColumn();
        } catch (PDOException $e) {
            return 0;
        }
    }
}
