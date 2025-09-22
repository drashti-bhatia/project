<?php
session_start();
include('../includes/db_connect.php');

// if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
//     header("Location: ../login.php");
//     exit();
// }

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_attraction'])) {
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $city_id = mysqli_real_escape_string($conn, $_POST['city_id']);
        $description = mysqli_real_escape_string($conn, $_POST['description']);
        $entry_fee = mysqli_real_escape_string($conn, $_POST['entry_fee']);
        $best_time_to_visit = mysqli_real_escape_string($conn, $_POST['best_time_to_visit']);
        $opening_hours = mysqli_real_escape_string($conn, $_POST['opening_hours']);

        // Handle image upload
        $image_url = '';
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $upload_dir = '../assets/images/attractions/';
            $file_name = uniqid() . '_' . basename($_FILES['image']['name']);
            $target_path = $upload_dir . $file_name;

            if (move_uploaded_file($_FILES['image']['tmp_name'], $target_path)) {
                $image_url = $file_name;
            }
        }

        $sql = "INSERT INTO attractions (name, city_id, description, entry_fee, best_time_to_visit, opening_hours, image_url)
                VALUES ('$name', '$city_id', '$description', '$entry_fee', '$best_time_to_visit', '$opening_hours', '$image_url')";

        mysqli_query($conn, $sql);
    } elseif (isset($_POST['update_attraction'])) {
        $attraction_id = intval($_POST['attraction_id']);
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $city_id = mysqli_real_escape_string($conn, $_POST['city_id']);
        $description = mysqli_real_escape_string($conn, $_POST['description']);
        $entry_fee = mysqli_real_escape_string($conn, $_POST['entry_fee']);
        $best_time_to_visit = mysqli_real_escape_string($conn, $_POST['best_time_to_visit']);
        $opening_hours = mysqli_real_escape_string($conn, $_POST['opening_hours']);

        $image_sql = '';
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $upload_dir = '../assets/images/attractions/';
            $file_name = uniqid() . '_' . basename($_FILES['image']['name']);
            $target_path = $upload_dir . $file_name;

            if (move_uploaded_file($_FILES['image']['tmp_name'], $target_path)) {
                // Delete old image
                $old_image_sql = "SELECT image_url FROM attractions WHERE attraction_id = $attraction_id";
                $old_image_result = mysqli_query($conn, $old_image_sql);
                $old_image = mysqli_fetch_assoc($old_image_result);

                if ($old_image && $old_image['image_url'] && file_exists($upload_dir . $old_image['image_url'])) {
                    unlink($upload_dir . $old_image['image_url']);
                }

                $image_sql = ", image_url = '$file_name'";
            }
        }

        $sql = "UPDATE attractions SET 
                name = '$name', 
                city_id = '$city_id', 
                description = '$description',
                entry_fee = '$entry_fee',
                best_time_to_visit = '$best_time_to_visit',
                opening_hours = '$opening_hours'
                $image_sql
                WHERE attraction_id = $attraction_id";

        mysqli_query($conn, $sql);
    } elseif (isset($_POST['delete_attraction'])) {
        $attraction_id = intval($_POST['attraction_id']);

        // Delete image
        $image_sql = "SELECT image_url FROM attractions WHERE attraction_id = $attraction_id";
        $image_result = mysqli_query($conn, $image_sql);
        $image = mysqli_fetch_assoc($image_result);

        if ($image && $image['image_url'] && file_exists('../assets/images/attractions/' . $image['image_url'])) {
            unlink('../assets/images/attractions/' . $image['image_url']);
        }

        $sql = "DELETE FROM attractions WHERE attraction_id = $attraction_id";
        mysqli_query($conn, $sql);
    }
}


// Fetch cities for dropdown
$cities_sql = "SELECT * FROM cities ORDER BY city_name";
$cities_result = mysqli_query($conn, $cities_sql);
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
        /* Ensures the modal is hidden by default. This is the fix. */
        .modal {
            display: none;
        }
    </style>
</head>
<body>
    <?php include 'admin_header.php'; ?>
    
    <div class="admin-container">
        <?php include 'admin_sidebar.php'; ?>
        
    <!-- Main Content -->
    <div class="admin-content">
        <h1 style="color: #1f8585ff; margin-bottom: 30px;">Manage Attractions</h1>
        <button class="btn-add" onclick="openAddModal()">Add New Attraction</button>

        <!-- Attractions List -->
        <div class="table-container glass">
            <h2 style="color: #1f8585ff; margin-bottom: 20px;">Attractions List</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>City</th>
                        <th>Description</th>
                        <th>Entry Fee</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Reset cities result pointer
                    mysqli_data_seek($cities_result, 0);
                    $cities = array();
                    while ($city = mysqli_fetch_assoc($cities_result)) {
                        $cities[$city['city_id']] = $city['city_name'];
                    }
                    
                    $sql = "SELECT * FROM attractions ORDER BY attraction_id DESC";
                    $result = mysqli_query($conn, $sql);

                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<tr>';
                        echo '<td>' . $row['attraction_id'] . '</td>';
                        echo '<td><img src="../assets/images/attractions/' . $row['image_url'] . '" class="attraction-img" alt="' . $row['name'] . '"></td>';
                        echo '<td>' . $row['name'] . '</td>';
                        echo '<td>' . (isset($cities[$row['city_id']]) ? $cities[$row['city_id']] : 'N/A') . '</td>';
                        echo '<td class="attraction-description" title="' . htmlspecialchars($row['description']) . '">' . substr($row['description'], 0, 50) . '...</td>';
                        echo '<td>₹' . $row['entry_fee'] . '</td>';
                        echo '<td class="action-btns">';
                        echo '<a href="#" class="edit-btn" onclick="openEditModal(' . $row['attraction_id'] . ', \'' . addslashes(htmlspecialchars($row['name'], ENT_QUOTES)) . '\', \'' . $row['city_id'] . '\', \'' . addslashes(htmlspecialchars($row['description'], ENT_QUOTES)) . '\', \'' . $row['entry_fee'] . '\', \'' . addslashes(htmlspecialchars($row['best_time_to_visit'], ENT_QUOTES)) . '\', \'' . addslashes(htmlspecialchars($row['opening_hours'], ENT_QUOTES)) . '\', \'' . $row['image_url'] . '\')"><i class="fas fa-edit"></i> Edit</a>';
                        echo '<form method="POST" action="" style="display:inline;">';
                        echo '<input type="hidden" name="attraction_id" value="' . $row['attraction_id'] . '">';
                        echo '<button type="submit" name="delete_attraction" class="delete-btn" onclick="return confirm(\'Are you sure you want to delete this attraction?\')"><i class="fas fa-trash"></i> Delete</button>';
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

