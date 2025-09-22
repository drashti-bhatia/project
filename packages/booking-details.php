<?php
include('../includes/db_connect.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: bookings.php");
    exit();
}

$booking_id = mysqli_real_escape_string($conn, $_GET['id']);
$user_id = $_SESSION['user_id'];

// Fetch booking details
$sql = "SELECT b.*, p.name as package_name, p.description as package_description, 
               p.duration_days, p.itinerary, p.inclusions, p.exclusions
        FROM bookings b 
        JOIN packages p ON b.package_id = p.package_id 
        WHERE b.booking_id = '$booking_id' AND b.user_id = '$user_id'";
$result = mysqli_query($conn, $sql);
$booking = mysqli_fetch_assoc($conn, $result);

if (!$booking) {
    header("Location: bookings.php");
    exit();
}

$page_title = "Booking #" . $booking['booking_id'] . " - Gujarat Yatar Portal";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    <style>
        .booking-details-hero {
            background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('assets/img/booking-bg.jpg');
            background-size: cover;
            background-position: center;
            padding: 100px 0;
            text-align: center;
            color: white;
        }
        
        .booking-content {
            padding: 50px 5%;
        }
        
        .booking-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            padding: 30px;
            margin-bottom: 30px;
        }
        
        .booking-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 1px solid #eee;
        }
        
        .booking-info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }
        
        .info-item {
            margin-bottom: 15px;
        }
        
        .info-label {
            font-weight: bold;
            color: #666;
            margin-bottom: 5px;
        }
        
        .status-badge {
            padding: 8px 15px;
            border-radius: 20px;
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
        
        .package-details {
            margin-top: 30px;
        }
        
        .action-buttons {
            margin-top: 30px;
            display: flex;
            gap: 15px;
        }
    </style>
</head>
<body>
    <?php include "../header.php"; ?>
    
    <section class="booking-details-hero">
        <div class="container">
            <h1>Booking Details #<?php echo $booking['booking_id']; ?></h1>
            <p>Package: <?php echo $booking['package_name']; ?></p>
        </div>
    </section>
    
    <section class="booking-content">
        <div class="container">
            <div class="booking-card">
                <div class="booking-header">
                    <h2>Booking Information</h2>
                    <span class="status-badge status-<?php echo $booking['payment_status']; ?>">
                        <?php echo ucfirst($booking['payment_status']); ?>
                    </span>
                </div>
                
                <div class="booking-info">
                    <div>
                        <div class="info-item">
                            <div class="info-label">Booking Date</div>
                            <div><?php echo date('F j, Y, g:i a', strtotime($booking['booking_date'])); ?></div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-label">Package Name</div>
                            <div><?php echo $booking['package_name']; ?></div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-label">Duration</div>
                            <div><?php echo $booking['duration_days']; ?> Days</div>
                        </div>
                    </div>
                    
                    <div>
                        <div class="info-item">
                            <div class="info-label">Travel Date</div>
                            <div><?php echo date('F j, Y', strtotime($booking['travel_date'])); ?></div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-label">Number of Travelers</div>
                            <div><?php echo $booking['number_of_travelers']; ?></div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-label">Total Amount</div>
                            <div style="font-size: 1.2rem; font-weight: bold; color: #FF6B35;">
                                ₹<?php echo number_format($booking['total_amount']); ?>
                            </div>
                        </div>
                    </div>
                </div>
                
                <?php if ($booking['payment_status'] == 'pending'): ?>
                <div class="action-buttons">
                    <a href="payment.php?booking_id=<?php echo $booking['booking_id']; ?>" class="btn">Pay Now</a>
                    <a href="cancel-booking.php?id=<?php echo $booking['booking_id']; ?>" class="btn" style="background: #f44336;" onclick="return confirm('Are you sure you want to cancel this booking?')">Cancel Booking</a>
                </div>
                <?php endif; ?>
            </div>
            
            <div class="booking-card package-details">
                <h2>Package Details</h2>
                <p><?php echo $booking['package_description']; ?></p>
                
                <h3 style="margin-top: 20px;">Itinerary</h3>
                <p><?php echo $booking['itinerary']; ?></p>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-top: 20px;">
                    <div>
                        <h3>Inclusions</h3>
                        <p><?php echo $booking['inclusions']; ?></p>
                    </div>
                    
                    <div>
                        <h3>Exclusions</h3>
                        <p><?php echo $booking['exclusions']; ?></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <?php include "../includes/footer.php"; ?>
</body>
</html>