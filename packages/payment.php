<?php
include "../includes/db_connect.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
} 

if (!isset($_GET['booking_id'])) {
    header("Location: bookings.php");
    exit();
}

$booking_id = mysqli_real_escape_string($conn, $_GET['booking_id']);
$user_id = $_SESSION['user_id'];

// Fetch booking details
$sql = "SELECT b.*, p.name as package_name 
        FROM bookings b 
        JOIN packages p ON b.package_id = p.package_id 
        WHERE b.booking_id = '$booking_id' AND b.user_id = '$user_id'";
$result = mysqli_query($conn, $sql);
$booking = mysqli_fetch_assoc($result);

if (!$booking || $booking['payment_status'] != 'pending') {
    header("Location: bookings.php");
    exit();
}

$page_title = "Payment - Booking #" . $booking_id;

// Handle payment submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $payment_method = mysqli_real_escape_string($conn, $_POST['payment_method']);
    $transaction_id = mysqli_real_escape_string($conn, $_POST['transaction_id']);
    
    // Update booking status
    $update_sql = "UPDATE bookings SET payment_status = 'paid' WHERE booking_id = '$booking_id'";
    
    // Record payment
    $payment_sql = "INSERT INTO payments (booking_id, amount, payment_method, transaction_id, status) 
                    VALUES ('$booking_id', '{$booking['total_amount']}', '$payment_method', '$transaction_id', 'success')";
    
    if (mysqli_query($conn, $update_sql) && mysqli_query($conn, $payment_sql)) {
        $_SESSION['payment_success'] = true;
        header("Location: payment-success.php?booking_id=$booking_id");
        exit();
    } else {
        $error_msg = "Payment failed. Please try again.";
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
        .payment-hero {
            background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('assets/img/payment-bg.jpg');
            background-size: cover;
            background-position: center;
            padding: 100px 0;
            text-align: center;
            color: white;
        }
        
        .payment-content {
            padding: 50px 5%;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 50px;
        }
        
        .booking-summary {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .summary-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }
        
        .total-amount {
            font-size: 1.5rem;
            font-weight: bold;
            color: #FF6B35;
            margin-top: 20px;
        }
        
        .payment-form {
            background: white;
            padding: 30px;
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
        
        .form-group select, .form-group input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
        }
        
        .payment-cards {
            display: flex;
            gap: 15px;
            margin: 15px 0;
        }
        
        .payment-card {
            border: 2px solid #ddd;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .payment-card:hover, .payment-card.selected {
            border-color: #3685fb;
            background: #f8f9fa;
        }
        
        .payment-card img {
            height: 40px;
            margin-bottom: 10px;
        }
        
        .alert {
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
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
    
    <section class="payment-hero">
        <div class="container">
            <h1>Complete Your Payment</h1>
            <p>Booking #<?php echo $booking_id; ?> - <?php echo $booking['package_name']; ?></p>
        </div>
    </section>
    
    <section class="payment-content">
        <div class="container">
            <div class="booking-summary">
                <h2>Booking Summary</h2>
                
                <div class="summary-item">
                    <span>Package Name:</span>
                    <span><?php echo $booking['package_name']; ?></span>
                </div>
                
                <div class="summary-item">
                    <span>Travel Date:</span>
                    <span><?php echo date('F j, Y', strtotime($booking['travel_date'])); ?></span>
                </div>
                
                <div class="summary-item">
                    <span>Number of Travelers:</span>
                    <span><?php echo $booking['number_of_travelers']; ?></span>
                </div>
                
                <div class="summary-item">
                    <span>Package Price:</span>
                    <span>₹<?php echo number_format($booking['total_amount'] / $booking['number_of_travelers']); ?></span>
                </div>
                
                <div class="summary-item">
                    <span>Total Amount:</span>
                    <span class="total-amount">₹<?php echo number_format($booking['total_amount']); ?></span>
                </div>
            </div>
            
            <div class="payment-form">
                <h2>Payment Details</h2>
                
                <?php if (isset($error_msg)): ?>
                    <div class="alert alert-error"><?php echo $error_msg; ?></div>
                <?php endif; ?>
                
                <form method="POST" action="payment.php?booking_id=<?php echo $booking_id; ?>">
                    <div class="form-group">
                        <label>Select Payment Method</label>
                        <div class="payment-cards">
                            <div class="payment-card" onclick="selectPayment('card')">
                                <img src="assets/img/credit-card.png" alt="Credit Card">
                                <div>Credit Card</div>
                            </div>
                            <div class="payment-card" onclick="selectPayment('upi')">
                                <img src="assets/img/upi.png" alt="UPI">
                                <div>UPI</div>
                            </div>
                            <div class="payment-card" onclick="selectPayment('netbanking')">
                                <img src="assets/img/bank.png" alt="Net Banking">
                                <div>Net Banking</div>
                            </div>
                        </div>
                        <input type="hidden" id="payment_method" name="payment_method" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="transaction_id">Transaction ID</label>
                        <input type="text" id="transaction_id" name="transaction_id" required 
                               placeholder="Enter your transaction ID">
                    </div>
                    
                    <button type="submit" class="btn" style="width: 100%; padding: 15px;">Pay Now</button>
                </form>
            </div>
        </div>
    </section>
    
    <script>
        function selectPayment(method) {
            document.querySelectorAll('.payment-card').forEach(card => {
                card.classList.remove('selected');
            });
            
            event.currentTarget.classList.add('selected');
            document.getElementById('payment_method').value = method;
        }
    </script>
    
    <?php include "../includes/footer.php"; ?>
</body>
</html>