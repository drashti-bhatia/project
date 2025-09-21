<?php
session_start();
include('includes/db_connect.php');
include('header.php');

$page_title = "Cities - Gujarat Yatar Portal";

// Fetch all cities from the database
$cities_sql = "SELECT * FROM cities ORDER BY city_name ASC";
$cities_result = mysqli_query($conn, $cities_sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .cities-hero {
            background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('assets/img/cities-bg.jpg');
            background-size: cover;
            background-position: center;
            padding: 100px 0;
            text-align: center;
            color: white;
            margin-top: 105px; 
        }
        
        .cities-hero h1 {
            font-size: 3rem;
            margin-bottom: 20px;
        }

        .cities-section {
            padding: 50px 5%;
            background-color: #f1f5f8;
            min-height: 80vh;
        }

        .cities-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }

        .city-card {
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            transition: transform 0.3s;
            background-color: #fff;
            border-radius: 15px;
            overflow: hidden;
        }
        
        .city-card img {
            width: 100%;
            height: 250px;
            object-fit: cover;
        }
        
        .city-content {
            padding: 20px;
            text-align: center;
        }
        
        .city-card h3 {
            font-size: 1.8rem;
            margin-bottom: 10px;
            color: #1f8585ff;
        }

        .city-card p {
            font-size: 1rem;
            color: #555;
            margin-bottom: 15px;
        }

        .city-card .best-time {
            font-weight: bold;
            color: #FF6B35;
        }
        
        .btn {
            display: inline-block;
            padding: 12px 30px;
            background: #3685fb;
            color: white;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
            border: 2px solid transparent;
        }
        .btn:hover {
            background-color: #FF6B35;
            transform: translateY(-3px);
            color: white;
        }
    </style>
</head>
<body>

<section class="cities-hero">
    <div class="container">
        <h1>Gujarat's Incredible Cities</h1>
        <p>Explore the diverse culture and history of Gujarat, one city at a time.</p>
    </div>
</section>

<section class="cities-section">
    <div class="container">
        <h2 class="section-title" style="margin-bottom: 40px;">Our Destinations</h2>
        
        <div class="cities-grid">
            <?php if (mysqli_num_rows($cities_result) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($cities_result)): ?>
                    <div class="city-card">
                        <img src="assets/img/cities/<?php echo htmlspecialchars($row['image_url']); ?>" alt="<?php echo htmlspecialchars($row['city_name']); ?>">
                        <div class="city-content">
                            <h3><?php echo htmlspecialchars($row['city_name']); ?></h3>
                            <p>Best time to visit: <span class="best-time"><?php echo htmlspecialchars($row['best_time_to_visit']); ?></span></p>
                            <p><?php echo htmlspecialchars(substr($row['description'], 0, 150)); ?>...</p>
                            <a href="city-detail.php?id=<?php echo $row['city_id']; ?>" class="btn">View City</a>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p style="text-align: center; width: 100%;">No cities found.</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
</body>
</html>