<?php
session_start();
include('../includes/db_connect.php');

// if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
//     header("Location: ../login.php");
//     exit();
// }

$page_title = "Manage Bookings";

// Initialize messages
$success_msg = "";
$error_msg = "";

// Handle form submissions for adding/updating/deleting bookings
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_booking'])) {
        $booking_id = mysqli_real_escape_string($conn, $_POST['booking_id']);
        $user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
        $package_id = mysqli_real_escape_string($conn, $_POST['package_id']);
        $travel_date = mysqli_real_escape_string($conn, $_POST['travel_date']);
        $number_of_travelers = mysqli_real_escape_string($conn, $_POST['number_of_travelers']);
        $total_amount = mysqli_real_escape_string($conn, $_POST['total_amount']);
        $status = mysqli_real_escape_string($conn, $_POST['status']);
        
        $sql = "UPDATE bookings SET 
                user_id = '$user_id', 
                package_id = '$package_id',
                travel_date = '$travel_date',
                number_of_travelers = '$number_of_travelers',
                total_amount = '$total_amount',
                payment_status = '$status'
                WHERE booking_id = '$booking_id'";
        
        if (mysqli_query($conn, $sql)) {
            $success_msg = "Booking updated successfully!";
        } else {
            $error_msg = "Error updating booking: " . mysqli_error($conn);
        }
    } elseif (isset($_POST['add_booking'])) {
        $user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
        $package_id = mysqli_real_escape_string($conn, $_POST['package_id']);
        $travel_date = mysqli_real_escape_string($conn, $_POST['travel_date']);
        $number_of_travelers = mysqli_real_escape_string($conn, $_POST['number_of_travelers']);
        $total_amount = mysqli_real_escape_string($conn, $_POST['total_amount']);
        $status = mysqli_real_escape_string($conn, $_POST['status']);

        $sql = "INSERT INTO bookings (user_id, package_id, travel_date, number_of_travelers, total_amount, payment_status)
                VALUES ('$user_id', '$package_id', '$travel_date', '$number_of_travelers', '$total_amount', '$status')";
        
        if (mysqli_query($conn, $sql)) {
            $success_msg = "Booking added successfully!";
        } else {
            $error_msg = "Error adding booking: " . mysqli_error($conn);
        }
    } elseif (isset($_POST['delete_booking'])) {
        $booking_id = intval($_POST['booking_id']);
        $sql = "DELETE FROM bookings WHERE booking_id = $booking_id";
        if (mysqli_query($conn, $sql)) {
            $success_msg = "Booking deleted successfully!";
        } else {
            $error_msg = "Error deleting booking: " . mysqli_error($conn);
        }
    }
}

// Fetch all bookings with user and package info
$bookings = array();
$sql = "SELECT b.*, u.username, u.email, p.name as package_name 
        FROM bookings b 
        JOIN users u ON b.user_id = u.user_id 
        JOIN packages p ON b.package_id = p.package_id 
        ORDER BY b.booking_id";
$result = mysqli_query($conn, $sql);
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $bookings[] = $row;
    }
}

// Fetch users for dropdown
$users_sql = "SELECT user_id, username, email FROM users ORDER BY username";
$users_result = mysqli_query($conn, $users_sql);
$users = [];
while ($user = mysqli_fetch_assoc($users_result)) {
    $users[] = $user;
}

