<?php
session_start();
// Include the mysqli database connection file
require_once '../includes/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate input
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate inputs
    $errors = [];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }

    if (empty($username)) {
        $errors[] = "Username is required";
    }

    if (strlen($password) < 8) {
        $errors[] = "Password must be at least 8 characters long";
    }

    if ($password !== $confirm_password) {
        $errors[] = "Passwords do not match";
    }

    if (!isset($_POST['terms'])) {
        $errors[] = "You must agree to the terms and conditions";
    }

    // Check if username or email already exists using a prepared statement
    $stmt = $conn->prepare("SELECT username, email FROM users WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $existing_user = $result->fetch_assoc();
    $stmt->close();

    if ($existing_user) {
        if ($existing_user['username'] === $username) {
            $errors[] = "Username already taken";
        }
        if ($existing_user['email'] === $email) {
            $errors[] = "Email already registered";
        }
    }

    // If no errors, register the user
    if (empty($errors)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        // Use a prepared statement to insert the new user
        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $hashed_password);
        
        if ($stmt->execute()) {
            $_SESSION['registration_success'] = true;
            header("Location: ../login.php");
            exit();
        } else {
            $errors[] = "Registration failed: " . $stmt->error;
        }
        $stmt->close();
    }

    // If there are errors, store them in session and redirect back
    if (!empty($errors)) {
        $_SESSION['register_errors'] = $errors;
        $_SESSION['old_input'] = [
            'email' => $email,
            'username' => $username
        ];
        header("Location: ../register.php");
        exit();
    }
} else {
    // If not a POST request, redirect to register page
    header("Location: ../register.php");
    exit();
}
