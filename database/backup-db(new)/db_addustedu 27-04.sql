-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 27, 2025 at 11:27 AM
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
  `email` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `email`) VALUES
(0, 'admin', '$2y$10$EX0L5MeIQldpkCuTZW.mjujTaj.Yy20IW0GOluecU/c.es.9r6E5.', 'admin@gmail.com');

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
  `nama_mapel` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `guru`
--

INSERT INTO `guru` (`nip`, `email`, `nama_guru`, `password`, `nama_mapel`) VALUES
(21101140, 'pahrulmaji@gmail.com', 'guru terbaikss', '$2y$10$5b/MJhDxwMBoOBZ0m4nofOCPrwn9XM/RZu7xuG528R7P71k629SUS', 'Matematika'),
(21101141, 'fahreziandika10@gmail.com', 'addust11', '$2y$10$nDOjyUB0msJL1E1FTC7PdeQTCR0ip441LfLFbHZk/g7f2EoQ2vOAO', 'Bahasa Inggris'),
(21101142, 'test@gmail.com', 'addust111', '$2y$10$SnRGlMYTwJSElDgt6DUza.qK/8tCzJQQfogjZxZxTMXkqMDgeBRU.', 'IPA'),
(21101143, 'test12@gmail.com', 'useraa', '$2y$10$nk3jFu4/ANCEkgrYFq4F6uYl2UZQHLGtdCAYLSQ6eEkfT9quBoDo.', 'Test'),
(214748364, 'Dummy@gmail.com', 'Ahmad Saugi', '$2y$10$nvcd.PCpCxStCPws.gAfluw192h3YOqXHTZIIp44yDp5RuHfYlg72', 'Pendidikan Agama Islam'),
(214748365, 'zaidanlineee67@gmail.com', 'Saauky', '$2y$10$3qQ2TYrtQHy44LblPMexnu4ZQrCWD.dYh20P.sOL5cyo6Z48fJQEq', 'Matematika'),
(1819107728, 'imas@gmail.com', 'Imas Kartika', '$2y$10$wCSBYTaCpSJaEX/1VUo1p.YU88vbgr7PeW.j1OkmD2xnKjIbB7SD6', 'Matematika');

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
  `kelas` varchar(5) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `siswa`
--

