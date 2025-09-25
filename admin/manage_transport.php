<?php
session_start();
include('../includes/db_connect.php');

// if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
//     header("Location: ../login.php");
//     exit();
// }

$page_title = "Manage Transport";

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_transport'])) {
        $transport_type = mysqli_real_escape_string($conn, $_POST['transport_type']);
        $departure_city_id = intval($_POST['departure_city_id']);
        $arrival_city_id = intval($_POST['arrival_city_id']);
        $departure_time = mysqli_real_escape_string($conn, $_POST['departure_time']);
        $arrival_time = mysqli_real_escape_string($conn, $_POST['arrival_time']);
        $approx_price = mysqli_real_escape_string($conn, $_POST['approx_price']);
        $description = mysqli_real_escape_string($conn, $_POST['description']);

        $sql = "INSERT INTO transport_options (transport_type, departure_city_id, arrival_city_id, departure_time, arrival_time, approx_price, description)
                VALUES ('$transport_type', '$departure_city_id', '$arrival_city_id', '$departure_time', '$arrival_time', '$approx_price', '$description')";

        mysqli_query($conn, $sql);
    } elseif (isset($_POST['update_transport'])) {
        $transport_id = intval($_POST['transport_id']);
        $transport_type = mysqli_real_escape_string($conn, $_POST['transport_type']);
        $departure_city_id = intval($_POST['departure_city_id']);
        $arrival_city_id = intval($_POST['arrival_city_id']);
        $departure_time = mysqli_real_escape_string($conn, $_POST['departure_time']);
        $arrival_time = mysqli_real_escape_string($conn, $_POST['arrival_time']);
        $approx_price = mysqli_real_escape_string($conn, $_POST['approx_price']);
        $description = mysqli_real_escape_string($conn, $_POST['description']);

        $sql = "UPDATE transport_options SET 
                transport_type = '$transport_type', 
                departure_city_id = '$departure_city_id', 
                arrival_city_id = '$arrival_city_id',
                departure_time = '$departure_time',
                arrival_time = '$arrival_time',
                approx_price = '$approx_price',
                description = '$description'
                WHERE transport_id = $transport_id";

        mysqli_query($conn, $sql);
    } elseif (isset($_POST['delete_transport'])) {
        $transport_id = intval($_POST['transport_id']);

        $sql = "DELETE FROM transport_options WHERE transport_id = $transport_id";
        mysqli_query($conn, $sql);
    }
}

