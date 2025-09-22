<?php
include('../includes/db_connect.php');


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$page_title = "My Bookings - Gujarat Yatar Portal";

// Fetch user's bookings
$sql = "SELECT b.*, p.name as package_name, p.price as package_price 
        FROM bookings b 
        JOIN packages p ON b.package_id = p.package_id 
        WHERE b.user_id = '$user_id' 
        ORDER BY b.booking_date DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    <style>
        .bookings-hero {
            background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('assets/img/bookings-bg.jpg');
            background-size: cover;
            background-position: center;
            padding: 100px 0;
            text-align: center;
            color: white;
        }
        
        .bookings-content {
            padding: 50px 5%;
        }
        
        .bookings-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .bookings-table th, .bookings-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        
        .bookings-table th {
            background: #3685fb;
            color: white;
            font-weight: bold;
        }
        
        .bookings-table tr:hover {
            background: #f8f9fa;
        }
        
        .status-badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: bold;
        }
        
        .status-pending {
            background: #FFC107;
            color: #333;
        }
        
        .status-paid {
            background: #4CAF50;
            color: white;
        }
        
        .status-cancelled {
            background: #f44336;
            color: white;
        }
        
        .no-bookings {
            text-align: center;
            padding: 50px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .action-btn {
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            font-size: 0.9rem;
        }
        
        .btn-view {
            background: #3685fb;
            color: white;
        }
        
        .btn-cancel {
            background: #f44336;
            color: white;
        }
        
        .btn-pay {
            background: #4CAF50;
            color: white;
        }
    </style>
</head>
<body>
    <?php include "../header.php"; ?>
    
    <section class="bookings-hero">
        <div class="container">
            <h1>My Bookings</h1>
            <p>Manage your travel plans and bookings</p>
        </div>
    </section>
    
    <section class="bookings-content">
        <div class="container">
            <?php if (mysqli_num_rows($result) > 0): ?>
                <table class="bookings-table">
                    <thead>
                        <tr>
                            <th>Booking ID</th>
                            <th>Package</th>
                            <th>Travel Date</th>
                            <th>Travelers</th>
                            <th>Total Amount</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($booking = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td>#<?php echo $booking['booking_id']; ?></td>
                            <td><?php echo $booking['package_name']; ?></td>
                            <td><?php echo date('M j, Y', strtotime($booking['travel_date'])); ?></td>
                            <td><?php echo $booking['number_of_travelers']; ?></td>
                            <td>₹<?php echo number_format($booking['total_amount']); ?></td>
                            <td>
                                <span class="status-badge status-<?php echo $booking['payment_status']; ?>">
                                    <?php echo ucfirst($booking['payment_status']); ?>
                                </span>
                            </td>
                            <td>
                                <a href="booking-details.php?id=<?php echo $booking['booking_id']; ?>" class="action-btn btn-view">View Details</a>
                                
                                <?php if ($booking['payment_status'] == 'pending'): ?>
                                    <a href="payment.php?booking_id=<?php echo $booking['booking_id']; ?>" class="action-btn btn-pay">Pay Now</a>
                                    <a href="cancel-booking.php?id=<?php echo $booking['booking_id']; ?>" class="action-btn btn-cancel" onclick="return confirm('Are you sure you want to cancel this booking?')">Cancel</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="no-bookings">
                    <h2>No Bookings Yet</h2>
                    <p>You haven't made any bookings yet. Start exploring our packages!</p>
                    <a href="packages.php" class="btn">Explore Packages</a>
                </div>
            <?php endif; ?>
        </div>
    </section>
    
    <?php include "../includes/footer.php"; ?>
</body>
</html>