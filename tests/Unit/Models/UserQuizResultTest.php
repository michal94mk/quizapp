<?php

use PHPUnit\Framework\TestCase;
use App\Models\UserQuizResult;
use App\Database\Database;

class UserQuizResultTest extends TestCase
{
    private $mockedDb;
    private $mockedPdo;
    private $userQuizResult;

    protected function setUp(): void
    {
        $this->mockedDb = $this->createMock(Database::class);

        $this->mockedPdo = $this->createMock(PDO::class);
        $this->mockedDb->method('getPdo')->willReturn($this->mockedPdo);

        $this->userQuizResult = new UserQuizResult();

        $reflection = new ReflectionClass($this->userQuizResult);
        $connProperty = $reflection->getProperty('conn');
        $connProperty->setAccessible(true);
        $connProperty->setValue($this->userQuizResult, $this->mockedPdo);
    }

    public function testGetTop10BestResults()
    {
        $mockedStatement = $this->createMock(PDOStatement::class);
        $mockedStatement->expects($this->once())
            ->method('fetchAll')
            ->willReturn([
                ['result_id' => 1, 'username' => 'user1', 'quiz_title' => 'Quiz 1', 'score' => 100, 'completed_at' => '2024-01-01']
            ]);

        $this->mockedPdo->expects($this->once())
            ->method('prepare')
            ->with($this->callback(function ($query) {
                $expectedSql = '/SELECT\s+uqr\.id\s+AS\s+result_id.*FROM\s+user_quiz_results/uix';
                return preg_match($expectedSql, preg_replace('/\s+/', ' ', $query)) === 1;
            }))
            ->willReturn($mockedStatement);

        $mockedStatement->expects($this->once())->method('execute');

        $results = $this->userQuizResult->getTop10BestResults(10, 0);
        $this->assertCount(1, $results);
        $this->assertEquals('user1', $results[0]['username']);
    }

    public function testGetRecentQuizResults()
    {
        $mockedStatement = $this->createMock(PDOStatement::class);
        $mockedStatement->expects($this->once())
            ->method('fetchAll')
            ->willReturn([
                ['username' => 'user1', 'quiz_title' => 'Quiz 1', 'score' => 100, 'completed_at' => '2024-01-01']
            ]);

        $this->mockedPdo->expects($this->once())
            ->method('prepare')
            ->with($this->callback(function ($query) {
                $expectedSql = '/SELECT\s+u\.username.*FROM\s+user_quiz_results/uix';
                return preg_match($expectedSql, preg_replace('/\s+/', ' ', $query)) === 1;
            }))
            ->willReturn($mockedStatement);

        $mockedStatement->expects($this->once())->method('execute');

        $results = $this->userQuizResult->getRecentQuizResults(5);
        $this->assertCount(1, $results);
        $this->assertEquals('Quiz 1', $results[0]['quiz_title']);
    }

    public function testGetResult()
    {
        $mockedStatement = $this->createMock(PDOStatement::class);
        $mockedStatement->expects($this->once())
            ->method('fetch')
            ->willReturn(['score' => 100, 'completed_at' => '2024-01-01']);

        $this->mockedPdo->expects($this->once())
            ->method('prepare')
            ->with($this->callback(function ($query) {
                $expectedSql = '/SELECT\s+score,\s+completed_at.*FROM\s+user_quiz_results/uix';
                return preg_match($expectedSql, preg_replace('/\s+/', ' ', $query)) === 1;
            }))
            ->willReturn($mockedStatement);

        $mockedStatement->expects($this->once())->method('execute');

        $result = $this->userQuizResult->getResult(1, 1);
        $this->assertNotNull($result);
        $this->assertEquals(100, $result['score']);
    }
}
