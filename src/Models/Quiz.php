<?php

namespace App\Models;

use App\Database\Database;
use PDO;

class Quiz
{
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

    private function prepareAndExecute(string $query, array $params = [])
    {
        $stmt = $this->conn->prepare($query);
        if (!$stmt) {
            throw new \Exception('Failed to prepare query: ' . implode(', ', $this->conn->errorInfo()));
        }

        if (!$stmt->execute($params)) {
            throw new \Exception('Failed to execute query: ' . implode(', ', $stmt->errorInfo()));
        }

        return $stmt;
    }

    public function create(string $title, ?string $description)
    {
        if (empty(trim($title))) {
            throw new \InvalidArgumentException("Quiz title cannot be empty.");
        }

        $query = "INSERT INTO quizzes (title, description) VALUES (:title, :description)";
        $this->prepareAndExecute($query, ['title' => $title, 'description' => $description]);

        return true;
    }

    public function update(int $id, string $title, ?string $description)
    {
        if (empty(trim($title))) {
            throw new \InvalidArgumentException("Quiz title cannot be empty.");
        }

        $query = "UPDATE quizzes SET title = :title, description = :description WHERE id = :id";
        return $this->prepareAndExecute($query, [
            'id' => $id,
            'title' => $title,
            'description' => $description
        ])->rowCount() > 0;
    }

    public function delete(int $id)
    {
        $query = "DELETE FROM quizzes WHERE id = :id";
        return $this->prepareAndExecute($query, ['id' => $id])->rowCount() > 0;
    }

    public function getQuizById(int $id)
    {
        $query = "SELECT * FROM quizzes WHERE id = :id";
        return $this->prepareAndExecute($query, ['id' => $id])->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllQuizzesPaginated(int $limit, int $offset)
    {
        if ($limit <= 0 || $offset < 0) {
            throw new \InvalidArgumentException("Limit and offset must be non-negative integers.");
        }

        $query = "
            SELECT 
                q.id AS quiz_id,
                q.title AS quiz_title,
                q.description AS quiz_description,
                q.created_at AS quiz_created_at,
                COUNT(qu.id) AS question_count
            FROM 
                quizzes q
            LEFT JOIN 
                questions qu ON q.id = qu.quiz_id
            GROUP BY 
                q.id, q.title, q.description, q.created_at
            LIMIT 
                :limit 
            OFFSET 
                :offset
        ";

        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllQuizzes()
    {
        $query = "SELECT id, title FROM quizzes";
        return $this->conn->query($query)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getQuizCount()
    {
        $query = "SELECT COUNT(*) AS count FROM quizzes";
        return (int) $this->conn->query($query)->fetch(PDO::FETCH_ASSOC)['count'];
    }

    public function getRecentQuizzes(int $limit = 5)
    {
        if ($limit <= 0) {
            throw new \InvalidArgumentException("Limit must be a positive integer.");
        }

        $query = "SELECT * FROM quizzes ORDER BY created_at DESC LIMIT :limit";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getQuizStats()
    {
        $query = "
            SELECT 
                COUNT(*) AS quiz_count,
                MAX(LENGTH(title)) AS longest_title_length,
                (SELECT title FROM quizzes ORDER BY LENGTH(title) DESC LIMIT 1) AS longest_title,
                (SELECT COUNT(*) FROM quizzes WHERE created_at >= DATE_SUB(NOW(), INTERVAL 1 MONTH)) AS recent_quiz_count,
                (SELECT AVG(question_count) FROM (
                    SELECT COUNT(*) AS question_count 
                    FROM questions 
                    GROUP BY quiz_id
                ) subquery) AS avg_questions_per_quiz
            FROM quizzes
        ";

        return $this->conn->query($query)->fetch(PDO::FETCH_ASSOC);
    }

    public function getTopQuizzes(int $limit = 5)
    {
        if ($limit <= 0) {
            throw new \InvalidArgumentException("Limit must be a positive integer.");
        }

        $query = "
            SELECT 
                title, 
                COUNT(ur.id) AS completions
            FROM 
                quizzes q
            LEFT JOIN 
                user_quiz_results ur ON q.id = ur.quiz_id
            GROUP BY 
                q.id
            ORDER BY 
                completions DESC
            LIMIT 
                :limit
        ";

        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getQuizPerformance()
    {
        $query = "
            SELECT 
                q.title, 
                AVG(ur.score) AS avg_score
            FROM 
                quizzes q
            LEFT JOIN 
                user_quiz_results ur ON q.id = ur.quiz_id
            GROUP BY 
                q.id
        ";

        return $this->conn->query($query)->fetchAll(PDO::FETCH_ASSOC);
    }
}
