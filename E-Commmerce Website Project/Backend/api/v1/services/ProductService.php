<?php

namespace Api\Services;

use PDO;

class ProductService {
    private static function connectDatabase() {
        $dsn = 'mysql:host=localhost;dbname=your_database';
        $username = 'your_username';
        $password = 'your_password';
        return new PDO($dsn, $username, $password);
    }

    public static function getAllProducts() {
        $db = self::connectDatabase();

        $stmt = $db->query('SELECT * FROM products');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
