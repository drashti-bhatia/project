-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 19, 2025 at 12:16 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ai`
--

-- --------------------------------------------------------

--
-- Table structure for table `attractions`
--

CREATE TABLE `attractions` (
  `attraction_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `city_id` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `entry_fee` decimal(10,2) DEFAULT NULL,
  `best_time_to_visit` varchar(255) DEFAULT NULL,
  `opening_hours` varchar(255) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `attractions`
--

INSERT INTO `attractions` (`attraction_id`, `name`, `city_id`, `description`, `entry_fee`, `best_time_to_visit`, `opening_hours`, `image_url`) VALUES
(1, 'Sabarmati Ashram', 1, 'The former residence of Mahatma Gandhi.', 0.00, 'All year', '8:30 AM - 6:30 PM', 'ashram.jpg'),
(2, 'Statue of Unity', 3, 'The world\'s tallest statue, located near Vadodara.', 150.00, 'October to March', '8:00 AM - 6:00 PM', 'sou.jpg'),
(3, 'Kankaria Lake', 1, 'A beautiful lakefront with a zoo, toy train, and various entertainment options.', 25.00, 'Evening', '9:00 AM - 10:00 PM', 'kankaria_lake.jpg'),
(4, 'Adalaj Stepwell', 1, 'An intricate stepwell with beautiful carvings, a masterpiece of Indo-Islamic architecture.', 0.00, 'Morning', '8:00 AM - 6:00 PM', 'adalaj_stepwell.jpg'),
(5, 'Dholavira', 17, 'An archaeological site belonging to the Indus Valley Civilization, one of the five largest Harappan sites.', 0.00, 'Winter', 'Sunrise to Sunset', 'dholavira.jpg'),
(6, 'Laxmi Vilas Palace', 3, 'An extravagant palace, four times the size of Buckingham Palace, and a masterpiece of Indo-Saracenic architecture.', 200.00, 'All year', '9:30 AM - 5:00 PM', 'laxmi_vilas_palace.jpg'),
(7, 'Jubilee Garden', 5, 'A historic public garden in Rajkot with various monuments and museums.', 0.00, 'All year', '6:00 AM - 10:00 PM', 'jubilee_garden.jpg'),
(8, 'Dwarkadhish Temple', 2, 'A magnificent temple dedicated to Lord Krishna, with intricate carvings and a grand spire.', 0.00, 'All year', '6:00 AM - 9:30 PM', 'dwarkadhish_temple.jpg'),
(9, 'Somnath Temple', 18, 'One of the twelve Jyotirlinga shrines of Lord Shiva, a major pilgrimage site.', 0.00, 'All year', '6:00 AM - 9:30 PM', 'somnath_temple.jpg'),
(10, 'Gir National Park', 3, 'A wildlife sanctuary and the only home of the Asiatic lions.', 400.00, 'December to March', '6:00 AM - 12:00 PM, 3:00 PM - 6:00 PM', 'gir_national_park.jpg'),
(11, 'Rani Ki Vav', 6, 'A UNESCO World Heritage site, a magnificent stepwell with intricate sculptures and carvings.', 40.00, 'October to March', '8:30 AM - 6:00 PM', 'rani_ki_vav.jpg'),
(12, 'Vintage Car Collection', 8, 'A private museum showcasing a rare collection of classic cars.', 200.00, 'All year', '9:00 AM - 5:00 PM', 'vintage_cars.jpg'),
(13, 'Lothal', 1, 'An ancient Harappan port city, providing a glimpse into the urban planning of the Indus Valley Civilization.', 0.00, 'Winter', '10:00 AM - 5:00 PM', 'lothal.jpg'),
(14, 'Akshardham Temple', 5, 'A grand temple complex dedicated to Swaminarayan, known for its intricate architecture and spiritual exhibits.', 0.00, 'All year', '9:30 AM - 7:30 PM', 'akshardham_temple.jpg'),
(15, 'Bhujodi Village', 1, 'A village of weavers and artisans, offering a chance to see traditional textile crafts.', 0.00, 'All year', '9:00 AM - 6:00 PM', 'bhujodi_village.jpg'),
(16, 'Marine National Park', 14, 'India\'s first marine national park, home to diverse marine life.', 0.00, 'October to March', '9:00 AM - 5:00 PM', 'marine_national_park.jpg'),
(17, 'Saputara Lake', 20, 'A beautiful artificial lake in the hill station of Saputara, offering boating and scenic views.', 0.00, 'All year', '9:00 AM - 6:00 PM', 'saputara_lake.jpg'),
(18, 'Sun Temple Modhera', 1, 'An 11th-century temple dedicated to the sun god Surya, known for its intricate carvings.', 0.00, 'October to March', 'Sunrise to Sunset', 'sun_temple_modhera.jpg'),
(19, 'Uparkot Fort', 4, 'An ancient fort in Junagadh with a history dating back to the Mauryan dynasty.', 0.00, 'All year', '7:00 AM - 7:00 PM', 'uparkot_fort.jpg'),
(20, 'Lighthouse Beach', 9, 'A beautiful beach with a historic lighthouse, perfect for a relaxing evening.', 0.00, 'All year', '24 Hours', 'lighthouse_beach.jpg'),
(21, 'Vijay Vilas Palace', 7, 'A beautiful palace on the beach, used as a film set for many Bollywood movies.', 0.00, 'All year', '9:00 AM - 1:00 PM, 3:00 PM - 6:00 PM', 'vijay_vilas_palace.jpg'),
(22, 'Champaner Fort', 20, 'Part of the UNESCO World Heritage site, this fort showcases a blend of Hindu and Islamic architecture.', 0.00, 'October to March', '8:30 AM - 5:30 PM', 'champaner_fort.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `booking_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `package_id` int(11) DEFAULT NULL,
  `booking_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `travel_date` date NOT NULL,
  `number_of_travelers` int(11) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `payment_status` enum('pending','paid','cancelled') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`booking_id`, `user_id`, `package_id`, `booking_date`, `travel_date`, `number_of_travelers`, `total_amount`, `payment_status`) VALUES
(23, 5, 1, '2025-09-15 12:02:27', '2025-10-20', 2, 11000.00, 'paid'),
(24, 7, 2, '2025-09-15 12:02:27', '2025-11-05', 3, 12000.00, 'paid'),
(25, 5, 1, '2025-09-15 12:02:27', '2025-11-15', 1, 5500.00, 'pending'),
(26, 7, 2, '2025-09-15 12:02:27', '2025-12-01', 4, 16000.00, 'paid'),
(27, 5, 1, '2025-09-15 12:02:27', '2026-01-10', 2, 11000.00, 'paid'),
(28, 7, 2, '2025-09-15 12:02:27', '2026-02-20', 3, 12000.00, 'pending'),
(29, 5, 1, '2025-09-15 12:02:27', '2026-03-05', 1, 5500.00, 'paid'),
(30, 7, 2, '2025-09-15 12:02:27', '2026-04-12', 4, 16000.00, 'paid'),
(31, 5, 1, '2025-09-15 12:02:27', '2026-05-25', 2, 11000.00, 'pending'),
(32, 7, 2, '2025-09-15 12:02:27', '2026-06-30', 3, 12000.00, 'paid'),
(33, 5, 1, '2025-09-15 12:02:27', '2026-07-15', 1, 5500.00, 'paid'),
(34, 7, 2, '2025-09-15 12:02:27', '2026-08-22', 4, 16000.00, 'pending'),
(35, 5, 1, '2025-09-15 12:02:27', '2026-09-01', 2, 11000.00, 'paid'),
(36, 7, 2, '2025-09-15 12:02:27', '2026-10-05', 3, 12000.00, 'paid'),
(37, 5, 1, '2025-09-15 12:02:27', '2026-11-11', 1, 5500.00, 'paid'),
(38, 7, 2, '2025-09-15 12:02:27', '2026-12-18', 4, 16000.00, 'pending'),
(39, 5, 1, '2025-09-15 12:02:27', '2027-01-25', 2, 11000.00, 'paid'),
(40, 7, 2, '2025-09-15 12:02:27', '2027-02-28', 3, 12000.00, 'paid'),
(41, 5, 1, '2025-09-15 12:02:27', '2027-03-15', 1, 5500.00, 'pending'),
(42, 7, 2, '2025-09-15 12:02:27', '2027-04-20', 4, 16000.00, 'paid');

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `city_id` int(11) NOT NULL,
  `city_name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `best_time_to_visit` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`city_id`, `city_name`, `description`, `image_url`, `best_time_to_visit`) VALUES
