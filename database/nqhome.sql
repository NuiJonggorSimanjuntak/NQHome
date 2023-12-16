-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 12 Sep 2023 pada 09.49
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
-- Database: `nqhome`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `auth_activation_attempts`
--

CREATE TABLE `auth_activation_attempts` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(255) NOT NULL,
  `user_agent` varchar(255) NOT NULL,
  `token` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `auth_groups`
--

CREATE TABLE `auth_groups` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `auth_groups`
--

INSERT INTO `auth_groups` (`id`, `name`, `description`) VALUES
(1, 'admin', 'Super Admin'),
(2, 'guru', 'Pengajar'),
(3, 'santri', 'Pengguna Utama');

-- --------------------------------------------------------

--
-- Struktur dari tabel `auth_groups_permissions`
--

CREATE TABLE `auth_groups_permissions` (
  `group_id` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `permission_id` int(11) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `auth_groups_permissions`
--

INSERT INTO `auth_groups_permissions` (`group_id`, `permission_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(2, 1),
(2, 3),
(3, 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `auth_groups_users`
--

CREATE TABLE `auth_groups_users` (
  `group_id` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `user_id` int(11) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `auth_groups_users`
--

INSERT INTO `auth_groups_users` (`group_id`, `user_id`) VALUES
(1, 1),
(2, 6),
(2, 7),
(2, 8),
(2, 10),
(3, 2),
(3, 5),
(3, 9);

-- --------------------------------------------------------

--
-- Struktur dari tabel `auth_logins`
--

CREATE TABLE `auth_logins` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `user_id` int(11) UNSIGNED DEFAULT NULL,
  `date` datetime NOT NULL,
  `success` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `auth_logins`
--

INSERT INTO `auth_logins` (`id`, `ip_address`, `email`, `user_id`, `date`, `success`) VALUES
(1, '::1', 'sams', 6, '2023-07-17 05:55:31', 0),
(2, '::1', 'adark8957@gmail.com', 6, '2023-07-17 05:55:43', 1),
(3, '::1', 'adark8957@gmail.com', 6, '2023-07-17 06:44:38', 1),
(4, '::1', 'adark8957@gmail.com', 6, '2023-07-17 06:45:13', 1),
(5, '::1', 'adark8957@gmail.com', 6, '2023-07-17 07:04:28', 1),
(6, '::1', 'adark8957@gmail.com', 6, '2023-07-17 07:28:47', 1),
(7, '::1', 'adark8957@gmail.com', 6, '2023-07-17 07:29:53', 1),
(8, '::1', 'adark8957@gmail.com', 6, '2023-07-17 07:40:52', 1),
(9, '::1', 'adark8957@gmail.com', 6, '2023-07-17 07:43:10', 1),
(10, '::1', 'adark8957@gmail.com', 6, '2023-07-17 07:52:45', 1),
(11, '::1', 'adark8957@gmail.com', 6, '2023-07-17 07:54:28', 1),
(12, '::1', 'adark8957@gmail.com', 6, '2023-07-17 07:56:41', 1),
(13, '::1', 'adark8957@gmail.com', 6, '2023-07-17 07:59:33', 1),
(14, '::1', 'adark8957@gmail.com', 6, '2023-07-17 07:59:46', 1),
(15, '::1', 'adark8957@gmail.com', 6, '2023-07-17 08:00:11', 1),
(16, '::1', 'adark8957@gmail.com', 6, '2023-07-17 08:00:28', 1),
(17, '::1', 'adark8957@gmail.com', 6, '2023-07-17 08:00:46', 1),
(18, '::1', 'adark8957@gmail.com', 6, '2023-07-17 08:01:03', 1),
(19, '::1', 'adark8957@gmail.com', 6, '2023-07-17 08:01:31', 1),
(20, '::1', 'adark8957@gmail.com', 6, '2023-07-17 08:01:43', 1),
(21, '::1', 'adark8957@gmail.com', 6, '2023-07-17 16:06:26', 1),
(22, '::1', 'adark8957@gmail.com', 6, '2023-07-17 16:07:49', 1),
(23, '::1', 'adark8957@gmail.com', 6, '2023-07-17 17:30:45', 1),
(24, '::1', 'adark8957@gmail.com', 6, '2023-07-20 14:19:32', 1),
(25, '::1', 'adark8957@gmail.com', 6, '2023-07-20 18:13:44', 1),
(26, '::1', 'adark8957@gmail.com', 6, '2023-07-20 18:17:05', 1),
(27, '::1', 'samwinzchester@gmail.com', 7, '2023-07-21 18:23:42', 1),
(28, '::1', 'adark8957@gmail.com', 6, '2023-07-21 18:28:40', 1),
(29, '::1', 'adark8957@gmail.com', 6, '2023-07-21 19:06:41', 1),
(30, '::1', 'adark8957@gmail.com', 6, '2023-07-21 19:14:23', 1),
(31, '::1', 'samwinzchester@gmail.com', 7, '2023-07-21 19:14:57', 1),
(32, '::1', 'adark8957@gmail.com', 6, '2023-07-21 19:17:32', 1),
(33, '::1', 'admin@example.com', 8, '2023-07-21 19:19:55', 1),
(34, '::1', 'admin@example.com', 8, '2023-07-21 19:20:17', 1),
(35, '::1', 'adark8957@gmail.com', 6, '2023-07-21 19:21:24', 1),
(36, '::1', 'adark8957@gmail.com', 6, '2023-07-21 19:25:44', 1),
(37, '::1', 'samwinzchester@gmail.com', 7, '2023-07-21 19:25:55', 1),
(38, '::1', 'adark8957@gmail.com', 6, '2023-07-21 19:26:15', 1),
(39, '::1', 'adark8957@gmail.com', 6, '2023-07-21 19:26:49', 1),
(40, '::1', 'samwinzchester@gmail.com', 7, '2023-07-21 19:27:09', 1),
(41, '::1', 'adark8957@gmail.com', 6, '2023-07-21 19:33:05', 1),
(42, '::1', 'samwinzchester@gmail.com', 7, '2023-07-21 19:34:37', 1),
(43, '::1', 'adark8957@gmail.com', 6, '2023-07-21 19:36:30', 1),
(44, '::1', 'samwinzchester@gmail.com', 7, '2023-07-21 19:42:48', 1),
(45, '::1', 'adark8957@gmail.com', 6, '2023-07-22 12:55:04', 1),
(46, '::1', 'adark8957@gmail.com', 6, '2023-07-22 13:05:44', 1),
(47, '::1', 'adark8957@gmail.com', 6, '2023-07-22 13:05:57', 1),
(48, '::1', 'adark8957@gmail.com', 6, '2023-07-22 13:06:21', 1),
(49, '::1', 'samwinzchester@gmail.com', 7, '2023-07-22 14:40:50', 1),
(50, '::1', 'adark8957@gmail.com', 6, '2023-07-22 14:43:25', 1),
(51, '::1', 'adark8957@gmail.com', 6, '2023-07-22 15:36:44', 1),
(52, '::1', 'adark8957@gmail.com', 6, '2023-07-22 15:44:54', 1),
(53, '::1', 'adark8957@gmail.com', 6, '2023-07-22 15:51:15', 1),
(54, '::1', 'adark8957@gmail.com', 6, '2023-07-22 15:56:21', 1),
(55, '::1', 'adark8957@gmail.com', 6, '2023-07-22 16:36:52', 1),
(56, '::1', 'adark8957@gmail.com', 6, '2023-07-22 16:43:55', 1),
(57, '::1', 'adark8957@gmail.com', 6, '2023-07-22 16:55:15', 1),
(58, '::1', 'adark8957@gmail.com', 6, '2023-07-22 17:15:08', 1),
(59, '::1', 'adark8957@gmail.com', 6, '2023-07-22 17:25:44', 1),
(60, '::1', 'adark8957@gmail.com', 6, '2023-07-23 16:25:47', 1),
(61, '::1', 'adark8957@gmail.com', 6, '2023-07-23 16:26:08', 1),
(62, '::1', 'adark8957@gmail.com', 6, '2023-07-23 16:46:40', 1),
(63, '::1', 'adark8957@gmail.com', 6, '2023-07-23 16:55:11', 1),
(64, '::1', 'adark8957@gmail.com', 6, '2023-07-23 17:05:05', 1),
(65, '::1', 'adark8957@gmail.com', 6, '2023-07-23 17:35:29', 1),
(66, '::1', 'adark8957@gmail.com', 6, '2023-07-23 17:40:20', 1),
(67, '::1', 'adark8957@gmail.com', 6, '2023-07-24 10:38:15', 1),
(68, '::1', 'adark8957@gmail.com', 6, '2023-07-24 15:43:36', 1),
(69, '::1', 'adark8957@gmail.com', 6, '2023-07-24 18:50:21', 1),
(70, '::1', 'adark8957@gmail.com', 6, '2023-07-29 08:57:05', 1),
(71, '::1', 'adark8957@gmail.com', 6, '2023-07-29 09:42:03', 1),
(72, '::1', 'adark8957@gmail.com', 6, '2023-07-29 12:29:36', 1),
(73, '::1', 'samwinzchester@gmail.com', 7, '2023-07-29 12:46:40', 1),
(74, '::1', 'adark8957@gmail.com', 6, '2023-07-29 12:47:22', 1),
(75, '::1', 'samwinzchester@gmail.com', 7, '2023-07-29 18:44:07', 1),
(76, '::1', 'adark8957@gmail.com', 6, '2023-07-29 18:45:02', 1),
(77, '::1', 'sams', 6, '2023-07-29 19:40:14', 0),
(78, '::1', 'adark8957@gmail.com', 6, '2023-07-29 19:40:41', 1),
(79, '::1', 'samwinzchester@gmail.com', 7, '2023-07-29 19:57:42', 1),
(80, '::1', 'samwinzchester@gmail.com', 7, '2023-07-29 20:10:38', 1),
(81, '::1', 'ortu@example.com', 10, '2023-07-29 20:11:06', 1),
(82, '::1', 'ortu@example.com', 10, '2023-07-29 20:12:58', 1),
(83, '::1', 'admin@example.com', 8, '2023-07-29 20:25:25', 1),
(84, '::1', 'ortu@example.com', 10, '2023-07-29 20:29:49', 1),
(85, '::1', 'adark8957@gmail.com', 6, '2023-07-29 20:32:51', 1),
(86, '::1', 'ortu', 10, '2023-07-29 20:39:52', 0),
(87, '::1', 'admin@example.com', 8, '2023-07-29 20:39:57', 1),
(88, '::1', 'adark8957@gmail.com', 6, '2023-07-29 20:40:17', 1),
(89, '::1', 'samwinzchester@gmail.com', 7, '2023-07-29 20:42:44', 1),
(90, '::1', 'adark8957@gmail.com', 6, '2023-07-29 20:44:46', 1),
(91, '::1', 'ortu', 10, '2023-07-29 20:45:09', 0),
(92, '::1', 'admin@example.com', 8, '2023-07-29 20:45:54', 1),
(93, '::1', 'admin@example.com', 8, '2023-07-29 20:46:13', 1),
(94, '::1', 'adark8957@gmail.com', 6, '2023-07-29 21:21:46', 1),
(95, '::1', 'adark8957@gmail.com', 6, '2023-07-30 15:43:18', 1),
(96, '::1', 'ortu@example.com', 10, '2023-07-30 17:21:59', 1),
(97, '::1', 'adark8957@gmail.com', 6, '2023-07-30 17:22:29', 1),
(98, '::1', 'adark8957@gmail.com', 6, '2023-07-31 13:02:41', 1),
(99, '::1', 'sams', NULL, '2023-07-31 13:53:10', 0),
(100, '::1', 'sams', NULL, '2023-07-31 13:53:13', 0),
(101, '::1', 'sams', NULL, '2023-07-31 13:53:31', 0),
(102, '::1', 'ortu', NULL, '2023-07-31 13:54:00', 0),
(103, '::1', 'sams', NULL, '2023-07-31 13:54:03', 0),
(104, '::1', 'sams', NULL, '2023-07-31 13:54:06', 0),
(105, '::1', 'sams', NULL, '2023-07-31 13:54:08', 0),
(106, '::1', 'sams', NULL, '2023-07-31 13:54:33', 0),
(107, '::1', 'sams', NULL, '2023-07-31 13:55:00', 0),
(108, '::1', 'sams', NULL, '2023-07-31 13:55:38', 0),
(109, '::1', 'sams', NULL, '2023-07-31 13:56:31', 0),
(110, '::1', 'adark8957@gmail.com', 6, '2023-07-31 13:59:07', 1),
(111, '::1', 'contoh', NULL, '2023-07-31 14:32:46', 0),
(112, '::1', 'nuijs', NULL, '2023-07-31 14:33:08', 0),
(113, '::1', 'adark8957@gmail.com', 6, '2023-07-31 14:33:26', 1),
(114, '::1', 'contoh', NULL, '2023-07-31 14:34:38', 0),
(115, '::1', 'contoh', NULL, '2023-07-31 14:35:03', 0),
(116, '::1', 'adark8957@gmail.com', 6, '2023-07-31 14:40:02', 1),
(117, '::1', 'sams', NULL, '2023-07-31 14:51:40', 0),
(118, '::1', 'sams', NULL, '2023-07-31 14:51:53', 0),
(119, '::1', 'sams', NULL, '2023-07-31 14:51:53', 0),
(120, '::1', 'sams', NULL, '2023-07-31 14:52:01', 0),
(121, '::1', 'sams', NULL, '2023-07-31 14:52:50', 0),
(122, '::1', 'adark8957@gmail.com', 6, '2023-07-31 14:53:17', 1),
(123, '::1', 'adark8957@gmail.com', 6, '2023-07-31 14:54:08', 1),
(124, '::1', 'test@gmail.com', 42, '2023-07-31 17:12:39', 1),
(125, '::1', 'adark8957@gmail.com', 6, '2023-08-01 17:39:55', 1),
(126, '::1', 'adark8957@gmail.com', 6, '2023-08-02 16:42:22', 1),
(127, '::1', 'adark8957@gmail.com', 6, '2023-08-03 15:17:15', 1),
(128, '::1', 'contoh2@gmail.com', 65, '2023-08-03 16:34:30', 1),
(129, '::1', 'adark8957@gmail.com', 6, '2023-08-04 08:41:44', 1),
(130, '::1', 'adark8957@gmail.com', 6, '2023-08-04 11:25:25', 1),
(131, '::1', 'adark8957@gmail.com', 6, '2023-08-04 16:31:53', 1),
(132, '::1', 'adark8957@gmail.com', 6, '2023-08-04 16:57:37', 1),
(133, '::1', 'adark8957@gmail.com', 6, '2023-08-05 17:13:53', 1),
(134, '::1', 'contoh1@gmail.com', 66, '2023-08-05 18:47:51', 1),
(135, '::1', 'contoh1@gmail.com', 66, '2023-08-05 19:34:24', 1),
(136, '::1', 'contoh1@gmail.com', 66, '2023-08-05 22:14:27', 1),
(137, '::1', 'adark8957@gmail.com', 6, '2023-08-06 13:30:51', 1),
(138, '::1', 'contoh1@gmail.com', 66, '2023-08-06 13:31:35', 1),
(139, '::1', 'contoh2', NULL, '2023-08-06 16:19:38', 0),
(140, '::1', 'contoh2', NULL, '2023-08-06 16:19:57', 0),
(141, '::1', 'contoh2', NULL, '2023-08-06 16:20:09', 0),
(142, '::1', 'contoh2', NULL, '2023-08-06 16:20:34', 0),
(143, '::1', 'contoh2', NULL, '2023-08-06 16:20:50', 0),
(144, '::1', 'admin@example.com', 8, '2023-08-06 16:21:00', 1),
(145, '::1', 'samwinzchester@gmail.com', 7, '2023-08-06 16:21:46', 1),
(146, '::1', 'contoh1@gmail.com', 66, '2023-08-06 16:23:02', 1),
(147, '::1', 'adark8957@gmail.com', 6, '2023-08-06 16:26:11', 1),
(148, '::1', 'adark8957@gmail.com', 6, '2023-08-06 16:28:40', 1),
(149, '::1', 'contoh1@gmail.com', 66, '2023-08-06 16:28:59', 1),
(150, '::1', 'adark8957@gmail.com', 6, '2023-08-06 16:29:59', 1),
(151, '::1', 'contoh1@gmail.com', 66, '2023-08-06 18:04:17', 1),
(152, '::1', 'contoh1@gmail.com', 66, '2023-08-06 18:16:05', 1),
(153, '::1', 'contoh1@gmail.com', 66, '2023-08-06 18:38:09', 1),
(154, '::1', 'contoh1@gmail.com', 66, '2023-08-06 19:07:22', 1),
(155, '::1', 'contoh1@gmail.com', 66, '2023-08-06 19:27:13', 1),
(156, '::1', 'adark8957@gmail.com', 6, '2023-08-07 12:56:44', 1),
(157, '::1', 'contoh1@gmail.com', 66, '2023-08-07 12:57:08', 1),
(158, '::1', 'contoh1@gmail.com', 66, '2023-08-07 15:04:46', 1),
(159, '::1', 'contoh2', NULL, '2023-08-07 15:05:00', 0),
(160, '::1', 'samwinzchester@gmail.com', 7, '2023-08-07 15:05:04', 1),
(161, '::1', 'adark8957@gmail.com', 6, '2023-08-07 15:05:21', 1),
(162, '::1', 'nui', NULL, '2023-08-07 18:19:58', 0),
(163, '::1', 'admin@example.com', 8, '2023-08-07 18:20:18', 1),
(164, '::1', 'contoh1@gmail.com', 66, '2023-08-07 18:36:28', 1),
(165, '::1', 'admin@example.com', 8, '2023-08-07 18:37:57', 1),
(166, '::1', 'contoh1@gmail.com', 66, '2023-08-07 18:38:33', 1),
(167, '::1', 'contoh1@gmail.com', 66, '2023-08-07 18:40:25', 1),
(168, '::1', 'admin@example.com', 8, '2023-08-07 18:44:28', 1),
(169, '::1', 'contoh1@gmail.com', 66, '2023-08-07 18:45:12', 1),
(170, '::1', 'admin@example.com', 8, '2023-08-07 19:01:58', 1),
(171, '::1', 'contoh1@gmail.com', 66, '2023-08-07 19:15:20', 1),
(172, '::1', 'adark8957@gmail.com', 6, '2023-08-08 06:30:16', 1),
(173, '::1', 'contoh1@gmail.com', 66, '2023-08-08 06:35:57', 1),
(174, '::1', 'contoh1@gmail.com', 66, '2023-08-08 08:39:52', 1),
(175, '::1', 'admin@example.com', 8, '2023-08-08 08:40:00', 1),
(176, '::1', 'contoh1@gmail.com', 66, '2023-08-08 09:05:40', 1),
(177, '::1', 'admin@example.com', 8, '2023-08-08 09:14:03', 1),
(178, '::1', 'adark8957@gmail.com', 6, '2023-08-08 09:17:00', 1),
(179, '::1', 'contoh1@gmail.com', 66, '2023-08-08 09:18:18', 1),
(180, '::1', 'admin@example.com', 8, '2023-08-08 09:53:14', 1),
(181, '::1', 'samwinzchester@gmail.com', 7, '2023-08-08 11:06:45', 1),
(182, '::1', 'contoh2', NULL, '2023-08-08 11:25:28', 0),
(183, '::1', 'contoh2', NULL, '2023-08-08 11:25:56', 0),
(184, '::1', 'contoh2@gmail.com', 67, '2023-08-08 11:28:26', 1),
(185, '::1', 'contoh2', NULL, '2023-08-08 12:08:06', 0),
(186, '::1', 'bowo', NULL, '2023-08-08 12:08:11', 0),
(187, '::1', 'contoh2@gmail.com', 70, '2023-08-08 12:08:43', 1),
(188, '::1', 'sams', NULL, '2023-08-08 12:17:51', 0),
(189, '::1', 'adark8957@gmail.com', 6, '2023-08-08 12:17:59', 1),
(190, '::1', 'sams', NULL, '2023-08-08 12:21:26', 0),
(191, '::1', 'nuijs', NULL, '2023-08-08 12:21:30', 0),
(192, '::1', 'sams', NULL, '2023-08-08 12:21:39', 0),
(193, '::1', 'sams', NULL, '2023-08-08 12:22:00', 0),
(194, '::1', 'nuijs', NULL, '2023-08-08 12:22:06', 0),
(195, '::1', 'sams', NULL, '2023-08-08 12:22:11', 0),
(196, '::1', 'sams', NULL, '2023-08-08 12:22:53', 0),
(197, '::1', 'sams', NULL, '2023-08-08 12:23:23', 0),
(198, '::1', 'sams', NULL, '2023-08-08 12:23:27', 0),
(199, '::1', 'sams', NULL, '2023-08-08 12:24:07', 0),
(200, '::1', 'adark8957@gmail.com', 6, '2023-08-08 12:24:34', 1),
(201, '::1', 'adark8957@gmail.com', 6, '2023-08-08 12:25:39', 1),
(202, '::1', 'sams', NULL, '2023-08-09 12:50:37', 0),
(203, '::1', 'adark8957@gmail.com', 6, '2023-08-09 12:50:44', 1),
(204, '::1', 'adark8957@gmail.com', 6, '2023-08-09 19:45:55', 1),
(205, '::1', 'adark8957@gmail.com', 6, '2023-08-10 16:30:16', 1),
(206, '::1', 'contoh2', NULL, '2023-08-10 19:22:29', 0),
(207, '::1', 'contoh1', NULL, '2023-08-10 19:22:33', 0),
(208, '::1', 'nuijs', NULL, '2023-08-10 19:22:36', 0),
(209, '::1', 'sams', NULL, '2023-08-10 19:22:39', 0),
(210, '::1', 'contoh2@gmail.com', 76, '2023-08-10 19:22:52', 1),
(211, '::1', 'nuijs', NULL, '2023-08-10 19:23:29', 0),
(212, '::1', 'samwinzchester@gmail.com', 7, '2023-08-10 19:23:54', 1),
(213, '::1', 'guru@gmail.com', 71, '2023-08-10 19:28:12', 1),
(214, '::1', 'adark8957@gmail.com', 6, '2023-08-10 22:51:54', 1),
(215, '::1', 'adark8957@gmail.com', 6, '2023-08-11 12:05:30', 1),
(216, '::1', 'contoh3@gmail.com', 77, '2023-08-11 18:01:42', 1),
(217, '::1', 'adark8957@gmail.com', 6, '2023-08-12 20:50:38', 1),
(218, '::1', 'contoh3@gmail.com', 77, '2023-08-12 23:57:46', 1),
(219, '::1', 'asdasda', NULL, '2023-08-13 00:05:02', 0),
(220, '::1', 'asdasda@gmail.com', 74, '2023-08-13 00:05:29', 1),
(221, '::1', 'adark8957@gmail.com', 6, '2023-08-13 15:30:19', 1),
(222, '::1', 'adark8957@gmail.com', 6, '2023-08-14 14:49:40', 1),
(223, '::1', 'adark8957@gmail.com', 6, '2023-08-14 20:47:15', 1),
(224, '::1', 'adark8957@gmail.com', 6, '2023-08-14 21:18:30', 1),
(225, '::1', 'adark8957@gmail.com', 6, '2023-08-15 13:23:52', 1),
(226, '::1', 'adark8957@gmail.com', 6, '2023-08-15 17:30:13', 1),
(227, '::1', 'adark8957@gmail.com', 6, '2023-08-15 19:40:58', 1),
(228, '::1', 'asdasda@gmail.com', 74, '2023-08-15 19:52:03', 1),
(229, '::1', 'adark8957@gmail.com', 6, '2023-08-16 16:35:25', 1),
(230, '::1', 'adark8957@gmail.com', 6, '2023-08-17 15:51:33', 1),
(231, '::1', 'santri3@gmail.c0m', 89, '2023-08-17 18:08:12', 1),
(232, '::1', 'santri1@gmail.c0m', 87, '2023-08-17 18:08:35', 1),
(233, '::1', 'santri3@gmail.c0m', 90, '2023-08-17 18:14:33', 1),
(234, '::1', 'adark8957@gmail.com', 6, '2023-08-17 18:17:13', 1),
(235, '::1', 'guru1@gmail.com', 98, '2023-08-17 20:00:46', 1),
(236, '::1', 'adark8957@gmail.com', 6, '2023-08-17 20:01:20', 1),
(237, '::1', '12345611', NULL, '2023-08-17 20:48:17', 0),
(238, '::1', 'santri1@gmail.c0m', 99, '2023-08-17 20:48:49', 1),
(239, '::1', 'adark8957@gmail.com', 6, '2023-08-17 20:49:47', 1),
(240, '::1', 'adark8957@gmail.com', 6, '2023-08-18 18:21:58', 1),
(241, '::1', 'adark8957@gmail.com', 6, '2023-08-20 13:51:13', 1),
(242, '::1', 'adark8957@gmail.com', 6, '2023-08-20 21:12:25', 1),
(243, '::1', 'adark8957@gmail.com', 6, '2023-08-21 13:13:07', 1),
(244, '::1', 'adark8957@gmail.com', 6, '2023-08-22 13:55:40', 1),
(245, '::1', 'adark8957@gmail.com', 6, '2023-08-22 17:28:39', 1),
(246, '::1', 'adark8957@gmail.com', 6, '2023-08-23 14:55:59', 1),
(247, '::1', 'putra.ryu17@gmail.com', 102, '2023-08-23 17:31:21', 1),
(248, '::1', 'adark8957@gmail.com', 6, '2023-08-24 15:56:22', 1),
(249, '::1', 'adark8957@gmail.com', 6, '2023-08-25 17:02:47', 1),
(250, '::1', 'adark8957@gmail.com', 6, '2023-08-27 17:33:30', 1),
(251, '::1', 'adark8957@gmail.com', 6, '2023-08-28 18:47:23', 1),
(252, '::1', 'adark8957@gmail.com', 6, '2023-08-31 15:21:12', 1),
(253, '::1', 'fahmi@gmail.com', 107, '2023-08-31 15:22:55', 1),
(254, '::1', 'fahmi', NULL, '2023-08-31 21:38:19', 0),
(255, '::1', 'adark8957@gmail.com', 6, '2023-08-31 21:39:31', 1),
(256, '::1', 'fahmi', NULL, '2023-08-31 21:40:49', 0),
(257, '::1', 'fahmi', NULL, '2023-08-31 21:40:52', 0),
(258, '::1', 'fahmi', NULL, '2023-08-31 21:40:54', 0),
(259, '::1', 'adark8957@gmail.com', 6, '2023-08-31 21:41:03', 1),
(260, '::1', 'fahmi@gmail.com', 107, '2023-08-31 21:41:37', 1),
(261, '::1', 'adark8957@gmail.com', 6, '2023-09-04 16:33:40', 1),
(262, '::1', 'contoh2', NULL, '2023-09-04 21:23:32', 0),
(263, '::1', 'rara', NULL, '2023-09-04 21:23:38', 0),
(264, '::1', 'rara', NULL, '2023-09-04 21:23:43', 0),
(265, '::1', 'kunia', NULL, '2023-09-04 21:24:05', 0),
(266, '::1', 'kunia', NULL, '2023-09-04 21:24:21', 0),
(267, '::1', 'soulknightgaming@gmail.com', 104, '2023-09-04 21:25:50', 1),
(268, '::1', 'kurniawati140304@gmail.com', 132, '2023-09-04 21:27:23', 1),
(269, '::1', 'kurniawati140304@gmail.com', 132, '2023-09-04 21:27:23', 1),
(270, '::1', 'fahmi@gmail.com', 107, '2023-09-04 21:39:58', 1),
(271, '::1', 'admin', NULL, '2023-09-04 22:55:47', 0),
(272, '::1', 'adark8957@gmail.com', 6, '2023-09-04 22:56:08', 1),
(273, '::1', 'fahmi@gmail.com', 107, '2023-09-05 00:06:39', 1),
(274, '::1', 'adark8957@gmail.com', 6, '2023-09-05 03:34:37', 1),
(275, '::1', 'fahmi@gmail.com', 107, '2023-09-05 04:46:35', 1),
(276, '::1', 'malikmawik78@gmail.com', 109, '2023-09-05 05:43:55', 1),
(277, '::1', 'putra.ryu17@gmail.com', 102, '2023-09-05 05:46:08', 1),
(278, '::1', 'hambaliimam1991@gmail.com', 105, '2023-09-05 05:55:56', 1),
(279, '::1', 'putra.ryu17@gmail.com', 102, '2023-09-05 05:56:12', 1),
(280, '::1', 'adark8957@gmail.com', 6, '2023-09-05 06:03:47', 1),
(281, '::1', 'putra.ryu17@gmail.com', 102, '2023-09-05 06:27:13', 1),
(282, '::1', 'dzaky', NULL, '2023-09-05 06:28:03', 0),
(283, '::1', 'putra.ryu17@gmail.com', 102, '2023-09-05 06:28:06', 1),
(284, '::1', 'putra.ryu17@gmail.com', 102, '2023-09-05 06:31:42', 1),
(285, '::1', 'dzaky', NULL, '2023-09-05 06:33:29', 0),
(286, '::1', 'dzaky', NULL, '2023-09-05 06:33:34', 0),
(287, '::1', 'putra.ryu17@gmail.com', 102, '2023-09-05 06:33:43', 1),
(288, '::1', 'putra.ryu17@gmail.com', 102, '2023-09-05 06:36:47', 1),
(289, '::1', 'putra.ryu17@gmail.com', 102, '2023-09-05 06:41:52', 1),
(290, '::1', 'dzaky', NULL, '2023-09-05 06:47:12', 0),
(291, '::1', 'putra.ryu17@gmail.com', 102, '2023-09-05 06:47:27', 1),
(292, '::1', 'putra.ryu17@gmail.com', 102, '2023-09-05 19:13:58', 1),
(293, '::1', 'adark8957@gmail.com', 6, '2023-09-05 19:14:26', 1),
(294, '::1', 'admin', NULL, '2023-09-05 19:42:13', 0),
(295, '::1', 'admin@gmail.com', 1, '2023-09-05 20:07:57', 1),
(296, '::1', 'lailayasmin541@gmail.com', 2, '2023-09-05 20:48:28', 1),
(297, '::1', 'fahmi@gmail.com', 3, '2023-09-05 21:21:30', 1),
(298, '::1', 'cecep', NULL, '2023-09-05 22:14:27', 0),
(299, '::1', 'cecep@gmail.com', 4, '2023-09-05 22:14:33', 1),
(300, '::1', 'fahmi@gmail.com', 3, '2023-09-05 22:15:34', 1),
(301, '::1', 'cecep@gmail.com', 4, '2023-09-05 22:20:00', 1),
(302, '::1', 'muhammad@gmail.com', 5, '2023-09-05 22:29:13', 1),
(303, '::1', 'admin@gmail.com', 1, '2023-09-06 16:42:41', 1),
(304, '::1', 'fahmi@gmail.com', 6, '2023-09-06 18:03:17', 1),
(305, '::1', 'muhammad@gmail.com', 5, '2023-09-06 18:08:04', 1),
(306, '::1', 'muhammad@gmail.com', 5, '2023-09-06 22:14:06', 1),
(307, '::1', 'muhammad@gmail.com', 5, '2023-09-06 22:16:03', 1),
(308, '::1', 'muhammad', 5, '2023-09-06 22:26:41', 0),
(309, '::1', 'admin', 1, '2023-09-06 22:26:47', 0),
(310, '::1', 'muhammad', 5, '2023-09-06 22:27:03', 0),
(311, '::1', 'admin@gmail.com', 1, '2023-09-06 22:27:10', 1),
(312, '::1', 'muhammad@gmail.com', 5, '2023-09-07 01:39:51', 1),
(313, '::1', 'muhammad', 5, '2023-09-07 01:40:16', 0),
(314, '::1', 'fahmi', 6, '2023-09-07 01:40:59', 0),
(315, '::1', 'fahmi', NULL, '2023-09-07 01:41:10', 0),
(316, '::1', 'fahmi@gmail.com', 6, '2023-09-07 01:41:15', 1),
(317, '::1', 'sams', NULL, '2023-09-07 17:58:49', 0),
(318, '::1', 'admin@gmail.com', 1, '2023-09-07 17:59:00', 1),
(319, '::1', 'admin@gmail.com', 1, '2023-09-08 19:41:46', 1),
(320, '::1', 'muhammad@gmail.com', 5, '2023-09-08 20:37:20', 1),
(321, '::1', 'muhammad@gmail.com', 5, '2023-09-08 20:40:36', 1),
(322, '::1', 'fahmi@gmail.com', 6, '2023-09-08 23:54:46', 1),
(323, '::1', 'admin@gmail.com', 1, '2023-09-10 01:08:26', 1),
(324, '::1', 'muhammad@gmail.com', 5, '2023-09-10 01:09:14', 1),
(325, '::1', 'admin@gmail.com', 1, '2023-09-10 04:42:01', 1),
(326, '::1', 'fahmi', NULL, '2023-09-10 04:42:40', 0),
(327, '::1', 'fahmi', NULL, '2023-09-10 04:43:19', 0),
(328, '::1', 'fahmi@gmail.com', 6, '2023-09-10 04:43:27', 1),
(329, '::1', 'muhammad@gmail.com', 5, '2023-09-10 04:43:47', 1),
(330, '::1', 'admin', NULL, '2023-09-11 13:28:02', 0),
(331, '::1', 'admin', NULL, '2023-09-11 13:28:38', 0),
(332, '::1', 'admin@gmail.com', 1, '2023-09-11 13:29:15', 1),
(333, '::1', 'muhammad@gmail.com', 5, '2023-09-11 13:34:17', 1),
(334, '::1', 'admin@gmail.com', 1, '2023-09-12 02:52:19', 1),
(335, '::1', 'muhammad@gmail.com', 5, '2023-09-12 02:52:48', 1),
(336, '::1', 'muhammad@gmail.com', 5, '2023-09-12 07:03:41', 1),
(337, '::1', 'fahmi@gmail.com', 6, '2023-09-12 07:20:21', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `auth_permissions`
--

CREATE TABLE `auth_permissions` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `auth_permissions`
--

INSERT INTO `auth_permissions` (`id`, `name`, `description`) VALUES
(1, 'kelola-users', 'Kelola Semua Users'),
(2, 'kelola-data-master', 'Kelola Semua Data Master'),
(3, 'kelola-profile-users', 'Kelola Profile Users');

-- --------------------------------------------------------

--
-- Struktur dari tabel `auth_reset_attempts`
--

CREATE TABLE `auth_reset_attempts` (
  `id` int(11) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `ip_address` varchar(255) NOT NULL,
  `user_agent` varchar(255) NOT NULL,
  `token` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `auth_tokens`
--

CREATE TABLE `auth_tokens` (
  `id` int(11) UNSIGNED NOT NULL,
  `selector` varchar(255) NOT NULL,
  `hashedValidator` varchar(255) NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `expires` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `auth_users_permissions`
--

CREATE TABLE `auth_users_permissions` (
  `user_id` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `permission_id` int(11) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(1, '2017-11-20-223112', 'Myth\\Auth\\Database\\Migrations\\CreateAuthTables', 'default', 'Myth\\Auth', 1689563218, 1),
(2, '2023-09-12-034618', 'App\\Database\\Migrations\\Informasi', 'default', 'App', 1694490504, 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_absen_guru`
--

CREATE TABLE `tbl_absen_guru` (
  `id` int(11) NOT NULL,
  `guru_id` int(10) UNSIGNED NOT NULL,
  `qr_id` int(11) NOT NULL,
  `jam_masuk` varchar(128) NOT NULL,
  `jam_keluar` varchar(128) NOT NULL,
  `keterangan` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_absen_santri`
--

CREATE TABLE `tbl_absen_santri` (
  `id` int(11) NOT NULL,
  `santri_id` int(10) UNSIGNED NOT NULL,
  `qr_id` int(11) NOT NULL,
  `jam_masuk` varchar(128) NOT NULL,
  `jam_keluar` varchar(128) NOT NULL,
  `keterangan` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tbl_absen_santri`
--

INSERT INTO `tbl_absen_santri` (`id`, `santri_id`, `qr_id`, `jam_masuk`, `jam_keluar`, `keterangan`) VALUES
(78, 2, 17, '14:29:45', '14:31:03', 'hadir'),
(79, 1, 17, '', '', 'izin'),
(80, 3, 17, '', '', 'tanpa keterangan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_arsip`
--

CREATE TABLE `tbl_arsip` (
  `id_berkas` int(11) UNSIGNED NOT NULL,
  `berkas` varchar(100) NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `tbl_arsip`
--

INSERT INTO `tbl_arsip` (`id_berkas`, `berkas`, `keterangan`, `created_at`, `updated_at`) VALUES
(1, '1694500011_9a91f145d0a1ece4c9af.pdf', 'informasi 1', '2023-09-12 06:14:09', '2023-09-12 06:26:51'),
(2, '1694500261_8d021ccc0801c07a87ab.pdf', 'informasi 2', '2023-09-12 06:31:01', '2023-09-12 06:31:01');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_guru`
--

CREATE TABLE `tbl_guru` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `id_mp` int(11) DEFAULT NULL,
  `nik` varchar(128) NOT NULL,
  `jenis_kelamin` varchar(128) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `alamat` varchar(128) NOT NULL,
  `no_telepon` varchar(128) NOT NULL,
  `pendidikan_terakhir` varchar(128) NOT NULL,
  `pengalaman_mengajar` varchar(300) NOT NULL,
  `tentang_pengajar` varchar(300) NOT NULL,
  `status_perkawinan` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tbl_guru`
--

INSERT INTO `tbl_guru` (`id`, `user_id`, `id_mp`, `nik`, `jenis_kelamin`, `tanggal_lahir`, `alamat`, `no_telepon`, `pendidikan_terakhir`, `pengalaman_mengajar`, `tentang_pengajar`, `status_perkawinan`) VALUES
(1, 6, 10, '191011400791', 'Laki-Laki', '2023-09-12', 'Tangerang', '08229467', 'S1', 'TAFSIR JALALAIN', 'adasd', 'Menikah'),
(2, 7, 20, '191011400794', '', '0000-00-00', '', '', '', '', '', ''),
(4, 8, 11, '191011400792', '', '0000-00-00', '', '', '', '', '', ''),
(5, 10, 12, '191011400793', '', '0000-00-00', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_jadwal_pelajaran`
--

CREATE TABLE `tbl_jadwal_pelajaran` (
  `id` int(11) NOT NULL,
  `id_mp` int(11) DEFAULT NULL,
  `id_guru` int(11) UNSIGNED DEFAULT NULL,
  `id_kelas` int(11) DEFAULT NULL,
  `tahun_ajaran` varchar(128) NOT NULL,
  `semester` enum('Ganjil','Genap') DEFAULT NULL,
  `hari` varchar(128) NOT NULL,
  `jam` varchar(128) NOT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_akhir` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tbl_jadwal_pelajaran`
--

INSERT INTO `tbl_jadwal_pelajaran` (`id`, `id_mp`, `id_guru`, `id_kelas`, `tahun_ajaran`, `semester`, `hari`, `jam`, `tanggal_mulai`, `tanggal_akhir`) VALUES
(2, 10, 1, 1, '2024/2025', 'Ganjil', 'Senin', '10:00-12:00', '2023-09-01', '2023-09-29'),
(3, 22, 2, 1, '2024/2025', 'Ganjil', 'Selasa', '10:00-12:00', '2023-09-01', '2023-09-29'),
(4, 13, 4, 1, '2024/2025', 'Ganjil', 'Rabu', '12:00-13:00', '2023-09-01', '2023-09-29'),
(5, 14, 5, 1, '2024/2025', 'Ganjil', 'Kamis', '12:00-14:00', '2023-09-01', '2023-09-29'),
(6, 15, 5, 1, '2024/2025', 'Ganjil', 'Jumat', '10:00-11:00', '2023-09-01', '2023-09-29'),
(7, 20, 1, 1, '2024/2025', 'Genap', 'Senin', '12:00-23:23', '2023-10-02', '2023-10-31'),
(8, 12, 2, 1, '2024/2025', 'Genap', 'Selasa', '09:09-07:09', '2023-10-02', '2023-10-31');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_kelas`
--

CREATE TABLE `tbl_kelas` (
  `id` int(11) NOT NULL,
  `nama_kelas` varchar(128) NOT NULL,
  `tingkat` varchar(128) NOT NULL,
  `kapasitas` varchar(128) NOT NULL,
  `id_guru` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tbl_kelas`
--

INSERT INTO `tbl_kelas` (`id`, `nama_kelas`, `tingkat`, `kapasitas`, `id_guru`) VALUES
(1, 'Kelas A', 'SD', '30', 1),
(2, 'Kelas B', 'SMP', '30', 4),
(3, 'Kelas C', 'SMA', '40', 2),
(5, 'Kelas D', 'TK', '20', 5);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_mp`
--

CREATE TABLE `tbl_mp` (
  `id` int(11) NOT NULL,
  `kode_mp` varchar(128) NOT NULL,
  `nama_mp` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tbl_mp`
--

INSERT INTO `tbl_mp` (`id`, `kode_mp`, `nama_mp`) VALUES
(10, 'MP01', 'Qur\'an'),
(11, 'MP02', 'Fiqih (Hukum Islam)'),
(12, 'MP03', 'Hadits (Tradisi Nabi)'),
(13, 'MP04', 'Aqidah'),
(14, 'MP05', 'Moral dan Etika Islam'),
(15, 'MP06', 'Tajwid '),
(16, 'MP07', 'Bahasa Arab'),
(17, 'MP08', 'Tafsir Qur\'an'),
(18, 'MP09', 'Nahwu dan Sharaf '),
(19, 'MP10', 'Sejarah Islam'),
(20, 'MP11', 'Sirah (Biografi Nabi Muhammad)'),
(21, 'MP12', 'Balaghah (Retorika Bahasa Arab)'),
(22, 'MP13', 'Ilmu Faraidh (Warisan dan Pewarisan)'),
(23, 'MP14', 'Adab (Etika dan Tata Krama)'),
(24, 'MP15', 'Akhlak Tasawuf (Etika Mistik Islam)'),
(25, 'MP16', 'Ujian Lisan'),
(27, 'MP17', 'Ujian Praktek');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_qrcode_guru`
--

CREATE TABLE `tbl_qrcode_guru` (
  `id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `jam_masuk` time NOT NULL,
  `jam_keluar` time NOT NULL,
  `qr_code` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tbl_qrcode_guru`
--

INSERT INTO `tbl_qrcode_guru` (`id`, `tanggal`, `jam_masuk`, `jam_keluar`, `qr_code`) VALUES
(60, '2023-08-01', '01:00:00', '02:00:00', 'qrcode_2023-08-01.png'),
(62, '2023-08-09', '15:00:00', '16:00:00', 'qrcode_2023-08-09.png'),
(63, '2023-08-02', '09:00:00', '11:00:00', 'qrcode_2023-08-02.png'),
(64, '2023-09-12', '14:30:00', '15:00:00', 'qrcode_2023-09-12.png');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_qrcode_santri`
--

CREATE TABLE `tbl_qrcode_santri` (
  `id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `jam_masuk` time NOT NULL,
  `jam_keluar` time NOT NULL,
  `qr_code` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tbl_qrcode_santri`
--

INSERT INTO `tbl_qrcode_santri` (`id`, `tanggal`, `jam_masuk`, `jam_keluar`, `qr_code`) VALUES
(7, '2023-08-01', '02:50:00', '03:00:00', 'qrcode_2023-08-01.png'),
(8, '2023-08-02', '03:00:00', '04:00:00', 'qrcode_2023-08-02.png'),
(9, '2023-08-04', '09:00:00', '10:00:00', 'qrcode_2023-08-04.png'),
(10, '2023-08-07', '09:00:00', '10:00:00', 'qrcode_2023-08-07.png'),
(11, '2023-08-03', '09:00:00', '11:00:00', 'qrcode_2023-08-03.png'),
(12, '2023-08-08', '09:00:00', '11:00:00', 'qrcode_2023-08-08.png'),
(13, '2023-08-09', '09:00:00', '11:00:00', 'qrcode_2023-08-09.png'),
(14, '2023-08-10', '09:00:00', '11:00:00', 'qrcode_2023-08-10.png'),
(15, '2023-08-11', '09:00:00', '11:00:00', 'qrcode_2023-08-11.png'),
(16, '2023-08-14', '01:00:00', '03:00:00', 'qrcode_2023-08-14.png'),
(17, '2023-09-12', '12:30:00', '14:30:00', 'qrcode_2023-09-12.png');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_santri`
--

CREATE TABLE `tbl_santri` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `nis` varchar(128) NOT NULL,
  `id_kelas` int(11) DEFAULT NULL,
  `kelas` varchar(128) NOT NULL,
  `awal_masuk` year(4) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `jenis_kelamin` varchar(128) NOT NULL,
  `riwayat_akademik` varchar(128) NOT NULL,
  `riwayat_kesehatan` varchar(128) NOT NULL,
  `nama_ortu` varchar(128) NOT NULL,
  `nama_kontak_darurat` varchar(128) NOT NULL,
  `telepon_kontak_darurat` varchar(128) NOT NULL,
  `status` varchar(128) NOT NULL,
  `alamat` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tbl_santri`
--

INSERT INTO `tbl_santri` (`id`, `user_id`, `nis`, `id_kelas`, `kelas`, `awal_masuk`, `tanggal_lahir`, `jenis_kelamin`, `riwayat_akademik`, `riwayat_kesehatan`, `nama_ortu`, `nama_kontak_darurat`, `telepon_kontak_darurat`, `status`, `alamat`) VALUES
(1, 2, '19291', 1, '4', '2019', '2023-09-05', 'Perempuan', 'SMP Tunas Bangsa', 'Sehat bugar', 'Rony', 'Rony', '6282294364870', 'Lama', 'jalan kp Plered rt03/011 no 30 Ciledug, Tangerang, Banten'),
(2, 5, '19292', 1, '6', '2019', '2023-09-01', 'Laki-Laki', 'SMA Berjuang', 'Sehat walafiat', 'Lex', 'dasdasdasd', '09834324324', 'Baru', 'Ciledug Indah 2 Blok C 5 No20\r\n'),
(3, 9, '19293', 1, '2', '0000', '0000-00-00', '', '', '', '', '', '6282294364870', '', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_transkrip_nilai`
--

CREATE TABLE `tbl_transkrip_nilai` (
  `id` int(11) NOT NULL,
  `id_santri` int(11) UNSIGNED NOT NULL,
  `id_jadwal_pelajaran` int(11) NOT NULL,
  `id_mata_pelajaran_1` int(11) NOT NULL,
  `id_mata_pelajaran_2` int(11) NOT NULL,
  `id_mata_pelajaran_3` int(11) NOT NULL,
  `id_mata_pelajaran_4` int(11) NOT NULL,
  `id_mata_pelajaran_5` int(11) NOT NULL,
  `id_mata_pelajaran_6` int(11) NOT NULL,
  `id_mata_pelajaran_7` int(11) NOT NULL,
  `nilai_tugas` varchar(128) NOT NULL,
  `nilai_uts` varchar(128) NOT NULL,
  `nilai_uas` varchar(128) NOT NULL,
  `nilai_rapot` varchar(128) NOT NULL,
  `total_nilai` varchar(128) NOT NULL,
  `rata_rata_nilai` decimal(10,2) NOT NULL,
  `tulisan` varchar(128) NOT NULL,
  `grade` char(1) NOT NULL,
  `kelakuan` varchar(128) NOT NULL,
  `kerajianan` varchar(128) NOT NULL,
  `kerapian` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tbl_transkrip_nilai`
--

INSERT INTO `tbl_transkrip_nilai` (`id`, `id_santri`, `id_jadwal_pelajaran`, `id_mata_pelajaran_1`, `id_mata_pelajaran_2`, `id_mata_pelajaran_3`, `id_mata_pelajaran_4`, `id_mata_pelajaran_5`, `id_mata_pelajaran_6`, `id_mata_pelajaran_7`, `nilai_tugas`, `nilai_uts`, `nilai_uas`, `nilai_rapot`, `total_nilai`, `rata_rata_nilai`, `tulisan`, `grade`, `kelakuan`, `kerajianan`, `kerapian`) VALUES
(2, 1, 2, 11, 10, 12, 13, 18, 25, 27, '100,100,100,100,100,100,100', '80,80,80,80,80,80,80', '90,90,90,90,90,90,90', '96,96,96,96,96,96,96', '672', 96.00, 'Sembilan puluh enam koma nol', 'A', 'A', 'B', 'B'),
(3, 2, 2, 11, 12, 13, 14, 15, 25, 27, '90,90,90,90,90,90,90', '78,78,78,78,78,78,78', '78,78,78,80,80,80,90', '86.4,86.4,86.4,86.8,86.8,86.8,88.8', '608.4', 86.91, 'Delapan puluh enam koma sembilan', 'B', 'A', 'A', 'A'),
(4, 2, 7, 10, 11, 13, 16, 19, 25, 27, '78,88,75,90,77,90,100', '80,78,87,68,88,87,78', '90,90,90,90,90,90,90', '80.6,87.4,79.2,87.8,80.7,89.7,95.8', '601.2', 85.89, 'Delapan puluh lima koma delapan', 'B', '', '', ''),
(7, 1, 2, 10, 11, 12, 13, 14, 25, 27, '', '', '', '', '', 0.00, '', '', '', '', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `name` varchar(128) NOT NULL,
  `image` varchar(128) DEFAULT 'default.jpg',
  `username` varchar(30) DEFAULT NULL,
  `password_hash` varchar(255) NOT NULL,
  `reset_hash` varchar(255) DEFAULT NULL,
  `reset_at` datetime DEFAULT NULL,
  `reset_expires` datetime DEFAULT NULL,
  `activate_hash` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `status_message` varchar(255) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 0,
  `force_pass_reset` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `email`, `name`, `image`, `username`, `password_hash`, `reset_hash`, `reset_at`, `reset_expires`, `activate_hash`, `status`, `status_message`, `active`, `force_pass_reset`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'admin@gmail.com', 'Administrator', 'default.jpg', 'admin', '$2y$10$fEu4GMkJ3GiLEyj6NMLZjunXYru/B0MBFKtaS3Z1yZsi/Oih0X.pu', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2023-09-05 20:06:49', '2023-09-05 20:06:49', NULL),
(2, 'lailayasmin541@gmail.com', 'Laila Yasmin', 'default.jpg', 'laila', '$2y$10$Bvmj4EEDQdaE1Mwjy82d..hXgyNFdtcFvDoWnlxqb1THNuV1gg0sK', NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, '2023-09-05 20:47:51', '2023-09-07 01:40:43', NULL),
(5, 'muhammad@gmail.com', 'Muhammad Dzaky Alfatih ', '1693953951_a78dd8465fd3f90fd89c.jpg', 'muhammad ', '$2y$10$CEkbDpwiUbOWPVSy/4Y17.CIomylEqPFK08JCPQnb6KFvShXvyPhi', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2023-09-05 22:28:49', '2023-09-07 01:40:48', NULL),
(6, 'fahmi@gmail.com', 'Fahmi Akmaludin', '1694023557_7e245a1bae53f68de839.png', 'fahmi', '$2y$10$vwUN8vWnhzl89Bb4qVTtvOuGxldF/6WeydAUpUU.T4stSjBzzm3K2', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2023-09-06 17:40:53', '2023-09-10 04:43:05', NULL),
(7, 'cecep@gmail.com', 'Cecep Fuad Audah', 'default.jpg', 'cecep', '$2y$10$wYPkjMgfcZKgtt/Fn3iAqeCo1GqAr7DNs0G9QUZaQn9MBGCWl3mCe', NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, '2023-09-06 19:45:22', '2023-09-07 01:40:32', NULL),
(8, 'asadullah@gmail.com', 'Asadullah Alwy Alaydrus', 'default.jpg', 'asadullah', '$2y$10$mbqeIoflgo1Zac67p28kDOo7HBAU9Y9RVBtorfX54cq7rXDGzDpOC', NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, '2023-09-06 20:33:00', '2023-09-07 01:40:35', NULL),
(9, 'malikmawik78@gmail.com', 'Malik sumanang', 'default.jpg', 'malikmawik78', '$2y$10$TQNh31jGDrvx.AAhrqdbPOOv769r7JFnP9uLkguKPxCVoXzLgzqum', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2023-09-06 20:35:11', '2023-09-06 20:35:11', NULL),
(10, 'divaaudiaazzahra@gmail.com', 'Diva Audia Azzahra', 'default.jpg', 'diva', '$2y$10$hT1x5/iGGsojB5Khg1zCxe.JCh4kS4fSVs0hQBZ7SYpsFRvVD46LK', NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, '2023-09-06 20:57:31', '2023-09-07 01:40:38', NULL);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `auth_activation_attempts`
--
ALTER TABLE `auth_activation_attempts`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `auth_groups`
--
ALTER TABLE `auth_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `auth_groups_permissions`
--
ALTER TABLE `auth_groups_permissions`
  ADD KEY `auth_groups_permissions_permission_id_foreign` (`permission_id`),
  ADD KEY `group_id_permission_id` (`group_id`,`permission_id`);

--
-- Indeks untuk tabel `auth_groups_users`
--
ALTER TABLE `auth_groups_users`
  ADD KEY `auth_groups_users_user_id_foreign` (`user_id`),
  ADD KEY `group_id_user_id` (`group_id`,`user_id`);

--
-- Indeks untuk tabel `auth_logins`
--
ALTER TABLE `auth_logins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email` (`email`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `auth_permissions`
--
ALTER TABLE `auth_permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `auth_reset_attempts`
--
ALTER TABLE `auth_reset_attempts`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `auth_tokens`
--
ALTER TABLE `auth_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `auth_tokens_user_id_foreign` (`user_id`),
  ADD KEY `selector` (`selector`);

--
-- Indeks untuk tabel `auth_users_permissions`
--
ALTER TABLE `auth_users_permissions`
  ADD KEY `auth_users_permissions_permission_id_foreign` (`permission_id`),
  ADD KEY `user_id_permission_id` (`user_id`,`permission_id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_absen_guru`
--
ALTER TABLE `tbl_absen_guru`
  ADD PRIMARY KEY (`id`),
  ADD KEY `guru_id` (`guru_id`),
  ADD KEY `qr_id` (`qr_id`);

--
-- Indeks untuk tabel `tbl_absen_santri`
--
ALTER TABLE `tbl_absen_santri`
  ADD PRIMARY KEY (`id`),
  ADD KEY `santri_id` (`santri_id`,`qr_id`),
  ADD KEY `qr_id` (`qr_id`);

--
-- Indeks untuk tabel `tbl_arsip`
--
ALTER TABLE `tbl_arsip`
  ADD PRIMARY KEY (`id_berkas`);

--
-- Indeks untuk tabel `tbl_guru`
--
ALTER TABLE `tbl_guru`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `users_id` (`user_id`),
  ADD KEY `id_mp` (`id_mp`);

--
-- Indeks untuk tabel `tbl_jadwal_pelajaran`
--
ALTER TABLE `tbl_jadwal_pelajaran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_mp` (`id_mp`,`id_guru`),
  ADD KEY `id_kelas` (`id_kelas`),
  ADD KEY `tbl_jadwal_pelajaran_ibfk_3` (`id_guru`);

--
-- Indeks untuk tabel `tbl_kelas`
--
ALTER TABLE `tbl_kelas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_guru` (`id_guru`);

--
-- Indeks untuk tabel `tbl_mp`
--
ALTER TABLE `tbl_mp`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_qrcode_guru`
--
ALTER TABLE `tbl_qrcode_guru`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_qrcode_santri`
--
ALTER TABLE `tbl_qrcode_santri`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_santri`
--
ALTER TABLE `tbl_santri`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `users_id` (`user_id`),
  ADD KEY `user_id_2` (`user_id`),
  ADD KEY `id_kelas` (`id_kelas`);

--
-- Indeks untuk tabel `tbl_transkrip_nilai`
--
ALTER TABLE `tbl_transkrip_nilai`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_santri` (`id_santri`,`id_jadwal_pelajaran`,`id_mata_pelajaran_1`),
  ADD KEY `tbl_transkrip_nilai_ibfk_2` (`id_jadwal_pelajaran`),
  ADD KEY `id_mata_pelajaran_1` (`id_mata_pelajaran_1`),
  ADD KEY `id_mata_pelajaran_2` (`id_mata_pelajaran_2`,`id_mata_pelajaran_3`),
  ADD KEY `tbl_transkrip_nilai_ibfk_5` (`id_mata_pelajaran_3`),
  ADD KEY `id_mata_pelajaran_4` (`id_mata_pelajaran_4`,`id_mata_pelajaran_5`,`id_mata_pelajaran_6`,`id_mata_pelajaran_7`),
  ADD KEY `tbl_transkrip_nilai_ibfk_7` (`id_mata_pelajaran_5`),
  ADD KEY `id_mata_pelajaran_6` (`id_mata_pelajaran_6`),
  ADD KEY `id_mata_pelajaran_7` (`id_mata_pelajaran_7`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `auth_activation_attempts`
--
ALTER TABLE `auth_activation_attempts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `auth_groups`
--
ALTER TABLE `auth_groups`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `auth_logins`
--
ALTER TABLE `auth_logins`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=338;

--
-- AUTO_INCREMENT untuk tabel `auth_permissions`
--
ALTER TABLE `auth_permissions`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `auth_reset_attempts`
--
ALTER TABLE `auth_reset_attempts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `auth_tokens`
--
ALTER TABLE `auth_tokens`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `tbl_absen_guru`
--
ALTER TABLE `tbl_absen_guru`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT untuk tabel `tbl_absen_santri`
--
ALTER TABLE `tbl_absen_santri`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT untuk tabel `tbl_arsip`
--
ALTER TABLE `tbl_arsip`
  MODIFY `id_berkas` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `tbl_guru`
--
ALTER TABLE `tbl_guru`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `tbl_jadwal_pelajaran`
--
ALTER TABLE `tbl_jadwal_pelajaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `tbl_kelas`
--
ALTER TABLE `tbl_kelas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `tbl_mp`
--
ALTER TABLE `tbl_mp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT untuk tabel `tbl_qrcode_guru`
--
ALTER TABLE `tbl_qrcode_guru`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT untuk tabel `tbl_qrcode_santri`
--
ALTER TABLE `tbl_qrcode_santri`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `tbl_santri`
--
ALTER TABLE `tbl_santri`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `tbl_transkrip_nilai`
--
ALTER TABLE `tbl_transkrip_nilai`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `auth_groups_permissions`
--
ALTER TABLE `auth_groups_permissions`
  ADD CONSTRAINT `auth_groups_permissions_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `auth_groups` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `auth_groups_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `auth_permissions` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `auth_groups_users`
--
ALTER TABLE `auth_groups_users`
  ADD CONSTRAINT `auth_groups_users_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `auth_groups` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `auth_groups_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `auth_tokens`
--
ALTER TABLE `auth_tokens`
  ADD CONSTRAINT `auth_tokens_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `auth_users_permissions`
--
ALTER TABLE `auth_users_permissions`
  ADD CONSTRAINT `auth_users_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `auth_permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `auth_users_permissions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tbl_absen_guru`
--
ALTER TABLE `tbl_absen_guru`
  ADD CONSTRAINT `tbl_absen_guru_ibfk_1` FOREIGN KEY (`qr_id`) REFERENCES `tbl_qrcode_guru` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_absen_guru_ibfk_2` FOREIGN KEY (`guru_id`) REFERENCES `tbl_guru` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tbl_absen_santri`
--
ALTER TABLE `tbl_absen_santri`
  ADD CONSTRAINT `tbl_absen_santri_ibfk_1` FOREIGN KEY (`santri_id`) REFERENCES `tbl_santri` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_absen_santri_ibfk_2` FOREIGN KEY (`qr_id`) REFERENCES `tbl_qrcode_santri` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tbl_guru`
--
ALTER TABLE `tbl_guru`
  ADD CONSTRAINT `tbl_guru_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_guru_ibfk_2` FOREIGN KEY (`id_mp`) REFERENCES `tbl_mp` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tbl_jadwal_pelajaran`
--
ALTER TABLE `tbl_jadwal_pelajaran`
  ADD CONSTRAINT `tbl_jadwal_pelajaran_ibfk_2` FOREIGN KEY (`id_mp`) REFERENCES `tbl_mp` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_jadwal_pelajaran_ibfk_3` FOREIGN KEY (`id_guru`) REFERENCES `tbl_guru` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_jadwal_pelajaran_ibfk_4` FOREIGN KEY (`id_kelas`) REFERENCES `tbl_kelas` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tbl_kelas`
--
ALTER TABLE `tbl_kelas`
  ADD CONSTRAINT `tbl_kelas_ibfk_1` FOREIGN KEY (`id_guru`) REFERENCES `tbl_guru` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tbl_santri`
--
ALTER TABLE `tbl_santri`
  ADD CONSTRAINT `tbl_santri_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_santri_ibfk_2` FOREIGN KEY (`id_kelas`) REFERENCES `tbl_kelas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tbl_transkrip_nilai`
--
ALTER TABLE `tbl_transkrip_nilai`
  ADD CONSTRAINT `tbl_transkrip_nilai_ibfk_1` FOREIGN KEY (`id_santri`) REFERENCES `tbl_santri` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_transkrip_nilai_ibfk_2` FOREIGN KEY (`id_jadwal_pelajaran`) REFERENCES `tbl_jadwal_pelajaran` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_transkrip_nilai_ibfk_3` FOREIGN KEY (`id_mata_pelajaran_1`) REFERENCES `tbl_mp` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_transkrip_nilai_ibfk_4` FOREIGN KEY (`id_mata_pelajaran_2`) REFERENCES `tbl_mp` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_transkrip_nilai_ibfk_5` FOREIGN KEY (`id_mata_pelajaran_3`) REFERENCES `tbl_mp` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_transkrip_nilai_ibfk_6` FOREIGN KEY (`id_mata_pelajaran_4`) REFERENCES `tbl_mp` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_transkrip_nilai_ibfk_7` FOREIGN KEY (`id_mata_pelajaran_5`) REFERENCES `tbl_mp` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_transkrip_nilai_ibfk_8` FOREIGN KEY (`id_mata_pelajaran_6`) REFERENCES `tbl_mp` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_transkrip_nilai_ibfk_9` FOREIGN KEY (`id_mata_pelajaran_7`) REFERENCES `tbl_mp` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
