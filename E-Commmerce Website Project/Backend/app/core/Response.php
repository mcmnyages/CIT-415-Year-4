<?php

namespace Core;

class Response {
    /**
     * Send a JSON response.
     *
     * @param mixed $data The response data.
     * @param int $status The HTTP status code.
     */
    public static function json($data, $status = 200) {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
}
