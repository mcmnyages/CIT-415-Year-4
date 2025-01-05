<?php
// backend/public/register.php

// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods');

// Include database and user model
require_once '../app/Config/Database.php';
require_once '../app/Models/User.php';

// Initialize database connection
$database = new Database();
$db = $database->getConnection();

// Initialize user object
$user = new User($db);

// Get posted data
$data = json_decode(file_get_contents("php://input"));

if(!empty($data)) {
    // Set user properties
    $user->username = $data->username ?? null;
    $user->email = $data->email ?? null;
    $user->password = $data->password ?? null;
    $user->first_name = $data->first_name ?? null;
    $user->last_name = $data->last_name ?? null;
    $user->address = $data->address ?? null;
    $user->phone = $data->phone ?? null;

    // Create user
    $result = $user->create();

    // Set response code
    http_response_code($result['success'] ? 201 : 400);

    // Send response
    echo json_encode($result);
} else {
    // Set response code - 400 bad request
    http_response_code(400);
    
    // Tell the user
    echo json_encode([
        "success" => false,
        "errors" => ["Missing required data"]
    ]);
}