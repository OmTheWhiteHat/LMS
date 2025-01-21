-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 21, 2025 at 05:58 PM
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
-- Database: `computer_lab`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('Admin','Manager') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`, `role`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'Admin');

-- --------------------------------------------------------

--
-- Table structure for table `item_stocks`
--

CREATE TABLE `item_stocks` (
  `id` int(11) NOT NULL,
  `item_name` varchar(100) NOT NULL,
  `quantity` int(11) NOT NULL,
  `last_updated` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `item_stocks`
--

INSERT INTO `item_stocks` (`id`, `item_name`, `quantity`, `last_updated`) VALUES
(1, 'MOUSE', 1, '2024-12-12 09:55:33');

-- --------------------------------------------------------

--
-- Table structure for table `receipts`
--

CREATE TABLE `receipts` (
  `id` int(11) NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `receipts`
--

INSERT INTO `receipts` (`id`, `item_name`, `quantity`, `total_amount`, `created_at`) VALUES
(1, 'Monitor Repair', 2, 100.00, '2024-12-12 20:08:04'),
(2, 'New Keyboard', 5, 75.00, '2024-12-12 20:08:04'),
(3, 'Annual Maintenance Fee', 1, 250.00, '2024-12-12 20:08:04');

-- --------------------------------------------------------

--
-- Table structure for table `resolved_issues`
--

CREATE TABLE `resolved_issues` (
  `id` int(11) NOT NULL,
  `system_id` int(11) DEFAULT NULL,
  `issue_description` text DEFAULT NULL,
  `resolution_details` text DEFAULT NULL,
  `resolution_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `resolved_issues`
--

INSERT INTO `resolved_issues` (`id`, `system_id`, `issue_description`, `resolution_details`, `resolution_date`) VALUES
(1, 1, 'Montor', 'Successfully repaired', '2024-12-13 08:48:34'),
(2, 1, 'Keyboard', 'maintainance', '2024-12-13 09:06:24');

-- --------------------------------------------------------

--
-- Table structure for table `systems`
--

CREATE TABLE `systems` (
  `id` int(11) NOT NULL,
  `cpu_id` varchar(255) DEFAULT NULL,
  `ups_id` varchar(255) DEFAULT NULL,
  `monitor_id` varchar(255) DEFAULT NULL,
  `issue` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `lab_name` varchar(255) DEFAULT NULL,
  `os_installed` varchar(255) DEFAULT NULL,
  `ram` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `internet` enum('Yes','No','Unknown') NOT NULL DEFAULT 'Unknown'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `systems`
--

INSERT INTO `systems` (`id`, `cpu_id`, `ups_id`, `monitor_id`, `issue`, `description`, `lab_name`, `os_installed`, `ram`, `image`, `internet`) VALUES
(1, 'BEST-CPU-01', 'BEST-01', 'BEST-01', 'NO', 'No', 'CS-1', 'LINUX', '12GB', '../uploads/default.jpg', 'Unknown');

-- --------------------------------------------------------

--
-- Table structure for table `system_log`
--

CREATE TABLE `system_log` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `login_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `ip_address` varchar(255) NOT NULL,
  `user_agent` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `system_log`
--

INSERT INTO `system_log` (`id`, `username`, `login_time`, `ip_address`, `user_agent`) VALUES
(1, 'admin', '2024-12-13 07:22:40', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36'),
(2, 'admin', '2024-12-13 07:42:22', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36');

-- --------------------------------------------------------

--
-- Table structure for table `system_status`
--

CREATE TABLE `system_status` (
  `id` int(11) NOT NULL,
  `system_id` int(11) NOT NULL,
  `status` varchar(255) NOT NULL,
  `last_updated` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `system_status`
--

INSERT INTO `system_status` (`id`, `system_id`, `status`, `last_updated`) VALUES
(1, 1, 'Inactive', '2024-12-13 09:07:36'),
(2, 1, 'Inactive', '2024-12-13 09:07:43'),
(3, 1, 'Active', '2024-12-13 09:08:59');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `item_stocks`
--
ALTER TABLE `item_stocks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `receipts`
--
ALTER TABLE `receipts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `resolved_issues`
--
ALTER TABLE `resolved_issues`
  ADD PRIMARY KEY (`id`),
  ADD KEY `system_id` (`system_id`);

--
-- Indexes for table `systems`
--
ALTER TABLE `systems`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_log`
--
ALTER TABLE `system_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_status`
--
ALTER TABLE `system_status`
  ADD PRIMARY KEY (`id`),
  ADD KEY `system_id` (`system_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `item_stocks`
--
ALTER TABLE `item_stocks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `receipts`
--
ALTER TABLE `receipts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `resolved_issues`
--
ALTER TABLE `resolved_issues`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `systems`
--
ALTER TABLE `systems`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `system_log`
--
ALTER TABLE `system_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `system_status`
--
ALTER TABLE `system_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `resolved_issues`
--
ALTER TABLE `resolved_issues`
  ADD CONSTRAINT `resolved_issues_ibfk_1` FOREIGN KEY (`system_id`) REFERENCES `systems` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `system_status`
--
ALTER TABLE `system_status`
  ADD CONSTRAINT `system_status_ibfk_1` FOREIGN KEY (`system_id`) REFERENCES `systems` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
