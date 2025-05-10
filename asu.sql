-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 04, 2025 at 12:53 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `asu`
--

-- --------------------------------------------------------

--
-- Table structure for table `about`
--

CREATE TABLE `about` (
  `id` int(11) NOT NULL,
  `about_header` varchar(225) NOT NULL,
  `about_body` varchar(225) NOT NULL,
  `img_url` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admin_accs`
--

CREATE TABLE `admin_accs` (
  `id` int(11) NOT NULL,
  `admin_users` varchar(225) NOT NULL,
  `admin_pass` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_accs`
--

INSERT INTO `admin_accs` (`id`, `admin_users`, `admin_pass`) VALUES
(1001, 'scientific', '#ScientificAdminASU2025#'),
(2001, 'art', '#ArtAdminASU2025#'),
(3001, 'athletic', '#AthleticAdminASU2025#'),
(4001, 'social', '#SocialAdminASU2025#'),
(5001, 'voyager', '#VoyagerAdminASU2025#'),
(6001, 'cultural', '#CulturalAdminASU2025#');

-- --------------------------------------------------------

--
-- Table structure for table `daily_visitors`
--

CREATE TABLE `daily_visitors` (
  `id` int(11) NOT NULL,
  `visit_date` date NOT NULL,
  `visitor_count` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `daily_visitors`
--

INSERT INTO `daily_visitors` (`id`, `visit_date`, `visitor_count`) VALUES
(49, '2025-03-03', 1);

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `title` varchar(225) NOT NULL,
  `img_url` varchar(225) NOT NULL,
  `event_type` varchar(225) NOT NULL,
  `expiry_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `title`, `img_url`, `event_type`, `expiry_time`) VALUES
(5, 'AI e-sport', 'event-img/form-2.jpg', 'athletic', '2025-03-06 01:25:00');

-- --------------------------------------------------------

--
-- Table structure for table `form_fields`
--

CREATE TABLE `form_fields` (
  `id` int(11) NOT NULL,
  `field_type` enum('label','checkbox','paragraph','text','radio') NOT NULL,
  `field_label` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `form_fields`
--

INSERT INTO `form_fields` (`id`, `field_type`, `field_label`) VALUES
(75, 'paragraph', ''),
(76, 'label', ''),
(77, 'checkbox', ''),
(78, 'radio', ''),
(79, 'checkbox', ''),
(80, 'checkbox', ''),
(81, 'checkbox', ''),
(82, 'paragraph', ''),
(83, 'paragraph', '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `ip_address` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL,
  `fields_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `ip_address`, `created_at`, `fields_data`) VALUES
(8, '127.0.0.1', '2025-03-03 08:50:38', '[\"field_65: Esssam\",\"field_66: 01062772291\",\"radio_68: 1\",\"checkbox_73: pes\"]');

-- --------------------------------------------------------

--
-- Table structure for table `visitors`
--

CREATE TABLE `visitors` (
  `id` int(11) NOT NULL,
  `ip_address` varchar(50) NOT NULL,
  `visit_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `visitors`
--

INSERT INTO `visitors` (`id`, `ip_address`, `visit_date`) VALUES
(58, '127.0.0.1', '2025-03-03');

-- --------------------------------------------------------

--
-- Table structure for table `yearly_visitors`
--

CREATE TABLE `yearly_visitors` (
  `id` int(11) NOT NULL,
  `visit_year` int(11) NOT NULL,
  `visitor_count` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `yearly_visitors`
--

INSERT INTO `yearly_visitors` (`id`, `visit_year`, `visitor_count`) VALUES
(49, 2025, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `about`
--
ALTER TABLE `about`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_accs`
--
ALTER TABLE `admin_accs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `daily_visitors`
--
ALTER TABLE `daily_visitors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `form_fields`
--
ALTER TABLE `form_fields`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `visitors`
--
ALTER TABLE `visitors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `yearly_visitors`
--
ALTER TABLE `yearly_visitors`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `about`
--
ALTER TABLE `about`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `admin_accs`
--
ALTER TABLE `admin_accs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6003;

--
-- AUTO_INCREMENT for table `daily_visitors`
--
ALTER TABLE `daily_visitors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `form_fields`
--
ALTER TABLE `form_fields`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `visitors`
--
ALTER TABLE `visitors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `yearly_visitors`
--
ALTER TABLE `yearly_visitors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
