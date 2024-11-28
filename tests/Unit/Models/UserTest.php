<?php

use PHPUnit\Framework\TestCase;
use App\Models\User;
use App\Database\Database;

class UserTest extends TestCase
{
    private $user;
    private $db;
    
    protected function setUp(): void
    {
        $this->db = new Database();
        $pdo = $this->db->getPdo();
        
        $pdo->exec("SET FOREIGN_KEY_CHECKS = 0;");
        $pdo->exec("DROP TABLE IF EXISTS users;");
        $pdo->exec("SET FOREIGN_KEY_CHECKS = 1;");
        
        $pdo->exec("CREATE TABLE users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(255) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL UNIQUE,
            role VARCHAR(50) DEFAULT 'user',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        );");
        
        $this->user = new User();
    }

    public function testCreateUser()
    {
        $username = 'testuser';
        $password = 'password123';
        $email = 'testuser@example.com';
        
        $result = $this->user->register($username, $password, $email);
        $this->assertEquals('Registration successful.', $result);
    }

    public function testDeleteUser()
    {
        $username = 'todeleteuser';
        $email = 'todeleteuser@example.com';
        
        $this->user->register($username, 'password123', $email);
        
        $this->assertTrue($this->user->usernameExists($username));
        
        $user = $this->user->getUserById($username);
        $userId = $user['id'];
        
        $this->assertTrue($this->user->delete($userId));
        
        $userAfterDelete = $this->user->getUserById($userId);
        
        $this->assertNull($userAfterDelete, 'User should be null after deletion');
    }
}
