-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 29 Jun 2024 pada 18.53
-- Versi server: 10.4.28-MariaDB
-- Versi PHP: 8.2.4

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
-- Struktur dari tabel `beasiswa`
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `beasiswa`
--

INSERT INTO `beasiswa` (`id_beasiswa`, `nama_beasiswa`, `id_program_studi`, `id_kategori`, `kuota`, `tanggal_tambah_data`, `tanggal_perbarui_data`, `tanggal_hapus_data`) VALUES
(1, 'Beasiswa Programming', 1, 3, 102, '2024-06-11 14:11:23', '2024-06-11 19:39:27', NULL),
(17, 'Beasiswa Robotik', 2, 2, 180, '2024-06-11 14:37:21', '2024-06-27 23:32:41', NULL),
(18, 'Beasiswa Teknologi', 3, 3, 121, '2024-06-11 19:34:28', '2024-06-27 23:39:03', NULL),
(30, 'Beasiswa Gaming', 2, 3, 123, '2024-06-14 10:18:17', NULL, NULL),
(33, 'Beasiswa Robotik', 2, 1, 123, '2024-06-27 20:12:31', '2024-06-27 23:21:08', NULL),
(34, 'Beasiswa Perancangan Sistem', 3, 3, 61, '2024-06-27 20:13:30', '2024-06-27 21:24:05', NULL),
(35, 'Beasiswa Animasi 3D', 1, 4, 362, '2024-06-27 20:14:38', NULL, NULL),
(36, 'Beasiswa Web Developer', 3, 4, 432, '2024-06-27 20:17:01', NULL, NULL),
(38, 'Beasiswa Adobe Photoshop', 1, 1, 295, '2024-06-27 20:55:22', '2024-06-29 23:45:41', NULL),
(39, 'Gaming', 3, 2, 300, '2024-06-27 21:13:26', '2024-06-27 21:13:44', '2024-06-29 18:33:35'),
(40, 'ABC', 2, 2, 456, '2024-06-27 23:41:42', NULL, '2024-06-29 18:33:33'),
(41, 'DFE', 1, 3, 123, '2024-06-28 00:20:57', NULL, '2024-06-29 18:33:29'),
(42, 'GHJ', 1, 2, 765, '2024-06-28 00:21:05', NULL, '2024-06-29 18:33:27'),
(43, 'ABD', 2, 1, 425, '2024-06-28 00:21:19', NULL, '2024-06-29 18:33:25'),
(44, 'hdhdh', 1, 2, 421, '2024-06-28 00:23:23', NULL, '2024-06-29 18:33:24'),
(45, 'qgsf', 2, 4, 698, '2024-06-28 00:23:44', NULL, '2024-06-29 18:33:22'),
(46, '5gdgd', 3, 3, 536, '2024-06-28 00:23:58', NULL, '2024-06-29 18:33:20'),
(47, 'hjg', 1, 2, 355, '2024-06-28 00:24:47', NULL, '2024-06-29 18:33:19'),
(48, '3654', 2, 2, 1353, '2024-06-28 00:25:02', NULL, '2024-06-29 18:33:17'),
(49, 'uop', 2, 4, 568, '2024-06-28 00:25:17', NULL, '2024-06-29 18:33:16'),
(50, '7jfy', 3, 3, 787, '2024-06-28 00:25:38', '2024-06-28 01:00:47', '2024-06-29 18:33:14'),
(51, 'Harus Bisa Ayo Gas', 1, 2, 319, '2024-06-29 23:19:59', '2024-06-29 23:20:19', '2024-06-29 18:20:30');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama_kategori`) VALUES
(1, 'Penghargaan'),
(2, 'Penelitian'),
(3, 'Akademik'),
(4, 'Non-Akademik');

-- --------------------------------------------------------

--
-- Struktur dari tabel `program_studi`
--

CREATE TABLE `program_studi` (
  `id_program_studi` int(11) NOT NULL,
  `nama_program_studi` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `program_studi`
--

INSERT INTO `program_studi` (`id_program_studi`, `nama_program_studi`) VALUES
(1, 'Teknik Informatika'),
(2, 'Teknik Mesin'),
(3, 'Sistem Informasi');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `full_name`, `role`, `is_active`, `created_at`, `updated_at`) VALUES
(9, 'admin@gmail.com', '$2y$10$KwqEGesKdQOBOkmcrqtDvObghDkGd.ZCzRT5bz08D/9YMD3XA5hOq', 'Admin', 'admin', 0, '2024-06-29 18:23:14', NULL),
(10, 'member@gmail.com', '$2y$10$zSxyo9lB.yESG/3DxjehVOLod17yERZ4ptNwPmKDLhQ5MiYLrEy2e', 'Member', 'member', 0, '2024-06-29 18:23:30', NULL),
(11, 'dannyfauzi@gmail.com', '$2y$10$HxP0qJZHcxBmCYRqKs.pW.E1QhBl16o/kwyj9SV0FMCUdavn3gPlW', 'Danny Fauzi', 'admin', 0, '2024-06-29 18:24:47', NULL),
(13, 'ferly@gmail.com', '$2y$10$6oPlNmS6mjvUQGtEtfblEO57mCgS6ZsQv4SOBEupHqU5FCmItfjrW', 'Ferly', 'member', 0, '2024-06-29 18:32:16', NULL);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `beasiswa`
--
ALTER TABLE `beasiswa`
  ADD PRIMARY KEY (`id_beasiswa`),
  ADD KEY `program_studi` (`id_program_studi`),
  ADD KEY `kategori` (`id_kategori`);

--
-- Indeks untuk tabel `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indeks untuk tabel `program_studi`
--
ALTER TABLE `program_studi`
  ADD PRIMARY KEY (`id_program_studi`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `beasiswa`
--
ALTER TABLE `beasiswa`
  MODIFY `id_beasiswa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT untuk tabel `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `program_studi`
--
ALTER TABLE `program_studi`
  MODIFY `id_program_studi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `beasiswa`
--
ALTER TABLE `beasiswa`
  ADD CONSTRAINT `kategori` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `program_studi` FOREIGN KEY (`id_program_studi`) REFERENCES `program_studi` (`id_program_studi`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
