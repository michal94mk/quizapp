<?php

use PHPUnit\Framework\TestCase;
use App\Models\Answer;
use App\Database\Database;

class AnswerTest extends TestCase
{
    private $answer;

    protected function setUp(): void
    {
        $database = new Database('mysql:host=127.0.0.1;dbname=testdb2', 'root', '');
        $pdo = $database->getPdo();
    
        $pdo->exec("SET FOREIGN_KEY_CHECKS = 0;");
        $pdo->exec("DROP TABLE IF EXISTS answers;");
        $pdo->exec("DROP TABLE IF EXISTS questions;");
        $pdo->exec("SET FOREIGN_KEY_CHECKS = 1;");
    
        $pdo->exec("
            CREATE TABLE questions (
                id INT AUTO_INCREMENT PRIMARY KEY,
                question_text TEXT NOT NULL
            );
        ");
    
        $pdo->exec("
            CREATE TABLE answers (
                id INT AUTO_INCREMENT PRIMARY KEY,
                question_id INT NOT NULL,
                answer_text TEXT NOT NULL,
                is_correct TINYINT(1) NOT NULL,
                FOREIGN KEY (question_id) REFERENCES questions(id) ON DELETE CASCADE
            );
        ");
    
        $pdo->exec("INSERT INTO questions (id, question_text) VALUES (1, 'Sample Question');");
    
        $this->answer = new Answer();
    }
    
    
    public function testCreate()
    {
        $id = $this->answer->create(1, 'Test answer', 1);

        $result = $this->answer->getAnswerById($id);

        $this->assertIsArray($result, 'Result should be an array');
        $this->assertEquals(1, $result['question_id'], 'Question ID should be 1');
        $this->assertEquals('Test answer', $result['answer_text'], 'Answer text should match');
        $this->assertEquals(1, $result['is_correct'], 'Is_correct should be 1');
    }

    public function testUpdate()
    {
        $id = $this->answer->create(1, 'Test answer', 1);

        $this->answer->update($id, 'Updated answer', 0);

        $result = $this->answer->getAnswerById($id);

        $this->assertEquals('Updated answer', $result['answer_text'], 'Answer text should be updated');
        $this->assertEquals(0, $result['is_correct'], 'Is_correct should be updated to 0');
    }

    public function testDelete()
    {
        $id = $this->answer->create(1, 'Test answer', 1);

        $this->answer->delete($id);

        $result = $this->answer->getAnswerById($id);

        $this->assertFalse($result, 'Result should be false for deleted record');
    }

    public function testGetAnswersByQuestionId(): void
    {
        $db = new Database('mysql:host=127.0.0.1;dbname=testdb', 'root', '');
        $pdo = $db->getPdo();
        $pdo->exec("INSERT INTO questions (id, question_text) VALUES (2, 'Another Question');");
    
        $answerId1 = $this->answer->create(2, 'Answer 1', true);
        $answerId2 = $this->answer->create(2, 'Answer 2', false);
    
        $answers = $this->answer->getAnswersByQuestionId(2);
    
        $this->assertCount(2, $answers);
        $this->assertEquals('Answer 1', $answers[0]['answer_text']);
        $this->assertEquals('Answer 2', $answers[1]['answer_text']);
    }
}
