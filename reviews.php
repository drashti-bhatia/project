<?php
include('includes/db_connect.php');
include('header.php');

$page_title = "Customer Reviews - Gujarat Yatar Portal";

// Handle new review submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_review'])) {
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        $rating = intval($_POST['rating']);
        $comment = mysqli_real_escape_string($conn, $_POST['comment']);
        $item_type = mysqli_real_escape_string($conn, $_POST['item_type']);
        $item_id = intval($_POST['item_id']);

        // Determine which foreign key to use (package_id or attraction_id)
        $package_id = null;
        $attraction_id = null;
        if ($item_type === 'package') {
            $package_id = $item_id;
        } elseif ($item_type === 'attraction') {
            $attraction_id = $item_id;
        }

        $sql = "INSERT INTO reviews (user_id, package_id, attraction_id, rating, comment, status)
                VALUES (?, ?, ?, ?, ?, 'pending')";

        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "iiiis", $user_id, $package_id, $attraction_id, $rating, $comment);
        mysqli_stmt_execute($stmt);

        if (mysqli_stmt_affected_rows($stmt) > 0) {
            $success_message = "Thank you! Your review has been submitted for approval.";
        } else {
            $error_message = "Error submitting review. Please try again.";
        }
    } else {
        $error_message = "You must be logged in to submit a review.";
    }
}

// Fetch all approved reviews
$sql = "SELECT r.*, u.username,
        COALESCE(p.name, a.name) as item_name,
        CASE
            WHEN r.package_id IS NOT NULL THEN 'package'
            WHEN r.attraction_id IS NOT NULL THEN 'attraction'
            ELSE 'unknown'
        END as review_type
        FROM reviews r
        JOIN users u ON r.user_id = u.user_id
        LEFT JOIN packages p ON r.package_id = p.package_id
        LEFT JOIN attractions a ON r.attraction_id = a.attraction_id
        WHERE r.status = 'approved'
        ORDER BY r.review_id DESC"; // Show newest reviews first

$reviews_result = mysqli_query($conn, $sql);

// Fetch all packages and attractions for the review form
$packages_sql = "SELECT package_id, name FROM packages ORDER BY name";
$packages_result = mysqli_query($conn, $packages_sql);

$attractions_sql = "SELECT attraction_id, name FROM attractions ORDER BY name";
$attractions_result = mysqli_query($conn, $attractions_sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .reviews-hero {
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('assets/img/reviews-bg.jpg');
            background-size: cover;
            background-position: center;
            padding: 100px 0;
            text-align: center;
            color: white;
        }

        .reviews-hero h1 {
            font-size: 3rem;
            margin-bottom: 20px;
        }

        /* MODIFIED: Section Styling */
        .reviews-section {
            padding: 50px 5%;
            background-color: transparent;
            min-height: 80vh;
        }

        .section-title {
            text-align: center;
            font-size: 35px;
            color: #333;
            margin-bottom: 40px;
        }

        /* MODIFIED: Card Styling */
        .review-card,
        .review-form-container {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05), 0 10px 20px rgba(0, 0, 0, 0.05);
            border: 1px solid #EAEAEA;
            margin-bottom: 30px;
        }

        .review-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            border-bottom: 1px solid #eee;
            padding-bottom: 15px;
        }

        .review-header h4 {
            font-size: 1.2rem;
            color: #333;
            /* Updated color */
            margin: 0;
        }

        /* MODIFIED: Star Rating Display using Font Awesome */
        .review-rating .fa-star {
            font-size: 1.1rem;
            color: #FFC107;
        }

        .review-rating .fa-star.empty {
            color: #e0e0e0;
        }

        .review-meta {
            font-size: 0.9em;
            color: #777;
            margin-bottom: 15px;
        }

        .review-meta span {
            font-weight: 600;
            color: #444;
        }

        .review-comment {
            line-height: 1.6;
            color: #555;
        }

        /* MODIFIED: Form Styling */
        .review-form-container h3 {
            text-align: center;
            color: #333;
            /* Updated color */
            margin-bottom: 30px;
            font-size: 1.8rem;
        }

        .review-form-container .form-group {
            margin-bottom: 20px;
        }

        .review-form-container label {
            font-weight: 600;
            display: block;
            margin-bottom: 8px;
            color: #444;
        }

        .review-form-container input,
        .review-form-container select,
        .review-form-container textarea {
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #ddd;
            background-color: #f9f9f9;
            transition: border-color 0.3s, box-shadow 0.3s;
            font-family: inherit;
        }

        .review-form-container input:focus,
        .review-form-container select:focus,
        .review-form-container textarea:focus {
            outline: none;
            border-color: var(--orange);
            box-shadow: 0 0 0 3px rgba(252, 117, 28, 0.15);
            background-color: #fff;
        }

        .review-form-container .btn {
            padding: 12px 30px;
            width: auto;
            font-size: 1rem;
            margin: 15px 0 0 0;
        }

        .rating-stars-input {
            font-size: 2em;
            color: #e0e0e0;
            cursor: pointer;
            text-align: center;
        }

        .rating-stars-input .star {
            transition: color 0.2s;
        }

        .rating-stars-input .star.selected,
        .rating-stars-input .star:hover,
        .rating-stars-input .star:hover~.star {
            color: #FFC107;
        }

        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 8px;
            font-weight: 500;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>

