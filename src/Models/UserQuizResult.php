<?php

namespace App\Models;

use App\Database\Database;

class UserQuizResult
{
    private $conn;
    public $user_id;
    public $quiz_id;
    public $score;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->getPdo();
    }

    public function createResult($userId, $quizId, $score)
    {
        $query = "INSERT INTO user_quiz_results (user_id, quiz_id, score) VALUES (:user_id, :quiz_id, :score)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
        $stmt->bindParam(':quiz_id', $quizId, \PDO::PARAM_INT);
        $stmt->bindParam(':score', $score, \PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function getTop10BestResults($limit, $offset)
    {
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

    public function getTop10ResultsForQuiz($quizId)
    {
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

    public function getResultCountForQuiz($quizId = null)
    {
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

    public function getResultCount()
    {
        $query = "SELECT COUNT(*) as count FROM user_quiz_results";
        $stmt = $this->conn->query($query);
        return $stmt->fetch(\PDO::FETCH_ASSOC)['count'];
    }

    public function getResult($userId, $quizId)
    {
        $query = "
            SELECT 
                score, 
                completed_at 
            FROM 
                user_quiz_results 
            WHERE 
                user_id = :user_id 
                AND quiz_id = :quiz_id
            ORDER BY 
                completed_at DESC 
            LIMIT 1
        ";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
        $stmt->bindParam(':quiz_id', $quizId, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function getDailyQuizCompletions()
    {
        $query = "
            SELECT 
                DATE(completed_at) AS date, 
                COUNT(*) AS completions
            FROM 
                user_quiz_results
            GROUP BY 
                DATE(completed_at)
            ORDER BY 
                date DESC
        ";

        return $this->conn->query($query)->fetchAll();
    }

    public function getUserAnswerStats()
    {
        $query = "
            SELECT 
                ua.user_id, 
                COUNT(*) AS total_answers, 
                SUM(CASE WHEN a.is_correct = 1 THEN 1 ELSE 0 END) AS correct_answers
            FROM 
                user_answers ua
            JOIN 
                answers a ON ua.answer_id = a.id
            GROUP BY 
                ua.user_id
        ";

        return $this->conn->query($query)->fetchAll();
    }

    public function getQuestionStats()
    {
        $query = "
            SELECT 
                q.question_text, 
                COUNT(*) AS answer_count
            FROM 
                user_answers ua
            JOIN 
                questions q ON ua.question_id = q.id
            GROUP BY 
                q.id
        ";

        return $this->conn->query($query)->fetchAll();
    }

    public function getRecentQuizResults($limit = 5)
    {
        $query = "
            SELECT 
                u.username, 
                q.title AS quiz_title, 
                ur.score, 
                ur.completed_at
            FROM 
                user_quiz_results ur
            JOIN 
                users u ON ur.user_id = u.id
            JOIN 
                quizzes q ON ur.quiz_id = q.id
            ORDER BY 
                ur.completed_at DESC
            LIMIT 
                :limit
        ";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
