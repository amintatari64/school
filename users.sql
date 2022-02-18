-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 16, 2022 at 05:50 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `users`
--

-- --------------------------------------------------------

--
-- Table structure for table `info`
--

CREATE TABLE `info` (
  `id` int(6) UNSIGNED NOT NULL,
  `fname` varchar(30) COLLATE utf8_persian_ci NOT NULL,
  `lname` varchar(30) COLLATE utf8_persian_ci NOT NULL,
  `code` int(10) NOT NULL,
  `access` varchar(30) COLLATE utf8_persian_ci NOT NULL,
  `class` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `info`
--

INSERT INTO `info` (`id`, `fname`, `lname`, `code`, `access`, `class`) VALUES
(1, 'محمدامین', 'فلانی', 987654321, 'admin', 0),
(11, 'محمد', 'علی', 123456789, 'teacher', 0),
(35, 'محمد', 'فلانی', 1234567890, 'student', 903);

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `id` int(6) UNSIGNED NOT NULL,
  `send_code` int(12) NOT NULL,
  `receiv_code` int(12) NOT NULL,
  `txt` varchar(500) COLLATE utf8_persian_ci NOT NULL,
  `ifread` varchar(10) COLLATE utf8_persian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`id`, `send_code`, `receiv_code`, `txt`, `ifread`) VALUES
(17, 1234567890, 987654321, 'fcgdgtdftgfd', 'yes'),
(18, 1234567890, 987654321, 'dfgfdffgdfgg', 'yes'),
(19, 1234567890, 987654321, 'ghghghhhhhhhhhhhhhhh', 'yes'),
(21, 1234567890, 987654321, 'ljkljljlk', 'yes'),
(22, 1234567890, 987654321, 'ghjgjghjhjjghgjjjjjjjjjjjj', 'yes'),
(23, 1234567890, 987654321, 'ghjghjh', 'yes'),
(24, 1234567890, 987654321, 'gjggjjhhhhjjj', 'yes'),
(38, 987654321, 1234567890, 'mohammad amin tatari hastam', 'yes');

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `id` int(6) UNSIGNED NOT NULL,
  `send_code` int(12) NOT NULL,
  `receive` varchar(30) COLLATE utf8_persian_ci NOT NULL,
  `title` varchar(50) COLLATE utf8_persian_ci NOT NULL,
  `txt` varchar(500) COLLATE utf8_persian_ci NOT NULL,
  `date` varchar(20) COLLATE utf8_persian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `score`
--

CREATE TABLE `score` (
  `id` int(6) UNSIGNED NOT NULL,
  `code` int(10) NOT NULL,
  `class` int(10) NOT NULL,
  `lesson` varchar(50) COLLATE utf8_persian_ci NOT NULL,
  `score` int(35) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `info`
--
ALTER TABLE `info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `score`
--
ALTER TABLE `score`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `info`
--
ALTER TABLE `info`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `score`
--
ALTER TABLE `score`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
