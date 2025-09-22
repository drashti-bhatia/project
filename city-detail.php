<?php
include('includes/db_connect.php');


if (!isset($_GET['id'])) {
    header("Location: destinations.php");
    exit();
}

$city_id = mysqli_real_escape_string($conn, $_GET['id']);
$sql = "SELECT * FROM cities WHERE city_id = '$city_id'";
$result = mysqli_query($conn, $sql);
$city = mysqli_fetch_assoc($result);

if (!$city) {
    header("Location: destinations.php");
    exit();
}

// Fetch attractions for this city
$attractions_sql = "SELECT * FROM attractions WHERE city_id = '$city_id'";
$attractions_result = mysqli_query($conn, $attractions_sql);

$page_title = $city['city_name'] . " - Gujarat Yatar Portal";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    <style>
        .city-hero {
            background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('assets/img/cities/<?php echo $city['image_url']; ?>');
            background-size: cover;
            background-position: center;
            padding: 100px 0;
            text-align: center;
            color: white;
        }
        
        .city-content {
            padding: 50px 5%;
        }
        
        .city-info {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 40px;
            margin-bottom: 50px;
        }
        
        .attractions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin-top: 30px;
        }
        
        .attraction-card {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .attraction-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        
        .attraction-content {
            padding: 20px;
        }
        
        .best-time-badge {
            background: #FF6B35;
            color: white;
            padding: 10px 20px;
            border-radius: 25px;
            display: inline-block;
            margin-bottom: 20px;
        }
        
        .info-card {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            border-left: 4px solid #3685fb;
        }
    </style>
</head>
<body>
    <?php include "header.php"; ?>
    
    <section class="city-hero">
        <div class="container">
            <h1><?php echo $city['city_name']; ?></h1>
            <p>Explore the beauty and culture of <?php echo $city['city_name']; ?></p>
        </div>
    </section>
    
    <section class="city-content">
        <div class="container">
            <div class="city-info">
                <div>
                    <h2>About <?php echo $city['name']; ?></h2>
                    <p><?php echo $city['description']; ?></p>
                </div>
                <div>
                    <div class="info-card">
                        <h3>Travel Information</h3>
                        <p><strong>Best Time to Visit:</strong> <?php echo $city['best_time_to_visit']; ?></p>
                        <p><strong>Ideal Duration:</strong> 3-5 days</p>
                        <a href="packages.php?city=<?php echo $city['name']; ?>" class="btn">View Packages</a>
                    </div>
                </div>
            </div>
            
            <h2>Top Attractions in <?php echo $city['name']; ?></h2>
            <div class="attractions-grid">
                <?php while ($attraction = mysqli_fetch_assoc($attractions_result)): ?>
                <div class="attraction-card">
                    <img src="assets/img/attractions/<?php echo $attraction['image_url']; ?>" alt="<?php echo $attraction['name']; ?>" class="attraction-image">
                    <div class="attraction-content">
                        <h3><?php echo $attraction['name']; ?></h3>
                        <p><?php echo substr($attraction['description'], 0, 100) . '...'; ?></p>
                        <p><strong>Entry Fee:</strong> ₹<?php echo $attraction['entry_fee']; ?></p>
                        <p><strong>Opening Hours:</strong> <?php echo $attraction['opening_hours']; ?></p>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
    </section>
    
    <?php include "../includes/footer.php"; ?>
</body>
</html>