<?php

require_once __DIR__ . '../../../../../Backend/app/config/database.php';
require_once __DIR__ . '/../../../../Backend/app/models/userSignupModel.php';

use Models\User;

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    // Validate input
    if (empty($name) || empty($email) || empty($password)) {
        $message = 'All fields are required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = 'Invalid email format.';
    } else {
        try {
            // Instantiate Database class and get the connection
            $database = new Database();
            $db = $database->getConnection();

            // Check if the email is already registered
            if (User::findByEmail($db, $email)) {
                $message = 'Email is already registered.';
            } else {
                // Securely hash the password
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                // Create the user
                User::create($db, $name, $email, $hashedPassword);
                $message = 'Registration successful!';
            }
        } catch (Exception $e) {
            $message = 'An error occurred: ' . htmlspecialchars($e->getMessage());
        }
    }
}
?>

