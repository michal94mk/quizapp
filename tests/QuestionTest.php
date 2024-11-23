<?php

use PHPUnit\Framework\TestCase;
use App\Models\Question;
use App\Database\Database;

class QuestionTest extends TestCase
{
    private $question;

    protected function setUp(): void
    {
        $database = new Database('mysql:host=127.0.0.1;dbname=testdb', 'root', '');
        $pdo = $database->getPdo();
    
        $pdo->exec("SET FOREIGN_KEY_CHECKS = 0;");
        $pdo->exec("DROP TABLE IF EXISTS questions;");
        $pdo->exec("DROP TABLE IF EXISTS quizzes;");
        $pdo->exec("SET FOREIGN_KEY_CHECKS = 1;");
    
        $pdo->exec("
            CREATE TABLE quizzes (
                id INT AUTO_INCREMENT PRIMARY KEY,
                title VARCHAR(255) NOT NULL,
                description TEXT,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            );
        ");
    
        $pdo->exec("
            CREATE TABLE questions (
                id INT AUTO_INCREMENT PRIMARY KEY,
                quiz_id INT NOT NULL,
                question_text TEXT NOT NULL,
                question_type VARCHAR(50) NOT NULL,
                FOREIGN KEY (quiz_id) REFERENCES quizzes(id) ON DELETE CASCADE
            );
        ");
    
        $pdo->exec("INSERT INTO quizzes (id, title, description) VALUES (1, 'Sample Quiz', 'Description');");
    
        $this->question = new Question();
    }
    

    public function testCreate(): void
    {
        $questionId = $this->question->create(1, 'What is the capital of France?', 'multiple-choice');
        $this->assertIsInt($questionId);

        $createdQuestion = $this->question->getQuestionById($questionId);
        $this->assertNotNull($createdQuestion);
        $this->assertEquals('What is the capital of France?', $createdQuestion['question_text']);
        $this->assertEquals('multiple-choice', $createdQuestion['question_type']);
        $this->assertEquals(1, $createdQuestion['quiz_id']);
    }

    public function testDelete(): void
    {
        $questionId = $this->question->create(1, 'What is the capital of France?', 'multiple-choice');
        $this->assertNotNull($questionId);

        $result = $this->question->delete($questionId);
        $this->assertTrue($result, 'Failed to delete the question');

        $deletedQuestion = $this->question->getQuestionById($questionId);
        $this->assertNull($deletedQuestion, 'The question still exists in the database');
    }
}
