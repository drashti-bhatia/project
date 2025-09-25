<?php
include('includes/db_connect.php');
include('header.php');

$page_title = "Attractions - Gujarat Yatar Portal";
$city_filter = '';

// Check if a city filter is applied from the URL
if (isset($_GET['city_id'])) {
    $city_filter = intval($_GET['city_id']);
}

// Fetch all cities to populate the filter dropdown
$cities_sql = "SELECT * FROM cities ORDER BY city_name";
$cities_result = mysqli_query($conn, $cities_sql);

// Fetch attractions based on the filter
$attractions_sql = "SELECT a.*, c.city_name FROM attractions a JOIN cities c ON a.city_id = c.city_id";
if ($city_filter) {
    $attractions_sql .= " WHERE a.city_id = " . $city_filter;
}
$attractions_sql .= " ORDER BY a.name ASC";
$attractions_result = mysqli_query($conn, $attractions_sql);
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
        .attractions-hero {
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('assets/img/destinations-bg.jpg');
            background-size: cover;
            background-position: center;
            padding: 100px 0;
            text-align: center;
            color: white;
        }

        .attractions-hero h1 {
            font-size: 3rem;
            margin-bottom: 20px;
        }

        .attractions-section {
            padding: 50px 5%;
            min-height: 80vh;
        }

        .attractions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 30px;
        }

        .attraction-card {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05), 0 10px 20px rgba(0, 0, 0, 0.05);
            width: 100%;
            transition: transform 0.3s ease;
            background-color: #fff;
            border-radius: 15px;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            border: 1px solid #EAEAEA;
        }

        .attraction-card:hover {
            transform: translateY(-5px);
        }

        .attraction-card img {
            width: 100%;
            height: 220px;
            object-fit: cover;
        }

        .attraction-content {
            padding: 25px;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }

        .attraction-card h3 {
            font-size: 1.5rem;
            margin-bottom: 5px;
            color: #333;
            text-align: left;
        }

        .attraction-card .city-name {
            font-size: 1rem;
            color: #666;
            margin-bottom: 15px;
            text-align: left;
        }

        .attraction-card p {
            text-align: left;
            color: #555;
            line-height: 1.6;
            margin-bottom: 10px;
        }

        /* MODIFIED: This rule correctly makes ONLY the description expand */
        .attraction-description {
            flex-grow: 1;
        }

        .attraction-details {
            margin-top: auto;
            /* Pushes details to be right above the meta section */
            padding-top: 10px;
        }

        .attraction-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 15px;
        }

        /* MODIFIED: Styled to match the 'duration' tag from packages.php */
        .entry-fee {
            background: #f9f2eeff;
            color: #983b3bff;
            padding: 8px 15px;
            border-radius: 50px;
            font-size: 0.9rem;
            font-weight: 600;
            white-space: nowrap;
        }

        /* MODIFIED: Styled to match the button from packages.php */
        .attraction-meta .btn {
            padding: 10px 25px;
            margin: 0;
            font-size: 0.95rem;
        }

        .filter-section {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 20px;
            margin-bottom: 40px;
            padding: 20px;
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .filter-section select {
            padding: 10px 15px;
            border-radius: 8px;
            border: 1px solid #ddd;
            font-size: 1rem;
            cursor: pointer;
        }
    </style>
</head>

<body>

    <section class="attractions-hero">
        <div class="container">
            <h1>Explore Gujarat's Best Attractions</h1>
            <p>Discover the rich cultural heritage and hidden gems of Gujarat.</p>
        </div>
    </section>

    <div class="bg-pattern">
        <section class="attractions-section">
            <div class="container">
                <h2 class="section-title" style="margin-bottom: 40px;padding-top: 30px;">Explore Attractions</h2>

                <div class="filter-section">
                    <label for="city-filter">Filter by City:</label>
                    <select id="city-filter" onchange="filterAttractions()">
                        <option value="">All Cities</option>
                        <?php mysqli_data_seek($cities_result, 0); ?>
                        <?php while ($city_row = mysqli_fetch_assoc($cities_result)): ?>
                            <option value="<?php echo $city_row['city_id']; ?>" <?php echo ($city_filter == $city_row['city_id']) ? 'selected' : ''; ?>>
                                <?php echo $city_row['city_name']; ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="attractions-grid">
                    <?php if (mysqli_num_rows($attractions_result) > 0): ?>
                        <?php while ($row = mysqli_fetch_assoc($attractions_result)): ?>
                            <div class="attraction-card">
                                <img src="assets/img/attractions/<?php echo htmlspecialchars($row['image_url']); ?>" alt="<?php echo htmlspecialchars($row['name']); ?>">
                                <div class="attraction-content">
                                    <h3><?php echo htmlspecialchars($row['name']); ?></h3>
                                    <span class="city-name"><?php echo htmlspecialchars($row['city_name']); ?></span>

                                    <p class="attraction-description"><?php echo htmlspecialchars($row['description']); ?></p>

                                    <div class="attraction-details">
                                        <p><strong>Best Time:</strong> <?php echo htmlspecialchars($row['best_time_to_visit']); ?></p>
                                        <p><strong>Hours:</strong> <?php echo htmlspecialchars($row['opening_hours']); ?></p>
                                    </div>
                                    <div class="attraction-meta">
                                        <span class="entry-fee">Entry Fee: ₹<?php echo htmlspecialchars($row['entry_fee']); ?></span>
                                        <a href="city-detail.php?id=<?php echo $row['city_id']; ?>" class="btn">View Details</a>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <p style="text-align: center; width: 100%;">No attractions found.</p>
                    <?php endif; ?>
                </div>
            </div>
        </section>
    </div>

    <script>
        function filterAttractions() {
            const cityId = document.getElementById('city-filter').value;
            window.location.href = 'attractions.php' + (cityId ? '?city_id=' + cityId : '');
        }
    </script>

    <?php include 'includes/footer.php'; ?>
</body>

</html>