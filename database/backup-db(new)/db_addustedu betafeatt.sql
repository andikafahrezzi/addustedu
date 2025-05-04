-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 03, 2025 at 04:31 PM
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
(1, '33e3ww', 'e3e3e3', 'sdsds', 'e3e3e', 'sdsdsd', 'A', 'mudah', 'evaluasi', 0, 'admin', 'sddss', '2025-05-01 06:47:58', 'pilihan'),
(2, 'dwdw', 'dwwdw', 'dww', 'wdw', 'wdw', 'A', 'mudah', 'aplikasi', 0, 'admin', 'dwwd', '2025-05-01 07:06:54', 'pilihan'),
(6, 'wwW', 'ww', 'ww', 'ww', 'ww', 'A', 'sedang', 'paham', 21101140, 'guru', 'Matematika', '2025-05-01 12:55:44', 'pilihan'),
(7, 'XXX', 'WXXX', 'XX', 'XXX', 'XXX', 'A', 'sulit', 'evaluasi', 21101140, 'guru', 'Matematika', '2025-05-01 13:30:14', 'pilihan'),
(8, 'qqq', NULL, NULL, NULL, NULL, NULL, 'sulit', 'evaluasi', 21101140, 'guru', 'Matematika', '2025-05-03 10:56:51', 'essay'),
(9, 'dqwddqwd', 'q', 'q', 'q', 'q', 'A', 'mudah', 'ingatan', 21101140, 'guru', 'Matematika', '2025-05-03 10:57:01', 'pilihan'),
(10, 'aaa', 'aa', 'aa', 'aa', 'aa', 'A', 'sedang', 'paham', 0, 'admin', 'aaa', '2025-05-03 06:26:05', 'pilihan'),
(11, 'ww', 'a', NULL, NULL, NULL, NULL, 'sulit', 'paham', 0, 'admin', 'ww', '2025-05-03 06:26:57', 'essay'),
(12, 'asewd', 'fewfewfwe', 'ffewe', 'ewfew', 'fewf', 'A', 'mudah', 'evaluasi', 0, 'admin', 'Matematika', '2025-05-03 14:01:53', 'pilihan'),
(13, 'WW', 'A', 'A', 'A', 'A', 'A', 'sedang', 'paham', 21101140, 'guru', 'Matematika', '2025-05-03 21:04:23', 'pilihan');

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
(101, 123456, 2, 'user', 's\r\n', NULL, '2025-04-26 22:13:22', '2025-04-27 10:13:22', NULL, NULL, NULL);

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
(21, 14, 30, 'a', '1.00');

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
(6, 'guru terbaikss', 'Matematika', 'WhatsApp_Video_2025-03-11_at_07_52_16_6ef150955.mp4', 'asa', 'XI', ' swa', '4845-17134-1-PB4.pdf', 21101140, 2);

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
(16, 2, 'aku', 'sss', 30, 1, 1, '2025-04-19 14:41:28');

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
(30, 16, 'wdqdqd', 'pilihan', 'qwdqwdw', 'dqqwd', 'qwdqwd', 'dqqwd', 'a', 1);

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
(14, 16, 123456, '2025-04-19 14:41:53', '2025-04-19 14:41:57', 'completed', '100.00');

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
  `date_created` int(64) NOT NULL,
  `kelas` varchar(5) NOT NULL DEFAULT '',
  `user_type` enum('siswa') NOT NULL DEFAULT 'siswa'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `siswa`
--

