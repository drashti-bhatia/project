<?php
include('../includes/db_connect.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$page_title = "Submit Review - Gujarat Yatar Portal";

// Fetch user's bookings
$user_id = $_SESSION['user_id'];
$bookings_sql = "SELECT b.*, p.name as package_name 
                 FROM bookings b 
                 JOIN packages p ON b.package_id = p.package_id 
                 WHERE b.user_id = '$user_id' AND b.payment_status = 'paid'";
$bookings_result = mysqli_query($conn, $bookings_sql);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $package_id = mysqli_real_escape_string($conn, $_POST['package_id']);
    $rating = mysqli_real_escape_string($conn, $_POST['rating']);
    $comment = mysqli_real_escape_string($conn, $_POST['comment']);
    $user_name = $_SESSION['username'];
    
    $sql = "INSERT INTO reviews (user_name, package_id, rating, comment) 
            VALUES ('$user_name', '$package_id', '$rating', '$comment')";
    
    if (mysqli_query($conn, $sql)) {
        $success_msg = "Thank you for your review!";
    } else {
        $error_msg = "Sorry, there was an error submitting your review. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    <style>
        .review-hero {
            background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('assets/img/review-bg.jpg');
            background-size: cover;
            background-position: center;
            padding: 100px 0;
            text-align: center;
            color: white;
        }
        
        .review-form {
            max-width: 600px;
            margin: 50px auto;
            padding: 30px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
        }
        
        .form-group select, .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
        }
        
        .form-group textarea {
            height: 150px;
            resize: vertical;
        }
        
        .rating-stars {
            display: flex;
            gap: 10px;
            margin: 10px 0;
        }
        
        .rating-stars input {
            display: none;
        }
        
        .rating-stars label {
            font-size: 2rem;
            color: #ddd;
            cursor: pointer;
            transition: color 0.3s;
        }
        
        .rating-stars input:checked ~ label,
        .rating-stars label:hover,
        .rating-stars label:hover ~ label {
            color: #FFD700;
        }
        
        .alert {
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
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
       <?php include "../header.php"; ?>
    
    <section class="review-hero">
        <div class="container">
            <h1>Share Your Experience</h1>
            <p>Help other travelers by sharing your experience</p>
        </div>
    </section>
    
    <section class="review-form">
        <div class="container">
            <?php if (isset($success_msg)): ?>
                <div class="alert alert-success"><?php echo $success_msg; ?></div>
            <?php endif; ?>
            
            <?php if (isset($error_msg)): ?>
                <div class="alert alert-error"><?php echo $error_msg; ?></div>
            <?php endif; ?>
            
            <form method="POST" action="submit_review.php">
                <div class="form-group">
                    <label for="package_id">Select Package</label>
                    <select id="package_id" name="package_id" required>
                        <option value="">Choose a package you booked</option>
                        <?php while ($booking = mysqli_fetch_assoc($bookings_result)): ?>
                            <option value="<?php echo $booking['package_id']; ?>">
                                <?php echo $booking['package_name']; ?> (Booked on <?php echo date('M j, Y', strtotime($booking['booking_date'])); ?>)
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label>Your Rating</label>
                    <div class="rating-stars">
                        <input type="radio" id="star5" name="rating" value="5" required>
                        <label for="star5">★</label>
                        
                        <input type="radio" id="star4" name="rating" value="4">
                        <label for="star4">★</label>
                        
                        <input type="radio" id="star3" name="rating" value="3">
                        <label for="star3">★</label>
                        
                        <input type="radio" id="star2" name="rating" value="2">
                        <label for="star2">★</label>
                        
                        <input type="radio" id="star1" name="rating" value="1">
                        <label for="star1">★</label>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="comment">Your Review</label>
                    <textarea id="comment" name="comment" placeholder="Share your experience..." required></textarea>
                </div>
                
                <button type="submit" class="btn" style="width: 100%; padding: 15px;">Submit Review</button>
            </form>
        </div>
    </section>
    
        <?php include "../includes/footer.php"; ?>
</body>
</html>