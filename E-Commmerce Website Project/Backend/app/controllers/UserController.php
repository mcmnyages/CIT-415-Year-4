<?php

namespace Api\Controllers;

use Api\Services\UserService;
use Core\Response;

class UserController {
    public function register() {
        $data = json_decode(file_get_contents('php://input'), true);

        // Validate input
        if (empty($data['name']) || empty($data['email']) || empty($data['password'])) {
            Response::json(['error' => 'All fields are required'], 400);
            return;
        }

        try {
            UserService::register($data['name'], $data['email'], $data['password']);
            Response::json(['message' => 'User registered successfully'], 201);
        } catch (\Exception $e) {
            Response::json(['error' => $e->getMessage()], 500);
        }
    }
}