INSERT INTO `siswa` (`nis`, `nama`, `password`, `email`, `image`, `is_active`, `date_created`, `kelas`, `user_type`) VALUES
(0, 'addust', '$2y$10$cYm/i5rWupzWKrc92nX4EublfQgeyyZl4AQyu2e4rbKFQUwc8iv9u', 'addust@gmial.com', 'default.jpg', 1, 1742275981, '', 'siswa'),
(39, 'Syaauqi Zaaidan', '$2y$10$djI2M/FQH2k3H7b6tLK5X.MZG1R.wrARoR6NerH3tsScNnsNCnexa', 'zaidanline67@gmail.com', '73349393_156861225523800_2119508204152772215_n_(1)6.jpg', 1, 1586163321, 'X', 'siswa'),
(11323, 'bjbsjb1', '$2y$10$VOoalVJV9zYYueBRttR7DevfcHEhH2ilZFt0OBLsF17iGT5pMCSKO', 'nasigir1e@gmail.com', 'default.jpg', 1, 1744613912, '', 'siswa'),
(18883, 'addusttt', '$2y$10$m3uP.Pe16p8NuQXi48Xen.EkUXHag.tcIq5.xzs2w.L88Ak0w7MYa', 'addust1@gmail.com', 'riyo1.jpg', 1, 1742454210, 'XI', 'siswa'),
(123456, 'user', '$2y$10$lG3qWm29AejdK/HV2iIwDOGzIAo3Q3MqlxVcODDQrj.hQvBYwWkdi', 'use1@gmail.com', 'default.jpg', 1, 1735200089, 'XI', 'siswa'),
(147852, 'dwdqwddq', '$2y$10$3T5Nmo7ZQIiF.h4e9Qqxo.oRzcYXGlceENvn9gObYM9lsXlsBlzDG', 'test12@gmail.com', 'default.jpg', 1, 1744168247, 'XII', 'siswa'),
(181816, 'qsqwdqwd', '$2y$10$YJppxwZ1JOt3s1/Xf9rgWewsjN8ZIhK1b.F39GcTmVS0uy5oOlhDK', 'testwd@gmail.com', 'default.jpg', 1, 1742296726, 'X', 'siswa'),
(211011, 'addust', '$2y$10$jxtWU6XSRAaV/kU0UqlUeurzzcp9EFVEuXJmwiGUrOSLjK9oSvjB6', '', 'default.jpg', 1, 1742276422, '', 'siswa'),
(232332, 'aasdadee qw', '$2y$10$luY1AxePrqda2kLL61Vu0.i/ZEtGLEvmamD3E4nrjBktQ4z1Va3V2', 'testwewe1@gmail.com', 'default.jpg', 1, 1742295476, '', 'siswa'),
(456123, 'wqdqdqw', '$2y$10$/Rx33H/8HvUpFcj3F4AM7eqlFnR17N38y7pt8pt0Ew3kRI3HwcNqi', 'nasigirewww@gmail.com', 'default.jpg', 1, 1744168582, 'XII', 'siswa'),
(456789, 'nasi gile', '$2y$10$LwYTyg0Usc1SNcQe50HY3.7ZWcRIy926dKlbLA8bZrWtgFMoTZMvq', '', 'default.jpg', 1, 1739114168, 'XII', 'siswa');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_jawaban_siswa`
--

CREATE TABLE `tbl_jawaban_siswa` (
  `id_jawaban` int(11) NOT NULL,
  `nis` int(11) DEFAULT NULL,
  `id_ujian` int(11) DEFAULT NULL,
  `id_soal` int(11) DEFAULT NULL,
  `jawaban` varchar(1) DEFAULT NULL,
  `ragu_ragu` tinyint(1) DEFAULT 0,
  `is_selesai` tinyint(1) DEFAULT 0,
  `jumlah_benar` int(11) DEFAULT 0,
  `jumlah_salah` int(11) DEFAULT 0,
  `score` float DEFAULT 0,
  `tanggal_submit` datetime DEFAULT NULL,
  `waktu_jawab` timestamp NOT NULL DEFAULT current_timestamp(),
  `waktu_mulai_ujian` datetime DEFAULT NULL,
  `waktu_submit` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_jawaban_siswa`
--

