<?php
include('includes/db_connect.php');
include('header.php');

// Check if a city ID is passed in the URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    // If no ID is provided, redirect to the main cities page
    header("Location: cities.php");
    exit();
}

// Sanitize the input to prevent SQL injection
$city_id = intval($_GET['id']);

// Use a prepared statement to fetch city details securely
$city_sql = "SELECT * FROM cities WHERE city_id = ?";
$stmt_city = mysqli_prepare($conn, $city_sql);
mysqli_stmt_bind_param($stmt_city, "i", $city_id);
mysqli_stmt_execute($stmt_city);
$city_result = mysqli_stmt_get_result($stmt_city);
$city = mysqli_fetch_assoc($city_result);

// If no city is found with the given ID, redirect back
if (!$city) {
    header("Location: cities.php");
    exit();
}

// Fetch attractions for this city using a prepared statement
$attractions_sql = "SELECT * FROM attractions WHERE city_id = ?";
$stmt_attractions = mysqli_prepare($conn, $attractions_sql);
mysqli_stmt_bind_param($stmt_attractions, "i", $city_id);
mysqli_stmt_execute($stmt_attractions);
$attractions_result = mysqli_stmt_get_result($stmt_attractions);

$page_title = htmlspecialchars($city['city_name']) . " - Gujarat Yatra Portal";

// --- START OF NEW CODE ---

// Fetch all cities into a lookup array
$all_cities = [];
$all_cities_sql = "SELECT city_id, city_name FROM cities";
$all_cities_result = mysqli_query($conn, $all_cities_sql);
while ($c = mysqli_fetch_assoc($all_cities_result)) {
    $all_cities[$c['city_id']] = $c['city_name'];
}

// Fetch transport options for the city
$transport_sql = "SELECT * FROM transport_options WHERE departure_city_id = ? OR arrival_city_id = ?";
$stmt_transport = mysqli_prepare($conn, $transport_sql);
mysqli_stmt_bind_param($stmt_transport, "ii", $city_id, $city_id);
mysqli_stmt_execute($stmt_transport);
$transport_result = mysqli_stmt_get_result($stmt_transport);

