<?php

use PHPUnit\Framework\TestCase;
use App\Models\UserAnswer;
use App\Database\Database;

class UserAnswerTest extends TestCase
{
    private $mockedDb;
    private $mockedPdo;

    protected function setUp(): void
    {
        $this->mockedPdo = $this->createMock(PDO::class);
        $this->mockedDb = $this->createMock(Database::class);

        $this->mockedDb->method('getPdo')->willReturn($this->mockedPdo);
    }

    public function testSaveUsesDatabaseWhenNoPdoProvided()
    {
        $stmtMock = $this->createMock(PDOStatement::class);

        $this->mockedPdo->expects($this->once())
            ->method('prepare')
            ->with($this->stringContains("INSERT INTO user_answers"))
            ->willReturn($stmtMock);

        $stmtMock->expects($this->once())
            ->method('execute');

        // Mockowanie klasy Database i przekazanie jej PDO do UserAnswer
        $userAnswer = new UserAnswer();
        $reflection = new ReflectionClass($userAnswer);
        $connProperty = $reflection->getProperty('conn');
        $connProperty->setAccessible(true);
        $connProperty->setValue($userAnswer, $this->mockedPdo);

        $userAnswer->user_id = 1;
        $userAnswer->question_id = 2;
        $userAnswer->answer_id = 3;

        $userAnswer->save();
    }
}
