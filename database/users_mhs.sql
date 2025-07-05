-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 17, 2025 at 02:59 PM
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
-- Database: `e_portofolio`
--

-- --------------------------------------------------------

--
-- Table structure for table `users_mhs`
--

CREATE TABLE `users_mhs` (
  `id` int(11) NOT NULL,
  `nim` bigint(20) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan','','') NOT NULL,
  `fakultas` varchar(100) NOT NULL,
  `program_studi` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users_mhs`
--

INSERT INTO `users_mhs` (`id`, `nim`, `nama_lengkap`, `tanggal_lahir`, `jenis_kelamin`, `fakultas`, `program_studi`, `password`) VALUES
(12, 2330511106, 'Danies Syabian Saputra', '2004-09-29', 'Laki-laki', 'Sains dan Teknologi', 'S1 Teknik Informatika', '240be518fabd2724ddb6f04eeb1da5967448d7e831c08c8fa822809f74c720a9');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users_mhs`
--
ALTER TABLE `users_mhs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nim` (`nim`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users_mhs`
--
ALTER TABLE `users_mhs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
