<?php

namespace App\Models;

use App\Database\Database;

class Quiz
{
    private $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->getPdo();
    }

    public function create($title, $description)
    {
        $query = "INSERT INTO quizzes (title, description) VALUES (:title, :description)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':title', $title, \PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, \PDO::PARAM_STR);

        return $stmt->execute();
    }

    public function update($id, $title, $description)
    {
        $query = "UPDATE quizzes SET title = :title, description = :description WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->bindParam(':title', $title, \PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, \PDO::PARAM_STR);

        return $stmt->execute();
    }

    public function delete($id)
    {
        $query = "DELETE FROM quizzes WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function getQuizById($id)
    {
        $query = "SELECT * FROM quizzes WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function getAllQuizzesPaginated($limit, $offset)
    {
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
        $stmt->bindParam(':limit', $limit, \PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getAllQuizzes()
    {
        $query = "SELECT id, title FROM quizzes";
        $stmt = $this->conn->query($query);

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getAllQuizzesTitles()
    {
        $query = "SELECT * FROM quizzes";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getQuizCount()
    {
        $query = "SELECT COUNT(*) as count FROM quizzes";
        $stmt = $this->conn->query($query);

        return $stmt->fetch(\PDO::FETCH_ASSOC)['count'];
    }

    public function getRecentQuizzes($limit = 5)
    {
        $query = "SELECT * FROM quizzes ORDER BY created_at DESC LIMIT :limit";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
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

        $stmt = $this->conn->query($query);

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function getTopQuizzes($limit = 5)
    {
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
        $stmt->bindParam(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
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

        return $this->conn->query($query)->fetchAll();
    }
}
