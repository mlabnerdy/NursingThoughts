-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 21, 2025 at 07:19 PM
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
-- Database: `nursingthoughts`
--

-- --------------------------------------------------------

--
-- Table structure for table `scores`
--

CREATE TABLE `scores` (
  `score_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `score` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `scores`
--

INSERT INTO `scores` (`score_id`, `user_id`, `subject_id`, `score`) VALUES
(44, 3, 1, 6),
(47, 3, 2, 7),
(48, 3, 4, 6),
(49, 3, 3, 4),
(50, 3, 5, 4),
(51, 3, 6, 6),
(52, 3, 7, 7),
(54, 4, 2, 6),
(55, 4, 1, 3),
(56, 5, 1, 5),
(57, 5, 2, 7);

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `subject_id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`subject_id`, `name`) VALUES
(7, 'Anatomy and Physiology'),
(3, 'Bio-Ethics'),
(9, 'Community Health Nursing'),
(2, 'Fundamentals in Nursing'),
(10, 'Health Assessment'),
(8, 'Maternal and Child'),
(6, 'Medical Terminologies'),
(4, 'Nutrition and Diet Therapy'),
(5, 'Pharmacology'),
(1, 'RABE'),
(11, 'Theoretical Foundation of Nursing');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `schoolID` varchar(50) DEFAULT NULL,
  `fullName` varchar(100) DEFAULT NULL,
  `YrLvl` varchar(10) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password_hash` varchar(255) DEFAULT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `token_expiry` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `schoolID`, `fullName`, `YrLvl`, `email`, `password_hash`, `reset_token`, `token_expiry`) VALUES
(3, '11-2345', 'Lucky Boi', '1', 'pogiako123@gmail.com', '$2y$10$8ib8ONaY23wMXEXxkgeNAu7N2jqEUYQC8juSThGKPG3sJa3g.grMK', NULL, NULL),
(4, '11-2233', 'Pogi Ako Diba', '3rd year', 'pogipogi123@gmail.com', '$2y$10$qh7JWXx6UbDYcZivx6SBSuhjXVUdOULi6tSTX8Qg/iPo9leVzIBCG', NULL, NULL),
(5, '22-0246', 'ganda', '3rd year', 'gandamo@gmail.com', '$2y$10$dhBZ9KO/hhT7yMYtEInKv.3/2pN6CsELlE6YYbp8likUltFLbKfLK', NULL, NULL),
(6, '11-3451', 'Mister Pogi', '1st year', 'luckykogu@gmail.com', '$2y$10$Jpo8QxeQGfOcMnTckubwyOjEwXxW1j9LP3f/ebLYTvQCHqKfuoKSO', 'f775f42e7051df7b57d15cef910caa35f7dd29bdd2ac41db191b7d256130eae6', '2025-04-22 01:25:32'),
(7, '30-3333', 'pogipogi', '3rd year', 'pogiakodiba@gmail.com', '$2y$10$DZIBMal.O4vSYlAf/LJsae7Q4mNP1KOPaasaUEm2yc7AzLEQChmla', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `scores`
--
ALTER TABLE `scores`
  ADD PRIMARY KEY (`score_id`),
  ADD UNIQUE KEY `unique_user_subject` (`user_id`,`subject_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `subject_id` (`subject_id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`subject_id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `scores`
--
ALTER TABLE `scores`
  MODIFY `score_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `subject_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `scores`
--
ALTER TABLE `scores`
  ADD CONSTRAINT `scores_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `scores_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`subject_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