<body>

    <section class="reviews-hero">
        <div class="container">
            <h1>What Our Travelers Say</h1>
            <p>Real stories and experiences from our valued customers.</p>
        </div>
    </section>

    <div class="bg-pattern">
        <section class="reviews-section">
            <div class="container">
                <h2 class="section-title">Latest Reviews</h2>

                <?php if (mysqli_num_rows($reviews_result) > 0): ?>
                    <?php while ($review = mysqli_fetch_assoc($reviews_result)): ?>
                        <div class="review-card">
                            <div class="review-header">
                                <h4><?php echo htmlspecialchars($review['username']); ?></h4>
                                <div class="review-rating">
                                    <?php
                                    $rating = intval($review['rating']);
                                    for ($i = 0; $i < 5; $i++) {
                                        echo ($i < $rating)
                                            ? '<i class="fas fa-star"></i>'
                                            : '<i class="fas fa-star empty"></i>';
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="review-meta">
                                <p>Reviewed for: <span><?php echo htmlspecialchars($review['item_name']); ?></span> (<?php echo ucfirst($review['review_type']); ?>)</p>
                                <p>Date: <?php echo date('F j, Y', strtotime($review['date_posted'])); ?></p>
                            </div>
                            <p class="review-comment"><?php echo nl2br(htmlspecialchars($review['comment'])); ?></p>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p style="text-align: center;">No reviews have been approved yet. Be the first to leave one!</p>
                <?php endif; ?>

                <div class="review-form-container">
                    <h3>Leave a Review</h3>
                    <?php if (isset($success_message)): ?>
                        <div class="alert alert-success"><?php echo $success_message; ?></div>
                    <?php endif; ?>
                    <?php if (isset($error_message)): ?>
                        <div class="alert alert-error"><?php echo $error_message; ?></div>
                    <?php endif; ?>

                    <form method="POST" action="reviews.php">
                        <div class="form-group">
                            <label for="item_type">Review for</label>
                            <select id="item_type" name="item_type" required>
                                <option value="">Select Item Type...</option>
                                <option value="package">Package</option>
                                <option value="attraction">Attraction</option>
                            </select>
                        </div>

                        <div class="form-group" id="item_id_group" style="display: none;">
                            <label for="item_id">Select Item</label>
                            <select id="item_id" name="item_id" required>
                                <option value="">Select Package/Attraction...</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="rating">Your Rating</label>
                            <div class="rating-stars-input" id="rating-stars">
                                <span class="star" data-value="1">&#9733;</span>
                                <span class="star" data-value="2">&#9733;</span>
                                <span class="star" data-value="3">&#9733;</span>
                                <span class="star" data-value="4">&#9733;</span>
                                <span class="star" data-value="5">&#9733;</span>
                            </div>
                            <input type="hidden" id="rating_input" name="rating" required>
                        </div>

                        <div class="form-group">
                            <label for="comment">Your Comment</label>
                            <textarea id="comment" name="comment" rows="5" placeholder="Share your experience..." required></textarea>
                        </div>

                        <div style="text-align: center;">
                            <?php if (isset($_SESSION['user_id'])): ?>
                                <button type="submit" name="submit_review" class="btn">Submit Review</button>
                            <?php else: ?>
                                <p style="color: #666;">Please <a href="login.php" style="color: var(--orange); text-decoration: none; font-weight: bold;">log in</a> to leave a review.</p>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>

    <script>
        // Handles the dynamic loading of packages or attractions based on the user's selection
        document.getElementById('item_type').addEventListener('change', function() {
            const itemType = this.value;
            const itemDropdown = document.getElementById('item_id');
            const itemGroup = document.getElementById('item_id_group');

            itemDropdown.innerHTML = '<option value="">Select ' + (itemType === 'package' ? 'Package' : 'Attraction') + '...</option>';

            if (itemType === 'package') {
                <?php
                mysqli_data_seek($packages_result, 0);
                while ($package = mysqli_fetch_assoc($packages_result)): ?>
                    itemDropdown.innerHTML += `<option value="<?php echo $package['package_id']; ?>"><?php echo addslashes(htmlspecialchars($package['name'])); ?></option>`;
                <?php endwhile; ?>
            } else if (itemType === 'attraction') {
                <?php
                mysqli_data_seek($attractions_result, 0);
                while ($attraction = mysqli_fetch_assoc($attractions_result)): ?>
                    itemDropdown.innerHTML += `<option value="<?php echo $attraction['attraction_id']; ?>"><?php echo addslashes(htmlspecialchars($attraction['name'])); ?></option>`;
                <?php endwhile; ?>
            }

            itemGroup.style.display = itemType ? 'block' : 'none';
        });

        // Handles the star rating input
        const stars = document.querySelectorAll('.rating-stars-input .star');
        const ratingInput = document.getElementById('rating_input');

        stars.forEach(star => {
            star.addEventListener('click', function() {
                const value = this.getAttribute('data-value');
                ratingInput.value = value;

                stars.forEach(s => {
                    if (s.getAttribute('data-value') <= value) {
                        s.classList.add('selected');
                    } else {
                        s.classList.remove('selected');
                    }
                });
            });
        });
    </script>

    <?php include 'includes/footer.php'; ?>
</body>

</html>