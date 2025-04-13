-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 15, 2025 at 08:06 AM
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
-- Database: `ocean_pearls`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `admin_name` enum('sharath','ahad','sudeep') NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `admin_name`, `password`) VALUES
(1, 'sharath', '$2y$10$rd6oZnqbb1ncPLgOPMnoZOoAtTyLiFCFvviq30OosOtVScxMB2TQi'),
(2, 'ahad', '$2y$10$rd6oZnqbb1ncPLgOPMnoZOoAtTyLiFCFvviq30OosOtVScxMB2TQi'),
(3, 'sudeep', '$2y$10$rd6oZnqbb1ncPLgOPMnoZOoAtTyLiFCFvviq30OosOtVScxMB2TQi');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `room_id` int(11) DEFAULT NULL,
  `checkin_date` date NOT NULL,
  `checkout_date` date NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `agreed_terms` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('Pending','Accepted','User Cancelled','Rejected') DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `nationality` varchar(255) NOT NULL,
  `payment_status` varchar(10) DEFAULT NULL,
  `booking_time` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` int(11) NOT NULL,
  `location` varchar(100) NOT NULL,
  `room_type` varchar(50) NOT NULL,
  `bedding` varchar(50) NOT NULL,
  `status` enum('Available','Booked') DEFAULT 'Available',
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `location`, `room_type`, `bedding`, `status`, `price`) VALUES
(13, 'Uppinakudru', 'Standard Single', 'Single', 'Available', 800.00),
(14, 'Uppinakudru', 'Standard Double', 'Double', 'Available', 1000.00),
(15, 'Uppinakudru', 'Standard King', 'King', 'Available', 1200.00),
(16, 'Uppinakudru', 'Deluxe Single', 'Single', 'Available', 1300.00),
(17, 'Uppinakudru', 'Deluxe Double', 'Double', 'Available', 1500.00),
(18, 'Uppinakudru', 'Deluxe King', 'King', 'Available', 1700.00),
(19, 'Uppinakudru', 'Suite Single', 'Single', 'Available', 2000.00),
(20, 'Uppinakudru', 'Suite Double', 'Double', 'Available', 2200.00),
(21, 'Uppinakudru', 'Suite King', 'King', 'Available', 2500.00),
(22, 'Koteshwara', 'Standard Single', 'Single', 'Available', 1200.00),
(23, 'Koteshwara', 'Standard Double', 'Double', 'Available', 1400.00),
(24, 'Koteshwara', 'Standard King', 'King', 'Available', 1600.00),
(25, 'Koteshwara', 'Deluxe Single', 'Single', 'Available', 1700.00),
(26, 'Koteshwara', 'Deluxe Double', 'Double', 'Available', 1900.00),
(27, 'Koteshwara', 'Deluxe King', 'King', 'Available', 2100.00),
(28, 'Koteshwara', 'Suite Single', 'Single', 'Available', 2500.00),
(29, 'Koteshwara', 'Suite Double', 'Double', 'Available', 2700.00),
(30, 'Koteshwara', 'Suite King', 'King', 'Available', 3000.00),
(31, 'Maravanthe', 'Standard Single', 'Single', 'Available', 1800.00),
(32, 'Maravanthe', 'Standard Double', 'Double', 'Available', 2000.00),
(33, 'Maravanthe', 'Standard King', 'King', 'Available', 2200.00),
(34, 'Maravanthe', 'Deluxe Single', 'Single', 'Available', 2500.00),
(35, 'Maravanthe', 'Deluxe Double', 'Double', 'Available', 2700.00),
(36, 'Maravanthe', 'Deluxe King', 'King', 'Available', 2900.00),
(37, 'Maravanthe', 'Suite Single', 'Single', 'Available', 3200.00),
(38, 'Maravanthe', 'Suite Double', 'Double', 'Available', 3500.00),
(39, 'Maravanthe', 'Suite King', 'King', 'Available', 3800.00);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nationality` varchar(50) NOT NULL DEFAULT 'India'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admin_name` (`admin_name`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `room_id` (`room_id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`);

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
