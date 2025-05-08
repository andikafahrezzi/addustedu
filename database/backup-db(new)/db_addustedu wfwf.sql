-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 08, 2025 at 06:56 AM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 7.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_addustedu`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(64) NOT NULL,
  `username` varchar(128) NOT NULL,
  `password` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `user_type` enum('admin') NOT NULL DEFAULT 'admin'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `email`, `user_type`) VALUES
(0, 'admin', '$2y$10$EX0L5MeIQldpkCuTZW.mjujTaj.Yy20IW0GOluecU/c.es.9r6E5.', 'admin@gmail.com', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `bank_soal`
--

CREATE TABLE `bank_soal` (
  `id_soal` int(11) NOT NULL,
  `pertanyaan` text NOT NULL,
  `pilihan_a` text DEFAULT NULL,
  `pilihan_b` text DEFAULT NULL,
  `pilihan_c` text DEFAULT NULL,
  `pilihan_d` text DEFAULT NULL,
  `kunci_jawaban` enum('A','B','C','D') DEFAULT NULL,
  `tingkat_kesulitan` enum('mudah','sedang','sulit') DEFAULT 'sedang',
  `tipe_kognitif` enum('ingatan','paham','aplikasi','analisis','evaluasi','kreasi') DEFAULT 'paham',
  `created_by` int(11) DEFAULT NULL,
  `user_type` enum('admin','guru') NOT NULL,
  `mapel_diajarkan` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `tipe_soal` enum('pilihan','essay') NOT NULL DEFAULT 'pilihan'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bank_soal`
--

INSERT INTO `bank_soal` (`id_soal`, `pertanyaan`, `pilihan_a`, `pilihan_b`, `pilihan_c`, `pilihan_d`, `kunci_jawaban`, `tingkat_kesulitan`, `tipe_kognitif`, `created_by`, `user_type`, `mapel_diajarkan`, `created_at`, `tipe_soal`) VALUES
(1, 'ww', 'e3e3e3', 'sdsds', 'e3e3e', 'sdsdsd', 'A', 'mudah', 'evaluasi', 0, 'admin', 'sddss', '2025-05-01 06:47:58', 'pilihan'),
(2, 'dwdw', 'dwwdw', 'dww', 'wdw', 'wdw', 'A', 'mudah', 'aplikasi', 0, 'admin', 'dwwd', '2025-05-01 07:06:54', 'pilihan'),
(6, 'wwW', 'ww', 'ww', 'ww', 'ww', 'A', 'sedang', 'paham', 21101140, 'guru', 'Matematika', '2025-05-01 12:55:44', 'pilihan'),
(7, 'XXX', 'WXXX', 'XX', 'XXX', 'XXX', 'A', 'sulit', 'evaluasi', 21101140, 'guru', 'Matematika', '2025-05-01 13:30:14', 'pilihan'),
(8, 'qqq', NULL, NULL, NULL, NULL, NULL, 'sulit', 'evaluasi', 21101140, 'guru', 'Matematika', '2025-05-03 10:56:51', 'essay'),
(9, 'dqwddqwd', 'q', 'q', 'q', 'q', 'A', 'mudah', 'ingatan', 21101140, 'guru', 'Matematika', '2025-05-03 10:57:01', 'pilihan'),
(10, 'aaa', 'aa', 'aa', 'aa', 'aa', 'A', 'sedang', 'paham', 0, 'admin', 'aaa', '2025-05-03 06:26:05', 'pilihan'),
(11, 'ww', 'a', NULL, NULL, NULL, NULL, 'sulit', 'paham', 0, 'admin', 'ww', '2025-05-03 06:26:57', 'essay'),
(12, 'asewd', 'fewfewfwe', 'ffewe', 'ewfew', 'fewf', 'A', 'mudah', 'evaluasi', 0, 'admin', 'Matematika', '2025-05-03 14:01:53', 'pilihan'),
(13, 'WW', 'A', 'A', 'A', 'A', 'A', 'sedang', 'paham', 21101140, 'guru', 'Matematika', '2025-05-03 21:04:23', 'pilihan'),
(14, 'qq', 'qq', 'qq', 'qq', 'q', 'A', 'sedang', 'paham', 0, 'admin', 'qq', '2025-05-04 09:39:49', 'pilihan'),
(15, 'sqsqs', 'qs', 'sq', 'sq', 'qsqsq', 'A', 'sedang', 'paham', 21101140, 'guru', 'Matematika', '2025-05-04 14:40:15', 'pilihan'),
(16, 'q', 'sqsq', 's', 'sqqs', 's', 'A', 'sedang', 'paham', 21101140, 'guru', 'Matematika', '2025-05-07 11:27:01', 'pilihan');

-- --------------------------------------------------------

--
-- Table structure for table `forum_diskusi`
--

