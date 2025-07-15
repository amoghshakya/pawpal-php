<?php

namespace App\Config;

use PDO;
use PDOException;


class Database
{
    private static ?PDO $pdo = null;

    public static function getConnection(): PDO
    {
        if (self::$pdo === null) {

            // Load environment variables
            $host = $_ENV['DB_HOST'] ?? 'localhost';
            $db = $_ENV['DB_NAME'] ?? 'pawpal';
            $user = $_ENV['DB_USER'] ?? 'root';
            $pass = $_ENV['DB_PASS'] ?? '';
            $port = $_ENV['DB_PORT'] ?? '3306';

            $dsn = "mysql:host=$host;dbname=$db;port=$port;charset=utf8mb4";

            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Throw exceptions on errors
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Fetch associative arrays by default
                PDO::ATTR_EMULATE_PREPARES   => false,                  // Use native prepared statements
            ];

            try {
                self::$pdo = new PDO($dsn, $user, $pass, $options);
            } catch (PDOException $e) {
                // Handle connection errors
                die("Database connection failed: " . $e->getMessage());
            }
        }

        return self::$pdo;
    }
}
