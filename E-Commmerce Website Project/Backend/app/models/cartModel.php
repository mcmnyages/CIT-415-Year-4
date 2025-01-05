<?php
// Include database configuration
require_once __DIR__ . '/../config/database.php';

class CreateCartTable {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function createCartTable() {
        try {
            // Check if table exists
            $tableExists = $this->conn->query("SHOW TABLES LIKE 'cart'")->rowCount() > 0;
            
            if ($tableExists) {
                echo "Cart table already exists\n";
                return;
            }

            $sql = "CREATE TABLE cart (
                id INT AUTO_INCREMENT PRIMARY KEY,
                user_id INT NOT NULL,
                product_id INT NOT NULL,
                quantity INT NOT NULL DEFAULT 1,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                FOREIGN KEY (user_id) REFERENCES users(id),
                FOREIGN KEY (product_id) REFERENCES products(id)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

            $this->conn->exec($sql);
            echo "Cart table created successfully\n";
        } catch (PDOException $e) {
            die("Error creating cart table: " . $e->getMessage());
        }
    }
}

// Initialize and create table
try {
    $createCartTable = new CreateCartTable();
    $createCartTable->createCartTable();
} catch(Exception $e) {
    die("Error initializing cart table: " . $e->getMessage(). '\n');
}
?>