CREATE TABLE `forum_diskusi` (
  `id` int(11) NOT NULL,
  `nis` int(20) NOT NULL,
  `materi_id` int(11) NOT NULL,
  `user` varchar(100) NOT NULL,
  `komentar` text NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `last_edit_time` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `forum_diskusi`
--

INSERT INTO `forum_diskusi` (`id`, `nis`, `materi_id`, `user`, `komentar`, `parent_id`, `tanggal`, `created_at`, `updated_at`, `last_edit_time`, `deleted_at`) VALUES
(100, 123456, 1, 'user', 's', NULL, '2025-04-19 07:34:51', '2025-04-19 19:34:51', NULL, NULL, NULL),
(109, 123456, 2, 'user', 'sss', NULL, '2025-05-07 01:05:22', '2025-05-07 13:05:22', NULL, NULL, NULL),
(110, 123456, 3, 'user', 'zzwww', NULL, '2025-05-07 01:06:21', '2025-05-07 13:06:21', '2025-05-07 08:21:13', NULL, NULL),
(111, 123456, 3, 'user', 'zz', NULL, '2025-05-07 01:11:20', '2025-05-07 13:11:20', NULL, NULL, NULL),
(112, 123456, 3, 'user', 'SS', NULL, '2025-05-07 01:13:03', '2025-05-07 13:13:03', NULL, NULL, NULL),
(113, 123456, 3, 'user', 's', NULL, '2025-05-07 01:17:49', '2025-05-07 13:17:49', NULL, NULL, NULL),
(114, 123456, 3, 'user', 'yyhx', NULL, '2025-05-07 01:19:28', '2025-05-07 13:19:28', NULL, NULL, NULL),
(115, 123456, 3, 'user', 'ww', 110, '2025-05-07 01:20:42', '2025-05-07 13:20:42', NULL, NULL, NULL),
(117, 123456, 2, 'user', 'ss', NULL, '2025-05-07 01:22:49', '2025-05-07 13:22:49', NULL, NULL, NULL),
(118, 123456, 1, 'user', 'y', NULL, '2025-05-07 01:23:43', '2025-05-07 13:23:43', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `guru`
--

CREATE TABLE `guru` (
  `nip` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `nama_guru` varchar(128) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_mapel` varchar(64) NOT NULL,
  `user_type` enum('guru') NOT NULL DEFAULT 'guru'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `guru`
--

INSERT INTO `guru` (`nip`, `email`, `nama_guru`, `password`, `nama_mapel`, `user_type`) VALUES
(21101140, 'pahrulmaji@gmail.com', 'guru terbaikss', '$2y$10$5b/MJhDxwMBoOBZ0m4nofOCPrwn9XM/RZu7xuG528R7P71k629SUS', 'Matematika', 'guru'),
(21101141, 'fahreziandika10@gmail.com', 'addust11', '$2y$10$nDOjyUB0msJL1E1FTC7PdeQTCR0ip441LfLFbHZk/g7f2EoQ2vOAO', 'Bahasa Inggris', 'guru'),
(21101142, 'test@gmail.com', 'addust111', '$2y$10$SnRGlMYTwJSElDgt6DUza.qK/8tCzJQQfogjZxZxTMXkqMDgeBRU.', 'IPA', 'guru'),
(21101143, 'test12@gmail.com', 'useraa', '$2y$10$nk3jFu4/ANCEkgrYFq4F6uYl2UZQHLGtdCAYLSQ6eEkfT9quBoDo.', 'Test', 'guru'),
(21101144, 'test12221@gmail.com', 'guru terbaik semesta', '$2y$10$16NmySXyDi2PIaCKH83VkOx1vPCdR8TkGQo0KdyknzLsPnebJJrYK', 'Matematika', 'guru'),
(214748364, 'Dummy@gmail.com', 'Ahmad Saugi', '$2y$10$nvcd.PCpCxStCPws.gAfluw192h3YOqXHTZIIp44yDp5RuHfYlg72', 'Pendidikan Agama Islam', 'guru'),
(214748365, 'zaidanlineee67@gmail.com', 'Saauky', '$2y$10$3qQ2TYrtQHy44LblPMexnu4ZQrCWD.dYh20P.sOL5cyo6Z48fJQEq', 'Matematika', 'guru'),
(1819107728, 'imas@gmail.com', 'Imas Kartika', '$2y$10$wCSBYTaCpSJaEX/1VUo1p.YU88vbgr7PeW.j1OkmD2xnKjIbB7SD6', 'Matematika', 'guru');

-- --------------------------------------------------------

--
-- Table structure for table `jawaban_siswa`
--

CREATE TABLE `jawaban_siswa` (
  `id` int(11) NOT NULL,
  `quiz_siswa_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `jawaban` text DEFAULT NULL,
  `poin_diperoleh` decimal(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `jawaban_siswa`
--

INSERT INTO `jawaban_siswa` (`id`, `quiz_siswa_id`, `question_id`, `jawaban`, `poin_diperoleh`) VALUES
(20, 14, 29, 'a', '1.00'),
(21, 14, 30, 'a', '1.00'),
(22, 15, 29, 'a', '1.00'),
(23, 15, 30, 'a', '1.00'),
(24, 15, 38, 'a', '1.00'),
(25, 15, 39, 'a', '1.00'),
(26, 15, 40, 'a', '1.00'),
(27, 15, 41, 'a', '1.00'),
(28, 15, 42, 'a', '1.00'),
(29, 15, 43, 'a', '1.00'),
(30, 15, 44, 'a', '1.00'),
(31, 15, 45, 'a', '0.00'),
(32, 16, 31, 'a', '1.00'),
(33, 16, 32, 'a', '1.00'),
(34, 16, 33, 'a', '1.00'),
(35, 16, 34, 'a', '1.00'),
(36, 16, 35, 'a', '0.00'),
(37, 16, 36, 'a', '0.00'),
(38, 16, 37, 'a', '0.00');

-- --------------------------------------------------------

--
-- Table structure for table `kategori_soal`
--

CREATE TABLE `kategori_soal` (
  `id_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(100) NOT NULL,
  `deskripsi` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `kelas`
--

CREATE TABLE `kelas` (
  `id` int(255) NOT NULL,
  `kelas` varchar(128) NOT NULL,
  `nama_siswa` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `materi`
--

CREATE TABLE `materi` (
  `id` int(11) NOT NULL,
  `nama_guru` varchar(128) NOT NULL,
  `nama_mapel` varchar(128) NOT NULL,
  `video` varchar(255) NOT NULL,
  `deskripsi` varchar(1024) NOT NULL,
  `kelas` varchar(128) NOT NULL,
  `linkform` varchar(100) DEFAULT NULL,
  `modul` varchar(255) NOT NULL,
  `id_guru` int(11) DEFAULT NULL,
  `pertemuan` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `materi`
--

INSERT INTO `materi` (`id`, `nama_guru`, `nama_mapel`, `video`, `deskripsi`, `kelas`, `linkform`, `modul`, `id_guru`, `pertemuan`) VALUES
(1, 'addust11', 'Bahasa Inggris', 'WhatsApp_Video_2025-03-11_at_07_52_16_6ef15095.mp4', 'aku cinta dunia ini', 'XI', ' www.youtube.com', '4845-17134-1-PB.pdf', 21101141, 1),
(2, 'guru terbaikss', 'Matematika', 'WhatsApp_Video_2025-03-11_at_07_52_16_6ef150951.mp4', 'ss', 'XI', ' sss', '5141-11123-2-PB.pdf', 21101140, 1),
(3, 'addust111', 'IPA', 'WhatsApp_Video_2025-03-11_at_07_52_16_6ef150952.mp4', '2', 'XI', ' 2', '4845-17134-1-PB1.pdf', 21101142, 1),
(4, 'useraa', 'Test', 'WhatsApp_Video_2025-03-11_at_07_52_16_6ef150953.mp4', '2', 'XI', ' 2', '4845-17134-1-PB2.pdf', 21101143, 1),
(5, 'Ahmad Saugi', 'Pendidikan Agama Islam', 'WhatsApp_Video_2025-03-11_at_07_52_16_6ef150954.mp4', 's', 'XI', 's', '4845-17134-1-PB3.pdf', 214748364, 1),
(6, 'guru terbaikss', 'Matematika', 'WhatsApp_Video_2025-03-11_at_07_52_16_6ef150955.mp4', 'asa', 'XI', ' swa', '4845-17134-1-PB4.pdf', 21101140, 2),
(7, 'guru terbaikss', 'Matematika', 'WhatsApp_Video_2025-03-11_at_07_52_16_6ef150956.mp4', 'aasdsad', 'XI', ' adada', 'riyo.jpg', 21101140, 3);

-- --------------------------------------------------------

--
-- Table structure for table `materi_status`
--

CREATE TABLE `materi_status` (
  `id` int(11) NOT NULL,
  `siswa_id` int(11) NOT NULL,
  `materi_id` int(11) NOT NULL,
  `bookmarked` tinyint(1) DEFAULT 0,
  `completed` tinyint(1) DEFAULT 0,
  `completion_date` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `quiz`
--

CREATE TABLE `quiz` (
  `id` int(11) NOT NULL,
  `materi_id` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `waktu_pengerjaan` int(11) NOT NULL DEFAULT 30,
  `attempts` int(11) NOT NULL DEFAULT 1,
  `shuffle_questions` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `quiz`
--

INSERT INTO `quiz` (`id`, `materi_id`, `judul`, `deskripsi`, `waktu_pengerjaan`, `attempts`, `shuffle_questions`, `created_at`) VALUES
(16, 2, 'akuw', 'sss', 30, 1, 1, '2025-04-19 14:41:28'),
(17, 2, 'qsqs', '12121', 30, 1, 1, '2025-05-07 06:30:45');

-- --------------------------------------------------------

--
-- Table structure for table `quiz_questions`
--

CREATE TABLE `quiz_questions` (
  `id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `pertanyaan` text NOT NULL,
  `tipe` enum('pilihan','essay') NOT NULL DEFAULT 'pilihan',
  `opsi_a` text DEFAULT NULL,
  `opsi_b` text DEFAULT NULL,
  `opsi_c` text DEFAULT NULL,
  `opsi_d` text DEFAULT NULL,
  `jawaban` varchar(10) DEFAULT NULL,
  `poin` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `quiz_questions`
--

INSERT INTO `quiz_questions` (`id`, `quiz_id`, `pertanyaan`, `tipe`, `opsi_a`, `opsi_b`, `opsi_c`, `opsi_d`, `jawaban`, `poin`) VALUES
(29, 16, 'ewwdqd', 'pilihan', 'dqwqwdq', 'qdwqwd', 'qwdqd', 'qdwqwd', 'a', 1),
(30, 16, 'wdqdqd', 'pilihan', 'qwdqwdw', 'dqqwd', 'qwdqwd', 'dqqwd', 'a', 1),
(31, 17, 'qsqsqss', 'pilihan', 'qsqs', 'qsqs', 'sqqs', 'qss', 'a', 1),
(32, 17, 'qsqsqss', 'pilihan', 'qsqs', 'qsqs', 'sqqs', 'qss', 'a', 1),
(33, 17, 'wqdqdq', 'pilihan', 'dqwdqd', 'qwdqwd', 'dqwqwd', 'qdwqwd', 'a', 1),
(34, 17, 'qwdwdqdqwd', 'pilihan', 'qdqdqd', 'qdqwqw', 'qwdwdq', 'dwwqd', 'a', 1),
(35, 17, 'qwdwdqdqwd', 'pilihan', 'qdqdqd', 'qdqwqw', 'qwdwdq', 'dwwqd', NULL, 1),
(36, 17, 'qwqw', 'pilihan', 'dqwqdqwd', 'dqdq', 'dqwqw', 'dqqwd', NULL, 1),
(37, 17, 'wqeqewq', 'pilihan', 'eqwe', 'qwewqe', 'qweqw', 'qweqwe', NULL, 1),
(38, 16, 'dqwdqwd', 'pilihan', 'qwdqd', 'qdqwd', 'dwqdqw', 'dqwqwd', 'a', 1),
(39, 16, 'qwdqdqw', 'pilihan', 'qwdqwd', 'qwdwqdwqdqwdqwdq', 'qwdqdqwdw', 'qdqwdqd', 'a', 1),
(40, 16, 'dqdqwdqw', 'pilihan', 'qwddqw', 'dqdq', 'wqdqd', 'qwdq', 'a', 1),
(41, 16, 'qwdqdq', 'pilihan', 'qwdqwd', 'qwddwq', 'qwdqwd', 'dqwqwd', 'a', 1),
(42, 16, 'qwdqdq', 'pilihan', 'qwdqwd', 'qwddwq', 'qwdqwd', 'dqwqwd', 'a', 1),
(43, 16, 'dqwddw', 'pilihan', 'qwdqwd', 'qwdwqd', 'dqwqd', 'wqwd', 'a', 1),
(44, 16, 'qwdqwdqd', 'pilihan', 'dqwdqdq', 'qdwqwdqw', 'dqwqwd', 'qdwqwd', 'a', 1),
(45, 16, 'qwdqdqdqdad', 'pilihan', 'dadadad', 'dadada', 'asdsad', 'dadada', 'b', 1);

-- --------------------------------------------------------

--
-- Table structure for table `quiz_siswa`
--

CREATE TABLE `quiz_siswa` (
  `id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `siswa_id` int(11) NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime DEFAULT NULL,
  `status` enum('ongoing','completed') NOT NULL DEFAULT 'ongoing',
  `score` decimal(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `quiz_siswa`
--

INSERT INTO `quiz_siswa` (`id`, `quiz_id`, `siswa_id`, `start_time`, `end_time`, `status`, `score`) VALUES
(14, 16, 123456, '2025-04-19 14:41:53', '2025-04-19 14:41:57', 'completed', '100.00'),
(15, 16, 18883, '2025-05-07 07:44:15', '2025-05-07 07:46:35', 'completed', '90.00'),
(16, 17, 18883, '2025-05-07 07:46:53', '2025-05-07 07:48:19', 'completed', '57.14');

-- --------------------------------------------------------

--
-- Table structure for table `siswa`
--

CREATE TABLE `siswa` (
  `nis` int(64) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(128) NOT NULL,
  `image` varchar(255) NOT NULL,
  `is_active` int(1) NOT NULL,
  `date_created` date DEFAULT NULL,
  `kelas` varchar(5) NOT NULL DEFAULT '',
  `user_type` enum('siswa') NOT NULL DEFAULT 'siswa'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `siswa`
--

INSERT INTO `siswa` (`nis`, `nama`, `password`, `email`, `image`, `is_active`, `date_created`, `kelas`, `user_type`) VALUES
(18883, 'addusttt', '$2y$10$m3uP.Pe16p8NuQXi48Xen.EkUXHag.tcIq5.xzs2w.L88Ak0w7MYa', 'addust1@gmail.com', 'riyo1.jpg', 1, '0000-00-00', 'XI', 'siswa'),
(18889, 'dqwd dqwwd', '$2y$10$ltdxVHLhIRZNdaKO3dxcZuWKUesuadS5nG1IGtyb32lE4wC3aWK9a', 'tewwst@gmail.com', 'default.jpg', 1, '2025-05-08', 'XI', 'siswa'),
(123456, 'user', '$2y$10$lG3qWm29AejdK/HV2iIwDOGzIAo3Q3MqlxVcODDQrj.hQvBYwWkdi', 'use1@gmail.com', 'default.jpg', 1, '0000-00-00', 'XI', 'siswa'),
(147852, 'dwdqwddq', '$2y$10$3T5Nmo7ZQIiF.h4e9Qqxo.oRzcYXGlceENvn9gObYM9lsXlsBlzDG', 'test12@gmail.com', 'default.jpg', 1, '0000-00-00', 'XII', 'siswa'),
(181816, 'qsqwdqwd', '$2y$10$YJppxwZ1JOt3s1/Xf9rgWewsjN8ZIhK1b.F39GcTmVS0uy5oOlhDK', 'testwd@gmail.com', 'default.jpg', 1, '0000-00-00', 'XI', 'siswa'),
(211011, 'addust', '$2y$10$jxtWU6XSRAaV/kU0UqlUeurzzcp9EFVEuXJmwiGUrOSLjK9oSvjB6', '', 'default.jpg', 1, '0000-00-00', 'XI', 'siswa'),
(232332, 'aasdadee qw', '$2y$10$luY1AxePrqda2kLL61Vu0.i/ZEtGLEvmamD3E4nrjBktQ4z1Va3V2', 'testwewe1@gmail.com', 'default.jpg', 1, '0000-00-00', '', 'siswa'),
(456123, 'wqdqdqw', '$2y$10$/Rx33H/8HvUpFcj3F4AM7eqlFnR17N38y7pt8pt0Ew3kRI3HwcNqi', 'nasigirewww@gmail.com', 'default.jpg', 1, '0000-00-00', 'XII', 'siswa'),
(456789, 'nasi gile', '$2y$10$LwYTyg0Usc1SNcQe50HY3.7ZWcRIy926dKlbLA8bZrWtgFMoTZMvq', '', 'default.jpg', 1, '0000-00-00', 'XII', 'siswa'),
(12345678, 'fefew wfw', '$2y$10$anEA.vREhudmuVo5tDBtwuwKO/Fhn3vFtFYqGQ0Tb2.Tz5svOcnEK', 'tesewewt@gmail.com', '', 0, '0000-00-00', 'XI', 'siswa');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_jawaban_siswa`
--

CREATE TABLE `tbl_jawaban_siswa` (
  `id_jawaban` int(11) NOT NULL,
  `nis` int(11) DEFAULT NULL,
  `id_ujian` int(11) DEFAULT NULL,
  `id_soal` int(11) DEFAULT NULL,
  `bank_soal_id` int(11) DEFAULT NULL,
  `jawaban` varchar(1) DEFAULT NULL,
  `ragu_ragu` tinyint(1) DEFAULT 0,
  `is_selesai` tinyint(1) DEFAULT 0,
  `jumlah_benar` int(11) DEFAULT 0,
  `jumlah_salah` int(11) DEFAULT 0,
  `score` float DEFAULT 0,
  `tanggal_submit` datetime DEFAULT NULL,
  `waktu_jawab` timestamp NOT NULL DEFAULT current_timestamp(),
  `waktu_mulai_ujian` datetime DEFAULT NULL,
  `waktu_submit` datetime DEFAULT NULL,
  `sumber` enum('tbl_soal','bank_soal') NOT NULL DEFAULT 'tbl_soal'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_jawaban_siswa`
--

INSERT INTO `tbl_jawaban_siswa` (`id_jawaban`, `nis`, `id_ujian`, `id_soal`, `bank_soal_id`, `jawaban`, `ragu_ragu`, `is_selesai`, `jumlah_benar`, `jumlah_salah`, `score`, `tanggal_submit`, `waktu_jawab`, `waktu_mulai_ujian`, `waktu_submit`, `sumber`) VALUES
(158, 123456, 36, NULL, NULL, NULL, 0, 1, 2, 1, 66.6667, NULL, '2025-05-04 09:10:53', '2025-05-04 11:10:53', '2025-05-04 11:11:06', 'tbl_soal'),
(159, 123456, 36, 28, NULL, 'A', 0, 1, 2, 1, 66.6667, NULL, '2025-05-04 09:10:57', NULL, '2025-05-04 11:11:06', 'tbl_soal'),
(160, 123456, 36, 29, NULL, 'A', 0, 1, 2, 1, 66.6667, NULL, '2025-05-04 09:11:01', NULL, '2025-05-04 11:11:06', 'tbl_soal'),
(161, 123456, 35, NULL, NULL, NULL, 0, 0, 0, 0, 0, NULL, '2025-05-04 09:12:57', '2025-05-04 11:12:57', NULL, 'tbl_soal'),
(164, 123456, 37, NULL, NULL, NULL, 0, 1, 0, 1, 0, NULL, '2025-05-04 09:27:36', '2025-05-04 11:27:36', '2025-05-04 12:08:19', 'tbl_soal'),
(165, 123456, 47, NULL, NULL, NULL, 0, 1, 0, 1, 0, NULL, '2025-05-04 10:12:36', '2025-05-04 12:12:36', '2025-05-04 12:25:45', 'tbl_soal'),
(166, 123456, 38, NULL, NULL, NULL, 0, 0, 0, 0, 0, NULL, '2025-05-04 10:17:55', '2025-05-04 12:17:55', NULL, 'tbl_soal'),
(167, 123456, 46, NULL, NULL, NULL, 0, 1, 0, 1, 0, NULL, '2025-05-04 10:25:56', '2025-05-04 12:25:56', '2025-05-04 12:28:34', 'tbl_soal'),
(168, 123456, 45, NULL, NULL, NULL, 0, 1, 0, 3, 0, NULL, '2025-05-04 10:28:43', '2025-05-04 12:28:43', '2025-05-04 12:39:47', 'tbl_soal'),
(169, 123456, 45, NULL, 13, 'A', 0, 1, 0, 3, 0, NULL, '2025-05-04 05:39:39', NULL, '2025-05-04 12:39:47', 'bank_soal'),
(170, 123456, 45, NULL, 15, 'A', 0, 1, 0, 3, 0, NULL, '2025-05-04 05:39:44', NULL, '2025-05-04 12:39:47', 'bank_soal'),
(171, 123456, 48, NULL, NULL, NULL, 0, 1, 1, 2, 33.3333, NULL, '2025-05-04 10:40:48', '2025-05-04 12:40:48', '2025-05-04 12:40:57', 'tbl_soal'),
(172, 123456, 48, NULL, 15, 'A', 0, 1, 1, 2, 33.3333, NULL, '2025-05-04 05:40:52', NULL, '2025-05-04 12:40:57', 'bank_soal'),
(173, 123456, 48, 38, NULL, 'A', 0, 1, 1, 2, 33.3333, NULL, '2025-05-04 05:40:54', NULL, '2025-05-04 12:40:57', 'tbl_soal'),
(174, 18883, 48, NULL, NULL, NULL, 0, 1, 1, 2, 33.3333, NULL, '2025-05-04 10:42:43', '2025-05-04 12:42:43', '2025-05-04 12:43:00', 'tbl_soal'),
(175, 18883, 48, NULL, 15, 'B', 0, 1, 1, 2, 33.3333, NULL, '2025-05-04 05:42:52', NULL, '2025-05-04 12:43:00', 'bank_soal'),
(176, 18883, 48, 38, NULL, 'A', 0, 1, 1, 2, 33.3333, NULL, '2025-05-04 05:42:55', NULL, '2025-05-04 12:43:00', 'tbl_soal'),
(177, 211011, 48, NULL, NULL, NULL, 0, 1, 0, 3, 0, NULL, '2025-05-04 10:45:10', '2025-05-04 12:45:10', '2025-05-04 12:45:20', 'tbl_soal'),
(178, 211011, 48, NULL, 15, 'A', 0, 1, 0, 3, 0, NULL, '2025-05-04 05:45:12', NULL, '2025-05-04 12:45:20', 'bank_soal'),
(179, 211011, 48, 38, NULL, 'C', 0, 1, 0, 3, 0, NULL, '2025-05-04 05:45:17', NULL, '2025-05-04 12:45:20', 'tbl_soal'),
(180, 123456, 49, NULL, NULL, NULL, 0, 1, 2, 1, 66.6667, NULL, '2025-05-04 11:35:35', '2025-05-04 13:35:35', '2025-05-04 13:35:44', 'tbl_soal'),
(181, 123456, 49, NULL, 13, 'A', 0, 1, 2, 1, 66.6667, NULL, '2025-05-04 06:35:37', NULL, '2025-05-04 13:35:44', 'bank_soal'),
(182, 123456, 49, NULL, 15, 'A', 0, 1, 2, 1, 66.6667, NULL, '2025-05-04 06:35:39', NULL, '2025-05-04 13:35:44', 'bank_soal'),
(183, 211011, 49, NULL, 13, 'A', 0, 1, 2, 0, 100, NULL, '2025-05-04 06:59:22', NULL, '2025-05-04 13:59:31', 'bank_soal'),
(184, 211011, 49, NULL, 15, 'A', 0, 1, 2, 0, 100, NULL, '2025-05-04 06:59:26', NULL, '2025-05-04 13:59:31', 'bank_soal'),
(185, 211011, 50, NULL, 13, 'A', 0, 1, 3, 0, 100, NULL, '2025-05-04 07:10:47', NULL, '2025-05-04 14:10:55', 'bank_soal'),
(186, 211011, 50, NULL, 15, 'A', 0, 1, 3, 0, 100, NULL, '2025-05-04 07:10:49', NULL, '2025-05-04 14:10:55', 'bank_soal'),
(187, 211011, 50, 39, NULL, 'A', 0, 1, 3, 0, 100, NULL, '2025-05-04 07:10:52', NULL, '2025-05-04 14:10:55', 'tbl_soal'),
(188, 123456, 50, NULL, 13, 'A', 0, 1, 2, 1, 66.6667, NULL, '2025-05-06 23:10:47', NULL, '2025-05-07 06:11:02', 'bank_soal'),
(189, 123456, 50, NULL, 15, 'C', 0, 1, 2, 1, 66.6667, NULL, '2025-05-06 23:10:56', NULL, '2025-05-07 06:11:02', 'bank_soal'),
(190, 123456, 50, 39, NULL, 'A', 0, 1, 2, 1, 66.6667, NULL, '2025-05-06 23:10:59', NULL, '2025-05-07 06:11:02', 'tbl_soal'),
(191, 18883, 50, NULL, 13, 'A', 0, 1, 3, 0, 100, NULL, '2025-05-06 23:11:37', NULL, '2025-05-07 06:11:44', 'bank_soal'),
(192, 18883, 50, NULL, 15, 'A', 0, 1, 3, 0, 100, NULL, '2025-05-06 23:11:40', NULL, '2025-05-07 06:11:44', 'bank_soal'),
(193, 18883, 50, 39, NULL, 'A', 0, 1, 3, 0, 100, NULL, '2025-05-06 23:11:42', NULL, '2025-05-07 06:11:44', 'tbl_soal');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_soal`
--

CREATE TABLE `tbl_soal` (
  `id_soal` int(11) NOT NULL,
  `id_ujian` int(11) DEFAULT NULL,
  `pertanyaan` text DEFAULT NULL,
  `pilihan_a` varchar(255) DEFAULT NULL,
  `pilihan_b` varchar(255) DEFAULT NULL,
  `pilihan_c` varchar(255) DEFAULT NULL,
  `pilihan_d` varchar(255) DEFAULT NULL,
  `kunci_jawaban` varchar(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_soal`
--

INSERT INTO `tbl_soal` (`id_soal`, `id_ujian`, `pertanyaan`, `pilihan_a`, `pilihan_b`, `pilihan_c`, `pilihan_d`, `kunci_jawaban`) VALUES
(28, 36, 'ww', 'ww', 'ww', 'ww', 'ww', 'A'),
(29, 36, 'www', 'ww', 'ww', 'ww', 'ww', 'A'),
(30, 40, 'www', 'www', 'ww', 'ww', 'ww', 'A'),
(31, 40, 'www', 'www', 'ww', 'ww', 'ww', 'A'),
(32, 40, 'www', 'www', 'ww', 'ww', 'ww', 'A'),
(33, 40, 'www', 'www', 'ww', 'ww', 'ww', 'A'),
(34, 40, 'wq', 'dqdq', 'dqdq', 'dqd', 'dqd', 'A'),
(35, 47, 'efwfwf', 'wfeww', 'wfwfw', 'fwfw', 'fwf', 'A'),
(36, 37, 'wdqwqd', 'qwdwd', 'qdwqwd', 'qwdqwd', 'dqw', 'A'),
(37, 38, 'wqdqwdq', 'dqwdqwdqw', 'dqwdqwd', 'qwdqwd', 'dqwd', 'A'),
(38, 48, 'ewdqwde', 'qdwqwd', 'qdqwd', 'qwd', 'dqwqwd', 'A'),
(39, 50, 'wdqdq', 'dqwdqwd', 'qdqwd', 'qwdqwd', 'qdqwd', 'A');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_ujian`
--

CREATE TABLE `tbl_ujian` (
  `id_ujian` int(11) NOT NULL,
  `nip_guru` int(11) NOT NULL,
  `nama_ujian` varchar(100) DEFAULT NULL,
  `tanggal_mulai` date DEFAULT NULL,
  `tanggal_selesai` date DEFAULT NULL,
  `durasi` int(11) DEFAULT NULL,
  `status` enum('aktif','nonaktif') DEFAULT NULL,
  `id_materi` int(11) DEFAULT NULL,
  `soal_source` enum('manual','bank_soal') DEFAULT 'manual'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_ujian`
--

INSERT INTO `tbl_ujian` (`id_ujian`, `nip_guru`, `nama_ujian`, `tanggal_mulai`, `tanggal_selesai`, `durasi`, `status`, `id_materi`, `soal_source`) VALUES
(35, 21101140, 'UTS', '2025-05-04', '2025-05-05', 22, 'aktif', 2, 'manual'),
(36, 21101140, 'UTSs', '2025-05-04', '2025-05-05', 22, 'aktif', 2, 'manual'),
(37, 21101140, 'wdwd', '2025-05-04', '2025-05-11', 22, 'aktif', 2, 'manual'),
(38, 21101140, 'wdwdw', '2025-05-04', '2025-05-11', 22, 'aktif', 2, 'manual'),
(39, 21101140, 'UTS', '2025-05-04', '2025-05-11', 33, 'aktif', 2, 'manual'),
(40, 21101140, 'UTS', '2025-05-03', '2025-05-04', 2, 'aktif', 2, 'manual'),
(41, 21101140, 'UTSsss', '2025-05-03', '2025-05-04', 22, 'aktif', 2, 'manual'),
(42, 21101140, 'www', '2025-05-04', '2025-05-16', 22, 'aktif', 2, 'manual'),
(43, 21101140, '2222', '2025-05-04', '2025-05-05', 222, 'aktif', 2, 'manual'),
(44, 21101140, '2222', '2025-05-04', '2025-05-05', 222, 'aktif', 2, 'manual'),
(45, 21101140, '2222ss', '2025-05-04', '2025-05-05', 222, 'aktif', 2, 'manual'),
(46, 21101140, 'www', '2025-05-04', '2025-05-05', 2, 'aktif', 2, 'manual'),
(47, 21101140, 'qss', '2025-05-04', '2025-05-15', 11, 'aktif', 6, 'manual'),
(48, 21101140, 'please', '2025-05-04', '2025-05-13', 11, 'aktif', 2, 'manual'),
(49, 21101140, 'UTS', '2025-05-04', '2025-05-05', 22, 'aktif', 2, 'manual'),
(50, 21101140, 'UTSs', '2025-05-07', '2025-05-08', 22, 'aktif', 2, 'manual');

-- --------------------------------------------------------

--
-- Table structure for table `token`
--

CREATE TABLE `token` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `date_created` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tugas_siswa`
--

CREATE TABLE `tugas_siswa` (
  `id` int(11) NOT NULL,
  `siswa_id` int(11) NOT NULL,
  `materi_id` int(11) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `original_filename` varchar(255) NOT NULL,
  `file_type` varchar(50) NOT NULL,
  `file_size` int(11) NOT NULL,
  `catatan` text DEFAULT NULL,
  `nilai` decimal(5,2) DEFAULT NULL,
  `dikirim_pada` datetime NOT NULL,
  `diupdate_pada` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `ujian_soal`
--

CREATE TABLE `ujian_soal` (
  `id` int(11) NOT NULL,
  `ujian_id` int(11) NOT NULL,
  `soal_id` int(11) DEFAULT NULL,
  `bank_soal_id` int(11) DEFAULT NULL,
  `sumber` enum('bank_soal','tbl_soal') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ujian_soal`
--

INSERT INTO `ujian_soal` (`id`, `ujian_id`, `soal_id`, `bank_soal_id`, `sumber`) VALUES
(58, 34, 13, NULL, 'bank_soal'),
(59, 34, 9, NULL, 'bank_soal'),
(60, 34, 7, NULL, 'bank_soal'),
(61, 34, 6, NULL, 'bank_soal'),
(62, 20, 26, NULL, 'tbl_soal'),
(63, 20, 27, NULL, 'tbl_soal'),
(64, 35, 15, NULL, 'bank_soal'),
(65, 35, 13, NULL, 'bank_soal'),
(66, 35, 9, NULL, 'bank_soal'),
(67, 35, 7, NULL, 'bank_soal'),
(68, 35, 6, NULL, 'bank_soal'),
(69, 36, 28, NULL, 'tbl_soal'),
(70, 36, 29, NULL, 'tbl_soal'),
(71, 37, 15, NULL, 'bank_soal'),
(72, 37, 13, NULL, 'bank_soal'),
(73, 37, 9, NULL, 'bank_soal'),
(74, 37, 7, NULL, 'bank_soal'),
(75, 37, 6, NULL, 'bank_soal'),
(76, 38, 15, NULL, 'bank_soal'),
(77, 38, 13, NULL, 'bank_soal'),
(78, 38, 9, NULL, 'bank_soal'),
(79, 38, 7, NULL, 'bank_soal'),
(80, 38, 6, NULL, 'bank_soal'),
(81, 39, 15, NULL, 'bank_soal'),
(82, 39, 13, NULL, 'bank_soal'),
(83, 39, 9, NULL, 'bank_soal'),
(85, 40, 34, NULL, 'tbl_soal'),
(86, 42, NULL, 15, 'bank_soal'),
(87, 42, NULL, 13, 'bank_soal'),
(88, 42, NULL, 9, 'bank_soal'),
(89, 42, NULL, 7, 'bank_soal'),
(90, 42, NULL, 6, 'bank_soal'),
(91, 43, NULL, 15, 'bank_soal'),
(92, 43, NULL, 13, 'bank_soal'),
(93, 44, 15, 15, 'bank_soal'),
(94, 44, 13, 13, 'bank_soal'),
(95, 45, NULL, 15, 'bank_soal'),
(96, 45, NULL, 13, 'bank_soal'),
(97, 46, NULL, 15, 'bank_soal'),
(98, 46, NULL, 13, 'bank_soal'),
(99, 47, NULL, 15, 'bank_soal'),
(100, 47, 35, NULL, 'tbl_soal'),
(101, 37, 36, NULL, 'tbl_soal'),
(102, 38, 37, NULL, 'tbl_soal'),
(103, 48, NULL, 15, 'bank_soal'),
(104, 48, 38, NULL, 'tbl_soal'),
(105, 49, NULL, 15, 'bank_soal'),
(106, 49, NULL, 13, 'bank_soal'),
(107, 50, NULL, 15, 'bank_soal'),
(108, 50, NULL, 13, 'bank_soal'),
(109, 50, 39, NULL, 'tbl_soal');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bank_soal`
--
ALTER TABLE `bank_soal`
  ADD PRIMARY KEY (`id_soal`);

--
-- Indexes for table `forum_diskusi`
--
ALTER TABLE `forum_diskusi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `materi_id` (`materi_id`),
  ADD KEY `fk_parent` (`parent_id`),
  ADD KEY `nis` (`nis`);

--
-- Indexes for table `guru`
--
ALTER TABLE `guru`
  ADD PRIMARY KEY (`nip`),
  ADD UNIQUE KEY `uq_nis` (`nip`);

--
-- Indexes for table `jawaban_siswa`
--
ALTER TABLE `jawaban_siswa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quiz_siswa_id` (`quiz_siswa_id`),
  ADD KEY `question_id` (`question_id`);

--
-- Indexes for table `kategori_soal`
--
ALTER TABLE `kategori_soal`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `materi`
--
ALTER TABLE `materi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_materi_guru` (`id_guru`);

--
-- Indexes for table `materi_status`
--
ALTER TABLE `materi_status`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `siswa_materi_unique` (`siswa_id`,`materi_id`),
  ADD KEY `fk_materi_status_materi` (`materi_id`);

--
-- Indexes for table `quiz`
--
ALTER TABLE `quiz`
  ADD PRIMARY KEY (`id`),
  ADD KEY `materi_id` (`materi_id`);

--
-- Indexes for table `quiz_questions`
--
ALTER TABLE `quiz_questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quiz_id` (`quiz_id`);

--
-- Indexes for table `quiz_siswa`
--
ALTER TABLE `quiz_siswa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quiz_id` (`quiz_id`),
  ADD KEY `siswa_id` (`siswa_id`);

--
-- Indexes for table `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`nis`);

--
-- Indexes for table `tbl_jawaban_siswa`
--
ALTER TABLE `tbl_jawaban_siswa`
  ADD PRIMARY KEY (`id_jawaban`),
  ADD KEY `nis` (`nis`),
  ADD KEY `id_ujian` (`id_ujian`),
  ADD KEY `fk_jawaban_tbl_soal` (`id_soal`),
  ADD KEY `fk_jawaban_bank_soal` (`bank_soal_id`);

--
-- Indexes for table `tbl_soal`
--
ALTER TABLE `tbl_soal`
  ADD PRIMARY KEY (`id_soal`),
  ADD KEY `id_ujian` (`id_ujian`);

--
-- Indexes for table `tbl_ujian`
--
ALTER TABLE `tbl_ujian`
  ADD PRIMARY KEY (`id_ujian`);

--
-- Indexes for table `token`
--
ALTER TABLE `token`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tugas_siswa`
--
ALTER TABLE `tugas_siswa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `siswa_id` (`siswa_id`),
  ADD KEY `materi_id` (`materi_id`);

--
-- Indexes for table `ujian_soal`
--
ALTER TABLE `ujian_soal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_ujian_soal` (`bank_soal_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bank_soal`
--
ALTER TABLE `bank_soal`
  MODIFY `id_soal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `forum_diskusi`
--
ALTER TABLE `forum_diskusi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=119;

--
-- AUTO_INCREMENT for table `jawaban_siswa`
--
ALTER TABLE `jawaban_siswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `kategori_soal`
--
ALTER TABLE `kategori_soal`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `materi`
--
ALTER TABLE `materi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `materi_status`
--
ALTER TABLE `materi_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quiz`
--
ALTER TABLE `quiz`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `quiz_questions`
--
ALTER TABLE `quiz_questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `quiz_siswa`
--
ALTER TABLE `quiz_siswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tbl_jawaban_siswa`
--
ALTER TABLE `tbl_jawaban_siswa`
  MODIFY `id_jawaban` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=194;

--
-- AUTO_INCREMENT for table `tbl_soal`
--
ALTER TABLE `tbl_soal`
  MODIFY `id_soal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `tbl_ujian`
--
ALTER TABLE `tbl_ujian`
  MODIFY `id_ujian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `token`
--
ALTER TABLE `token`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `tugas_siswa`
--
ALTER TABLE `tugas_siswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `ujian_soal`
--
ALTER TABLE `ujian_soal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=110;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `forum_diskusi`
--
ALTER TABLE `forum_diskusi`
  ADD CONSTRAINT `fk_parent` FOREIGN KEY (`parent_id`) REFERENCES `forum_diskusi` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `forum_diskusi_ibfk_1` FOREIGN KEY (`materi_id`) REFERENCES `materi` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `forum_diskusi_ibfk_2` FOREIGN KEY (`nis`) REFERENCES `siswa` (`nis`) ON DELETE CASCADE;

--
-- Constraints for table `jawaban_siswa`
--
ALTER TABLE `jawaban_siswa`
  ADD CONSTRAINT `jawaban_siswa_ibfk_1` FOREIGN KEY (`quiz_siswa_id`) REFERENCES `quiz_siswa` (`id`),
  ADD CONSTRAINT `jawaban_siswa_ibfk_2` FOREIGN KEY (`question_id`) REFERENCES `quiz_questions` (`id`);

--
-- Constraints for table `materi`
--
ALTER TABLE `materi`
  ADD CONSTRAINT `fk_materi_guru` FOREIGN KEY (`id_guru`) REFERENCES `guru` (`nip`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `materi_status`
--
ALTER TABLE `materi_status`
  ADD CONSTRAINT `fk_materi_status_materi` FOREIGN KEY (`materi_id`) REFERENCES `materi` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_materi_status_siswa` FOREIGN KEY (`siswa_id`) REFERENCES `siswa` (`nis`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `quiz`
--
ALTER TABLE `quiz`
  ADD CONSTRAINT `quiz_ibfk_1` FOREIGN KEY (`materi_id`) REFERENCES `materi` (`id`);

--
-- Constraints for table `quiz_questions`
--
ALTER TABLE `quiz_questions`
  ADD CONSTRAINT `quiz_questions_ibfk_1` FOREIGN KEY (`quiz_id`) REFERENCES `quiz` (`id`);

--
-- Constraints for table `quiz_siswa`
--
ALTER TABLE `quiz_siswa`
  ADD CONSTRAINT `quiz_siswa_ibfk_1` FOREIGN KEY (`quiz_id`) REFERENCES `quiz` (`id`),
  ADD CONSTRAINT `quiz_siswa_ibfk_2` FOREIGN KEY (`siswa_id`) REFERENCES `siswa` (`nis`);

--
-- Constraints for table `tbl_jawaban_siswa`
--
ALTER TABLE `tbl_jawaban_siswa`
  ADD CONSTRAINT `fk_jawaban_bank_soal` FOREIGN KEY (`bank_soal_id`) REFERENCES `bank_soal` (`id_soal`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_jawaban_tbl_soal` FOREIGN KEY (`id_soal`) REFERENCES `tbl_soal` (`id_soal`) ON DELETE SET NULL,
  ADD CONSTRAINT `tbl_jawaban_siswa_ibfk_1` FOREIGN KEY (`nis`) REFERENCES `siswa` (`nis`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_jawaban_siswa_ibfk_2` FOREIGN KEY (`id_ujian`) REFERENCES `tbl_ujian` (`id_ujian`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_soal`
--
ALTER TABLE `tbl_soal`
  ADD CONSTRAINT `tbl_soal_ibfk_1` FOREIGN KEY (`id_ujian`) REFERENCES `tbl_ujian` (`id_ujian`) ON DELETE CASCADE;

--
-- Constraints for table `tugas_siswa`
--
ALTER TABLE `tugas_siswa`
  ADD CONSTRAINT `tugas_siswa_ibfk_1` FOREIGN KEY (`siswa_id`) REFERENCES `siswa` (`nis`),
  ADD CONSTRAINT `tugas_siswa_ibfk_2` FOREIGN KEY (`materi_id`) REFERENCES `materi` (`id`);

--
-- Constraints for table `ujian_soal`
--
ALTER TABLE `ujian_soal`
  ADD CONSTRAINT `fk_ujian_soal` FOREIGN KEY (`bank_soal_id`) REFERENCES `bank_soal` (`id_soal`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
