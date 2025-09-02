-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 01, 2025 at 11:30 AM
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
-- Database: `db_addustedudev`
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
  `created_by` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  `user_type` enum('admin','guru') NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `tipe_soal` enum('pilihan','essay') NOT NULL DEFAULT 'pilihan',
  `id_mapel` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bank_soal`
--

INSERT INTO `bank_soal` (`id_soal`, `pertanyaan`, `pilihan_a`, `pilihan_b`, `pilihan_c`, `pilihan_d`, `kunci_jawaban`, `tingkat_kesulitan`, `tipe_kognitif`, `created_by`, `user_type`, `created_at`, `tipe_soal`, `id_mapel`) VALUES
(1, '1 + 1 = ?', '1', '2', '3', '4', 'A', 'sulit', 'analisis', '1', 'admin', '2025-08-17 20:00:44', 'pilihan', 2),
(2, 'aljabar adalah?', NULL, NULL, NULL, NULL, NULL, 'sedang', 'paham', '21101140', 'guru', '2025-08-18 01:01:29', 'essay', 2),
(3, 'kenapa aljabar penting?', NULL, NULL, NULL, NULL, NULL, 'sulit', 'paham', '21101140', 'guru', '2025-08-18 01:01:50', 'essay', 2),
(4, 'kenapa administrasi penting?', NULL, NULL, NULL, NULL, NULL, 'sulit', 'paham', '21101140', 'guru', '2025-08-18 01:37:26', 'essay', 1),
(5, 'kenapa administrasi penting?', 'karena A', 'karena AC', 'karena AD', 'karena B', 'A', 'mudah', 'evaluasi', '21101140', 'guru', '2025-08-18 01:38:08', 'pilihan', 1);

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
(1, 'guru', '21101140', 1, NULL, 'Jangan lupa kerjakan quiznya Teman-teman', '2025-08-17 21:35:30', NULL, NULL),
(2, 'siswa', '12345678', 1, 1, 'test', '2025-08-22 14:31:08', NULL, NULL),
(3, 'siswa', '12345678', 1, 2, 'test', '2025-08-22 14:31:22', NULL, NULL),
(4, 'siswa', '12345678', 1, 3, 'test', '2025-08-22 14:31:34', NULL, NULL),
(5, 'siswa', '12345678', 1, 3, 'dqwwwwwwwwdqwdqwdqwdqwdqwdqwdqwdqwdqwdqwdqwdqwdqwdqwdqwdqwdqwdqwdqwdqwdqwdqwdqwdqwdqwdqwwwwwww', '2025-08-22 14:32:48', NULL, NULL),
(8, 'guru', '21101140', 1, NULL, 'testd', '2025-08-29 10:10:51', '2025-08-29 10:11:03', NULL),
(9, 'guru', '21101140', 1, 5, 'balas', '2025-08-29 10:11:14', '2025-08-29 15:11:25', '2025-08-29 10:11:25'),
(10, 'siswa', '12345678999', 1, NULL, 'kontol', '2025-08-29 14:28:45', '2025-08-29 19:29:01', '2025-08-29 14:29:01'),
(11, 'siswa', '12345678999', 1, NULL, 'tests', '2025-08-29 14:32:05', '2025-08-29 14:32:24', NULL),
(12, 'siswa', '12345678999', 1, 8, 'selamat pagi guru', '2025-08-29 14:32:41', '2025-08-29 19:32:54', '2025-08-29 14:32:54');

-- --------------------------------------------------------

--
-- Table structure for table `guru`
--

CREATE TABLE `guru` (
  `nip` varchar(20) NOT NULL,
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
('21101140', 'pahrulmaji@gmail.com', 'Guru Terbaik', '$2y$10$nP.nAiLkI0z/Hw7ZsGqaYOW5pRsOEXRmqmMkGfa4FBHTVqZWXvFZS', 'guru', 'default.jpg', NULL),
('21101141', 'test@gmail.com', 'addust', '$2y$10$HstvPR5G0R1.udZ8Q7LrHOOuaVa81CIeSo6ryxWL9mj14GwQm0NfO', 'guru', 'default.jpg', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `guru_mapel`
--

CREATE TABLE `guru_mapel` (
  `id` int(11) NOT NULL,
  `id_guru` varchar(20) CHARACTER SET latin1 NOT NULL,
  `id_mapel` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `guru_mapel`
--

INSERT INTO `guru_mapel` (`id`, `id_guru`, `id_mapel`) VALUES
(26, '21101140', 1),
(27, '21101140', 2),
(28, '21101141', 3),
(29, '21101141', 4);

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
(1, 1, 1, 'a', '1.00'),
(2, 1, 2, 'a', '1.00'),
(3, 1, 3, 'a', '1.00'),
(4, 1, 4, 'a', '1.00'),
(5, 1, 5, 'a', '0.00'),
(6, 2, 6, 'b', '1.00'),
(7, 2, 7, 'a', '2.00'),
(8, 2, 8, 'd', '0.00'),
(9, 2, 9, 'b', '3.00'),
(10, 2, 11, 'd', '0.00'),
(16, 4, 6, 'b', '1.00'),
(17, 4, 7, 'd', '0.00'),
(18, 4, 8, 'b', '0.00'),
(19, 4, 9, 'b', '3.00'),
(20, 4, 11, 'b', '3.00');

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
(1, 'PC1IPS1', 'X', 'Ilmu Pengetahuan Sos'),
(2, 'PC1IPS2', 'XI', 'Ilmu Pengetahuan Sos'),
(3, 'PC1IPS3', 'XII', 'Ilmu Pengetahuan Sos'),
(4, 'PC1IPA1', 'X', 'Ilmu Pengetahuan Ala'),
(5, 'PC1IPA2', 'XI', 'Ilmu Pengetahuan Ala'),
(6, 'PC1IPA3', 'XII', 'Ilmu Pengetahuan Ala');

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
(1, 'Administrasi', 'lorems'),
(2, 'Matematika', 'lorems'),
(3, 'Ilmu Pengetahuan Alam', 'lorems'),
(4, 'Ilmu Pengetahuan Sosial', 'lorems'),
(5, 'Manajemen', 'lorems');

-- --------------------------------------------------------

--
-- Table structure for table `materi`
--

CREATE TABLE `materi` (
  `id` int(11) NOT NULL,
  `id_guru` varchar(20) NOT NULL,
  `id_mapel` int(11) NOT NULL,
  `id_kelas` int(11) NOT NULL,
  `video` varchar(1024) DEFAULT NULL,
  `deskripsi` varchar(1024) NOT NULL,
  `linkform` varchar(100) DEFAULT NULL,
  `modul` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `materi`
--

INSERT INTO `materi` (`id`, `id_guru`, `id_mapel`, `id_kelas`, `video`, `deskripsi`, `linkform`, `modul`) VALUES
(1, '21101140', 1, 1, 'https://www.youtube.com/embed/AlrOq3W7IZ4?rel=0', 'ascaca', ' cacsa', '563-Article_Text-2917-1-10-20220728.pdf'),
(2, '21101140', 2, 1, 'https://www.youtube.com/embed/QFLAuddS6qM?rel=0', 'FWFEWFEWF', 'FWEFWFWFWF', '918-1743-1-SM.pdf'),
(3, '21101140', 2, 1, 'https://www.youtube.com/embed/eQv10AP5BG0?rel=0&modestbranding=1', 'CACASC', ' CACACACAC', '563-Article_Text-2917-1-10-202207281.pdf'),
(4, '21101140', 1, 1, 'https://www.youtube.com/embed/4HrweW4IqJc?rel=0', 'wfwfwefwe', 'fwefwefwe', '1416-Article_Text-2548-1-10-20221110.pdf'),
(5, '21101140', 2, 1, 'https://www.youtube.com/embed/eQv10AP5BG0?rel=0', 'cddqwd', 'qwdqwdq', '563-Article_Text-2917-1-10-202207282.pdf'),
(7, '21101141', 3, 1, 'https://www.youtube.com/embed/x1x71WPgy8I?rel=0', 'bisa', 'https://youtu.be/x1x71WPgy8I?si=GddFy3cPJ7Q-Nwzw', '3163-7623-1-PB1.pdf'),
(8, '21101141', 3, 1, 'https://www.youtube.com/embed/x1x71WPgy8I?rel=0', 'https://youtu.be/x1x71WPgy8I?si=RSjxs7rBj7fZk7Fa', 'https://youtu.be/x1x71WPgy8I?si=RSjxs7rBj7fZk7Fa', '412-Article_Text-1358-1-10-20220625.pdf');

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
(1, 1, 1, 1, '2025-08-17'),
(2, 2, 1, 1, '2025-08-17'),
(3, 3, 1, 2, '2025-08-17'),
(4, 4, 1, 2, '2025-08-17'),
(5, 5, 1, 3, '2025-08-17'),
(6, 8, 1, 1, '2025-08-28'),
(7, 7, 1, 2, '2025-08-28'),
(10, 7, 1, 3, '2025-08-28');

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
(1, 2, 'aljabar only', 'quiz tentang al jabar', 30, 1, 1, '2025-08-17 20:35:37'),
(2, 1, 'Administrasi', 'ini deskripsi', 30, 1, 1, '2025-08-24 06:29:24'),
(3, 5, 'quiz', 'quiz matemik', 30, 1, 1, '2025-08-28 12:44:23');

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
(1, 1, '1+1=', 'pilihan', '1', '3', '2', '4', 'a', 1),
(2, 1, '1+1=', 'pilihan', '1', '3', '2', '4', 'a', 1),
(3, 1, '1+1=', 'pilihan', '1', '3', '2', '4', 'a', 1),
(4, 1, '1+1=', 'pilihan', '1', '4', '23', '5', 'a', 1),
(5, 1, '1+1=', 'pilihan', '423424', '2423', '23424', '1', 'd', 1),
(6, 2, 'Tujuan utama dari administrasi perkantoran adalah …', 'pilihan', 'Mengatur keuangan perusahaan', 'Mengelola proses pencatatan, surat-menyurat, dan arsip', 'Menentukan strategi pemasaran', 'Membuat laporan pajak', 'b', 1),
(7, 2, 'Arsip yang digunakan secara langsung dan sering disebut adalah …', 'pilihan', 'Arsip aktif', 'Arsip inaktif', 'Arsip vital', 'Arsip statis', 'a', 2),
(8, 2, 'Peralatan yang digunakan untuk menyimpan arsip berbentuk lembaran adalah …', 'pilihan', 'Filling cabinet', 'Dispenser', 'Whiteboard', 'Scanner', 'a', 1),
(9, 2, 'Surat dinas yang ditujukan kepada instansi lain disebut …', 'pilihan', 'Surat pribadi', 'Surat keluar', 'Surat masuk', 'Memo', 'b', 3),
(11, 2, 'Salah satu fungsi administrasi adalah …', 'pilihan', 'Menyusun anggaran negara', 'Menyimpan data agar mudah dicari kembali', 'Membuat kurikulum sekolah', 'Menetapkan hukum nasional', 'b', 3),
(12, 3, 'test', 'pilihan', 'test', 'test', 'test', 'test', 'c', 1),
(13, 3, 'test1', 'pilihan', 'test', 'test', 'test', 'test', 'a', 1);

-- --------------------------------------------------------

--
-- Table structure for table `quiz_siswa`
--

CREATE TABLE `quiz_siswa` (
  `id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `siswa_id` varchar(20) CHARACTER SET latin1 NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime DEFAULT NULL,
  `status` enum('ongoing','completed') NOT NULL DEFAULT 'ongoing',
  `score` decimal(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `quiz_siswa`
--

INSERT INTO `quiz_siswa` (`id`, `quiz_id`, `siswa_id`, `start_time`, `end_time`, `status`, `score`) VALUES
(1, 1, '12345678', '2025-08-22 14:50:42', '2025-08-22 14:50:49', 'completed', '80.00'),
(2, 2, '1234567899', '2025-08-24 06:37:25', '2025-08-24 06:38:27', 'completed', '60.00'),
(4, 2, '12345678999', '2025-08-29 13:54:55', '2025-08-29 13:55:57', 'completed', '70.00');

-- --------------------------------------------------------

--
-- Table structure for table `rps`
--

CREATE TABLE `rps` (
  `id_rps` int(11) NOT NULL,
  `guru_mapel_id` int(11) NOT NULL,
  `kelas_id` int(11) NOT NULL,
  `file_rps` varchar(255) NOT NULL,
  `semester` varchar(20) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `rps`
--

INSERT INTO `rps` (`id_rps`, `guru_mapel_id`, `kelas_id`, `file_rps`, `semester`, `created_at`, `updated_at`) VALUES
(11, 26, 1, 'RPS_21101140_26_1_1756454682.pdf', '2025 genap', '2025-08-29 10:04:42', '2025-08-29 15:04:42');

-- --------------------------------------------------------

--
-- Table structure for table `siswa`
--

CREATE TABLE `siswa` (
  `nis` varchar(20) NOT NULL,
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
('0014946300', 'AHMAD RAMADHAN', '$2y$10$lrkbhz0oxUZsD/S9LhQWAun47w8b//qqDUgRUuYgxF2QXjbSyMV.G', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-01', 3, 'siswa'),
('0028290024', 'Gysen Wangsa', '$2y$10$03c2Ogjd.pjcUkgcUPZDlO2LyOWVQ9zRa.tfMlcYyz06Np57eG.KW', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-01', 3, 'siswa'),
('0031344056', 'Muhamad Safeih', '$2y$10$6XqssnCTCCVLN8AYQG87BO92Vx7fRam42xgrpCWHdo5vKusLzYsT2', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-01', 3, 'siswa'),
('0039378456', 'Rimpi', '$2y$10$9Ge/nrPtX.iYnzVbdkCA5.MWnpujPwyLROrg.jbOBOkoGs3Bk64He', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-01', 3, 'siswa'),
('0042184528', 'Michael Agustian', '$2y$10$vvsuScGTv04RIjycS34m1u7z4zfig3Y02940.7Vg.RZhghPeXKwP2', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-01', 3, 'siswa'),
('0044795891', 'PUTRI SYAKILLAH ANASTASYAH', '$2y$10$fOQNokYNdDzBzOp9c0Hy2uLwmEJJMw4c8N35qdjo7r3imLpb8DX5q', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-01', 3, 'siswa'),
('0044875032', 'Firda Atikah Putri', '$2y$10$8tX.zyAX4vA1oTpUQKo9XOF0BIJmyycS5Oio.RyTSAd175ZaocRvm', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-01', 3, 'siswa'),
('0045351054', 'ADJIE ADITYA NUGRAHA', '$2y$10$y/bU.feIGomGb2okY3/eeudSIMbHIpLq0mgz/qLu0fJtzmPheeET6', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-01', 3, 'siswa'),
('0045683849', 'Adelia Dian Megareta', '$2y$10$RXVshgafC5d8ZAjENvKlU.nE9sbCvjB4kefE9ICpF.rKUKlZ7g9Yi', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-01', 3, 'siswa'),
('0046215859', 'PUTRA MARHAEN', '$2y$10$oynlAvxI9Rar3oGgBBiQtePasae9PEWQ/zZoW0L0F4e3gX544wJfq', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-01', 3, 'siswa'),
('0051192742', 'ANGGA ERLANGGA PUTRA', '$2y$10$i2TqPGqNJYyEZMH3YnJ12umNLZi1MoM9fjJznGeMT.bE/QS6N1DPO', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-01', 3, 'siswa'),
('0052818825', 'Muhammad Rogib', '$2y$10$EmjEUih17YDHeBq5fqx7sOOqR8rhIRByPuum3/b6Y5h6ph1KfDWbG', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-01', 3, 'siswa'),
('0058595046', 'Muhamad Rizky Andrean', '$2y$10$kYwH5JcY6y4O2mmwuxZeSer5gkPjYWo45N73Vx6fPZw7RlxW.6Fiu', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-01', 3, 'siswa'),
('0062303354', 'Lydia Listiawan', '$2y$10$qbK1xUNHRObdA74KQCsc8.BHevH/3FL3NGk/aGZsBmQGwMLiUgr8u', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-01', 3, 'siswa'),
('0063301626', 'Muhammad Adi Saputra', '$2y$10$8K1RXvtI79zQot575Hp5bONzcMtRPQmCXNqbzvc2rtYtlT6sOed9y', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-01', 2, 'siswa'),
('0064797771', 'MUHAMMAD DIKI MIFTACHHUDIN', '$2y$10$h/QnJMR3zsSyB9qjPch9TuItiVAmbE9E1cE/zGGrbQI52NmnCkDp6', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-01', 3, 'siswa'),
('0065165563', 'Vazia Zulia vasha', '$2y$10$uhpWfnpV0XQzc9MfL8mwmuSvIyYUimTY.6sPXE1QzWQhNfCzYcAJS', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-01', 3, 'siswa'),
('0066988913', 'Bunga Nur Aulia', '$2y$10$8mhG9bLPB.lNqu50k.rYcOd5kHbJJo9NklCd.R18t7UatIIfAnikq', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-01', 3, 'siswa'),
('0073601675', 'Rizky Agusti', '$2y$10$v4ikO7fT/BIALCGRnB17mePajvlb4WQZVu79VpGT0jZT3qQ0kDWv2', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-01', 2, 'siswa'),
('0073767204', 'RHEVA DESFARINI', '$2y$10$FzD/LN/gAltJK1IikEMBsuHw496HH06U9JPocsB.qObeytye4ZskK', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-01', 3, 'siswa'),
('0077490337', 'GADIS GITA LAUREN', '$2y$10$eiatmRJNktL.A7DVqsSAtOYM8/rGVD/P4j7XXpeCh3fLYDHEJobE6', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-01', 3, 'siswa'),
('0079552543', 'VICKY DWI VERNANDA', '$2y$10$Oz92XviFvhN3hW8DMBqZke/KYRJ6Un1e/9oadwO1cRsOeRWF75Sve', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-01', 3, 'siswa'),
('0079655473', 'M.TRISTAN RIVALDY', '$2y$10$CnCNbYen8uWstCAyri44t.QvS9XJThS78/fhUWZgvha.ojcwNYL52', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-01', 3, 'siswa'),
('0079948350', 'NURJELANI', '$2y$10$kg8cWSiD8b2Y/5jk6fo08upSaKw5RmuEIFPkO.UrQelzlkcDXh4Pi', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-01', 3, 'siswa'),
('0082779275', 'Putri aurelia', '$2y$10$WQ2F1ijuoiV9PBBUTQnWxeeePjuNOHohuxDtt1ralRZIZIPc61jxa', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-01', 3, 'siswa'),
('0084276194', 'ALDI SUPARDI', '$2y$10$m6OCY62exhF2eYVwUBuriO8ZwzpbNL2WfWHlU1kVgd/btAUs/YvNG', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-01', 3, 'siswa'),
('0084617145', 'Washfi Faraz Kamilah', '$2y$10$oZmq5.pIPAjghKncGJ5tFeyI3XMec13Y09Uj7xFsLJ51Mq5LPHOEW', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-01', 2, 'siswa'),
('0084764574', 'Eva', '$2y$10$oLtnnomtpUsDvAGcMa3q2.Ej4ZK.aZYfpbuWw0iwh7dH3SoNez8jC', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-01', 2, 'siswa'),
('0086207880', 'DIMAS YOGA RAMADHAN', '$2y$10$kG4YxdHxRh7ulUo5/Jt63.8qnC6MnI535njMDlqGZVKxTnrIhhPK.', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-01', 2, 'siswa'),
('0086769753', 'SHEILA NATASYA', '$2y$10$XT0oeorIYMln56qANv8fvegC4Xe1p8Q7oPSNt7CU0DjrCoJBMuUp.', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-01', 3, 'siswa'),
('0087211088', 'AZKIYATU ZAHRA', '$2y$10$DhAwTVBOAWcsjy7Bp.ddpuSlBSYzb3uR2Mi7Jk.Acxo0yT4W/NIJa', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-01', 2, 'siswa'),
('0087217408', 'Zavio Rizki Saputra', '$2y$10$wjDTyFMBm0h5ZHQqrwNdlegqcv3Qkj0PeMTkVZoHbZ9gDgYpccmmS', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-01', 3, 'siswa'),
('0087337628', 'KHAERUN NURI', '$2y$10$1vQhC21F9kWra2pIO52OauVhC4eHD1cYF0q5VW.3V.AnjGPYfNTwG', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-01', 2, 'siswa'),
('0089969128', 'AHMAD SYAHRONI', '$2y$10$KD2fMerNSSCjQSDXc.YAf.K5zY.UwfG5knDQG9WMstP/VLmq0rOUK', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-01', 3, 'siswa'),
('0091031828', 'MEIDY MAQFIRAH', '$2y$10$XBMzkmoTwqLkHQPavrpyDe6VPqpH9f7qm/evM8FTI5R/HTUstmUVK', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-01', 2, 'siswa'),
('0092516158', 'Kholilurohman', '$2y$10$.9qDcB..QGOtC.nNyO/19eZUlX6fMVyzxpN9buGSrc5XIkHGprRnq', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-01', 2, 'siswa'),
('0093590373', 'TAZKIYAH NURMALA', '$2y$10$R27lTpfImsKZ4MdByz0Vy.H4ytPUGb4hpAwvN3pDWf/GwXdEs6oP.', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-01', 3, 'siswa'),
('0093801678', 'Arif Rahman Tiar', '$2y$10$MtM0hk4FFg4KM5sLjN6ykOQXAcMVJVzSMzGJnQqe6RD3accnUZknu', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-01', 3, 'siswa'),
('0094063500', 'SONGO ABABIL', '$2y$10$MGoKqRbVrR0AXY8U6JIvluFNWCkJITjdVwiaOs5EO9.gbOdRJW7aC', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-01', 2, 'siswa'),
('0095416290', 'FAHMI RIDHO', '$2y$10$cFBG1XgWLEecbbCzk7nwGOXvLAITPWkgoPNl8yllUASBNsPTsmbUy', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-01', 1, 'siswa'),
('0095454453', 'MUHAMAD FIRMANSYAH', '$2y$10$01UKK.cQszZTi9w9ecm5Nu/1NSgJkRM/rH0claDl21nraZeux60ta', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-01', 3, 'siswa'),
('0096317085', 'RAISYA RAMADHANI', '$2y$10$K3xdFdUPg1PPt7HK7i5w8u9dXI/u2DZ/f5EXGulyak1S3ZgBms/By', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-01', 3, 'siswa'),
('0096325350', 'Muhammad Raihan', '$2y$10$ZfeDlT7alkpGwICxKIUbzejxISI9SdMlAzLXrGDQW6bUaWHraa9BG', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-01', 2, 'siswa'),
('0098026915', 'SYAHRUL AL HAJJ DZULFIKAR', '$2y$10$2EzognR4ir8QWRGdzbl2qu7.zteT3PtZSEr5J94/QM72uwd7TJyRe', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-01', 2, 'siswa'),
('0099268185', 'AHMAD FIRAS BAHIRA', '$2y$10$0Wp076hnYzAtwgLRwNAyJuSlkQ3U3QasyVuKsH2jWlMysptaqS6UK', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-01', 3, 'siswa'),
('0101839911', 'Sri Wahyuni', '$2y$10$vVtHOKtOe5fRZw1cTT7OUOXD6mPDAqdf0tGfO1nGzHsZJVhTw7CKG', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-01', 2, 'siswa'),
('0103361826', 'Noviyanti', '$2y$10$94ra5McZAsHGHWdzCGr/huGm/tHaI2P9lfXwHQ.BV9P80Sc6MH2He', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-01', 2, 'siswa'),
('0104991736', 'MUHAMAD AUZAI', '$2y$10$T1nQr/K253yTuUCX6lGJxOTPjF80/EDUW5oIo0Xir0n1rxvqLLObi', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-01', 2, 'siswa'),
('0105778035', 'SAIDA', '$2y$10$BqCIEkKARJ0urmZPqMacI.URaB69hwGjRYBymUWHcIsQfhTYA2bBi', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-01', 2, 'siswa'),
('0107037461', 'Alvian Yusuf Handoko', '$2y$10$Hb1b6o2jfUgTxqNGtWVdyOIxocIyAU1i6uuxQeoRcsJfx5VMT7kxO', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-01', 2, 'siswa'),
('0128301889', 'MUHAMMAD DWI ANDRE ARAFAH', '$2y$10$SoyvO/bSlcn6qQj2gLvncel7ggiLECuiyh2ypHMZazFW88ciu/Rfa', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-01', 1, 'siswa'),
('12345678', 'Max Verstapen', '$2y$10$/Eh6H/5Hf8iA1VDqVdHUW.WcoVxzMb2BDbtIBtvDBnHawZ4l4Nu6a', 'maxverstapen123@gmail.com', 'default.jpg', 1, '2025-08-17', 1, 'siswa'),
('123456789', 'Future', '$2y$10$9NEj6LYVp9wOQBz8QK8YS.rWYbSGUFXzX3wvJ1YUx16ocBKbwMglu', 'tesswswt@gmail.com', 'default.jpg', 1, '2025-08-24', 1, 'siswa'),
('1234567899', 'John Doe', '$2y$10$nWSiM/QQvZQn45WJ5iFAqu8cVQAX5An2MAvYUKNCEFRucxbo/caI2', 'lorem@example.com', 'default.jpg', 1, '2025-08-17', 1, 'siswa'),
('12345678999', 'Lionel Messis', '$2y$10$lP4uN/pwesy7qZf5OewCfeD0eBsC1v2ThQt57gU8nxcZkPEbB0d1u', 'loremas@example.com', 'default.jpg', 1, '2025-08-28', 1, 'siswa'),
('2021383151', 'Fina Wardawiyah', '$2y$10$yxcqV7A4Ij4lVpoPiFvwTuekv5/M.rzbfZJQI1gaGbztKsy27lUlS', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-01', 3, 'siswa'),
('2052804732', 'Ibra Wimarta', '$2y$10$lvfH5Ja0VqUtTtcNu69CXuJENtgaY5xuyv51DaBm90KEoSWxtP6ha', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-01', 3, 'siswa'),
('2061010927', 'Sinta', '$2y$10$o/j.yiVic0MiEEH.GtIetO46rTYiSTGJQUBql4Mx2PdRNJajGMIRe', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-01', 3, 'siswa'),
('2065234615', 'Khairunnisa', '$2y$10$AA3cuqhftxR7bH532zliB.4VC6LZELsKXMtGKOjANEkTblxsWk0Rq', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-01', 3, 'siswa'),
('2078814025', 'Maulana Indra Prama', '$2y$10$3A2nywhcVsAUVsGiIvlUiuaTrdtepKSo8wuSu891/9cMsmazeO5Ny', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-01', 3, 'siswa'),
('2082533938', 'Noval Adrian Wijaya', '$2y$10$S20Ol0Xg053tZk57pE6T4OgC/789J6SCeRwKNK9cA9Zyx8hI9lzLi', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-01', 3, 'siswa'),
('2098350667', 'Fitri', '$2y$10$gdZxMR.XAUeegQcX2VhX9uK.NoKsedBfQVgZNd346uL2Wdpr6D35K', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-01', 3, 'siswa'),
('3016839237', 'Siti Inayah Haq', '$2y$10$RGqQfddF9YLklemd6Z2wOeo9q3Q.Gf8coDMCQusNL6RMZAILaVs/W', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-01', 2, 'siswa'),
('3044755103', 'Ahmad Khorib', '$2y$10$5SQn5ehFilubXIJuvxo91ezIweHYN9ACubgjQDkjsv3YHaBnIzqz2', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-01', 2, 'siswa'),
('3045646933', 'Usli Imam Safei', '$2y$10$DrHHuY5XB8TM44G4lTXMJu0/dnXSLbqZroxI9DB7XkROCWkb4RIiq', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-01', 3, 'siswa'),
('3061461498', 'MUHAMMAD SAYYID FATUR ROHMAN', '$2y$10$1.bMfAtrY8w3ym4II8IBAuep9xvBVs64l1HQo.n9AAmroxEzW559a', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-01', 3, 'siswa'),
('3063319075', 'Muhammad Maulana Ilyas', '$2y$10$f.7kRD80CbUQYXj5HwSl4Ooj7iaoQ1o4E2975RvhQIkvHPVo6SgsS', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-01', 3, 'siswa'),
('3068576912', 'Aida', '$2y$10$Ybh0Qsc5nPYm0imC8a1/aeT1s4one0eX9Gc4L/zXaB7UBPYCAoYs6', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-01', 2, 'siswa'),
('3072235768', 'Muhammad Taju Syarop Fauzi', '$2y$10$VYNkM2xOfljoopfK8U5T/.kMnrw5jQB6PlPnVwHLIflNT.MLzvBpm', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-01', 3, 'siswa'),
('3073203066', 'Muhammad Rynaldi', '$2y$10$0qB2qMboDJyejbpGDqH4WuS.p8FQbyHA/UbJaCLMNFpbzbrj2J9Ve', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-01', 2, 'siswa'),
('3080556625', 'HAPIZ YUSRI', '$2y$10$5VB2VlHUvGrrCumBVnN4LeLByJz4oHO5yoYhrtiaVNHxfkO4dxnwa', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-01', 3, 'siswa'),
('3091558263', 'Muhammad Husni Makki Sonhaji', '$2y$10$ZtZoSYWLIIR3eRdR4G1FIutY97FhxlqF3gaSecQB4lQquAi9KwYPW', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-01', 2, 'siswa'),
('3107966544', 'Najwa Putri Awaliyah', '$2y$10$GU2b7kMCB/IqgkhG4JRHIu/g5ZE7M2p7lxgdkMttKvXO/5KHqRMtW', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-01', 3, 'siswa'),
('3124368879', 'RIZKI FAUZI', '$2y$10$BESosJi.b8Wd9pt5lEolJ.9jBvxMM.mKbFhRgv8JqC7vn5tb8ONTW', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-01', 2, 'siswa'),
('3128153661', 'MUHAMMAD SYAFIQ ZAKY ISKANDAR', '$2y$10$6s/PehvFniS8PnCXzxD3V.Jgb2Ixzzpu8C3FFUW1rH7/MWsQ9FniG', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-01', 2, 'siswa'),
('3146882349', 'Laila Khanza Az Zahra', '$2y$10$qD9CH/atCzNDUMHCGufktuOcVrlDcriubZqCY5GCBESpsG76jB8Yi', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-01', 1, 'siswa'),
('3745065752', 'KARTONO', '$2y$10$xZtKC4dCkI07dd1YYVBKUummtWP9FPUFivhtui6kxKrmHJyPK5thy', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-01', 2, 'siswa'),
('3749766539', 'ZAINUDIN', '$2y$10$k7Llad7i8zkOSAtoE6aXW.gJntEu.BEQEUJ4/ww1Gf35miYNtEAFa', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-01', 3, 'siswa'),
('3762315024', 'Nurlaela', '$2y$10$6ZJ3duyRnyjueNsmDUkPxem22rBxVnVWGPp6uqSiBE//ZMDcEO3xW', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-01', 3, 'siswa'),
('3839354749', 'SYAIPUDIN', '$2y$10$lAG1lPxELOCuIsGHDuU4zeh98FYw8w8zJspnRpbgZVj4mdC8PlFJq', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-01', 2, 'siswa'),
('3898374246', 'Apiyah', '$2y$10$UikFYs2w9rO2dtzM0XulNu1O4yu79JkJOxU37TNF6RwKl/zBOoKCi', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-01', 2, 'siswa'),
('3957922406', 'Dwi Bayu Pribadi', '$2y$10$jV9uJ0k3iVsiYXzHUloCougVTGf59ZtV7DRgT12dQKvw8RPNuOB6G', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-01', 2, 'siswa'),
('3994681926', 'Khumaeratur Rodhiyah', '$2y$10$FBico9ArDuD9JA7ZwLWPb.9e.7AuHbAPoSkkWR6Uz56GuhjOLFRse', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-01', 3, 'siswa'),
('9779152739', 'Jamsuri', '$2y$10$HjCmLGWbRUQ3mSeM2fcm7.hCxSAM83bh76s74s1C/O/QLTQsYO20S', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-01', 3, 'siswa'),
('9804913006', 'Mukri', '$2y$10$yhZWr2fAidPm1jCEMVHX5uOmhoxlj3MEetZ5DRpu2NN/beLvQJP2q', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-01', 3, 'siswa'),
('9996776172', 'Wiji Sanuri', '$2y$10$j/rWcoOALkIBkg5tVs.Esu3Wg4mrwxXvAHULT4Vcj2i/pmi9CksGq', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-01', 3, 'siswa');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_jawaban_siswa`
--

CREATE TABLE `tbl_jawaban_siswa` (
  `id_jawaban` int(11) NOT NULL,
  `nis` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
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
(25, '1234567899', 6, NULL, NULL, NULL, NULL, 0, 1, 3, 1, 52.5, NULL, '2025-08-24 07:51:39', '2025-08-24 09:51:39', '2025-08-24 09:52:21', 'bank_soal', NULL, NULL, 82.5),
(26, '1234567899', 6, NULL, NULL, NULL, NULL, 0, 1, 3, 1, 52.5, NULL, '2025-08-24 07:51:39', '2025-08-24 09:51:39', '2025-08-24 09:52:21', 'bank_soal', NULL, NULL, 82.5),
(27, '1234567899', 6, NULL, NULL, NULL, NULL, 0, 1, 3, 1, 52.5, NULL, '2025-08-24 07:51:39', '2025-08-24 09:51:39', '2025-08-24 09:52:21', 'tbl_soal', NULL, NULL, 82.5),
(28, '1234567899', 6, NULL, NULL, NULL, NULL, 0, 1, 3, 1, 52.5, NULL, '2025-08-24 07:51:39', '2025-08-24 09:51:39', '2025-08-24 09:52:21', 'tbl_soal', NULL, NULL, 82.5),
(29, '1234567899', 6, NULL, NULL, NULL, NULL, 0, 1, 3, 1, 52.5, NULL, '2025-08-24 07:51:39', '2025-08-24 09:51:39', '2025-08-24 09:52:21', 'tbl_soal', NULL, NULL, 82.5),
(30, '1234567899', 6, NULL, 5, 'D', NULL, 0, 1, 3, 1, 52.5, NULL, '2025-08-24 02:52:11', NULL, '2025-08-24 09:52:21', 'bank_soal', NULL, NULL, 82.5),
(31, '1234567899', 6, NULL, 4, NULL, '11321\n', 0, 1, 3, 1, 52.5, NULL, '2025-08-24 02:52:16', NULL, '2025-08-24 09:52:21', 'bank_soal', 100, '', 82.5),
(32, '1234567899', 6, 6, NULL, 'B', NULL, 0, 1, 3, 1, 52.5, NULL, '2025-08-24 02:51:57', NULL, '2025-08-24 09:52:21', 'tbl_soal', NULL, NULL, 82.5),
(33, '1234567899', 6, 7, NULL, 'B', NULL, 0, 1, 3, 1, 52.5, NULL, '2025-08-24 02:52:01', NULL, '2025-08-24 09:52:21', 'tbl_soal', NULL, NULL, 82.5),
(34, '1234567899', 6, 8, NULL, 'A', NULL, 0, 1, 3, 1, 52.5, NULL, '2025-08-24 02:52:03', NULL, '2025-08-24 09:52:21', 'tbl_soal', NULL, NULL, 82.5),
(35, '123456789', 6, NULL, NULL, NULL, NULL, 0, 1, 4, 0, 70, NULL, '2025-08-24 07:59:00', '2025-08-24 09:59:00', '2025-08-24 09:59:22', 'bank_soal', NULL, NULL, 100),
(36, '123456789', 6, NULL, NULL, NULL, NULL, 0, 1, 4, 0, 70, NULL, '2025-08-24 07:59:00', '2025-08-24 09:59:00', '2025-08-24 09:59:22', 'bank_soal', NULL, NULL, 100),
(37, '123456789', 6, NULL, NULL, NULL, NULL, 0, 1, 4, 0, 70, NULL, '2025-08-24 07:59:00', '2025-08-24 09:59:00', '2025-08-24 09:59:22', 'tbl_soal', NULL, NULL, 100),
(38, '123456789', 6, NULL, NULL, NULL, NULL, 0, 1, 4, 0, 70, NULL, '2025-08-24 07:59:00', '2025-08-24 09:59:00', '2025-08-24 09:59:22', 'tbl_soal', NULL, NULL, 100),
(39, '123456789', 6, NULL, NULL, NULL, NULL, 0, 1, 4, 0, 70, NULL, '2025-08-24 07:59:00', '2025-08-24 09:59:00', '2025-08-24 09:59:22', 'tbl_soal', NULL, NULL, 100),
(40, '123456789', 6, NULL, 5, 'A', NULL, 0, 1, 4, 0, 70, NULL, '2025-08-24 02:59:01', NULL, '2025-08-24 09:59:22', 'bank_soal', NULL, NULL, 100),
(41, '123456789', 6, NULL, 4, NULL, 'ffefef\n89p8p8', 0, 1, 4, 0, 70, NULL, '2025-08-24 02:59:20', NULL, '2025-08-24 09:59:22', 'bank_soal', 100, '', 100),
(42, '123456789', 6, 6, NULL, 'B', NULL, 0, 1, 4, 0, 70, NULL, '2025-08-24 02:59:10', NULL, '2025-08-24 09:59:22', 'tbl_soal', NULL, NULL, 100),
(43, '123456789', 6, 7, NULL, 'B', NULL, 0, 1, 4, 0, 70, NULL, '2025-08-24 02:59:12', NULL, '2025-08-24 09:59:22', 'tbl_soal', NULL, NULL, 100),
(44, '123456789', 6, 8, NULL, 'A', NULL, 0, 1, 4, 0, 70, NULL, '2025-08-24 02:59:15', NULL, '2025-08-24 09:59:22', 'tbl_soal', NULL, NULL, 100),
(45, '12345678999', 6, NULL, NULL, NULL, NULL, 0, 1, 1, 3, 17.5, NULL, '2025-08-29 12:36:29', '2025-08-29 14:36:29', '2025-08-29 14:40:03', 'bank_soal', NULL, NULL, 47.5),
(46, '12345678999', 6, NULL, NULL, NULL, NULL, 0, 1, 1, 3, 17.5, NULL, '2025-08-29 12:36:29', '2025-08-29 14:36:29', '2025-08-29 14:40:03', 'bank_soal', NULL, NULL, 47.5),
(47, '12345678999', 6, NULL, NULL, NULL, NULL, 0, 1, 1, 3, 17.5, NULL, '2025-08-29 12:36:29', '2025-08-29 14:36:29', '2025-08-29 14:40:03', 'tbl_soal', NULL, NULL, 47.5),
(48, '12345678999', 6, NULL, NULL, NULL, NULL, 0, 1, 1, 3, 17.5, NULL, '2025-08-29 12:36:29', '2025-08-29 14:36:29', '2025-08-29 14:40:03', 'tbl_soal', NULL, NULL, 47.5),
(49, '12345678999', 6, NULL, NULL, NULL, NULL, 0, 1, 1, 3, 17.5, NULL, '2025-08-29 12:36:29', '2025-08-29 14:36:29', '2025-08-29 14:40:03', 'tbl_soal', NULL, NULL, 47.5),
(50, '12345678999', 6, NULL, 4, NULL, 'karena baik', 0, 1, 1, 3, 17.5, NULL, '2025-08-29 07:37:24', NULL, '2025-08-29 14:40:03', 'bank_soal', 100, '', 47.5),
(51, '12345678999', 6, NULL, 5, 'C', NULL, 0, 1, 1, 3, 17.5, NULL, '2025-08-29 07:38:22', NULL, '2025-08-29 14:40:03', 'bank_soal', NULL, NULL, 47.5),
(52, '12345678999', 6, 6, NULL, 'A', NULL, 0, 1, 1, 3, 17.5, NULL, '2025-08-29 07:38:08', NULL, '2025-08-29 14:40:03', 'tbl_soal', NULL, NULL, 47.5),
(53, '12345678999', 6, 7, NULL, 'A', NULL, 0, 1, 1, 3, 17.5, NULL, '2025-08-29 07:38:45', NULL, '2025-08-29 14:40:03', 'tbl_soal', NULL, NULL, 47.5),
(54, '12345678999', 6, 8, NULL, 'A', NULL, 0, 1, 1, 3, 17.5, NULL, '2025-08-29 07:38:50', NULL, '2025-08-29 14:40:03', 'tbl_soal', NULL, NULL, 47.5);

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
(6, 6, 'Tujuan utama dari administrasi perkantoran adalah …', 'Mengatur keuangan perusahaan', 'Mengelola proses pencatatan, surat-menyurat, dan arsip', 'Menentukan strategi pemasaran', 'Membuat laporan pajak', 'B', 'pilihan'),
(7, 6, 'siapa pembuat aplikasi ini?', 'addist', 'addust', 'bahlil', 'reymond', 'B', 'pilihan'),
(8, 6, 'test soal', 'a', 'b', 'c', 'd', 'A', 'pilihan');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_ujian`
--

CREATE TABLE `tbl_ujian` (
  `id_ujian` int(11) NOT NULL,
  `nip_guru` varchar(20) CHARACTER SET latin1 NOT NULL,
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
(5, '21101140', 'Harian 1', '2025-08-01', '2025-08-08', 20, 'aktif', 1, 'manual', 70, 30),
(6, '21101140', 'Harian 2', '2025-08-24', '2025-08-31', 20, 'aktif', 4, 'manual', 70, 30),
(8, '21101140', 'Harian 3', '2025-09-01', '2025-09-30', 20, 'aktif', 4, 'manual', 70, 30);

-- --------------------------------------------------------

--
-- Table structure for table `tugas_siswa`
--

CREATE TABLE `tugas_siswa` (
  `id` int(11) NOT NULL,
  `siswa_id` varchar(20) CHARACTER SET latin1 NOT NULL,
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
(1, '12345678', 1, 'assets/materi_tugas/648093bfef7c7af7bf9697b4ff12b0a9.png', 'logo (PNG)', 'image/png', 29, 'Good', '100.00', '2025-08-22 14:57:00', '2025-08-29 10:33:03');

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
(15, 5, NULL, 5, 'bank_soal'),
(16, 5, NULL, 4, 'bank_soal'),
(17, 6, NULL, 5, 'bank_soal'),
(18, 6, NULL, 4, 'bank_soal'),
(19, 6, 6, NULL, 'tbl_soal'),
(20, 6, 7, NULL, 'tbl_soal'),
(21, 6, 8, NULL, 'tbl_soal'),
(24, 8, NULL, 5, 'bank_soal'),
(25, 8, NULL, 4, 'bank_soal');

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
-- Indexes for table `rps`
--
ALTER TABLE `rps`
  ADD PRIMARY KEY (`id_rps`),
  ADD KEY `fk_rps_guru_mapel` (`guru_mapel_id`),
  ADD KEY `fk_rps_kelas` (`kelas_id`);

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
  MODIFY `id_soal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `forum_diskusi`
--
ALTER TABLE `forum_diskusi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `guru_mapel`
--
ALTER TABLE `guru_mapel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `jawaban_siswa`
--
ALTER TABLE `jawaban_siswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `mata_pelajaran`
--
ALTER TABLE `mata_pelajaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `materi`
--
ALTER TABLE `materi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `pertemuan`
--
ALTER TABLE `pertemuan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `quiz`
--
ALTER TABLE `quiz`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `quiz_questions`
--
ALTER TABLE `quiz_questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `quiz_siswa`
--
ALTER TABLE `quiz_siswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `rps`
--
ALTER TABLE `rps`
  MODIFY `id_rps` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tbl_jawaban_siswa`
--
ALTER TABLE `tbl_jawaban_siswa`
  MODIFY `id_jawaban` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `tbl_soal`
--
ALTER TABLE `tbl_soal`
  MODIFY `id_soal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tbl_ujian`
--
ALTER TABLE `tbl_ujian`
  MODIFY `id_ujian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tugas_siswa`
--
ALTER TABLE `tugas_siswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `ujian_soal`
--
ALTER TABLE `ujian_soal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

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
  ADD CONSTRAINT `guru_mapel_ibfk_1` FOREIGN KEY (`id_guru`) REFERENCES `guru` (`nip`) ON DELETE CASCADE ON UPDATE CASCADE,
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
  ADD CONSTRAINT `fk_materi_guru` FOREIGN KEY (`id_guru`) REFERENCES `guru` (`nip`) ON DELETE CASCADE ON UPDATE CASCADE,
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
  ADD CONSTRAINT `quiz_siswa_ibfk_2` FOREIGN KEY (`siswa_id`) REFERENCES `siswa` (`nis`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `rps`
--
ALTER TABLE `rps`
  ADD CONSTRAINT `fk_rps_guru_mapel` FOREIGN KEY (`guru_mapel_id`) REFERENCES `guru_mapel` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_rps_kelas` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
  ADD CONSTRAINT `tbl_jawaban_siswa_ibfk_1` FOREIGN KEY (`nis`) REFERENCES `siswa` (`nis`) ON DELETE CASCADE ON UPDATE CASCADE,
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
  ADD CONSTRAINT `fk_ujian_guru` FOREIGN KEY (`nip_guru`) REFERENCES `guru` (`nip`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_ujian_pertemuan` FOREIGN KEY (`id_pertemuan`) REFERENCES `pertemuan` (`id`);

--
-- Constraints for table `tugas_siswa`
--
ALTER TABLE `tugas_siswa`
  ADD CONSTRAINT `fk_tugas_pertemuan` FOREIGN KEY (`id_pertemuan`) REFERENCES `pertemuan` (`id`),
  ADD CONSTRAINT `fk_tugas_siswa` FOREIGN KEY (`siswa_id`) REFERENCES `siswa` (`nis`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ujian_soal`
--
ALTER TABLE `ujian_soal`
  ADD CONSTRAINT `fk_ujian_soal` FOREIGN KEY (`bank_soal_id`) REFERENCES `bank_soal` (`id_soal`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
