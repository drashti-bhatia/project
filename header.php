<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gujarat Yatra Portal</title>
    <link rel="stylesheet" href="assets/css/style.css">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded"/>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <header>
        <div class="container main-header">
            <div class="logo">
                <a href="index.php">
                    <img src="assets/img/logo/logo.png" alt="The Gujarat Yatra Portal logo">
                    <span class="logo-text">Gujarat Yatra Portal</span>
                </a>
            </div>

            <div class="links">
                <nav class="main-nav">
                    <ul>
                        <li><a href="index.php">Home</a></li>
                        <li><a href="attractions.php">Attractions</a></li>
                        <li><a href="packages.php">Packages</a></li>
                        <li><a href="cities.php">Cities</a></li>
                        <li><a href="about.php">About Us</a></li>
                    </ul>
                </nav>

                <div class="search-container">
                    <span class="material-symbols-rounded search-icon-input">search</span>
                    <input type="text" class="search-input" placeholder="       Search...">
                </div>

                <div class="header-actions">
                    <div class="user-actions">
                        <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
                            <div class="dropdown">
                                <button class="user-btn"><i class="fas fa-user"></i></button>
                                <div class="dropdown-content">
                                    <a href="my_bookings.php">My Bookings</a>
                                    <a href="reviews.php">My Reviews</a>
                                    <a href="logout.php">Logout</a>
                                </div>
                            </div>
                    </div>

                <?php else: ?>
                    <a href="login.php" class="btn btn-login">Login</a>
                <?php endif; ?>

                <div class="mobile-menu-icon">
                    <i class="fas fa-bars"></i>
                </div>
                </div>
            </div>
        </div>
    </header>
    <main>