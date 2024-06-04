-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 03 Jun 2024 pada 10.54
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
-- Struktur dari tabel `pendaftar`
--

CREATE TABLE `pendaftar` (
  `id_pendaftar` int(11) NOT NULL,
  `nama_mahasiswa` varchar(255) NOT NULL,
  `nim_mahasiswa` varchar(15) NOT NULL,
  `email_mahasiswa` varchar(255) NOT NULL,
  `alamat_mahasiswa` varchar(255) NOT NULL,
  `no_hp_mahasiswa` varchar(15) NOT NULL,
  `id_program_studi` int(11) NOT NULL,
  `semester_mahasiswa` varchar(11) NOT NULL,
  `ipk_terakhir_mahasiswa` decimal(3,2) NOT NULL,
  `id_pilihan_beasiswa` int(11) NOT NULL,
  `tanggal_tambah_data` datetime DEFAULT NULL,
  `tanggal_perbarui_data` datetime DEFAULT NULL,
  `tanggal_hapus_data` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pendaftar`
--

INSERT INTO `pendaftar` (`id_pendaftar`, `nama_mahasiswa`, `nim_mahasiswa`, `email_mahasiswa`, `alamat_mahasiswa`, `no_hp_mahasiswa`, `id_program_studi`, `semester_mahasiswa`, `ipk_terakhir_mahasiswa`, `id_pilihan_beasiswa`, `tanggal_tambah_data`, `tanggal_perbarui_data`, `tanggal_hapus_data`) VALUES
(5, 'Danny Bungai', '211011401689', 'danny@gmail.com', 'Jl. Witana', '085101515637', 1, 'Semester 6', 3.80, 1, '2024-06-02 22:34:09', '2024-06-03 13:31:55', NULL),
(8, 'Ferly Hander', '211011409831', 'ferly@gmail.com', 'Jl. Pahlawan', '085567628743', 2, 'Semester 5', 3.20, 3, '2024-06-02 22:41:28', '2024-06-03 06:53:03', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pilihan_beasiswa`
--

CREATE TABLE `pilihan_beasiswa` (
  `id_pilihan_beasiswa` int(11) NOT NULL,
  `nama_beasiswa` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pilihan_beasiswa`
--

INSERT INTO `pilihan_beasiswa` (`id_pilihan_beasiswa`, `nama_beasiswa`) VALUES
(1, 'Beasiswa Penghargaan'),
(2, 'Beasiswa Penelitian'),
(3, 'Beasiswa Non-Akademik');

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
(2, 'Teknik Mesin');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `pendaftar`
--
ALTER TABLE `pendaftar`
  ADD PRIMARY KEY (`id_pendaftar`),
  ADD KEY `program_studi` (`id_program_studi`),
  ADD KEY `pilihan_beasiswa` (`id_pilihan_beasiswa`);

--
-- Indeks untuk tabel `pilihan_beasiswa`
--
ALTER TABLE `pilihan_beasiswa`
  ADD PRIMARY KEY (`id_pilihan_beasiswa`);

--
-- Indeks untuk tabel `program_studi`
--
ALTER TABLE `program_studi`
  ADD PRIMARY KEY (`id_program_studi`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `pendaftar`
--
ALTER TABLE `pendaftar`
  MODIFY `id_pendaftar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `pilihan_beasiswa`
--
ALTER TABLE `pilihan_beasiswa`
  MODIFY `id_pilihan_beasiswa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `program_studi`
--
ALTER TABLE `program_studi`
  MODIFY `id_program_studi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `pendaftar`
--
ALTER TABLE `pendaftar`
  ADD CONSTRAINT `pilihan_beasiswa` FOREIGN KEY (`id_pilihan_beasiswa`) REFERENCES `pilihan_beasiswa` (`id_pilihan_beasiswa`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `program_studi` FOREIGN KEY (`id_program_studi`) REFERENCES `program_studi` (`id_program_studi`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
