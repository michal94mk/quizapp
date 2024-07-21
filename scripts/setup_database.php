<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

$path = __DIR__ . '/..';
$dotenv = Dotenv::createUnsafeImmutable($path);
$dotenv->load();

$dbConfig = [
    'host' => getenv('DB_HOST'),
    'database' => getenv('DB_NAME'),
    'username' => getenv('DB_USER'),
    'password' => getenv('DB_PASS'),
    'charset' => getenv('DB_CHARSET'),
];

try {
    $dsn = "mysql:host={$dbConfig['host']};dbname={$dbConfig['database']};charset={$dbConfig['charset']}";
    $pdo = new PDO($dsn, $dbConfig['username'], $dbConfig['password']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected to the database successfully!";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
