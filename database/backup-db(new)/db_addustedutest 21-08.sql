-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 21, 2025 at 10:51 AM
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
(1, '1 + 1 = ?', '1', '2', '3', '4', 'A', 'sulit', 'analisis', 1, 'admin', '2025-08-17 20:00:44', 'pilihan', 2),
(2, 'aljabar adalah?', NULL, NULL, NULL, NULL, NULL, 'sedang', 'paham', 21101140, 'guru', '2025-08-18 01:01:29', 'essay', 2),
(3, 'kenapa aljabar penting?', NULL, NULL, NULL, NULL, NULL, 'sulit', 'paham', 21101140, 'guru', '2025-08-18 01:01:50', 'essay', 2),
(4, 'kenapa administrasi penting?', NULL, NULL, NULL, NULL, NULL, 'sulit', 'paham', 21101140, 'guru', '2025-08-18 01:37:26', 'essay', 1),
(5, 'kenapa administrasi penting?', 'karena A', 'karena AC', 'karena AD', 'karena B', 'A', 'mudah', 'evaluasi', 21101140, 'guru', '2025-08-18 01:38:08', 'pilihan', 1);

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
(1, 'guru', '21101140', 1, NULL, 'Jangan lupa kerjakan quiznya Teman-teman', '2025-08-17 21:35:30', NULL, NULL);

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
(21101140, 'pahrulmaji@gmail.com', 'Guru Terbaik', '$2y$10$3p5IHxSz8vEkCVkO2N8Lw.vIiRdcRWmbVRS36m2GHORyNGwNYr0Eq', 'guru', 'default.jpg', NULL),
(21101141, 'test@gmail.com', 'addust', '$2y$10$sE4r22ml4cYo5H4Y1e4u3.nsWvpz69tatcNc56l4Iwq0RcSM3mwXy', 'guru', 'default.jpg', NULL);

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
(1, 21101140, 1),
(2, 21101140, 2),
(3, 21101141, 3),
(4, 21101141, 4);

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
(4, 'Ilmu Pengetahuan Sosial', 'lorems');

-- --------------------------------------------------------

--
-- Table structure for table `materi`
--

