<?php

namespace App\Models;

use App\Database\Database;
use PDO;
use PDOException;

class Answer {
    private $conn;

    public function __construct(PDO $pdo = null)
    {
        if ($pdo) {
            $this->conn = $pdo;
        } else {
            $db = new Database();
            $this->conn = $db->getPdo();
        }
    }

    public function create($quizId, $answerText, $isCorrect)
    {
        $query = "SELECT COUNT(*) FROM quizzes WHERE id = :quiz_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':quiz_id', $quizId, PDO::PARAM_INT);
        $stmt->execute();
        $quizExists = $stmt->fetchColumn() > 0;
    
        if (!$quizExists) {
            throw new \Exception("Quiz with ID $quizId does not exist.");
        }
    
        $query = "INSERT INTO answers (question_id, answer_text, is_correct) VALUES (:question_id, :answer_text, :is_correct)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':question_id', $quizId, PDO::PARAM_INT);
        $stmt->bindParam(':answer_text', $answerText, PDO::PARAM_STR);
        $stmt->bindValue(':is_correct', $isCorrect ? 1 : 0, PDO::PARAM_INT);
    
        $stmt->execute();
        return (int) $this->conn->lastInsertId();
    }

    public function update($id, $answerText, $isCorrect)
    {
        if (empty($answerText)) {
            throw new \Exception("Answer text cannot be empty.");
        }
    
        try {
            $query = "UPDATE answers SET answer_text = :answer_text, is_correct = :is_correct WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':answer_text', $answerText, PDO::PARAM_STR);
            $stmt->bindValue(':is_correct', $isCorrect ? 1 : 0, PDO::PARAM_INT);
            $stmt->execute();
    
            if ($stmt->rowCount() === 0) {
                throw new \Exception("No rows were updated. Answer with ID $id might not exist.");
            }
    
            return true;
        } catch (PDOException $e) {
            throw new \Exception("Failed to update answer: " . $e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $query = "DELETE FROM answers WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            if ($stmt->rowCount() === 0) {
                throw new \Exception("No rows were deleted. Answer with ID $id might not exist.");
            }
            return true;
        } catch (PDOException $e) {
            throw new \Exception("Failed to delete answer: " . $e->getMessage());
        }
    }

    public function getAnswerById($id)
    {
        $query = "SELECT * FROM answers WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function getAnswersByQuestionId($questionId)
    {
        $query = "SELECT * FROM answers WHERE question_id = :question_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':question_id', $questionId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    public function find($id)
    {
        return $this->getAnswerById($id);
    }
}
