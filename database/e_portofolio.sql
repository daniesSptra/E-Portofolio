-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 05, 2025 at 11:06 PM
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

--
-- Dumping data for table `communication_languages`
--

INSERT INTO `communication_languages` (`id_communication`, `id_profile`, `language`, `level`) VALUES
(6, 14, 'Indonesia', 'Beginner'),
(8, 16, 'Indonesia', 'Advanced'),
(24, 17, 'Indonesia', 'Advanced'),
(25, 17, 'Inggris', 'Beginner'),
(26, 17, 'Jepang', 'Intermediate'),
(29, 12, 'Indonesia', 'Advanced'),
(30, 12, 'Inggris', 'Beginner');

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

--
-- Dumping data for table `experience`
--

INSERT INTO `experience` (`id_experience`, `id_profile`, `lokasi`, `deskripsi`) VALUES
(4, 14, '', ''),
(6, 16, '', ''),
(17, 17, 'PT Informasi Digital - Magang (1 Novermber 2023 - 2 Januari 2024) ', 'Mengelola dan perawatan Sistem Jaringan'),
(18, 17, 'Himpunan Mahasiswa Informatika - Divisi PSDM (periode 2023 - 2024)', 'Meningkatkan Sumber Daya manusiwa dalam membangun mahasiswa yang siap masuk ke dunia yang profesional'),
(20, 12, 'PT ABC ABADI - Magang(2021-2022)', 'Melakukan Manajemen Data Barang');

-- --------------------------------------------------------

--
-- Table structure for table `hardskills`
--

CREATE TABLE `hardskills` (
  `id_hardskills` int(11) NOT NULL,
  `id_profile` int(11) NOT NULL,
  `skill` varchar(255) DEFAULT '''-'''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hardskills`
--

INSERT INTO `hardskills` (`id_hardskills`, `id_profile`, `skill`) VALUES
(6, 14, 'Desain Grafis'),
(8, 16, 'Ui/Ux'),
(16, 17, 'Data Analis'),
(19, 12, 'Front-End'),
(20, 12, 'Backend');

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id_languages` int(11) NOT NULL,
  `id_profile` int(11) NOT NULL,
  `language_prog` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id_languages`, `id_profile`, `language_prog`) VALUES
(7, 14, 'HTML'),
(9, 16, ''),
(34, 17, 'HTML5'),
(35, 17, 'CSS3'),
(36, 17, 'Javascript'),
(37, 17, 'python'),
(38, 17, 'typescript'),
(42, 12, 'Javascript'),
(43, 12, 'Python');

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

--
-- Dumping data for table `profile`
--

INSERT INTO `profile` (`id_profile`, `nim`, `email`, `no_telepon`, `alamat`, `asal_sekolah`, `ipk`, `foto`) VALUES
(12, 2330511106, 'danies106@ummi.ac.id', '085846421151', 'Kabupaten Sukabumi', 'SMK DWIWARNA', 3.78, '678a78533782b.jpg'),
(14, 2330311041, 'erginihbos33@gmail.com', '081234567678', 'Japang Kulon', 'SMAN 1 Jampangkulon', 3.50, '678aa6393c00d.jpg'),
(16, 2330511107, 'endass222@gmail.com', '081234567678', 'pcibadak', 'SMKN 1 CIBADAK', 3.58, '678c8ea5ec27f.jpg'),
(17, 1234567890, 'emailmahasiswa234@gmail.com', '085534567890', 'Nama Jalan/Kampung, Nama Desa, Nama Kecamatan, Kabupaten/Kota', 'SMAN 1 INDONESIA', 3.78, '678f13670b74e.jpeg');

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

--
-- Dumping data for table `softskills`
--

INSERT INTO `softskills` (`id_softskills`, `id_profile`, `skill`) VALUES
(6, 14, 'Public Speaking'),
(8, 16, 'Manajemen Waktu'),
(16, 17, 'Komunikasi Dengan Baik'),
(19, 12, 'Komunikasi Dengan Baik'),
(20, 12, 'Tanggung Jawab');

-- --------------------------------------------------------

--
-- Table structure for table `tools`
--

CREATE TABLE `tools` (
  `id_tools` int(11) NOT NULL,
  `id_profile` int(11) NOT NULL,
  `tool` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tools`
--

INSERT INTO `tools` (`id_tools`, `id_profile`, `tool`) VALUES
(6, 14, 'Adobe  Photoshop'),
(8, 16, 'Figma'),
(19, 17, 'Visual-Studio'),
(21, 12, 'Git');

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
(16, 2330511106, 'Danies Syabian Saputra', '2004-09-29', 'Laki-laki', 'Sains dan Teknologi', 'S1 Teknik Informatika', '240be518fabd2724ddb6f04eeb1da5967448d7e831c08c8fa822809f74c720a9'),
(21, 2330311041, 'Ergi Nurjamil', '2004-04-22', 'Laki-laki', 'Sains dan Teknologi', 'S1 Teknik Informatika', '240be518fabd2724ddb6f04eeb1da5967448d7e831c08c8fa822809f74c720a9'),
(23, 2330511107, 'Muammad Naufal Endas', '2003-07-17', 'Laki-laki', 'Sains dan Teknologi', 'S1 Teknik Informatika', '1f2b1986fc0484a9b4e3100ac38bff95d3204d8ad6390e182ba1c1c697c47f65'),
(24, 23305111099, 'Khairusy', '2004-03-12', 'Laki-laki', 'Sains dan Teknologi', 'S1 Teknik Informatika', '240be518fabd2724ddb6f04eeb1da5967448d7e831c08c8fa822809f74c720a9'),
(25, 1234567890, 'Nama Mahasiswa', '2000-01-01', 'Laki-laki', 'Sains dan Teknologi', 'S1 Teknik Informatika', '240be518fabd2724ddb6f04eeb1da5967448d7e831c08c8fa822809f74c720a9'),
(27, 2330511100, 'Moch DIka Herdian Shopa', '2004-02-20', 'Laki-laki', 'Sains dan Teknologi', 'S1 Teknik Informatika', '240be518fabd2724ddb6f04eeb1da5967448d7e831c08c8fa822809f74c720a9'),
(28, 12345678, 'akun tumbal', '2003-01-02', 'Laki-laki', 'Sains dan Teknologi', 'S1 Teknik Sipil', 'e210e8145499e7bfa4c544ab6f58f5591cf094a96c8ee40d23d8bd49ed0f73d6');

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
