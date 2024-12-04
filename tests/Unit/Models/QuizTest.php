<?php

namespace Tests\Unit\Models;

use App\Models\Quiz;
use App\Database\Database;
use PDO;
use PHPUnit\Framework\TestCase;

class QuizTest extends TestCase
{
    private $mockedPdo;
    private $mockedDb;
    private $quiz;

    protected function setUp(): void
    {
        $this->mockedPdo = $this->createMock(PDO::class);

        $this->mockedDb = $this->createMock(Database::class);
        $this->mockedDb->method('getPdo')->willReturn($this->mockedPdo);

        $this->quiz = new Quiz($this->mockedPdo);
    }

    public function testCreateQuizSuccess()
    {
        $stmtMock = $this->createMock(\PDOStatement::class);
        $stmtMock->method('execute')->willReturn(true);
        $this->mockedPdo->method('prepare')->willReturn($stmtMock);
        $this->mockedPdo->method('lastInsertId')->willReturn('1');

        $result = $this->quiz->create('Sample Quiz', 'This is a sample description.');

        $this->assertEquals(1, $result);
    }

    public function testCreateQuizThrowsExceptionForEmptyTitle()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Quiz title cannot be empty.");

        $this->quiz->create('', 'This is a sample description.');
    }

    public function testUpdateQuizSuccess()
    {
        $stmtMock = $this->createMock(\PDOStatement::class);
        $stmtMock->method('execute')->willReturn(true);
        $stmtMock->method('rowCount')->willReturn(1);
        $this->mockedPdo->method('prepare')->willReturn($stmtMock);

        $result = $this->quiz->update(1, 'Updated Title', 'Updated Description');

        $this->assertTrue($result);
    }

    public function testDeleteQuizSuccess()
    {
        $stmtMock = $this->createMock(\PDOStatement::class);
        $stmtMock->method('execute')->willReturn(true);
        $stmtMock->method('rowCount')->willReturn(1);
        $this->mockedPdo->method('prepare')->willReturn($stmtMock);

        $result = $this->quiz->delete(1);

        $this->assertTrue($result);
    }

    public function testGetQuizById()
    {
        $stmtMock = $this->createMock(\PDOStatement::class);
        $stmtMock->method('execute')->willReturn(true);
        $stmtMock->method('fetch')->willReturn([
            'id' => 1,
            'title' => 'Sample Quiz',
            'description' => 'This is a sample description.'
        ]);
        $this->mockedPdo->method('prepare')->willReturn($stmtMock);

        $result = $this->quiz->getQuizById(1);

        $this->assertIsArray($result);
        $this->assertEquals('Sample Quiz', $result['title']);
    }

    public function testGetAllQuizzesPaginated()
    {
        $stmtMock = $this->createMock(\PDOStatement::class);
        $stmtMock->method('execute')->willReturn(true);
        $stmtMock->method('fetchAll')->willReturn([
            ['id' => 1, 'title' => 'Quiz 1', 'description' => 'Description 1'],
            ['id' => 2, 'title' => 'Quiz 2', 'description' => 'Description 2']
        ]);
        $this->mockedPdo->method('prepare')->willReturn($stmtMock);

        $result = $this->quiz->getAllQuizzesPaginated(10, 0);

        $this->assertIsArray($result);
        $this->assertCount(2, $result);
        $this->assertEquals('Quiz 1', $result[0]['title']);
    }
}