(1, 'Ahmedabad', 'A bustling metropolitan city and a former capital of Gujarat.', 'ahmedabad.jpg', 'October to March'),
(2, 'Surat', 'Known as the Diamond City of India, famous for its textile industry.', 'surat.jpg', 'November to February'),
(3, 'Vadodara', 'A cultural hub with palaces and gardens, also known as Sanskari Nagari.', 'vadodara.jpg', 'October to March'),
(4, 'Bhuj', 'The historic city of Bhuj is the heart of the Kutch district, known for its traditional crafts and ancient temples.', 'bhuj.jpg', 'October to March'),
(5, 'Dwarka', 'An ancient pilgrimage site and one of the four sacred Char Dham sites, Dwarka is believed to be the kingdom of Lord Krishna.', 'dwarka.jpg', 'October to March'),
(6, 'Sasan Gir', 'Home to the majestic Asiatic lions, Sasan Gir National Park offers thrilling wildlife safaris.', 'sasan_gir.jpg', 'December to March'),
(7, 'Junagadh', 'Rich in history and architecture, Junagadh is known for its historic forts, caves, and the Girnar mountain.', 'junagadh.jpg', 'November to February'),
(8, 'Gandhinagar', 'The capital city of Gujarat, known for its green spaces, modern infrastructure, and the Akshardham Temple.', 'gandhinagar.jpg', 'October to March'),
(9, 'Patan', 'Famous for the Rani ki Vav, a UNESCO World Heritage site, and Patola sarees, Patan is a city of historical significance.', 'patan.jpg', 'October to March'),
(10, 'Mandvi', 'A coastal town with a beautiful beach, a historical fort, and a centuries-old shipbuilding yard.', 'mandvi.jpg', 'October to March'),
(11, 'Kevadia', 'The home of the Statue of Unity, Kevadia is a modern tourism destination with various attractions.', 'kevadia.jpg', 'October to March'),
(12, 'Diu', 'A serene coastal town with a rich colonial history, beautiful beaches, and stunning forts.', 'diu.jpg', 'October to May'),
(13, 'Rajkot', 'A major commercial and industrial hub of Saurashtra, with a rich history related to Mahatma Gandhi.', 'rajkot.jpg', 'October to March'),
(14, 'Porbandar', 'The birthplace of Mahatma Gandhi, Porbandar is a coastal city with historical and religious sites.', 'porbandar.jpg', 'October to March'),
(15, 'Gondal', 'Known for its royal palaces, vintage cars, and rich history, Gondal offers a glimpse into the princely state of Gujarat.', 'gondal.jpg', 'October to March'),
(16, 'Anand', 'The Milk Capital of India, famous for its Amul dairy cooperative movement.', 'anand.jpg', 'November to February'),
(17, 'Jamnagar', 'Known as the Pearl City of Gujarat, with beautiful lakes, temples, and the Marine National Park.', 'jamnagar.jpg', 'October to March'),
(18, 'Bhavnagar', 'A coastal city with a rich cultural heritage, known for its lakes, temples, and natural attractions.', 'bhavnagar.jpg', 'October to March'),
(19, 'Morbi', 'Known as the Ceramic City of India, Morbi is a major industrial hub with a rich history and beautiful palaces.', 'morbi.jpg', 'October to March'),
(20, 'Rann of Kutch', 'A surreal landscape of white salt desert, especially famous for the Rann Utsav festival.', 'rann_of_kutch.jpg', 'November to February'),
(21, 'Somnath', 'Home to the Somnath Temple, one of the twelve Jyotirlinga shrines of Lord Shiva.', 'somnath.jpg', 'October to March'),
(22, 'Poshina', 'A tribal village known for its traditional crafts and spiritual heritage.', 'poshina.jpg', 'October to March'),
(23, 'Champaner-Pavagadh', 'A UNESCO World Heritage Site with historical and archaeological ruins.', 'champaner_pavagadh.jpg', 'October to March');

