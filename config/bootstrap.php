<?php

// Autoload Composer dependencies
require_once __DIR__ . '/../vendor/autoload.php';

// Load environment variables from .env file
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// Set error reporting levels
error_reporting(E_ALL);
ini_set('display_errors', getenv('APP_ENV') === 'development' ? '1' : '0');

// Set default timezone
date_default_timezone_set(getenv('APP_TIMEZONE') ?: 'UTC');

// Start session if session driver is set
if (getenv('SESSION_DRIVER') === 'session') {
    session_start();
}