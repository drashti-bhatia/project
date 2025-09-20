<?php
session_start();
$errors = $_SESSION['login_errors'] ?? [];
$old_username = $_SESSION['old_username'] ?? '';
unset($_SESSION['login_errors']);
unset($_SESSION['old_username']);

$registration_success = isset($_SESSION['registration_success']) ? true : false;
unset($_SESSION['registration_success']);

// Check if user is already logged in, if so, redirect to dashboard
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header("Location: ../admin/dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Gujarat Yatar Portal</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>

    </style>
</head>

<body>
    <section class="login-section">
        <div class="login-container">
            <div class="login-logo">
                <img src="assets/img/logo.png" alt="Gujarat Tourism">
            </div>

            <h2 class="login-title">Login to Your Account</h2>

            <?php if ($registration_success): ?>
                <div class="login-success" style="color: green; margin-bottom: 15px;">
                    Registration successful! Please login.
                </div>
            <?php endif; ?>

            <?php if (!empty($errors)): ?>
                <div class="login-error">
                    <?php foreach ($errors as $error): ?>
                        <p><?php echo htmlspecialchars($error); ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <form action="includes/authenticate.php" method="POST">
                <div class="login-form-group">
                    <label for="username" class="login-label">Username</label>
                    <input type="text" id="username" name="username" class="login-input"
                        value="<?php echo htmlspecialchars($old_username); ?>" required>
                </div>

                <div class="login-form-group">
                    <label for="password" class="login-label">Password</label>
                    <input type="password" id="password" name="password" class="login-input" required>
                </div>

                <button type="submit" class="btn-login">Login</button>

                <div class="login-links">
                    <a href="forgot-password.php" class="forgot-password">Forgot Password?</a>
                    <p class="register-link">Don't have an account? <a href="register.php">Register here</a></p>
                </div>
            </form>
        </div>
    </section>
</body>
</html>
