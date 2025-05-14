-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 14, 2025 at 10:01 AM
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
(119, 12345, 1, 'John Doe', 'qwdwq', NULL, '2025-05-14 02:55:05', '2025-05-14 14:55:05', NULL, NULL, NULL),
(120, 123456, 1, 'zccust', 'akuuuuuuuuu', NULL, '2025-05-14 02:56:09', '2025-05-14 14:56:09', '2025-05-14 09:59:07', NULL, NULL),
(121, 123456, 2, 'zccust', 'ww', NULL, '2025-05-14 02:58:01', '2025-05-14 14:58:01', NULL, NULL, NULL),
(122, 123456, 2, 'zccust', 'ww', NULL, '2025-05-14 02:58:49', '2025-05-14 14:58:49', NULL, NULL, NULL),
(123, 123456, 1, 'zccust', 'mikji', NULL, '2025-05-14 02:59:29', '2025-05-14 14:59:29', NULL, NULL, NULL);

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
(8, 'guru terbaik semesta', 'Matematika', 'WhatsApp_Video_2025-03-11_at_07_52_16_6ef150957.mp4', 'dwqd', 'XI', ' dqwdqdw', '5141-11123-2-PB1.pdf', 21101144, 1);

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
(194, 12345, 51, NULL, 17, 'A', 0, 1, 5, 0, 100, NULL, '2025-05-14 02:30:38', NULL, '2025-05-14 09:30:59', 'bank_soal'),
(195, 12345, 51, NULL, 15, 'A', 0, 1, 5, 0, 100, NULL, '2025-05-14 02:30:42', NULL, '2025-05-14 09:30:59', 'bank_soal'),
(196, 12345, 51, NULL, 13, 'A', 0, 1, 5, 0, 100, NULL, '2025-05-14 02:30:44', NULL, '2025-05-14 09:30:59', 'bank_soal'),
(197, 12345, 51, 40, NULL, 'A', 0, 1, 5, 0, 100, NULL, '2025-05-14 02:30:46', NULL, '2025-05-14 09:30:59', 'tbl_soal'),
(198, 12345, 51, 41, NULL, 'A', 0, 1, 5, 0, 100, NULL, '2025-05-14 02:30:48', NULL, '2025-05-14 09:30:59', 'tbl_soal'),
(199, 12345, 52, NULL, 17, 'A', 0, 1, 1, 1, 50, NULL, '2025-05-14 02:54:27', NULL, '2025-05-14 09:54:35', 'bank_soal'),
(200, 12345, 52, 42, NULL, 'C', 0, 1, 1, 1, 50, NULL, '2025-05-14 02:54:31', NULL, '2025-05-14 09:54:35', 'tbl_soal');

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
(40, 51, 'wdqwd', 'qwdqd', 'dqwdqw', 'dqdqd', 'dqwd', 'A'),
(41, 51, 'qwddqw', 'qwdqwdwq', 'dqwdqwd', 'qwdwqdw', 'qdwqdq', 'A'),
(42, 52, 'qdqwdqwd', 'qwdqwd', 'qwdqwd', 'qwdqwdq', 'dq', 'A');

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
(52, 21101140, 'UTS', '2025-05-14', '2025-05-15', 21, 'aktif', 2, 'manual');

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
(116, 52, 42, NULL, 'tbl_soal');

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
  MODIFY `id_soal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `forum_diskusi`
--
ALTER TABLE `forum_diskusi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=124;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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
  MODIFY `id_jawaban` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=201;

--
-- AUTO_INCREMENT for table `tbl_soal`
--
ALTER TABLE `tbl_soal`
  MODIFY `id_soal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `tbl_ujian`
--
ALTER TABLE `tbl_ujian`
  MODIFY `id_ujian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=117;

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