INSERT INTO `tbl_jawaban_siswa` (`id_jawaban`, `nis`, `id_ujian`, `id_soal`, `jawaban`, `ragu_ragu`, `is_selesai`, `jumlah_benar`, `jumlah_salah`, `score`, `tanggal_submit`, `waktu_jawab`, `waktu_mulai_ujian`, `waktu_submit`) VALUES
(72, 123456, 20, NULL, NULL, 0, 1, 0, 0, 0, '2025-05-03 14:17:16', '2025-05-03 12:17:16', NULL, NULL),
(73, 123456, 21, NULL, NULL, 0, 1, 0, 0, 0, '2025-05-03 14:18:11', '2025-05-03 12:18:11', NULL, NULL),
(74, 123456, 22, NULL, NULL, 0, 1, 0, 0, 0, '2025-05-03 14:20:39', '2025-05-03 12:20:39', NULL, NULL),
(75, 18883, 20, NULL, NULL, 0, 1, 0, 0, 0, '2025-05-03 14:23:26', '2025-05-03 12:23:26', NULL, NULL),
(76, 18883, 21, NULL, NULL, 0, 1, 0, 0, 0, '2025-05-03 14:23:41', '2025-05-03 12:23:41', NULL, NULL),
(77, 18883, 22, NULL, NULL, 0, 1, 0, 0, 0, NULL, '2025-05-03 12:38:09', '2025-05-03 14:38:09', '2025-05-03 14:38:09'),
(78, 18883, 23, NULL, NULL, 0, 1, 0, 0, 0, NULL, '2025-05-03 12:39:24', '2025-05-03 14:39:24', '2025-05-03 14:39:24'),
(79, 18883, 24, NULL, NULL, 0, 1, 0, 0, 0, '2025-05-03 15:03:09', '2025-05-03 12:48:19', '2025-05-03 14:48:19', NULL),
(80, 123456, 23, NULL, NULL, 0, 1, 0, 0, 0, '2025-05-03 15:03:40', '2025-05-03 13:03:29', '2025-05-03 15:03:29', NULL),
(81, 123456, 24, NULL, NULL, 0, 1, 0, 0, 0, '2025-05-03 15:04:03', '2025-05-03 13:03:51', '2025-05-03 15:03:51', NULL),
(82, 123456, 25, NULL, NULL, 0, 1, 0, 0, 0, '2025-05-03 15:40:33', '2025-05-03 13:19:56', '2025-05-03 15:19:56', '2025-05-03 15:54:21'),
(83, 123456, 26, NULL, NULL, 0, 1, 0, 1, 0, '2025-05-03 15:40:53', '2025-05-03 13:34:10', '2025-05-03 15:34:10', '2025-05-03 15:54:38'),
(84, 18883, 25, NULL, NULL, 0, 1, 0, 0, 0, NULL, '2025-05-03 13:46:00', '2025-05-03 15:46:00', '2025-05-03 15:53:39'),
(85, 18883, 26, NULL, NULL, 0, 1, 1, 0, 100, NULL, '2025-05-03 13:53:48', '2025-05-03 15:53:48', '2025-05-03 15:53:56'),
(86, 18883, 26, 20, 'A', 0, 1, 1, 0, 100, NULL, '2025-05-03 13:53:56', NULL, '2025-05-03 15:53:56'),
(87, 123456, 26, 20, 'C', 0, 1, 0, 1, 0, NULL, '2025-05-03 13:54:38', NULL, '2025-05-03 15:54:38'),
(88, 123456, 27, NULL, NULL, 0, 1, 1, 0, 100, NULL, '2025-05-03 13:56:20', '2025-05-03 15:56:20', '2025-05-03 15:56:30'),
(89, 123456, 27, 21, 'A', 0, 1, 1, 0, 100, NULL, '2025-05-03 13:56:30', NULL, '2025-05-03 15:56:30'),
(90, 18883, 27, NULL, NULL, 0, 1, 0, 1, 0, NULL, '2025-05-03 13:56:51', '2025-05-03 15:56:51', '2025-05-03 15:57:07'),
(91, 18883, 27, 21, 'B', 0, 1, 0, 1, 0, NULL, '2025-05-03 13:57:07', NULL, '2025-05-03 15:57:07'),
(92, 18883, 28, NULL, NULL, 0, 1, 0, 0, 0, NULL, '2025-05-03 13:57:52', '2025-05-03 15:57:52', '2025-05-03 15:58:07'),
(93, 123456, 28, NULL, NULL, 0, 1, 0, 0, 0, NULL, '2025-05-03 13:58:37', '2025-05-03 15:58:37', '2025-05-03 15:58:46'),
(94, 123456, 29, NULL, NULL, 0, 1, 1, 0, 100, NULL, '2025-05-03 14:01:16', '2025-05-03 16:01:16', '2025-05-03 16:01:20'),
(95, 123456, 29, 23, 'A', 0, 1, 1, 0, 100, NULL, '2025-05-03 14:01:20', NULL, '2025-05-03 16:01:20'),
(96, 123456, 30, NULL, NULL, 0, 1, 0, 0, 0, NULL, '2025-05-03 14:01:35', '2025-05-03 16:01:35', '2025-05-03 16:02:47'),
(97, 18883, 29, NULL, NULL, 0, 1, 0, 1, 0, NULL, '2025-05-03 14:06:44', '2025-05-03 16:06:44', '2025-05-03 16:06:50'),
(98, 18883, 29, 23, 'B', 0, 1, 0, 1, 0, NULL, '2025-05-03 14:06:50', NULL, '2025-05-03 16:06:50'),
(99, 18883, 30, NULL, NULL, 0, 1, 0, 0, 0, NULL, '2025-05-03 14:07:04', '2025-05-03 16:07:04', '2025-05-03 16:07:10'),
(100, 18883, 31, NULL, NULL, 0, 0, 0, 0, 0, NULL, '2025-05-03 14:13:32', '2025-05-03 16:13:32', NULL),
(103, 123456, 31, NULL, NULL, 0, 1, 0, 0, 0, NULL, '2025-05-03 14:20:52', '2025-05-03 16:20:52', '2025-05-03 16:24:53'),
(106, 123456, 32, NULL, NULL, 0, 1, 2, 0, 100, NULL, '2025-05-03 14:26:37', '2025-05-03 16:26:37', '2025-05-03 16:26:43'),
(107, 123456, 32, 24, 'A', 0, 1, 2, 0, 100, NULL, '2025-05-03 14:26:43', NULL, '2025-05-03 16:26:43'),
(108, 123456, 32, 25, 'A', 1, 1, 2, 0, 100, NULL, '2025-05-03 14:26:43', NULL, '2025-05-03 16:26:43');

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
(18, 21, 'wqdqwd', 'qwdqwd', 'dqwqwdqw', 'dqwd', 'qwdqw', 'A'),
(19, 22, 'wdd', 'wdwd', 'wdwdw', 'dwdw', 'wdw', 'B'),
(20, 26, 'wdqwd', 'dwq', 'qwdd', 'dqwdw', 'qwddqw', 'A'),
(21, 27, '222', 'ww', 'ww', 'q2', '22', 'A'),
(22, 27, '2', '2', '2', '2', '2', 'A'),
(23, 29, 'ss', 'ss', 'ss', 'ss', 'ss', 'A'),
(24, 32, '2qdd', 'dqwqwdqw', 'dqwdqw', 'dqwwqd', 'dwqw', 'A'),
(25, 32, 'wdqdqwd', 'qwdqwd', 'wqdwqd', 'dwqdqd', 'wdqqdqwd', 'A');

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
(20, 21101140, 'dfwed', '2025-05-03', '2025-05-04', 1, 'aktif', 2, 'manual'),
(21, 21101140, '1111', '2025-05-03', '2025-05-17', 2, 'aktif', 2, 'manual'),
(22, 21101140, 'UTS', '2025-05-03', '2025-05-04', 2, 'aktif', 2, 'manual'),
(23, 21101140, 'UTS', '2025-05-03', '2025-05-22', 20, 'aktif', 6, 'manual'),
(24, 21101140, 'wdw', '2025-05-03', '2025-05-22', 20, 'aktif', 6, 'manual'),
(25, 21101140, 'UTS', '2025-05-03', '2025-05-10', 22, 'aktif', 6, 'manual'),
(26, 21101140, 'UTS', '2025-05-03', '2025-05-10', 22, 'aktif', 6, 'manual'),
(27, 21101140, 'please', '2025-05-03', '2025-05-04', 22, 'aktif', 2, 'manual'),
(28, 21101140, 'pleases', '2025-05-03', '2025-05-04', 22, 'aktif', 2, 'manual'),
(29, 21101140, 'dqww', '2025-05-03', '2025-05-04', 22, 'aktif', 2, 'manual'),
(30, 21101140, 'dqww', '2025-05-03', '2025-05-04', 22, 'aktif', 2, 'manual'),
(31, 21101140, 'wdwd', '2025-05-03', '2025-05-10', 22, 'aktif', 2, 'manual'),
(32, 21101140, 'wdwdqq', '2025-05-03', '2025-05-10', 22, 'aktif', 2, 'manual');

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

