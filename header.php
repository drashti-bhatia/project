<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gujarat Yatar Portal</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>
<body class="bg-pattern">
    <header class="main-header">
        <div class="main-header">
            <div class="logo">
                <a href="index.php">
                    <img src="assets/img/logo/logo.png" alt="Gujarat Yatra Portal">
                    <span class="logo-text">Gujarat Yatra Portal</span>
                </a>
            </div>

            <div class="header-right">
                <nav class="main-nav">
                    <ul>
                        <li><a href="index.php">Home</a></li>
                        <li><a href="attractions.php">Attractions</a></li>
                        <li><a href="packages/packages.php">Packages</a></li>
                        <li><a href="about.php">About Us</a></li>
                    </ul>
                </nav>

                <div class="search-container">
                    <span class="material-symbols-rounded">search</span>
                    <input type="text" class="search-input" placeholder="Search...">
                </div>

                <div class="user-actions">
                    <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
                        <div class="dropdown">
                            <button class="user-btn"><i class="fas fa-user"></i></button>
                            <div class="dropdown-content">
                                <a href="packages/bookings.php">My Bookings</a>
                                <a href="reviews/reviews.php">My Reviews</a>
                                <a href="logout.php">Logout</a>
                            </div>
                        </div>
                    <?php else: ?>
                        <a href="login.php" class="btn btn-login">Login</a>
                    <?php endif; ?>
                </div>

                <div class="mobile-menu-icon">
                    <i class="fas fa-bars"></i>
                </div>
            </div>
        </div>
    </header>
    <main>