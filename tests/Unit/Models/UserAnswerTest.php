<?php

use PHPUnit\Framework\TestCase;
use App\Models\UserAnswer;
use App\Database\Database;

class UserAnswerTest extends TestCase
{
    private $userAnswer;

    protected function setUp(): void
    {
        $database = new Database();
        $pdo = $database->getPdo();

        $pdo->exec("SET FOREIGN_KEY_CHECKS = 0;");
        $pdo->exec("DROP TABLE IF EXISTS user_answers;");
        $pdo->exec("DROP TABLE IF EXISTS answers;");
        $pdo->exec("DROP TABLE IF EXISTS questions;");
        $pdo->exec("DROP TABLE IF EXISTS quizzes;");
        $pdo->exec("DROP TABLE IF EXISTS users;");
        $pdo->exec("SET FOREIGN_KEY_CHECKS = 1;");

        $pdo->exec("
            CREATE TABLE users (
                id INT AUTO_INCREMENT PRIMARY KEY,
                username VARCHAR(255) NOT NULL UNIQUE,
                password VARCHAR(255) NOT NULL,
                email VARCHAR(255) NOT NULL UNIQUE,
                role VARCHAR(255) NOT NULL DEFAULT 'user',
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            );
        ");

        $pdo->exec("
            CREATE TABLE quizzes (
                id INT AUTO_INCREMENT PRIMARY KEY,
                title VARCHAR(255) NOT NULL,
                description TEXT,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            );
        ");

        $pdo->exec("
            CREATE TABLE questions (
                id INT AUTO_INCREMENT PRIMARY KEY,
                quiz_id INT NOT NULL,
                question_text TEXT NOT NULL,
                question_type ENUM('single choice', 'multiple choice') NOT NULL,
                FOREIGN KEY (quiz_id) REFERENCES quizzes(id) ON DELETE CASCADE
            );
        ");

        $pdo->exec("
            CREATE TABLE answers (
                id INT AUTO_INCREMENT PRIMARY KEY,
                question_id INT NOT NULL,
                answer_text TEXT NOT NULL,
                is_correct BOOLEAN NOT NULL,
                FOREIGN KEY (question_id) REFERENCES questions(id) ON DELETE CASCADE
            );
        ");

        $pdo->exec("
            CREATE TABLE user_answers (
                id INT AUTO_INCREMENT PRIMARY KEY,
                user_id INT NOT NULL,
                question_id INT NOT NULL,
                answer_id INT NOT NULL,
                answered_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
                FOREIGN KEY (question_id) REFERENCES questions(id) ON DELETE CASCADE,
                FOREIGN KEY (answer_id) REFERENCES answers(id) ON DELETE CASCADE
            );
        ");

        $pdo->exec("INSERT INTO users (id, username, password, email) VALUES (1, 'test_user', 'password', 'test@example.com');");
        $pdo->exec("INSERT INTO quizzes (id, title, description) VALUES (1, 'Test Quiz', 'Description');");
        $pdo->exec("INSERT INTO questions (id, quiz_id, question_text, question_type) VALUES (1, 1, 'Test Question', 'single choice');");
        $pdo->exec("INSERT INTO answers (id, question_id, answer_text, is_correct) VALUES (1, 1, 'Test Answer', TRUE);");

        $this->userAnswer = new UserAnswer();
    }

    public function testSaveUserAnswer()
    {
        $this->userAnswer->user_id = 1;
        $this->userAnswer->question_id = 1;
        $this->userAnswer->answer_id = 1;
    
        $this->userAnswer->save();
    
        $database = new Database('mysql:host=127.0.0.1;dbname=testdb', 'root', '');
        $pdo = $database->getPdo();
        $stmt = $pdo->query("SELECT * FROM user_answers");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
        $this->assertNotEmpty($result, "Data should be saved in the database.");
        $this->assertEquals(1, (int)$result['user_id'], "User ID should match.");
        $this->assertEquals(1, (int)$result['question_id'], "Question ID should match.");
        $this->assertEquals(1, (int)$result['answer_id'], "Answer ID should match.");
    }
    
    public function testSaveWithInvalidDataThrowsException()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("All fields (user_id, question_id, answer_id) must be set.");
    
        $userAnswer = new UserAnswer();
        $userAnswer->user_id = null; 
        $userAnswer->question_id = 1;
        $userAnswer->answer_id = 1;
    
        $userAnswer->save();
    }
    

    public function testSaveInsertsCorrectTimestamp()
    {
        $this->userAnswer->user_id = 1;
        $this->userAnswer->question_id = 1;
        $this->userAnswer->answer_id = 1;

        $this->userAnswer->save();

        $database = new Database('mysql:host=127.0.0.1;dbname=testdb', 'root', '');
        $pdo = $database->getPdo();
        $stmt = $pdo->query("SELECT * FROM user_answers");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->assertNotEmpty($result['answered_at'], "The answered_at field should not be empty.");
        $this->assertLessThanOrEqual(time(), strtotime($result['answered_at']), "Timestamp should be valid.");
    }
}
