<?php

namespace Models;

class User {
    public static function create($db, $name, $email, $password) {
        try {
            $stmt = $db->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
            $stmt->execute([
                ':name' => $name,
                ':email' => $email,
                ':password' => $password,
            ]);
            return ['success' => true, 'message' => 'User created successfully.'];
        } catch (\PDOException $e) {
            return ['success' => false, 'message' => 'Error creating user: ' . $e->getMessage()];
        }
    }

    public static function findByEmail($db, $email) {
        try {
            $stmt = $db->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->execute([':email' => $email]);
            $user = $stmt->fetch();
            if ($user) {
                return ['success' => true, 'data' => $user];
            } else {
                return ['success' => false, 'message' => 'User not found.'];
            }
        } catch (\PDOException $e) {
            return ['success' => false, 'message' => 'Error finding user: ' . $e->getMessage()];
        }
    }
}
