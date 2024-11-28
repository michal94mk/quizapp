<?php

use PHPUnit\Framework\TestCase;
use App\Models\UserQuizResult;
use App\Database\Database;

class UserQuizResultTest extends TestCase
{
    private $conn;
    private $userQuizResult;

    protected function setUp(): void
    {
        $db = new Database();
        $this->conn = $db->getPdo();
    
        $this->conn->exec("SET FOREIGN_KEY_CHECKS = 0;");
    
        $this->conn->exec("DROP TABLE IF EXISTS user_quiz_results;");
        $this->conn->exec("DROP TABLE IF EXISTS users;");
        $this->conn->exec("DROP TABLE IF EXISTS quizzes;");
    
        $this->conn->exec("CREATE TABLE users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(255) NOT NULL
        );");
    
        $this->conn->exec("CREATE TABLE quizzes (
            id INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(255) NOT NULL,
            description TEXT NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        );");
    
        $this->conn->exec("CREATE TABLE user_quiz_results (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT NOT NULL,
            quiz_id INT NOT NULL,
            score INT NOT NULL,
            completed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
            FOREIGN KEY (quiz_id) REFERENCES quizzes(id) ON DELETE CASCADE
        );");
    
        $this->conn->beginTransaction();
    
        try {
            $this->conn->exec("INSERT INTO users (username) VALUES ('test_user');");
            $this->conn->exec("INSERT INTO users (username) VALUES ('another_user');");
    
            $this->conn->exec("INSERT INTO quizzes (title) VALUES ('test_quiz');");
    
            $this->conn->exec("INSERT INTO user_quiz_results (user_id, quiz_id, score) VALUES (1, 1, 90);");
            $this->conn->exec("INSERT INTO user_quiz_results (user_id, quiz_id, score) VALUES (2, 1, 80);");
    
            $this->conn->commit();
        } catch (\Exception $e) {
            $this->conn->rollBack();
            throw $e;
        }
    
        $this->userQuizResult = new UserQuizResult($this->conn);
    }
    

    public function testGetTop10BestResults()
    {
        $results = $this->userQuizResult->getTop10BestResults(10, 0);
    
        $this->assertNotNull($results);
        $this->assertCount(2, $results);
        $this->assertEquals(90, $results[0]['score']);
    }
    

    public function testGetTop10ResultsForQuiz()
    {
        $results = $this->userQuizResult->getTop10ResultsForQuiz(1);
    
    
        $this->assertNotNull($results);
        $this->assertCount(2, $results);
        $this->assertEquals(90, $results[0]['score']);
    }
}
