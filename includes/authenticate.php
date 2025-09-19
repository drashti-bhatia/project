<?php
session_start();
// Include the mysqli database connection file
require_once 'db_connect.php'; // Corrected path to db_connect.php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize input to prevent SQL injection
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $password = $_POST['password'];

    // Validate inputs
    $errors = [];

    if (empty($username)) {
        $errors[] = "Username is required";
    }

    if (empty($password)) {
        $errors[] = "Password is required";
    }

    if (empty($errors)) {
        // Use a prepared statement to prevent SQL injection
        $stmt = $conn->prepare("SELECT user_id, username, password, is_admin FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();

        if ($user && password_verify($password, $user['password'])) {
            // Login successful, set session variables
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['loggedin'] = true;

            // Check if the user is an admin
            if ($user['is_admin'] == 1) {
                $_SESSION['is_admin'] = true;
                // Corrected path for admin dashboard
                header("Location: ../admin/dashboard.php");
            } else {
                $_SESSION['is_admin'] = false;
                // Path for regular users
                header("Location: ../index.php");
            }
            exit();
        } else {
            $errors[] = "Invalid username or password";
        }
    }

    // If there are errors, store them in session and redirect back
    if (!empty($errors)) {
        $_SESSION['login_errors'] = $errors;
        $_SESSION['old_username'] = $username;
        header("Location: ../login.php");
        exit();
    }
} else {
    // If not a POST request, redirect to login page
    header("Location: ../login.php");
    exit();
}
