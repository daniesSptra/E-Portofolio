-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 16, 2025 at 04:47 AM
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
-- Table structure for table `certificates`
--

CREATE TABLE `certificates` (
  `id_certificate` int(11) NOT NULL,
  `id_profile` int(11) NOT NULL,
  `certificate_thumbnail` varchar(255) DEFAULT NULL,
  `certificate_link` varchar(255) DEFAULT NULL,
  `certificate_description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `communication_languages`
--

CREATE TABLE `communication_languages` (
  `id_communication` int(11) NOT NULL,
  `id_profile` int(11) NOT NULL,
  `language` varchar(100) DEFAULT NULL,
  `level` enum('Beginner','Intermediate','Advanced') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `experience`
--

CREATE TABLE `experience` (
  `id_experience` int(11) NOT NULL,
  `id_profile` int(11) NOT NULL,
  `lokasi` varchar(100) NOT NULL DEFAULT '''-''',
  `deskripsi` text NOT NULL DEFAULT '\'-\''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hardskills`
--

CREATE TABLE `hardskills` (
  `id_hardskills` int(11) NOT NULL,
  `id_profile` int(11) NOT NULL,
  `skill` varchar(255) DEFAULT '''-'''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id_languages` int(11) NOT NULL,
  `id_profile` int(11) NOT NULL,
  `language_prog` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `profile`
--

CREATE TABLE `profile` (
  `id_profile` int(11) NOT NULL,
  `nim` bigint(20) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `no_telepon` varchar(20) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `asal_sekolah` varchar(100) DEFAULT NULL,
  `ipk` float(3,2) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id_projects` int(11) NOT NULL,
  `id_profile` int(11) NOT NULL,
  `project_name` varchar(100) DEFAULT NULL,
  `project_thumb` varchar(100) DEFAULT NULL,
  `project_link` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `softskills`
--

CREATE TABLE `softskills` (
  `id_softskills` int(11) NOT NULL,
  `id_profile` int(11) NOT NULL,
  `skill` varchar(255) DEFAULT '''-'''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tools`
--

CREATE TABLE `tools` (
  `id_tools` int(11) NOT NULL,
  `id_profile` int(11) NOT NULL,
  `tool` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- Indexes for dumped tables
--

--
-- Indexes for table `certificates`
--
ALTER TABLE `certificates`
  ADD PRIMARY KEY (`id_certificate`),
  ADD KEY `id_profile` (`id_profile`);

--
-- Indexes for table `communication_languages`
--
ALTER TABLE `communication_languages`
  ADD PRIMARY KEY (`id_communication`),
  ADD KEY `id_profile` (`id_profile`);

--
-- Indexes for table `experience`
--
ALTER TABLE `experience`
  ADD PRIMARY KEY (`id_experience`),
  ADD KEY `id_profile` (`id_profile`);

--
-- Indexes for table `hardskills`
--
ALTER TABLE `hardskills`
  ADD PRIMARY KEY (`id_hardskills`),
  ADD KEY `id_profile` (`id_profile`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id_languages`),
  ADD KEY `id_profile` (`id_profile`);

--
-- Indexes for table `profile`
--
ALTER TABLE `profile`
  ADD PRIMARY KEY (`id_profile`),
  ADD UNIQUE KEY `nim` (`nim`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id_projects`),
  ADD KEY `id_profile` (`id_profile`);

--
-- Indexes for table `softskills`
--
ALTER TABLE `softskills`
  ADD PRIMARY KEY (`id_softskills`),
  ADD KEY `id_profile` (`id_profile`);

--
-- Indexes for table `tools`
--
ALTER TABLE `tools`
  ADD PRIMARY KEY (`id_tools`),
  ADD KEY `id_profile` (`id_profile`);

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
-- AUTO_INCREMENT for table `certificates`
--
ALTER TABLE `certificates`
  MODIFY `id_certificate` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `communication_languages`
--
ALTER TABLE `communication_languages`
  MODIFY `id_communication` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `experience`
--
ALTER TABLE `experience`
  MODIFY `id_experience` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `hardskills`
--
ALTER TABLE `hardskills`
  MODIFY `id_hardskills` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id_languages` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `profile`
--
ALTER TABLE `profile`
  MODIFY `id_profile` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id_projects` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `softskills`
--
ALTER TABLE `softskills`
  MODIFY `id_softskills` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `tools`
--
ALTER TABLE `tools`
  MODIFY `id_tools` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `users_mhs`
--
ALTER TABLE `users_mhs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `certificates`
--
ALTER TABLE `certificates`
  ADD CONSTRAINT `certificates_ibfk_1` FOREIGN KEY (`id_profile`) REFERENCES `profile` (`id_profile`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `communication_languages`
--
ALTER TABLE `communication_languages`
  ADD CONSTRAINT `communication_languages_ibfk_1` FOREIGN KEY (`id_profile`) REFERENCES `profile` (`id_profile`) ON DELETE CASCADE;

--
-- Constraints for table `experience`
--
ALTER TABLE `experience`
  ADD CONSTRAINT `experience_ibfk_1` FOREIGN KEY (`id_profile`) REFERENCES `profile` (`id_profile`) ON DELETE CASCADE;

--
-- Constraints for table `hardskills`
--
ALTER TABLE `hardskills`
  ADD CONSTRAINT `hardskills_ibfk_1` FOREIGN KEY (`id_profile`) REFERENCES `profile` (`id_profile`) ON DELETE CASCADE;

--
-- Constraints for table `languages`
--
ALTER TABLE `languages`
  ADD CONSTRAINT `languages_ibfk_1` FOREIGN KEY (`id_profile`) REFERENCES `profile` (`id_profile`) ON DELETE CASCADE;

--
-- Constraints for table `profile`
--
ALTER TABLE `profile`
  ADD CONSTRAINT `profile_ibfk_1` FOREIGN KEY (`nim`) REFERENCES `users_mhs` (`nim`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `projects`
--
ALTER TABLE `projects`
  ADD CONSTRAINT `projects_ibfk_1` FOREIGN KEY (`id_profile`) REFERENCES `profile` (`id_profile`) ON DELETE CASCADE;

--
-- Constraints for table `softskills`
--
ALTER TABLE `softskills`
  ADD CONSTRAINT `softskills_ibfk_1` FOREIGN KEY (`id_profile`) REFERENCES `profile` (`id_profile`) ON DELETE CASCADE;

--
-- Constraints for table `tools`
--
ALTER TABLE `tools`
  ADD CONSTRAINT `tools_ibfk_1` FOREIGN KEY (`id_profile`) REFERENCES `profile` (`id_profile`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
