<?php
session_start();
include('../includes/db_connect.php');

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: ../login.php");
    exit();
}

$page_title = "Admin Dashboard";

// Get counts for dashboard stats
$cities_count = 0;
$attractions_count = 0;
$packages_count = 0;
$bookings_count = 0;

// Cities count
$sql = "SELECT COUNT(*) as count FROM cities";
$result = mysqli_query($conn, $sql);
if ($result) {
    $row = mysqli_fetch_assoc($result);
    $cities_count = $row['count'];
}

// Attractions count
$sql = "SELECT COUNT(*) as count FROM attractions";
$result = mysqli_query($conn, $sql);
if ($result) {
    $row = mysqli_fetch_assoc($result);
    $attractions_count = $row['count'];
}

// Packages count
$sql = "SELECT COUNT(*) as count FROM packages";
$result = mysqli_query($conn, $sql);
if ($result) {
    $row = mysqli_fetch_assoc($result);
    $packages_count = $row['count'];
}

// Bookings count
$sql = "SELECT COUNT(*) as count FROM bookings";
$result = mysqli_query($conn, $sql);
if ($result) {
    $row = mysqli_fetch_assoc($result);
    $bookings_count = $row['count'];
}

// Get recent bookings
$recent_bookings = array();
$sql = "SELECT b.booking_id, p.name, b.payment_status 
        FROM bookings b 
        JOIN packages p ON b.package_id = p.package_id 
        ORDER BY b.booking_date DESC 
        LIMIT 5";
$result = mysqli_query($conn, $sql);
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $recent_bookings[] = $row;
    }
}

// Get recent reviews
$recent_reviews = array();
$sql = "SELECT r.*, p.name as package_name 
        FROM reviews r 
        LEFT JOIN packages p ON r.package_id = p.package_id 
        ORDER BY r.date_posted DESC 
        LIMIT 3";
$result = mysqli_query($conn, $sql);
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $recent_reviews[] = $row;
    }
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
    </style>
</head>
<body>
    <?php include 'admin_header.php'; ?>

    <div class="admin-container">
        <?php include 'admin_sidebar.php'; ?>
        <div class="admin-content">
            <h1 style="color: #000000ff; margin-bottom: 30px;">Dashboard Overview</h1>

            <div class="stats-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 40px;">
                <div class="stat-card glass">
                    <h3>Cities</h3>
                    <p><?php echo $cities_count; ?></p>
                </div>
                <div class="stat-card glass">
                    <h3>Attractions</h3>
                    <p><?php echo $attractions_count; ?></p>
                </div>
                <div class="stat-card glass">
                    <h3>Packages</h3>
                    <p><?php echo $packages_count; ?></p>
                </div>
                <div class="stat-card glass">
                    <h3>Bookings</h3>
                    <p><?php echo $bookings_count; ?></p>
                </div>
            </div>

            <div class="recent-activity" style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">
                <div class="glass" style="padding: 20px;">
                    <h3 style="color: #1f8585ff; margin-bottom: 20px;">Recent Bookings</h3>
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="border-bottom: 1px solid #eee;">
                                <th style="padding: 10px; text-align: left;">ID</th>
                                <th style="padding: 10px; text-align: left;">Package</th>
                                <th style="padding: 10px; text-align: left;">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recent_bookings as $booking): ?>
                            <tr style="border-bottom: 1px solid #eee;">
                                <td style="padding: 10px;"><?php echo $booking['booking_id']; ?></td>
                                <td style="padding: 10px;"><?php echo substr($booking['name'], 0, 20) . '...'; ?></td>
                                <td style="padding: 10px;">
                                    <span style="display: inline-block; padding: 3px 10px; border-radius: 20px; background: <?php echo ($booking['payment_status'] === 'paid' ? '#4CAF50' : '#FFC107'); ?>; color: <?php echo ($booking['payment_status'] === 'paid' ? 'white' : '#333'); ?>;">
                                        <?php echo ucfirst($booking['payment_status']); ?>
                                    </span>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="glass" style="padding: 20px;">
                    <h3 style="color: #1f8585ff; margin-bottom: 20px;">Recent Reviews</h3>
                    <div style="display: flex; flex-direction: column; gap: 15px;">
                        <?php foreach ($recent_reviews as $review): ?>
                        <div style="padding: 15px; background: rgba(255, 255, 255, 0.3); border-radius: 8px;">
                            <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                                <span style="font-weight: 600;"><?php echo $review['user_name']; ?></span>
                                <span style="color: #FFA500;"><?php echo str_repeat('★', $review['rating']) . str_repeat('☆', 5 - $review['rating']); ?></span>
                            </div>
                            <p style="margin-bottom: 5px; font-size: 0.9rem;">"<?php echo substr($review['comment'], 0, 60) . '...'; ?>"</p>
                            <div style="display: flex; justify-content: space-between; font-size: 0.8rem; color: #666;">
                                <span><?php echo ($review['package_name'] ? $review['package_name'] : 'Attraction Review'); ?></span>
                                <span><?php echo date('M j, Y', strtotime($review['date_posted'])); ?></span>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>