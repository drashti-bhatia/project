<?php
session_start();
include('../includes/db_connect.php');

// if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
//     header("Location: ../login.php");
//     exit();
// }

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_package'])) {
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $description = mysqli_real_escape_string($conn, $_POST['description']);
        $price = mysqli_real_escape_string($conn, $_POST['price']);
        $duration_days = mysqli_real_escape_string($conn, $_POST['duration_days']);
        $inclusions = mysqli_real_escape_string($conn, $_POST['inclusions']);
        $city_id = mysqli_real_escape_string($conn, $_POST['city_id']);

        // Handle image upload
        $image_url = '';
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $upload_dir = '../assets/images/packages/';
            $file_name = uniqid() . '_' . basename($_FILES['image']['name']);
            $target_path = $upload_dir . $file_name;

            if (move_uploaded_file($_FILES['image']['tmp_name'], $target_path)) {
                $image_url = $file_name;
            }
        }

        $sql = "INSERT INTO packages (name, description, price, duration_days, inclusions, city_id, image_url)
                VALUES ('$name', '$description', '$price', '$duration_days', '$inclusions', '$city_id', '$image_url')";

        mysqli_query($conn, $sql);
    } elseif (isset($_POST['update_package'])) {
        $package_id = intval($_POST['package_id']);
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $description = mysqli_real_escape_string($conn, $_POST['description']);
        $price = mysqli_real_escape_string($conn, $_POST['price']);
        $duration_days = mysqli_real_escape_string($conn, $_POST['duration_days']);
        $inclusions = mysqli_real_escape_string($conn, $_POST['inclusions']);
        $city_id = mysqli_real_escape_string($conn, $_POST['city_id']);

        $image_sql = '';
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $upload_dir = '../assets/images/packages/';
            $file_name = uniqid() . '_' . basename($_FILES['image']['name']);
            $target_path = $upload_dir . $file_name;

            if (move_uploaded_file($_FILES['image']['tmp_name'], $target_path)) {
                // Delete old image
                $old_image_sql = "SELECT image_url FROM packages WHERE package_id = $package_id";
                $old_image_result = mysqli_query($conn, $old_image_sql);
                $old_image = mysqli_fetch_assoc($old_image_result);

                if ($old_image && $old_image['image_url'] && file_exists($upload_dir . $old_image['image_url'])) {
                    unlink($upload_dir . $old_image['image_url']);
                }

                $image_sql = ", image_url = '$file_name'";
            }
        }

        $sql = "UPDATE packages SET 
                name = '$name', 
                description = '$description', 
                price = '$price',
                duration_days = '$duration_days',
                inclusions = '$inclusions',
                city_id = '$city_id'
                $image_sql
                WHERE package_id = $package_id";

        mysqli_query($conn, $sql);
    } elseif (isset($_POST['delete_package'])) {
        $package_id = intval($_POST['package_id']);

        // Delete image
        $image_sql = "SELECT image_url FROM packages WHERE package_id = $package_id";
        $image_result = mysqli_query($conn, $image_sql);
        $image = mysqli_fetch_assoc($image_result);

        if ($image && $image['image_url'] && file_exists('../assets/images/packages/' . $image['image_url'])) {
            unlink('../assets/images/packages/' . $image['image_url']);
        }

        $sql = "DELETE FROM packages WHERE package_id = $package_id";
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
        /* Ensure the modal is hidden by default. */
        .modal {
            display: none;
        }
    </style>
</head>
<body>
    <?php include 'admin_header.php'; ?>
    
    <div class="admin-container">
        <?php include 'admin_sidebar.php'; ?>
        
    <div class="admin-content">
        <h1 style="color: #1f8585ff; margin-bottom: 30px;">Manage Packages</h1>
        
        <button class="btn-add" onclick="openAddModal()">Add New Package</button>

        <div class="table-container glass">
            <h2 style="color: #1f8585ff; margin-bottom: 20px;">Packages List</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Duration</th>
                        <th>City</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Re-fetch cities for display
                    mysqli_data_seek($cities_result, 0);
                    $cities = array();
                    while ($city = mysqli_fetch_assoc($cities_result)) {
                        $cities[$city['city_id']] = $city['city_name'];
                    }
                    
                    $sql = "SELECT * FROM packages ORDER BY package_id DESC";
                    $result = mysqli_query($conn, $sql);

                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<tr>';
                        echo '<td>' . $row['package_id'] . '</td>';
                        echo '<td><img src="../assets/images/packages/' . $row['image_url'] . '" class="package-img" alt="' . $row['name'] . '"></td>';
                        echo '<td>' . $row['name'] . '</td>';
                        echo '<td>₹' . $row['price'] . '</td>';
                        echo '<td>' . $row['duration_days'] . ' days</td>';
                        echo '<td>' . (isset($cities[$row['city_id']]) ? $cities[$row['city_id']] : 'N/A') . '</td>';
                        echo '<td class="action-btns">';
                        echo '<a href="#" class="edit-btn" onclick="openEditModal(' . $row['package_id'] . ', \'' . htmlspecialchars($row['name'], ENT_QUOTES) . '\', \'' . htmlspecialchars($row['description'], ENT_QUOTES) . '\', \'' . $row['price'] . '\', \'' . $row['duration_days'] . '\', \'' . htmlspecialchars($row['inclusions'], ENT_QUOTES) . '\', \'' . $row['city_id'] . '\', \'' . $row['image_url'] . '\')"><i class="fas fa-edit"></i> Edit</a>';
                        echo '<form method="POST" action="" style="display:inline;">';
                        echo '<input type="hidden" name="package_id" value="' . $row['package_id'] . '">';
                        echo '<button type="submit" name="delete_package" class="delete-btn" onclick="return confirm(\'Are you sure you want to delete this package?\')"><i class="fas fa-trash"></i> Delete</button>';
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

<div id="packageModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h2 id="modalTitle" style="color: #1f8585ff; margin-bottom: 20px;"></h2>
        <form method="POST" action="" enctype="multipart/form-data">
            <input type="hidden" id="package_id" name="package_id">

            <div class="form-group">
                <label for="name">Package Name</label>
                <input type="text" class="form-control" id="modal_name" name="name" required>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="modal_description" name="description" rows="4" required></textarea>
            </div>

            <div class="form-group">
                <label for="price">Price (₹)</label>
                <input type="number" class="form-control" id="modal_price" name="price" required min="0">
            </div>

            <div class="form-group">
                <label for="duration_days">Duration (Days)</label>
                <input type="number" class="form-control" id="modal_duration_days" name="duration_days" required min="1">
            </div>

            <div class="form-group">
                <label for="inclusions">Inclusions</label>
                <textarea class="form-control" id="modal_inclusions" name="inclusions" rows="3"></textarea>
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
                <label for="image">Package Image</label>
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
        document.getElementById('modalTitle').innerText = 'Add New Package';
        document.getElementById('package_id').value = '';
        document.getElementById('modal_name').value = '';
        document.getElementById('modal_description').value = '';
        document.getElementById('modal_price').value = '';
        document.getElementById('modal_duration_days').value = '';
        document.getElementById('modal_inclusions').value = '';
        document.getElementById('modal_city_id').value = '';
        document.getElementById('modal_image').required = true;
        document.getElementById('current_image_container').style.display = 'none';
        document.getElementById('modalSubmitBtn').name = 'add_package';
        document.getElementById('modalSubmitBtn').innerText = 'Add Package';
        document.getElementById('packageModal').style.display = 'flex';
    }

    function openEditModal(packageId, name, description, price, duration_days, inclusions, cityId, imageUrl) {
        document.getElementById('modalTitle').innerText = 'Edit Package';
        document.getElementById('package_id').value = packageId;
        document.getElementById('modal_name').value = name;
        document.getElementById('modal_description').value = description;
        document.getElementById('modal_price').value = price;
        document.getElementById('modal_duration_days').value = duration_days;
        document.getElementById('modal_inclusions').value = inclusions;
        document.getElementById('modal_city_id').value = cityId;
        document.getElementById('modal_image').required = false;

        if (imageUrl && imageUrl !== '') {
            document.getElementById('current_image').src = '../assets/images/packages/' + imageUrl;
            document.getElementById('current_image_container').style.display = 'block';
        } else {
            document.getElementById('current_image_container').style.display = 'none';
        }

        document.getElementById('modalSubmitBtn').name = 'update_package';
        document.getElementById('modalSubmitBtn').innerText = 'Update Package';
        document.getElementById('packageModal').style.display = 'flex';
    }
    
    function closeModal() {
        document.getElementById('packageModal').style.display = 'none';
    }
    
    // Close the modal when clicking outside of it
    window.onclick = function(event) {
        const modal = document.getElementById('packageModal');
        if (event.target === modal) {
            closeModal();
        }
    }
</script>

</body>
</html>