<?php
include "header.php";
$page_title = "About Us - Gujarat Yatar Portal";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
</head>

<body>
    <?php include "header.php"; ?>

    <section class="about-hero">
        <div class="container">
            <h1>About Gujarat Yatar Portal</h1>
            <p>Your gateway to exploring the beautiful state of Gujarat</p>
        </div>
    </section>
    <section class="stats-section">
        <div class="container">
            <h2>Our Achievements</h2>
            <div class="stats-grid">
                <div class="stat-item">
                    <div class="stat-number">10,000+</div>
                    <div class="stat-label">Happy Travelers</div>
                </div>

                <div class="stat-item">
                    <div class="stat-number">500+</div>
                    <div class="stat-label">Tour Packages</div>
                </div>

                <div class="stat-item">
                    <div class="stat-number">50+</div>
                    <div class="stat-label">Destinations</div>
                </div>

                <div class="stat-item">
                    <div class="stat-number">98%</div>
                    <div class="stat-label">Satisfaction Rate</div>
                </div>
            </div>
        </div>
    </section>

    <section class="about-content">
        <div class="container">
            <h2>Our Story</h2>
            <p> Welcome to Gujarat Yatar Portal, your trusted partner in exploring the vibrant and diverse landscapes of
                Gujarat. Our mission is to provide a seamless travel experience for everyone, showcasing the state's
                rich cultural heritage, natural beauty, and diverse experiences.</p>

            <p>Our platform connects travelers with the best tour packages, accommodations, and local experiences,
                ensuring that every visit to Gujarat is memorable and enriching.</p>

            <div class="mission-vision">
                <div class="mission-card">
                    <h3>Our Mission</h3>
                    <p>To promote sustainable tourism in Gujarat by providing authentic travel experiences, supporting
                        local communities, and preserving the cultural and natural heritage of the state.</p>
                </div>

                <div class="vision-card">
                    <h3>Our Vision</h3>
                    <p>To become the leading platform for Gujarat tourism, recognized for excellence in service,
                        innovation in travel experiences, and commitment to sustainable tourism practices.</p>
                </div>
            </div>
        </div>
    </section>

    <?php include "includes/footer.php"; ?>
</body>

</html>