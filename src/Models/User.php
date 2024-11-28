<?php

namespace App\Models;

use App\Database\Database;

class User
{
    private $conn;
    private $table_name = 'users';

    public $id;
    public $username;
    public $password;
    public $email;
    public $role;
    public $created_at;

    public function __construct()
    {
        try {
            $db = new Database();
            $this->conn = $db->getPdo();
        } catch (\Exception $e) {
            throw new \Exception('Database connection failed: ' . $e->getMessage());
        }
    }

    public function getAllUsersPaginated($limit, $offset)
    {
        try {
            $query = "SELECT * FROM users LIMIT :limit OFFSET :offset";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':limit', $limit, \PDO::PARAM_INT);
            $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            throw new \Exception('Error fetching users: ' . $e->getMessage());
        }
    }

    public function getUserById($id)
    {
        try {
            $query = "SELECT * FROM users WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
            $stmt->execute();
    
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
    
            return $result ? $result : null;
        } catch (\Exception $e) {
            throw new \Exception('Error fetching user by ID: ' . $e->getMessage());
        }
    }

    public function save()
    {
        try {
            $query = "INSERT INTO {$this->table_name} 
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
        } catch (\Exception $e) {
            throw new \Exception('Error saving user: ' . $e->getMessage());
        }
    }

    public function register($username, $password, $email, $role = 'user')
    {
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

        return $this->save() ? 'Registration successful.' : 'Registration failed.';
    }

    public function create($username, $password, $email, $role)
    {
        try {
            $query = "INSERT INTO users (username, password, email, role) 
                      VALUES (:username, :password, :email, :role)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':username', $username, \PDO::PARAM_STR);
            $stmt->bindParam(':password', $password, \PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, \PDO::PARAM_STR);
            $stmt->bindParam(':role', $role, \PDO::PARAM_STR);

            return $stmt->execute();
        } catch (\Exception $e) {
            throw new \Exception('Error creating user: ' . $e->getMessage());
        }
    }

    public function update($id, $username, $password, $email, $role)
    {
        try {
            if (empty($username)) {
                throw new \Exception('Nazwa użytkownika nie może być pusta.');
            }

            $sql = "UPDATE users SET username = :username, email = :email, role = :role";
            if (!empty($password)) {
                $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
                $sql .= ", password = :password";
            }
            $sql .= " WHERE id = :id";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':role', $role);
            $stmt->bindParam(':id', $id);

            if (!empty($password)) {
                $stmt->bindParam(':password', $hashedPassword);
            }

            return $stmt->execute();
        } catch (\Exception $e) {
            throw new \Exception('Error updating user: ' . $e->getMessage());
        }
    }

    public function usernameExists($username)
    {
        try {
            $query = "SELECT id FROM {$this->table_name} WHERE username = :username";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':username', $username);
            $stmt->execute();

            $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            return count($result) > 0;
        } catch (\Exception $e) {
            throw new \Exception('Error checking username existence: ' . $e->getMessage());
        }
    }

    public function emailExists($email)
    {
        try {
            $query = "SELECT id FROM {$this->table_name} WHERE email = :email";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            return $stmt->rowCount() > 0;
        } catch (\Exception $e) {
            throw new \Exception('Error checking email existence: ' . $e->getMessage());
        }
    }

    public function login($username, $password)
    {
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
                'message' => 'Login successful.',
            ];
        }

        return 'Invalid username or password.';
    }

    public function getUserCount()
    {
        try {
            $query = "SELECT COUNT(*) FROM users";
            $stmt = $this->conn->query($query);

            return $stmt->fetchColumn();
        } catch (\Exception $e) {
            throw new \Exception('Error counting users: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $query = "DELETE FROM users WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
            $result = $stmt->execute();
    
            return $result;
        } catch (\Exception $e) {
            throw new \Exception('Error deleting user: ' . $e->getMessage());
        }
    }

    public function getRoleCounts()
    {
        try {
            $query = "SELECT role, COUNT(*) AS user_count FROM users GROUP BY role";
            return $this->conn->query($query)->fetchAll();
        } catch (\Exception $e) {
            throw new \Exception('Error fetching role counts: ' . $e->getMessage());
        }
    }
}
