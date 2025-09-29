-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 29, 2025 at 10:26 AM
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
-- Database: `smart_gym`
--

-- --------------------------------------------------------

--
-- Table structure for table `administators`
--

CREATE TABLE `administators` (
  `id` int(255) NOT NULL,
  `unid` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `tel` varchar(20) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `level` enum('admin','superUser','user') DEFAULT NULL,
  `accountStatus` enum('active','deactivated','deleted') NOT NULL DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `administators`
--

INSERT INTO `administators` (`id`, `unid`, `first_name`, `last_name`, `email`, `tel`, `password_hash`, `level`, `accountStatus`, `created_at`) VALUES
(1, '7854', '', '', 'admin@gmail.com', '', '12345', 'admin', 'active', '2025-09-08 11:36:47');

-- --------------------------------------------------------

--
-- Table structure for table `emailsubscriptions`
--

CREATE TABLE `emailsubscriptions` (
  `id` int(255) NOT NULL,
  `unid` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `dateAdded` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `emailsubscriptions`
--

INSERT INTO `emailsubscriptions` (`id`, `unid`, `email`, `dateAdded`) VALUES
(4, '70833', 'njoro45.itap@gmail.com', '2025-09-17 06:16:32');

-- --------------------------------------------------------

--
-- Table structure for table `payment_history`
--

CREATE TABLE `payment_history` (
  `id` int(255) NOT NULL,
  `user_unid` varchar(255) NOT NULL,
  `Receipt_no` varchar(255) NOT NULL,
  `subscription` varchar(255) NOT NULL,
  `amount` varchar(255) NOT NULL,
  `paymentMode` varchar(255) NOT NULL,
  `dateAdded` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment_history`
--

INSERT INTO `payment_history` (`id`, `user_unid`, `Receipt_no`, `subscription`, `amount`, `paymentMode`, `dateAdded`) VALUES
(1, '81096', 'rtye45ar6', 'monthly', '1500', '', '2025-09-17 08:08:38');

-- --------------------------------------------------------

--
-- Table structure for table `plans`
--

CREATE TABLE `plans` (
  `id` int(255) NOT NULL,
  `unid` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `duration_value` int(255) NOT NULL,
  `duration_type` enum('week','day','month','year') DEFAULT NULL,
  `tariff` varchar(255) NOT NULL,
  `discount` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `plans`
--

INSERT INTO `plans` (`id`, `unid`, `name`, `duration_value`, `duration_type`, `tariff`, `discount`) VALUES
(27, '46785', 'Free Trial', 30, 'day', '0', '0'),
(28, '7767', 'Montly', 1, 'month', '1500', '0'),
(29, '0817', 'Yearly', 1, 'year', '18000', '10');

-- --------------------------------------------------------

--
-- Table structure for table `plansubscription`
--

CREATE TABLE `plansubscription` (
  `id` int(11) NOT NULL,
  `user_unid` varchar(255) NOT NULL,
  `plan_unid` varchar(255) NOT NULL,
  `plan_name` varchar(255) NOT NULL,
  `expiryDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `plansubscription`
--

INSERT INTO `plansubscription` (`id`, `user_unid`, `plan_unid`, `plan_name`, `expiryDate`) VALUES
(6, '81096', '7767', 'Montly', '2025-10-16 08:02:22'),
(7, '5223', '0817', 'Yearly', '2026-09-27 09:26:42');

-- --------------------------------------------------------

--
-- Table structure for table `plan_features`
--

CREATE TABLE `plan_features` (
  `id` int(255) NOT NULL,
  `plan_id` varchar(255) NOT NULL,
  `feature_text` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `plan_features`
--

INSERT INTO `plan_features` (`id`, `plan_id`, `feature_text`) VALUES
(33, '46785', 'Limited gym access (1–2 days/week or off-peak)'),
(34, '46785', 'Basic workout equipment'),
(35, '46785', '1 free fitness consultation'),
(36, '46785', 'Basic workout plans (PDF/app)'),
(37, '46785', 'Community newsletter / tips'),
(38, '7767', 'All workout equipment'),
(39, '7767', 'Fitness consultation'),
(40, '7767', 'Discounts on merchandise'),
(41, '7767', 'All group classes included'),
(42, '7767', 'Locker access &amp;amp; towel service'),
(43, '7767', 'Access card'),
(44, '0817', 'Everything in Monthly'),
(45, '0817', '2 personal trainer sessions / month'),
(46, '0817', 'Free merch pack &amp;amp; priority booking'),
(47, '0817', 'Free acces card replacement');

-- --------------------------------------------------------

--
-- Table structure for table `suggestion_box`
--

CREATE TABLE `suggestion_box` (
  `id` int(255) NOT NULL,
  `unid` varchar(255) NOT NULL,
  `suggestion` varchar(255) NOT NULL,
  `dateAdded` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `suggestion_box`
--

INSERT INTO `suggestion_box` (`id`, `unid`, `suggestion`, `dateAdded`) VALUES
(1, '2763', 'thi', '2025-09-17 05:38:42'),
(2, '82882', 'hi', '2025-09-17 05:41:53'),
(3, '9575', 'hi', '2025-09-17 06:14:19'),
(4, '37299', 'hiii', '2025-09-17 06:16:58'),
(5, '5223', 'design ur ui', '2025-09-27 09:26:23');

-- --------------------------------------------------------

--
-- Table structure for table `trainers`
--

CREATE TABLE `trainers` (
  `id` int(255) NOT NULL,
  `unid` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `tel` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `status` enum('active','deactivated','deleted') NOT NULL DEFAULT 'active',
  `level` enum('Gym Instructor','Personal Trainer','Specialist Trainer','Advanced/Clinical Trainer') NOT NULL DEFAULT 'Gym Instructor',
  `joining_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `trainers`
--

INSERT INTO `trainers` (`id`, `unid`, `first_name`, `last_name`, `tel`, `email`, `status`, `level`, `joining_date`) VALUES
(2, '6612', 'samue', 'mwang', '0717109680', 'njoro45.itap@gmail.com', 'active', 'Gym Instructor', '2025-09-09 10:37:55'),
(3, '35852', 'samuel', 'mwangi', '0717109786', 'njoro4.itap@gmail.com', 'active', 'Personal Trainer', '2025-09-09 11:47:52');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(255) NOT NULL,
  `unid` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `tel` varchar(20) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `notification_preference` enum('sms','email') NOT NULL DEFAULT 'email',
  `accountStatus` enum('active','deactivated','deleted','blacklisted') NOT NULL DEFAULT 'active',
  `reset_token` varchar(255) NOT NULL,
  `reset_expiry` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `unid`, `first_name`, `last_name`, `email`, `tel`, `password_hash`, `notification_preference`, `accountStatus`, `reset_token`, `reset_expiry`, `created_at`) VALUES
(2, '81096', 'samuel', 'mwangi', 'njoro45.itap@gmail.com', '0717109686', '$2y$10$l4V7.ox07zFhnpqIRYPAhul7tXdF5Fdng7ya/72.ZN3LwP/zgXqhK', 'email', 'active', '', NULL, '2025-09-16 04:18:24');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `administators`
--
ALTER TABLE `administators`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `emailsubscriptions`
--
ALTER TABLE `emailsubscriptions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_history`
--
ALTER TABLE `payment_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `plans`
--
ALTER TABLE `plans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `plansubscription`
--
ALTER TABLE `plansubscription`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `plan_features`
--
ALTER TABLE `plan_features`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `suggestion_box`
--
ALTER TABLE `suggestion_box`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `trainers`
--
ALTER TABLE `trainers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `administators`
--
ALTER TABLE `administators`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `emailsubscriptions`
--
ALTER TABLE `emailsubscriptions`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `payment_history`
--
ALTER TABLE `payment_history`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `plans`
--
ALTER TABLE `plans`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `plansubscription`
--
ALTER TABLE `plansubscription`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `plan_features`
--
ALTER TABLE `plan_features`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `suggestion_box`
--
ALTER TABLE `suggestion_box`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `trainers`
--
ALTER TABLE `trainers`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
