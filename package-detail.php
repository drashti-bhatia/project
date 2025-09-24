<?php
include 'includes/db_connect.php';
include 'header.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: packages.php");
    exit();
}

$package_id = intval($_GET['id']);

// Fetch package details
$package_sql = "SELECT p.*, c.city_name FROM packages p JOIN cities c ON p.city_id = c.city_id WHERE p.package_id = ?";
$stmt_package = mysqli_prepare($conn, $package_sql);
mysqli_stmt_bind_param($stmt_package, "i", $package_id);
mysqli_stmt_execute($stmt_package);
$package_result = mysqli_stmt_get_result($stmt_package);
$package = mysqli_fetch_assoc($package_result);

if (!$package) {
    header("Location: packages.php");
    exit();
}

$page_title = htmlspecialchars($package['name']) . " - Gujarat Yatra Portal";

// Fetch reviews for this package
$reviews_sql = "SELECT r.*, u.username FROM reviews r JOIN users u ON r.user_id = u.user_id WHERE r.package_id = ? AND r.status = 'approved' ORDER BY r.date_posted DESC";
$stmt_reviews = mysqli_prepare($conn, $reviews_sql);
mysqli_stmt_bind_param($stmt_reviews, "i", $package_id);
mysqli_stmt_execute($stmt_reviews);
$reviews_result = mysqli_stmt_get_result($stmt_reviews);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .package-detail-hero {
            background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('assets/img/packages/<?php echo htmlspecialchars($package['image_url']); ?>');
            background-size: cover;
            background-position: center;
            padding: 150px 0;
            text-align: center;
            color: white;
        }

        .package-detail-hero h1 {
            font-size: 3.5rem;
            margin-bottom: 10px;
        }

        .package-detail-hero p {
            font-size: 1.2rem;
        }

        .package-section {
            padding: 50px 5%;
            background-color: #f1f5f8;
        }
        
        .package-content-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 40px;
            align-items: flex-start;
            margin-bottom: 50px;
        }

        .details-card, .inclusions-card {
            background: #fff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }

        .details-card h2, .inclusions-card h3, .reviews-section h3 {
            font-size: 2rem;
            margin-bottom: 20px;
            color: #1f8585ff;
        }

        .inclusions-card h3 {
             font-size: 1.5rem;
        }
        
        .details-card p {
            font-size: 1.1rem;
            line-height: 1.8;
            color: #555;
        }

        .inclusions-card ul {
            list-style: none;
            padding: 0;
        }

        .inclusions-card li {
            font-size: 1rem;
            margin-bottom: 10px;
            color: #555;
        }
        
        .package-price-info {
            background: #FF6B35;
            color: white;
            padding: 20px;
            border-radius: 15px;
            text-align: center;
        }
        
        .package-price-info h3 {
            font-size: 1.8rem;
            margin-bottom: 10px;
            color: white;
        }
        
        .package-price-info p {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .reviews-section {
            margin-top: 50px;
        }

        .review-card {
            background: #fff;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        
        .review-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }
        
        .review-header .user {
            font-weight: bold;
            color: #333;
        }
        
        .review-header .rating-stars {
            color: #FFD700;
        }
        
        .review-comment {
            color: #666;
            line-height: 1.6;
        }

        @media (max-width: 768px) {
            .package-content-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <section class="package-detail-hero">
        <div class="container">
            <h1><?php echo htmlspecialchars($package['name']); ?></h1>
            <p>A <?php echo htmlspecialchars($package['duration_days']); ?> day journey to <?php echo htmlspecialchars($package['city_name']); ?></p>
        </div>
    </section>

    <div class="bg-pattern">
        <section class="package-section">
            <div class="container">
                <div class="package-content-grid">
                    <div class="main-content">
                        <div class="details-card">
                            <h2>About this Package</h2>
                            <p><?php echo htmlspecialchars($package['description']); ?></p>
                            <?php if (isset($package['ideal_for']) && !empty($package['ideal_for'])): ?>
                                <p><strong>Ideal for:</strong> <?php echo htmlspecialchars($package['ideal_for']); ?></p>
                            <?php endif; ?>
                        </div>
                        
                        <div class="details-card">
                            <h3>Itinerary</h3>
                            <?php if (isset($package['itinerary']) && !empty($package['itinerary'])): ?>
                                <p><?php echo nl2br(htmlspecialchars($package['itinerary'])); ?></p>
                            <?php else: ?>
                                <p>No itinerary available for this package.</p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="sidebar">
                        <div class="package-price-info">
                            <h3>Starting From</h3>
                            <p>₹<?php echo number_format($package['price']); ?> per person</p>
                            <?php if (isset($_SESSION['user_id'])): ?>
                                <a href="booking.php?package_id=<?php echo $package['package_id']; ?>" class="btn" style="background: white; color: #FF6B35; margin-top: 20px;">Book Now</a>
                            <?php else: ?>
                                <a href="login.php" class="btn" style="background: white; color: #FF6B35; margin-top: 20px;">Login to Book</a>
                            <?php endif; ?>
                        </div>
                        
                        <div class="inclusions-card">
                            <h3>Package Inclusions</h3>
                            <ul>
                                <?php
                                $inclusions_list = explode(',', $package['inclusions']);
                                foreach ($inclusions_list as $item): ?>
                                    <li><i class="fas fa-check-circle" style="color: #1f8585ff; margin-right: 5px;"></i> <?php echo trim($item); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="reviews-section">
                    <h3>Customer Reviews</h3>
                    <?php if (mysqli_num_rows($reviews_result) > 0): ?>
                        <?php while ($review = mysqli_fetch_assoc($reviews_result)):
                            $stars = str_repeat('★', $review['rating']) . str_repeat('☆', 5 - $review['rating']);
                        ?>
                            <div class="review-card">
                                <div class="review-header">
                                    <span class="user"><?php echo htmlspecialchars($review['username']); ?></span>
                                    <span class="rating-stars"><?php echo $stars; ?></span>
                                </div>
                                <p class="review-comment"><?php echo htmlspecialchars($review['comment']); ?></p>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <p style="text-align: center; color: #666;">No reviews yet. Be the first to review this package!</p>
                    <?php endif; ?>
                </div>
            </div>
        </section>
    </div>

    <?php include "includes/footer.php"; ?>
</body>
</html>