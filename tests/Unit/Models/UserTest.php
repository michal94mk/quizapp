<?php

use PHPUnit\Framework\TestCase;
use App\Models\User;
use App\Database\Database;

class UserTest extends TestCase
{
    private $mockedDb;
    private $mockedPdo;
    private $user;

    protected function setUp(): void
    {
        $this->mockedDb = $this->createMock(Database::class);

        $this->mockedPdo = $this->createMock(PDO::class);
        $this->mockedDb->method('getPdo')->willReturn($this->mockedPdo);

        $this->user = new User();

        $reflection = new ReflectionClass($this->user);
        $connProperty = $reflection->getProperty('conn');
        $connProperty->setAccessible(true);
        $connProperty->setValue($this->user, $this->mockedPdo);
    }

    public function testGetAllUsersPaginated()
    {
        $mockedStatement = $this->createMock(PDOStatement::class);
        $mockedStatement->expects($this->once())
            ->method('fetchAll')
            ->willReturn([['id' => 1, 'username' => 'test_user']]);

        $this->mockedPdo->expects($this->once())
            ->method('prepare')
            ->with($this->stringContains('SELECT * FROM users LIMIT :limit OFFSET :offset'))
            ->willReturn($mockedStatement);

        $mockedStatement->expects($this->once())->method('execute');

        $result = $this->user->getAllUsersPaginated(10, 0);
        $this->assertCount(1, $result);
        $this->assertEquals('test_user', $result[0]['username']);
    }

    public function testGetUserById()
    {
        $mockedStatement = $this->createMock(PDOStatement::class);
        $mockedStatement->expects($this->once())
            ->method('fetch')
            ->willReturn(['id' => 1, 'username' => 'test_user']);

        $this->mockedPdo->expects($this->once())
            ->method('prepare')
            ->with($this->stringContains('SELECT * FROM users WHERE id = :id'))
            ->willReturn($mockedStatement);

        $mockedStatement->expects($this->once())->method('execute');

        $result = $this->user->getUserById(1);
        $this->assertNotNull($result);
        $this->assertEquals('test_user', $result['username']);
    }

    public function testSave()
    {
        $mockedStatement = $this->createMock(PDOStatement::class);
        $mockedStatement->expects($this->once())
            ->method('execute')
            ->willReturn(true);
    
        $this->mockedPdo->expects($this->once())
            ->method('prepare')
            ->with($this->callback(function ($query) {
                $expectedSql = '/INSERT INTO users\s+SET\s+username\s*=\s*:username,\s+password\s*=\s*:password,\s+email\s*=\s*:email,\s+role\s*=\s*:role/i';
                return preg_match($expectedSql, $query) === 1;
            }))
            ->willReturn($mockedStatement);
    
        $this->user->username = 'test_user';
        $this->user->password = 'password123';
        $this->user->email = 'test@example.com';
        $this->user->role = 'user';
    
        $result = $this->user->save();
        $this->assertTrue($result);
    }
    

    public function testUsernameExists()
    {
        $mockedStatement = $this->createMock(PDOStatement::class);
        $mockedStatement->expects($this->once())
            ->method('fetchAll')
            ->willReturn([['id' => 1]]);

        $this->mockedPdo->expects($this->once())
            ->method('prepare')
            ->with($this->stringContains('SELECT id FROM users WHERE username = :username'))
            ->willReturn($mockedStatement);

        $mockedStatement->expects($this->once())->method('execute');

        $result = $this->user->usernameExists('test_user');
        $this->assertTrue($result);
    }

    public function testLoginSuccess()
    {
        $mockedStatement = $this->createMock(PDOStatement::class);
        $mockedStatement->expects($this->once())
            ->method('fetch')
            ->willReturn([
                'id' => 1,
                'username' => 'test_user',
                'password' => password_hash('password123', PASSWORD_BCRYPT),
                'role' => 'user',
            ]);

        $this->mockedPdo->expects($this->once())
            ->method('prepare')
            ->with($this->stringContains('SELECT id, username, role, password FROM users WHERE username = :username'))
            ->willReturn($mockedStatement);

        $mockedStatement->expects($this->once())->method('execute');

        $result = $this->user->login('test_user', 'password123');
        $this->assertIsArray($result);
        $this->assertEquals('test_user', $result['username']);
    }
}
