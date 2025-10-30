-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 30 Okt 2025 pada 12.33
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `my5edb`
--
CREATE DATABASE IF NOT EXISTS `my5edb` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `my5edb`;

-- --------------------------------------------------------

--
-- Struktur dari tabel `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `price` double NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `created`) VALUES
(1, 'Speaker Portable', 'tahan air', 180000, '2025-10-30 10:11:01'),
(3, 'keyboard', 'type mahal 456556', 89000, '2025-10-30 10:11:11'),
(5, 'External Monitor', 'monitor', 700000, '2025-10-30 10:10:13');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `fullname` varchar(50) NOT NULL,
  `role` varchar(20) NOT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `reg_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `activation_token` varchar(128) DEFAULT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `reset_token_expires` datetime DEFAULT NULL,
  `reset_expiry` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `fullname`, `role`, `status`, `reg_date`, `modified`, `activation_token`, `reset_token`, `reset_token_expires`, `reset_expiry`) VALUES
(6, 'a@gmail.com', '$2y$10$QMsQ2wU22/l5K5kBqE4rAu9UlMnLt3HTDE/GYmo67MZi9WMco8KfO', 'a', 'AdminGudang', 'active', '2025-10-30 09:21:40', '2025-10-30 10:31:41', NULL, '92ca2302076f3aaaffe703b39a533b7f', '2025-10-30 12:12:07', NULL),
(7, 'cicak@gmail.com', '$2y$10$xkN8eyXrpXmYM1fZM5Yerus1DNTXwjDeh4fuRY.ox2Bg7EiegDKT6', 'cicak', 'AdminGudang', 'active', '2025-10-30 09:38:30', '2025-10-30 09:40:40', NULL, 'f286c1cf168e95ada96a47feabfa9548', '2025-10-30 11:40:40', '2025-10-30 11:38:59');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
