-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 09, 2025 at 09:31 AM
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
(16, 'q', 'sqsq', 's', 'sqqs', 's', 'A', 'sedang', 'paham', 21101140, 'guru', 'Matematika', '2025-05-07 11:27:01', 'pilihan'),
(17, 'admin', 'qwdqwdqwdqw', 'dqwdqwd', 'qwdwqd', 'qdwqwd', 'A', 'sedang', 'paham', 0, 'admin', 'Matematika', '2025-05-14 09:21:13', 'pilihan');

-- --------------------------------------------------------

--
-- Table structure for table `forum_diskusi`
--

CREATE TABLE `forum_diskusi` (
  `id` int(11) NOT NULL,
  `user_type` enum('siswa','guru') NOT NULL,
  `user_id` varchar(20) NOT NULL,
  `materi_id` int(11) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `komentar` text NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `forum_diskusi`
--

INSERT INTO `forum_diskusi` (`id`, `user_type`, `user_id`, `materi_id`, `user_name`, `komentar`, `parent_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(20, 'siswa', '123456', 2, 'zccust', 'WDWW', NULL, '2025-05-24 05:08:22', NULL, NULL),
(21, 'siswa', '123456', 2, 'zccust', 'DWDW', 20, '2025-05-24 05:08:27', NULL, NULL),
(22, 'siswa', '123456', 2, 'zccust', 'DWDWD', 21, '2025-05-24 05:08:33', NULL, NULL),
(23, 'siswa', '123456', 2, 'zccust', 'ACSCACA', 21, '2025-05-24 05:08:43', NULL, NULL),
(24, 'guru', '21101140', 2, 'guru terbaikss', 'QDWDQ', 20, '2025-05-24 05:09:45', NULL, NULL),
(25, 'siswa', '123456', 2, 'zccust', 'QSQ', 24, '2025-05-24 05:10:15', NULL, NULL),
(26, 'siswa', '123456', 2, 'zccust', 'DWDW', 24, '2025-05-24 05:11:56', NULL, NULL),
(27, 'guru', '21101140', 2, 'guru terbaikss', 'QWDQWD', 20, '2025-05-24 05:12:15', NULL, NULL),
(28, 'siswa', '123456', 2, 'zccust', 'qwdqd', 27, '2025-05-24 05:14:07', NULL, NULL),
(29, 'siswa', '12345', 2, 'John Doe', 'qwdq', NULL, '2025-05-24 05:14:40', NULL, NULL),
(30, 'siswa', '12345', 2, 'John Doe', 'qwdqdw', 28, '2025-05-24 05:14:47', NULL, NULL),
(31, 'siswa', '12345', 2, 'John Doe', 'wqddq', 20, '2025-05-24 05:14:57', NULL, NULL),
(32, 'siswa', '12345', 2, 'John Doe', 'test', 22, '2025-05-24 05:43:26', NULL, NULL),
(33, 'siswa', '12345', 2, 'John Doe', 'test', 20, '2025-05-24 05:44:17', NULL, NULL),
(34, 'siswa', '12345', 2, 'John Doe', 'test', 20, '2025-05-24 05:44:32', NULL, NULL),
(35, 'siswa', '12345', 2, 'John Doe', 'test', 30, '2025-05-24 05:45:04', NULL, NULL),
(36, 'guru', '21101140', 2, 'guru terbaikss', 'bagus', 29, '2025-05-24 05:52:27', NULL, NULL),
(37, 'guru', '21101140', 2, 'guru terbaikss', 'maenarik', 21, '2025-05-24 05:52:42', NULL, NULL),
(38, 'guru', '21101140', 2, 'guru terbaikss', 'menarik', 32, '2025-05-24 05:53:07', NULL, NULL),
(39, 'siswa', '123456', 2, 'zccust', 'ss', NULL, '2025-05-25 02:47:53', NULL, NULL),
(40, 'siswa', '123456', 2, 'zccust', 'makasih', 36, '2025-05-25 02:49:30', NULL, NULL),
(41, 'siswa', '123456', 2, 'zccust', 'sqs', NULL, '2025-05-25 03:19:40', NULL, NULL),
(42, 'siswa', '123456', 2, 'zccust', 'ewfewf', NULL, '2025-05-25 03:20:02', NULL, NULL),
(43, 'siswa', '123456', 2, 'zccust', 'qwqdwq', NULL, '2025-05-25 03:20:36', NULL, NULL),
(44, 'siswa', '123456', 2, 'zccust', 'dwd', 26, '2025-05-25 03:22:38', NULL, NULL),
(45, 'guru', '21101140', 2, 'guru terbaikss', 'test', 42, '2025-05-25 13:59:44', NULL, NULL);

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
  `user_type` enum('guru') NOT NULL DEFAULT 'guru',
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `guru`
--

INSERT INTO `guru` (`nip`, `email`, `nama_guru`, `password`, `nama_mapel`, `user_type`, `image`) VALUES
(21101140, 'pahrulmaji@gmail.com', 'guru terbaiksss', '$2y$10$lA3ZNJtjvaadgZF8s7g/6eSv4hcvA7gC2K6bMRpywL/ueaGWrHM.C', 'Matematika', 'guru', 'default.jpg'),
(21101141, 'fahreziandika10@gmail.com', 'addust11', '$2y$10$nDOjyUB0msJL1E1FTC7PdeQTCR0ip441LfLFbHZk/g7f2EoQ2vOAO', 'Bahasa Inggris', 'guru', ''),
(21101142, 'test@gmail.com', 'addust111', '$2y$10$SnRGlMYTwJSElDgt6DUza.qK/8tCzJQQfogjZxZxTMXkqMDgeBRU.', 'IPA', 'guru', ''),
(21101143, 'test12@gmail.com', 'useraa', '$2y$10$nk3jFu4/ANCEkgrYFq4F6uYl2UZQHLGtdCAYLSQ6eEkfT9quBoDo.', 'Test', 'guru', ''),
(21101144, 'test12221@gmail.com', 'guru terbaik semesta', '$2y$10$16NmySXyDi2PIaCKH83VkOx1vPCdR8TkGQo0KdyknzLsPnebJJrYK', 'Matematika', 'guru', ''),
(214748364, 'Dummy@gmail.com', 'Ahmad Saugi', '$2y$10$nvcd.PCpCxStCPws.gAfluw192h3YOqXHTZIIp44yDp5RuHfYlg72', 'Pendidikan Agama Islam', 'guru', ''),
(214748365, 'zaidanlineee67@gmail.com', 'Saauky', '$2y$10$3qQ2TYrtQHy44LblPMexnu4ZQrCWD.dYh20P.sOL5cyo6Z48fJQEq', 'Matematika', 'guru', ''),
(1819107728, 'imas@gmail.com', 'Imas Kartika', '$2y$10$wCSBYTaCpSJaEX/1VUo1p.YU88vbgr7PeW.j1OkmD2xnKjIbB7SD6', 'Matematika', 'guru', '');

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
(39, 17, 46, 'a', '1.00'),
(40, 17, 47, 'a', '1.00'),
(41, 17, 48, 'qwdqwdwq', '0.00');

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
(7, 'guru terbaikss', 'Matematika', 'WhatsApp_Video_2025-03-11_at_07_52_16_6ef150956.mp4', 'aasdsad', 'XI', ' adada', 'riyo.jpg', 21101140, 3),
(8, 'guru terbaik semesta', 'Matematika', 'WhatsApp_Video_2025-03-11_at_07_52_16_6ef150957.mp4', 'dwqd', 'XI', ' dqwdqdw', '5141-11123-2-PB1.pdf', 21101144, 1),
(9, 'guru terbaiksss', 'Matematika', 'WhatsApp_Video_2025-03-11_at_07_52_16_6ef150958.mp4', 'asw', 'XI', ' https://chat.deepseek.com/a/chat/s/233e98bb-ca7b-44cc-a1bf-fb6b42d8a3c2', 'Tugas_Regulasi_HAKI_Indonesia.pdf', 21101140, 6);

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
(18, 2, 'qsqs', 'wqdqwdqw', 30, 1, 1, '2025-05-25 14:00:54');

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
(46, 18, 'qwdqwd', 'pilihan', 'qdqwd', 'qwdwqd', 'qdqwd', 'qwdqwd', 'a', 1),
(47, 18, 'qwdqd', 'pilihan', 'qdqwdq', 'dqqd', 'dqqd', 'qwdqwd', 'a', 1),
(48, 18, 'qwdqdqwd', 'essay', NULL, NULL, NULL, NULL, NULL, 1);

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
(17, 18, 123456, '2025-05-25 14:01:40', '2025-05-25 14:01:48', 'completed', '66.67');

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
(12345, 'John Doe', '$2y$10$iQ6P8T2BT5fjJgQuei5OJeuzNzb4MF0GRJD5Zu.kbn6C9w8und8Ea', 'john@example.com', 'default.jpg', 1, '2025-05-14', 'XI', 'siswa'),
(123456, 'zccust', '$2y$10$eXVlmnJT.j/ccoZgn4Z5xOrQ0dQPntdMi0wNTIAooJhrNL2SLoMa6', 'testefwf@gmail.com', 'default.jpg', 1, '2025-05-14', 'XI', 'siswa');

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
  `catatan_essay` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_jawaban_siswa`
--

INSERT INTO `tbl_jawaban_siswa` (`id_jawaban`, `nis`, `id_ujian`, `id_soal`, `bank_soal_id`, `jawaban`, `jawaban_essay`, `ragu_ragu`, `is_selesai`, `jumlah_benar`, `jumlah_salah`, `score`, `tanggal_submit`, `waktu_jawab`, `waktu_mulai_ujian`, `waktu_submit`, `sumber`, `nilai_essay`, `catatan_essay`) VALUES
(194, 12345, 51, NULL, 17, 'A', NULL, 0, 1, 5, 0, 100, NULL, '2025-05-14 02:30:38', NULL, '2025-05-14 09:30:59', 'bank_soal', NULL, NULL),
(195, 12345, 51, NULL, 15, 'A', NULL, 0, 1, 5, 0, 100, NULL, '2025-05-14 02:30:42', NULL, '2025-05-14 09:30:59', 'bank_soal', NULL, NULL),
(196, 12345, 51, NULL, 13, 'A', NULL, 0, 1, 5, 0, 100, NULL, '2025-05-14 02:30:44', NULL, '2025-05-14 09:30:59', 'bank_soal', NULL, NULL),
(197, 12345, 51, 40, NULL, 'A', NULL, 0, 1, 5, 0, 100, NULL, '2025-05-14 02:30:46', NULL, '2025-05-14 09:30:59', 'tbl_soal', NULL, NULL),
(198, 12345, 51, 41, NULL, 'A', NULL, 0, 1, 5, 0, 100, NULL, '2025-05-14 02:30:48', NULL, '2025-05-14 09:30:59', 'tbl_soal', NULL, NULL),
(199, 12345, 52, NULL, 17, 'A', NULL, 0, 1, 1, 1, 50, NULL, '2025-05-14 02:54:27', NULL, '2025-05-14 09:54:35', 'bank_soal', NULL, NULL),
(200, 12345, 52, 42, NULL, 'C', NULL, 0, 1, 1, 1, 50, NULL, '2025-05-14 02:54:31', NULL, '2025-05-14 09:54:35', 'tbl_soal', NULL, NULL),
(201, 123456, 51, NULL, 17, 'A', NULL, 0, 1, 5, 0, 100, NULL, '2025-05-15 03:08:50', NULL, '2025-05-15 10:09:04', 'bank_soal', NULL, NULL),
(202, 123456, 51, NULL, 15, 'A', NULL, 1, 1, 5, 0, 100, NULL, '2025-05-15 03:08:54', NULL, '2025-05-15 10:09:04', 'bank_soal', NULL, NULL),
(203, 123456, 51, NULL, 13, 'A', NULL, 0, 1, 5, 0, 100, NULL, '2025-05-15 03:08:57', NULL, '2025-05-15 10:09:04', 'bank_soal', NULL, NULL),
(204, 123456, 51, 40, NULL, 'A', NULL, 0, 1, 5, 0, 100, NULL, '2025-05-15 03:09:00', NULL, '2025-05-15 10:09:04', 'tbl_soal', NULL, NULL),
(205, 123456, 51, 41, NULL, 'A', NULL, 0, 1, 5, 0, 100, NULL, '2025-05-15 03:09:02', NULL, '2025-05-15 10:09:04', 'tbl_soal', NULL, NULL),
(206, 123456, 52, NULL, 17, 'D', NULL, 0, 1, 0, 2, 0, NULL, '2025-05-15 03:31:08', NULL, '2025-05-15 10:31:13', 'bank_soal', NULL, NULL),
(207, 123456, 52, 42, NULL, 'D', NULL, 0, 1, 0, 2, 0, NULL, '2025-05-15 03:31:10', NULL, '2025-05-15 10:31:13', 'tbl_soal', NULL, NULL),
(270, 123456, 53, NULL, 8, NULL, 'dwqdqwdqwd', 0, 1, 3, 0, 100, NULL, '2025-05-24 23:20:05', NULL, '2025-05-25 06:20:20', 'bank_soal', 66, 'ewfewf'),
(271, 123456, 53, NULL, 16, 'A', NULL, 0, 1, 3, 0, 100, NULL, '2025-05-24 23:20:07', NULL, '2025-05-25 06:20:20', 'bank_soal', NULL, NULL),
(272, 123456, 53, NULL, 17, 'A', NULL, 0, 1, 3, 0, 100, NULL, '2025-05-24 23:20:14', NULL, '2025-05-25 06:20:20', 'bank_soal', NULL, NULL),
(273, 123456, 53, 43, NULL, 'A', NULL, 0, 1, 3, 0, 100, NULL, '2025-05-24 23:20:16', NULL, '2025-05-25 06:20:20', 'tbl_soal', NULL, NULL);

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
(40, 51, 'wdqwd', 'qwdqd', 'dqwdqw', 'dqdqd', 'dqwd', 'A', 'pilihan'),
(41, 51, 'qwddqw', 'qwdqwdwq', 'dqwdqwd', 'qwdwqdw', 'qdwqdq', 'A', 'pilihan'),
(42, 52, 'qdqwdqwd', 'qwdqwd', 'qwdqwd', 'qwdqwdq', 'dq', 'A', 'pilihan'),
(43, 53, 'wcwcw', 'ccwcw', 'wcwc', 'cwwc', 'wcwc', 'A', 'pilihan'),
(44, 52, 'fewfwf', 'weewfew', 'fwefewf', 'wfewf', 'wfeew', 'A', 'pilihan'),
(45, 52, 'wqddq', 'qwdqwd', 'dqdqw', 'qwdqwd', 'dqwqd', 'A', 'pilihan'),
(46, 52, 'agaregaegaegrae', 'gregaegaegaegae', 'graege', 'geagaegaeg', 'raeggae', 'A', 'pilihan'),
(47, 52, 'ewfawfawfawgfawg', 'efwrt3wr34', 'ewrf23rw', 'wefewfewf', 'wefewf', 'A', 'pilihan');

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
(51, 21101144, 'UTS', '2025-05-14', '2025-05-15', 100, 'aktif', 8, 'manual'),
(52, 21101140, 'UTS', '2025-05-14', '2025-05-15', 21, 'aktif', 2, 'manual'),
(53, 21101140, 'wdwd', '2025-05-25', '2025-05-26', 123, 'aktif', 2, 'manual');

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
(7, 123456, 2, 'assets/materi_tugas/b3399cea54e7c036a78984a5bd297bf8.pdf', '559_+Alvaro+Alexander+22507-22513 (PDF)', 'application/pdf', 157, NULL, NULL, '2025-05-21 09:37:30', NULL),
(8, 123456, 1, 'assets/materi_tugas/34201d16be023a1a6c7874303f7fb6ee.png', 'test\' (PNG)', 'image/png', 45, '', '100.00', '2025-06-07 09:08:35', '2025-06-08 02:03:33'),
(9, 123456, 8, 'assets/materi_tugas/6e4d3bcaa6365c89671f0f125267ad6e.png', 'DVSV (PNG)', 'image/png', 43, NULL, NULL, '2025-06-08 02:02:06', NULL),
(10, 123456, 7, 'assets/materi_tugas/909a78572485098f79dfc27c67de62d4.png', 'weff (PNG)', 'image/png', 44, 'cwe', '40.00', '2025-06-08 02:14:34', '2025-06-08 02:19:55');

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
(109, 50, 39, NULL, 'tbl_soal'),
(110, 51, NULL, 17, 'bank_soal'),
(111, 51, NULL, 15, 'bank_soal'),
(112, 51, NULL, 13, 'bank_soal'),
(113, 51, 40, NULL, 'tbl_soal'),
(114, 51, 41, NULL, 'tbl_soal'),
(115, 52, NULL, 17, 'bank_soal'),
(116, 52, 42, NULL, 'tbl_soal'),
(117, 53, NULL, 17, 'bank_soal'),
(118, 53, NULL, 16, 'bank_soal'),
(119, 53, NULL, 8, 'bank_soal'),
(120, 53, 43, NULL, 'tbl_soal'),
(121, 52, 44, NULL, 'tbl_soal'),
(122, 52, 45, NULL, 'tbl_soal'),
(123, 52, 46, NULL, 'tbl_soal'),
(124, 52, 47, NULL, 'tbl_soal');

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
  ADD KEY `user_composite` (`user_type`,`user_id`),
  ADD KEY `fk_parent` (`parent_id`);

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
  MODIFY `id_soal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `forum_diskusi`
--
ALTER TABLE `forum_diskusi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `jawaban_siswa`
--
ALTER TABLE `jawaban_siswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `kategori_soal`
--
ALTER TABLE `kategori_soal`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `materi`
--
ALTER TABLE `materi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `materi_status`
--
ALTER TABLE `materi_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quiz`
--
ALTER TABLE `quiz`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `quiz_questions`
--
ALTER TABLE `quiz_questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `quiz_siswa`
--
ALTER TABLE `quiz_siswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `tbl_jawaban_siswa`
--
ALTER TABLE `tbl_jawaban_siswa`
  MODIFY `id_jawaban` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=274;

--
-- AUTO_INCREMENT for table `tbl_soal`
--
ALTER TABLE `tbl_soal`
  MODIFY `id_soal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `tbl_ujian`
--
ALTER TABLE `tbl_ujian`
  MODIFY `id_ujian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `token`
--
ALTER TABLE `token`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `tugas_siswa`
--
ALTER TABLE `tugas_siswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `ujian_soal`
--
ALTER TABLE `ujian_soal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=125;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `forum_diskusi`
--
ALTER TABLE `forum_diskusi`
  ADD CONSTRAINT `fk_parent` FOREIGN KEY (`parent_id`) REFERENCES `forum_diskusi` (`id`) ON DELETE CASCADE;

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
