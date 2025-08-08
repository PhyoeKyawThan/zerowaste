-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 08, 2025 at 10:01 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `zwdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `adm_id` int(222) NOT NULL,
  `username` varchar(222) NOT NULL,
  `password` varchar(222) NOT NULL,
  `email` varchar(222) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`adm_id`, `username`, `password`, `email`, `date`) VALUES
(1, 'admin', 'e6e061838856bf47e1de730719fb2609', 'admin@gmail.com', '2025-08-08 19:56:59');

-- --------------------------------------------------------

--
-- Table structure for table `dishes`
--

CREATE TABLE `dishes` (
  `d_id` int(222) NOT NULL,
  `rs_id` int(222) NOT NULL,
  `stock` int(11) NOT NULL,
  `title` varchar(222) NOT NULL,
  `slogan` varchar(222) NOT NULL,
  `img` varchar(222) NOT NULL,
  `status` enum('Pending','Approved','Rejected') NOT NULL DEFAULT 'Pending',
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `remark`
--

CREATE TABLE `remark` (
  `id` int(11) NOT NULL,
  `users_claims_id` int(11) NOT NULL,
  `status` varchar(255) NOT NULL,
  `remark` mediumtext NOT NULL,
  `remarkDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `restaurant`
--

CREATE TABLE `restaurant` (
  `rs_id` int(222) NOT NULL,
  `c_id` int(222) NOT NULL,
  `title` varchar(222) NOT NULL,
  `email` varchar(222) NOT NULL,
  `phone` varchar(222) NOT NULL,
  `url` varchar(222) NOT NULL,
  `o_hr` varchar(222) NOT NULL,
  `c_hr` varchar(222) NOT NULL,
  `o_days` varchar(222) NOT NULL,
  `address` text NOT NULL,
  `image` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `res_category`
--

CREATE TABLE `res_category` (
  `c_id` int(222) NOT NULL,
  `c_name` varchar(222) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `res_category`
--

INSERT INTO `res_category` (`c_id`, `c_name`, `date`) VALUES
(1, 'Continental', '2022-05-27 08:07:35'),
(2, 'Italian', '2021-04-07 08:45:23'),
(3, 'Chinese', '2021-04-07 08:45:25'),
(4, 'American', '2021-04-07 08:45:28');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `u_id` int(222) NOT NULL,
  `username` varchar(222) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `f_name` varchar(222) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `l_name` varchar(222) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(222) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `phone` varchar(222) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(222) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status` int(222) NOT NULL DEFAULT 1,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `role` enum('shop','user') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `account_status` enum('Pending','Approved') NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users_claims`
--

CREATE TABLE `users_claims` (
  `id` int(222) NOT NULL,
  `u_id` int(222) NOT NULL,
  `quantity` int(222) NOT NULL,
  `d_id` int(11) NOT NULL,
  `status` enum('Pending','Delivered','Rejected') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'Pending',
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `pickup_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`adm_id`);

--
-- Indexes for table `dishes`
--
ALTER TABLE `dishes`
  ADD PRIMARY KEY (`d_id`),
  ADD KEY `rs_id` (`rs_id`);

--
-- Indexes for table `remark`
--
ALTER TABLE `remark`
  ADD PRIMARY KEY (`id`),
  ADD KEY `remark_ibfk_1` (`users_claims_id`);

--
-- Indexes for table `restaurant`
--
ALTER TABLE `restaurant`
  ADD PRIMARY KEY (`rs_id`),
  ADD KEY `restaurant_ibfk_1` (`user_id`);

--
-- Indexes for table `res_category`
--
ALTER TABLE `res_category`
  ADD PRIMARY KEY (`c_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`u_id`);

--
-- Indexes for table `users_claims`
--
ALTER TABLE `users_claims`
  ADD PRIMARY KEY (`id`),
  ADD KEY `u_id` (`u_id`),
  ADD KEY `d_id` (`d_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `adm_id` int(222) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `dishes`
--
ALTER TABLE `dishes`
  MODIFY `d_id` int(222) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `remark`
--
ALTER TABLE `remark`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `restaurant`
--
ALTER TABLE `restaurant`
  MODIFY `rs_id` int(222) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `res_category`
--
ALTER TABLE `res_category`
  MODIFY `c_id` int(222) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `u_id` int(222) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users_claims`
--
ALTER TABLE `users_claims`
  MODIFY `id` int(222) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `dishes`
--
ALTER TABLE `dishes`
  ADD CONSTRAINT `dishes_ibfk_1` FOREIGN KEY (`rs_id`) REFERENCES `restaurant` (`rs_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `remark`
--
ALTER TABLE `remark`
  ADD CONSTRAINT `remark_ibfk_1` FOREIGN KEY (`users_claims_id`) REFERENCES `users_claims` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `restaurant`
--
ALTER TABLE `restaurant`
  ADD CONSTRAINT `restaurant_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`u_id`) ON DELETE NO ACTION;

--
-- Constraints for table `users_claims`
--
ALTER TABLE `users_claims`
  ADD CONSTRAINT `users_claims_ibfk_1` FOREIGN KEY (`u_id`) REFERENCES `users` (`u_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `users_claims_ibfk_2` FOREIGN KEY (`d_id`) REFERENCES `dishes` (`d_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
