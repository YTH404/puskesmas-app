-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 07, 2025 at 02:36 PM
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
(1, 'super', '12345678', '00:00:00', '24:00:00', 'superadmin'),
(2, 'Yesaya', '12345678', '00:00:00', '23:59:00', 'pendaftaran'),
(3, 'Teofilus', '12345678', '00:00:00', '23:59:00', 'pemeriksaan'),
(5, 'Hendrawan', '12345678', '00:00:00', '23:59:00', 'apoteker'),
(6, 'admin', '12345678', '00:00:00', '24:00:00', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `dokter`
--

CREATE TABLE `dokter` (
  `id_dokter` int(11) NOT NULL,
  `nama_dokter` varchar(100) NOT NULL,
  `spesialis` varchar(100) NOT NULL,
  `no_hp_dokter` varchar(13) NOT NULL,
  `start_time_dokter` time NOT NULL,
  `end_time_dokter` time NOT NULL,
  `alamat_dokter` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `dokter`
--

INSERT INTO `dokter` (`id_dokter`, `nama_dokter`, `spesialis`, `no_hp_dokter`, `start_time_dokter`, `end_time_dokter`, `alamat_dokter`) VALUES
(1, 'Dr. Fufu Fafa', 'Anak', '081122223333', '00:00:00', '04:00:00', 'cigondewah'),
(2, 'Dr. Idham', 'Kandungan', '082233334444', '04:00:00', '23:00:00', 'rancaekek');

-- --------------------------------------------------------

--
-- Table structure for table `pasien`
--

CREATE TABLE `pasien` (
  `id_pasien` int(5) NOT NULL,
  `nama_pasien` varchar(100) NOT NULL,
  `nama_ibu` varchar(100) NOT NULL,
  `jenis_kelamin` varchar(10) NOT NULL,
  `golongan_darah` varchar(5) NOT NULL,
  `tgl_lahir` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pasien`
--

INSERT INTO `pasien` (`id_pasien`, `nama_pasien`, `nama_ibu`, `jenis_kelamin`, `golongan_darah`, `tgl_lahir`) VALUES
(1, 'Andika', 'Ibu Andika', 'Laki-laki', 'A', '2025-12-02'),
(2, 'Idham', 'Ibu Idham', 'Laki-laki', 'B', '2025-12-02');

-- --------------------------------------------------------

--
-- Table structure for table `pemeriksaan`
--

CREATE TABLE `pemeriksaan` (
  `id_pemeriksaan` int(11) NOT NULL,
  `id_pendaftaran` int(11) NOT NULL,
  `id_dokter` int(11) NOT NULL,
  `waktu_periksa` datetime NOT NULL,
  `obat` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pemeriksaan`
--

INSERT INTO `pemeriksaan` (`id_pemeriksaan`, `id_pendaftaran`, `id_dokter`, `waktu_periksa`, `obat`) VALUES
(1, 1, 1, '2025-12-03 22:53:00', 'Paracetamol'),
(2, 2, 1, '2025-12-03 22:53:00', '');

-- --------------------------------------------------------

--
-- Table structure for table `pendaftaran`
--

CREATE TABLE `pendaftaran` (
  `id_pendaftaran` int(11) NOT NULL,
  `id_pasien` int(11) NOT NULL,
  `keluhan` varchar(200) NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pendaftaran`
--

INSERT INTO `pendaftaran` (`id_pendaftaran`, `id_pasien`, `keluhan`, `status`) VALUES
(1, 1, 'Sakit Kepala', 'Selesai'),
(2, 1, 'Sakit Kaki', 'Diperiksa'),
(3, 2, 'Sakit Tangan', 'Menunggu'),
(4, 2, 'Sakit Perut', 'Menunggu');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indexes for table `dokter`
--
ALTER TABLE `dokter`
  ADD PRIMARY KEY (`id_dokter`);

--
-- Indexes for table `pasien`
--
ALTER TABLE `pasien`
  ADD PRIMARY KEY (`id_pasien`);

--
-- Indexes for table `pemeriksaan`
--
ALTER TABLE `pemeriksaan`
  ADD PRIMARY KEY (`id_pemeriksaan`);

--
-- Indexes for table `pendaftaran`
--
ALTER TABLE `pendaftaran`
  ADD PRIMARY KEY (`id_pendaftaran`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `dokter`
--
ALTER TABLE `dokter`
  MODIFY `id_dokter` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pasien`
--
ALTER TABLE `pasien`
  MODIFY `id_pasien` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pemeriksaan`
--
ALTER TABLE `pemeriksaan`
  MODIFY `id_pemeriksaan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pendaftaran`
--
ALTER TABLE `pendaftaran`
  MODIFY `id_pendaftaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pemeriksaan`
--
ALTER TABLE `pemeriksaan`
  ADD CONSTRAINT `pemeriksaan_ibfk_1` FOREIGN KEY (`id_pendaftaran`) REFERENCES `pendaftaran` (`id_pendaftaran`),
  ADD CONSTRAINT `pemeriksaan_ibfk_2` FOREIGN KEY (`id_dokter`) REFERENCES `dokter` (`id_dokter`);

--
-- Constraints for table `pendaftaran`
--
ALTER TABLE `pendaftaran`
  ADD CONSTRAINT `pendaftaran_ibfk_1` FOREIGN KEY (`id_pasien`) REFERENCES `pasien` (`id_pasien`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