// --- END OF NEW CODE ---

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
        .city-hero {
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('assets/img/cities/<?php echo htmlspecialchars($city['image_url']); ?>');
            background-size: cover;
            background-position: center;
            padding: 100px 0;
            text-align: center;
            color: white;
            margin-top: 105px;
        }

        .city-hero h1 {
            font-size: 3.5rem;
            margin-bottom: 10px;
        }

        .city-hero p {
            font-size: 1.2rem;
        }

        .city-section {
            padding: 50px 5%;
            background-color: #f1f5f8;
        }

        .city-info-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 40px;
            align-items: flex-start;
            margin-bottom: 50px;
        }

        .city-description h2 {
            font-size: 2.5rem;
            margin-bottom: 15px;
            color: #1f8585ff;
        }

        .city-description p {
            font-size: 1.1rem;
            line-height: 1.8;
            color: #555;
        }

        .info-card {
            background: #fff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            border-left: 5px solid #3685fb;
        }

        .info-card h3 {
            font-size: 1.5rem;
            margin-bottom: 15px;
            color: #333;
        }

        .info-card p {
            margin-bottom: 10px;
            font-size: 1rem;
            color: #666;
        }

        .info-card strong {
            color: #FF6B35;
        }

        .attractions-list-section h2 {
            font-size: 2.5rem;
            margin-bottom: 30px;
            text-align: center;
            color: #1f8585ff;
        }

        .attractions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 30px;
        }

        .attraction-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .attraction-card:hover {
            transform: translateY(-10px);
        }

        .attraction-image {
            width: 100%;
            height: 220px;
            object-fit: cover;
        }

        .attraction-content {
            padding: 20px;
        }

        .attraction-content h3 {
            font-size: 1.5rem;
            margin-bottom: 10px;
            color: #333;
        }

        .attraction-content p {
            font-size: 1rem;
            color: #666;
            margin-bottom: 15px;
        }

        .attraction-details {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 15px;
        }

        .attraction-details span {
            background: #f9f2eeff;
            color: #983b3bff;
            padding: 5px 12px;
            border-radius: 50px;
            font-size: 0.9rem;
            font-weight: 600;
        }

        .transport-options-section {
            padding: 50px 5%;
        }

        .transport-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }

        .transport-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .transport-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .transport-badge {
            font-size: 1rem;
            padding: 5px 10px;
            border-radius: 5px;
            color: white;
            text-transform: uppercase;
            font-weight: bold;
        }

        .badge-bus {
            background-color: #4CAF50;
        }

        .badge-train {
            background-color: #2196F3;
        }

        .badge-flight {
            background-color: #FF9800;
        }

        .badge-car {
            background-color: #607D8B;
        }

        .transport-price {
            font-size: 1.2rem;
            font-weight: bold;
            color: #FF6B35;
        }

        .transport-details p {
            margin-bottom: 8px;
            color: #555;
        }

        @media (max-width: 768px) {
            .city-info-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <section class="city-hero">
        <div class="container">
            <h1><?php echo htmlspecialchars($city['city_name']); ?></h1>
            <p>Explore the beauty and culture of <?php echo htmlspecialchars($city['city_name']); ?></p>
        </div>
    </section>

    <div class="bg-pattern">
        <section class="city-section">
            <div class="container">
                <div class="city-info-grid">
                    <div class="city-description">
                        <h2>About <?php echo htmlspecialchars($city['city_name']); ?></h2>
                        <p><?php echo htmlspecialchars($city['description']); ?></p>
                        <a href="packages.php?destination=<?php echo urlencode($city['city_name']); ?>" class="btn" style="margin-top: 20px; display: inline-block;">View Packages</a>
                    </div>
                    <div class="info-card">
                        <h3>Travel Information</h3>
                        <p><strong><i class="fas fa-sun"></i> Best Time to Visit:</strong>
                            <?php echo htmlspecialchars($city['best_time_to_visit']); ?></p>
                        <p><strong><i class="fas fa-clock"></i> Ideal Duration:</strong> 3-5 days</p>
                    </div>
                </div>

                <div class="attractions-list-section">
                    <h2>Top Attractions in <?php echo htmlspecialchars($city['city_name']); ?></h2>
                    <div class="attractions-grid">
                        <?php if (mysqli_num_rows($attractions_result) > 0): ?>
                            <?php while ($attraction = mysqli_fetch_assoc($attractions_result)): ?>
                                <div class="attraction-card">
                                    <img src="assets/img/attractions/<?php echo htmlspecialchars($attraction['image_url']); ?>" alt="<?php echo htmlspecialchars($attraction['name']); ?>" class="attraction-image">
                                    <div class="attraction-content">
                                        <h3><?php echo htmlspecialchars($attraction['name']); ?></h3>
                                        <p><?php echo htmlspecialchars(substr($attraction['description'], 0, 100)); ?>...</p>
                                        <div class="attraction-details">
                                            <span>₹<?php echo htmlspecialchars($attraction['entry_fee']); ?></span>
                                            <span><?php echo htmlspecialchars($attraction['opening_hours']); ?></span>
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <p style="text-align: center; width: 100%;">No attractions found for this city.</p>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="transport-options-section">
                    <h2 class="section-title" style="margin-bottom: 30px; text-align: center;">Transport to and from
                        <?php echo htmlspecialchars($city['city_name']); ?>
                    </h2>
                    <div class="transport-grid">
                        <?php if (mysqli_num_rows($transport_result) > 0): ?>
                            <?php while ($transport = mysqli_fetch_assoc($transport_result)):
                                $badge_class = '';
                                if ($transport['transport_type'] == 'bus')
                                    $badge_class = 'badge-bus';
                                if ($transport['transport_type'] == 'train')
                                    $badge_class = 'badge-train';
                                if ($transport['transport_type'] == 'flight')
                                    $badge_class = 'badge-flight';
                                if ($transport['transport_type'] == 'car')
                                    $badge_class = 'badge-car';
                                ?>
                                <div class="transport-card">
                                    <div class="transport-header">
                                        <span class="transport-badge <?php echo $badge_class; ?>"><?php echo ucfirst($transport['transport_type']); ?></span>
                                        <span class="transport-price">₹<?php echo htmlspecialchars($transport['approx_price']); ?></span>
                                    </div>
                                    <div class="transport-details">
                                        <p><strong>From:</strong> <?php echo htmlspecialchars($transport['departure_city_id']); ?>
                                            at <?php echo date('h:i A', strtotime($transport['departure_time'])); ?></p>
                                        <p><strong>To:</strong> <?php echo htmlspecialchars($transport['arrival_city_id']); ?> at
                                            <?php echo date('h:i A', strtotime($transport['arrival_time'])); ?>
                                        </p>
                                        <p class="transport-description">
                                            <?php echo htmlspecialchars($transport['description']); ?>
                                        </p>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <p style="text-align: center; width: 100%;">No transport options found for this city.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <?php include "includes/footer.php"; ?>
</body>

</html>