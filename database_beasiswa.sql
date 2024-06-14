-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 14, 2024 at 06:30 AM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 7.4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `database_beasiswa`
--

-- --------------------------------------------------------

--
-- Table structure for table `beasiswa`
--

CREATE TABLE `beasiswa` (
  `id_beasiswa` int(11) NOT NULL,
  `nama_beasiswa` varchar(255) NOT NULL,
  `id_program_studi` int(11) NOT NULL,
  `id_kategori` int(11) NOT NULL,
  `kuota` int(11) NOT NULL,
  `tanggal_tambah_data` datetime DEFAULT NULL,
  `tanggal_perbarui_data` datetime DEFAULT NULL,
  `tanggal_hapus_data` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `beasiswa`
--

INSERT INTO `beasiswa` (`id_beasiswa`, `nama_beasiswa`, `id_program_studi`, `id_kategori`, `kuota`, `tanggal_tambah_data`, `tanggal_perbarui_data`, `tanggal_hapus_data`) VALUES
(1, 'Beasiswa Programming', 1, 3, 200, '2024-06-11 14:11:23', '2024-06-12 19:20:50', '2024-06-12 14:24:56'),
(17, 'Beasiswa Robotik', 1, 2, 200, '2024-06-11 14:37:21', '2024-06-12 19:25:23', NULL),
(18, 'Beasiswa Teknologi', 3, 3, 200, '2024-06-11 19:34:28', '2024-06-12 19:25:43', NULL),
(23, 'Microsoft Tuition Scholarship', 1, 3, 200, '2024-06-11 22:19:45', NULL, NULL),
(24, 'Google Lime Scholarship', 1, 1, 100, '2024-06-11 22:20:15', NULL, NULL),
(25, 'Microsoft Tuition Scholarship', 1, 1, 50, '2024-06-11 22:21:23', NULL, NULL),
(26, 'Beasiswa Cargill Global Scholars', 1, 4, 20, '2024-06-11 22:22:18', NULL, '2024-06-12 14:24:39'),
(27, 'Google Lime Scholarship', 2, 1, 200, '2024-06-12 19:43:34', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama_kategori`) VALUES
(1, 'Penghargaan'),
(2, 'Penelitian'),
(3, 'Akademik'),
(4, 'Non-Akademik');

-- --------------------------------------------------------

--
-- Table structure for table `program_studi`
--

CREATE TABLE `program_studi` (
  `id_program_studi` int(11) NOT NULL,
  `nama_program_studi` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `program_studi`
--

INSERT INTO `program_studi` (`id_program_studi`, `nama_program_studi`) VALUES
(1, 'Teknik Informatika'),
(2, 'Teknik Mesin'),
(3, 'Sistem Informasi');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `role` enum('admin','member') NOT NULL,
  `is_active` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `full_name`, `role`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'danny123@gmail.com', '$2y$10$jFWDrI4iT9GPh.k.7qaOyu0KJ1KUkw2/7noXvfdOiEFMfLV37klXO', 'Danny', 'admin', 0, '2024-06-10 09:54:06', NULL),
(4, 'herky@gmail.com', '$2y$10$PNyr.23/ocBrFeziMN/1w.1mnotB5lkQGOUw/ut1H3vgVEoBp7sWe', 'Herky', 'admin', 0, '2024-06-11 15:10:32', NULL),
(5, 'ferly@gmail.com', '$2y$10$FQEyfxa.B16jyRzLIvHEYuOXoxvoL6ovSyQjzy3Tc8YsdeXA0Opk.', 'Ferly', 'admin', 0, '2024-06-11 15:33:04', NULL),
(6, 'fauzi@gmail.com', '$2y$10$LQxIYTrFzcpjKZfiiFmgtOIvHT/PfAwN1AfiDPeqBTT03/hvCv/Vi', 'Fauzi', 'admin', 0, '2024-06-12 14:14:31', NULL),
(7, 'fauzi@gmail.com', '$2y$10$SKulPsrzU2GJg/c62oJwBubx6nC/c.OUZfMuCcjZJmQKiIEvsnHlW', 'Mohammad Fauzie Apriansyah', 'admin', 0, '2024-06-12 14:24:14', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `beasiswa`
--
ALTER TABLE `beasiswa`
  ADD PRIMARY KEY (`id_beasiswa`),
  ADD KEY `program_studi` (`id_program_studi`),
  ADD KEY `kategori` (`id_kategori`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `program_studi`
--
ALTER TABLE `program_studi`
  ADD PRIMARY KEY (`id_program_studi`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `beasiswa`
--
ALTER TABLE `beasiswa`
  MODIFY `id_beasiswa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `program_studi`
--
ALTER TABLE `program_studi`
  MODIFY `id_program_studi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `beasiswa`
--
ALTER TABLE `beasiswa`
  ADD CONSTRAINT `kategori` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `program_studi` FOREIGN KEY (`id_program_studi`) REFERENCES `program_studi` (`id_program_studi`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
