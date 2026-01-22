-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 22, 2026 at 02:49 PM
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
-- Database: `puskesmas`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(5) NOT NULL,
  `nama_admin` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `start_time_admin` time NOT NULL,
  `end_time_admin` time NOT NULL,
  `level` enum('pendaftaran','pemeriksaan','apoteker','admin','superadmin') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `nama_admin`, `password`, `start_time_admin`, `end_time_admin`, `level`) VALUES
(1, 'super', '$2y$10$4OvKGUWayf3rOibp1bu0X.nS0K6UCEOg6YmuNYa2Sk1desYVd67hC', '00:00:00', '24:00:00', 'superadmin'),
(2, 'Yesaya', '$2y$10$2wG3tv3UluuJmEm7gWrxRO.kxPS0FtyxDH22i7bJdPnjKnGjs7N8K', '00:00:00', '23:59:00', 'pendaftaran'),
(3, 'Teofilus', '$2y$10$2wG3tv3UluuJmEm7gWrxRO.kxPS0FtyxDH22i7bJdPnjKnGjs7N8K', '00:00:00', '23:59:00', 'pemeriksaan'),
(5, 'Hendrawan', '$2y$10$2wG3tv3UluuJmEm7gWrxRO.kxPS0FtyxDH22i7bJdPnjKnGjs7N8K', '00:00:00', '23:59:00', 'apoteker'),
(6, 'admin', '$2y$10$Wiyq5gT50ROOzm.CWY1GjO3x3pnpVs4MGAlHxM0UI7WRQ3QcEiqRy', '01:00:00', '23:12:00', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