--
-- Dumping data for table `tugas_siswa`
--

INSERT INTO `tugas_siswa` (`id`, `siswa_id`, `materi_id`, `file_path`, `original_filename`, `file_type`, `file_size`, `catatan`, `nilai`, `dikirim_pada`, `diupdate_pada`) VALUES
(5, 123456, 2, 'assets/materi_tugas/4ffa8f57cc1d87126a96a82895de9eff.jpg', 'riyo (JPG)', 'image/jpeg', 44, 'se', '100.00', '2025-04-19 14:42:27', '2025-04-19 14:43:12');

-- --------------------------------------------------------

--
-- Table structure for table `ujian_soal`
--

CREATE TABLE `ujian_soal` (
  `id` int(11) NOT NULL,
  `ujian_id` int(11) NOT NULL,
  `soal_id` int(11) NOT NULL,
  `sumber` enum('bank_soal','tbl_soal') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ujian_soal`
--

INSERT INTO `ujian_soal` (`id`, `ujian_id`, `soal_id`, `sumber`) VALUES
(13, 20, 9, 'bank_soal'),
(14, 21, 9, 'bank_soal'),
(15, 21, 8, 'bank_soal'),
(16, 21, 7, 'bank_soal'),
(17, 21, 6, 'bank_soal'),
(18, 21, 18, 'tbl_soal'),
(19, 22, 9, 'bank_soal'),
(20, 22, 8, 'bank_soal'),
(21, 22, 7, 'bank_soal'),
(22, 22, 6, 'bank_soal'),
(23, 22, 19, 'tbl_soal'),
(24, 23, 9, 'bank_soal'),
(25, 23, 8, 'bank_soal'),
(26, 23, 7, 'bank_soal'),
(27, 24, 9, 'bank_soal'),
(28, 24, 8, 'bank_soal'),
(29, 24, 7, 'bank_soal'),
(30, 25, 9, 'bank_soal'),
(31, 25, 7, 'bank_soal'),
(32, 25, 6, 'bank_soal'),
(33, 26, 20, 'tbl_soal'),
(34, 27, 9, 'bank_soal'),
(35, 27, 8, 'bank_soal'),
(36, 27, 7, 'bank_soal'),
(37, 27, 6, 'bank_soal'),
(38, 27, 21, 'tbl_soal'),
(39, 28, 9, 'bank_soal'),
(40, 28, 8, 'bank_soal'),
(41, 28, 7, 'bank_soal'),
(42, 28, 6, 'bank_soal'),
(43, 30, 9, 'bank_soal'),
(44, 30, 7, 'bank_soal'),
(45, 30, 6, 'bank_soal'),
(46, 27, 22, 'tbl_soal'),
(47, 29, 23, 'tbl_soal'),
(48, 31, 13, 'bank_soal'),
(49, 31, 9, 'bank_soal'),
(50, 31, 7, 'bank_soal'),
(51, 31, 6, 'bank_soal'),
(52, 32, 24, 'tbl_soal'),
(53, 32, 25, 'tbl_soal');

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
  ADD KEY `id_soal` (`id_soal`);

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
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT for table `jawaban_siswa`
--
ALTER TABLE `jawaban_siswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `kategori_soal`
--
ALTER TABLE `kategori_soal`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `materi`
--
ALTER TABLE `materi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `materi_status`
--
ALTER TABLE `materi_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quiz`
--
ALTER TABLE `quiz`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `quiz_questions`
--
ALTER TABLE `quiz_questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `quiz_siswa`
--
ALTER TABLE `quiz_siswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tbl_jawaban_siswa`
--
ALTER TABLE `tbl_jawaban_siswa`
  MODIFY `id_jawaban` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- AUTO_INCREMENT for table `tbl_soal`
--
ALTER TABLE `tbl_soal`
  MODIFY `id_soal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `tbl_ujian`
--
ALTER TABLE `tbl_ujian`
  MODIFY `id_ujian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `token`
--
ALTER TABLE `token`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `tugas_siswa`
--
ALTER TABLE `tugas_siswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `ujian_soal`
--
ALTER TABLE `ujian_soal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

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
  ADD CONSTRAINT `tbl_jawaban_siswa_ibfk_1` FOREIGN KEY (`nis`) REFERENCES `siswa` (`nis`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_jawaban_siswa_ibfk_2` FOREIGN KEY (`id_ujian`) REFERENCES `tbl_ujian` (`id_ujian`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_jawaban_siswa_ibfk_3` FOREIGN KEY (`id_soal`) REFERENCES `tbl_soal` (`id_soal`) ON DELETE CASCADE;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
