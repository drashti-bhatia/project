<?php
include('includes/db_connect.php');
include('header.php');

$page_title = "My Bookings";

// Redirect if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch all bookings for the current user, joining with the packages table to get package names
$sql = "SELECT b.*, p.name as package_name, p.price as package_price, p.image_url
        FROM bookings b
        JOIN packages p ON b.package_id = p.package_id
        WHERE b.user_id = ?
        ORDER BY b.booking_date DESC";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
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
        .my-bookings-hero {
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('assets/img/my-bookings-bg.jpg');
            background-size: cover;
            background-position: center;
            padding: 100px 0;
            text-align: center;
            color: white;
            margin-top: 105px;
        }

        .bookings-section {
            padding: 50px 5%;
            min-height: 80vh;
            background-color: #f1f5f8;
        }

        .booking-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 25px;
            padding: 25px;
            display: flex;
            align-items: center;
            gap: 20px;
        }
        
        .booking-card img {
            width: 150px;
            height: 100px;
            object-fit: cover;
            border-radius: 10px;
        }

        .booking-content {
            flex-grow: 1;
        }

        .booking-content h3 {
            font-size: 1.5rem;
            color: #1f8585ff;
            margin-bottom: 5px;
        }

        .booking-details {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            font-size: 0.95rem;
            color: #555;
            margin-top: 10px;
        }

        .booking-details p {
            margin: 0;
            display: flex;
            align-items: center;
            gap: 5px;
        }
        
        /* New Styles for better layout */
        .booking-details strong {
            color: #333;
        }

        .status-badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            color: white;
        }
        
        .status-pending { background-color: #FFC107; color: #333; }
        .status-paid { background-color: #4CAF50; }
        .status-cancelled { background-color: #f44336; }
        
        .no-bookings {
            text-align: center;
            font-size: 1.2rem;
            color: #777;
            margin-top: 50px;
        }

        @media (max-width: 768px) {
            .booking-card {
                flex-direction: column;
                text-align: center;
            }

            .booking-details {
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <section class="my-bookings-hero">
        <div class="container">
            <h1>My Bookings</h1>
            <p>View the history of your tour bookings with us.</p>
        </div>
    </section>

    <div class="bg-pattern">
        <section class="bookings-section">
            <div class="container">
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php while ($booking = mysqli_fetch_assoc($result)): ?>
                        <div class="booking-card">
                            <img src="assets/img/packages/<?php echo htmlspecialchars($booking['image_url']); ?>" alt="<?php echo htmlspecialchars($booking['package_name']); ?>">
                            <div class="booking-content">
                                <h3><?php echo htmlspecialchars($booking['package_name']); ?></h3>
                                <div class="booking-details">
                                    <p><i class="fas fa-calendar-check"></i> <strong>Booked:</strong> <?php echo date('M j, Y', strtotime($booking['booking_date'])); ?></p>
                                    <p><i class="fas fa-plane"></i> <strong>Travel Date:</strong> <?php echo date('M j, Y', strtotime($booking['travel_date'])); ?></p>
                                    <p><i class="fas fa-users"></i> <strong>Travelers:</strong> <?php echo htmlspecialchars($booking['number_of_travelers']); ?></p>
                                    <p><i class="fas fa-rupee-sign"></i> <strong>Total Amount:</strong> ₹<?php echo number_format($booking['total_amount'], 2); ?></p>
                                    <p><i class="fas fa-credit-card"></i> <strong>Status:</strong> <span class="status-badge status-<?php echo strtolower($booking['payment_status']); ?>">
                                            <?php echo ucfirst($booking['payment_status']); ?>
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="no-bookings">
                        <p>You have no bookings yet. Explore our <a href="packages.php">tour packages</a> to get started! </p>
                    </div>
                <?php endif; ?>
            </div>
        </section>
    </div>

    <?php include 'includes/footer.php'; ?>
</body>
<<<<<<< HEAD

=======
>>>>>>> main
</html>