// Fetch packages for dropdown
$packages_sql = "SELECT package_id, name FROM packages ORDER BY name";
$packages_result = mysqli_query($conn, $packages_sql);
$packages = [];
while ($package = mysqli_fetch_assoc($packages_result)) {
    $packages[] = $package;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        <?php include 'admin_styles.css'; ?>
        
        /* Ensures the modal is hidden by default. */
        .modal {
            display: none;
        }

        .status-badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        
        .status-pending {
            background-color: #FFC107;
            color: #333;
        }
        
        .status-paid {
            background-color: #4CAF50;
            color: white;
        }
        
        .status-cancelled {
            background-color: #f44336;
            color: white;
        }
    </style>
</head>
<body>
    <?php include 'admin_header.php'; ?>
    
    <div class="admin-container">
        <?php include 'admin_sidebar.php'; ?>
        
        <div class="admin-content">
            <h1 style="color: #1f8585ff; margin-bottom: 20px;">Manage Bookings</h1>
            <button class="btn-add" onclick="openAddModal()">Add New Booking</button>
            
            <?php if (!empty($success_msg)): ?>
                <div class="alert alert-success"><?php echo $success_msg; ?></div>
            <?php endif; ?>
            
            <?php if (!empty($error_msg)): ?>
                <div class="alert alert-error"><?php echo $error_msg; ?></div>
            <?php endif; ?>
            
            <div class="glass" style="padding: 20px;">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>User</th>
                            <th>Package</th>
                            <th>Booking Date</th>
                            <th>Travel Date</th>
                            <th>Travelers</th>
                            <th>Total Amount</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($bookings as $booking): ?>
                        <tr>
                            <td><?php echo $booking['booking_id']; ?></td>
                            <td><?php echo $booking['username']; ?><br><small><?php echo $booking['email']; ?></small></td>
                            <td><?php echo $booking['package_name']; ?></td>
                            <td><?php echo date('M j, Y', strtotime($booking['booking_date'])); ?></td>
                            <td><?php echo date('M j, Y', strtotime($booking['travel_date'])); ?></td>
                            <td><?php echo $booking['number_of_travelers']; ?></td>
                            <td>₹<?php echo $booking['total_amount']; ?></td>
                            <td>
                                <span class="status-badge status-<?php echo $booking['payment_status']; ?>">
                                    <?php echo ucfirst($booking['payment_status']); ?>
                                </span>
                            </td>
                            <td>
                                <div class="action-btns">
                                    <a href="#" class="edit-btn" onclick="openEditModal('<?php echo $booking['booking_id']; ?>', '<?php echo $booking['user_id']; ?>', '<?php echo $booking['package_id']; ?>', '<?php echo $booking['travel_date']; ?>', '<?php echo $booking['number_of_travelers']; ?>', '<?php echo $booking['total_amount']; ?>', '<?php echo $booking['payment_status']; ?>')"><i class="fas fa-edit"></i> Edit</a>
                                    <form method="POST" action="" style="display:inline;">
                                        <input type="hidden" name="booking_id" value="<?php echo $booking['booking_id']; ?>">
                                        <button type="submit" name="delete_booking" class="delete-btn" onclick="return confirm('Are you sure you want to delete this booking?')"><i class="fas fa-trash"></i> Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="bookingModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2 id="modalTitle" style="color: #1f8585ff; margin-bottom: 20px;"></h2>
            <form method="POST" action="">
                <input type="hidden" id="booking_id" name="booking_id">

                <div class="form-group">
                    <label for="user_id">User</label>
                    <select class="form-control" id="modal_user_id" name="user_id" required>
                        <option value="">Select User</option>
                        <?php foreach ($users as $user): ?>
                            <option value="<?php echo $user['user_id']; ?>"><?php echo $user['username'] . ' (' . $user['email'] . ')'; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="package_id">Package</label>
                    <select class="form-control" id="modal_package_id" name="package_id" required>
                        <option value="">Select Package</option>
                        <?php foreach ($packages as $package): ?>
                            <option value="<?php echo $package['package_id']; ?>"><?php echo $package['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="travel_date">Travel Date</label>
                    <input type="date" class="form-control" id="modal_travel_date" name="travel_date" required>
                </div>
                
                <div class="form-group">
                    <label for="number_of_travelers">Number of Travelers</label>
                    <input type="number" class="form-control" id="modal_travelers" name="number_of_travelers" required min="1">
                </div>
                
                <div class="form-group">
                    <label for="total_amount">Total Amount (₹)</label>
                    <input type="number" class="form-control" id="modal_total_amount" name="total_amount" required min="0" step="0.01">
                </div>
                
                <div class="form-group">
                    <label for="status">Status</label>
                    <select class="form-control" id="modal_status" name="status" required>
                        <option value="pending">Pending</option>
                        <option value="paid">Paid</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>

                <div class="btn-container">
                    <button type="submit" id="modalSubmitBtn" class="btn"></button>
                    <button type="button" class="btn" onclick="closeModal()">Cancel</button>
                </div>
            </form>
        </div>
    </div>

<script>
    function openAddModal() {
        document.getElementById('modalTitle').innerText = 'Add New Booking';
        document.getElementById('booking_id').value = '';
        document.getElementById('modal_user_id').value = '';
        document.getElementById('modal_package_id').value = '';
        document.getElementById('modal_travel_date').value = '';
        document.getElementById('modal_travelers').value = '';
        document.getElementById('modal_total_amount').value = '';
        document.getElementById('modal_status').value = 'pending';
        document.getElementById('modalSubmitBtn').name = 'add_booking';
        document.getElementById('modalSubmitBtn').innerText = 'Add Booking';
        document.getElementById('bookingModal').style.display = 'flex';
    }

    function openEditModal(bookingId, userId, packageId, travelDate, travelers, totalAmount, status) {
        document.getElementById('modalTitle').innerText = 'Edit Booking';
        document.getElementById('booking_id').value = bookingId;
        document.getElementById('modal_user_id').value = userId;
        document.getElementById('modal_package_id').value = packageId;
        document.getElementById('modal_travel_date').value = travelDate;
        document.getElementById('modal_travelers').value = travelers;
        document.getElementById('modal_total_amount').value = totalAmount;
        document.getElementById('modal_status').value = status;
        document.getElementById('modalSubmitBtn').name = 'update_booking';
        document.getElementById('modalSubmitBtn').innerText = 'Update Booking';
        document.getElementById('bookingModal').style.display = 'flex';
    }
    
    function closeModal() {
        document.getElementById('bookingModal').style.display = 'none';
    }
    
    window.onclick = function(event) {
        const modal = document.getElementById('bookingModal');
        if (event.target === modal) {
            closeModal();
        }
    }
</script>

</body>
</html>