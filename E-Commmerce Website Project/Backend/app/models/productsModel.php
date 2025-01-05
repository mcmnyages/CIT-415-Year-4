<?php

require_once __DIR__ . '/../config/database.php';

class CreateProductTable {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function createProductsTable() {
        try {
            // Check if table exists
            $tableExists = $this->conn->query("SHOW TABLES LIKE 'products'")->rowCount() > 0;
            
            if ($tableExists) {
                echo "Products table already exists\n";
                return;
            }

            $sql = "CREATE TABLE products (
                id INT AUTO_INCREMENT PRIMARY KEY,
                category_id INT NOT NULL,
                name VARCHAR(255) NOT NULL,
                description TEXT,
                price DECIMAL(10,2) NOT NULL,
                stock_quantity INT NOT NULL DEFAULT 0,
                image_url VARCHAR(255),
                status ENUM('active', 'inactive') DEFAULT 'active',
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                FOREIGN KEY (category_id) REFERENCES categories(id)
            )";

            $this->conn->exec($sql);
            echo "Products table created successfully.\n";
        } catch (PDOException $e) {
            die("Error creating table: " . $e->getMessage());
        }
    }
}

// Usage
try {
    $createProductTable = new CreateProductTable();
    $createProductTable->createProductsTable();
} catch(Exception $e) {
    die("Error Creating products table!: " . $e->getMessage());
}
?>