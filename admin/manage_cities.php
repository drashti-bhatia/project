<?php
session_start();
include('../includes/db_connect.php');

// if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
//     header("Location: ../login.php");
//     exit();
// }

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_city'])) {
        $city_name = mysqli_real_escape_string($conn, $_POST['city_name']);
        $description = mysqli_real_escape_string($conn, $_POST['description']);
        $best_time = mysqli_real_escape_string($conn, $_POST['best_time_to_visit']);

        // Handle image upload
        $image_url = '';
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $upload_dir = '../assets/images/cities/';
            $file_name = uniqid() . '_' . basename($_FILES['image']['name']);
            $target_path = $upload_dir . $file_name;

            if (move_uploaded_file($_FILES['image']['tmp_name'], $target_path)) {
                $image_url = $file_name;
            }
        }

        $sql = "INSERT INTO cities (city_name, description, image_url, best_time_to_visit)
                VALUES ('$city_name', '$description', '$image_url', '$best_time')";

        mysqli_query($conn, $sql);
    } elseif (isset($_POST['update_city'])) {
        $city_id = intval($_POST['city_id']);
        $city_name = mysqli_real_escape_string($conn, $_POST['city_name']);
        $description = mysqli_real_escape_string($conn, $_POST['description']);
        $best_time = mysqli_real_escape_string($conn, $_POST['best_time_to_visit']);

        $image_sql = '';
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $upload_dir = '../assets/images/cities/';
            $file_name = uniqid() . '_' . basename($_FILES['image']['name']);
            $target_path = $upload_dir . $file_name;

            if (move_uploaded_file($_FILES['image']['tmp_name'], $target_path)) {
                // Delete old image
                $old_image_sql = "SELECT image_url FROM cities WHERE city_id = $city_id";
                $old_image_result = mysqli_query($conn, $old_image_sql);
                $old_image = mysqli_fetch_assoc($old_image_result);

                if ($old_image && $old_image['image_url'] && file_exists($upload_dir . $old_image['image_url'])) {
                    unlink($upload_dir . $old_image['image_url']);
                }

                $image_sql = ", image_url = '$file_name'";
            }
        }

        $sql = "UPDATE cities SET 
                city_name = '$city_name', 
                description = '$description', 
                best_time_to_visit = '$best_time'
                $image_sql
                WHERE city_id = $city_id";

        mysqli_query($conn, $sql);
    } elseif (isset($_POST['delete_city'])) {
        $city_id = intval($_POST['city_id']);

        // Delete image
        $image_sql = "SELECT image_url FROM cities WHERE city_id = $city_id";
        $image_result = mysqli_query($conn, $image_sql);
        $image = mysqli_fetch_assoc($image_result);

        if ($image && $image['image_url'] && file_exists('../assets/images/cities/' . $image['image_url'])) {
            unlink('../assets/images/cities/' . $image['image_url']);
        }

        $sql = "DELETE FROM cities WHERE city_id = $city_id";
        mysqli_query($conn, $sql);
    }
}

$page_title = "Manage Cities";
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
        <h1 style="color: #1f8585ff; margin-bottom: 30px;">Manage Cities</h1>

        <button class="btn-add" onclick="openAddModal()">Add New City</button>

        <div class="table-container glass">
            <h2 style="color: #1f8585ff; margin-bottom: 20px;">Cities List</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM cities ORDER BY city_id DESC";
                    $result = mysqli_query($conn, $sql);

                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<tr>';
                        echo '<td>' . $row['city_id'] . '</td>';
                        echo '<td><img src="../assets/images/cities/' . $row['image_url'] . '" class="city-img" alt="' . $row['city_name'] . '"></td>';
                        echo '<td>' . $row['city_name'] . '</td>';
                        echo '<td>' . substr($row['description'], 0, 50) . '...</td>';
                        echo '<td class="action-btns">';
                        echo '<a href="#" class="edit-btn" onclick="openEditModal(' . $row['city_id'] . ', \'' . htmlspecialchars($row['city_name'], ENT_QUOTES) . '\', \'' . htmlspecialchars($row['description'], ENT_QUOTES) . '\', \'' . htmlspecialchars($row['best_time_to_visit'], ENT_QUOTES) . '\', \'' . $row['image_url'] . '\')"><i class="fas fa-edit"></i> Edit</a>';
                        echo '<form method="POST" action="" style="display:inline;">';
                        echo '<input type="hidden" name="city_id" value="' . $row['city_id'] . '">';
                        echo '<button type="submit" name="delete_city" class="delete-btn" onclick="return confirm(\'Are you sure you want to delete this city?\')"><i class="fas fa-trash"></i> Delete</button>';
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

<div id="cityModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h2 id="modalTitle" style="color: #1f8585ff; margin-bottom: 20px;"></h2>
        <form method="POST" action="" enctype="multipart/form-data">
            <input type="hidden" id="city_id" name="city_id">

            <div class="form-group">
                <label for="city_name">City Name</label>
                <input type="text" class="form-control" id="modal_city_name" name="city_name" required>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="modal_description" name="description" rows="4" required></textarea>
            </div>

            <div class="form-group">
                <label for="best_time_to_visit">Best Time to Visit</label>
                <input type="text" class="form-control" id="modal_best_time" name="best_time_to_visit" required>
            </div>

            <div class="form-group">
                <label for="image">City Image</label>
                <input type="file" class="form-control" id="modal_image" name="image" accept="image/*">
                <div id="current_image_container" style="margin-top: 10px; display: none;">
                    <p>Current Image:</p>
                    <img id="current_image" src="" alt="Current Image" style="max-width: 150px; border-radius: 5px;">
                </div>
            </div>

            <button type="submit" id="modalSubmitBtn" class="btn"></button>
            <button type="button" class="btn" style="background: #666; margin-left: 10px;" onclick="closeModal()">Cancel</button>
        </form>
    </div>
</div>

<script>
    function openAddModal() {
        document.getElementById('modalTitle').innerText = 'Add New City';
        document.getElementById('city_id').value = '';
        document.getElementById('modal_city_name').value = '';
        document.getElementById('modal_description').value = '';
        document.getElementById('modal_best_time').value = '';
        document.getElementById('modal_image').required = true;
        document.getElementById('current_image_container').style.display = 'none';
        document.getElementById('modalSubmitBtn').name = 'add_city';
        document.getElementById('modalSubmitBtn').innerText = 'Add City';
        document.getElementById('cityModal').style.display = 'flex';
    }

    function openEditModal(cityId, cityName, description, bestTime, imageUrl) {
        document.getElementById('modalTitle').innerText = 'Edit City';
        document.getElementById('city_id').value = cityId;
        document.getElementById('modal_city_name').value = cityName;
        document.getElementById('modal_description').value = description;
        document.getElementById('modal_best_time').value = bestTime;
        document.getElementById('modal_image').required = false;
        
        if (imageUrl && imageUrl !== '') {
            document.getElementById('current_image').src = '../assets/images/cities/' + imageUrl;
            document.getElementById('current_image_container').style.display = 'block';
        } else {
            document.getElementById('current_image_container').style.display = 'none';
        }

        document.getElementById('modalSubmitBtn').name = 'update_city';
        document.getElementById('modalSubmitBtn').innerText = 'Update City';
        document.getElementById('cityModal').style.display = 'flex';
    }
    
    function closeModal() {
        document.getElementById('cityModal').style.display = 'none';
    }
    
    // Close the modal when clicking outside of it
    window.onclick = function(event) {
        const modal = document.getElementById('cityModal');
        if (event.target === modal) {
            closeModal();
        }
    }
</script>

</body>
</html>