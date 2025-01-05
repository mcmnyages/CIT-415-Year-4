<?php

namespace Api\Services;

require_once __DIR__ . '/../../app/config/database.php';

use Models\User;


class UserService {
    public static function register($name, $email, $password) {
        // Instantiate the Database class and get the connection
        $database = new \Database();
        $db = $database->getConnection();

        // Check if the email is already registered
        if (User::findByEmail($db, $email)) {
            throw new \Exception('Email is already registered');
        }

        // Hash the password and save the user
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        User::create($db, $name, $email, $hashedPassword);
    }
}