<!-- Edit/Add Attraction Modal -->
<div id="attractionModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h2 id="modalTitle" style="color: #1f8585ff; margin-bottom: 20px;"></h2>
        <form method="POST" action="" enctype="multipart/form-data">
            <input type="hidden" id="attraction_id" name="attraction_id">

            <div class="form-group">
                <label for="name">Attraction Name</label>
                <input type="text" class="form-control" id="modal_name" name="name" required>
            </div>

            <div class="form-group">
                <label for="city_id">City</label>
                <select class="form-control" id="modal_city_id" name="city_id" required>
                    <option value="">Select City</option>
                    <?php
                    // Re-fetch cities as the pointer has moved
                    $cities_sql = "SELECT * FROM cities ORDER BY city_name";
                    $cities_result = mysqli_query($conn, $cities_sql);
                    while ($city = mysqli_fetch_assoc($cities_result)): ?>
                        <option value="<?php echo $city['city_id']; ?>"><?php echo $city['city_name']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="modal_description" name="description" rows="4" required></textarea>
            </div>

            <div class="form-group">
                <label for="entry_fee">Entry Fee (₹)</label>
                <input type="number" class="form-control" id="modal_entry_fee" name="entry_fee" required min="0">
            </div>

            <div class="form-group">
                <label for="best_time_to_visit">Best Time to Visit</label>
                <input type="text" class="form-control" id="modal_best_time" name="best_time_to_visit" required>
            </div>

            <div class="form-group">
                <label for="opening_hours">Opening Hours</label>
                <input type="text" class="form-control" id="modal_opening_hours" name="opening_hours" placeholder="e.g., 9:00 AM - 6:00 PM">
            </div>

            <div class="form-group">
                <label for="image">Attraction Image</label>
                <input type="file" class="form-control" id="modal_image" name="image" accept="image/*">
                <div id="current_image_container" style="margin-top: 10px; display: none;">
                    <p>Current Image:</p>
                    <img id="current_image" src="" alt="Current Image" style="max-width: 150px; border-radius: 5px;">
                </div>
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
        document.getElementById('modalTitle').innerText = 'Add New Attraction';
        document.getElementById('attraction_id').value = '';
        document.getElementById('modal_name').value = '';
        document.getElementById('modal_city_id').value = '';
        document.getElementById('modal_description').value = '';
        document.getElementById('modal_entry_fee').value = '';
        document.getElementById('modal_best_time').value = '';
        document.getElementById('modal_opening_hours').value = '';
        document.getElementById('modal_image').required = true;
        document.getElementById('current_image_container').style.display = 'none';
        document.getElementById('modalSubmitBtn').name = 'add_attraction';
        document.getElementById('modalSubmitBtn').innerText = 'Add Attraction';
        document.getElementById('attractionModal').style.display = 'flex';
    }

    function openEditModal(attractionId, name, cityId, description, entryFee, bestTime, openingHours, imageUrl) {
        document.getElementById('modalTitle').innerText = 'Edit Attraction';
        document.getElementById('attraction_id').value = attractionId;
        document.getElementById('modal_name').value = name;
        document.getElementById('modal_city_id').value = cityId;
        document.getElementById('modal_description').value = description;
        document.getElementById('modal_entry_fee').value = entryFee;
        document.getElementById('modal_best_time').value = bestTime;
        document.getElementById('modal_opening_hours').value = openingHours;
        document.getElementById('modal_image').required = false;

        if (imageUrl && imageUrl !== '') {
            document.getElementById('current_image').src = '../assets/images/attractions/' + imageUrl;
            document.getElementById('current_image_container').style.display = 'block';
        } else {
            document.getElementById('current_image_container').style.display = 'none';
        }

        document.getElementById('modalSubmitBtn').name = 'update_attraction';
        document.getElementById('modalSubmitBtn').innerText = 'Update Attraction';
        document.getElementById('attractionModal').style.display = 'flex';
    }
    
    function closeModal() {
        document.getElementById('attractionModal').style.display = 'none';
    }
    
    // Close the modal when clicking outside of it
    window.onclick = function(event) {
        const modal = document.getElementById('attractionModal');
        if (event.target === modal) {
            closeModal();
        }
    }
</script>

</body>
</html>