<?php

namespace Tests\Unit\Models;

use App\Models\Question;
use App\Database\Database;
use PDO;
use PDOStatement;
use PHPUnit\Framework\TestCase;

class QuestionTest extends TestCase
{
    private $mockedPdo;
    private $mockedDb;
    private $question;

    protected function setUp(): void
    {
        $this->mockedPdo = $this->createMock(PDO::class);

        $this->mockedDb = $this->createMock(Database::class);
        $this->mockedDb->method('getPdo')->willReturn($this->mockedPdo);

        $this->question = new Question($this->mockedPdo);
    }

    public function testCreateQuestionSuccess()
    {
        $stmtMock = $this->createMock(PDOStatement::class);
        $stmtMock->method('execute')->willReturn(true);
        $stmtMock->method('fetchColumn')->willReturn(1);
        $this->mockedPdo->method('prepare')->willReturn($stmtMock);
        $this->mockedPdo->method('lastInsertId')->willReturn('123');

        $result = $this->question->create(1, 'What is PHP?', 'multiple_choice');

        $this->assertEquals('123', $result);
    }

    public function testDeleteQuestionSuccess()
    {
        $stmtMock = $this->createMock(PDOStatement::class);
        $stmtMock->method('execute')->willReturn(true);
        $stmtMock->method('rowCount')->willReturn(1);
    
        $this->mockedPdo->method('prepare')->willReturn($stmtMock);
    
        $questionMock = $this->getMockBuilder(Question::class)
            ->setConstructorArgs([$this->mockedPdo])
            ->onlyMethods(['getQuestionById'])
            ->getMock();
    
        $questionMock->method('getQuestionById')->willReturn([
            'id' => 1,
            'quiz_id' => 1,
            'question_text' => 'What is PHP?',
            'question_type' => 'multiple_choice',
        ]);
    
        $result = $questionMock->delete(1);
    
        $this->assertTrue($result);
    }
    

    public function testDeleteQuestionThrowsExceptionWhenNoRowsDeleted()
    {
        $stmtMock = $this->createMock(PDOStatement::class);
        $stmtMock->method('execute')->willReturn(true);
        $stmtMock->method('rowCount')->willReturn(0);
        $this->mockedPdo->method('prepare')->willReturn($stmtMock);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Pytanie o ID 1 nie istnieje.');

        $this->question->delete(1);
    }

    public function testUpdateQuestionSuccess()
    {
        $stmtMock = $this->createMock(PDOStatement::class);
        $stmtMock->method('execute')->willReturn(true);
        $stmtMock->method('rowCount')->willReturn(1);
        $this->mockedPdo->method('prepare')->willReturn($stmtMock);

        $result = $this->question->update(1, 1, 'What is PHP?', 'multiple_choice');

        $this->assertTrue($result);
    }

    public function testUpdateQuestionReturnsFalseWhenNoRowsUpdated()
    {
        $stmtMock = $this->createMock(PDOStatement::class);
        $stmtMock->method('execute')->willReturn(true);
        $stmtMock->method('rowCount')->willReturn(0);
        $this->mockedPdo->method('prepare')->willReturn($stmtMock);

        $result = $this->question->update(1, 1, 'What is PHP?', 'multiple_choice');

        $this->assertFalse($result);
    }

    public function testGetAllQuestionsPaginated()
    {
        $stmtMock = $this->createMock(PDOStatement::class);
        $stmtMock->method('execute')->willReturn(true);
        $stmtMock->method('fetchAll')->willReturn([
            [
                'id' => 1,
                'quiz_id' => 1,
                'question_text' => 'What is PHP?',
                'question_type' => 'multiple_choice',
                'quiz_title' => 'PHP Quiz'
            ]
        ]);
        $this->mockedPdo->method('prepare')->willReturn($stmtMock);

        $result = $this->question->getAllQuestionsPaginated(10, 0);

        $this->assertIsArray($result);
        $this->assertCount(1, $result);
        $this->assertEquals('What is PHP?', $result[0]['question_text']);
    }

    public function testGetQuestionById()
    {
        $stmtMock = $this->createMock(PDOStatement::class);
        $stmtMock->method('execute')->willReturn(true);
        $stmtMock->method('fetch')->willReturn([
            'id' => 1,
            'quiz_id' => 1,
            'question_text' => 'What is PHP?',
            'question_type' => 'multiple_choice'
        ]);
        $this->mockedPdo->method('prepare')->willReturn($stmtMock);

        $result = $this->question->getQuestionById(1);

        $this->assertIsArray($result);
        $this->assertEquals('What is PHP?', $result['question_text']);
    }

    public function testGetQuestionCount()
    {
        $stmtMock = $this->createMock(PDOStatement::class);
        $stmtMock->method('fetchColumn')->willReturn(5);
        $this->mockedPdo->method('query')->willReturn($stmtMock);

        $result = $this->question->getQuestionCount();

        $this->assertEquals(5, $result);
    }
}
