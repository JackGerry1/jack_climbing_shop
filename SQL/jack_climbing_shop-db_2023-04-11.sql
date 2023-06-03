-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 11, 2023 at 08:55 AM
-- Server version: 8.0.31
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jack_climbing_shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `CUSTOMER_ID` int NOT NULL,
  `first_name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `last_name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `postcode` varchar(8) COLLATE utf8mb4_general_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `password_salt` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`CUSTOMER_ID`, `first_name`, `last_name`, `email`, `address`, `postcode`, `password_hash`, `password_salt`) VALUES
(1, 'walter', 'white', 'walter123@gmail.com', '45 Wolverton Road, Stony Stratford', 'MK11 1ED', '$2y$10$4XMEFzFZE1JtK6IIFXUKyOwssgVVmhKOJ1HnEjBNyF4eOo7pyRl7K', 'a06ce64b8fbf2e4662d89c5177c01da1bf5b84ae16498822c46715fb57481dec'),
(2, 'john', 'smith', 'john321@gmail.com', '11 Broadland Road, Bury St Edmunds', 'IP33 2TG', '$2y$10$LQy2BpREYwP7Q97xoh.BIeyqdXUVnYkGWLsMDMF8LYLkdSl2N.BMK', '81c810a63549cbea01e8ca665ab9b03e51f0a6f3ca86cf0587bd66e43b3a38ee'),
(3, 'steve', 'cook', 'stevec345@gmail.com', '10 Walnut Mews, Wooburn Green', 'HP10 0AG', '$2y$10$HxfS1CwRZSFrQcV/Dyq/SulXTkLF7icN0bhiham9f5sqjJkIjLa8S', '45b2e5983e062c6e28d14985386a04e0066709370379e873a6061189ddea12e6');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `PRODUCT_ID` int NOT NULL,
  `product_name` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `category` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `description` text COLLATE utf8mb4_general_ci,
  `stock` int DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`PRODUCT_ID`, `product_name`, `category`, `price`, `description`, `stock`, `image`) VALUES
(1, 'Black Diamond Camalot', 'Climbing Gear', '129.95', 'The Black Diamond Camalot is a popular and reliable climbing cam that comes in a range of sizes.', 25, 'camalot.jpg'),
(2, 'Petzl Grigri 2', 'Climbing Gear', '99.95', 'The Petzl Grigri 2 is a belay device that offers excellent control and safety for climbers.', 25, 'grigri2.jpg'),
(3, 'La Sportiva Solution', 'Climbing Shoes', '179.95', 'The La Sportiva Solution is a high-performance climbing shoe designed for steep and technical routes.', 7, 'solution.jpg'),
(4, 'Black Diamond Momentum Harness', 'Climbing Gear', '59.95', 'The Black Diamond Momentum Harness is a comfortable and durable harness for all-around climbing.', 30, 'momentum.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `PURCHASE_ID` int NOT NULL,
  `CUSTOMER_ID` int DEFAULT NULL,
  `PRODUCT_ID` int DEFAULT NULL,
  `purchase_date` datetime DEFAULT NULL,
  `quantity` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `purchases`
--

INSERT INTO `purchases` (`PURCHASE_ID`, `CUSTOMER_ID`, `PRODUCT_ID`, `purchase_date`, `quantity`) VALUES
(1, 2, 2, '2023-04-06 08:50:35', 25),
(2, 3, 1, '2023-04-06 09:12:18', 5),
(15, 1, 3, '2023-04-06 18:38:26', 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`CUSTOMER_ID`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`PRODUCT_ID`);

--
-- Indexes for table `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`PURCHASE_ID`),
  ADD KEY `CUSTOMER_ID` (`CUSTOMER_ID`),
  ADD KEY `PRODUCT_ID` (`PRODUCT_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `CUSTOMER_ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `PRODUCT_ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `PURCHASE_ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `purchases`
--
ALTER TABLE `purchases`
  ADD CONSTRAINT `purchases_ibfk_1` FOREIGN KEY (`CUSTOMER_ID`) REFERENCES `customers` (`CUSTOMER_ID`),
  ADD CONSTRAINT `purchases_ibfk_2` FOREIGN KEY (`PRODUCT_ID`) REFERENCES `products` (`PRODUCT_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
