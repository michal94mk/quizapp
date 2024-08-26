<?php

namespace App\Models;

use App\Database\Database;

class Quiz {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getPdo();
    }

    public function create($title, $description, $questions)
    {
        try {
            $query = "INSERT INTO quizzes (title, description) VALUES (:title, :description)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':title', $title, \PDO::PARAM_STR);
            $stmt->bindParam(':description', $description, \PDO::PARAM_STR);
            $stmt->execute();

            $quiz_id = $this->conn->lastInsertId();

            foreach ($questions as $question) {
                $query = "INSERT INTO questions (quiz_id, question_text, question_type) VALUES (:quiz_id, :question_text, :question_type)";
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(':quiz_id', $quiz_id, \PDO::PARAM_INT);
                $stmt->bindParam(':question_text', $question['question_text'], \PDO::PARAM_STR);
                $stmt->bindParam(':question_type', $question['question_type'], \PDO::PARAM_STR);
                $stmt->execute();

                $question_id = $this->conn->lastInsertId();

                foreach ($question['answers'] as $answer) {
                    $query = "INSERT INTO answers (question_id, answer_text, is_correct) VALUES (:question_id, :answer_text, :is_correct)";
                    $stmt = $this->conn->prepare($query);
                    $stmt->bindParam(':question_id', $question_id, \PDO::PARAM_INT);
                    $stmt->bindParam(':answer_text', $answer['answer_text'], \PDO::PARAM_STR);
                    $stmt->bindParam(':is_correct', $answer['is_correct'], \PDO::PARAM_BOOL);
                    $stmt->execute();
                }
            }

            return $quiz_id;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function update($id, $title, $description) {
        $query = "UPDATE quizzes SET title = :title, description = :description WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->bindParam(':title', $title, \PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, \PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function delete($id) {
        $query = "DELETE FROM quizzes WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function getQuizById($id) {
        $query = "SELECT * FROM quizzes WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function getAllQuizzes($limit, $offset) {
        $query = "SELECT * FROM quizzes LIMIT :limit OFFSET :offset";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':limit', $limit, \PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getQuizCount() {
        $query = "SELECT COUNT(*) as count FROM quizzes";
        $stmt = $this->conn->query($query);
        return $stmt->fetch(\PDO::FETCH_ASSOC)['count'];
    }

    public function getRecentQuizzes($limit = 5) {
        $query = "SELECT * FROM quizzes ORDER BY created_at DESC LIMIT :limit";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
