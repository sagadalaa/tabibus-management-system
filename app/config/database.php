<?php
/**
 * Database Connection for Clinic Management System
 * Author: Your Name
 * Description: Centralized database connection using PDO.
 */

class Database
{
    private static $instance = null; // Singleton instance
    private $connection; // PDO connection instance

    /**
     * Database Constructor
     * Initializes the PDO connection using configuration.
     */
    private function __construct()
    {
        try {
            // Load configuration
            $config = require __DIR__ . '/config.php';
            $dbConfig = $config['database'];

            // DSN (Data Source Name)
            $dsn = "mysql:host={$dbConfig['host']};dbname={$dbConfig['name']};charset={$dbConfig['charset']}";

            // Create a new PDO connection
            $this->connection = new PDO($dsn, $dbConfig['user'], $dbConfig['password']);

            // Set PDO options for better error handling and performance
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $this->connection->setAttribute(PDO::ATTR_PERSISTENT, true); // Persistent connection
        } catch (PDOException $e) {
            // Handle connection error
            $this->handleError($e->getMessage());
        }
    }

    /**
     * Get the singleton instance of the Database class.
     * 
     * @return Database
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    /**
     * Get the PDO connection instance.
     * 
     * @return PDO
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * Handle Database Errors
     * 
     * @param string $error
     */
    private function handleError($error)
    {
        // Log the error to a file (if enabled in config)
        $config = require __DIR__ . '/config.php';
        if ($config['environment']['log_errors']) {
            $logFile = $config['paths']['logs'] . '/database_error.log';
            file_put_contents($logFile, '[' . date('Y-m-d H:i:s') . '] ' . $error . PHP_EOL, FILE_APPEND);
        }

        // Optionally, display a user-friendly message (disable in production)
        if ($config['environment']['debug']) {
            die("Database Error: " . htmlspecialchars($error));
        } else {
            die("A system error occurred. Please try again later.");
        }
    }
}
