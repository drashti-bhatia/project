<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gujarat Yatar Portal</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <header>
        <div class="header-top"> </div>
        </div>
        <div class="container main-header">
            <div class="logo">
                <img src="assets/img/logo/logo.png" alt="Gujarat Yatar Portal">
                <span class="logo-text">Gujarat Yatar Portal</span>
            </div>
            <nav>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="attractions.php">Attractions</a></li>
                    <li><a href="packages/packages.php">Packages</a></li>
                    <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
                        <li><a href="packages/bookings.php">Bookings</a></li>
                        <li><a href="city-detail.php">City Details</a></li>
                        <li><a href="reviews/reviews.php">Review</a></li>                        
                        <li><a href="logout.php">Logout</a></li>
                    <?php else: ?>
                        <li><a href="login.php">Login</a></li>
                    <?php endif; ?>
                    <li><a href="about.php">About Us</a></li>
                </ul>
            </nav>
            <div class="search-icon">
                <i class="fas fa-search"></i>
            </div>
        </div>
    </header>
    <main>
