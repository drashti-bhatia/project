-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 24, 2025 at 02:56 PM
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
-- Database: `traveldb`
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
(0, 'Somnath Temple', 21, 'One of the twelve Jyotirlinga shrines of Lord Shiva, a major pilgrimage site.', 0.00, 'All year', '6:00 AM - 9:30 PM', 'somnath_temple.webp'),
(1, 'Kankaria Lake', 1, 'A beautiful lakefront with a zoo, toy train, and various entertainment options.', 25.00, 'Evening', '9:00 AM - 10:00 PM', 'kankaria_lake.webp'),
(2, 'Adalaj Stepwell', 1, 'An intricate stepwell with beautiful carvings, a masterpiece of Indo-Islamic architecture.', 25.00, 'Morning', '8:00 AM - 6:00 PM', 'adalaj_stepwell.webp'),
(3, 'Dholavira', 20, 'An archaeological site belonging to the Indus Valley Civilization, one of the five largest Harappan sites.', 5.00, 'Winter', 'Sunrise to Sunset', 'dholavira.webp'),
(4, 'Laxmi Vilas Palace', 3, 'An extravagant palace, four times the size of Buckingham Palace, and a masterpiece of Indo-Saracenic architecture.', 250.00, 'All year', '9:30 AM - 5:00 PM', 'laxmi_vilas_palace.webp'),
(5, 'Jubilee Garden', 13, 'A historic public garden in Rajkot with various monuments and museums.', 0.00, 'All year', '6:00 AM - 10:00 PM', 'jubilee_garden.webp'),
(6, 'Dwarkadhish Temple', 5, 'A magnificent temple dedicated to Lord Krishna, with intricate carvings and a grand spire.', 0.00, 'All year', '6:00 AM - 9:30 PM', 'dwarkadhish_temple.webp'),
(8, 'Gir National Park', 6, 'A wildlife sanctuary and the only home of the Asiatic lions.', 4300.00, 'December to March', '6:00 AM - 12:00 PM, 3:00 PM - 6:00 PM', 'gir_national_park.webp'),
(9, 'Rani Ki Vav', 9, 'A UNESCO World Heritage site, a magnificent stepwell with intricate sculptures and carvings.', 35.00, 'October to March', '8:30 AM - 6:00 PM', 'rani_ki_vav.webp'),
(10, 'Vintage Car Collection', 4, 'A private museum showcasing a rare collection of classic cars.', 50.00, 'All year', '9:00 AM - 5:00 PM', 'vintage_cars.webp'),
(11, 'Lothal', 1, 'An ancient Harappan port city, providing a glimpse into the urban planning of the Indus Valley Civilization.', 0.00, 'Winter', '10:00 AM - 5:00 PM', 'lothal.webp'),
(12, 'Akshardham Temple', 8, 'A grand temple complex dedicated to Swaminarayan, known for its intricate architecture and spiritual exhibits.', 0.00, 'All year', '9:30 AM - 7:30 PM', 'akshardham_temple.webp'),
(13, 'Bhujodi Village', 20, 'A village of weavers and artisans, offering a chance to see traditional textile crafts.', 0.00, 'All year', '9:00 AM - 6:00 PM', 'bhujodi_village.webp'),
(14, 'Marine National Park', 17, 'India\'s first marine national park, home to diverse marine life.', 40.00, 'October to March', '9:00 AM - 5:00 PM', 'marine_national_park.webp'),
(15, 'Ambika Niketan Temple', 2, 'It is prominent pilgrimage place. It was built by the devotee of the Goddess, late Smt Bharati Maiya.', 0.00, 'October to March', '7:00 AM to 1:00 PM and 3:00 PM to 10:00 PM', 'ambika_niketan_temple.webp'),
(16, 'Sun Temple Modhera', 4, 'An 11th-century temple dedicated to the sun god Surya, known for its intricate carvings.', 20.00, 'October to March', 'Sunrise to Sunset', 'sun_temple_modhera.webp'),
(17, 'Uparkot Fort', 7, 'An ancient fort in Junagadh with a history dating back to the Mauryan dynasty.', 100.00, 'All year', '7:00 AM - 7:00 PM', 'uparkot_fort.webp'),
(18, 'Kirti temple', 14, 'A pleasant and bright place of respect, was built in the honour of Mahatma Gandhi and his wife Kasturba Gandhi in Porbandar in the Indian State of Gujarat.', 0.00, 'January to March', '10:00 AM - 12:00 PM and 3:00 PM - 6:30 PM', 'kirti_temple.webp'),
(19, 'Vijay Vilas Palace', 20, 'A beautiful palace on the beach, used as a film set for many Bollywood movies.', 70.00, 'All year', '9:00 AM - 1:00 PM, 3:00 PM - 6:00 PM', 'vijay_vilas_palace.webp'),
(20, 'Naulakha Palace', 15, 'An 18th-century architectural marvel in Gondal, Naulakha Palace is famous for its intricate carvings and a museum of royal artifacts.', 0.00, 'October to March', '10:00 AM - 7:00 PM', 'naulakha_palace.webp');

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
  `payment_status` enum('pending','paid','cancelled') NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`booking_id`, `user_id`, `package_id`, `booking_date`, `travel_date`, `number_of_travelers`, `total_amount`, `payment_status`) VALUES
