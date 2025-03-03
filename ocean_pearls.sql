-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 03, 2025 at 01:20 PM
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
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_name` enum('sharath','ahad','sudeep') NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admin_name` (`admin_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`admin_name`, `password`) VALUES
('sharath', '$2y$10$rd6oZnqbb1ncPLgOPMnoZOoAtTyLiFCFvviq30OosOtVScxMB2TQi'),
('ahad', '$2y$10$rd6oZnqbb1ncPLgOPMnoZOoAtTyLiFCFvviq30OosOtVScxMB2TQi'),
('sudeep', '$2y$10$rd6oZnqbb1ncPLgOPMnoZOoAtTyLiFCFvviq30OosOtVScxMB2TQi');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `booking_time` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `room_id` (`room_id`),
  CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `location` varchar(100) NOT NULL,
  `room_type` varchar(50) NOT NULL,
  `bedding` varchar(50) NOT NULL,
  `status` enum('Available','Booked') DEFAULT 'Available',
  `price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`location`, `room_type`, `bedding`, `status`, `price`) VALUES
('Uppinakudru', 'Standard Single', 'Single', 'Available', 800.00),
('Uppinakudru', 'Standard Double', 'Double', 'Available', 1000.00),
('Uppinakudru', 'Standard King', 'King', 'Available', 1200.00),
('Uppinakudru', 'Deluxe Single', 'Single', 'Available', 1300.00),
('Uppinakudru', 'Deluxe Double', 'Double', 'Available', 1500.00),
('Uppinakudru', 'Deluxe King', 'King', 'Available', 1700.00),
('Uppinakudru', 'Suite Single', 'Single', 'Available', 2000.00),
('Uppinakudru', 'Suite Double', 'Double', 'Available', 2200.00),
('Uppinakudru', 'Suite King', 'King', 'Available', 2500.00),
('Koteshwara', 'Standard Single', 'Single', 'Available', 1200.00),
('Koteshwara', 'Standard Double', 'Double', 'Available', 1400.00),
('Koteshwara', 'Standard King', 'King', 'Available', 1600.00),
('Koteshwara', 'Deluxe Single', 'Single', 'Available', 1700.00),
('Koteshwara', 'Deluxe Double', 'Double', 'Available', 1900.00),
('Koteshwara', 'Deluxe King', 'King', 'Available', 2100.00),
('Koteshwara', 'Suite Single', 'Single', 'Available', 2500.00),
('Koteshwara', 'Suite Double', 'Double', 'Available', 2700.00),
('Koteshwara', 'Suite King', 'King', 'Available', 3000.00),
('Maravanthe', 'Standard Single', 'Single', 'Available', 1800.00),
('Maravanthe', 'Standard Double', 'Double', 'Available', 2000.00),
('Maravanthe', 'Standard King', 'King', 'Available', 2200.00),
('Maravanthe', 'Deluxe Single', 'Single', 'Available', 2500.00),
('Maravanthe', 'Deluxe Double', 'Double', 'Available', 2700.00),
('Maravanthe', 'Deluxe King', 'King', 'Available', 2900.00),
('Maravanthe', 'Suite Single', 'Single', 'Available', 3200.00),
('Maravanthe', 'Suite Double', 'Double', 'Available', 3500.00),
('Maravanthe', 'Suite King', 'King', 'Available', 3800.00);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nationality` varchar(50) NOT NULL DEFAULT 'India',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
