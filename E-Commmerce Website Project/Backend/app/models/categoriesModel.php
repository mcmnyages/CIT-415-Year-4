<?php

require_once __DIR__ . '/../config/database.php';

class CreateCategoryTable {
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


    public function createCategoriesTable() {
        try {
            // Check if the table already exists
            $tableExists = $this->conn->query("SHOW TABLES LIKE 'categories'")->rowCount() > 0;

            if ($tableExists) {
                echo "categories table already exists\n";
                return;
            }

            if (!$tableExists) {
                // SQL query to create the `categories` table
                $sql = "
                    CREATE TABLE categories (
                        id INT AUTO_INCREMENT PRIMARY KEY,
                        name VARCHAR(255) NOT NULL,
                        description TEXT,
                        parent_id INT,
                        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                        FOREIGN KEY (parent_id) REFERENCES categories(id) ON DELETE SET NULL
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
                ";

                // Execute the query
                $this->conn->exec($sql);
                echo "Table 'categories' created successfully.\n";
            } else {
                echo "Table 'categories' already exists.\n";
            }
        } catch (PDOException $e) {
            die("Error creating table: " . $e->getMessage());
        }
    }
}

// Usage
try{
    $createCategoryTable = new CreateCategoryTable();
    $createCategoryTable->createCategoriesTable();
}catch(Exception $e){
    die("Error Creating categories table!: " . $e->getMessage().'\n');
}