(1, 1, 1, '2025-09-15 12:02:27', '2025-10-20', 2, 11000.00, 'paid'),
(2, 2, 2, '2025-09-15 12:02:27', '2025-11-05', 3, 12000.00, 'paid'),
(3, 3, 3, '2025-09-15 12:02:27', '2025-11-15', 1, 12000.00, 'pending'),
(4, 4, 4, '2025-09-15 12:02:27', '2025-12-01', 4, 34000.00, 'paid'),
(5, 5, 5, '2025-09-15 12:02:27', '2026-01-10', 2, 14000.00, 'paid'),
(6, 1, 6, '2025-09-15 12:02:27', '2026-02-20', 3, 18000.00, 'paid'),
(7, 2, 7, '2025-09-15 12:02:27', '2026-03-05', 1, 9500.00, 'paid'),
(8, 3, 8, '2025-09-15 12:02:27', '2026-04-12', 4, 60000.00, 'paid'),
(9, 4, 9, '2025-09-15 12:02:27', '2026-05-25', 2, 6000.00, 'pending'),
(10, 5, 10, '2025-09-15 12:02:27', '2026-06-30', 3, 15000.00, 'paid'),
(12, 2, 12, '2025-09-15 12:02:27', '2026-08-22', 4, 30000.00, 'pending'),
(13, 3, 13, '2025-09-15 12:02:27', '2026-09-01', 2, 5000.00, 'paid'),
(15, 5, 15, '2025-09-15 12:02:27', '2026-11-11', 1, 9000.00, 'paid'),
(16, 1, 16, '2025-09-15 12:02:27', '2026-12-18', 4, 44000.00, 'pending'),
(17, 2, 17, '2025-09-15 12:02:27', '2027-01-25', 2, 7000.00, 'paid'),
(18, 3, 18, '2025-09-15 12:02:27', '2027-02-28', 3, 6000.00, 'paid'),
(19, 4, 19, '2025-09-15 12:02:27', '2027-03-15', 1, 10000.00, 'pending'),
(20, 5, 20, '2025-09-15 12:02:27', '2027-04-20', 4, 32000.00, 'paid'),
(49, 3, 2, '2025-09-24 11:55:17', '2025-09-25', 2, 8000.00, '');

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
(1, 'Ahmedabad', 'A bustling metropolitan city and a former capital of Gujarat.', 'ahmedabad.webp', 'October to March'),
(2, 'Surat', 'Known as the Diamond City of India, famous for its textile industry.', 'surat.webp', 'November to February'),
(3, 'Vadodara', 'A cultural hub with palaces and gardens, also known as Sanskari Nagari.', 'vadodara.webp', 'October to March'),
(4, 'Mehsana', 'Mehsana, Gujarat, is known for the Mehsana breed of buffalo and is a destination for its rich cultural heritage and natural beauty', 'mehsana.webp', 'November to February'),
(5, 'Dwarka', 'An ancient pilgrimage site and one of the four sacred Char Dham sites, Dwarka is believed to be the kingdom of Lord Krishna.', 'dwarka.webp', 'October to March'),
(6, 'Gir', 'Home to the majestic Asiatic lions, Sasan Gir National Park offers thrilling wildlife safaris.', 'gir.webp', 'October to February'),
(7, 'Junagadh', 'Rich in history and architecture, Junagadh is known for its historic forts, caves, and the Girnar mountain.', 'junagadh.webp', 'November to February'),
(8, 'Gandhinagar', 'The capital city of Gujarat, known for its green spaces, modern infrastructure, and the Akshardham Temple.', 'gandhinagar.webp', 'October to March'),
(9, 'Patan', 'Famous for the Rani ki Vav, a UNESCO World Heritage site, and Patola sarees, Patan is a city of historical significance.', 'patan.webp', 'October to March'),
(10, 'Valsad', 'Previously known as Bulsar, Valsad district\'s offers some unique travel destinations. It\'s well-known for its mango plantations', 'valsad.webp', 'October to March'),
(11, 'Amreli', 'The district is named after its administrative headquarters, the city of Amreli, which historically was known as Amravaali.', 'amreli.webp', 'October to March'),
(12, ' Navsari ', 'A serene coastal town with a rich colonial history, beautiful beaches, and stunning forts.', 'navsari.webp', 'October to May'),
(13, 'Rajkot', 'A major commercial and industrial hub of Saurashtra, with a rich history related to Mahatma Gandhi.', 'rajkot.webp', 'October to March'),
(14, 'Porbandar', 'The birthplace of Mahatma Gandhi, Porbandar is a coastal city with historical and religious sites.', 'porbandar.webp', 'October to March'),
(15, 'Gondal', 'Known for its royal palaces, vintage cars, and rich history, Gondal offers a glimpse into the princely state of Gujarat.', 'gondal.webp', 'October to March'),
(16, 'Anand', 'The Milk Capital of India, famous for its Amul dairy cooperative movement.', 'anand.webp', 'November to February'),
(17, 'Jamnagar', 'Known as the Pearl City of Gujarat, with beautiful lakes, temples, and the Marine National Park.', 'jamnagar.webp', 'October to March'),
(18, 'Bhavnagar', 'A coastal city with a rich cultural heritage, known for its lakes, temples, and natural attractions.', 'bhavnagar.webp', 'October to March'),
(19, 'Morbi', 'Known as the Ceramic City of India, Morbi is a major industrial hub with a rich history and beautiful palaces.', 'morbi.webp', 'October to March'),
(20, 'Kutch', 'Kutch is a mesmerizing white salt desert that hosts the vibrant Rann Utsav festival. It\'s an extraordinary landscape of traditional artistry and rich history.', 'kutch.webp', 'November to February'),
(21, 'Somnath', 'Home to the Somnath Temple, one of the twelve Jyotirlinga shrines of Lord Shiva.', 'somnath.webp', 'October to March'),
(22, 'Poshina', 'A tribal village known for its traditional crafts and spiritual heritage.', 'poshina.webp', 'October to March');

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
  `image_url` varchar(255) DEFAULT NULL,
  `itinerary` text DEFAULT NULL,
  `ideal_for` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `packages`
--

