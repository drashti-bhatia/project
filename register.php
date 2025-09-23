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
    <title>Register - Gujarat Yatra Portal</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>

<body>
    <div class="bg-pattern">
        <div class="class= auth-page-body">
            <div class="auth-card">
                <div class="auth-illustration-col">
                    <img src="assets/img/undraw_travelers_kud9.svg" alt="Person planning a trip">
                </div>
                <div class="auth-form-col">
                    <div class="auth-form-content">
                        <div class="auth-logo">
                            <a href="index.php">
                                <img src="assets/img/logo/logo.png" alt="Gujarat Yatra Portal Logo">
                                <span class="auth-logo-text">Gujarat Yatra Portal</span>
                            </a>
                        </div>

                        <hr>

                        <h2>Create Your Account</h2>
                        <p>Start your journey with us today.</p>

                        <?php if (!empty($errors)): ?>
                            <div class="auth-error">
                                <?php foreach ($errors as $error): ?>
                                    <p><?php echo htmlspecialchars($error); ?></p>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                        <form action="includes/process_register.php" method="POST">
                            <div class="input-wrapper">
                                <label for="email">Email Address</label>
                                <span class="material-symbols-rounded input-icon">mail</span>
                                <input type="email" id="email" name="email" placeholder="Enter your email" value="<?php echo htmlspecialchars($old_input['email'] ?? ''); ?>" required>
                            </div>
                            <div class="input-wrapper">
                                <label for="username">Username</label>
                                <span class="material-symbols-rounded input-icon">person</span>
                                <input type="text" id="username" name="username" placeholder="Choose a username" value="<?php echo htmlspecialchars($old_input['username'] ?? ''); ?>" required>
                            </div>
                            <div class="input-wrapper">
                                <label for="password">Password</label>
                                <span class="material-symbols-rounded input-icon">lock</span>
                                <input type="password" id="password" name="password" placeholder="Create a password" required>
                            </div>
                            <div class="input-wrapper">
                                <label for="confirm_password">Confirm Password</label>
                                <span class="material-symbols-rounded input-icon">password</span>
                                <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm your password" required>
                            </div>

                            <button type="submit" class="btn-auth-submit">Create Account</button>
                        </form>
                        <div class="bottom-link">
                            Already have an account? <a href="login.php">Sign in</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>