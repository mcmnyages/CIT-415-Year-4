<?php

// Include database configuration
require_once __DIR__ . '/../../app/config/database.php';

require_once __DIR__ . '/../../app/models/userModel.php';
require_once __DIR__ . '/../../app/models/categoriesModel.php';
require_once __DIR__ . '/../../app/models/productsModel.php';
require_once __DIR__ . '/../../app/models/ordersModel.php';
require_once __DIR__ . '/../../app/models/orderitemsModel.php';
require_once __DIR__ . '/../../app/models/cartModel.php';

try {
    echo "Starting database initialization...\n";

    // Create tables in order (respect foreign key constraints)

     $createProductTable = new CreateProductTable();
    $createProductTable->createProductsTable();

    $createUserTable = new CreateUserTable();
    $createUserTable->createUsersTable();

    $createCategoryTable = new CreateCategoryTable();
    $createCategoryTable->createCategoriesTable();



    $createOrderTable = new CreateOrderTable();
    $createOrderTable->createOrdersTable();

    $createOrderItemTable = new CreateOrderItemTable();
    $createOrderItemTable->createOrderItemsTable();

    $createCartTable = new CreateCartTable();
    $createCartTable->createCartTable();

    echo "Database initialization completed successfully!\n";
} catch(Exception $e) {
    die("Database initialization failed: " . $e->getMessage());
}
?>