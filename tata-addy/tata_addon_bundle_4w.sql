-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 21, 2022 at 04:00 PM
-- Server version: 5.7.30-33
-- PHP Version: 7.4.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bimabuyuat`
--

-- --------------------------------------------------------

--
-- Table structure for table `tata_addon_bundle_4w`
--

CREATE TABLE `tata_addon_bundle_4w` (
  `id` int(11) NOT NULL,
  `plan_id` varchar(10) NOT NULL,
  `plan_name` varchar(255) NOT NULL,
  `arr` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tata_addon_bundle_4w`
--

INSERT INTO `tata_addon_bundle_4w` (`id`, `plan_id`, `plan_name`, `arr`) VALUES
(1, 'P1', 'SILVER', '[7]'),
(2, 'P2', 'GOLD', '[2,3,4,7,10]'),
(3, 'P3', 'PEARL', '[1,2,3,4,7,10]'),
(4, 'P4', 'PEARL+', '[1,2,3,4,5,6,7,10]'),
(5, 'P5', 'SAPPHIRE', '[1,2,3,4,6,7,8,10]'),
(6, 'P6', 'SAPPHIREPLUS', '[1,2,3,4,5,6,7,8,10]'),
(7, 'P7', 'SAPPHIRE++', '[1,2,3,4,5,6,7,8,10,11]'),
(8, 'P10', 'PLATINUM', '[1,2,3,4,5,7,10,11]'),
(9, 'P11', 'CORAL', '[1,2,3,4,6,7,10]'),
(10, 'P12', 'PEARL++', '[1,2,3,4,5,6,7,10,11]');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tata_addon_bundle_4w`
--
ALTER TABLE `tata_addon_bundle_4w`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tata_addon_bundle_4w`
--
ALTER TABLE `tata_addon_bundle_4w`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
