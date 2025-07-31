-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 31, 2025 at 06:48 PM
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
-- Database: `db_addustedutest`
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
(1, 'admin', '$2y$10$EX0L5MeIQldpkCuTZW.mjujTaj.Yy20IW0GOluecU/c.es.9r6E5.', 'admin@admin.com', 'admin');

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
  `created_at` datetime DEFAULT current_timestamp(),
  `tipe_soal` enum('pilihan','essay') NOT NULL DEFAULT 'pilihan',
  `id_mapel` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bank_soal`
--

INSERT INTO `bank_soal` (`id_soal`, `pertanyaan`, `pilihan_a`, `pilihan_b`, `pilihan_c`, `pilihan_d`, `kunci_jawaban`, `tingkat_kesulitan`, `tipe_kognitif`, `created_by`, `user_type`, `created_at`, `tipe_soal`, `id_mapel`) VALUES
(2, 'duhs', 'aaa', 'aa', 'aa', 'aa', 'A', 'mudah', 'paham', 1, 'admin', '2025-07-15 09:05:30', 'pilihan', 1),
(3, 'qq', NULL, NULL, NULL, NULL, NULL, 'sedang', 'paham', 1, 'admin', '2025-07-15 09:05:59', 'essay', 1),
(4, 'aaa', 'aaa', 'aa', 'aa', 'aa', 'A', 'sedang', 'analisis', 21101140, 'guru', '2025-07-17 16:29:43', 'pilihan', 1),
(5, 'yang bener', NULL, NULL, NULL, NULL, NULL, 'sedang', 'paham', 21101140, 'guru', '2025-07-17 16:29:56', 'essay', 1),
(8, 'asa', 'dqdqd', 'qdqdqd', 'qdqdwq', 'dqwdqdqwd', 'A', 'sedang', 'paham', 1, 'admin', '2025-07-25 13:36:23', 'pilihan', 1),
(9, 'dfwfewwf', 'wfwefw', '', 'fwfwfwff', '', 'A', 'sedang', 'paham', 21101141, 'guru', '2025-07-26 20:20:06', 'pilihan', 2),
(10, 'fewewfwfwfwfwf', NULL, NULL, NULL, NULL, NULL, 'sedang', 'paham', 21101141, 'guru', '2025-07-26 20:20:13', 'essay', 2),
(11, 'fwewfwfwf', NULL, NULL, NULL, NULL, NULL, 'sedang', 'paham', 21101141, 'guru', '2025-07-26 20:20:20', 'essay', 2),
(12, 'thsrth', 'hsthsrhr', 'hsrhr', 'hsrh', 'hsrthrsh', 'A', 'sedang', 'paham', 21101140, 'guru', '2025-07-27 17:31:34', 'pilihan', 1),
(13, 'tests', 'eraggrga', 'rgege', 'reaa', 'rgagg', 'A', 'sedang', 'paham', 21101140, 'guru', '2025-07-27 17:31:52', 'pilihan', 2);

-- --------------------------------------------------------

--
-- Table structure for table `forum_diskusi`
--

CREATE TABLE `forum_diskusi` (
  `id` int(11) NOT NULL,
  `user_type` enum('siswa','guru') NOT NULL,
  `user_id` varchar(20) NOT NULL,
  `id_pertemuan` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `komentar` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `forum_diskusi`
--

INSERT INTO `forum_diskusi` (`id`, `user_type`, `user_id`, `id_pertemuan`, `parent_id`, `komentar`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'siswa', '12345678', 1, NULL, 'dsdxqwd', '2025-07-15 16:09:17', NULL, NULL),
(2, 'siswa', '12345678', 1, NULL, 'aku', '2025-07-15 16:12:04', '2025-07-16 21:43:24', '2025-07-16 16:43:24'),
(3, 'siswa', '12345678', 1, NULL, 'qwqwqww', '2025-07-15 16:23:07', NULL, NULL),
(4, 'siswa', '12345678', 1, NULL, 'sqsqs', '2025-07-15 16:52:13', NULL, NULL),
(5, 'siswa', '12345678', 1, 1, 'wdqqwds', '2025-07-15 17:05:37', '2025-07-16 12:24:57', '2025-07-16 07:24:57'),
(6, 'siswa', '12345678', 1, 5, 'testss', '2025-07-16 06:04:56', '2025-07-16 11:31:27', '2025-07-16 06:31:27'),
(7, 'siswa', '12345678', 1, 1, 'wqdqwdww', '2025-07-16 07:38:28', '2025-07-16 12:38:38', '2025-07-16 07:38:38'),
(8, 'siswa', '12345678', 1, NULL, 'aaaaa', '2025-07-16 07:43:36', NULL, NULL),
(9, 'siswa', '12345678', 1, 1, 'yayaya\r\n', '2025-07-16 07:44:01', '2025-07-16 21:43:37', '2025-07-16 16:43:37'),
(10, 'siswa', '12345678', 1, 9, 'apansi', '2025-07-16 07:44:39', NULL, NULL),
(11, 'siswa', '12345678', 1, 2, 'hahaha', '2025-07-16 07:45:16', NULL, NULL),
(12, 'siswa', '12345678', 1, 1, 'test aje\r\n', '2025-07-16 07:45:52', '2025-07-16 21:43:11', '2025-07-16 16:43:11'),
(13, 'siswa', '12345678', 1, NULL, 'test', '2025-07-16 07:50:58', NULL, NULL),
(14, 'siswa', '12345678', 1, 13, 'test kali', '2025-07-16 07:51:18', NULL, NULL),
(15, 'siswa', '12345678', 1, NULL, 'ssssssssss', '2025-07-16 07:51:52', NULL, NULL),
(16, 'siswa', '12345678', 1, 15, 'test', '2025-07-16 07:54:34', NULL, NULL),
(17, 'guru', '21101140', 2, NULL, 'ss', '2025-07-16 15:27:58', NULL, NULL),
(18, 'guru', '21101140', 2, NULL, 'ss', '2025-07-16 16:06:20', NULL, NULL),
(19, 'guru', '21101140', 1, NULL, 'ss', '2025-07-16 16:06:28', NULL, NULL),
(20, 'guru', '21101140', 1, NULL, 'ss', '2025-07-16 16:17:58', NULL, NULL),
(21, 'guru', '21101140', 1, 20, 'ss', '2025-07-16 16:28:32', '2025-07-16 21:43:03', '2025-07-16 16:43:03'),
(22, 'guru', '21101140', 1, 10, 'yang sopanee', '2025-07-16 16:28:45', '2025-07-16 16:28:51', NULL),
(23, 'guru', '21101140', 1, 1, 'sss', '2025-07-16 16:44:02', NULL, NULL),
(24, 'guru', '21101140', 1, 23, 'sss', '2025-07-16 16:44:09', '2025-07-16 21:44:18', '2025-07-16 16:44:18'),
(25, 'siswa', '12345678', 1, 23, 'sss', '2025-07-16 16:44:55', NULL, NULL),
(26, 'siswa', '12345678', 1, 1, 'sss', '2025-07-16 16:45:06', '2025-07-16 21:45:39', '2025-07-16 16:45:39'),
(27, 'siswa', '1234567898', 10, NULL, 'dwqqwd', '2025-07-29 08:19:41', NULL, NULL),
(28, 'guru', '21101140', 10, 27, 'yessir', '2025-07-29 08:20:17', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `guru`
--

CREATE TABLE `guru` (
  `nip` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `nama_guru` varchar(128) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_type` enum('guru') NOT NULL DEFAULT 'guru',
  `image` varchar(255) NOT NULL,
  `id_mapel` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `guru`
