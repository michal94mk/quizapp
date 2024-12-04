<?php

namespace Tests\Unit\Models;

use App\Models\Answer;
use App\Database\Database;
use PDO;
use PHPUnit\Framework\TestCase;

class AnswerTest extends TestCase
{
    private $mockedPdo;
    private $mockedDb;
    private $answer;

    protected function setUp(): void
    {
        $this->mockedPdo = $this->createMock(PDO::class);
    
        $this->mockedDb = $this->createMock(Database::class);
        $this->mockedDb->method('getPdo')->willReturn($this->mockedPdo);
    
        $this->answer = new Answer($this->mockedPdo);
    }
    
    public function testCreateAnswerSuccess()
    {
        $stmtMock = $this->createMock(\PDOStatement::class);
        $stmtMock->method('execute')->willReturn(true);
        $stmtMock->method('fetchColumn')->willReturn(1);
    
        $this->mockedPdo->method('prepare')->willReturn($stmtMock);
    
        $this->mockedPdo->method('lastInsertId')->willReturn('1');
    
        $result = $this->answer->create(1, 'Example Answer', true);
    
        $this->assertEquals(1, $result);
    }

    public function testCreateAnswerThrowsExceptionForNonExistentQuiz()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Quiz with ID 1 does not exist.');

        $stmtMock = $this->createMock(\PDOStatement::class);
        $stmtMock->method('execute')->willReturn(true);
        $stmtMock->method('fetchColumn')->willReturn(0);

        $this->mockedPdo->method('prepare')->willReturn($stmtMock);

        $this->answer->create(1, 'Example Answer', true);
    }

    public function testUpdateAnswerThrowsExceptionForEmptyText()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Answer text cannot be empty.');

        $this->answer->update(1, '', true);
    }

    public function testUpdateAnswerSuccess()
    {
        $stmtMock = $this->createMock(\PDOStatement::class);
        $stmtMock->method('execute')->willReturn(true);
        $stmtMock->method('rowCount')->willReturn(1);

        $this->mockedPdo->method('prepare')->willReturn($stmtMock);

        $result = $this->answer->update(1, 'Updated Answer', false);

        $this->assertTrue($result);
    }

    public function testDeleteAnswerSuccess()
    {
        $stmtMock = $this->createMock(\PDOStatement::class);
        $stmtMock->method('execute')->willReturn(true);
        $stmtMock->method('rowCount')->willReturn(1);

        $this->mockedPdo->method('prepare')->willReturn($stmtMock);

        $result = $this->answer->delete(1);

        $this->assertTrue($result);
    }

    public function testDeleteAnswerThrowsExceptionWhenAnswerNotExist()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('No rows were deleted. Answer with ID 1 might not exist.');

        $stmtMock = $this->createMock(\PDOStatement::class);
        $stmtMock->method('execute')->willReturn(true);
        $stmtMock->method('rowCount')->willReturn(0);

        $this->mockedPdo->method('prepare')->willReturn($stmtMock);

        $this->answer->delete(1);
    }

    public function testGetAnswerById()
    {
        $stmtMock = $this->createMock(\PDOStatement::class);
        $stmtMock->method('execute')->willReturn(true);
        $stmtMock->method('fetch')->willReturn([
            'id' => 1,
            'question_id' => 1,
            'answer_text' => 'Example Answer',
            'is_correct' => 1,
        ]);

        $this->mockedPdo->method('prepare')->willReturn($stmtMock);

        $result = $this->answer->getAnswerById(1);

        $this->assertIsArray($result);
        $this->assertEquals(1, $result['id']);
    }

    public function testGetAnswersByQuestionId()
    {
        $stmtMock = $this->createMock(\PDOStatement::class);
        $stmtMock->method('execute')->willReturn(true);
        $stmtMock->method('fetchAll')->willReturn([
            ['id' => 1, 'question_id' => 1, 'answer_text' => 'Answer 1', 'is_correct' => 1],
            ['id' => 2, 'question_id' => 1, 'answer_text' => 'Answer 2', 'is_correct' => 0],
        ]);

        $this->mockedPdo->method('prepare')->willReturn($stmtMock);

        $result = $this->answer->getAnswersByQuestionId(1);

        $this->assertIsArray($result);
        $this->assertCount(2, $result);
        $this->assertEquals('Answer 1', $result[0]['answer_text']);
    }
}
