<?php

namespace App\Database;

use PDO;
use PDOException;

class Database {
    private $pdo;

    public function __construct() {

        $dotenv = \Dotenv\Dotenv::createUnsafeImmutable(__DIR__.'/../../');
        $dotenv->load();

        $dsn = sprintf(
            'mysql:host=%s;dbname=%s',
            getenv('DB_HOST'),
            getenv('DB_NAME')
        );

        try {
            $this->pdo = new PDO($dsn, getenv('DB_USER'), getenv('DB_PASS'));
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            throw new \RuntimeException("Connection failed: " . $e->getMessage());
        }
    }

    public function getPdo() {
        return $this->pdo;
    }
}