// Fetch cities for dropdown menus and display lookup
$cities_sql = "SELECT city_id, city_name FROM cities ORDER BY city_name";
$cities_result = mysqli_query($conn, $cities_sql);
$cities_lookup = [];
while ($city = mysqli_fetch_assoc($cities_result)) {
    $cities_lookup[$city['city_id']] = $city['city_name'];
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
    </style>
</head>
<body>
    <?php include 'admin_header.php'; ?>
    
    <div class="admin-container">
        <?php include 'admin_sidebar.php'; ?>
        
    <div class="admin-content">
        <h1 style="color: #1f8585ff; margin-bottom: 30px;">Manage Transport</h1>

        <button class="btn-add" onclick="openAddModal()">Add New Transport</button>

        <div class="table-container glass">
            <h2 style="color: #1f8585ff; margin-bottom: 20px;">Transport Options List</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Type</th>
                        <th>Departure City</th>
                        <th>Arrival City</th>
                        <th>Departure Time</th>
                        <th>Price</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM transport_options ORDER BY transport_id";
                    $result = mysqli_query($conn, $sql);

                    while ($row = mysqli_fetch_assoc($result)) {
                        $badge_class = '';
                        if ($row['transport_type'] == 'bus') $badge_class = 'badge-bus';
                        if ($row['transport_type'] == 'train') $badge_class = 'badge-train';
                        if ($row['transport_type'] == 'flight') $badge_class = 'badge-flight';
                        if ($row['transport_type'] == 'car') $badge_class = 'badge-car'; // Added car
                        
                        echo '<tr>';
                        echo '<td>' . $row['transport_id'] . '</td>';
                        echo '<td><span class="transport-badge ' . $badge_class . '">' . ucfirst($row['transport_type']) . '</span></td>';
                        echo '<td>' . htmlspecialchars($cities_lookup[$row['departure_city_id']] ?? 'N/A') . '</td>';
                        echo '<td>' . htmlspecialchars($cities_lookup[$row['arrival_city_id']] ?? 'N/A') . '</td>';
                        echo '<td>' . date('h:i A', strtotime($row['departure_time'])) . '</td>';
                        echo '<td>₹' . $row['approx_price'] . '</td>';
                        echo '<td class="action-btns">';
                        echo '<a href="#" class="edit-btn" onclick="openEditModal(' . $row['transport_id'] . ', \'' . htmlspecialchars($row['transport_type'], ENT_QUOTES) . '\', ' . $row['departure_city_id'] . ', ' . $row['arrival_city_id'] . ', \'' . htmlspecialchars($row['departure_time'], ENT_QUOTES) . '\', \'' . htmlspecialchars($row['arrival_time'], ENT_QUOTES) . '\', \'' . $row['approx_price'] . '\', \'' . htmlspecialchars($row['description'], ENT_QUOTES) . '\')"><i class="fas fa-edit"></i> Edit</a>';
                        echo '<form method="POST" action="" style="display:inline;">';
                        echo '<input type="hidden" name="transport_id" value="' . $row['transport_id'] . '">';
                        echo '<button type="submit" name="delete_transport" class="delete-btn" onclick="return confirm(\'Are you sure you want to delete this transport option?\')"><i class="fas fa-trash"></i> Delete</button>';
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

<div id="transportModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h2 id="modalTitle" style="color: #1f8585ff; margin-bottom: 20px;"></h2>
        <form method="POST" action="">
            <input type="hidden" id="transport_id" name="transport_id">

            <div class="form-group">
                <label for="transport_type">Transport Type</label>
                <select class="form-control" id="modal_transport_type" name="transport_type" required>
                    <option value="">Select Type</option>
                    <option value="bus">Bus</option>
                    <option value="train">Train</option>
                    <option value="flight">Flight</option>
                    <option value="car">Car</option>
                </select>
            </div>

            <div class="form-group">
                <label for="departure_city_id">Departure City</label>
                <select class="form-control" id="modal_departure_city_id" name="departure_city_id" required>
                    <option value="">Select Departure City</option>
                    <?php 
                    mysqli_data_seek($cities_result, 0); // Reset result pointer
                    while ($city = mysqli_fetch_assoc($cities_result)): ?>
                        <option value="<?php echo $city['city_id']; ?>"><?php echo $city['city_name']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="arrival_city_id">Arrival City</label>
                <select class="form-control" id="modal_arrival_city_id" name="arrival_city_id" required>
                    <option value="">Select Arrival City</option>
                    <?php 
                    mysqli_data_seek($cities_result, 0); // Reset result pointer
                    while ($city = mysqli_fetch_assoc($cities_result)): ?>
                        <option value="<?php echo $city['city_id']; ?>"><?php echo $city['city_name']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="departure_time">Departure Time</label>
                <input type="time" class="form-control" id="modal_departure_time" name="departure_time" required>
            </div>

            <div class="form-group">
                <label for="arrival_time">Arrival Time</label>
                <input type="time" class="form-control" id="modal_arrival_time" name="arrival_time">
            </div>

            <div class="form-group">
                <label for="approx_price">Approximate Price (₹)</label>
                <input type="number" class="form-control" id="modal_approx_price" name="approx_price" required min="0">
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="modal_description" name="description" rows="3"></textarea>
            </div>

            <div class="btn-container">
                <button type="submit" id="modalSubmitBtn" class="btn"></button>
                <button type="button" class="btn-cancel" onclick="closeModal()">Cancel</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openAddModal() {
        document.getElementById('modalTitle').innerText = 'Add New Transport';
        document.getElementById('transport_id').value = '';
        document.getElementById('modal_transport_type').value = '';
        document.getElementById('modal_departure_city_id').value = '';
        document.getElementById('modal_arrival_city_id').value = '';
        document.getElementById('modal_departure_time').value = '';
        document.getElementById('modal_arrival_time').value = '';
        document.getElementById('modal_approx_price').value = '';
        document.getElementById('modal_description').value = '';
        document.getElementById('modalSubmitBtn').name = 'add_transport';
        document.getElementById('modalSubmitBtn').innerText = 'Add Transport';
        document.getElementById('transportModal').style.display = 'flex';
    }

    function openEditModal(transportId, type, depCityId, arrCityId, depTime, arrTime, price, description) {
        document.getElementById('modalTitle').innerText = 'Edit Transport';
        document.getElementById('transport_id').value = transportId;
        document.getElementById('modal_transport_type').value = type;
        document.getElementById('modal_departure_city_id').value = depCityId;
        document.getElementById('modal_arrival_city_id').value = arrCityId;
        document.getElementById('modal_departure_time').value = depTime;
        document.getElementById('modal_arrival_time').value = arrTime;
        document.getElementById('modal_approx_price').value = price;
        document.getElementById('modal_description').value = description;
        document.getElementById('modalSubmitBtn').name = 'update_transport';
        document.getElementById('modalSubmitBtn').innerText = 'Update Transport';
        document.getElementById('transportModal').style.display = 'flex';
    }
    
    function closeModal() {
        document.getElementById('transportModal').style.display = 'none';
    }
    
    // Close the modal when clicking outside of it
    window.onclick = function(event) {
        const modal = document.getElementById('transportModal');
        if (event.target === modal) {
            closeModal();
        }
    }
</script>

</body>
</html>