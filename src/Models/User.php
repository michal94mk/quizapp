<?php

namespace App\Models;

use App\Database\Database;

class User {
    private $conn;
    private $table_name = 'users';

    public $id;
    public $username;
    public $password;
    public $email;
    public $role;
    public $created_at;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getPdo();
    }

    public function save() {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET username = :username, 
                      password = :password, 
                      email = :email, 
                      role = :role";

        $stmt = $this->conn->prepare($query);

        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->password = htmlspecialchars(strip_tags($this->password));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->role = htmlspecialchars(strip_tags($this->role));

        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':password', $this->password);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':role', $this->role);

        return $stmt->execute();
    }

    public function register($username, $password, $email, $role = 'user') {
        if ($this->usernameExists($username)) {
            return 'Username already exists.';
        }
    
        if ($this->emailExists($email)) {
            return 'Email already exists.';
        }
    
        $this->username = $username;
        $this->password = password_hash($password, PASSWORD_BCRYPT);
        $this->email = $email;
        $this->role = $role;
    
        if ($this->save()) {
            return 'Registration successful.';
        } else {
            return 'Registration failed.';
        }
    }

    public function usernameExists($username) {
        $query = "SELECT id FROM " . $this->table_name . " WHERE username = :username";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }

    public function emailExists($email) {
        $query = "SELECT id FROM " . $this->table_name . " WHERE email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }

    public function login($username, $password) {
        $query = "SELECT id, username, role, password FROM users WHERE username = :username";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);
        
        if ($user && password_verify($password, $user['password'])) {
            return [
                'id' => $user['id'],
                'username' => $user['username'],
                'role' => $user['role'],
                'message' => 'Login successful.'
            ];
        } else {
            return 'Invalid username or password.';
        }
    }    
}
