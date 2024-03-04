-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Εξυπηρετητής: 127.0.0.1
-- Χρόνος δημιουργίας: 08 Φεβ 2024 στις 13:48:48
-- Έκδοση διακομιστή: 10.4.32-MariaDB
-- Έκδοση PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Βάση δεδομένων: `xristos`
--

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `aithmata`
--

CREATE TABLE `aithmata` (
  `username` varchar(30) DEFAULT NULL,
  `onoma` varchar(30) NOT NULL,
  `mobile` varchar(30) NOT NULL,
  `eidos` varchar(30) DEFAULT NULL,
  `proion` varchar(30) NOT NULL,
  `atoma` int(50) DEFAULT NULL,
  `egine_dekto` varchar(3) DEFAULT NULL,
  `hmerominia_aitisis` date DEFAULT NULL,
  `hmerominia_oloklirosis` date DEFAULT NULL,
  `latitude` varchar(30) NOT NULL,
  `longitude` varchar(30) NOT NULL,
  `reqStatus` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Άδειασμα δεδομένων του πίνακα `aithmata`
--

INSERT INTO `aithmata` (`username`, `onoma`, `mobile`, `eidos`, `proion`, `atoma`, `egine_dekto`, `hmerominia_aitisis`, `hmerominia_oloklirosis`, `latitude`, `longitude`, `reqStatus`) VALUES
('antonis', 'Antonis A', '7690878731', 'Beverages', 'Water', 6, 'NAI', '2024-02-01', '0000-00-00', '38.261', '21.744', ''),
('antonis', 'Antonis A', '7690878731', 'First Aid', 'First Aid Kit', 5, ' ', '2024-02-01', '0000-00-00', '38.261', '21.744', ''),
('george', 'George T', '7654329087', 'Food', 'Sardines', 4, 'NAI', '2024-02-01', '0000-00-00', '38.282', '21.766', ''),
('nikos', 'Nikos G', '7634323085', 'Kitchen Supplies', 'Scrub brush', 5, 'NAI', '2024-02-01', '0000-00-00', '38.235', '21.758', '');

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `aithmatapolith`
--

CREATE TABLE `aithmatapolith` (
  `username` varchar(30) DEFAULT NULL,
  `eidos` varchar(30) DEFAULT NULL,
  `proion` varchar(30) NOT NULL,
  `atoma` int(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Άδειασμα δεδομένων του πίνακα `aithmatapolith`
--

INSERT INTO `aithmatapolith` (`username`, `eidos`, `proion`, `atoma`) VALUES
('antonis', 'Beverages', 'Water', 6),
('antonis', 'First Aid', 'First Aid Kit', 5),
('george', 'Food', 'Sardines', 4),
('nikos', 'Kitchen Supplies', 'Scrub brush', 5);

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `anakoinoseis`
--

CREATE TABLE `anakoinoseis` (
  `id_anak` int(5) NOT NULL,
  `keimeno` text DEFAULT NULL,
  `hmerominia_dimosieusis` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Άδειασμα δεδομένων του πίνακα `anakoinoseis`
--

INSERT INTO `anakoinoseis` (`id_anak`, `keimeno`, `hmerominia_dimosieusis`) VALUES
(1, 'There is a demand for Water for 20 people and Food for 25 people.', '2023-12-28'),
(2, 'There is a demand for Supplies for 13 people.', '2023-12-28'),
(3, 'There is a demand for Water for 30 people.', '2024-01-25');

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `categories`
--

CREATE TABLE `categories` (
  `cat_id` int(11) NOT NULL,
  `cat_name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Άδειασμα δεδομένων του πίνακα `categories`
--

INSERT INTO `categories` (`cat_id`, `cat_name`) VALUES
(1, 'Beverages'),
(2, 'Cleaning Supplies'),
(3, 'Clothing'),
(4, 'First Aid '),
(5, 'Food'),
(6, 'Kitchen Supplies'),
(7, 'Medical Supplies'),
(8, 'Personal Hygiene '),
(9, 'Shoes');

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `diasostes`
--

CREATE TABLE `diasostes` (
  `username` varchar(30) NOT NULL,
  `car_id` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Άδειασμα δεδομένων του πίνακα `diasostes`
--

INSERT INTO `diasostes` (`username`, `car_id`) VALUES
('tasos', '200'),
('panos', '300'),
('elena', '100'),
('elena', '100'),
('tasos', '200'),
('panos', '300');

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `dorees`
--

CREATE TABLE `dorees` (
  `donId` int(10) NOT NULL,
  `username` varchar(30) DEFAULT NULL,
  `onoma` varchar(30) DEFAULT NULL,
  `mobile` varchar(30) DEFAULT NULL,
  `proion` varchar(30) DEFAULT NULL,
  `atoma` int(50) DEFAULT NULL,
  `egine_dekto` varchar(3) DEFAULT NULL,
  `hmerominia_doreas` date DEFAULT NULL,
  `hmerominia_oloklirosis` date DEFAULT NULL,
  `latitude` varchar(10) NOT NULL,
  `longitude` varchar(10) NOT NULL,
  `donStatus` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Άδειασμα δεδομένων του πίνακα `dorees`
--

INSERT INTO `dorees` (`donId`, `username`, `onoma`, `mobile`, `proion`, `atoma`, `egine_dekto`, `hmerominia_doreas`, `hmerominia_oloklirosis`, `latitude`, `longitude`, `donStatus`) VALUES
(12, 'makis', 'Makis K', '3829405867', 'Water  ', 20, 'NAI', '2024-02-01', '0000-00-00', '38.1922254', '21.7645839', ''),
(13, 'makis', 'Makis K', '3829405867', 'Food  ', 25, ' ', '2024-02-01', '0000-00-00', '38.1922254', '21.7645839', ''),
(14, 'maria', 'Maria N', '7654329087', 'Cleaning rag', 5, ' ', '2024-02-01', '0000-00-00', '38.217', '21.721', '');

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `doreespolith`
--

CREATE TABLE `doreespolith` (
  `donId` int(10) NOT NULL,
  `username` varchar(30) DEFAULT NULL,
  `proion` varchar(30) DEFAULT NULL,
  `atoma` int(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Άδειασμα δεδομένων του πίνακα `doreespolith`
--

INSERT INTO `doreespolith` (`donId`, `username`, `proion`, `atoma`) VALUES
(14, 'makis', 'Water  ', 20),
(15, 'makis', 'Food  ', 25),
(16, 'maria', 'Cleaning rag', 5);

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `loads`
--

CREATE TABLE `loads` (
  `load_id` int(11) NOT NULL,
  `car_id` int(11) DEFAULT NULL,
  `pr_name` varchar(255) DEFAULT NULL,
  `category` varchar(50) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Άδειασμα δεδομένων του πίνακα `loads`
--

INSERT INTO `loads` (`load_id`, `car_id`, `pr_name`, `category`, `quantity`) VALUES
(19, 100, 'Broom', '2', 5),
(20, 300, 'Sardines', 'Food', 4),
(21, 300, 'Biscuits', 'Food', 7),
(23, 200, 'Cleaning rag', '2', 3);

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `logintable`
--

CREATE TABLE `logintable` (
  `username` varchar(30) DEFAULT NULL,
  `password` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Άδειασμα δεδομένων του πίνακα `logintable`
--

INSERT INTO `logintable` (`username`, `password`) VALUES
('makis', 'makis123'),
('maria', 'maria123'),
('antonis', 'antonis123'),
('george', 'george123'),
('nikos', 'nikos123'),
('xristos', 'xristos123'),
('elena', 'elena123'),
('tasos', 'tasos123'),
('panos', 'panos123');

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `oxhmata`
--

CREATE TABLE `oxhmata` (
  `username` int(11) NOT NULL,
  `cid` int(11) NOT NULL,
  `pr_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `latitude` varchar(30) NOT NULL,
  `longitude` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Άδειασμα δεδομένων του πίνακα `oxhmata`
--

INSERT INTO `oxhmata` (`username`, `cid`, `pr_id`, `quantity`, `latitude`, `longitude`) VALUES
(100, 0, 0, 0, '38.280', '21.792'),
(200, 0, 0, 0, '38.207', '21.734'),
(300, 0, 0, 0, '38.222', '21.775');

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `pr_name` varchar(50) NOT NULL,
  `category` varchar(50) NOT NULL,
  `quantity` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Άδειασμα δεδομένων του πίνακα `products`
--

INSERT INTO `products` (`id`, `pr_name`, `category`, `quantity`) VALUES
(16, 'Water', '1', 183),
(17, 'Orange juice', '1', 185),
(18, 'Sardines', '5', 196),
(19, 'Canned corn', '5', 200),
(20, 'Bread', '5', 200),
(21, 'Chocolate', '5', 200),
(22, 'Men Sneakers', '9', 200),
(25, 'Spaghetti', '5', 200),
(26, 'Croissant', '5', 200),
(29, 'Biscuits', '5', 193),
(30, 'Bandages', '7', 200),
(31, 'Disposable gloves', '7', 200),
(32, 'Gauze', '7', 200),
(33, 'Antiseptic', '7', 200),
(34, 'First Aid Kit', '4', 200),
(35, 'Painkillers', '4', 200),
(36, 'Blanket', '3', 200),
(37, 'Fakes', '5', 200),
(38, 'Menstrual Pads', '7', 200),
(39, 'Tampon', '8', 200),
(40, 'Toilet Paper', '8', 200),
(41, 'Baby wipes', '8', 200),
(42, 'Toothbrush', '8', 200),
(43, 'Toothpaste', '8', 200),
(44, 'Vitamin C', '7', 200),
(45, 'Multivitamines', '7', 200),
(46, 'Paracetamol', '7', 200),
(47, 'Ibuprofen', '7', 200),
(51, 'Cleaning rag', '2', 190),
(55, 'Plastic bucket', '6', 200),
(56, 'Scrub brush', '6', 200),
(57, 'Dust mask', '2', 200),
(58, 'Broom', '2', 195),
(65, 'Underwear', '3', 200),
(66, 'Socks', '3', 200),
(67, 'Warm Jacket', '3', 200),
(68, 'Raincoat', '3', 200),
(69, 'Gloves', '3', 200),
(70, 'Pants', '3', 200),
(71, 'Boots', '9', 200),
(72, 'Dishes', '6', 200),
(74, 'Paring knives', '6', 200),
(75, 'Pan', '6', 200),
(76, 'Glass', '6', 200),
(84, 'water ', '1', 183),
(85, 'Coca Cola', '1', 191),
(86, 'spray', '4', 200),
(90, 'Condensed milk', '1', 200),
(91, 'Cereal bar', '5', 200),
(93, 'Water Disinfection Tablets', '8', 200),
(96, 'Winter hat', '3', 200),
(97, 'Winter gloves', '3', 200),
(98, 'Scarf', '3', 200),
(99, 'Thermos', '6', 200),
(100, 'Tea', '1', 200),
(101, 'Dog Food ', '5', 200),
(102, 'Cat Food', '5', 200),
(103, 'Canned', '5', 200),
(104, 'Chlorine', '8', 200),
(105, 'Medical gloves', '7', 200),
(106, 'T-Shirt', '3', 200),
(111, 'Sleeping Bag', '3', 200),
(112, 'Toothbrush', '8', 200),
(113, 'Toothpaste', '8', 200),
(114, 'Thermometer', '7', 200),
(115, 'Rice', '5', 200),
(117, 'Towels', '8', 200),
(120, 'Fruits', '5', 200),
(125, 'Bandages', '7', 200),
(126, 'Betadine', '7', 200),
(127, 'cotton wool', '7', 200),
(128, 'Crackers', '5', 200),
(129, 'Sanitary Pads', '7', 200),
(131, 'Electrolytes', '5', 200),
(132, 'Pain killers', '4', 200),
(134, 'Juice', '1', 200),
(135, 'Toilet Paper', '8', 200),
(137, 'Biscuits', '5', 193),
(138, 'Antihistamines', '7', 200),
(140, 'Lacta', '5', 200),
(141, 'Canned Tuna', '5', 200),
(148, 'Dry Cranberries', '5', 200),
(149, 'Dry Apricots', '5', 200);

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `product_details`
--

CREATE TABLE `product_details` (
  `pr_id` int(11) NOT NULL,
  `detail_name` varchar(30) NOT NULL,
  `detail_value` varchar(30) NOT NULL,
  `quantity` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Άδειασμα δεδομένων του πίνακα `product_details`
--

INSERT INTO `product_details` (`pr_id`, `detail_name`, `detail_value`, `quantity`) VALUES
(16, 'volume', '1.5l', 0),
(16, 'pack size', '6', 0),
(17, 'volume', '250ml', 0),
(17, 'pack size', '12', 0),
(18, 'brand', 'Trata', 0),
(18, 'weight', '200g', 0),
(19, 'weight', '500g', 0),
(20, 'weight', '1kg', 0),
(20, 'type', 'white', 0),
(21, 'weight', '100g', 0),
(21, 'type', 'milk chocolate', 0),
(21, 'brand', 'ION', 0),
(22, 'size', '44', 0),
(25, 'grams', '500', 0),
(26, 'calories', '200', 0),
(29, '', '', 0),
(30, '', '25 pcs', 0),
(31, '', '100 pcs', 0),
(32, '', '', 0),
(33, '', '250ml', 0),
(34, '', '', 0),
(35, 'volume', '200mg', 0),
(36, 'size', '50\" x 60\"', 0),
(37, '', '', 0),
(38, 'stock', '500', 0),
(38, 'size', '3', 0),
(38, '', '', 0),
(39, 'stock', '500', 0),
(39, 'size', 'regular', 0),
(40, 'stock', '300', 0),
(40, 'ply', '3', 0),
(41, 'volume', '500gr', 0),
(41, 'stock ', '500', 0),
(41, 'scent', 'aloe', 0),
(42, 'stock', '500', 0),
(43, 'stock', '250', 0),
(44, 'stock', '200', 0),
(45, 'stock', '200', 0),
(46, 'stock', '2000', 0),
(46, 'dosage', '500mg', 0),
(47, 'stock ', '10', 0),
(47, 'dosage', '200mg', 0),
(51, '', '', 0),
(55, '', '', 0),
(56, '', '', 0),
(57, '', '', 0),
(58, '', '', 0),
(65, '', '', 0),
(66, '', '', 0),
(67, '', '', 0),
(68, '', '', 0),
(69, '', '', 0),
(70, '', '', 0),
(71, '', '', 0),
(72, '', '', 0),
(74, '', '', 0),
(75, '', '', 0),
(76, '', '', 0),
(84, '', '', 0),
(85, 'Volume', '500ml', 0),
(86, 'volume', '75ml', 0),
(90, 'weight', '400gr', 0),
(91, 'weight', '23,5gr', 0),
(93, 'Basic Ingredients', 'Iodine', 0),
(93, 'Suggested for', 'Everyone expept pregnant women', 0),
(96, '', '', 0),
(97, '', '', 0),
(98, '', '', 0),
(99, '', '', 0),
(100, 'volume', '500ml', 0),
(101, 'volume', '500g', 0),
(102, 'volume', '500g', 0),
(103, '', '', 0),
(104, 'volume', '500ml', 0),
(105, 'volume', '20pieces', 0),
(106, 'size', 'XL', 0),
(111, '', '', 0),
(112, '', '', 0),
(113, '', '', 0),
(114, '', '', 0),
(115, '', '', 0),
(117, '', '', 0),
(120, '', '', 0),
(120, '', '', 0),
(125, 'Adhesive', '2 meters', 0),
(126, 'Povidone iodine 10%', '240 ml', 0),
(127, '100% Hydrofile', '70gr', 0),
(128, 'Quantity per package', '10', 0),
(128, 'Packages', '2', 0),
(129, 'piece', '10 pieces', 0),
(129, '', '', 0),
(129, '', '', 0),
(131, 'packet of pills', '20 pills', 0),
(132, 'packet of pills', '20 pills', 0),
(134, 'volume', '500ml', 0),
(135, 'rolls', '1 roll', 0),
(135, '', '', 0),
(137, 'packet', '1 packet', 0),
(138, 'pills', '10 pills', 0),
(140, 'weight', '105g', 0),
(141, '', '', 0),
(148, 'weight', '100', 0),
(149, 'weight', '100', 0);

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `tasks`
--

CREATE TABLE `tasks` (
  `id_task` int(10) NOT NULL,
  `eidos_task` varchar(10) NOT NULL,
  `username_res` varchar(30) NOT NULL,
  `car_id` varchar(30) NOT NULL,
  `citizen_name` varchar(30) NOT NULL,
  `citizen_mobile` varchar(30) NOT NULL,
  `proion` varchar(30) NOT NULL,
  `atoma` varchar(30) NOT NULL,
  `destination_lat` varchar(30) NOT NULL,
  `destination_lng` varchar(30) NOT NULL,
  `task_status` varchar(10) NOT NULL,
  `hmerominia_analipsis` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Άδειασμα δεδομένων του πίνακα `tasks`
--

INSERT INTO `tasks` (`id_task`, `eidos_task`, `username_res`, `car_id`, `citizen_name`, `citizen_mobile`, `proion`, `atoma`, `destination_lat`, `destination_lng`, `task_status`, `hmerominia_analipsis`) VALUES
(33, 'Donation', 'elena', '100', 'Makis K', '3829405867', 'Water  ', '20', '38.1922254', '21.7645839', '', '2024-02-01'),
(35, 'Request', 'panos', '300', 'Antonis A', '7690878731', 'Water', '6', '38.261', '21.744', '', '2024-02-01'),
(36, 'Request', 'panos', '300', 'George T', '7654329087', 'Sardines', '4', '38.282', '21.766', '', '2024-02-01');

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `users`
--

CREATE TABLE `users` (
  `id` varchar(30) NOT NULL,
  `username` varchar(30) DEFAULT NULL,
  `password` varchar(30) DEFAULT NULL,
  `name` varchar(30) DEFAULT NULL,
  `mobile` varchar(30) DEFAULT NULL,
  `latitude` varchar(30) DEFAULT NULL,
  `longitude` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Άδειασμα δεδομένων του πίνακα `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `name`, `mobile`, `latitude`, `longitude`) VALUES
('citizen', 'makis', 'makis123', 'Makis K', '3829405867', '38.1922254', '21.7645839'),
('citizen', 'maria', 'maria123', 'Maria N', '7654329087', '38.217', '21.721'),
('citizen', 'antonis', 'antonis123', 'Antonis A', '7690878731', '38.261', '21.744'),
('citizen', 'george', 'george123', 'George T', '7654329087', '38.282', '21.766'),
('citizen', 'nikos', 'nikos123', 'Nikos G', '7634323085', '38.235', '21.758'),
('admin', 'xristos', 'xristos123', 'Xristos P', '1234567843', '38.223', '21.746'),
('diasostis', 'elena', 'elena123', 'Elena B', '1290756323', '38.280', '21.768'),
('diasostis', 'tasos', 'tasos123', 'Tasos T', '1926589012', '38.228', '21.769'),
('diasostis', 'panos', 'panos123', 'Panos P', '1832564810', '38.207', '21.733');

--
-- Ευρετήρια για άχρηστους πίνακες
--

--
-- Ευρετήρια για πίνακα `anakoinoseis`
--
ALTER TABLE `anakoinoseis`
  ADD PRIMARY KEY (`id_anak`);

--
-- Ευρετήρια για πίνακα `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`cat_id`);

--
-- Ευρετήρια για πίνακα `dorees`
--
ALTER TABLE `dorees`
  ADD PRIMARY KEY (`donId`);

--
-- Ευρετήρια για πίνακα `doreespolith`
--
ALTER TABLE `doreespolith`
  ADD PRIMARY KEY (`donId`);

--
-- Ευρετήρια για πίνακα `loads`
--
ALTER TABLE `loads`
  ADD PRIMARY KEY (`load_id`);

--
-- Ευρετήρια για πίνακα `oxhmata`
--
ALTER TABLE `oxhmata`
  ADD PRIMARY KEY (`username`);

--
-- Ευρετήρια για πίνακα `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Ευρετήρια για πίνακα `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id_task`);

--
-- AUTO_INCREMENT για άχρηστους πίνακες
--

--
-- AUTO_INCREMENT για πίνακα `anakoinoseis`
--
ALTER TABLE `anakoinoseis`
  MODIFY `id_anak` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT για πίνακα `dorees`
--
ALTER TABLE `dorees`
  MODIFY `donId` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT για πίνακα `doreespolith`
--
ALTER TABLE `doreespolith`
  MODIFY `donId` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT για πίνακα `loads`
--
ALTER TABLE `loads`
  MODIFY `load_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT για πίνακα `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id_task` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
