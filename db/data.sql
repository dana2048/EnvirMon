-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 28, 2018 at 02:06 PM
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
-- Table structure for table `data`
--

DROP TABLE IF EXISTS `data`;
CREATE TABLE IF NOT EXISTS `data` (
  `id` int(11) NOT NULL,
  `stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `sensor` smallint(3) NOT NULL,
  `pressure` float DEFAULT NULL,
  `humidity` float DEFAULT NULL,
  `temperature` float DEFAULT NULL,
  `luminance` float DEFAULT NULL,
  `year` smallint(6) DEFAULT NULL,
  `month` tinyint(4) DEFAULT NULL,
  `day` tinyint(4) DEFAULT NULL,
  `hour` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=356932 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `data`
--

INSERT INTO `data` (`id`, `stamp`, `sensor`, `pressure`, `humidity`, `temperature`, `luminance`, `year`, `month`, `day`, `hour`) VALUES
(1, '2018-02-10 03:07:00', 2, NULL, NULL, 66.2, NULL, 2018, 2, 9, 22),
(2, '2018-02-10 03:07:00', 2, NULL, NULL, 66.2, NULL, 2018, 2, 9, 22),
(3, '2018-02-10 03:07:02', 1, NULL, NULL, 64.04, NULL, 2018, 2, 9, 22),
(4, '2018-02-10 03:07:10', 2, NULL, NULL, 66.2, NULL, 2018, 2, 9, 22),
(5, '2018-02-10 03:07:12', 1, NULL, NULL, 64.04, NULL, 2018, 2, 9, 22),
(6, '2018-02-10 03:07:20', 2, NULL, NULL, 66.2, NULL, 2018, 2, 9, 22),
(7, '2018-02-10 03:07:22', 1, NULL, NULL, 64.04, NULL, 2018, 2, 9, 22),
(8, '2018-02-10 03:07:30', 2, NULL, NULL, 66.2, NULL, 2018, 2, 9, 22),
(9, '2018-02-10 03:07:32', 1, NULL, NULL, 64.04, NULL, 2018, 2, 9, 22);

--
-- Triggers `data`
--
DROP TRIGGER IF EXISTS `data_BEFORE_INSERT`;
DELIMITER $$
CREATE TRIGGER `data_BEFORE_INSERT` BEFORE INSERT ON `data`
 FOR EACH ROW BEGIN
	SET new.stamp=now();
	SET new.year=YEAR(new.stamp),
		new.month=MONTH(new.stamp),
		new.day=DAY(new.stamp),
		new.hour=HOUR(new.stamp);
END
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `data`
--
ALTER TABLE `data`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sensor` (`sensor`),
  ADD KEY `YMDH` (`year`,`month`,`day`,`hour`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `data`
--
ALTER TABLE `data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=356932;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
