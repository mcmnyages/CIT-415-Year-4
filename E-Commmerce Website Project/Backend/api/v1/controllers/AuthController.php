<?php

namespace Api\Controllers;

class AuthController {
    public function login() {
        $data = json_decode(file_get_contents('php://input'), true);

        if ($data['email'] === 'admin@example.com' && $data['password'] === 'password') {
            echo json_encode(['message' => 'Login successful']);
        } else {
            http_response_code(401);
            echo json_encode(['error' => 'Invalid credentials']);
        }
    }
}