CREATE TABLE `materi` (
  `id` int(11) NOT NULL,
  `id_guru` int(11) NOT NULL,
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
(1, 21101140, 1, 1, 'https://www.youtube.com/embed/AlrOq3W7IZ4?rel=0', 'ascaca', ' cacsa', '563-Article_Text-2917-1-10-20220728.pdf'),
(2, 21101140, 2, 1, 'https://www.youtube.com/embed/QFLAuddS6qM?rel=0', 'FWFEWFEWF', 'FWEFWFWFWF', '918-1743-1-SM.pdf'),
(3, 21101140, 2, 1, 'https://www.youtube.com/embed/eQv10AP5BG0?rel=0&modestbranding=1', 'CACASC', ' CACACACAC', '563-Article_Text-2917-1-10-202207281.pdf'),
(4, 21101140, 1, 1, 'https://www.youtube.com/embed/4HrweW4IqJc?rel=0', 'wfwfwefwe', 'fwefwefwe', '1416-Article_Text-2548-1-10-20221110.pdf'),
(5, 21101140, 2, 1, 'https://www.youtube.com/embed/eQv10AP5BG0?rel=0', 'cddqwd', 'qwdqwdq', '563-Article_Text-2917-1-10-202207282.pdf');

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
(5, 5, 1, 3, '2025-08-17');

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
(1, 2, 'aljabar only', 'quiz tentang al jabar', 30, 1, 1, '2025-08-17 20:35:37');

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
(5, 1, '1+1=', 'pilihan', '423424', '2423', '23424', '1', 'd', 1);

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
(3, 1, 1, 'RPS_21101140_1_1_1755758725.pdf', '2025 genap', '2025-08-21 08:45:25', '2025-08-21 13:45:25');

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
(12345678, 'Max Verstapen', '$2y$10$U6pnCd3xy3owZJrdjEqz9OsHpjrQ5TI.KPBqDrVh4RFklfbq9hABi', 'maxverstapen123@gmail.com', 'default.jpg', 1, '2025-08-17', 1, 'siswa'),
(1234567899, 'John Doe', '$2y$10$nWSiM/QQvZQn45WJ5iFAqu8cVQAX5An2MAvYUKNCEFRucxbo/caI2', 'lorem@example.com', 'default.jpg', 1, '2025-08-17', 1, 'siswa');

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
(1, 12345678, 1, NULL, NULL, NULL, NULL, 0, 1, 2, 1, 46.6667, NULL, '2025-08-17 18:58:48', '2025-08-17 20:58:48', '2025-08-17 21:01:00', 'bank_soal', NULL, NULL, 100),
(2, 12345678, 1, NULL, NULL, NULL, NULL, 0, 1, 2, 1, 46.6667, NULL, '2025-08-17 18:58:48', '2025-08-17 20:58:48', '2025-08-17 21:01:00', 'bank_soal', NULL, NULL, 100),
(3, 12345678, 1, NULL, NULL, NULL, NULL, 0, 1, 2, 1, 46.6667, NULL, '2025-08-17 18:58:48', '2025-08-17 20:58:48', '2025-08-17 21:01:00', 'bank_soal', NULL, NULL, 100),
(4, 12345678, 1, NULL, NULL, NULL, NULL, 0, 1, 2, 1, 46.6667, NULL, '2025-08-17 18:58:48', '2025-08-17 20:58:48', '2025-08-17 21:01:00', 'tbl_soal', NULL, NULL, 100),
(5, 12345678, 1, NULL, NULL, NULL, NULL, 0, 1, 2, 1, 46.6667, NULL, '2025-08-17 18:58:48', '2025-08-17 20:58:48', '2025-08-17 21:01:00', 'tbl_soal', NULL, NULL, 100),
(6, 12345678, 1, NULL, 3, NULL, 'karena ok', 0, 1, 2, 1, 46.6667, NULL, '2025-08-17 13:58:59', NULL, '2025-08-17 21:01:00', 'bank_soal', 100, 'good', 100),
(7, 12345678, 1, NULL, 1, 'A', NULL, 0, 1, 2, 1, 46.6667, NULL, '2025-08-17 13:59:13', NULL, '2025-08-17 21:01:00', 'bank_soal', NULL, NULL, 100),
(8, 12345678, 1, 1, NULL, 'A', NULL, 0, 1, 2, 1, 46.6667, NULL, '2025-08-17 13:59:19', NULL, '2025-08-17 21:01:00', 'tbl_soal', NULL, NULL, 100),
(9, 1234567899, 1, NULL, NULL, NULL, NULL, 0, 1, 1, 2, 23.3333, NULL, '2025-08-17 19:02:05', '2025-08-17 21:02:05', '2025-08-17 21:04:27', 'bank_soal', NULL, NULL, 23.3333),
(10, 1234567899, 1, NULL, NULL, NULL, NULL, 0, 1, 1, 2, 23.3333, NULL, '2025-08-17 19:02:05', '2025-08-17 21:02:05', '2025-08-17 21:04:27', 'bank_soal', NULL, NULL, 23.3333),
(11, 1234567899, 1, NULL, NULL, NULL, NULL, 0, 1, 1, 2, 23.3333, NULL, '2025-08-17 19:02:05', '2025-08-17 21:02:05', '2025-08-17 21:04:27', 'bank_soal', NULL, NULL, 23.3333),
(12, 1234567899, 1, NULL, NULL, NULL, NULL, 0, 1, 1, 2, 23.3333, NULL, '2025-08-17 19:02:06', '2025-08-17 21:02:05', '2025-08-17 21:04:27', 'tbl_soal', NULL, NULL, 23.3333),
(13, 1234567899, 1, NULL, NULL, NULL, NULL, 0, 1, 1, 2, 23.3333, NULL, '2025-08-17 19:02:06', '2025-08-17 21:02:05', '2025-08-17 21:04:27', 'tbl_soal', NULL, NULL, 23.3333),
(14, 1234567899, 1, NULL, 1, 'A', NULL, 0, 1, 1, 2, 23.3333, NULL, '2025-08-17 14:02:12', NULL, '2025-08-17 21:04:27', 'bank_soal', NULL, NULL, 23.3333);

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
(1, 1, '1+1=', '1', '2', '3', '4', 'A', 'pilihan'),
(2, 1, '1+2=', '1', '2', '3', '4', 'C', 'pilihan');

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
(1, 21101140, 'UTS', '2025-08-17', '2025-08-31', 2, 'aktif', 2, 'manual', 70, 30);

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
(1, 1, NULL, 3, 'bank_soal'),
(2, 1, NULL, 2, 'bank_soal'),
(3, 1, NULL, 1, 'bank_soal'),
(4, 1, 1, NULL, 'tbl_soal'),
(5, 1, 2, NULL, 'tbl_soal');

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
  MODIFY `id_soal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `forum_diskusi`
--
ALTER TABLE `forum_diskusi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `guru_mapel`
--
ALTER TABLE `guru_mapel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `jawaban_siswa`
--
ALTER TABLE `jawaban_siswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `mata_pelajaran`
--
ALTER TABLE `mata_pelajaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `materi`
--
ALTER TABLE `materi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `pertemuan`
--
ALTER TABLE `pertemuan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `quiz`
--
ALTER TABLE `quiz`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `quiz_questions`
--
ALTER TABLE `quiz_questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `quiz_siswa`
--
ALTER TABLE `quiz_siswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rps`
--
ALTER TABLE `rps`
  MODIFY `id_rps` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_jawaban_siswa`
--
ALTER TABLE `tbl_jawaban_siswa`
  MODIFY `id_jawaban` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tbl_soal`
--
ALTER TABLE `tbl_soal`
  MODIFY `id_soal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_ujian`
--
ALTER TABLE `tbl_ujian`
  MODIFY `id_ujian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tugas_siswa`
--
ALTER TABLE `tugas_siswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ujian_soal`
--
ALTER TABLE `ujian_soal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