INSERT INTO `packages` (`package_id`, `name`, `description`, `price`, `duration_days`, `inclusions`, `city_id`, `image_url`, `itinerary`, `ideal_for`) VALUES
(1, 'Ahmedabad Heritage Tour', 'Explore the rich history and heritage of Ahmedabad.', 5500.00, 3, 'Accommodation, Breakfast, Guided tour of heritage sites.', 1, 'heritage_package.webp', 'Day 1: Arrival in Ahmedabad, visit Sabarmati Ashram and Adalaj Stepwell. Day 2: Explore the Heritage Walk of Old Ahmedabad, visit Siddi Saiyyed Mosque. Day 3: Visit Kankaria Lake and departure.', 'History enthusiasts and families.'),
(2, 'Vadodara Cultural Gateway', 'A 2-day trip to explore the cultural capital of Gujarat.', 4000.00, 2, 'Travel, Accommodation, Entry tickets to monuments.', 3, 'cultural_package.webp', 'Day 1: Arrive in Vadodara and check in. Visit Laxmi Vilas Palace and Maharaja Fateh Singh Museum. Day 2: Explore local art and departure.', 'Culture lovers and art enthusiasts.'),
(3, 'Kutch Rann Utsav Special', 'A special package to experience the mesmerizing Rann Utsav festival in the white desert.', 12000.00, 4, 'Tent stay, all meals, cultural programs, desert safari.', 20, 'kutch_rann_utsav.webp', 'Day 1: Arrival at Bhuj, check into luxury tents. Enjoy Rann Utsav cultural programs. Day 2: Visit the White Rann at sunrise and sunset. Day 3: Explore the Kutch craft villages. Day 4: Departure.', 'Adventure seekers and festival-goers.'),
(4, 'Gir Wildlife Safari', 'Experience the thrill of a lifetime with a safari to spot the Asiatic lion.', 8500.00, 3, 'Accommodation, jungle safari, all meals.', 6, 'gir_safari.webp', 'Day 1: Arrive at Gir, check in. Afternoon safari in Gir National Park. Day 2: Morning safari to spot lions and other wildlife. Day 3: Nature walk and departure.', 'Wildlife enthusiasts and nature lovers.'),
(5, 'Dwarka & Somnath Pilgrimage', 'A sacred tour to the divine temples of Dwarka and Somnath.', 7000.00, 4, 'Accommodation, temple visits, travel.', 5, 'dwarka_somnath.webp', 'Day 1: Arrive in Dwarka, visit Dwarkadhish Temple and Dwarka Beach. Day 2: Visit Bet Dwarka and Nageshwar Jyotirlinga. Day 3: Travel to Somnath, visit Somnath Temple at sunset. Day 4: Morning aarti at Somnath and departure.', 'Pilgrims and spiritual travelers.'),
(6, 'Heritage Ahmedabad & Patan', 'Discover the architectural marvels of Ahmedabad and Patan.', 6000.00, 3, 'Accommodation, breakfast, guided tour of monuments.', 1, 'heritage_package_2.webp', 'Day 1: Arrive in Ahmedabad, explore heritage sites. Day 2: Day trip to Patan, visit Rani ki Vav. Day 3: Visit Modhera Sun Temple and departure.', 'History enthusiasts and photographers.'),
(7, 'Coastal Gujarat Tour', 'Explore the beautiful beaches and coastal towns of Gujarat.', 9500.00, 5, 'Accommodation, travel, water sports activities.', 20, 'coastal_tour.webp', 'Day 1: Arrive at Mandvi, check in to a beach resort. Day 2: Enjoy the beach and visit Vijay Vilas Palace. Day 3: Explore the local marine life. Day 4: Visit a nearby port and departure.', 'Beach lovers and families.'),
(8, 'Gondal Royal Retreat', 'A royal experience in Gondal with stays in heritage palaces and a vintage car tour.', 15000.00, 2, 'Palace stay, all meals, vintage car tour.', 15, 'gondal_royal.webp', 'Day 1: Arrive in Gondal, check in to a heritage palace. Visit the Naulakha Palace and explore the city. Day 2: Take a vintage car tour and enjoy a royal dinner before departure.', 'Luxury travelers and history buffs.'),
(9, 'Ahmedabad Foodie Trail', 'A culinary journey through the streets of Ahmedabad, tasting local delicacies.', 3000.00, 1, 'Guided food tour, tasting sessions.', 1, 'foodie_trail.webp', 'Day 1: Evening food tour covering Manek Chowk, street food stalls, and traditional Gujarati thali. Day 2: Enjoy a local breakfast and shopping before departure.', 'Foodies and culinary adventurers.'),
(10, 'Statue of Unity & Kevadia', 'A family trip to the Statue of Unity and surrounding attractions.', 5000.00, 2, 'Accommodation, transport, entry tickets.', 3, 'sou_package.webp', 'Day 1: Arrive at Kevadia, visit the Statue of Unity and Sardar Sarovar Dam. Day 2: Explore the Butterfly Garden, Valley of Flowers, and jungle safari before departure.', 'Families and sightseers.'),
(12, 'Jamnagar Pearl Tour', 'Explore the scenic lakes and marine life of Jamnagar.', 7500.00, 3, 'Accommodation, local transport, park entry tickets.', 17, 'jamnagar_tour.webp', 'Day 1: Arrive in Jamnagar, visit Lakhota Lake and Lakhota Palace. Day 2: Explore Marine National Park. Day 3: Departure.', 'Nature lovers and wildlife photographers.'),
(13, 'Surat Textile Tour', 'A short trip to explore the textile industry and diamond markets of Surat.', 2500.00, 2, 'Accommodation, guided market tour.', 2, 'surat_tour.webp', 'Day 1: Arrive in Surat and explore the famous textile and diamond markets. Day 2: Visit local industries and departure.', 'Business travelers and shoppers.'),
(15, 'Poshina Tribal Experience', 'A unique cultural tour to the tribal villages of Gujarat.', 9000.00, 3, 'Accommodation, cultural immersion, local transport.', 22, 'poshina_tour.webp', 'Day 1: Arrive at Poshina, immerse in local tribal culture. Day 2: Visit local tribal villages and artisan workshops. Day 3: Departure.', 'Cultural enthusiasts and art lovers.'),
(16, 'Wild Saurashtra', 'An adventure-filled trip to Junagadh, Gir and surrounding wildlife areas.', 11000.00, 4, 'Accommodation, safaris, guided trekking.', 7, 'wild_saurashtra.webp', 'Day 1: Arrive in Junagadh, visit Uparkot Fort. Day 2: Travel to Gir National Park for a safari. Day 3: Another safari and nature trekking. Day 4: Departure from Junagadh.', 'Adventure lovers and wildlife photographers.'),
(17, 'Gandhinagar City Tour', 'Explore the capital city of Gujarat, known for its green spaces and modern architecture.', 3500.00, 2, 'Accommodation, local transport, entry tickets.', 8, 'gandhinagar_tour.webp', 'Day 1: Arrive in Gandhinagar, visit Akshardham Temple and Sarita Udyan. Day 2: Explore the Indroda Nature Park and departure.', 'Families and spiritual seekers.'),
(18, 'Amul Co-operative Tour', 'A short tour of the dairy industry in Anand and surrounding areas.', 2000.00, 1, 'Guided factory tour, tasting sessions.', 1, 'amul_tour.webp', 'Day 1: Arrive at Anand, take a guided tour of the Amul Dairy plant. Day 2: Explore the local market and departure.', 'Foodies and educational tourists.'),
(19, 'Spiritual Gujarat', 'A pilgrimage tour covering the major religious sites of Gujarat.', 10000.00, 5, 'Accommodation, transport, temple visits.', 5, 'spiritual_tour.webp', 'Day 1: Arrive in Dwarka, visit Dwarkadhish Temple. Day 2: Visit Somnath Temple and Bhalka Teerth. Day 3: Travel to Junagadh, visit Girnar. Day 4: Visit local temples and departure.', 'Pilgrims and spiritual seekers.'),
(20, 'Bhuj & Kutch Crafts Tour', 'A journey to the craft villages of Kutch to experience traditional art and culture.', 8000.00, 4, 'Accommodation, local transport, workshop visits.', 4, 'bhuj_crafts.webp', 'Day 1: Arrive in Bhuj, visit Bhujodi Village and local craft centers. Day 2: Visit Dholavira, an ancient Indus Valley site. Day 3: Explore local markets and departure.', 'Artisans and cultural explorers.'),
(21, 'Sasan Gir', 'A combination of thrilling wildlife and relaxing in natural.', 13500.00, 5, 'Accommodation, jungle safari,adventural activities.', 6, 'gir.webp', 'Day 1: Arrive in Sasan Gir, check in. Afternoon jungle safari. Day 2: Morning safari and nature activities. Day 3: Departure.', 'Wildlife enthusiasts and families.'),
(22, 'Lothal & Dholavira History Tour', 'An archaeological expedition to the ancient sites of the Indus Valley Civilization.', 9000.00, 4, 'Accommodation, transport, guided tour of sites.', 1, 'lothal_dholavira.webp', 'Day 1: Arrive in Ahmedabad, travel to Lothal. Day 2: Visit the archaeological site of Lothal and museum. Day 3: Travel to Dholavira. Day 4: Explore Dholavira and departure.', 'History enthusiasts and students.');

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
(1, 1, 3, NULL, 5, 'The tour was fantastic! Our guide was very knowledgeable and friendly.', '2025-09-15 12:02:06', 'approved'),
(2, 2, NULL, 13, 4, 'Great package, but the accommodation could have been better.', '2025-09-15 12:02:06', 'approved'),
(3, 3, 10, NULL, 5, 'The Statue of Unity is a must-see! It is absolutely breathtaking.', '2025-09-15 12:02:06', 'approved'),
(4, 4, 1, NULL, 4, 'Sabarmati Ashram is a very peaceful and serene place. A great experience.', '2025-09-15 12:02:06', 'approved'),
(5, 5, NULL, 6, 3, 'The trip was good overall, but the itinerary was a bit rushed.', '2025-09-15 12:02:06', 'pending'),
(6, 1, 2, NULL, 5, 'Highly recommend this package. The city tour was very well-organized.', '2025-09-15 12:02:06', 'approved'),
(7, 2, 5, NULL, 5, 'A truly spiritual experience. The historical significance is immense.', '2025-09-15 12:02:06', 'approved'),
(8, 3, NULL, 19, 3, 'A very impressive palaces, though the heat was a bit much during the day.', '2025-09-15 12:02:06', 'approved'),
(9, 4, NULL, 15, 5, 'This heritage tour exceeded my expectations. A perfect blend of history and culture.', '2025-09-15 12:02:06', 'approved'),
(10, 5, 22, NULL, 4, 'A pleasant trip, the cultural events were a highlight.', '2025-09-15 12:02:06', 'approved'),
(11, 1, 6, NULL, 4, 'Informative and inspiring visit. I learned so much about Gandhi.', '2025-09-15 12:02:06', 'approved'),
(12, 2, NULL, 20, 5, 'An architectural marvel. It is even more grand in person.', '2025-09-15 12:02:06', 'approved'),
(13, 3, 3, NULL, 4, 'Enjoyed every moment of this tour. The food was delicious.', '2025-09-15 12:02:06', 'approved'),
(14, 4, 12, NULL, 2, 'The transport was delayed, but the rest of the tour was good.', '2025-09-15 12:02:06', 'rejected'),
(15, 5, NULL, 16, 5, 'Incredible views and a beautiful monument. Loved it!', '2025-09-15 12:02:06', 'approved'),
(16, 1, NULL, 1, 5, 'A quiet and reflective place. A must-visit for everyone.', '2025-09-15 12:02:06', 'approved'),
(17, 2, 1, NULL, 5, 'Everything was perfect. The guide, the hotels, the schedule.', '2025-09-15 12:02:06', 'approved'),
(18, 3, 19, NULL, 5, 'Excellent value for money. Loved the entire experience.', '2025-09-15 12:02:06', 'approved'),
(19, 4, NULL, 18, 5, 'Highly recommend this place for a peaceful time.', '2025-09-15 12:02:06', 'approved'),
(44, 5, NULL, 6, 3, 'Good experience, but the crowd management could be better.', '2025-09-15 12:02:06', 'pending'),
(45, 1, 8, NULL, 3, 'It was amazing ... but there are a lot of things which i missed because of less time ', '2025-09-21 11:34:19', 'approved');

