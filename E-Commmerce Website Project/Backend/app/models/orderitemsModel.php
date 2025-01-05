<?php

// Include database configuration
require_once __DIR__ . '/../config/database.php';


class CreateOrderItemTable {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function createOrderItemsTable() {
        try {
            // Check if table exists
            $tableExists = $this->conn->query("SHOW TABLES LIKE 'order_items'")->rowCount() > 0;
            
            if ($tableExists) {
                echo "Order items table already exists\n";
                return;
            }

            $sql = "CREATE TABLE order_items (
                id INT AUTO_INCREMENT PRIMARY KEY,
                order_id INT NOT NULL,
                product_id INT NOT NULL,
                quantity INT NOT NULL,
                price DECIMAL(10,2) NOT NULL,
                FOREIGN KEY (order_id) REFERENCES orders(id),
                FOREIGN KEY (product_id) REFERENCES products(id)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

            $this->conn->exec($sql);
            echo "Order items table created successfully\n";
        } catch (PDOException $e) {
            die("Error creating order items table: " . $e->getMessage());
        }
    }
}

// Initialize and create table
try {
    $createOrderItemTable = new CreateOrderItemTable();
    $createOrderItemTable->createOrderItemsTable();
} catch(Exception $e) {
    die("Error initializing order items table: " . $e->getMessage());
}
?>