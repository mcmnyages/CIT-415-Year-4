<?php

namespace Api\Controllers;

use Api\Services\ProductService;

class ProductController {
    public function index() {
        $products = ProductService::getAllProducts();
        echo json_encode($products);
    }
}
