<?php

namespace Middleware;

class AuthMiddleware {
    public static function check() {
        if (!isset($_SESSION['user'])) {
            http_response_code(403);
            echo json_encode(['error' => 'Unauthorized']);
            exit;
        }
    }
}