--

INSERT INTO `guru` (`nip`, `email`, `nama_guru`, `password`, `user_type`, `image`, `id_mapel`) VALUES
(21101140, 'pahrulmaji@gmail.com', 'guru terbaik semestas', '$2y$10$UorwtaEU9o.RBf5ueod/4u7K97tOeuVZZjYfvGEmogwjs1wjIB1OC', 'guru', '', 1),
(21101141, 'test1q222@gmail.com', 'guru tacu', '$2y$10$mkyupMAp59xkFET3LEnVieiDzYB.62A71qsiJXG5kbl8t7Q2mFTpi', 'guru', '', 2);

-- --------------------------------------------------------

--
-- Table structure for table `guru_mapel`
--

CREATE TABLE `guru_mapel` (
  `id` int(11) NOT NULL,
  `id_guru` int(11) NOT NULL,
  `id_mapel` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `guru_mapel`
--

INSERT INTO `guru_mapel` (`id`, `id_guru`, `id_mapel`) VALUES
(9, 21101140, 1),
(10, 21101140, 2),
(11, 21101140, 3),
(12, 21101141, 1),
(13, 21101141, 2),
(14, 21101141, 3);

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
(6, 2, 1, 'a', '1.00'),
(7, 2, 2, 'a', '1.00'),
(8, 2, 3, 'a', '1.00'),
(9, 2, 4, 'a', '1.00'),
(10, 2, 5, 'a', '1.00'),
(11, 4, 14, 'a', '1.00'),
(12, 4, 15, 'd', '0.00'),
(13, 5, 1, NULL, '0.00'),
(14, 5, 2, NULL, '0.00'),
(15, 5, 3, NULL, '0.00'),
(16, 5, 4, NULL, '0.00'),
(17, 5, 5, 'a', '1.00');

-- --------------------------------------------------------

--
-- Table structure for table `kelas`
--

CREATE TABLE `kelas` (
  `id` int(11) NOT NULL,
  `nama_kelas` varchar(20) NOT NULL,
  `tingkat` varchar(5) NOT NULL,
  `jurusan` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kelas`
--

INSERT INTO `kelas` (`id`, `nama_kelas`, `tingkat`, `jurusan`) VALUES
(1, 'X A', 'X', 'Administrasi'),
(2, 'XI A', 'XI', 'Administrasi'),
(3, 'XII A', 'XII', 'Administrasi'),
(4, 'X B', 'X', 'Administrasi'),
(6, 'PC1IPS1', 'X', 'Ilmu Pengetahuan Sos'),
(8, 'PC1IPS2', 'XI', 'Ilmu Pengetahuan Sos');

-- --------------------------------------------------------

--
-- Table structure for table `mata_pelajaran`
--

CREATE TABLE `mata_pelajaran` (
  `id` int(11) NOT NULL,
  `nama_mapel` varchar(128) NOT NULL,
  `deskripsi` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mata_pelajaran`
--

INSERT INTO `mata_pelajaran` (`id`, `nama_mapel`, `deskripsi`) VALUES
(1, 'Administrasi', 'lorem'),
(2, 'Matematika', 'lorem'),
(3, 'Ilmu Pengertahuan Alam', 'lorem');

-- --------------------------------------------------------

--
-- Table structure for table `materi`
--

CREATE TABLE `materi` (
  `id` int(11) NOT NULL,
  `id_guru` int(11) NOT NULL,
  `id_mapel` int(11) NOT NULL,
  `id_kelas` int(11) NOT NULL,
  `video` varchar(255) NOT NULL,
  `deskripsi` varchar(1024) NOT NULL,
  `linkform` varchar(100) DEFAULT NULL,
  `modul` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `materi`
--

INSERT INTO `materi` (`id`, `id_guru`, `id_mapel`, `id_kelas`, `video`, `deskripsi`, `linkform`, `modul`) VALUES
(1, 21101140, 1, 1, 'WIN_20241104_17_06_10_Pro3.mp4', '123', ' 212', 'WIN_20231030_13_35_02_Pro1.jpg'),
(2, 21101140, 1, 1, 'WIN_20241104_17_06_10_Pro4.mp4', '13334', ' 1212', 'WIN_20231030_13_35_02_Pro2.jpg'),
(3, 21101141, 2, 1, 'WIN_20241104_17_06_10_Pro5.mp4', 'ssssssssssssssssssssssssssssssssssssssssssssssssss', ' https://www.youtube.com/watch?v=_eDpH4hMW1o&amp;list=RDN9bKBAA22Go&amp;index=27', 'WIN_20231030_13_35_02_Pro3.jpg'),
(5, 21101140, 1, 1, 'WIN_20241104_17_06_10_Pro12.mp4', 'aku', ' aku', 'WIN_20231030_13_35_02_Pro10.jpg'),
(7, 21101140, 2, 1, 'WIN_20241104_17_06_10_Pro13.mp4', 'wcwcwcw', 'cwcwcwc', 'WIN_20231030_13_35_02_Pro11.jpg'),
(9, 21101140, 1, 1, 'WIN_20241104_17_06_10_Pro21.mp4', 'aaa', 'aaa', 'WIN_20231030_13_35_02_Pro19.jpg'),
(10, 21101140, 2, 1, 'WIN_20241104_17_06_10_Pro22.mp4', 'asxasxasx', ' axasxaxasxa', 'WIN_20231030_13_35_02_Pro20.jpg'),
(11, 21101140, 1, 4, 'WIN_20241104_17_06_10_Pro23.mp4', 'test', 'https://www.youtube.com/', 'WIN_20231030_13_35_02_Pro21.jpg'),
(12, 21101140, 1, 4, 'WIN_20241104_17_06_10_Pro20.mp4', 'dqwdw', ' wqdwqd', 'WIN_20231030_13_35_02_Pro18.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `pertemuan`
--

CREATE TABLE `pertemuan` (
  `id` int(11) NOT NULL,
  `id_materi` int(11) NOT NULL,
  `id_kelas` int(11) NOT NULL,
  `pertemuan_ke` int(11) NOT NULL,
  `tanggal` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pertemuan`
--

INSERT INTO `pertemuan` (`id`, `id_materi`, `id_kelas`, `pertemuan_ke`, `tanggal`) VALUES
(1, 2, 1, 1, '2025-07-15'),
(2, 1, 1, 2, '2025-07-16'),
(3, 3, 1, 1, '2025-07-16'),
(5, 5, 1, 3, '2025-07-16'),
(7, 7, 1, 5, '2025-07-19'),
(8, 9, 1, 4, '2025-07-20'),
(9, 10, 1, 1, '2025-07-24'),
(10, 11, 4, 1, '2025-07-29'),
(11, 12, 4, 2, '2025-07-29');

-- --------------------------------------------------------

--
-- Table structure for table `quiz`
--

CREATE TABLE `quiz` (
  `id` int(11) NOT NULL,
  `id_pertemuan` int(11) NOT NULL,
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

INSERT INTO `quiz` (`id`, `id_pertemuan`, `judul`, `deskripsi`, `waktu_pengerjaan`, `attempts`, `shuffle_questions`, `created_at`) VALUES
(3, 1, 'qq', 'qqq', 30, 1, 1, '2025-07-16 09:28:28'),
(4, 2, 'Asique', 'asiq', 30, 1, 1, '2025-07-17 07:36:18'),
(7, 9, 'Aku baik', 'aljabar adalah', 30, 1, 1, '2025-07-26 12:55:10'),
(8, 10, 'qsqs', 'hrth', 30, 1, 1, '2025-07-29 08:28:03');

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
(1, 3, 'wdwqdqwd', 'pilihan', 'qwdqwd', 'dqqdq', 'qwdqdwq', 'dqqwd', 'a', 1),
(2, 3, 'qwddq', 'pilihan', 'qdqwqdq', 'qwdqwd', 'qwdqwd', 'dqwwdqq', 'a', 1),
(3, 3, 'qdwqwdw', 'pilihan', 'qwdqdq', 'dqdqdqwd', 'wdqwdwqdq', 'dqdqdq', 'a', 1),
(4, 3, 'qdwqwdw', 'pilihan', 'qwdqdq', 'dqdqdqwd', 'wdqwdwqdq', 'dqdqdq', 'a', 1),
(5, 3, 'wqqwdqwdqw', 'pilihan', 'dqdqdq', 'qdqd', 'qdq', 'dqdqdq', 'a', 1),
(6, 4, 'aku', 'pilihan', 'qwdqwdqwdqwd', 'dqwdqwd', 'dqwdqwdwq', 'qwdqwd', 'a', 1),
(7, 4, 'qdqwdqwdwq', 'pilihan', 'dqwdqwdqwd', 'dqwdqwdqw', 'qwdqwdqw', 'dqwdwqdwq', 'a', 1),
(8, 4, 'qdqwdqdqwd', 'pilihan', 'qwdqwdqdqw', 'dqdqwd', 'dqwdqd', 'qdqdq', 'a', 1),
(9, 4, 'qwdqdq', 'pilihan', 'dqwdqdqdq', 'qdqdq', 'dqwdqd', 'dqdqdq', 'a', 1),
(11, 7, 'cscscsc', 'pilihan', 'sdcsd', 'cscccd', 'scsc', 'cscsc', 'a', 1),
(12, 7, 'qwdqdqdwq', 'pilihan', 'qwdqdqdqd', 'qdqdqwd', 'wqdqdq', 'dqdqd', 'a', 1),
(13, 7, 'zwdqdqd', 'pilihan', 'qwdqdqdqd', 'qdqwdqw', 'qwdqwdqdqwd', 'qdwdqd', 'a', 1),
(14, 8, 'qdqwdq', 'pilihan', 'qwdqd', 'qdqdqdqd', 'dqd', 'qdqdqd', 'a', 1),
(15, 8, 'wdqwqdqdqdqd', 'pilihan', 'dqqdqwdwq', 'qdqd', 'dqdq', 'dqdqdq', 'a', 1);

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
(2, 3, 12345678, '2025-07-24 12:39:33', '2025-07-24 12:39:46', 'completed', '100.00'),
(3, 7, 12345678, '2025-07-26 14:04:28', '2025-07-26 14:36:52', 'completed', '0.00'),
(4, 8, 1234567898, '2025-07-29 08:30:57', '2025-07-29 08:31:06', 'completed', '50.00'),
(5, 3, 1234567899, '2025-07-29 11:34:22', '2025-07-29 12:04:23', 'completed', '20.00');

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
  `id_kelas` int(11) NOT NULL,
  `user_type` enum('siswa') NOT NULL DEFAULT 'siswa'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `siswa`
--

INSERT INTO `siswa` (`nis`, `nama`, `password`, `email`, `image`, `is_active`, `date_created`, `id_kelas`, `user_type`) VALUES
(12345678, 'addust', '$2y$10$3RDMCm2W9spWQ1tNeUcJiuavrUDd5J.r1voeLKTlQfGBznK9xuRtW', 'pahrulmaji@gmail.com', 'default.jpg', 1, '2025-07-15', 1, 'siswa'),
(123456789, 'addusttt', '$2y$10$nJ7o8eOTw5OF6KRGWXiDC.BwYbd0R6qVAnn7Kcdvozbr2J6SFVtdy', 'test1q22sss2@gmail.com', 'default.jpg', 1, '2025-07-17', 1, 'siswa'),
(1234567898, 'frbro', '$2y$10$1rAUcKRmfEjfouLgRSpGD./ckC7rRoMIisHbbt4ip0zLIWWq2AZ.K', 'testwfwefewf@gmail.com', 'default.jpg', 1, '2025-07-29', 4, 'siswa'),
(1234567899, 'siswa terbaik', '$2y$10$3FuVyqH6BcloMPqfSolTK.TcFID2rA2zW/UzaL.GnKaCQZUlLLB9a', 'jagajaga100110@gmail.com', 'default.jpg', 1, '2025-07-26', 1, 'siswa');

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
  `jawaban_essay` text DEFAULT NULL,
  `ragu_ragu` tinyint(1) DEFAULT 0,
  `is_selesai` tinyint(1) DEFAULT 0,
  `jumlah_benar` int(11) DEFAULT 0,
  `jumlah_salah` int(11) DEFAULT 0,
  `score` float DEFAULT 0,
  `tanggal_submit` datetime DEFAULT NULL,
  `waktu_jawab` timestamp NOT NULL DEFAULT current_timestamp(),
  `waktu_mulai_ujian` datetime DEFAULT NULL,
  `waktu_submit` datetime DEFAULT NULL,
  `sumber` enum('tbl_soal','bank_soal') NOT NULL DEFAULT 'tbl_soal',
  `nilai_essay` int(11) DEFAULT NULL,
  `catatan_essay` text DEFAULT NULL,
  `nilai_akhir` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_jawaban_siswa`
--

INSERT INTO `tbl_jawaban_siswa` (`id_jawaban`, `nis`, `id_ujian`, `id_soal`, `bank_soal_id`, `jawaban`, `jawaban_essay`, `ragu_ragu`, `is_selesai`, `jumlah_benar`, `jumlah_salah`, `score`, `tanggal_submit`, `waktu_jawab`, `waktu_mulai_ujian`, `waktu_submit`, `sumber`, `nilai_essay`, `catatan_essay`, `nilai_akhir`) VALUES
(118, 12345678, 10, NULL, NULL, NULL, NULL, 0, 1, 1, 1, 25, NULL, '2025-07-26 16:59:19', '2025-07-26 18:59:19', '2025-07-26 19:02:41', 'bank_soal', NULL, NULL, 100),
(119, 12345678, 10, NULL, NULL, NULL, NULL, 0, 1, 1, 1, 25, NULL, '2025-07-26 16:59:19', '2025-07-26 18:59:19', '2025-07-26 19:02:41', 'bank_soal', NULL, NULL, 100),
(120, 12345678, 10, NULL, NULL, NULL, NULL, 0, 1, 1, 1, 25, NULL, '2025-07-26 16:59:19', '2025-07-26 18:59:19', '2025-07-26 19:02:41', 'bank_soal', NULL, NULL, 100),
(121, 12345678, 10, NULL, NULL, NULL, NULL, 0, 1, 1, 1, 25, NULL, '2025-07-26 16:59:19', '2025-07-26 18:59:19', '2025-07-26 19:02:41', 'bank_soal', NULL, NULL, 100),
(122, 12345678, 10, NULL, 8, 'A', NULL, 0, 1, 1, 1, 25, NULL, '2025-07-26 11:59:21', NULL, '2025-07-26 19:02:41', 'bank_soal', NULL, NULL, 100),
(123, 12345678, 10, NULL, 5, NULL, 'fewfwefwfwfwfw', 0, 1, 1, 1, 25, NULL, '2025-07-26 11:59:31', NULL, '2025-07-26 19:02:41', 'bank_soal', 100, '', 100),
(124, 12345678, 11, NULL, NULL, NULL, NULL, 0, 1, 2, 2, 25, NULL, '2025-07-26 17:03:11', '2025-07-26 19:03:11', '2025-07-26 19:07:04', 'tbl_soal', NULL, NULL, 25),
(125, 12345678, 11, NULL, NULL, NULL, NULL, 0, 1, 2, 2, 25, NULL, '2025-07-26 17:03:11', '2025-07-26 19:03:11', '2025-07-26 19:07:04', 'tbl_soal', NULL, NULL, 25),
(126, 12345678, 11, NULL, NULL, NULL, NULL, 0, 1, 2, 2, 25, NULL, '2025-07-26 17:03:11', '2025-07-26 19:03:11', '2025-07-26 19:07:04', 'tbl_soal', NULL, NULL, 25),
(127, 12345678, 11, NULL, NULL, NULL, NULL, 0, 1, 2, 2, 25, NULL, '2025-07-26 17:03:11', '2025-07-26 19:03:11', '2025-07-26 19:07:04', 'tbl_soal', NULL, NULL, 25),
(128, 12345678, 11, 14, NULL, 'A', NULL, 0, 1, 2, 2, 25, NULL, '2025-07-26 12:03:13', NULL, '2025-07-26 19:07:04', 'tbl_soal', NULL, NULL, 25),
(129, 12345678, 11, 15, NULL, 'A', NULL, 0, 1, 2, 2, 25, NULL, '2025-07-26 12:03:16', NULL, '2025-07-26 19:07:04', 'tbl_soal', NULL, NULL, 25),
(130, 12345678, 13, NULL, NULL, NULL, NULL, 0, 1, 1, 1, 25, NULL, '2025-07-26 17:09:47', '2025-07-26 19:09:47', '2025-07-26 19:13:47', 'bank_soal', NULL, NULL, 100),
(131, 12345678, 13, NULL, NULL, NULL, NULL, 0, 1, 1, 1, 25, NULL, '2025-07-26 17:09:47', '2025-07-26 19:09:47', '2025-07-26 19:13:47', 'bank_soal', NULL, NULL, 100),
(132, 12345678, 13, NULL, NULL, NULL, NULL, 0, 1, 1, 1, 25, NULL, '2025-07-26 17:09:47', '2025-07-26 19:09:47', '2025-07-26 19:13:47', 'tbl_soal', NULL, NULL, 100),
(133, 12345678, 13, NULL, NULL, NULL, NULL, 0, 1, 1, 1, 25, NULL, '2025-07-26 17:09:47', '2025-07-26 19:09:47', '2025-07-26 19:13:47', 'tbl_soal', NULL, NULL, 100),
(134, 12345678, 13, NULL, 5, NULL, 'cscdscsc', 0, 1, 1, 1, 25, NULL, '2025-07-26 12:09:53', NULL, '2025-07-26 19:13:47', 'bank_soal', 100, 'qwdqw', 100),
(135, 12345678, 13, 18, NULL, 'A', NULL, 0, 1, 1, 1, 25, NULL, '2025-07-26 12:09:55', NULL, '2025-07-26 19:13:47', 'tbl_soal', NULL, NULL, 100),
(136, 123456789, 10, NULL, NULL, NULL, NULL, 0, 1, 1, 1, 25, NULL, '2025-07-26 17:22:44', '2025-07-26 19:22:44', '2025-07-26 19:24:49', 'bank_soal', NULL, NULL, 100),
(137, 123456789, 10, NULL, NULL, NULL, NULL, 0, 1, 1, 1, 25, NULL, '2025-07-26 17:22:44', '2025-07-26 19:22:44', '2025-07-26 19:24:49', 'bank_soal', NULL, NULL, 100),
(138, 123456789, 10, NULL, NULL, NULL, NULL, 0, 1, 1, 1, 25, NULL, '2025-07-26 17:22:44', '2025-07-26 19:22:44', '2025-07-26 19:24:49', 'bank_soal', NULL, NULL, 100),
(139, 123456789, 10, NULL, NULL, NULL, NULL, 0, 1, 1, 1, 25, NULL, '2025-07-26 17:22:44', '2025-07-26 19:22:44', '2025-07-26 19:24:49', 'bank_soal', NULL, NULL, 100),
(140, 123456789, 10, NULL, 8, 'A', NULL, 0, 1, 1, 1, 25, NULL, '2025-07-26 12:22:45', NULL, '2025-07-26 19:24:49', 'bank_soal', NULL, NULL, 100),
(141, 123456789, 10, NULL, 5, NULL, 'dqdqwdqwdqwd', 0, 1, 1, 1, 25, NULL, '2025-07-26 12:22:54', NULL, '2025-07-26 19:24:49', 'bank_soal', 100, '', 100),
(142, 123456789, 11, NULL, NULL, NULL, NULL, 0, 1, 2, 2, 25, NULL, '2025-07-26 17:25:02', '2025-07-26 19:25:02', '2025-07-26 19:25:37', 'tbl_soal', NULL, NULL, 25),
(143, 123456789, 11, NULL, NULL, NULL, NULL, 0, 1, 2, 2, 25, NULL, '2025-07-26 17:25:02', '2025-07-26 19:25:02', '2025-07-26 19:25:37', 'tbl_soal', NULL, NULL, 25),
(144, 123456789, 11, NULL, NULL, NULL, NULL, 0, 1, 2, 2, 25, NULL, '2025-07-26 17:25:02', '2025-07-26 19:25:02', '2025-07-26 19:25:37', 'tbl_soal', NULL, NULL, 25),
(145, 123456789, 11, NULL, NULL, NULL, NULL, 0, 1, 2, 2, 25, NULL, '2025-07-26 17:25:02', '2025-07-26 19:25:02', '2025-07-26 19:25:37', 'tbl_soal', NULL, NULL, 25),
(146, 123456789, 11, 14, NULL, 'A', NULL, 0, 1, 2, 2, 25, NULL, '2025-07-26 12:25:09', NULL, '2025-07-26 19:25:37', 'tbl_soal', NULL, NULL, 25),
(147, 123456789, 11, 15, NULL, 'A', NULL, 0, 1, 2, 2, 25, NULL, '2025-07-26 12:25:14', NULL, '2025-07-26 19:25:37', 'tbl_soal', NULL, NULL, 25),
(148, 123456789, 13, NULL, NULL, NULL, NULL, 0, 1, 1, 1, 25, NULL, '2025-07-26 17:31:20', '2025-07-26 19:31:20', '2025-07-26 19:36:18', 'bank_soal', NULL, NULL, 75),
(149, 123456789, 13, NULL, NULL, NULL, NULL, 0, 1, 1, 1, 25, NULL, '2025-07-26 17:31:20', '2025-07-26 19:31:20', '2025-07-26 19:36:18', 'bank_soal', NULL, NULL, 75),
(150, 123456789, 13, NULL, NULL, NULL, NULL, 0, 1, 1, 1, 25, NULL, '2025-07-26 17:31:20', '2025-07-26 19:31:20', '2025-07-26 19:36:18', 'tbl_soal', NULL, NULL, 75),
(151, 123456789, 13, NULL, NULL, NULL, NULL, 0, 1, 1, 1, 25, NULL, '2025-07-26 17:31:20', '2025-07-26 19:31:20', '2025-07-26 19:36:18', 'tbl_soal', NULL, NULL, 75),
(152, 123456789, 13, NULL, 5, NULL, 'qwdqwdqwd', 0, 1, 1, 1, 25, NULL, '2025-07-26 12:31:25', NULL, '2025-07-26 19:36:18', 'bank_soal', 50, 'x', 75),
(153, 123456789, 13, 18, NULL, 'A', NULL, 0, 1, 1, 1, 25, NULL, '2025-07-26 12:31:27', NULL, '2025-07-26 19:36:18', 'tbl_soal', NULL, NULL, 75),
(154, 1234567899, 10, NULL, NULL, NULL, NULL, 0, 1, 1, 1, 25, NULL, '2025-07-26 17:38:51', '2025-07-26 19:38:51', '2025-07-26 19:39:28', 'bank_soal', NULL, NULL, 100),
(155, 1234567899, 10, NULL, NULL, NULL, NULL, 0, 1, 1, 1, 25, NULL, '2025-07-26 17:38:51', '2025-07-26 19:38:51', '2025-07-26 19:39:28', 'bank_soal', NULL, NULL, 100),
(156, 1234567899, 10, NULL, NULL, NULL, NULL, 0, 1, 1, 1, 25, NULL, '2025-07-26 17:38:51', '2025-07-26 19:38:51', '2025-07-26 19:39:28', 'bank_soal', NULL, NULL, 100),
(157, 1234567899, 10, NULL, NULL, NULL, NULL, 0, 1, 1, 1, 25, NULL, '2025-07-26 17:38:51', '2025-07-26 19:38:51', '2025-07-26 19:39:28', 'bank_soal', NULL, NULL, 100),
(158, 1234567899, 10, NULL, 8, 'A', NULL, 0, 1, 1, 1, 25, NULL, '2025-07-26 12:39:12', NULL, '2025-07-26 19:39:28', 'bank_soal', NULL, NULL, 100),
(159, 1234567899, 10, NULL, 5, NULL, 'qwdqwd', 0, 1, 1, 1, 25, NULL, '2025-07-26 12:39:27', NULL, '2025-07-26 19:39:28', 'bank_soal', 100, 'dqwd', 100),
(160, 1234567899, 11, NULL, NULL, NULL, NULL, 0, 1, 3, 1, 37.5, NULL, '2025-07-26 18:11:09', '2025-07-26 20:11:09', '2025-07-26 20:11:18', 'tbl_soal', NULL, NULL, 37.5),
(161, 1234567899, 11, NULL, NULL, NULL, NULL, 0, 1, 3, 1, 37.5, NULL, '2025-07-26 18:11:09', '2025-07-26 20:11:09', '2025-07-26 20:11:18', 'tbl_soal', NULL, NULL, 37.5),
(162, 1234567899, 11, NULL, NULL, NULL, NULL, 0, 1, 3, 1, 37.5, NULL, '2025-07-26 18:11:09', '2025-07-26 20:11:09', '2025-07-26 20:11:18', 'tbl_soal', NULL, NULL, 37.5),
(163, 1234567899, 11, NULL, NULL, NULL, NULL, 0, 1, 3, 1, 37.5, NULL, '2025-07-26 18:11:09', '2025-07-26 20:11:09', '2025-07-26 20:11:18', 'tbl_soal', NULL, NULL, 37.5),
(164, 1234567899, 11, 14, NULL, 'A', NULL, 0, 1, 3, 1, 37.5, NULL, '2025-07-26 13:11:11', NULL, '2025-07-26 20:11:18', 'tbl_soal', NULL, NULL, 37.5),
(165, 1234567899, 11, 15, NULL, 'A', NULL, 0, 1, 3, 1, 37.5, NULL, '2025-07-26 13:11:13', NULL, '2025-07-26 20:11:18', 'tbl_soal', NULL, NULL, 37.5),
(166, 1234567899, 11, 16, NULL, 'A', NULL, 0, 1, 3, 1, 37.5, NULL, '2025-07-26 13:11:16', NULL, '2025-07-26 20:11:18', 'tbl_soal', NULL, NULL, 37.5),
(167, 1234567899, 13, NULL, NULL, NULL, NULL, 0, 1, 1, 1, 25, NULL, '2025-07-26 18:11:31', '2025-07-26 20:11:31', '2025-07-26 20:14:34', 'bank_soal', NULL, NULL, 50),
(168, 1234567899, 13, NULL, NULL, NULL, NULL, 0, 1, 1, 1, 25, NULL, '2025-07-26 18:11:31', '2025-07-26 20:11:31', '2025-07-26 20:14:34', 'bank_soal', NULL, NULL, 50),
(169, 1234567899, 13, NULL, NULL, NULL, NULL, 0, 1, 1, 1, 25, NULL, '2025-07-26 18:11:31', '2025-07-26 20:11:31', '2025-07-26 20:14:34', 'tbl_soal', NULL, NULL, 50),
(170, 1234567899, 13, NULL, NULL, NULL, NULL, 0, 1, 1, 1, 25, NULL, '2025-07-26 18:11:31', '2025-07-26 20:11:31', '2025-07-26 20:14:34', 'tbl_soal', NULL, NULL, 50),
(171, 1234567899, 13, NULL, 5, NULL, 'dqwddq', 0, 1, 1, 1, 25, NULL, '2025-07-26 13:11:33', NULL, '2025-07-26 20:14:34', 'bank_soal', 0, 'qwdqw', 50),
(172, 1234567899, 13, 18, NULL, 'A', NULL, 0, 1, 1, 1, 25, NULL, '2025-07-26 13:11:36', NULL, '2025-07-26 20:14:34', 'tbl_soal', NULL, NULL, 50),
(173, 12345678, 15, NULL, NULL, NULL, NULL, 0, 1, 2, 1, 33.3333, NULL, '2025-07-27 11:14:01', '2025-07-27 13:14:01', '2025-07-27 13:14:17', 'bank_soal', NULL, NULL, 58.3333),
(174, 12345678, 15, NULL, NULL, NULL, NULL, 0, 1, 2, 1, 33.3333, NULL, '2025-07-27 11:14:01', '2025-07-27 13:14:01', '2025-07-27 13:14:17', 'bank_soal', NULL, NULL, 58.3333),
(175, 12345678, 15, NULL, NULL, NULL, NULL, 0, 1, 2, 1, 33.3333, NULL, '2025-07-27 11:14:01', '2025-07-27 13:14:01', '2025-07-27 13:14:17', 'bank_soal', NULL, NULL, 58.3333),
(176, 12345678, 15, NULL, NULL, NULL, NULL, 0, 1, 2, 1, 33.3333, NULL, '2025-07-27 11:14:01', '2025-07-27 13:14:01', '2025-07-27 13:14:17', 'bank_soal', NULL, NULL, 58.3333),
(177, 12345678, 15, NULL, NULL, NULL, NULL, 0, 1, 2, 1, 33.3333, NULL, '2025-07-27 11:14:01', '2025-07-27 13:14:01', '2025-07-27 13:14:17', 'tbl_soal', NULL, NULL, 58.3333),
(178, 12345678, 15, NULL, 3, NULL, 'efefwewfewf', 0, 1, 2, 1, 33.3333, NULL, '2025-07-27 06:14:05', NULL, '2025-07-27 13:14:17', 'bank_soal', 0, 'qwdwqd', 58.3333),
(179, 12345678, 15, NULL, 4, 'A', NULL, 0, 1, 2, 1, 33.3333, NULL, '2025-07-27 06:14:06', NULL, '2025-07-27 13:14:17', 'bank_soal', NULL, NULL, 58.3333),
(180, 12345678, 15, NULL, 5, NULL, 'qdwdqwdq', 0, 1, 2, 1, 33.3333, NULL, '2025-07-27 06:14:09', NULL, '2025-07-27 13:14:17', 'bank_soal', 100, 'fwefw', 58.3333),
(181, 12345678, 15, NULL, 12, 'A', NULL, 0, 1, 2, 1, 33.3333, NULL, '2025-07-27 06:14:11', NULL, '2025-07-27 13:14:17', 'bank_soal', NULL, NULL, 58.3333),
(182, 12345678, 15, 21, NULL, 'C', NULL, 0, 1, 2, 1, 33.3333, NULL, '2025-07-27 06:14:15', NULL, '2025-07-27 13:14:17', 'tbl_soal', NULL, NULL, 58.3333),
(183, 12345678, 14, NULL, NULL, NULL, NULL, 0, 1, 3, 0, 50, NULL, '2025-07-27 11:15:59', '2025-07-27 13:15:59', '2025-07-27 13:16:26', 'bank_soal', NULL, NULL, 100),
(184, 12345678, 14, NULL, NULL, NULL, NULL, 0, 1, 3, 0, 50, NULL, '2025-07-27 11:15:59', '2025-07-27 13:15:59', '2025-07-27 13:16:26', 'bank_soal', NULL, NULL, 100),
(185, 12345678, 14, NULL, NULL, NULL, NULL, 0, 1, 3, 0, 50, NULL, '2025-07-27 11:15:59', '2025-07-27 13:15:59', '2025-07-27 13:16:26', 'bank_soal', NULL, NULL, 100),
(186, 12345678, 14, NULL, NULL, NULL, NULL, 0, 1, 3, 0, 50, NULL, '2025-07-27 11:15:59', '2025-07-27 13:15:59', '2025-07-27 13:16:26', 'bank_soal', NULL, NULL, 100),
(187, 12345678, 14, NULL, NULL, NULL, NULL, 0, 1, 3, 0, 50, NULL, '2025-07-27 11:15:59', '2025-07-27 13:15:59', '2025-07-27 13:16:26', 'tbl_soal', NULL, NULL, 100),
(188, 12345678, 14, NULL, 9, 'A', NULL, 0, 1, 3, 0, 50, NULL, '2025-07-27 06:16:14', NULL, '2025-07-27 13:16:26', 'bank_soal', NULL, NULL, 100),
(189, 12345678, 14, NULL, 10, NULL, 'qdqwdqw', 0, 1, 3, 0, 50, NULL, '2025-07-27 06:16:18', NULL, '2025-07-27 13:16:26', 'bank_soal', 100, 'qwd', 100),
(190, 12345678, 14, NULL, 11, NULL, 'dqqwdqd', 0, 1, 3, 0, 50, NULL, '2025-07-27 06:16:20', NULL, '2025-07-27 13:16:26', 'bank_soal', 100, '', 100),
(191, 12345678, 14, NULL, 13, 'A', NULL, 0, 1, 3, 0, 50, NULL, '2025-07-27 06:16:21', NULL, '2025-07-27 13:16:26', 'bank_soal', NULL, NULL, 100),
(192, 12345678, 14, 20, NULL, 'A', NULL, 0, 1, 3, 0, 50, NULL, '2025-07-27 06:16:23', NULL, '2025-07-27 13:16:26', 'tbl_soal', NULL, NULL, 100),
(193, 123456789, 15, NULL, NULL, NULL, NULL, 0, 1, 0, 3, 0, NULL, '2025-07-27 11:18:03', '2025-07-27 13:18:03', '2025-07-27 13:22:33', 'bank_soal', NULL, NULL, 0),
(194, 123456789, 15, NULL, NULL, NULL, NULL, 0, 1, 0, 3, 0, NULL, '2025-07-27 11:18:03', '2025-07-27 13:18:03', '2025-07-27 13:22:33', 'bank_soal', NULL, NULL, 0),
(195, 123456789, 15, NULL, NULL, NULL, NULL, 0, 1, 0, 3, 0, NULL, '2025-07-27 11:18:03', '2025-07-27 13:18:03', '2025-07-27 13:22:33', 'bank_soal', NULL, NULL, 0),
(196, 123456789, 15, NULL, NULL, NULL, NULL, 0, 1, 0, 3, 0, NULL, '2025-07-27 11:18:03', '2025-07-27 13:18:03', '2025-07-27 13:22:33', 'bank_soal', NULL, NULL, 0),
(197, 123456789, 15, NULL, NULL, NULL, NULL, 0, 1, 0, 3, 0, NULL, '2025-07-27 11:18:03', '2025-07-27 13:18:03', '2025-07-27 13:22:33', 'tbl_soal', NULL, NULL, 0),
(198, 123456789, 14, NULL, NULL, NULL, NULL, 0, 1, 0, 3, 0, NULL, '2025-07-27 11:22:47', '2025-07-27 13:22:47', '2025-07-27 13:26:49', 'bank_soal', NULL, NULL, 0),
(199, 123456789, 14, NULL, NULL, NULL, NULL, 0, 1, 0, 3, 0, NULL, '2025-07-27 11:22:47', '2025-07-27 13:22:47', '2025-07-27 13:26:49', 'bank_soal', NULL, NULL, 0),
(200, 123456789, 14, NULL, NULL, NULL, NULL, 0, 1, 0, 3, 0, NULL, '2025-07-27 11:22:47', '2025-07-27 13:22:47', '2025-07-27 13:26:49', 'bank_soal', NULL, NULL, 0),
(201, 123456789, 14, NULL, NULL, NULL, NULL, 0, 1, 0, 3, 0, NULL, '2025-07-27 11:22:47', '2025-07-27 13:22:47', '2025-07-27 13:26:49', 'bank_soal', NULL, NULL, 0),
(202, 123456789, 14, NULL, NULL, NULL, NULL, 0, 1, 0, 3, 0, NULL, '2025-07-27 11:22:47', '2025-07-27 13:22:47', '2025-07-27 13:26:49', 'tbl_soal', NULL, NULL, 0),
(203, 123456789, 14, NULL, 10, NULL, 'dqwwdqd', 0, 1, 0, 3, 0, NULL, '2025-07-27 06:22:53', NULL, '2025-07-27 13:26:49', 'bank_soal', 0, '0', 0),
(204, 1234567898, 16, NULL, NULL, NULL, NULL, 0, 1, 0, 5, 0, NULL, '2025-07-29 06:30:42', '2025-07-29 08:30:42', '2025-07-29 08:30:45', 'bank_soal', NULL, NULL, 0),
(205, 1234567898, 16, NULL, NULL, NULL, NULL, 0, 1, 0, 5, 0, NULL, '2025-07-29 06:30:42', '2025-07-29 08:30:42', '2025-07-29 08:30:45', 'bank_soal', NULL, NULL, 0),
(206, 1234567898, 16, NULL, NULL, NULL, NULL, 0, 1, 0, 5, 0, NULL, '2025-07-29 06:30:42', '2025-07-29 08:30:42', '2025-07-29 08:30:45', 'bank_soal', NULL, NULL, 0),
(207, 1234567898, 16, NULL, NULL, NULL, NULL, 0, 1, 0, 5, 0, NULL, '2025-07-29 06:30:42', '2025-07-29 08:30:42', '2025-07-29 08:30:45', 'bank_soal', NULL, NULL, 0),
(208, 1234567898, 16, NULL, NULL, NULL, NULL, 0, 1, 0, 5, 0, NULL, '2025-07-29 06:30:42', '2025-07-29 08:30:42', '2025-07-29 08:30:45', 'tbl_soal', NULL, NULL, 0),
(209, 1234567899, 15, NULL, NULL, NULL, NULL, 0, 1, 0, 3, 0, NULL, '2025-07-29 10:32:21', '2025-07-29 12:32:21', '2025-07-29 12:36:08', 'bank_soal', NULL, NULL, 0),
(210, 1234567899, 15, NULL, NULL, NULL, NULL, 0, 1, 0, 3, 0, NULL, '2025-07-29 10:32:21', '2025-07-29 12:32:21', '2025-07-29 12:36:08', 'bank_soal', NULL, NULL, 0),
(211, 1234567899, 15, NULL, NULL, NULL, NULL, 0, 1, 0, 3, 0, NULL, '2025-07-29 10:32:21', '2025-07-29 12:32:21', '2025-07-29 12:36:08', 'bank_soal', NULL, NULL, 0),
(212, 1234567899, 15, NULL, NULL, NULL, NULL, 0, 1, 0, 3, 0, NULL, '2025-07-29 10:32:21', '2025-07-29 12:32:21', '2025-07-29 12:36:08', 'bank_soal', NULL, NULL, 0),
(213, 1234567899, 15, NULL, NULL, NULL, NULL, 0, 1, 0, 3, 0, NULL, '2025-07-29 10:32:21', '2025-07-29 12:32:21', '2025-07-29 12:36:08', 'tbl_soal', NULL, NULL, 0);

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
  `kunci_jawaban` varchar(1) DEFAULT NULL,
  `tipe_soal` enum('pilihan','essay') NOT NULL DEFAULT 'pilihan'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_soal`
--

INSERT INTO `tbl_soal` (`id_soal`, `id_ujian`, `pertanyaan`, `pilihan_a`, `pilihan_b`, `pilihan_c`, `pilihan_d`, `kunci_jawaban`, `tipe_soal`) VALUES
(14, 11, 'fwefwe', 'fewfewf', 'fwfw', 'fewfwf', 'ewf', 'A', 'pilihan'),
(15, 11, 'ewfwfwfew', 'fewfwf', 'wfw', 'wfwfw', 'fwffw', 'A', 'pilihan'),
(16, 11, 'ewfewfw', 'fwfwf', 'wfwf', 'wfwf', 'wfwf', 'A', 'pilihan'),
(17, 11, 'fewfwf', 'wefew', 'fwfwf', 'fewfew', 'fewfew', 'A', 'pilihan'),
(18, 13, 'qwdqd', 'qdwqd', 'qwdq', 'qdq', 'qqd', 'A', 'pilihan'),
(19, 13, 'wdqqd', 'qdqd', 'qdqd', 'qddqq', 'dqwqd', 'A', 'pilihan'),
(20, 14, 'wdqdqwd', 'qwdqw', 'dqwdq', 'dwqdq', 'dqq', 'A', 'pilihan'),
(21, 15, 'wefwf', 'wfwf', 'wfwfw', 'fwf', 'wfw', 'A', 'pilihan'),
(22, 16, 'wfwef', 'wefewfew', 'fewf', 'fwfewfw', 'fwf', 'A', 'pilihan');

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
  `id_pertemuan` int(11) DEFAULT NULL,
  `soal_source` enum('manual','bank_soal') DEFAULT 'manual',
  `bobot_pg` tinyint(3) DEFAULT 70,
  `bobot_essay` tinyint(3) DEFAULT 30
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_ujian`
--

INSERT INTO `tbl_ujian` (`id_ujian`, `nip_guru`, `nama_ujian`, `tanggal_mulai`, `tanggal_selesai`, `durasi`, `status`, `id_pertemuan`, `soal_source`, `bobot_pg`, `bobot_essay`) VALUES
(10, 21101140, 'UTS', '2025-07-26', '2025-07-31', 2, 'aktif', 1, 'manual', 50, 50),
(11, 21101140, 'UAS', '2025-07-26', '2025-07-31', 2, 'aktif', 2, 'manual', 50, 50),
(13, 21101140, 'Harian', '2025-07-26', '2025-07-31', 2, 'aktif', 5, 'manual', 50, 50),
(14, 21101140, 'UTSs', '2025-07-27', '2025-07-31', 2, 'aktif', 7, 'manual', 50, 50),
(15, 21101140, 'ADM', '2025-07-27', '2025-07-31', 2, 'aktif', 8, 'manual', 50, 50),
(16, 21101140, 'UTS', '2025-07-29', '2025-07-31', 2, 'aktif', 10, 'manual', 50, 50);

-- --------------------------------------------------------

--
-- Table structure for table `tugas_siswa`
--

CREATE TABLE `tugas_siswa` (
  `id` int(11) NOT NULL,
  `siswa_id` int(11) NOT NULL,
  `id_pertemuan` int(11) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `original_filename` varchar(255) NOT NULL,
  `file_type` varchar(50) NOT NULL,
  `file_size` int(11) NOT NULL,
  `catatan` text DEFAULT NULL,
  `nilai` decimal(5,2) DEFAULT NULL,
  `dikirim_pada` datetime NOT NULL,
  `diupdate_pada` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tugas_siswa`
--

INSERT INTO `tugas_siswa` (`id`, `siswa_id`, `id_pertemuan`, `file_path`, `original_filename`, `file_type`, `file_size`, `catatan`, `nilai`, `dikirim_pada`, `diupdate_pada`) VALUES
(9, 12345678, 1, 'assets/materi_tugas/e708dc3cdfb0b2d1ed4a25bf376d5cdb.jpg', 'WIN_20231030_13_35_02_Pro (JPG)', 'image/jpeg', 96, 'dadadad', '100.00', '2025-07-16 07:38:18', '2025-07-17 09:57:01'),
(10, 1234567898, 10, 'assets/materi_tugas/11edc41ad71ed5307ea3ba0e6bc3e554.jpg', 'WIN_20231030_13_35_02_Pro (JPG)', 'image/jpeg', 96, NULL, NULL, '2025-07-29 08:31:30', NULL);

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
(41, 10, NULL, 8, 'bank_soal'),
(42, 10, NULL, 5, 'bank_soal'),
(43, 10, NULL, 4, 'bank_soal'),
(44, 10, NULL, 3, 'bank_soal'),
(45, 11, 14, NULL, 'tbl_soal'),
(46, 11, 15, NULL, 'tbl_soal'),
(47, 11, 16, NULL, 'tbl_soal'),
(48, 11, 17, NULL, 'tbl_soal'),
(50, 13, NULL, 5, 'bank_soal'),
(51, 13, NULL, 3, 'bank_soal'),
(52, 13, 18, NULL, 'tbl_soal'),
(53, 13, 19, NULL, 'tbl_soal'),
(54, 14, NULL, 13, 'bank_soal'),
(55, 14, NULL, 11, 'bank_soal'),
(56, 14, NULL, 10, 'bank_soal'),
(57, 14, NULL, 9, 'bank_soal'),
(58, 14, 20, NULL, 'tbl_soal'),
(59, 15, NULL, 12, 'bank_soal'),
(60, 15, NULL, 5, 'bank_soal'),
(61, 15, NULL, 4, 'bank_soal'),
(62, 15, NULL, 3, 'bank_soal'),
(63, 15, 21, NULL, 'tbl_soal'),
(64, 16, NULL, 12, 'bank_soal'),
(65, 16, NULL, 8, 'bank_soal'),
(66, 16, NULL, 4, 'bank_soal'),
(67, 16, NULL, 2, 'bank_soal'),
(68, 16, 22, NULL, 'tbl_soal');

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
  ADD PRIMARY KEY (`id_soal`),
  ADD KEY `id_mapel` (`id_mapel`);

--
-- Indexes for table `forum_diskusi`
--
ALTER TABLE `forum_diskusi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pertemuan` (`id_pertemuan`),
  ADD KEY `user_composite` (`user_type`,`user_id`),
  ADD KEY `fk_parent` (`parent_id`);

--
-- Indexes for table `guru`
--
ALTER TABLE `guru`
  ADD PRIMARY KEY (`nip`),
  ADD UNIQUE KEY `uq_nis` (`nip`),
  ADD KEY `fk_guru_mapel` (`id_mapel`);

--
-- Indexes for table `guru_mapel`
--
ALTER TABLE `guru_mapel`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_guru` (`id_guru`),
  ADD KEY `id_mapel` (`id_mapel`);

--
-- Indexes for table `jawaban_siswa`
--
ALTER TABLE `jawaban_siswa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quiz_siswa_id` (`quiz_siswa_id`),
  ADD KEY `question_id` (`question_id`);

--
-- Indexes for table `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nama_kelas` (`nama_kelas`);

--
-- Indexes for table `mata_pelajaran`
--
ALTER TABLE `mata_pelajaran`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `materi`
--
ALTER TABLE `materi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_guru` (`id_guru`),
  ADD KEY `id_mapel` (`id_mapel`),
  ADD KEY `fk_materi_kelas` (`id_kelas`);

--
-- Indexes for table `pertemuan`
--
ALTER TABLE `pertemuan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_materi` (`id_materi`),
  ADD KEY `id_kelas` (`id_kelas`);

--
-- Indexes for table `quiz`
--
ALTER TABLE `quiz`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pertemuan` (`id_pertemuan`);

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
  ADD PRIMARY KEY (`nis`),
  ADD KEY `id_kelas` (`id_kelas`);

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
  ADD PRIMARY KEY (`id_ujian`),
  ADD KEY `nip_guru` (`nip_guru`),
  ADD KEY `id_pertemuan` (`id_pertemuan`);

--
-- Indexes for table `tugas_siswa`
--
ALTER TABLE `tugas_siswa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `siswa_id` (`siswa_id`),
  ADD KEY `id_pertemuan` (`id_pertemuan`);

--
-- Indexes for table `ujian_soal`
--
ALTER TABLE `ujian_soal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bank_soal_id` (`bank_soal_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bank_soal`
--
ALTER TABLE `bank_soal`
  MODIFY `id_soal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `forum_diskusi`
--
ALTER TABLE `forum_diskusi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `guru_mapel`
--
ALTER TABLE `guru_mapel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `jawaban_siswa`
--
ALTER TABLE `jawaban_siswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `mata_pelajaran`
--
ALTER TABLE `mata_pelajaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `materi`
--
ALTER TABLE `materi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `pertemuan`
--
ALTER TABLE `pertemuan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `quiz`
--
ALTER TABLE `quiz`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `quiz_questions`
--
ALTER TABLE `quiz_questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `quiz_siswa`
--
ALTER TABLE `quiz_siswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_jawaban_siswa`
--
ALTER TABLE `tbl_jawaban_siswa`
  MODIFY `id_jawaban` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=214;

--
-- AUTO_INCREMENT for table `tbl_soal`
--
ALTER TABLE `tbl_soal`
  MODIFY `id_soal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `tbl_ujian`
--
ALTER TABLE `tbl_ujian`
  MODIFY `id_ujian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tugas_siswa`
--
ALTER TABLE `tugas_siswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `ujian_soal`
--
ALTER TABLE `ujian_soal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bank_soal`
--
ALTER TABLE `bank_soal`
  ADD CONSTRAINT `fk_soal_mapel` FOREIGN KEY (`id_mapel`) REFERENCES `mata_pelajaran` (`id`);

--
-- Constraints for table `forum_diskusi`
--
ALTER TABLE `forum_diskusi`
  ADD CONSTRAINT `fk_forum_pertemuan` FOREIGN KEY (`id_pertemuan`) REFERENCES `pertemuan` (`id`),
  ADD CONSTRAINT `fk_parent` FOREIGN KEY (`parent_id`) REFERENCES `forum_diskusi` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `guru`
--
ALTER TABLE `guru`
  ADD CONSTRAINT `fk_guru_mapel` FOREIGN KEY (`id_mapel`) REFERENCES `mata_pelajaran` (`id`);

--
-- Constraints for table `guru_mapel`
--
ALTER TABLE `guru_mapel`
  ADD CONSTRAINT `guru_mapel_ibfk_1` FOREIGN KEY (`id_guru`) REFERENCES `guru` (`nip`),
  ADD CONSTRAINT `guru_mapel_ibfk_2` FOREIGN KEY (`id_mapel`) REFERENCES `mata_pelajaran` (`id`);

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
  ADD CONSTRAINT `fk_materi_guru` FOREIGN KEY (`id_guru`) REFERENCES `guru` (`nip`),
  ADD CONSTRAINT `fk_materi_mapel` FOREIGN KEY (`id_mapel`) REFERENCES `mata_pelajaran` (`id`);

--
-- Constraints for table `pertemuan`
--
ALTER TABLE `pertemuan`
  ADD CONSTRAINT `fk_pertemuan_kelas` FOREIGN KEY (`id_kelas`) REFERENCES `kelas` (`id`),
  ADD CONSTRAINT `fk_pertemuan_materi` FOREIGN KEY (`id_materi`) REFERENCES `materi` (`id`);

--
-- Constraints for table `quiz`
--
ALTER TABLE `quiz`
  ADD CONSTRAINT `quiz_ibfk_1` FOREIGN KEY (`id_pertemuan`) REFERENCES `pertemuan` (`id`);

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
-- Constraints for table `siswa`
--
ALTER TABLE `siswa`
  ADD CONSTRAINT `fk_siswa_kelas` FOREIGN KEY (`id_kelas`) REFERENCES `kelas` (`id`);

--
-- Constraints for table `tbl_jawaban_siswa`
--
ALTER TABLE `tbl_jawaban_siswa`
  ADD CONSTRAINT `fk_jawaban_ke_tblsoal` FOREIGN KEY (`id_soal`) REFERENCES `tbl_soal` (`id_soal`),
  ADD CONSTRAINT `tbl_jawaban_siswa_ibfk_1` FOREIGN KEY (`nis`) REFERENCES `siswa` (`nis`),
  ADD CONSTRAINT `tbl_jawaban_siswa_ibfk_2` FOREIGN KEY (`id_ujian`) REFERENCES `tbl_ujian` (`id_ujian`),
  ADD CONSTRAINT `tbl_jawaban_siswa_ibfk_4` FOREIGN KEY (`bank_soal_id`) REFERENCES `bank_soal` (`id_soal`);

--
-- Constraints for table `tbl_soal`
--
ALTER TABLE `tbl_soal`
  ADD CONSTRAINT `fk_soal_ujian` FOREIGN KEY (`id_ujian`) REFERENCES `tbl_ujian` (`id_ujian`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_ujian`
--
ALTER TABLE `tbl_ujian`
  ADD CONSTRAINT `fk_ujian_guru` FOREIGN KEY (`nip_guru`) REFERENCES `guru` (`nip`),
  ADD CONSTRAINT `fk_ujian_pertemuan` FOREIGN KEY (`id_pertemuan`) REFERENCES `pertemuan` (`id`);

--
-- Constraints for table `tugas_siswa`
--
ALTER TABLE `tugas_siswa`
  ADD CONSTRAINT `fk_tugas_pertemuan` FOREIGN KEY (`id_pertemuan`) REFERENCES `pertemuan` (`id`),
  ADD CONSTRAINT `fk_tugas_siswa` FOREIGN KEY (`siswa_id`) REFERENCES `siswa` (`nis`);

--
-- Constraints for table `ujian_soal`
--
ALTER TABLE `ujian_soal`
  ADD CONSTRAINT `fk_ujian_soal` FOREIGN KEY (`bank_soal_id`) REFERENCES `bank_soal` (`id_soal`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