-- --------------------------------------------------------

--
-- Table structure for table `packages`
--

CREATE TABLE `packages` (
  `package_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `duration_days` int(11) DEFAULT NULL,
  `inclusions` text DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `packages`
--

INSERT INTO `packages` (`package_id`, `name`, `description`, `price`, `duration_days`, `inclusions`, `city_id`, `image_url`) VALUES
(1, 'Ahmedabad Heritage Tour', 'Explore the rich history and heritage of Ahmedabad.', 5500.00, 3, 'Accommodation, Breakfast, Guided tour of heritage sites.', 1, 'heritage_package.jpg'),
(2, 'Vadodara Cultural Gateway', 'A 2-day trip to explore the cultural capital of Gujarat.', 4000.00, 2, 'Travel, Accommodation, Entry tickets to monuments.', 3, 'cultural_package.jpg'),
(3, 'Kutch Rann Utsav Special', 'A special package to experience the mesmerizing Rann Utsav festival in the white desert.', 12000.00, 4, 'Tent stay, all meals, cultural programs, desert safari.', 17, 'kutch_rann_utsav.jpg'),
(4, 'Gir Wildlife Safari', 'Experience the thrill of a lifetime with a safari to spot the Asiatic lion.', 8500.00, 3, 'Accommodation, jungle safari, all meals.', 3, 'gir_safari.jpg'),
(5, 'Dwarka & Somnath Pilgrimage', 'A sacred tour to the divine temples of Dwarka and Somnath.', 7000.00, 4, 'Accommodation, temple visits, travel.', 2, 'dwarka_somnath.jpg'),
(6, 'Heritage Ahmedabad & Patan', 'Discover the architectural marvels of Ahmedabad and Patan.', 6000.00, 3, 'Accommodation, breakfast, guided tour of monuments.', 1, 'heritage_package_2.jpg'),
(7, 'Coastal Gujarat Tour', 'Explore the beautiful beaches and coastal towns of Gujarat.', 9500.00, 5, 'Accommodation, travel, water sports activities.', 9, 'coastal_tour.jpg'),
(8, 'Gondal Royal Retreat', 'A royal experience in Gondal with stays in heritage palaces and a vintage car tour.', 15000.00, 2, 'Palace stay, all meals, vintage car tour.', 8, 'gondal_royal.jpg'),
(9, 'Ahmedabad Foodie Trail', 'A culinary journey through the streets of Ahmedabad, tasting local delicacies.', 3000.00, 1, 'Guided food tour, tasting sessions.', 1, 'foodie_trail.jpg'),
(10, 'Statue of Unity & Kevadia', 'A family trip to the Statue of Unity and surrounding attractions.', 5000.00, 2, 'Accommodation, transport, entry tickets.', 3, 'sou_package.jpg'),
(11, 'Diu Beach Getaway', 'A relaxing trip to the beautiful beaches of Diu with a taste of its colonial past.', 6500.00, 3, 'Accommodation, beach activities, sightseeing.', 9, 'diu_getaway.jpg'),
(12, 'Jamnagar Pearl Tour', 'Explore the scenic lakes and marine life of Jamnagar.', 7500.00, 3, 'Accommodation, local transport, park entry tickets.', 14, 'jamnagar_tour.jpg'),
(13, 'Surat Textile Tour', 'A short trip to explore the textile industry and diamond markets of Surat.', 2500.00, 2, 'Accommodation, guided market tour.', 2, 'surat_tour.jpg'),
(14, 'Champaner-Pavagadh Exploration', 'Discover the historical and archaeological wonders of this UNESCO site.', 4500.00, 2, 'Accommodation, guided tour, transport.', 20, 'champaner_tour.jpg'),
(15, 'Poshina Tribal Experience', 'A unique cultural tour to the tribal villages of Gujarat.', 9000.00, 3, 'Accommodation, cultural immersion, local transport.', 19, 'poshina_tour.jpg'),
(16, 'Wild Saurashtra', 'An adventure-filled trip to Junagadh, Gir and surrounding wildlife areas.', 11000.00, 4, 'Accommodation, safaris, guided trekking.', 4, 'wild_saurashtra.jpg'),
(17, 'Gandhinagar City Tour', 'Explore the capital city of Gujarat, known for its green spaces and modern architecture.', 3500.00, 2, 'Accommodation, local transport, entry tickets.', 5, 'gandhinagar_tour.jpg'),
(18, 'Amul Co-operative Tour', 'A short tour of the dairy industry in Anand and surrounding areas.', 2000.00, 1, 'Guided factory tour, tasting sessions.', 13, 'amul_tour.jpg'),
(19, 'Spiritual Gujarat', 'A pilgrimage tour covering the major religious sites of Gujarat.', 10000.00, 5, 'Accommodation, transport, temple visits.', 18, 'spiritual_tour.jpg'),
(20, 'Bhuj & Kutch Crafts Tour', 'A journey to the craft villages of Kutch to experience traditional art and culture.', 8000.00, 4, 'Accommodation, local transport, workshop visits.', 1, 'bhuj_crafts.jpg'),
(21, 'Sasan Gir & Diu Getaway', 'A combination of thrilling wildlife and relaxing beach experience.', 13500.00, 5, 'Accommodation, jungle safari, beach activities.', 3, 'gir_diu.jpg'),
(22, 'Lothal & Dholavira History Tour', 'An archaeological expedition to the ancient sites of the Indus Valley Civilization.', 9000.00, 4, 'Accommodation, transport, guided tour of sites.', 1, 'lothal_dholavira.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `review_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `package_id` int(11) DEFAULT NULL,
  `attraction_id` int(11) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL CHECK (`rating` >= 1 and `rating` <= 5),
  `comment` text DEFAULT NULL,
  `date_posted` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('pending','approved','rejected') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`review_id`, `user_id`, `package_id`, `attraction_id`, `rating`, `comment`, `date_posted`, `status`) VALUES
