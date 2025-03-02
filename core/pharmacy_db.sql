-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 02, 2025 at 01:03 PM
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
-- Database: `pharmacy_db`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `get_all_pharmacy` ()   SELECT
*
FROM pharmacy
WHERE `pharmacy_name` != 'null'$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_all_users` ()   SELECT
*
FROM users WHERE role != 'admin'$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_user_reminder` (IN `user_id` INT)   SELECT
r.id AS 'reminder_id',
r.reminder_time,
r.phar_name,
m.medicine_name,
m.quantity,
m.price,
m.img,
m.exp_date
FROM reminder r
INNER JOIN medicines m ON r.med_id=m.id
WHERE r.user_id=user_id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `medicines_list` ()   SELECT
m.id AS 'med_id',
m.medicine_name,
m.quantity,
m.price,
m.img,
m.exp_date,
u.id AS 'u_id',
u.username,
u.phar_id AS 'phr_id',
p.pharmacy_name
FROM medicines m
INNER JOIN users u ON m.user_id=u.id
INNER JOIN pharmacy p ON u.phar_id=p.id
ORDER BY m.medicine_name ASC$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `medicines_list_by_user` (IN `user_id` INT)   SELECT
*
FROM medicines m
WHERE m.user_id=user_id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `medicines_list_recent` ()   SELECT
m.id AS 'med_id',
m.medicine_name,
m.quantity,
m.price,
m.img,
m.exp_date,
u.id AS 'u_id',
u.username,
u.phar_id AS 'phr_id',
p.pharmacy_name
FROM medicines m
INNER JOIN users u ON m.user_id=u.id
INNER JOIN pharmacy p ON u.phar_id=p.id
ORDER BY m.id DESC LIMIT 4$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `medicines`
--

CREATE TABLE `medicines` (
  `id` int(11) NOT NULL,
  `medicine_name` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` int(11) DEFAULT NULL,
  `img` text DEFAULT NULL,
  `exp_date` date NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `medicines`
--

INSERT INTO `medicines` (`id`, `medicine_name`, `quantity`, `price`, `img`, `exp_date`, `user_id`) VALUES
(7, 'Adderall', 8, 5, './img/medicine/Adderall.png', '2025-03-05', 17),
(9, 'Entresto', 10, 9, './img/medicine/Entresto.png', '2025-03-05', 16),
(10, 'Amlodipine', 8, 25, './img/medicine/Amlodipine_Besylate.png', '2025-03-13', 16);

-- --------------------------------------------------------

--
-- Table structure for table `pharmacy`
--

CREATE TABLE `pharmacy` (
  `id` int(11) NOT NULL,
  `pharmacy_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pharmacy`
--

INSERT INTO `pharmacy` (`id`, `pharmacy_name`) VALUES
(1, 'Bartell Drugs'),
(2, 'Boone Drug'),
(999, 'null');

-- --------------------------------------------------------

--
-- Table structure for table `reminder`
--

CREATE TABLE `reminder` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `med_id` int(11) NOT NULL,
  `phar_name` varchar(255) DEFAULT NULL,
  `reminder_time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` text NOT NULL,
  `role` enum('admin','patient','pharmacist') NOT NULL DEFAULT 'patient',
  `phone` varchar(255) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `address` text DEFAULT NULL,
  `diseases` varchar(255) DEFAULT NULL,
  `experience` varchar(255) DEFAULT NULL,
  `phar_id` int(11) DEFAULT NULL,
  `reminder_ids` text DEFAULT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `phone`, `dob`, `address`, `diseases`, `experience`, `phar_id`, `reminder_ids`, `status`) VALUES
(1, 'admin', 'admin@gmail.com', '4297f44b13955235245b2497399d7a93', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1'),
(15, 'patient', 'patient@gmail.com', '4297f44b13955235245b2497399d7a93', 'patient', '12312345', '2025-02-15', 'asdasd', 'Tooth Issue.', '', 999, NULL, '1'),
(16, 'pharmacist', 'pharmacist@gmail.com', '4297f44b13955235245b2497399d7a93', 'pharmacist', '123123456', '2017-07-06', 'hey', '', '10 years of experience', 1, NULL, '1'),
(17, 'pharmacist2', 'pharmacist2@gmail.com', '4297f44b13955235245b2497399d7a93', 'pharmacist', '123123456', '2017-07-06', 'hey', '', '10 years of experience', 2, NULL, '1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `medicines`
--
ALTER TABLE `medicines`
  ADD PRIMARY KEY (`id`),
  ADD KEY `phar_id` (`user_id`);

--
-- Indexes for table `pharmacy`
--
ALTER TABLE `pharmacy`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reminder`
--
ALTER TABLE `reminder`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `reminder_ibfk_2` (`med_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `phar_id` (`phar_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `medicines`
--
ALTER TABLE `medicines`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `pharmacy`
--
ALTER TABLE `pharmacy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1001;

--
-- AUTO_INCREMENT for table `reminder`
--
ALTER TABLE `reminder`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `medicines`
--
ALTER TABLE `medicines`
  ADD CONSTRAINT `medicines_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `reminder`
--
ALTER TABLE `reminder`
  ADD CONSTRAINT `reminder_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `reminder_ibfk_2` FOREIGN KEY (`med_id`) REFERENCES `medicines` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`phar_id`) REFERENCES `pharmacy` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
