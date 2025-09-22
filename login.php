<?php
session_start();
$errors = $_SESSION['login_errors'] ?? [];
$old_username = $_SESSION['old_username'] ?? '';
unset($_SESSION['login_errors']);
unset($_SESSION['old_username']);

$registration_success = isset($_SESSION['registration_success']) ? true : false;
unset($_SESSION['registration_success']);

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Gujarat Yatra Portal</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>
<body class="auth-page-body">
    <div class="auth-card">
        <div class="auth-illustration-col">
            <img src="assets/img/undraw_travelers_kud9.svg" alt="Person working on a travel website">
        </div>
        <div class="auth-form-col">
            <div class="auth-form-content">
                <div class="auth-logo">
                    <a href="index.php">
                        <img src="assets/img/logo/logo.png" alt="Gujarat Yatra Portal">
                    </a>
                </div>
                <h2>Welcome Back</h2>
                <p>Login to access your account.</p>

                <?php if ($registration_success): ?>
                    <div class="auth-success">Registration successful! Please login.</div>
                <?php endif; ?>

                <?php if (!empty($errors)): ?>
                    <div class="auth-error">
                        <?php foreach ($errors as $error): ?>
                            <p><?php echo htmlspecialchars($error); ?></p>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <form action="includes/authenticate.php" method="POST">
                    <div class="input-wrapper">
                        <label for="username">Username</label>
                        <span class="material-symbols-rounded input-icon">person</span>
                        <input type="text" id="username" name="username" placeholder="Enter your username" value="<?php echo htmlspecialchars($old_username); ?>" required>
                    </div>
                    <div class="input-wrapper">
                        <label for="password">Password</label>
                        <span class="material-symbols-rounded input-icon">lock</span>
                        <input type="password" id="password" name="password" placeholder="Enter your password" required>
                    </div>
                    <div class="auth-options">
                        <a href="#">Forgot password?</a>
                    </div>
                    <button type="submit" class="btn-auth-submit">Login</button>
                </form>
                <div class="bottom-link">
                    Don't have an account? <a href="register.php">Sign up</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>