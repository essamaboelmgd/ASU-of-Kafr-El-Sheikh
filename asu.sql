-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 10, 2025 at 07:21 PM
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
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `message` text NOT NULL,
  `created_at` datetime NOT NULL,
  `ip_address` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `daily_visitors`
--

CREATE TABLE `daily_visitors` (
  `visit_date` date NOT NULL,
  `visitor_count` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(11, 'test event', 'event-img/images (19).jpeg', 'art', '2025-05-12 19:40:00');

-- --------------------------------------------------------

--
-- Table structure for table `event_users`
--

CREATE TABLE `event_users` (
  `id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `grade` enum('First','Second','Third','Fourth') NOT NULL,
  `created_at` datetime NOT NULL,
  `ip_address` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `form_fields`
--

CREATE TABLE `form_fields` (
  `id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `field_type` enum('label','checkbox','paragraph','text','radio') NOT NULL,
  `field_label` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `form_fields`
--

INSERT INTO `form_fields` (`id`, `event_id`, `field_type`, `field_label`) VALUES
(155, 11, 'paragraph', 'Test Event'),
(156, 11, 'paragraph', 'ازيكم يابشمهندسين دا فورم تجريبي عشان نشوف الفورمات اشتغلت تمام واللا لسا'),
(157, 11, 'paragraph', 'تقييمك للمنصه : '),
(158, 11, 'radio', 'ممتازه'),
(159, 11, 'radio', 'جيده'),
(160, 11, 'radio', 'مقبوله'),
(161, 11, 'radio', 'سيئه'),
(162, 11, 'radio', 'سيئه جدا');

-- --------------------------------------------------------

--
-- Table structure for table `total_visits`
--

CREATE TABLE `total_visits` (
  `visit_date` date NOT NULL,
  `visit_count` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `ip_address` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL,
  `fields_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `event_id`, `ip_address`, `created_at`, `fields_data`) VALUES
(12, 0, '127.0.0.1', '2025-05-10 18:56:19', '[\"radio_158: ممتازه\"]');

-- --------------------------------------------------------

--
-- Table structure for table `visitors`
--

CREATE TABLE `visitors` (
  `id` int(11) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `visit_date` date NOT NULL,
  `visit_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `yearly_visitors`
--

CREATE TABLE `yearly_visitors` (
  `visit_year` year(4) NOT NULL,
  `visitor_count` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `daily_visitors`
--
ALTER TABLE `daily_visitors`
  ADD PRIMARY KEY (`visit_date`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `event_users`
--
ALTER TABLE `event_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `form_fields`
--
ALTER TABLE `form_fields`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `total_visits`
--
ALTER TABLE `total_visits`
  ADD PRIMARY KEY (`visit_date`);

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
  ADD PRIMARY KEY (`visit_year`);

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
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `event_users`
--
ALTER TABLE `event_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `form_fields`
--
ALTER TABLE `form_fields`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=163;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `visitors`
--
ALTER TABLE `visitors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
