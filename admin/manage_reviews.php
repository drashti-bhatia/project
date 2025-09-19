<?php
session_start();
include('../includes/db_connect.php');

// if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
//     header("Location: ../login.php");
//     exit();
// }

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_review'])) {
        $review_id = intval($_POST['review_id']);
        $rating = mysqli_real_escape_string($conn, $_POST['rating']);
        $comment = mysqli_real_escape_string($conn, $_POST['comment']);
        $status = mysqli_real_escape_string($conn, $_POST['status']);

        $sql = "UPDATE reviews SET 
                rating = '$rating',
                comment = '$comment',
                status = '$status'
                WHERE review_id = $review_id";

        mysqli_query($conn, $sql);
    } elseif (isset($_POST['delete_review'])) {
        $review_id = intval($_POST['review_id']);

        $sql = "DELETE FROM reviews WHERE review_id = $review_id";
        mysqli_query($conn, $sql);
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
    
    <!-- Main Content -->
    <div class="admin-content">
        <h1 style="color: #1f8585ff; margin-bottom: 30px;">Manage Reviews</h1>

        <!-- Filters -->
        <div class="filter-container">
            <div class="filter-item">
                <label for="status_filter">Status</label>
                <select id="status_filter" onchange="filterReviews()">
                    <option value="all">All Statuses</option>
                    <option value="pending">Pending</option>
                    <option value="approved">Approved</option>
                    <option value="rejected">Rejected</option>
                </select>
            </div>
            <div class="filter-item">
                <label for="rating_filter">Rating</label>
                <select id="rating_filter" onchange="filterReviews()">
                    <option value="all">All Ratings</option>
                    <option value="5">5 Stars</option>
                    <option value="4">4 Stars</option>
                    <option value="3">3 Stars</option>
                    <option value="2">2 Stars</option>
                    <option value="1">1 Star</option>
                </select>
            </div>
            <div class="filter-item">
                <label for="type_filter">Type</label>
                <select id="type_filter" onchange="filterReviews()">
                    <option value="all">All Types</option>
                    <option value="package">Package Reviews</option>
                    <option value="attraction">Attraction Reviews</option>
                </select>
            </div>
        </div>

        <!-- Reviews List -->
        <div class="table-container glass">
            <h2 style="color: #1f8585ff; margin-bottom: 20px;">Reviews List</h2>
            <table id="reviews-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User</th>
                        <th>Rating</th>
                        <th>Comment</th>
                        <th>Type</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT r.*, u.username, u.email, 
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
                            ORDER BY r.date_posted DESC";
                    $result = mysqli_query($conn, $sql);

                    while ($row = mysqli_fetch_assoc($result)) {
                        $badge_class = '';
                        if ($row['status'] == 'pending') $badge_class = 'status-pending';
                        if ($row['status'] == 'approved') $badge_class = 'status-approved';
                        if ($row['status'] == 'rejected') $badge_class = 'status-rejected';
                        
                        $stars = str_repeat('★', $row['rating']) . str_repeat('☆', 5 - $row['rating']);
                        
                        echo '<tr data-status="' . $row['status'] . '" data-rating="' . $row['rating'] . '" data-type="' . $row['review_type'] . '">';
                        echo '<td>' . $row['review_id'] . '</td>';
                        echo '<td>';
                        echo '<div class="review-details">';
                        echo '<span class="review-user">' . $row['username'] . '</span>';
                        echo '<span class="review-date">' . $row['email'] . '</span>';
                        echo '</div>';
                        echo '</td>';
                        echo '<td><span class="rating-stars">' . $stars . '</span></td>';
                        echo '<td class="review-comment" title="' . htmlspecialchars($row['comment']) . '">' . substr($row['comment'], 0, 50) . '...</td>';
                        echo '<td>' . ucfirst($row['review_type']) . '<br><small>' . $row['item_name'] . '</small></td>';
                        echo '<td>' . date('M j, Y', strtotime($row['date_posted'])) . '</td>';
                        echo '<td><span class="status-badge ' . $badge_class . '">' . ucfirst($row['status']) . '</span></td>';
                        echo '<td class="action-btns">';
                        echo '<a href="#" class="edit-btn" onclick="openEditModal(' . $row['review_id'] . ', \'' . $row['comment'] . '\', ' . $row['rating'] . ', \'' . $row['status'] . '\')"><i class="fas fa-edit"></i> Edit</a>';
                        echo '<form method="POST" action="" style="display:inline;">';
                        echo '<input type="hidden" name="review_id" value="' . $row['review_id'] . '">';
                        echo '<button type="submit" name="delete_review" class="delete-btn" onclick="return confirm(\'Are you sure you want to delete this review?\')"><i class="fas fa-trash"></i> Delete</button>';
                        echo '</form>';
                        echo '</td>';
                        echo '</tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeEditModal()">&times;</span>
        <h2 style="color: #1f8585ff; margin-bottom: 20px;">Edit Review</h2>
        <form method="POST" action="">
            <input type="hidden" id="modal_review_id" name="review_id">
            
            <div class="form-group">
                <label for="modal_rating">Rating</label>
                <select class="form-control" id="modal_rating" name="rating" required>
                    <option value="1">1 Star</option>
                    <option value="2">2 Stars</option>
                    <option value="3">3 Stars</option>
                    <option value="4">4 Stars</option>
                    <option value="5">5 Stars</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="modal_comment">Comment</label>
                <textarea class="form-control" id="modal_comment" name="comment" rows="4" required></textarea>
            </div>
            
            <div class="form-group">
                <label for="modal_status">Status</label>
                <select class="form-control" id="modal_status" name="status" required>
                    <option value="pending">Pending</option>
                    <option value="approved">Approved</option>
                    <option value="rejected">Rejected</option>
                </select>
            </div>
            
            <button type="submit" name="update_review" class="btn">Update Review</button>
            <button type="button" class="btn" style="background: #666;" onclick="closeEditModal()">Cancel</button>
        </form>
    </div>
</div>

<script>
    function filterReviews() {
        const statusFilter = document.getElementById('status_filter').value;
        const ratingFilter = document.getElementById('rating_filter').value;
        const typeFilter = document.getElementById('type_filter').value;
        
        const rows = document.querySelectorAll('#reviews-table tbody tr');
        
        rows.forEach(row => {
            const status = row.getAttribute('data-status');
            const rating = row.getAttribute('data-rating');
            const type = row.getAttribute('data-type');
            
            const statusMatch = statusFilter === 'all' || status === statusFilter;
            const ratingMatch = ratingFilter === 'all' || rating === ratingFilter;
            const typeMatch = typeFilter === 'all' || type === typeFilter;
            
            if (statusMatch && ratingMatch && typeMatch) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }
    
    function openEditModal(reviewId, comment, rating, status) {
        document.getElementById('modal_review_id').value = reviewId;
        document.getElementById('modal_comment').value = comment;
        document.getElementById('modal_rating').value = rating;
        document.getElementById('modal_status').value = status;
        
        document.getElementById('editModal').style.display = 'block';
    }
    
    function closeEditModal() {
        document.getElementById('editModal').style.display = 'none';
    }
    
    // Close modal when clicking outside of it
    window.onclick = function(event) {
        const modal = document.getElementById('editModal');
        if (event.target === modal) {
            closeEditModal();
        }
    }
</script>
</body>
</html>