<?php

use PHPUnit\Framework\TestCase;
use App\Models\Question;
use App\Database\Database;

class QuestionTest extends TestCase
{
    private $question;

    protected function setUp(): void
    {
        $database = new Database();
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

    public function testCreateThrowsExceptionOnInvalidQuizId()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Quiz with ID 999 does not exist.');
    
        $this->question->create(999, 'Invalid Question', 'text');
    }    

    public function testUpdateThrowsExceptionOnInvalidQuestionId()
    {
        $result = $this->question->update(999, 1, 'Updated Question', 'multiple-choice');
        $this->assertFalse($result, 'Expected update to fail for non-existent question');
    }
       
    public function testDeleteThrowsExceptionOnNonExistentQuestion(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Question with ID 999 does not exist.');
    
        $this->question->delete(999);
    }    

    public function testGetQuestionByIdReturnsNullForNonExistentQuestion(): void
    {
        $result = $this->question->getQuestionById(999);
        $this->assertNull($result, 'Expected null when fetching non-existent question');
    }

    public function testCreateAndRetrieveMultipleQuestions(): void
    {
        $question1 = $this->question->create(1, 'First question?', 'text');
        $question2 = $this->question->create(1, 'Second question?', 'multiple-choice');

        $questions = $this->question->getQuestionsByQuizId(1);

        $this->assertCount(2, $questions, 'Expected two questions for the quiz');
        $this->assertEquals('First question?', $questions[0]['question_text']);
        $this->assertEquals('Second question?', $questions[1]['question_text']);
    }
}
