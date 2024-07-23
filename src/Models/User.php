<?php

namespace App\Models;

use App\Database\Database;
use PDO;

class User {
    private $conn;
    private $table_name = 'users';

    public $id;
    public $username;
    public $password;
    public $email;
    public $role;  // Dodana kolumna
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

    public function login($username, $password) {
        $query = "SELECT password, role FROM " . $this->table_name . " WHERE username = :username LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        if ($stmt->rowCount() === 0) {
            return 'Username does not exist.';
        }

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $hashedPassword = $row['password'];
        $role = $row['role'];

        if (password_verify($password, $hashedPassword)) {
            return ['message' => 'Login successful.', 'role' => $role];
        } else {
            return 'Invalid password.';
        }
    }
}
