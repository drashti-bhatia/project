<?php
include('includes/db_connect.php');

$page_title = "Destinations - Gujarat Yatar Portal";

// Fetch all cities
$sql = "SELECT * FROM cities ORDER BY city_name";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    <style>
        .destinations-hero {
            background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('assets/img/destinations-bg.jpg');
            background-size: cover;
            background-position: center;
            padding: 100px 0;
            text-align: center;
            color: white;
        }
        
        .destinations-hero h1 {
            font-size: 3rem;
            margin-bottom: 20px;
        }
        
        .destinations-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            padding: 50px 5%;
        }
        
        .destination-card {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }
        
        .destination-card:hover {
            transform: translateY(-10px);
        }
        
        .destination-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        
        .destination-content {
            padding: 20px;
        }
        
        .destination-content h3 {
            color: #333;
            margin-bottom: 10px;
        }
        
        .destination-content p {
            color: #666;
            margin-bottom: 15px;
            line-height: 1.6;
        }
        
        .destination-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 15px;
        }
        
        .best-time {
            background: #FF6B35;
            color: white;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.9rem;
        }
        
        .view-btn {
            background: #3685fb;
            color: white;
            padding: 8px 15px;
            border-radius: 5px;
            text-decoration: none;
            transition: background 0.3s;
        }
        
        .view-btn:hover {
            background: #2a6fd8;
        }
        
        .filter-section {
            background: #f8f9fa;
            padding: 30px 5%;
            text-align: center;
        }
        
        .filter-options {
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
        }
        
        .filter-btn {
            background: white;
            border: 2px solid #3685fb;
            color: #3685fb;
            padding: 10px 20px;
            border-radius: 25px;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .filter-btn.active, .filter-btn:hover {
            background: #3685fb;
            color: white;
        }
    </style>
</head>
<body>
    <?php include "header.php"; ?>
    
    <section class="destinations-hero">
        <div class="container">
            <h1>Explore Gujarat's Beautiful Destinations</h1>
            <p>Discover the rich cultural heritage and natural beauty of Gujarat</p>
        </div>
    </section>
    
    <section class="filter-section">
        <div class="container">
            <h2 style="margin-bottom: 20px; color: #333;">Filter Destinations</h2>
            <div class="filter-options">
                <button class="filter-btn active" data-filter="all">All Destinations</button>
                <button class="filter-btn" data-filter="heritage">Heritage Sites</button>
                <button class="filter-btn" data-filter="beach">Beach Destinations</button>
                <button class="filter-btn" data-filter="wildlife">Wildlife Sanctuaries</button>
                <button class="filter-btn" data-filter="religious">Religious Sites</button>
            </div>
        </div>
    </section>
    
    <section class="destinations-grid">
        <?php while ($cities = mysqli_fetch_assoc($result)): ?>
        <div class="destination-card" data-category="heritage">
            <img src="assets/img/cities/<?php echo $city['image_url']; ?>" alt="<?php echo $city['city_name']; ?>" class="destination-image">
            <div class="destination-content">
                <h3><?php echo $city['city_name']; ?></h3>
                <p><?php echo substr($city['description'], 0, 100) . '...'; ?></p>
                <div class="destination-meta">
                    <span class="best-time">Best Time: <?php echo $city['best_time_to_visit']; ?></span>
                    <a href="city-detail.php?id=<?php echo $city['city_id']; ?>" class="view-btn">Explore</a>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
    </section>
    
    <script>
        // Simple filter functionality
        document.querySelectorAll('.filter-btn').forEach(button => {
            button.addEventListener('click', () => {
                document.querySelectorAll('.filter-btn').forEach(btn => btn.classList.remove('active'));
                button.classList.add('active');
                
                const filter = button.getAttribute('data-filter');
                // In a real implementation, you would filter the destinations here
                // This is a simplified version for demonstration
            });
        });
    </script>
    
    <?php include "includes/footer.php"; ?>
</body>
</html>