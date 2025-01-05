<?php
// userModel.php

// Include database configuration
require_once __DIR__ . '/../config/database.php';
class CreateUserTable {
    private $conn;

    public function __construct() {
        try {
            // Get database connection from config
            $database = new Database();
            $this->conn = $database->getConnection();
            
            if ($this->conn === null) {
                throw new Exception("Failed to connect to database");
            }
            
            echo "Connected successfully\n";
        } catch(Exception $e) {
            die("Connection failed: " . $e->getMessage() . "\n");
        }
    }

    public function createUsersTable() {
        try {
            // Check if table exists
            $tableExists = $this->conn->query("SHOW TABLES LIKE 'users'")->rowCount() > 0;
            
            if ($tableExists) {
                echo "Users table already exists\n";
                return;
            }

            // SQL to create users table
            $sql = "CREATE TABLE users (
                id INT PRIMARY KEY AUTO_INCREMENT,
                username VARCHAR(50) NOT NULL UNIQUE,
                email VARCHAR(100) NOT NULL UNIQUE,
                password VARCHAR(255) NOT NULL,
                first_name VARCHAR(50),
                last_name VARCHAR(50),
                address TEXT,
                phone VARCHAR(20),
                role ENUM('user', 'admin') DEFAULT 'user',
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                INDEX idx_email (email),
                INDEX idx_username (username)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

            // Execute the SQL
            $this->conn->exec($sql);
            echo "Users table created successfully\n";

        } catch(PDOException $e) {
            die("Error creating table: " . $e->getMessage() . "\n");
        }
    }
}

// Usage
try {
    $setup = new CreateUserTable();
    $setup->createUsersTable();
} catch(Exception $e) {
    die("Error creating users table!: " . $e->getMessage() . "\n");
}

?>