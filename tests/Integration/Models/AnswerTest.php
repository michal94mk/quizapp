<?php

use PHPUnit\Framework\TestCase;
use App\Models\Answer;
use App\Database\Database;

class AnswerTest extends TestCase
{
    private $answer;

    protected function setUp(): void
    {
        $database = new Database();
        $pdo = $database->getPdo();

        $pdo->exec("SET FOREIGN_KEY_CHECKS = 0;");
        $pdo->exec("DROP TABLE IF EXISTS answers;");
        $pdo->exec("DROP TABLE IF EXISTS quizzes;");
        $pdo->exec("SET FOREIGN_KEY_CHECKS = 1;");

        $pdo->exec("CREATE TABLE answers (
            id INT AUTO_INCREMENT PRIMARY KEY,
            question_id INT NOT NULL,
            answer_text TEXT NOT NULL,
            is_correct TINYINT(1) NOT NULL
        );");

        $pdo->exec("CREATE TABLE quizzes (
            id INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(255) NOT NULL
        );");

        $pdo->exec("INSERT INTO quizzes (title) VALUES ('Test Quiz');");

        $this->answer = new Answer();
    }

    public function testCreateThrowsExceptionOnInvalidData()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Quiz with ID  does not exist.');
        
        $this->answer->create(null, 'Sample Answer', true);
    }
    

    public function testUpdateThrowsExceptionOnInvalidData()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('No rows were updated. Answer with ID 999 might not exist.');
    
        $this->answer->update(999, 'Updated Text', true);
    }

    public function testDeleteThrowsExceptionIfAnswerDoesNotExist()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("No rows were deleted. Answer with ID 999 might not exist.");

        $this->answer->delete(999);
    }

    public function testGetAnswerByIdReturnsNullForNonExistentAnswer()
    {
        $result = $this->answer->getAnswerById(999);
        $this->assertNull($result, "Expected null when fetching non-existent answer");
    }

    public function testCreateAndRetrieveAnswer()
    {
        $answerId = $this->answer->create(1, 'Sample Answer', true);
        $this->assertIsInt($answerId);

        $retrievedAnswer = $this->answer->getAnswerById($answerId);
        $this->assertNotNull($retrievedAnswer, "Answer with ID $answerId should exist.");
        $this->assertEquals('Sample Answer', $retrievedAnswer['answer_text']);
        $this->assertEquals(1, $retrievedAnswer['question_id']);
        $this->assertEquals(1, $retrievedAnswer['is_correct']);
    }

    public function testDeleteRemovesAnswerSuccessfully()
    {
        $answerId = $this->answer->create(1, 'Sample Answer', true);
        $this->assertIsInt($answerId);

        $result = $this->answer->delete($answerId);
        $this->assertTrue($result);

        $deletedAnswer = $this->answer->getAnswerById($answerId);
        $this->assertNull($deletedAnswer, "Answer with ID $answerId should have been deleted.");
    }
}