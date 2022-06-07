-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 07, 2022 at 10:10 AM
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
-- Table structure for table `tata_addons_fw`
--

CREATE TABLE `tata_addons_fw` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `applicable_ncb` varchar(255) NOT NULL,
  `applicable_non_ncb` varchar(255) NOT NULL,
  `bundle` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tata_addons_fw`
--

INSERT INTO `tata_addons_fw` (`id`, `name`, `applicable_ncb`, `applicable_non_ncb`, `bundle`) VALUES
(1, 'Depreciation reimbursement', '-7 years -8 months -26 days', '-5 years -8 months -27days', 'P3'),
(2, 'Loss of Personal belongings (IDV)', '-7 years -8 months -26 days', '-5 years -8 months -27days', 'P2'),
(3, 'Emergency transport and Hotel expenses (IDV)', '-7 years -8 months -26 days', '-5 years -8 months -27days', 'P2'),
(4, 'Key Replacement', '-7 years -8 months -26 days', '-5 years -8 months -27days', 'P2'),
(5, 'Engine Secure', '-7 years -8 months -26 days', '-5 years -8 months -27days', 'P6'),
(6, 'Consumables expenses', '-7 years -8 months -26 days', '-5 years -8 months -27 days', 'P6'),
(7, 'Repair of glass, plastic fibre and rubber glass', '', '', 'P1'),
(8, 'Tyre Secure', '-7 years -8 months -26 days', '-5 years -8 months -27days', 'P6'),
(9, 'NCB protection cover', '-15 years -8 months -24 days', '', ''),
(10, 'Roadside Assistance', '-15 years -8 months -24 days', '-10 years -8 months -25 days', 'P6'),
(11, 'Return to Invoice', '-3 years -8 months -27 days', '-3 years -8 months -27 days', 'P7'),
(12, 'Daily Allowance', '', '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tata_addons_fw`
--
ALTER TABLE `tata_addons_fw`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tata_addons_fw`
--
ALTER TABLE `tata_addons_fw`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