(25, 5, 2, NULL, 5, 'The tour was fantastic! Our guide was very knowledgeable and friendly.', '2025-09-15 12:02:06', 'approved'),
(26, 7, 1, NULL, 4, 'Great package, but the accommodation could have been better.', '2025-09-15 12:02:06', 'approved'),
(27, 5, NULL, 2, 5, 'The Statue of Unity is a must-see! It is absolutely breathtaking.', '2025-09-15 12:02:06', 'approved'),
(28, 7, NULL, 1, 4, 'Sabarmati Ashram is a very peaceful and serene place. A great experience.', '2025-09-15 12:02:06', 'approved'),
(29, 5, 1, NULL, 3, 'The trip was good overall, but the itinerary was a bit rushed.', '2025-09-15 12:02:06', 'pending'),
(30, 7, 2, NULL, 5, 'Highly recommend this package. The city tour was very well-organized.', '2025-09-15 12:02:06', 'approved'),
(31, 5, NULL, 1, 5, 'A truly spiritual experience. The historical significance is immense.', '2025-09-15 12:02:06', 'approved'),
(32, 7, NULL, 2, 4, 'A very impressive statue, though the heat was a bit much during the day.', '2025-09-15 12:02:06', 'approved'),
(33, 5, 1, NULL, 5, 'This heritage tour exceeded my expectations. A perfect blend of history and culture.', '2025-09-15 12:02:06', 'approved'),
(34, 7, 2, NULL, 4, 'A pleasant trip, the cultural events were a highlight.', '2025-09-15 12:02:06', 'approved'),
(35, 5, NULL, 1, 4, 'Informative and inspiring visit. I learned so much about Gandhi.', '2025-09-15 12:02:06', 'approved'),
(36, 7, NULL, 2, 5, 'An architectural marvel. It is even more grand in person.', '2025-09-15 12:02:06', 'approved'),
(37, 5, 1, NULL, 4, 'Enjoyed every moment of this tour. The food was delicious.', '2025-09-15 12:02:06', 'approved'),
(38, 7, 2, NULL, 3, 'The transport was delayed, but the rest of the tour was good.', '2025-09-15 12:02:06', 'rejected'),
(39, 5, NULL, 2, 5, 'Incredible views and a beautiful monument. Loved it!', '2025-09-15 12:02:06', 'approved'),
(40, 7, NULL, 1, 5, 'A quiet and reflective place. A must-visit for everyone.', '2025-09-15 12:02:06', 'approved'),
(41, 5, 1, NULL, 5, 'Everything was perfect. The guide, the hotels, the schedule.', '2025-09-15 12:02:06', 'approved'),
(42, 7, 2, NULL, 5, 'Excellent value for money. Loved the entire experience.', '2025-09-15 12:02:06', 'approved'),
(43, 5, NULL, 1, 5, 'Highly recommend this place for a peaceful time.', '2025-09-15 12:02:06', 'approved'),
(44, 7, NULL, 2, 4, 'Good experience, but the crowd management could be better.', '2025-09-15 12:02:06', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `transport_options`
--

CREATE TABLE `transport_options` (
  `transport_id` int(11) NOT NULL,
  `transport_type` enum('bus','train','flight','car') NOT NULL,
  `departure_city` varchar(255) NOT NULL,
  `arrival_city` varchar(255) NOT NULL,
  `departure_time` time NOT NULL,
  `arrival_time` time DEFAULT NULL,
  `approx_price` decimal(10,2) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `transport_options`
--

INSERT INTO `transport_options` (`transport_id`, `transport_type`, `departure_city`, `arrival_city`, `departure_time`, `arrival_time`, `approx_price`, `description`) VALUES
(1, 'bus', 'Ahmedabad', 'Vadodara', '08:00:00', '10:30:00', 350.00, 'AC bus service with Wi-Fi.'),
(2, 'train', 'Surat', 'Mumbai', '06:30:00', '12:00:00', 800.00, 'Express train with sleeper class options.'),
(3, 'flight', 'Ahmedabad', 'Delhi', '14:00:00', '15:30:00', 4500.00, 'Direct flight operated by a major airline.'),
(4, 'bus', 'Ahmedabad', 'Bhuj', '07:00:00', '16:00:00', 600.00, 'Sleeper bus service with comfortable seats.'),
(5, 'train', 'Ahmedabad', 'Dwarka', '22:00:00', '08:00:00', 950.00, 'Overnight train journey with sleeper class.'),
(6, 'flight', 'Mumbai', 'Ahmedabad', '11:00:00', '12:15:00', 3800.00, 'Frequent flights connecting major cities.'),
(7, 'car', 'Vadodara', 'Kevadia', '09:00:00', '11:30:00', 2500.00, 'Private car service for a comfortable ride.'),
(8, 'bus', 'Ahmedabad', 'Surat', '13:30:00', '18:30:00', 450.00, 'Semi-sleeper AC bus service.'),
(9, 'train', 'Surat', 'Vadodara', '08:45:00', '10:30:00', 250.00, 'Daily local train service.'),
(10, 'flight', 'Delhi', 'Surat', '09:30:00', '11:00:00', 5000.00, 'Early morning flight for business travelers.'),
(11, 'car', 'Rajkot', 'Gondal', '10:00:00', '11:00:00', 800.00, 'Quick and easy taxi service.'),
(12, 'bus', 'Bhuj', 'Mandvi', '12:00:00', '13:30:00', 150.00, 'Local bus service.'),
(13, 'train', 'Ahmedabad', 'Patan', '07:30:00', '09:00:00', 180.00, 'Short train ride.'),
(14, 'bus', 'Junagadh', 'Sasan Gir', '10:00:00', '11:30:00', 120.00, 'Convenient local bus route.'),
(15, 'car', 'Ahmedabad', 'Gandhinagar', '17:00:00', '17:45:00', 600.00, 'Shared taxi service.'),
(16, 'flight', 'Delhi', 'Rajkot', '16:00:00', '17:45:00', 5500.00, 'Afternoon flight options.'),
(17, 'train', 'Vadodara', 'Mumbai', '01:00:00', '08:00:00', 1200.00, 'Overnight express train.'),
(18, 'bus', 'Surat', 'Diu', '21:00:00', '07:00:00', 850.00, 'Overnight AC bus to the coast.'),
(19, 'car', 'Ahmedabad', 'Anand', '08:30:00', '09:45:00', 1500.00, 'One-way cab service.'),
(20, 'train', 'Ahmedabad', 'Jamnagar', '19:00:00', '02:00:00', 700.00, 'Evening train to Jamnagar.'),
(21, 'bus', 'Bhavnagar', 'Palitana', '10:00:00', '11:30:00', 100.00, 'Local bus for pilgrims.'),
(22, 'car', 'Rajkot', 'Porbandar', '14:00:00', '16:00:00', 1800.00, 'Private car service.'),
(23, 'flight', 'Mumbai', 'Vadodara', '20:00:00', '21:00:00', 3200.00, 'Late evening flight.');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_admin` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password`, `created_at`, `is_admin`) VALUES
(5, 'a', 'a@gmail.com', '$2y$10$/ZSv7/N8VkliFgK1NqVWzeQSibY2DvqUyvvwg/uux843ARNybJlQ2', '2025-09-14 11:45:39', 0),
(7, 'admin', 'admin@example.com', '$2y$10$S09sAGrle2tNmEM4U1p03O9c1ygqdVjBSex59alcpn39jpGj0Tbvi', '2025-09-15 04:12:25', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attractions`
--
ALTER TABLE `attractions`
  ADD PRIMARY KEY (`attraction_id`),
  ADD KEY `city_id` (`city_id`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `package_id` (`package_id`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`city_id`);

--
-- Indexes for table `packages`
--
ALTER TABLE `packages`
  ADD PRIMARY KEY (`package_id`),
  ADD KEY `city_id` (`city_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `package_id` (`package_id`),
  ADD KEY `attraction_id` (`attraction_id`);

--
-- Indexes for table `transport_options`
--
ALTER TABLE `transport_options`
  ADD PRIMARY KEY (`transport_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attractions`
--
ALTER TABLE `attractions`
  MODIFY `attraction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `city_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `packages`
--
ALTER TABLE `packages`
  MODIFY `package_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `transport_options`
--
ALTER TABLE `transport_options`
  MODIFY `transport_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attractions`
--
ALTER TABLE `attractions`
  ADD CONSTRAINT `attractions_ibfk_1` FOREIGN KEY (`city_id`) REFERENCES `cities` (`city_id`) ON DELETE CASCADE;

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`package_id`) REFERENCES `packages` (`package_id`) ON DELETE CASCADE;

--
-- Constraints for table `packages`
--
ALTER TABLE `packages`
  ADD CONSTRAINT `packages_ibfk_1` FOREIGN KEY (`city_id`) REFERENCES `cities` (`city_id`) ON DELETE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`package_id`) REFERENCES `packages` (`package_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `reviews_ibfk_3` FOREIGN KEY (`attraction_id`) REFERENCES `attractions` (`attraction_id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