INSERT INTO `siswa` (`nis`, `nama`, `password`, `email`, `image`, `is_active`, `date_created`, `kelas`) VALUES
(0, 'addust', '$2y$10$cYm/i5rWupzWKrc92nX4EublfQgeyyZl4AQyu2e4rbKFQUwc8iv9u', 'addust@gmial.com', 'default.jpg', 1, 1742275981, ''),
(39, 'Syaauqi Zaaidan', '$2y$10$djI2M/FQH2k3H7b6tLK5X.MZG1R.wrARoR6NerH3tsScNnsNCnexa', 'zaidanline67@gmail.com', '73349393_156861225523800_2119508204152772215_n_(1)6.jpg', 1, 1586163321, 'X'),
(11323, 'bjbsjb1', '$2y$10$VOoalVJV9zYYueBRttR7DevfcHEhH2ilZFt0OBLsF17iGT5pMCSKO', 'nasigir1e@gmail.com', 'default.jpg', 1, 1744613912, ''),
(18883, 'addusttt', '$2y$10$bgLd2NGzEGiL8GDCN0KnaO6Rt3QrF8Ta0FZAzyWmYk8x5DIuOKx82', 'addust1@gmail.com', 'riyo1.jpg', 1, 1742454210, 'XI'),
(123456, 'user', '$2y$10$lG3qWm29AejdK/HV2iIwDOGzIAo3Q3MqlxVcODDQrj.hQvBYwWkdi', 'use1@gmail.com', 'default.jpg', 1, 1735200089, 'XI'),
(147852, 'dwdqwddq', '$2y$10$3T5Nmo7ZQIiF.h4e9Qqxo.oRzcYXGlceENvn9gObYM9lsXlsBlzDG', 'test12@gmail.com', 'default.jpg', 1, 1744168247, 'XII'),
(181816, 'qsqwdqwd', '$2y$10$YJppxwZ1JOt3s1/Xf9rgWewsjN8ZIhK1b.F39GcTmVS0uy5oOlhDK', 'testwd@gmail.com', 'default.jpg', 1, 1742296726, 'X'),
(211011, 'addust', '$2y$10$jxtWU6XSRAaV/kU0UqlUeurzzcp9EFVEuXJmwiGUrOSLjK9oSvjB6', '', 'default.jpg', 1, 1742276422, ''),
(232332, 'aasdadee qw', '$2y$10$luY1AxePrqda2kLL61Vu0.i/ZEtGLEvmamD3E4nrjBktQ4z1Va3V2', 'testwewe1@gmail.com', 'default.jpg', 1, 1742295476, ''),
(456123, 'wqdqdqw', '$2y$10$/Rx33H/8HvUpFcj3F4AM7eqlFnR17N38y7pt8pt0Ew3kRI3HwcNqi', 'nasigirewww@gmail.com', 'default.jpg', 1, 1744168582, 'XII'),
(456789, 'nasi gile', '$2y$10$LwYTyg0Usc1SNcQe50HY3.7ZWcRIy926dKlbLA8bZrWtgFMoTZMvq', '', 'default.jpg', 1, 1739114168, 'XII');

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
  `waktu_jawab` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_jawaban_siswa`
--

INSERT INTO `tbl_jawaban_siswa` (`id_jawaban`, `nis`, `id_ujian`, `id_soal`, `jawaban`, `ragu_ragu`, `waktu_jawab`) VALUES
(1, 123456, NULL, 1, 'a', 0, '2025-04-27 09:24:25'),
(2, 123456, NULL, 2, 'b', 1, '2025-04-27 09:24:25'),
(3, 123456, NULL, 3, 'b', 0, '2025-04-27 09:24:25'),
(4, 123456, NULL, 4, 'c', 0, '2025-04-27 09:24:25'),
(5, 123456, NULL, 5, 'd', 0, '2025-04-27 09:24:25');

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
(1, 4, 'dspvdvpsvn', 'cwdcw', 'qdwqdq', 'dqwqw', 'dqqwd', 'A'),
(2, 4, 'dqwdqw', 'a', 'a', 'a', 'a', 'A'),
(3, 4, 'r23r', 'dqwdw', 'qwdq', 'wdqqdwq', 'dqddq', 'A'),
(4, 4, 'dqqwd', 'dqdqw', 'qdqwd', 'qwdwd', 'ddqwwd', 'A'),
(5, 4, 'ddqwqwd', 'qdwwqdwq', 'dqwqwd', 'qdqwdqw', 'dqwqwdd', 'A');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_ujian`
--

CREATE TABLE `tbl_ujian` (
  `id_ujian` int(11) NOT NULL,
  `nama_ujian` varchar(100) DEFAULT NULL,
  `tanggal_mulai` date DEFAULT NULL,
  `tanggal_selesai` date DEFAULT NULL,
  `durasi` int(11) DEFAULT NULL,
  `status` enum('aktif','nonaktif') DEFAULT NULL,
  `id_materi` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_ujian`
--

INSERT INTO `tbl_ujian` (`id_ujian`, `nama_ujian`, `tanggal_mulai`, `tanggal_selesai`, `durasi`, `status`, `id_materi`) VALUES
(4, '11q', '2025-04-26', '2025-04-27', 100, 'aktif', 2),
(5, 'hahaha', '2025-04-27', '2025-04-27', 100, 'aktif', 6);

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

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for dumped tables
--

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
  MODIFY `id_jawaban` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_soal`
--
ALTER TABLE `tbl_soal`
  MODIFY `id_soal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_ujian`
--
ALTER TABLE `tbl_ujian`
  MODIFY `id_ujian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
