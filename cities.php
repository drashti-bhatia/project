<?php
include('includes/db_connect.php');
include('header.php');

$page_title = "Cities - Gujarat Yatra Portal";

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
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('assets/img/cities-bg.jpg');
            background-size: cover;
            background-position: center;
            padding: 100px 0;
            text-align: center;
            color: white;
        }

        .cities-hero h1 {
            font-size: 3rem;
            margin-bottom: 20px;
        }

        .cities-section {
            padding: 50px 5%;
            min-height: 80vh;
        }

        .cities-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }

        .city-card {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05), 0 10px 20px rgba(0, 0, 0, 0.05);
            width: 100%;
            transition: transform 0.3s;
            background-color: #fff;
            border-radius: 15px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            border: 1px solid #EAEAEA;
        }

        .city-card img {
            width: 100%;
            height: 220px;
            /* Adjusted height */
            object-fit: cover;
        }

        .city-content {
            padding: 25px;
            text-align: left;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .city-card h3 {
            font-size: 1.5rem;
            margin-bottom: 10px;
            color: #333;
        }

        .city-card p {
            font-size: 1rem;
            color: #555;
            margin-bottom: 15px;
            line-height: 1.6;
        }

        .city-description {
            flex-grow: 1;
        }

        .city-card .best-time {
            font-weight: 600;
            color: #555;
        }

        .city-content .btn {
            display: inline-block;
            padding: 12px 30px;
            background: var(--orange);
            color: white;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
            border: 2px solid transparent;
            text-align: center;
            margin-top: auto;
            margin-bottom: auto;
        }

        .btn:hover {
            background-color: var(--darkblue);
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

    <div class="bg-pattern">
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
                                    <p class="city-description"><?php echo htmlspecialchars(substr($row['description'], 0, 150)); ?>...</p>
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
    </div>

    <?php include 'includes/footer.php'; ?>
</body>

</html>