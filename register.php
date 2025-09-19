<?php
session_start();
$errors = $_SESSION['register_errors'] ?? [];
$old_input = $_SESSION['old_input'] ?? [];
unset($_SESSION['register_errors']);
unset($_SESSION['old_input']);
?> 

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Gujarat Yatar Portal</title>
    <link rel="stylesheet" href="assets/css/style.css">

    <style>

    </style>
</head>

<body>
    <section class="register-section">
        <div class="register-container">
            <div class="register-logo">
                <img src="assets/img/logo.png" alt="Gujarat Tourism">
            </div>

            <h2 class="register-title">Create Your Account</h2>
            <?php if (!empty($errors)): ?>
                <div class="register-error">
                    <?php foreach ($errors as $error): ?>
                        <p><?php echo htmlspecialchars($error); ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <form action="includes/process_register.php" method="POST">
                <div class="register-form-group">
                    <label for="email" class="register-label">Email Address</label>
                    <input type="email" id="email" name="email" class="register-input" value="<?php echo htmlspecialchars($old_input['email'] ?? ''); ?>" required>
                </div>

                <div class="register-form-group">
                    <label for="username" class="register-label">Username</label>
                    <input type="text" id="username" name="username" class="register-input" value="<?php echo htmlspecialchars($old_input['username'] ?? ''); ?>" required>
                </div>

                <div class="register-form-group">
                    <label for="password" class="register-label">Password</label>
                    <input type="password" id="password" name="password" class="register-input" required>
                </div>

                <div class="register-form-group">
                    <label for="confirm_password" class="register-label">Confirm Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" class="register-input"
                        required>
                </div>

                <div class="terms-checkbox">
                    <input type="checkbox" id="terms" name="terms" required>
                    <label for="terms">I agree to the terms...</label>
                </div>

                <button type="submit" class="btn-register">Register</button>

                <div class="register-links">
                    <p class="login-link">Already have an account? <a href="login.php">Login here</a></p>
                </div>
            </form>
        </div>
    </section>
</body>
</html>
