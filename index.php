<?php
include "header.php";
include 'includes/db_connect.php';
?>

<div class="bg-pattern">
    <section class="hero" style="padding-top: 25px;">
        <div class="slider-container">
            <div class="slider-wrapper">
                <div class="slide active" style="background-image: url('assets/img/bg/slider1.webp')">
                </div>
                <div class="slide" style="background-image: linear-gradient(rgba(0,0,0,0.3), rgba(0,0,0,0.3)), url('assets/img/bg/slider2.webp')">
                    <div class="slide-content">
                        <h2>
                            Statue of Unity - A Symbol of Unity
                        </h2>
                        <p>
                            Explore the world's tallest statue, a tribute to Sardar Vallabhbhai Patel, standing tall as a symbol of India's unity.
                        </p>
                    </div>
                </div>

                <div class="slide" style="background-image: linear-gradient(rgba(0,0,0,0.3), rgba(0,0,0,0.3)), url('assets/img/bg/slider3.webp')">
                    <div class="slide-content">
                        <h2>Rann of Kutch - A White Desert Wonderland</h2>
                        <p>A mesmerizing white salt desert that hosts the vibrant Rann Utsav festival and is home to unique wildlife.</p>
                    </div>
                </div>

                <div class="slide" style="background-image: linear-gradient(rgba(0,0,0,0.3), rgba(0,0,0,0.3)), url('assets/img/bg/slider4.webp')">
                    <div class="slide-content">
                        <h2>Modhera Sun Temple - An Architectural Marvel</h2>
                        <p>An architectural marvel in Gujarat, this 11th-century temple is dedicated to the sun god Surya. The intricate carvings and a grand stepwell make it a stunning example of ancient Indian artistry.</p>
                    </div>
                </div>

                <div class="slide" style="background-image: linear-gradient(rgba(0,0,0,0.3), rgba(0,0,0,0.3)), url('assets/img/bg/slider5.webp')">
                    <div class="slide-content">
                        <h2>Adalaj Stepwell -A Water Building Marvel</h2>
                        <p>A magnificent five-story deep stepwell near Ahmedabad, Gujarat, celebrated for its intricate carvings and a beautiful fusion of Hindu and Islamic architecture.</p>
                    </div>
                </div>

                <button class="arrow prev" onclick="changeSlide(-1)">
                    <span class="material-symbols-rounded">
                        arrow_back
                    </span>
                </button>
                <button class="arrow next" onclick="changeSlide(1)">
                    <span class="material-symbols-rounded">
                        arrow_forward
                    </span>
                </button>

                <div class="navigation">
                    <div class="nav-dot active" onclick="currentSlide(1)"></div>
                    <div class="nav-dot" onclick="currentSlide(2)"></div>
                    <div class="nav-dot" onclick="currentSlide(3)"></div>
                    <div class="nav-dot" onclick="currentSlide(4)"></div>
                    <div class="nav-dot" onclick="currentSlide(5)"></div>
                </div>

                <div class="progress-bar" id="progressBar"></div>
            </div>
        </div>
    </section>
    <script src="assets/js/slider.js"></script>

    <section class="section">
        <div class="section-header">
            <h2 class="section-title">Popular Destinations</h2>
            <a class="section-link" href="cities.php">View all destinations</a>
            <i class="section-arrow">
                <svg version="1.0" viewBox="0 0 512.000000 512.000000" preserveAspectRatio="xMidYMid meet">
                    <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)" fill="#ffffffff" stroke="none">
                        <path d="M1179 3387 c-64 -34 -102 -93 -107 -166 -2 -32 1 -76 8 -97 10 -32 142 -169 679 -707 446 -447 679 -674 707 -687 50 -25 133 -26 182 -3 24 10 275 254 690 667 500 499 658 663 677 700 90 180 -92 368 -275 285 -34 -15 -180 -154 -613 -587 l-567 -567 -578 577 c-399 400 -588 582 -614 593 -56 23 -136 19 -189 -8z" />
                    </g>
                </svg>
            </i>
        </div>

        <div class="cards">
            <?php
            $sql = "SELECT * FROM cities ORDER BY city_id LIMIT 3";
            $result = mysqli_query($conn, $sql);

            while ($row = mysqli_fetch_assoc($result)) {
                echo '<div class="card">';

                echo '<img src="assets/img/cities/' . $row['image_url'] . '" alt="' . $row['city_name'] . '">';

                echo '<div class="card-body">';

                echo '<h3>' . $row['city_name'] . '</h3>';

                echo '<p class="card-text">' . $row['description'] . '</p>';

                echo '<p><strong> Best Time to Visit : ' . $row['best_time_to_visit'] . '</strong></p>';

                echo '<a href="city-detail.php?id=' . $row['city_id'] . '" class="btn">Explore</a>';

                echo '</div>';

                echo '</div>';
            }
            ?>
        </div>
    </section>

    <section class="section">
        <div class="section-header">
            <h2 class="section-title">Featured Packages</h2>
            <a class="section-link" href="packages.php">View all packages</a>
            <i class="section-arrow">
                <svg version="1.0" viewBox="0 0 512.000000 512.000000" preserveAspectRatio="xMidYMid meet">
                    <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)" fill="#ffffffff" stroke="none">
                        <path d="M1179 3387 c-64 -34 -102 -93 -107 -166 -2 -32 1 -76 8 -97 10 -32 142 -169 679 -707 446 -447 679 -674 707 -687 50 -25 133 -26 182 -3 24 10 275 254 690 667 500 499 658 663 677 700 90 180 -92 368 -275 285 -34 -15 -180 -154 -613 -587 l-567 -567 -578 577 c-399 400 -588 582 -614 593 -56 23 -136 19 -189 -8z" />
                    </g>
                </svg>
            </i>
        </div>
        <div class="cards">
            <?php
            $sql = "SELECT * FROM packages ORDER BY package_id LIMIT 3";
            $result = mysqli_query($conn, $sql);

            while ($row = mysqli_fetch_assoc($result)) {
                echo '<div class="card">';

                echo '<img src="assets/img/packages/' . $row['image_url'] . '" alt="' . $row['name'] . '">';

                echo '<div class="card-body">';

                echo '<h3>' . $row['name'] . '</h3>';

                // MODIFIED: Removed the 'card-text' class to allow natural height
                echo '<p>Duration: ' . $row['duration_days'] . ' days</p>';

                echo '<p><strong>₹' . $row['price'] . ' per person</strong></p>';

                if (isset($_SESSION['loggedin'])) {
                    echo '<a href="package-detail.php?id=' . $row['package_id'] . '" class="btn">View Details</a>';
                } else {
                    echo '<a href="login.php" class="btn">Login to Book</a>';
                }

                echo '</div>';
                echo '</div>';
            }
            ?>
        </div>
    </section>

    <section class="section">
        <div class="section-header">
            <h2 class="section-title">What Our Travelers Say</h2>
            <a class="section-link" href="reviews.php">View all reviews</a>
            <i class="section-arrow">
                <svg version="1.0" viewBox="0 0 512.000000 512.000000" preserveAspectRatio="xMidYMid meet">
                    <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)" fill="#ffffffff" stroke="none">
                        <path d="M1179 3387 c-64 -34 -102 -93 -107 -166 -2 -32 1 -76 8 -97 10 -32 142 -169 679 -707 446 -447 679 -674 707 -687 50 -25 133 -26 182 -3 24 10 275 254 690 667 500 499 658 663 677 700 90 180 -92 368 -275 285 -34 -15 -180 -154 -613 -587 l-567 -567 -578 577 c-399 400 -588 582 -614 593 -56 23 -136 19 -189 -8z" />
                    </g>
                </svg>
            </i>
        </div>
        <div class="cards">
            <?php
            $sql = "SELECT r.*, u.username, p.name as package_name, a.name as attraction_name 
                FROM reviews r 
                LEFT JOIN users u ON r.user_id = u.user_id 
                LEFT JOIN packages p ON r.package_id = p.package_id 
                LEFT JOIN attractions a ON r.attraction_id = a.attraction_id
                ORDER BY r.date_posted DESC
                LIMIT 2";
            $result = mysqli_query($conn, $sql);

            // MODIFIED: This entire loop is refactored to use CSS classes instead of inline styles
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<div class="card review-card">';
                echo '<div class="review-card__header">';
                echo '<div class="review-card__avatar">' . substr($row['username'], 0, 1) . '</div>';
                echo '<div class="review-card__author">';
                echo '<h4>' . htmlspecialchars($row['username']) . '</h4>';
                echo '<div class="review-card__rating">';
                echo str_repeat('★', $row['rating']) . str_repeat('☆', 5 - $row['rating']);
                echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '<p class="review-card__comment">"' . htmlspecialchars($row['comment']) . '"</p>';
                echo '<div class="review-card__footer">';
                echo '<p>' . ($row['package_name'] ? 'Package: ' . htmlspecialchars($row['package_name']) : 'Attraction: ' . htmlspecialchars($row['attraction_name'])) . '</p>';
                echo '<p>' . date('M j, Y', strtotime($row['date_posted'])) . '</p>';
                echo '</div>';
                echo '</div>';
            }
            ?>

            <?php if (isset($_SESSION['user_id'])): ?>
                <div class="card card--prompt">
                    <h3>Share Your Experience</h3>
                    <p>Have you traveled with us? Leave a review!</p>
                    <a href="reviews.php" class="btn">Write a Review</a>
                </div>
            <?php endif; ?>
        </div>
    </section>

</div>

<?php include "includes/footer.php" ?>