-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 17, 2024 at 05:42 AM
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
-- Database: `cbsphp`
--

-- --------------------------------------------------------

--
-- Table structure for table `booking_list`
--

CREATE TABLE `booking_list` (
  `id` int(30) NOT NULL,
  `ref_code` varchar(100) NOT NULL,
  `client_id` int(30) NOT NULL,
  `cab_id` int(30) NOT NULL,
  `pickup_zone` text NOT NULL,
  `drop_zone` text NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT 0 COMMENT '0 = Pending,\r\n1 = Driver has Confirmed,\r\n2 = Pickup,\r\n3 = drop-off,\r\n4 = cancelled',
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `cost` int(30) NOT NULL,
  `Amount` int(11) DEFAULT NULL,
  `Payment_status` text NOT NULL,
  `Visible_status` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking_list`
--

INSERT INTO `booking_list` (`id`, `ref_code`, `client_id`, `cab_id`, `pickup_zone`, `drop_zone`, `status`, `date_created`, `date_updated`, `cost`, `Amount`, `Payment_status`, `Visible_status`) VALUES
(57, '202410-00001', 18, 21, 'A', 'B', 1, '2024-10-17 08:16:21', '2024-10-17 08:23:15', 0, 5000, 'Paid', 'True');

-- --------------------------------------------------------

--
-- Table structure for table `cab_list`
--

CREATE TABLE `cab_list` (
  `id` int(30) NOT NULL,
  `reg_code` varchar(100) NOT NULL,
  `category_id` int(30) NOT NULL,
  `cab_reg_no` varchar(200) NOT NULL,
  `body_no` varchar(100) NOT NULL,
  `cab_model` text NOT NULL,
  `cab_driver` text NOT NULL,
  `driver_contact` text NOT NULL,
  `driver_address` text NOT NULL,
  `password` text NOT NULL,
  `image_path` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `delete_flag` tinyint(1) NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cab_list`
--

INSERT INTO `cab_list` (`id`, `reg_code`, `category_id`, `cab_reg_no`, `body_no`, `cab_model`, `cab_driver`, `driver_contact`, `driver_address`, `password`, `image_path`, `status`, `delete_flag`, `date_created`, `date_updated`) VALUES
(20, '202202-00002', 2, 'ASTR0306', 'Fusion-130', 'Ford Fusion', 'Mark Cooper', '09123456789', '8B54/R  N.H.S Raddolugama', '$2y$10$bqdGNE4kbL.weGEmO1FTuuh/QH44nN2eUHbk8qgIgJwdHfK8p9iOC', 'uploads/OIP (1).jpg', 1, 0, '2024-10-11 17:50:13', NULL),
(21, '1', 1, 'ASTR0306', 'Fusion-130', 'Ford Fusion', 'Mark Cooper', '09123456789', '8B54/R  N.H.S Raddolugama', '$2y$10$O0hpNnG.Bn4ZuxtLKBGlbuxrQPJZyXg8FMK0VJiGn0mi9L4NjYeNe', 'uploads/OIP (1).jpg', 1, 0, '2024-10-11 17:59:35', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `category_list`
--

CREATE TABLE `category_list` (
  `id` int(30) NOT NULL,
  `seater` int(11) NOT NULL,
  `description` text NOT NULL,
  `delete_flag` tinyint(1) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `cost` int(30) NOT NULL,
  `type` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category_list`
--

INSERT INTO `category_list` (`id`, `seater`, `description`, `delete_flag`, `status`, `date_created`, `date_updated`, `cost`, `type`) VALUES
(1, 10, 'afawfafafacaw awfafd afafrawfdaf aa', 0, 1, '2024-10-10 19:46:26', NULL, 600001, 'bus'),
(2, 1, 'adafafcawad', 0, 1, '2024-10-10 19:51:01', NULL, 5, 'Car'),
(3, 4, 'affaa', 0, 1, '2024-10-11 09:45:18', NULL, 5000, 'bmw');

-- --------------------------------------------------------

--
-- Table structure for table `client_list`
--

CREATE TABLE `client_list` (
  `id` int(30) NOT NULL,
  `firstname` text NOT NULL,
  `middlename` text DEFAULT NULL,
  `lastname` text NOT NULL,
  `gender` text NOT NULL,
  `contact` text NOT NULL,
  `address` text NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` text DEFAULT NULL,
  `image_path` text DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `delete_flag` tinyint(1) DEFAULT 0,
  `date_created` datetime DEFAULT current_timestamp(),
  `date_added` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `client_list`
--

INSERT INTO `client_list` (`id`, `firstname`, `middlename`, `lastname`, `gender`, `contact`, `address`, `email`, `password`, `image_path`, `status`, `delete_flag`, `date_created`, `date_added`) VALUES
(1, 'Elizabeth', 'J.', 'Watson', 'Female', '1478555560', '85 Sycamore Lake Road', 'elizabeth@mail.com', '5f4dcc3b5aa765d61d8327deb882cf99', 'uploads/clients/1.png?v=1644995661', 1, 0, '2022-02-27 13:06:42', '2022-03-27 21:10:54'),
(2, 'Christine', 'M.', 'Moore', 'Female', '7412589666', '12 Bleck Street, PA', 'christine@mail.com', '5f4dcc3b5aa765d61d8327deb882cf99', 'uploads/clients/2.png?v=1648043485', 1, 0, '2022-03-01 19:36:24', '2022-03-27 21:10:40'),
(3, 'Luciano', 'B.', 'Fridley', 'Male', '7896585555', '372 Saint Marys Avenue', 'lsmith@mail.com', '5f4dcc3b5aa765d61d8327deb882cf99', NULL, 1, 0, '2022-03-01 13:13:38', '2022-03-27 21:11:06'),
(4, 'Matt', 'P.', 'Melton', 'Male', '4589658888', '870 School House Road', 'mattb@mail.com', '5f4dcc3b5aa765d61d8327deb882cf99', NULL, 1, 0, '2022-03-01 13:34:09', '2022-03-27 21:11:16'),
(5, 'James', 'P.', 'Luis', 'Male', '7850000010', '49 Poco Mas Drive', 'jamesp@mail.com', '5f4dcc3b5aa765d61d8327deb882cf99', NULL, 1, 0, '2022-03-01 13:39:25', '2022-03-27 21:11:28'),
(6, 'Timothy', 'E.', 'Maurer', 'Male', '1458965555', '75 Brannon Avenue', 'timothye@mail.com', '5f4dcc3b5aa765d61d8327deb882cf99', NULL, 1, 0, '2022-03-01 13:41:16', '2022-03-27 21:11:37'),
(7, 'Ebony', 'S.', 'Coulter', 'Female', '7850002145', '35 Simpson Street', 'ebonys@mail.com', '5f4dcc3b5aa765d61d8327deb882cf99', NULL, 1, 0, '2022-03-01 13:54:26', '2022-03-27 21:11:52'),
(8, 'Jason', 'F.', 'Billingsley', 'Male', '1458965555', '90 Jadewood Farms', 'jasonk@mail.com', '5f4dcc3b5aa765d61d8327deb882cf99', NULL, 1, 0, '2022-03-01 13:56:19', '2022-03-27 21:12:06'),
(9, 'Daniel', 'J.', 'Amos', 'Male', '4565550010', '77 Driftwood Road', 'daniel@mail.com', '5f4dcc3b5aa765d61d8327deb882cf99', NULL, 1, 0, '2022-03-01 13:59:54', '2022-03-27 21:12:17'),
(10, 'Edith', 'D.', 'Collins', 'Male', '1458965555', '90 Glory Road', 'edith@mail.com', '5f4dcc3b5aa765d61d8327deb882cf99', NULL, 1, 0, '2022-03-01 14:09:00', '2022-03-27 21:12:31'),
(11, 'Gina', 'J.', 'Bernard', 'Female', '1456854100', '41 Coulter Lane', 'ginac@mail.com', '5f4dcc3b5aa765d61d8327deb882cf99', NULL, 1, 0, '2022-03-01 14:14:37', '2022-03-27 21:12:47'),
(12, 'Thomas', 'J.', 'Greenwood', 'Male', '4569000010', '70 Elk Avenue', 'thomas@mail.com', '5f4dcc3b5aa765d61d8327deb882cf99', 'uploads/clients/12.png?v=1648370087', 1, 0, '2022-03-01 14:19:47', '2022-03-27 21:12:59'),
(13, 'Peter', 'J.', 'Fidley', 'Male', '1456985555', '42 Ridge Road', 'peter@mail.com', '5f4dcc3b5aa765d61d8327deb882cf99', NULL, 1, 0, '2022-03-27 21:10:14', NULL),
(14, 'John', 'H.', 'Hampton', 'Male', '4789652210', '50 Pooh Bear Lane', 'johnhm@mail.com', '5f4dcc3b5aa765d61d8327deb882cf99', NULL, 1, 0, '2022-03-27 22:20:32', NULL),
(15, 'Maria', 'J.', 'Connors', 'Female', '1478523655', '76 Richland Avenue', 'mariaj@mail.com', '5f4dcc3b5aa765d61d8327deb882cf99', NULL, 1, 0, '2022-03-27 22:21:08', NULL),
(16, 'Karen', 'M.', 'Brewer', 'Female', '1458888888', '591 Leisure Lane', 'karenb@mail.com', '5f4dcc3b5aa765d61d8327deb882cf99', NULL, 1, 0, '2022-03-27 22:21:53', NULL),
(17, 'Norma', 'K.', 'Gravelle', 'Female', '1458965555', '66 Blane Street', 'normak@mail.com', '5f4dcc3b5aa765d61d8327deb882cf99', NULL, 1, 0, '2022-03-27 22:24:54', NULL),
(18, 'aloka', 'sadaruwan', 'FDO', 'Male', '+7841415895', 'afawfaafafa', 'alokasadaruwan133@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', NULL, 1, 0, '2024-10-03 08:17:37', NULL),
(28, 'cc', 'cc', 'c', 'Male', '12312321', '8B54/R  N.H.S Raddolugamaafdfafawadfawda', 'alokasadaruadwadawwan166@gmail.com', NULL, NULL, 1, 0, '2024-10-16 19:18:27', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `last_login` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`id`, `username`, `firstname`, `lastname`, `password`, `last_login`) VALUES
(1, 'user1', 'John', 'Doe', '1234', '2024-10-17 09:09:31'),
(4, 'alokaa', 'alokaa', 'sadaruwana', '$2y$10$K2T8j6H4W47iWQ9nW4yZuODIgFQ2WxBrUQpCs5L5QppUOTW4whceK', '2024-10-17 09:02:00'),
(5, 'achini', 'achini', 'samarasekara', '$2y$10$oSfSU2YdJLCokYgOw6n8tennOssKUx0ZGXTgdKTMdor.8nawSav8K', '2024-10-17 09:02:00'),
(6, 'samare', 'samare', 'silwa', '$2y$10$AtDkbyTDtT72oeQSXlNb..KPkA.hobZ6S9R.aFlzpRUweX1PGkmL.', '2024-10-17 09:06:00'),
(7, 'samare123', 'samares', 'silwaa', '$2y$10$wLkfJvh5x6biLOdTcBC7R..bWeRI4q3jXB7kD.aepb6lYV7oF/KS.', '2024-10-10 09:06:00'),
(8, 'ww', 'ww', 'ee', '$2y$10$BhoIeHaLhTIyKRURzY87yeIuFXzzu9LLCFsig14A9AI64O.34Fexa', '2024-10-17 09:07:00');

-- --------------------------------------------------------

--
-- Table structure for table `system_info`
--

CREATE TABLE `system_info` (
  `id` int(30) NOT NULL,
  `meta_field` text NOT NULL,
  `meta_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `system_info`
--

INSERT INTO `system_info` (`id`, `meta_field`, `meta_value`) VALUES
(1, 'name', 'City Taxi (PVT) Ltd'),
(6, 'short_name', 'City Taxi (PVT) Ltd'),
(11, 'logo', 'uploads/1728527040_urban (1).png'),
(13, 'user_avatar', 'uploads/user_avatar.jpg'),
(14, 'cover', 'uploads/1728109920_3.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `firstname` varchar(250) NOT NULL,
  `lastname` varchar(250) NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `avatar` text DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `type` tinyint(1) NOT NULL DEFAULT 0,
  `date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `username`, `password`, `avatar`, `last_login`, `type`, `date_added`, `date_updated`) VALUES
(0, 'liyanage', 'wasantha', 'liyanage', '81dc9bdb52d04dc20036dbd8313ed055', NULL, NULL, 2, '2024-10-16 12:55:41', NULL),
(1, 'Administrator', 'Liam', 'admin', '81dc9bdb52d04dc20036dbd8313ed055', 'uploads/1624000_adminicn.png', NULL, 1, '2022-01-19 14:02:37', '2024-10-05 09:33:36'),
(8, 'Martha', 'Heath', 'martha', '81dc9bdb52d04dc20036dbd8313ed055', 'uploads/avatar-8.png?v=1648396920', NULL, 2, '2022-03-01 16:14:00', '2024-10-05 09:21:43'),
(9, 'Andrew', 'Stokes', 'andrew', '81dc9bdb52d04dc20036dbd8313ed055', 'uploads/avatar-9.png?v=1648396901', NULL, 2, '2022-03-27 21:46:41', '2024-10-05 09:21:43');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booking_list`
--
ALTER TABLE `booking_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cab_id` (`cab_id`),
  ADD KEY `client_id` (`client_id`);

--
-- Indexes for table `cab_list`
--
ALTER TABLE `cab_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `category_list`
--
ALTER TABLE `category_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `client_list`
--
ALTER TABLE `client_list`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `system_info`
--
ALTER TABLE `system_info`
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
-- AUTO_INCREMENT for table `booking_list`
--
ALTER TABLE `booking_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `cab_list`
--
ALTER TABLE `cab_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `category_list`
--
ALTER TABLE `category_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `client_list`
--
ALTER TABLE `client_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `system_info`
--
ALTER TABLE `system_info`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booking_list`
--
ALTER TABLE `booking_list`
  ADD CONSTRAINT `booking_list_ibfk_1` FOREIGN KEY (`cab_id`) REFERENCES `cab_list` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `booking_list_ibfk_2` FOREIGN KEY (`client_id`) REFERENCES `client_list` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cab_list`
--
ALTER TABLE `cab_list`
  ADD CONSTRAINT `cab_list_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category_list` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
