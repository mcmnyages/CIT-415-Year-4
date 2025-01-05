<?php

global $router;

// Auth routes
$router->addRoute('POST', '/api/v1/login', [\Api\Controllers\AuthController::class, 'login']);
$router->addRoute('GET', '/api/v1/products', [\Api\Controllers\ProductController::class, 'index']);
