<?php
session_start();
include 'includes/db_connect.php';

$page_title = "Tour Packages - Gujarat Yatar Portal";

// --- Start of corrected filter logic ---

$sql = "SELECT p.*, c.city_name FROM packages p JOIN cities c ON p.city_id = c.city_id WHERE 1=1";
$params = [];
$types = '';

// Handle city/destination filter
if (isset($_GET['destination']) && !empty($_GET['destination'])) {
    $destination = mysqli_real_escape_string($conn, $_GET['destination']);
    $sql .= " AND c.city_name = ?";
    $params[] = $destination;
    $types .= 's';
}

// Handle duration filter
if (isset($_GET['duration']) && !empty($_GET['duration'])) {
    $duration_key = intval($_GET['duration']);
    switch ($duration_key) {
        case 1:
            $sql .= " AND p.duration_days BETWEEN 1 AND 3";
            break;
        case 2:
            $sql .= " AND p.duration_days BETWEEN 1 AND 5";
            break;
        case 3:
            $sql .= " AND p.duration_days BETWEEN 1 AND 8";
            break;
    }
}

// Handle price filter
if (isset($_GET['price']) && !empty($_GET['price'])) {
    $price_limit = intval($_GET['price']);
    $sql .= " AND p.price <= ?";
    $params[] = $price_limit;
    $types .= 'i';
}

// Order the results
$sql .= " ORDER BY p.price ASC";

// Use prepared statements for security
$stmt = mysqli_prepare($conn, $sql);
if ($stmt) {
    if (!empty($params)) {
        mysqli_stmt_bind_param($stmt, $types, ...$params);
    }
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
} else {
    // Fallback to a non-filtered query or show an error
    $result = mysqli_query($conn, "SELECT p.*, c.city_name FROM packages p JOIN cities c ON p.city_id = c.city_id ORDER BY p.price ASC");
}

// Fetch all cities for the destination dropdown
$cities_sql = "SELECT city_name FROM cities ORDER BY city_name";
$cities_result = mysqli_query($conn, $cities_sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .packages-hero {
            background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('../assets/images/packages-bg.jpg');
            background-size: cover;
            background-position: center;
            padding: 100px 0;
            text-align: center;
            color: white;
            margin-top: 105px;
        }
        
        .packages-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 30px;
            padding: 50px 5%;
        }
        
        .package-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }
        
        .package-card:hover {
            transform: translateY(-10px);
        }
        
        .package-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        
        .package-content {
            padding: 25px;
        }
        
        .package-price {
            font-size: 1.5rem;
            color: #FF6B35;
            font-weight: bold;
            margin: 10px 0;
        }
        
        .package-features {
            margin: 15px 0;
        }
        
        .package-features li {
            margin-bottom: 8px;
            color: #666;
        }
        
        .package-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
        }
        
        .duration {
            background: #3685fb;
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.9rem;
        }
        
        .filter-section {
            background: #f8f9fa;
            padding: 40px 5%;
        }
        
        .filter-form {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            max-width: 1000px;
            margin: 0 auto;
        }
        
        .filter-form select, .filter-form input {
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            width: 100%;
        }
        
        .filter-form button {
            background: #FF6B35;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <?php include "header.php"; ?>
    
    <section class="packages-hero">
        <div class="container">
            <h1>Amazing Tour Packages</h1>
            <p>Discover Gujarat with our carefully curated travel experiences</p>
        </div>
    </section>
    
    <section class="filter-section">
        <div class="container">
            <h2 style="text-align: center; margin-bottom: 30px; color: #333; font-size: 35px;">Find Your Perfect Trip</h2>
            <form class="filter-form" method="GET" action="packages.php">
                <select name="destination">
                    <option value="">All Destinations</option>
                    <?php 
                    mysqli_data_seek($cities_result, 0);
                    while ($city_row = mysqli_fetch_assoc($cities_result)): ?>
                        <option value="<?php echo htmlspecialchars($city_row['city_name']); ?>" <?php echo (isset($_GET['destination']) && $_GET['destination'] == $city_row['city_name']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($city_row['city_name']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
                <select name="duration">
                    <option value="">Any Duration</option>
                    <option value="1" <?php echo (isset($_GET['duration']) && $_GET['duration'] == 1) ? 'selected' : ''; ?>>1-3 Days</option>
                    <option value="2" <?php echo (isset($_GET['duration']) && $_GET['duration'] == 2) ? 'selected' : ''; ?>>4-5 Days</option>
                </select>
                <select name="price">
                    <option value="">Any Price</option>
                    <option value="5000" <?php echo (isset($_GET['price']) && $_GET['price'] == 5000) ? 'selected' : ''; ?>>Under ₹5000</option>
                    <option value="10000" <?php echo (isset($_GET['price']) && $_GET['price'] == 10000) ? 'selected' : ''; ?>>Under ₹10000</option>
                    <option value="15000" <?php echo (isset($_GET['price']) && $_GET['price'] == 15000) ? 'selected' : ''; ?>>Under ₹15000</option>
                </select>
                <button type="submit">Search Packages</button>
            </form>
        </div>
    </section>
    
    <section class="packages-grid">
        <?php if ($result && mysqli_num_rows($result) > 0): ?>
            <?php while ($package = mysqli_fetch_assoc($result)): ?>
            <div class="package-card">
                <img src="assets/img/packages/<?php echo htmlspecialchars($package['image_url']); ?>" alt="<?php echo htmlspecialchars($package['name']); ?>" class="package-image">
                <div class="package-content">
                    <h3><?php echo $package['name']; ?></h3>
                    <div class="package-price">₹<?php echo number_format($package['price']); ?> per person</div>
                    <p><?php echo substr($package['description'], 0, 100) . '...'; ?></p>
                    
                    <h4>Inclusions:</h4>
                    <ul class="package-features">
                        <?php 
                        $inclusions_list = explode(',', $package['inclusions']);
                        foreach ($inclusions_list as $item): ?>
                            <li>✅ <?php echo trim($item); ?></li>
                        <?php endforeach; ?>
                    </ul>
                    
                    <div class="package-meta">
                        <span class="duration"><?php echo $package['duration_days']; ?> Days</span>
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <a href="book.php?package_id=<?php echo $package['package_id']; ?>" class="btn">Book Now</a>
                        <?php else: ?>
                            <a href="login.php" class="btn">Login to Book</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p style="text-align: center; width: 100%;">No packages found matching your criteria.</p>
        <?php endif; ?>
    </section>
    
    <?php include "includes/footer.php"; ?>
</body>
</html>