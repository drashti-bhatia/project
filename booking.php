<?php
include('includes/db_connect.php');
include('header.php');

$page_title = "Book Your Tour";
$booking_success = false;
$error_message = "";
$total_amount_display = 0; // Initialize a variable to store the total amount for display

// Check if the user is logged in.
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Check if a package ID is provided in the URL.
if (!isset($_GET['package_id']) || empty($_GET['package_id'])) {
    header("Location: packages.php");
    exit();
}

$package_id = intval($_GET['package_id']);
$user_id = $_SESSION['user_id'];

// Fetch package details to display on the booking page.
$package_sql = "SELECT * FROM packages WHERE package_id = ?";
$stmt_package = mysqli_prepare($conn, $package_sql);
mysqli_stmt_bind_param($stmt_package, "i", $package_id);
mysqli_stmt_execute($stmt_package);
$package_result = mysqli_stmt_get_result($stmt_package);
$package = mysqli_fetch_assoc($package_result);

if (!$package) {
    header("Location: packages.php");
    exit();
}

// Handle booking form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['book_package'])) {
    $travel_date = mysqli_real_escape_string($conn, $_POST['travel_date']);
    $number_of_travelers = intval($_POST['number_of_travelers']);

    // Basic validation
    if ($number_of_travelers <= 0) {
        $error_message = "Number of travelers must be at least 1.";
    } else {
        $total_amount = $package['price'] * $number_of_travelers;
        $total_amount_display = $total_amount; // Set the display variable
        $payment_status = 'pending';

        // Insert booking into the database using a prepared statement for security
        $sql = "INSERT INTO bookings (user_id, package_id, travel_date, number_of_travelers, total_amount, payment_status) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt_booking = mysqli_prepare($conn, $sql);

        // Check if the prepared statement was successful
        if ($stmt_booking) {
            // Correct the type string and bind the parameters
            mysqli_stmt_bind_param($stmt_booking, "iisisd", $user_id, $package_id, $travel_date, $number_of_travelers, $total_amount, $payment_status);

            if (mysqli_stmt_execute($stmt_booking)) {
                $booking_success = true;
            } else {
                // Provide a more specific error message if the execution fails
                $error_message = "Booking failed. MySQL Error: " . mysqli_stmt_error($stmt_booking);
            }
        } else {
            // Provide a more specific error if the statement preparation fails
            $error_message = "Database statement failed. MySQL Error: " . mysqli_error($conn);
        }
    }
}
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
        .booking-hero {
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('assets/img/packages/<?php echo htmlspecialchars($package['image_url']); ?>');
            background-size: cover;
            background-position: center;
            padding: 100px 0;
            text-align: center;
            color: white;
            margin-top: 105px;
        }

        .booking-form-section {
            padding: 50px 5%;
            background-color: #f1f5f8;
            min-height: 80vh;
            display: flex;
            justify-content: center;
            align-items: flex-start;
        }

        .booking-form-container {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 100%;
        }

        .booking-form-container h2 {
            font-size: 2rem;
            color: #1f8585ff;
            margin-bottom: 20px;
            text-align: center;
        }

        .booking-form-container .form-group {
            margin-bottom: 20px;
        }

        .booking-form-container label {
            display: block;
            font-weight: bold;
            margin-bottom: 8px;
            color: #555;
        }

        .booking-form-container input[type="date"],
        .booking-form-container input[type="number"],
        .booking-form-container input[type="text"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 1rem;
        }

        .booking-form-container .btn {
            width: 100%;
            padding: 15px;
            font-size: 1.1rem;
            border-radius: 8px;
        }

        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 8px;
            font-size: 1rem;
            text-align: center;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .package-summary {
            background-color: #f1f1f1;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .package-summary p {
            margin: 5px 0;
        }
    </style>
</head>

<body>
    <section class="booking-hero">
        <div class="container">
            <h1>Book Your Trip</h1>
            <p>You are booking: <?php echo htmlspecialchars($package['name']); ?></p>
        </div>
    </section>

    <section class="booking-form-section">
        <div class="booking-form-container">
            <h2>Booking Details</h2>

            <?php if ($booking_success): ?>
                <div class="alert alert-success">
                    Booking successful! Your booking ID is: **<?php echo mysqli_insert_id($conn); ?>**.
                    <br>Total Amount: **₹<?php echo number_format($total_amount_display, 2); ?>**.
                    <br>We will contact you soon.
                </div>
            <?php else: ?>
                <?php if ($error_message): ?>
                    <div class="alert alert-error">
                        <?php echo $error_message; ?>
                    </div>
                <?php endif; ?>

                <div class="package-summary">
                    <p><strong>Package:</strong> <?php echo htmlspecialchars($package['name']); ?></p>
                    <p><strong>Duration:</strong> <?php echo htmlspecialchars($package['duration_days']); ?> Days</p>
                    <p><strong>Price per person:</strong> ₹<?php echo number_format($package['price'], 2); ?></p>
                </div>

                <form method="POST" action="">
                    <input type="hidden" name="book_package" value="1">

                    <div class="form-group">
                        <label for="travel_date">Select Travel Date</label>
                        <input type="date" id="travel_date" name="travel_date" required min="<?php echo date('Y-m-d'); ?>">
                    </div>

                    <div class="form-group">
                        <label for="number_of_travelers">Number of Travelers</label>
                        <input type="number" id="number_of_travelers" name="number_of_travelers" required min="1">
                    </div>

                    <button type="submit" class="btn">Confirm Booking</button>
                </form>
            <?php endif; ?>
        </div>
    </section>

    <?php include "includes/footer.php"; ?>
</body>

</html>