-- --------------------------------------------------------

--
-- Table structure for table `transport_options`
--

CREATE TABLE `transport_options` (
  `transport_id` int(11) NOT NULL,
  `transport_type` enum('bus','train','flight','car') NOT NULL,
  `departure_city_id` int(11) DEFAULT NULL,
  `arrival_city_id` int(11) DEFAULT NULL,
  `departure_time` time NOT NULL,
  `arrival_time` time DEFAULT NULL,
  `approx_price` decimal(10,2) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `transport_options`
--

INSERT INTO `transport_options` (`transport_id`, `transport_type`, `departure_city_id`, `arrival_city_id`, `departure_time`, `arrival_time`, `approx_price`, `description`) VALUES
(24, 'bus', 1, 2, '07:00:00', '13:00:00', 450.00, 'AC bus from Ahmedabad to Surat.'),
(25, 'train', 1, 5, '22:30:00', '08:30:00', 900.00, 'Overnight train to Dwarka.'),
(26, 'flight', 1, 20, '14:00:00', '15:30:00', 3500.00, 'Direct flight to Kutch (Bhuj Airport).'),
(27, 'bus', 2, 1, '14:00:00', '20:00:00', 400.00, 'Luxury bus to Ahmedabad.'),
(28, 'train', 2, 3, '09:00:00', '11:00:00', 250.00, 'Local train to Vadodara.'),
(29, 'flight', 2, 7, '11:00:00', '12:30:00', 4800.00, 'Connecting flight to Junagadh.'),
(30, 'bus', 3, 1, '06:00:00', '08:30:00', 350.00, 'AC bus service to Ahmedabad.'),
(31, 'train', 3, 2, '12:00:00', '14:00:00', 200.00, 'Regular train to Surat.'),
(32, 'car', 3, 8, '15:00:00', '16:30:00', 1800.00, 'Private taxi to Gandhinagar.'),
(33, 'bus', 4, 1, '08:00:00', '09:30:00', 150.00, 'Local bus to Ahmedabad.'),
(34, 'train', 4, 9, '10:00:00', '10:45:00', 80.00, 'Short train ride to Patan.'),
(35, 'car', 4, 8, '11:00:00', '12:00:00', 1200.00, 'Private taxi to Gandhinagar.'),
(36, 'bus', 5, 21, '13:00:00', '16:00:00', 250.00, 'Bus to Somnath.'),
(37, 'train', 5, 17, '18:00:00', '22:00:00', 500.00, 'Evening train to Jamnagar.'),
(38, 'car', 5, 14, '09:00:00', '10:30:00', 1000.00, 'Private taxi to Porbandar.'),
(39, 'bus', 6, 7, '16:00:00', '17:30:00', 120.00, 'Local bus service to Junagadh.'),
(40, 'car', 6, 15, '10:00:00', '12:00:00', 1500.00, 'Taxi to Gondal.'),
(41, 'train', 6, 21, '11:00:00', '13:00:00', 180.00, 'Train to Somnath.'),
(42, 'bus', 7, 6, '08:00:00', '09:30:00', 120.00, 'Bus to Gir National Park.'),
(43, 'train', 7, 13, '14:00:00', '16:00:00', 300.00, 'Train to Rajkot.'),
(44, 'car', 7, 14, '11:00:00', '13:00:00', 2000.00, 'Private taxi to Porbandar.'),
(45, 'bus', 8, 1, '17:00:00', '18:00:00', 80.00, 'AC bus to Ahmedabad.'),
(46, 'train', 8, 4, '09:00:00', '10:30:00', 100.00, 'Local train to Mehsana.'),
(47, 'car', 8, 16, '14:00:00', '15:00:00', 1000.00, 'Taxi to Anand.'),
(48, 'bus', 9, 4, '12:00:00', '12:45:00', 70.00, 'Local bus to Mehsana.'),
(49, 'car', 9, 1, '15:00:00', '17:00:00', 2000.00, 'Private taxi to Ahmedabad.'),
(50, 'bus', 10, 2, '10:00:00', '12:00:00', 250.00, 'AC bus to Surat.'),
(51, 'train', 10, 12, '15:00:00', '15:30:00', 50.00, 'Local train to Navsari.'),
(52, 'bus', 11, 7, '09:00:00', '11:00:00', 200.00, 'Bus to Junagadh.'),
(53, 'car', 11, 13, '13:00:00', '14:30:00', 1200.00, 'Private taxi to Rajkot.'),
(54, 'bus', 12, 10, '08:00:00', '08:30:00', 50.00, 'Local bus to Valsad.'),
(55, 'car', 12, 2, '10:00:00', '11:00:00', 800.00, 'Private taxi to Surat.'),
(56, 'bus', 13, 15, '09:00:00', '10:30:00', 150.00, 'Bus to Gondal.'),
(57, 'train', 13, 7, '12:00:00', '14:00:00', 300.00, 'Train to Junagadh.'),
(58, 'bus', 14, 5, '11:00:00', '12:30:00', 180.00, 'Local bus to Dwarka.'),
(59, 'car', 14, 7, '14:00:00', '16:00:00', 2000.00, 'Private taxi to Junagadh.'),
(60, 'bus', 15, 13, '13:00:00', '14:30:00', 150.00, 'Bus to Rajkot.'),
(61, 'car', 15, 6, '10:00:00', '12:00:00', 1500.00, 'Private taxi to Gir.'),
(62, 'bus', 16, 3, '08:00:00', '09:00:00', 100.00, 'Local bus to Vadodara.'),
(63, 'car', 16, 1, '11:00:00', '12:30:00', 1500.00, 'Private taxi to Ahmedabad.'),
(64, 'bus', 17, 5, '09:00:00', '13:00:00', 400.00, 'AC bus to Dwarka.'),
(65, 'train', 17, 13, '15:00:00', '17:00:00', 250.00, 'Local train to Rajkot.'),
(66, 'bus', 18, 1, '06:00:00', '11:00:00', 500.00, 'AC bus to Ahmedabad.'),
(67, 'train', 18, 2, '09:00:00', '16:00:00', 650.00, 'Train to Surat.'),
(68, 'bus', 19, 13, '08:00:00', '09:30:00', 150.00, 'Local bus to Rajkot.'),
(69, 'car', 19, 20, '11:00:00', '14:00:00', 2500.00, 'Private taxi to Kutch.'),
(70, 'bus', 20, 1, '08:00:00', '17:00:00', 600.00, 'Sleeper bus to Ahmedabad.'),
(71, 'train', 20, 1, '19:00:00', '05:00:00', 750.00, 'Overnight train to Ahmedabad.'),
(72, 'flight', 20, 1, '16:00:00', '17:30:00', 4000.00, 'Direct flight to Ahmedabad.'),
(73, 'bus', 21, 5, '10:00:00', '13:00:00', 250.00, 'Bus to Dwarka.'),
(74, 'train', 21, 7, '14:00:00', '16:30:00', 200.00, 'Train to Junagadh.'),
(75, 'bus', 22, 1, '07:00:00', '12:00:00', 350.00, 'Local bus to Ahmedabad.'),
(76, 'car', 22, 8, '13:00:00', '14:30:00', 1800.00, 'Private taxi to Gandhinagar.'),
(78, 'bus', 1, 2, '07:00:00', '13:00:00', 450.00, 'AC bus from Ahmedabad to Surat.'),
(79, 'train', 1, 5, '22:30:00', '08:30:00', 900.00, 'Overnight train to Dwarka.'),
(80, 'flight', 1, 20, '14:00:00', '15:30:00', 3500.00, 'Direct flight to Kutch (Bhuj Airport).'),
(81, 'bus', 2, 1, '14:00:00', '20:00:00', 400.00, 'Luxury bus to Ahmedabad.'),
(82, 'train', 2, 3, '09:00:00', '11:00:00', 250.00, 'Local train to Vadodara.'),
(83, 'flight', 2, 7, '11:00:00', '12:30:00', 4800.00, 'Connecting flight to Junagadh.'),
(84, 'bus', 3, 1, '06:00:00', '08:30:00', 350.00, 'AC bus service to Ahmedabad.'),
(85, 'train', 3, 2, '12:00:00', '14:00:00', 200.00, 'Regular train to Surat.'),
(86, 'car', 3, 8, '15:00:00', '16:30:00', 1800.00, 'Private taxi to Gandhinagar.'),
(87, 'bus', 4, 1, '08:00:00', '09:30:00', 150.00, 'Local bus to Ahmedabad.'),
(88, 'train', 4, 9, '10:00:00', '10:45:00', 80.00, 'Short train ride to Patan.'),
(89, 'car', 4, 8, '11:00:00', '12:00:00', 1200.00, 'Private taxi to Gandhinagar.'),
(90, 'bus', 5, 21, '13:00:00', '16:00:00', 250.00, 'Bus to Somnath.'),
(91, 'train', 5, 17, '18:00:00', '22:00:00', 500.00, 'Evening train to Jamnagar.'),
(92, 'car', 5, 14, '09:00:00', '10:30:00', 1000.00, 'Private taxi to Porbandar.'),
(93, 'bus', 6, 7, '16:00:00', '17:30:00', 120.00, 'Local bus service to Junagadh.'),
(94, 'car', 6, 15, '10:00:00', '12:00:00', 1500.00, 'Taxi to Gondal.'),
(95, 'train', 6, 21, '11:00:00', '13:00:00', 180.00, 'Train to Somnath.'),
(96, 'bus', 7, 6, '08:00:00', '09:30:00', 120.00, 'Bus to Gir National Park.'),
(97, 'train', 7, 13, '14:00:00', '16:00:00', 300.00, 'Train to Rajkot.'),
(98, 'car', 7, 14, '11:00:00', '13:00:00', 2000.00, 'Private taxi to Porbandar.'),
(99, 'bus', 8, 1, '17:00:00', '18:00:00', 80.00, 'AC bus to Ahmedabad.'),
(100, 'train', 8, 4, '09:00:00', '10:30:00', 100.00, 'Local train to Mehsana.'),
(101, 'car', 8, 16, '14:00:00', '15:00:00', 1000.00, 'Taxi to Anand.'),
(102, 'bus', 9, 4, '12:00:00', '12:45:00', 70.00, 'Local bus to Mehsana.'),
(103, 'car', 9, 1, '15:00:00', '17:00:00', 2000.00, 'Private taxi to Ahmedabad.'),
(104, 'bus', 10, 2, '10:00:00', '12:00:00', 250.00, 'AC bus to Surat.'),
(105, 'train', 10, 12, '15:00:00', '15:30:00', 50.00, 'Local train to Navsari.'),
(106, 'bus', 11, 7, '09:00:00', '11:00:00', 200.00, 'Bus to Junagadh.'),
(107, 'car', 11, 13, '13:00:00', '14:30:00', 1200.00, 'Private taxi to Rajkot.'),
(108, 'bus', 12, 10, '08:00:00', '08:30:00', 50.00, 'Local bus to Valsad.'),
(109, 'car', 12, 2, '10:00:00', '11:00:00', 800.00, 'Private taxi to Surat.'),
(110, 'bus', 13, 15, '09:00:00', '10:30:00', 150.00, 'Bus to Gondal.'),
(111, 'train', 13, 7, '12:00:00', '14:00:00', 300.00, 'Train to Junagadh.'),
(112, 'bus', 14, 5, '11:00:00', '12:30:00', 180.00, 'Local bus to Dwarka.'),
(113, 'car', 14, 7, '14:00:00', '16:00:00', 2000.00, 'Private taxi to Junagadh.'),
(114, 'bus', 15, 13, '13:00:00', '14:30:00', 150.00, 'Bus to Rajkot.'),
(115, 'car', 15, 6, '10:00:00', '12:00:00', 1500.00, 'Private taxi to Gir.'),
(116, 'bus', 16, 3, '08:00:00', '09:00:00', 100.00, 'Local bus to Vadodara.'),
(117, 'car', 16, 1, '11:00:00', '12:30:00', 1500.00, 'Private taxi to Ahmedabad.'),
(118, 'bus', 17, 5, '09:00:00', '13:00:00', 400.00, 'AC bus to Dwarka.'),
(119, 'train', 17, 13, '15:00:00', '17:00:00', 250.00, 'Local train to Rajkot.'),
(120, 'bus', 18, 1, '06:00:00', '11:00:00', 500.00, 'AC bus to Ahmedabad.'),
(121, 'train', 18, 2, '09:00:00', '16:00:00', 650.00, 'Train to Surat.'),
(122, 'bus', 19, 13, '08:00:00', '09:30:00', 150.00, 'Local bus to Rajkot.'),
(123, 'car', 19, 20, '11:00:00', '14:00:00', 2500.00, 'Private taxi to Kutch.'),
(124, 'bus', 20, 1, '08:00:00', '17:00:00', 600.00, 'Sleeper bus to Ahmedabad.'),
(125, 'train', 20, 1, '19:00:00', '05:00:00', 750.00, 'Overnight train to Ahmedabad.'),
(126, 'flight', 20, 1, '16:00:00', '17:30:00', 4000.00, 'Direct flight to Ahmedabad.'),
(127, 'bus', 21, 5, '10:00:00', '13:00:00', 250.00, 'Bus to Dwarka.'),
(128, 'train', 21, 7, '14:00:00', '16:30:00', 200.00, 'Train to Junagadh.'),
(129, 'bus', 22, 1, '07:00:00', '12:00:00', 350.00, 'Local bus to Ahmedabad.'),
(130, 'car', 22, 8, '13:00:00', '14:30:00', 1800.00, 'Private taxi to Gandhinagar.'),
(132, 'bus', 1, 2, '07:00:00', '13:00:00', 450.00, 'AC bus from Ahmedabad to Surat.'),
(133, 'train', 1, 5, '22:30:00', '08:30:00', 900.00, 'Overnight train to Dwarka.'),
(134, 'flight', 1, 20, '14:00:00', '15:30:00', 3500.00, 'Direct flight to Kutch (Bhuj Airport).'),
(135, 'bus', 2, 1, '14:00:00', '20:00:00', 400.00, 'Luxury bus to Ahmedabad.'),
(136, 'train', 2, 3, '09:00:00', '11:00:00', 250.00, 'Local train to Vadodara.'),
(137, 'flight', 2, 7, '11:00:00', '12:30:00', 4800.00, 'Connecting flight to Junagadh.'),
(138, 'bus', 3, 1, '06:00:00', '08:30:00', 350.00, 'AC bus service to Ahmedabad.'),
(139, 'train', 3, 2, '12:00:00', '14:00:00', 200.00, 'Regular train to Surat.'),
(140, 'car', 3, 8, '15:00:00', '16:30:00', 1800.00, 'Private taxi to Gandhinagar.'),
(141, 'bus', 4, 1, '08:00:00', '09:30:00', 150.00, 'Local bus to Ahmedabad.'),
(142, 'train', 4, 9, '10:00:00', '10:45:00', 80.00, 'Short train ride to Patan.'),
(143, 'car', 4, 8, '11:00:00', '12:00:00', 1200.00, 'Private taxi to Gandhinagar.'),
(144, 'bus', 5, 21, '13:00:00', '16:00:00', 250.00, 'Bus to Somnath.'),
(145, 'train', 5, 17, '18:00:00', '22:00:00', 500.00, 'Evening train to Jamnagar.'),
(146, 'car', 5, 14, '09:00:00', '10:30:00', 1000.00, 'Private taxi to Porbandar.'),
(147, 'bus', 6, 7, '16:00:00', '17:30:00', 120.00, 'Local bus service to Junagadh.'),
(148, 'car', 6, 15, '10:00:00', '12:00:00', 1500.00, 'Taxi to Gondal.'),
(149, 'train', 6, 21, '11:00:00', '13:00:00', 180.00, 'Train to Somnath.'),
(150, 'bus', 7, 6, '08:00:00', '09:30:00', 120.00, 'Bus to Gir National Park.'),
(151, 'train', 7, 13, '14:00:00', '16:00:00', 300.00, 'Train to Rajkot.'),
(152, 'car', 7, 14, '11:00:00', '13:00:00', 2000.00, 'Private taxi to Porbandar.'),
(153, 'bus', 8, 1, '17:00:00', '18:00:00', 80.00, 'AC bus to Ahmedabad.'),
(154, 'train', 8, 4, '09:00:00', '10:30:00', 100.00, 'Local train to Mehsana.'),
(155, 'car', 8, 16, '14:00:00', '15:00:00', 1000.00, 'Taxi to Anand.'),
(156, 'bus', 9, 4, '12:00:00', '12:45:00', 70.00, 'Local bus to Mehsana.'),
(157, 'car', 9, 1, '15:00:00', '17:00:00', 2000.00, 'Private taxi to Ahmedabad.'),
(158, 'bus', 10, 2, '10:00:00', '12:00:00', 250.00, 'AC bus to Surat.'),
(159, 'train', 10, 12, '15:00:00', '15:30:00', 50.00, 'Local train to Navsari.'),
(160, 'bus', 11, 7, '09:00:00', '11:00:00', 200.00, 'Bus to Junagadh.'),
(161, 'car', 11, 13, '13:00:00', '14:30:00', 1200.00, 'Private taxi to Rajkot.'),
(162, 'bus', 12, 10, '08:00:00', '08:30:00', 50.00, 'Local bus to Valsad.'),
(163, 'car', 12, 2, '10:00:00', '11:00:00', 800.00, 'Private taxi to Surat.'),
(164, 'bus', 13, 15, '09:00:00', '10:30:00', 150.00, 'Bus to Gondal.'),
(165, 'train', 13, 7, '12:00:00', '14:00:00', 300.00, 'Train to Junagadh.'),
(166, 'bus', 14, 5, '11:00:00', '12:30:00', 180.00, 'Local bus to Dwarka.'),
(167, 'car', 14, 7, '14:00:00', '16:00:00', 2000.00, 'Private taxi to Junagadh.'),
(168, 'bus', 15, 13, '13:00:00', '14:30:00', 150.00, 'Bus to Rajkot.'),
(169, 'car', 15, 6, '10:00:00', '12:00:00', 1500.00, 'Private taxi to Gir.'),
(170, 'bus', 16, 3, '08:00:00', '09:00:00', 100.00, 'Local bus to Vadodara.'),
(171, 'car', 16, 1, '11:00:00', '12:30:00', 1500.00, 'Private taxi to Ahmedabad.'),
(172, 'bus', 17, 5, '09:00:00', '13:00:00', 400.00, 'AC bus to Dwarka.'),
(173, 'train', 17, 13, '15:00:00', '17:00:00', 250.00, 'Local train to Rajkot.'),
(174, 'bus', 18, 1, '06:00:00', '11:00:00', 500.00, 'AC bus to Ahmedabad.'),
(175, 'train', 18, 2, '09:00:00', '16:00:00', 650.00, 'Train to Surat.'),
(176, 'bus', 19, 13, '08:00:00', '09:30:00', 150.00, 'Local bus to Rajkot.'),
(177, 'car', 19, 20, '11:00:00', '14:00:00', 2500.00, 'Private taxi to Kutch.'),
(178, 'bus', 20, 1, '08:00:00', '17:00:00', 600.00, 'Sleeper bus to Ahmedabad.'),
(179, 'train', 20, 1, '19:00:00', '05:00:00', 750.00, 'Overnight train to Ahmedabad.'),
(180, 'flight', 20, 1, '16:00:00', '17:30:00', 4000.00, 'Direct flight to Ahmedabad.'),
(181, 'bus', 21, 5, '10:00:00', '13:00:00', 250.00, 'Bus to Dwarka.'),
(182, 'train', 21, 7, '14:00:00', '16:30:00', 200.00, 'Train to Junagadh.'),
(183, 'bus', 22, 1, '07:00:00', '12:00:00', 350.00, 'Local bus to Ahmedabad.'),
(184, 'car', 22, 8, '13:00:00', '14:30:00', 1800.00, 'Private taxi to Gandhinagar.');

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
(1, 'drashti', 'b@gmail.com', '$2y$10$3doZFjO.6yifPzTmfiTh7OK63t2ijigTxmYVASQsmSn0vBgjun8Pi', '2025-09-20 13:38:38', 0),
(2, 'kavi', 'c@gmail.com', '$2y$10$7qR6QH24WDTsKGi11s0vCuk32N/KxUTM5JlZC6xNKfFvb803pCJT6', '2025-09-20 13:39:37', 0),
(3, 'sweety', 'd@gmail.com', '$2y$10$fWtuWsB9AYrZmzl/hxB3T.VR4f9d0cu3tzs1yMYKCddDG7rdYzCz2', '2025-09-20 16:42:15', 0),
(4, 'grishma', 'e@gmail.com', '$2y$10$jP34xIyQTD8XxcGm4JuHIuzQeYmMcUHqx4HtH9JlRHZB8oF71gEam', '2025-09-20 16:43:17', 0),
(5, 'kara', 'a@gmail.com', '$2y$10$/ZSv7/N8VkliFgK1NqVWzeQSibY2DvqUyvvwg/uux843ARNybJlQ2', '2025-09-14 11:45:39', 0),
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
  ADD PRIMARY KEY (`transport_id`),
  ADD KEY `departure_city_id` (`departure_city_id`),
  ADD KEY `arrival_city_id` (`arrival_city_id`);

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
  MODIFY `attraction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=318;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

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
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `transport_options`
--
ALTER TABLE `transport_options`
  MODIFY `transport_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=185;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

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

--
-- Constraints for table `transport_options`
--
ALTER TABLE `transport_options`
  ADD CONSTRAINT `transport_options_ibfk_1` FOREIGN KEY (`departure_city_id`) REFERENCES `cities` (`city_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transport_options_ibfk_2` FOREIGN KEY (`arrival_city_id`) REFERENCES `cities` (`city_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
