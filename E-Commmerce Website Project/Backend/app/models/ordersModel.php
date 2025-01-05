<?php
// Include database configuration
require_once __DIR__ . '/../config/database.php';

class CreateOrderTable {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function createOrdersTable() {
        try {
            // Check if table exists
            $tableExists = $this->conn->query("SHOW TABLES LIKE 'orders'")->rowCount() > 0;
            
            if ($tableExists) {
                echo "Orders table already exists\n";
                return;
            }

            $sql = "CREATE TABLE orders (
                id INT AUTO_INCREMENT PRIMARY KEY,
                user_id INT NOT NULL,
                total_amount DECIMAL(10,2) NOT NULL,
                status ENUM('pending', 'processing', 'completed', 'cancelled') DEFAULT 'pending',
                shipping_address TEXT NOT NULL,
                payment_status ENUM('pending', 'paid', 'failed') DEFAULT 'pending',
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                FOREIGN KEY (user_id) REFERENCES users(id)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

            $this->conn->exec($sql);
            echo "Orders table created successfully\n";
        } catch (PDOException $e) {
            die("Error creating orders table: " . $e->getMessage());
        }
    }
}

// Initialize and create table
try {
    $createOrderTable = new CreateOrderTable();
    $createOrderTable->createOrdersTable();
} catch(Exception $e) {
    die("Error initializing orders table: " . $e->getMessage());
}
?>