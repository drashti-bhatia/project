<?php
// Start session if not already started
if (!isset($_SESSION)) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin_styles.css">
</head>
<body>
<header class="admin-header">
    <h2>Gujarat Yatra Portal - Admin Panel</h2>
    <div class="header-welcome">
        <span>Welcome, <?php echo $_SESSION['admin_username'] ?? 'Admin'; ?></span>
        <a href="../logout.php">Logout</a>
    </div>
</header>