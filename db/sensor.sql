-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 28, 2018 at 02:10 PM
-- Server version: 5.6.26
-- PHP Version: 5.6.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `monitor`
--

-- --------------------------------------------------------

--
-- Table structure for table `sensor`
--

DROP TABLE IF EXISTS `sensor`;
CREATE TABLE IF NOT EXISTS `sensor` (
  `id` int(11) NOT NULL,
  `stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `number` smallint(3) NOT NULL COMMENT 'unique number identifies each sensor',
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT 'friendly name for display to the user',
  `type` set('T','H','P','L','') COLLATE utf8_unicode_ci NOT NULL COMMENT 'type of data that the sensor can return',
  `active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `sensor`
--

INSERT INTO `sensor` (`id`, `stamp`, `number`, `name`, `type`, `active`) VALUES
(1, '2018-02-12 02:22:13', 1, 'electronics', 'T,H', 1),
(2, '2018-02-12 02:23:06', 2, 'workshop', 'T', 1),
(3, '2018-02-16 23:47:06', 3, 'garage', 'T,H', 1),
(4, '2018-02-24 02:18:12', 4, 'BME280', 'T,H,P', 1),
(5, '2018-04-07 00:00:03', 101, 'Photocell', 'L', 0),
(6, '2018-04-07 00:00:03', 102, 'PhotoTransistor', 'L', 0),
(11, '2018-04-07 00:02:09', 103, 'TSL2561-Vis', 'L', 1),
(12, '2018-04-07 00:02:09', 104, 'TSL2561-IR', 'L', 1),
(13, '2018-04-07 00:03:37', 105, 'TSL2561SF-1', 'L', 1),
(14, '2018-04-07 00:03:37', 106, 'TSL2561SF-2', 'L', 1),
(15, '2018-04-07 00:04:29', 107, 'TSL2591-Vis', 'L', 0),
(16, '2018-04-07 00:04:29', 108, 'TSL2591-IR', 'L', 0),
(17, '2018-04-07 00:05:06', 109, 'GA1A12S', 'L', 1),
(18, '2018-04-07 00:05:06', 110, 'ALSPT19', 'L', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `sensor`
--
ALTER TABLE `sensor`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `number` (`number`),
  ADD UNIQUE KEY `number_2` (`number`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `sensor`
--
ALTER TABLE `sensor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=19;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
