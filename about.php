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
    <style>
        /* Card Style Unification */
        .stat-item,
        .mission-card,
        .vision-card {
            background: white;
            border-radius: 15px;
            border: 1px solid #EAEAEA;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05), 0 10px 20px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease;
            padding: 30px;
        }

        .stat-item:hover,
        .mission-card:hover,
        .vision-card:hover {
            transform: translateY(-5px);
        }

        /* Color and Typography Consistency */
        .mission-card h3,
        .vision-card h3 {
            color: var(--orange);
            /* Use theme color */
            margin-bottom: 20px;
            font-size: 1.5rem;
        }

        .stats-section h2,
        .about-content h2 {
            text-align: center;
            font-size: 35px;
            color: #333;
            margin-bottom: 40px;
        }

        .about-content p {
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
            margin-bottom: 20px;
            line-height: 1.7;
            text-align: center;
        }

        /* Section Background Consistency */
        .stats-section {
            background-color: transparent;
            padding: 60px 5%;
        }

        /* Make mission/vision cards equal height */
        .mission-vision {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            margin: 50px auto;
            align-items: stretch;
            max-width: 900px;
        }

        .mission-card,
        .vision-card {
            display: flex;
            flex-direction: column;
            text-align: center;
        }
    </style>
</head>

<body>
    <section class="about-hero">
        <div class="container">
            <h1>About Gujarat Yatar Portal</h1>
            <p>Your gateway to exploring the beautiful state of Gujarat</p>
        </div>
    </section>

    <div class="bg-pattern">
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
    </div> <?php include "includes/footer.php"; ?>
</body>

</html>