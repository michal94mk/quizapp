<?php

namespace App\Models;

use App\Database\Database;
use PDO;
use PDOException;

class Question {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getPdo();
    }

    public function create($quizId, $questionText, $questionType) {
        try {
            $query = "INSERT INTO questions (quiz_id, question_text, question_type) VALUES (:quiz_id, :question_text, :question_type)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':quiz_id', $quizId, PDO::PARAM_INT);
            $stmt->bindParam(':question_text', $questionText, PDO::PARAM_STR);
            $stmt->bindParam(':question_type', $questionType, PDO::PARAM_STR);
            $stmt->execute();
            return (int) $this->conn->lastInsertId();
        } catch (PDOException $e) {
            return null;
        }
    }

    public function update($id, $quizId, $questionText, $questionType) {
        try {
            $query = "UPDATE questions SET quiz_id = :quiz_id, question_text = :question_text, question_type = :question_type WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':quiz_id', $quizId, PDO::PARAM_INT);
            $stmt->bindParam(':question_text', $questionText, PDO::PARAM_STR);
            $stmt->bindParam(':question_type', $questionType, PDO::PARAM_STR);
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    public function delete($id) {
        try {
            $query = "DELETE FROM questions WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            if ($stmt->execute()) {
                return $stmt->rowCount() > 0;
            }
            return false;
        } catch (PDOException $e) {
            return false;
        }
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
