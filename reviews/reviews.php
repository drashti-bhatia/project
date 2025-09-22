<?php
include '../includes/db_connect.php';

$page_title = "Travel Reviews - Gujarat Yatar Portal";

// Fetch all reviews with package information
$sql = "SELECT r.*, p.name as package_name 
        FROM reviews r 
        LEFT JOIN packages p ON r.package_id = p.package_id 
        ORDER BY r.date_posted DESC";
$result = mysqli_query($conn, $sql);

// Calculate average rating
$avg_sql = "SELECT AVG(rating) as avg_rating, COUNT(*) as total_reviews FROM reviews";
$avg_result = mysqli_query($conn, $avg_sql);
$avg_data = mysqli_fetch_assoc($avg_result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    <style>
        .reviews-hero {
            background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('assets/img/reviews-bg.jpg');
            background-size: cover;
            background-position: center;
            padding: 100px 0;
            text-align: center;
            color: white;
        }
        
        .reviews-content {
            padding: 50px 5%;
        }
        
        .reviews-stats {
            background: #3685fb;
            color: white;
            padding: 40px;
            border-radius: 10px;
            text-align: center;
            margin-bottom: 40px;
        }
        
        .average-rating {
            font-size: 3rem;
            font-weight: bold;
            margin-bottom: 10px;
        }
        
        .stars-large {
            color: #FFD700;
            font-size: 2rem;
            margin-bottom: 20px;
        }
        
        .reviews-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }
        
        .review-card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .review-header {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }
        
        .reviewer-avatar {
            width: 50px;
            height: 50px;
            background: #3685fb;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 1.2rem;
            margin-right: 15px;
        }
        
        .review-stars {
            color: #FFD700;
            margin-bottom: 10px;
        }
        
        .review-package {
            background: #f8f9fa;
            padding: 10px;
            border-radius: 5px;
            margin-top: 15px;
            font-size: 0.9rem;
        }
        
        .review-date {
            color: #666;
            font-size: 0.9rem;
            margin-top: 10px;
        }
        
        .add-review-section {
            background: #f8f9fa;
            padding: 50px 5%;
            text-align: center;
            margin-top: 50px;
        }
    </style>
</head>
<body>
    <?php include "../header.php"; ?>
    
    <section class="reviews-hero">
        <div class="container">
            <h1>Traveler Reviews</h1>
            <p>See what our customers have to say about their experiences</p>
        </div>
    </section>
    
    <section class="reviews-content">
        <div class="container">
            <div class="reviews-stats">
                <div class="average-rating"><?php echo number_format($avg_data['avg_rating'], 1); ?></div>
                <div class="stars-large">
                    <?php 
                    $full_stars = floor($avg_data['avg_rating']);
                    $half_star = ($avg_data['avg_rating'] - $full_stars) >= 0.5;
                    
                    echo str_repeat('★', $full_stars);
                    echo $half_star ? '½' : '';
                    echo str_repeat('☆', 5 - ceil($avg_data['avg_rating']));
                    ?>
                </div>
                <p>Based on <?php echo $avg_data['total_reviews']; ?> reviews</p>
            </div>
            
            <div class="reviews-grid">
                <?php while ($review = mysqli_fetch_assoc($result)): ?>
                <div class="review-card">
                    <div class="review-header">
                        <div class="reviewer-avatar">
                            <?php echo strtoupper(substr($review['user_name'], 0, 1)); ?>
                        </div>
                        <div>
                            <h3><?php echo $review['user_name']; ?></h3>
                            <div class="review-stars">
                                <?php echo str_repeat('★', $review['rating']) . str_repeat('☆', 5 - $review['rating']); ?>
                            </div>
                        </div>
                    </div>
                    
                    <p><?php echo $review['comment']; ?></p>
                    
                    <?php if ($review['package_name']): ?>
                    <div class="review-package">
                        Package: <?php echo $review['package_name']; ?>
                    </div>
                    <?php endif; ?>
                    
                    <div class="review-date">
                        <?php echo date('F j, Y', strtotime($review['date_posted'])); ?>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
    </section>
    
    <section class="add-review-section">
        <div class="container">
            <h2>Share Your Experience</h2>
            <p>Have you traveled with us? We'd love to hear about your experience!</p>
            
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="submit_review.php" class="btn">Write a Review</a>
            <?php else: ?>
                <p>Please <a href="../login.php" style="color: #3685fb;">login</a> to submit a review.</p>
            <?php endif; ?>
        </div>
    </section>
    
       <?php include "../includes/footer.php"; ?>
</body>
</html>