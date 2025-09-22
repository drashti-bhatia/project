<?php
include '../includes/db_connect.php';

$page_title = "Tour Packages - Gujarat Yatar Portal";

// Filter by city if specified 
$filter = "";
if (isset($_GET['city'])) {
    $city = mysqli_real_escape_string($conn, $_GET['city']);
    $filter = " WHERE name LIKE '%$city%' OR description LIKE '%$city%'";
}

$sql = "SELECT * FROM packages $filter ORDER BY price";
$result = mysqli_query($conn, $sql);
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
            background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('assets/img/packages-bg.jpg');
            background-size: cover;
            background-position: center;
            padding: 100px 0;
            text-align: center;
            color: white;
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
    <?php include "../header.php"; ?>
    
    <section class="packages-hero">
        <div class="container">
            <h1>Amazing Tour Packages</h1>
            <p>Discover Gujarat with our carefully curated travel experiences</p>
        </div>
    </section>
    
    <section class="filter-section">
        <div class="container">
            <h2 style="text-align: center; margin-bottom: 30px; color: #333;">Find Your Perfect Trip</h2>
            <form class="filter-form" method="GET" action="packages.php">
                <select name="destination">
                    <option value="">All Destinations</option>
                    <option value="Ahmedabad">Ahmedabad</option>
                    <option value="Vadodara">Vadodara</option>
                    <option value="Surat">Surat</option>
                    <option value="Rajkot">Rajkot</option>
                </select>
                <select name="duration">
                    <option value="">Any Duration</option>
                    <option value="1">1-3 Days</option>
                    <option value="2">4-7 Days</option>
                    <option value="3">8+ Days</option>
                </select>
                <select name="price">
                    <option value="">Any Price</option>
                    <option value="1000">Under ₹1000</option>
                    <option value="5000">Under ₹5000</option>
                    <option value="10000">Under ₹10000</option>
                </select>
                <button type="submit">Search Packages</button>
            </form>
        </div>
    </section>
    
    <section class="packages-grid">
        <?php while ($package = mysqli_fetch_assoc($result)): ?>
        <div class="package-card">
            <img src="assets/img/packages/package-<?php echo $package['package_id']; ?>.jpg" alt="<?php echo $package['name']; ?>" class="package-image">
            <div class="package-content">
                <h3><?php echo $package['name']; ?></h3>
                <div class="package-price">₹<?php echo number_format($package['price']); ?> per person</div>
                <p><?php echo substr($package['description'], 0, 100) . '...'; ?></p>
                
                <ul class="package-features">
                    <li>✅ <?php echo $package['duration_days']; ?> Days Tour</li>
                    <li>✅ Guided Experience</li>
                    <li>✅ Accommodation Included</li>
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
    </section>
    
    <?php include "../includes/footer.php"; ?>
</body>
</html>