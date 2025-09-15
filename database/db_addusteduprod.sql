-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 15, 2025 at 08:46 AM
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
-- Database: `db_addusteduprod`
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

-- --------------------------------------------------------

--
-- Table structure for table `guru`
--

CREATE TABLE `guru` (
  `nip` varchar(20) NOT NULL,
  `nuptk` varchar(25) NOT NULL,
  `email` varchar(255) NOT NULL,
  `nama_guru` varchar(128) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_type` enum('guru') NOT NULL DEFAULT 'guru',
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `guru`
--

INSERT INTO `guru` (`nip`, `nuptk`, `email`, `nama_guru`, `password`, `user_type`, `image`) VALUES
('1282023001', '1282023001', 'guru1@gmail.com', 'Ahmad Safei', '$2y$10$8iwiPrS9jYUVAhZAF.3a9.oa4EA/f5scljh/ZJqksTUkQgiKzONza', 'guru', 'default.jpg'),
('1282023002', '1282023002', 'guru2@gmail.com', 'Ahmad Nazir', '$2y$10$.OOU9m9OZX9X3MbLFOU5ruCA4YhQc0Sh3H2NS0h4TkSnIbyPLhrdK', 'guru', 'default.jpg'),
('1282023003', '1282023003', 'guru3@gmail.com', 'Arif Prasetyo', '$2y$10$EQsFl9fKEyxedhLi31/JpumijVbDxdbc/6Y/gFeUzNUtxecdfq/Ae', 'guru', 'default.jpg'),
('1282023004', '1282023004', 'guru4@gmail.com', 'Agus Supandi', '$2y$10$e0MDxwA3v9Oxb23QQT3d6u0iV2URL0Jre0hznziz9AlO2sHiKogOq', 'guru', 'default.jpg'),
('1282023005', '1282023005', 'guru5@gmail.com', 'Desi Permatasari', '$2y$10$itzA3Zc3HcZNUNUxx.LatumXtbpdVXj0fgznIThNcr1DVfBotFJJ.', 'guru', 'default.jpg'),
('1282023006', '1282023006', 'guru6@gmail.com', 'Fahrur Roji', '$2y$10$OkEScASteYCZydjKijA2..yhw6CQIoCwrSoxysJG3K5LsURBFKUdO', 'guru', 'default.jpg'),
('1282023007', '1282023007', 'guru7@gmail.com', 'Kurnia Sandi', '$2y$10$UfjOJqhZfBvtxLpwLDdMfe0Wp2bg4gHSjTujdssye1jPY5nME/PK.', 'guru', 'default.jpg'),
('1282023008', '1282023008', 'guru8@gmail.com', 'Naimah', '$2y$10$be.ETcD5GsOpSn.sOJl7serSLMKNiyjLxnIfidpsK71HNzUWelqUW', 'guru', 'default.jpg'),
('1282023009', '1282023009', 'guru9@gmail.com', 'Indah Safitri', '$2y$10$TsZpKBLYAFCSuuzVmtui2.22tVQzSgLYfI9nng7hfLz62rOU1v/Iq', 'guru', 'default.jpg'),
('1282023010', '1282023010', 'guru10@gmail.com', 'Irwan Humaidi Nur', '$2y$10$dyPAftCxYnMlsEaFxl3hBOS4ewcnLwyfugAjVBMEC6iLO3OA.H1Om', 'guru', 'default.jpg'),
('1282023011', '1282023011', 'guru11@gmail.comsq', 'Mochamad Mubin', '$2y$10$lLguJu.ylmMc9wSNBPOLRO5Xlvm4TDV23j/Yu.82ctTsL8jeRA54i', 'guru', 'default.jpg'),
('1282023012', '1282023012', 'guru12@gmail.com', 'Linda Hidayah', '$2y$10$jHpMomr8IyATmN0DoJ8I.uJDWnCwdbF4o7aa2OD4wY46SodzLbpSa', 'guru', 'default.jpg'),
('1282023013', '1282023013', 'guru13@gmail.com', 'Amsarudin', '$2y$10$Xzwy9nT.gY7tb06MO8m0AOQnQ9fF.KZ6tWmXB78LdAJuOv0QW8gsq', 'guru', 'default.jpg'),
('1282023014', '1282023014', 'guru14@gmail.com', 'Windah Arofah', '$2y$10$W4QtGNnMsW/zjDEgKCS34uVOC54YskHhFB4aly0mvSpsIDsFhPIUi', 'guru', 'default.jpg');

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
(1, '1282023001', 1),
(3, '1282023002', 3),
(4, '1282023002', 15),
(5, '1282023003', 9),
(6, '1282023004', 4),
(7, '1282023005', 11),
(8, '1282023006', 6),
(9, '1282023007', 1),
(10, '1282023008', 2),
(11, '1282023008', 5),
(12, '1282023009', 15),
(13, '1282023010', 4),
(14, '1282023010', 10),
(15, '1282023011', 6),
(16, '1282023011', 13),
(17, '1282023012', 11),
(18, '1282023012', 13),
(19, '1282023013', 9),
(20, '1282023013', 14),
(21, '1282023014', 12);

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
(1, 'PASD1', 'SD', 'Sekolah Dasar'),
(2, 'PBSMP1', 'SMP', 'sekolah menengah per'),
(3, 'PCSMA1', 'SMA', 'sekolah menengah akh');

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
(1, 'Sejarah Indonesia', 'Sejarah Indonesia'),
(2, 'Ilmu Pengetahuan Sosial', 'Ilmu Pengetahuan Sosial'),
(3, 'Sosiologi', 'Sosiologi'),
(4, 'Pendidikan Kewarganegaraan', 'Pendidikan Kewarganegaraan'),
(5, 'Ekonomi', 'Ekonomi'),
(6, 'Matematika', 'Matematika'),
(7, 'Pendidikan Jasmani Olahraga dan Kesehatan', 'Pendidikan Jasmani Olahraga dan Kesehatan'),
(8, 'Sejarah', 'Sejarah'),
(9, 'Pendidikan Agama', 'Pendidikan Agama'),
(10, 'Geografi', 'Geografi'),
(11, 'Bahasa Indonesia', 'Bahasa Indonesia'),
(12, 'Bahasa Inggris', 'Bahasa Inggris'),
(13, 'Seni Budaya', 'Seni Budaya'),
(14, 'Baca Tulis Quran', 'Baca Tulis Quran'),
(15, 'Ilmu Pengetahuan Alam', 'lorems');

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

-- --------------------------------------------------------

--
-- Table structure for table `pertemuan`
--

CREATE TABLE `pertemuan` (
  `id` int(11) NOT NULL,
  `id_materi` int(11) NOT NULL,
  `id_guru` varchar(20) DEFAULT NULL,
  `id_kelas` int(11) NOT NULL,
  `pertemuan_ke` int(11) NOT NULL,
  `tanggal` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `siswa_id` varchar(20) CHARACTER SET latin1 NOT NULL,
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
('0014946300', 'AHMAD RAMADHAN', '$2y$10$phFsR2sUrcJ0EYdVi9v1BOhuFDObYoXyMZYyiEQ2gi6xTZsgVEovu', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-10', 3, 'siswa'),
('0028290024', 'Gysen Wangsa', '$2y$10$x.Gb1B46ZmdGzfCN3Sd82.Xfn.gEeAFUiq5JLPh0A4/qqjk6mjtQ.', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-10', 3, 'siswa'),
('0031344056', 'Muhamad Safeih', '$2y$10$bZ8wa/aNir5R0dy7Y2AEEuCsG6c0Oq55Es.xaB1xkSKzDoU.kcVY2', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-10', 3, 'siswa'),
('0039378456', 'Rimpi', '$2y$10$CgzPEfMGfdxYndJv/aHENuIRbmEifqX56ODlBq0UrBoV9UmOROwS6', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-10', 3, 'siswa'),
('0042184528', 'Michael Agustian', '$2y$10$fcN4Da7jGg3ErZ/.pLKvpeJrDPj7vTQUz3dsbuFqRsMytN5iSHon6', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-10', 3, 'siswa'),
('0044795891', 'PUTRI SYAKILLAH ANASTASYAH', '$2y$10$aUgXz0MZXnEBZ9BVWAPux.Hp35N2j3QsWEUOkYsw3o7XPxaqY1XLy', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-10', 3, 'siswa'),
('0044875032', 'Firda Atikah Putri', '$2y$10$GSUkU6bdBSoIdhgb8VGkgeopAKZSEdNYK5CVHX9l6Lta2iRmtNvpO', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-10', 3, 'siswa'),
('0045351054', 'ADJIE ADITYA NUGRAHA', '$2y$10$fK0yAH/4ZVc.cGLJz4CDNewWP9zpF0KktNssEIKduPMwHETmGf9Dm', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-10', 3, 'siswa'),
('0045683849', 'Adelia Dian Megareta', '$2y$10$gmCd3OwOc7sYLcB84KRmZeQdMk0//aXehjWc3TH8aHJCiydAcpjrC', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-10', 3, 'siswa'),
('0046215859', 'PUTRA MARHAEN', '$2y$10$lHXY8/RkZSzFKlHV6jLHru/H2lqdHdgX.pW7CR7aqYKg.Gs/xI1i6', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-10', 3, 'siswa'),
('0051192742', 'ANGGA ERLANGGA PUTRA', '$2y$10$RdqlXty57yRwtZjZwnUkTeB4pNXhEPTg37Us1.KNg44NYcPA8YL/i', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-10', 3, 'siswa'),
('0052818825', 'Muhammad Rogib', '$2y$10$jvjve.8EI60ZyhEh6Hryh.gGM5J9wmCnUokpy4vO6cNJCHIMKrakO', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-10', 3, 'siswa'),
('0058595046', 'Muhamad Rizky Andrean', '$2y$10$MKZyEVOsmsVszE73tDkgTenRGWN59Pis.12DhwDKbm9n/fNEnzMQe', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-10', 3, 'siswa'),
('0062303354', 'Lydia Listiawan', '$2y$10$jJkKSOo/Jh53f6EjA5Fx0u7b.hHuRSYcesieqbZ1t4/C2JfVmUZrG', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-10', 3, 'siswa'),
('0063301626', 'Muhammad Adi Saputra', '$2y$10$bkJ.K4GeUoFAP7UJJEIUae8tFb71Ki48enEtoZxx7mJHPEICTPVxe', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-10', 2, 'siswa'),
('0064797771', 'MUHAMMAD DIKI MIFTACHHUDIN', '$2y$10$1.b8oHg/bNRg8ActMoLSQeSDR06qm5lEnbYPevUcHB81tORpEsON.', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-10', 3, 'siswa'),
('0065165563', 'Vazia Zulia vasha', '$2y$10$t/mnmyQQrSVEk65VkapmCuh8jCD0XpEJSh86HUClMwgoA09CUiahq', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-10', 3, 'siswa'),
('0066988913', 'Bunga Nur Aulia', '$2y$10$Ma4EiQNHwzkIrqrZnbVvwu55Q8EpCW3Si9fpRip8i31aGZNhVEWve', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-10', 3, 'siswa'),
('0073601675', 'Rizky Agusti', '$2y$10$V2yw8qKlfMcnMoLJvpt1au9zqK/9MQkwvm55nDWqZ5mY7Mv2nbo7m', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-10', 2, 'siswa'),
('0073767204', 'RHEVA DESFARINI', '$2y$10$MSjJMSY8k0GNrMv/Ad.0IOUVKDeeBYrMcjqcMAsUvlHAxm3ScMyW6', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-10', 3, 'siswa'),
('0077490337', 'GADIS GITA LAUREN', '$2y$10$rB9NTvF4fDGyHlcAsOvOI.u2rr5WBWtkJ6jJ.ABTSafktIpyDa6J6', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-10', 3, 'siswa'),
('0079552543', 'VICKY DWI VERNANDA', '$2y$10$QadT9D1AyJ.AqrvjM3I1CuCGUXiMtam2EYHg2tavJ4CyIHR7k5AH2', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-10', 3, 'siswa'),
('0079655473', 'M.TRISTAN RIVALDY', '$2y$10$6dgst9Q3QVwpG5gsHA0Cpew2pU16rf3JiUp9HYbBHJoz4t5C8plve', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-10', 3, 'siswa'),
('0079948350', 'NURJELANI', '$2y$10$etICx0cczEdZDRydomLXE.W7r9/.C1/LT6SWrEUuWLpL.bAruEGYy', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-10', 3, 'siswa'),
('0082779275', 'Putri aurelia', '$2y$10$13AfpcEXC3MfUAgUa2as1u8XCXLR/ZcdUQrcHRILpqcDy0aU6boKa', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-10', 3, 'siswa'),
('0084276194', 'ALDI SUPARDI', '$2y$10$OGvloFCB43gkezkXj1wzH.g8bu/PP/AQf5uiHtsb7OjC7jmd7vBjK', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-10', 3, 'siswa'),
('0084617145', 'Washfi Faraz Kamilah', '$2y$10$DfnnHE1N5hxoTKoMB0L3RerGRbHtJ4fl8BCuik2BRXyhdB3XfMbaW', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-10', 2, 'siswa'),
('0084764574', 'Eva', '$2y$10$T7tCgWnTbNj7kP8NAD2KiuMCZ048eRA7faEtb96Jy4GplUi8kdF/2', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-10', 2, 'siswa'),
('0086207880', 'DIMAS YOGA RAMADHAN', '$2y$10$G3tUmF5J7zTO2yl3vH78q.7FH3g9y9wbiqhbqlPrVlU8f8erIU0Cq', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-10', 2, 'siswa'),
('0086769753', 'SHEILA NATASYA', '$2y$10$hpkYQu0PgWEdFCbym1ZjR.o.fp6pYY0M/APaSSd7XV6.jrzj3ULau', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-10', 3, 'siswa'),
('0087211088', 'AZKIYATU ZAHRA', '$2y$10$O5tVSpJDyPgBaVMc0kgL3uv1/Vpk4Rmo8TthfT8/EFZ.fJJuXqRXW', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-10', 2, 'siswa'),
('0087217408', 'Zavio Rizki Saputra', '$2y$10$rkKkH3ZayA5bGu4gBTYSz.qv.WM83nKuiBtxIxshvBY5O6WEsXHt.', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-10', 3, 'siswa'),
('0087337628', 'KHAERUN NURI', '$2y$10$WzGbROD6KAqY.Kj7BezoxOTalqrdoMWJQZgakIctDOdnpI1dDB5mC', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-10', 2, 'siswa'),
('0089969128', 'AHMAD SYAHRONI', '$2y$10$Dz4qMPskyYXSyX0wr6WNROYB6nkBYh8N6srlvlmUjPxDelRt6uhQa', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-10', 3, 'siswa'),
('0091031828', 'MEIDY MAQFIRAH', '$2y$10$RsdUwR/lXg.9b6IffoSkduM8O08MDYvalK0YhLz3sbLREyHYPnl2K', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-10', 2, 'siswa'),
('0092516158', 'Kholilurohman', '$2y$10$iZBGZ8yUJa1gWKM.zGc44.y79uWlQNnqPQz3KCYjleW0fBNXQHo9C', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-10', 2, 'siswa'),
('0093590373', 'TAZKIYAH NURMALA', '$2y$10$wfBm5lHPNlJN4qj4ZIgSpOmlChu5rk3K8MtFaQQLE8O1bEGISMEaq', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-10', 3, 'siswa'),
('0093801678', 'Arif Rahman Tiar', '$2y$10$KgWPJkvhXidUoElGs0HVHeyMC0mTzHLXWT5m1EfkU/K5MOyWXN6Xu', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-10', 3, 'siswa'),
('0094063500', 'SONGO ABABIL', '$2y$10$DA8rNIGFQWvUy3tPdwxwhep0gk60G2G.f454awVK75FyAGWAo90QO', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-10', 2, 'siswa'),
('0095416290', 'FAHMI RIDHO', '$2y$10$8e.6TOt6xjOlwfYPhM8fgezP/wR2XPV8tTBQEl8QhRpr0M5Cevqtm', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-10', 1, 'siswa'),
('0095454453', 'MUHAMAD FIRMANSYAH', '$2y$10$gaLqC1i2yWSjaoEnfQoAouj/.MS.Pz3Q7v16qxWAjAoiszUw0I/em', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-10', 3, 'siswa'),
('0096317085', 'RAISYA RAMADHANI', '$2y$10$DqRYtsmgT6vFhsZ3bMI.6u5Zk5NIhiTW8vsN/MGwx0JxUnRxVyes.', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-10', 3, 'siswa'),
('0096325350', 'Muhammad Raihan', '$2y$10$x3FWvQbQz/BWMfZmBn/kg.0TqB1wUwCy1STwuTSwDboLKxkuF4EAq', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-10', 2, 'siswa'),
('0098026915', 'SYAHRUL AL HAJJ DZULFIKAR', '$2y$10$1UauzTwIwwE2M3zBwPsq6.S7P3QDdU4Fa2OPi4uLW1lJZjuy/TrMy', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-10', 2, 'siswa'),
('0099268185', 'AHMAD FIRAS BAHIRA', '$2y$10$0.IHfSD/LLQYkfAci9t0Eeq.0.dHKNkz35tgeL8bq8kFNu48ZM3NK', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-10', 3, 'siswa'),
('0101839911', 'Sri Wahyuni', '$2y$10$8q6I4gX3KdvMJDLN/Xy3Ce1ziQ.pkNYKJmVsHE1fABoyzxBCYpqEG', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-10', 2, 'siswa'),
('0103361826', 'Noviyanti', '$2y$10$oAIM5eKj6u372otY/76pmexA4HH1sJHaE7ixqDd41RxTpo4DwviCy', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-10', 2, 'siswa'),
('0104991736', 'MUHAMAD AUZAI', '$2y$10$A909OpZn8qVmy9rD5KyQrOt7eJfIIsbQb39sxKQ2QT8Ld0LCrpXie', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-10', 2, 'siswa'),
('0105778035', 'SAIDA', '$2y$10$F3C4bdkpblPvLArbI9gIt.GxhNhZqnX4qwoMlz/6iPJ7YVtIJeJ6.', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-10', 2, 'siswa'),
('0107037461', 'Alvian Yusuf Handoko', '$2y$10$mDjyzYyaaRiYBvo1G2ypHOQz/01uKcIjhub1yNd/HQ9M9B4XyQyr2', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-10', 2, 'siswa'),
('0128301889', 'MUHAMMAD DWI ANDRE ARAFAH', '$2y$10$wLhVUCy0rK4SAXt8As3JXOXxa0gzu6V6El9X/20.dVcgXmjM87Yhe', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-10', 1, 'siswa'),
('12345678', 'Muttakim Saefullah', '$2y$10$8ZZScX8w2UE/F6u8NfSp9eK/UGE2lh9MsRwNi0wQrFQOqeVkEZVUK', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-10', 2, 'siswa'),
('2021383151', 'Fina Wardawiyah', '$2y$10$0ksWxNM96uDILaFYB5pizO5RTNTXwX3IDu6rXo.fXkT6gTOCw5trO', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-10', 3, 'siswa'),
('2052804732', 'Ibra Wimarta', '$2y$10$LUNd.4FFuVR/wV93IcEawu.ZTJT/BZQQJ2/PjyRW3klI3xod5NBSa', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-10', 3, 'siswa'),
('2061010927', 'Sinta', '$2y$10$70TiVobwdYvkvjoTR0MvPukoXsWEGrzmh7kUjvjjXDTTCEvIj3Q5y', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-10', 3, 'siswa'),
('2065234615', 'Khairunnisa', '$2y$10$EOnKgsI88pyzh5ZaGGNWNOW5oLFxd1k58yea89eLx5r/JvK.Orfgq', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-10', 3, 'siswa'),
('2078814025', 'Maulana Indra Prama', '$2y$10$DSa70CzMaujrIrawvEgc.egoYRN7sM85Dv0F14Cy1QVbKLxJIbdti', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-10', 3, 'siswa'),
('2082533938', 'Noval Adrian Wijaya', '$2y$10$qEsNBg0M57t8d/W9WJlh8erOzTInI8/rMsVp2SppdqMjCuj4iRxGW', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-10', 3, 'siswa'),
('2098350667', 'Fitri', '$2y$10$UKUc1OZ/K8qffooYicXf3eEGUFvCYuTdiZbSM3vovcmprl949n1BW', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-10', 3, 'siswa'),
('3016839237', 'Siti Inayah Haq', '$2y$10$/bW.PIxZ6i7.ZeV6eEOVD.fOSIlhvo0OYsOSlvQLdJkinDkJAxC6S', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-10', 2, 'siswa'),
('3044755103', 'Ahmad Khorib', '$2y$10$EzprManGmvv93XVean49HOKU4Nz6FN8V.WbeI160kfvsiOozM8y9.', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-10', 2, 'siswa'),
('3045646933', 'Usli Imam Safei', '$2y$10$EpmpVlSxBG7aALpMFfzc9eJmI4JTKbDpoMJuby10EEO.KkheoNaj2', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-10', 3, 'siswa'),
('3061461498', 'MUHAMMAD SAYYID FATUR ROHMAN', '$2y$10$L32H88xLRI0rAFN683Su0OUMOHs3TJpwk29BwmhO/xIydsPTQ5qnS', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-10', 3, 'siswa'),
('3063319075', 'Muhammad Maulana Ilyas', '$2y$10$A.fBtp/B0.v2VlVULRhiIOkx9luxDOJgiCWIJDHY9vIXX5wZvCYFq', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-10', 3, 'siswa'),
('3068576912', 'Aida', '$2y$10$RTmugECn4IOUHNzvvFtPu.XVQ7A9qH4rIPhl9hmWsS9.LydUn8ED6', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-10', 2, 'siswa'),
('3072235768', 'Muhammad Taju Syarop Fauzi', '$2y$10$s8GzEB1/YtoNRYAxBGwz.uebsJ8W0cBY7/OaZfIzbXIlBG28vu0nS', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-10', 3, 'siswa'),
('3073203066', 'Muhammad Rynaldi', '$2y$10$3sCPfnLH9sEqPnDHDEwrGO7UftCXuo./HlixYrcPY8jODOPdQqag.', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-10', 2, 'siswa'),
('3080556625', 'HAPIZ YUSRI', '$2y$10$n3ia8USDpadwCgPNT6eMkOKVXO3YFM61C3r/xivq9hbs5INz4OsHq', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-10', 3, 'siswa'),
('3091558263', 'Muhammad Husni Makki Sonhaji', '$2y$10$ytYfcKvwcBxKnDX1kG/FnuUZRXJoFZ8wWB0SyPavHmbGfR7dDxWJ2', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-10', 2, 'siswa'),
('3107966544', 'Najwa Putri Awaliyah', '$2y$10$NsguXDN.NpKnR5D4PQAZFe5MJJe9f3q5WkSRM43gW3uGDABx7rBWe', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-10', 3, 'siswa'),
('3124368879', 'RIZKI FAUZI', '$2y$10$5f3i3pMRdV.aPWI.BAsCr.XqUleJJ4g6WTViWVL.v7V5ogWUSXQ7a', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-10', 2, 'siswa'),
('3128153661', 'MUHAMMAD SYAFIQ ZAKY ISKANDAR', '$2y$10$2qVFivxenryLwkSVqLYz9.TXLzCBGT.XYWXf9hL/.FzCWQyh4QHRy', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-10', 2, 'siswa'),
('3146882349', 'Laila Khanza Az Zahra', '$2y$10$SoCIJ9gqpoCc/62R59ZVP.FwObz9A/5lU3P1Mo.lB0wIi1hkZZaIS', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-10', 1, 'siswa'),
('3745065752', 'KARTONO', '$2y$10$HftMild/pxikyxo0XbHBIuOuZ1EbkXgok9TlDvfZxcUwX0quTnBia', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-10', 2, 'siswa'),
('3749766539', 'ZAINUDIN', '$2y$10$XJzOcy8mUPJJ9YIa0Th1l.RbYEVY9tvUvmBjNCLWMjXvaLcjml3uW', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-10', 3, 'siswa'),
('3762315024', 'Nurlaela', '$2y$10$6TWKlC419AHfwz1U9QPm/.vqjTaAceZnVN6yw.NBVXoGJm94aKYCm', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-10', 3, 'siswa'),
('3839354749', 'SYAIPUDIN', '$2y$10$NlpDAisz23DccJUshhsn7eyvdYHZTW3ONDt2gKVsKGUFql1.S84oO', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-10', 2, 'siswa'),
('3898374246', 'Apiyah', '$2y$10$HvNL3apZLq3hfuzsK9WJ5uodGMJPEKR5HjpYctgEOrK8r88v55i2C', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-10', 2, 'siswa'),
('3957922406', 'Dwi Bayu Pribadi', '$2y$10$ck1EoMFFGD6/wlcFBHn7F.f/GoYlBmgJWhvIJhteI6Mtl8vA.0fZS', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-10', 2, 'siswa'),
('3994681926', 'Khumaeratur Rodhiyah', '$2y$10$GX7FdSYDG.0E8CB72DsoJ.w1f27YGV1mRMndAtYeiTK0w6lXDcJ..', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-10', 3, 'siswa'),
('9779152739', 'Jamsuri', '$2y$10$rwfTgs3MmTBvxJazPvAgQ.Y4AIzxUFEIAPqjUDqZjsTK0KyLC0NMG', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-10', 3, 'siswa'),
('9804913006', 'Mukri', '$2y$10$001MyjX/dmXUYS8cMUElSeMqIkcf6jc/oEI7XUnYm1JkIMUkcAKiK', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-10', 3, 'siswa'),
('9996776172', 'Wiji Sanuri', '$2y$10$B3vzKKZX/xDcAt8UzLOnJ./RDbpHGTvSACLbV2ura.wQ6dSE/dlHO', 'siswa@gmail.com', 'default.jpg', 1, '2025-09-10', 3, 'siswa');

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
  ADD UNIQUE KEY `nuptk` (`nuptk`);

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
  MODIFY `id_soal` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `forum_diskusi`
--
ALTER TABLE `forum_diskusi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `guru_mapel`
--
ALTER TABLE `guru_mapel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `jawaban_siswa`
--
ALTER TABLE `jawaban_siswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `mata_pelajaran`
--
ALTER TABLE `mata_pelajaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `materi`
--
ALTER TABLE `materi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pertemuan`
--
ALTER TABLE `pertemuan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quiz`
--
ALTER TABLE `quiz`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quiz_questions`
--
ALTER TABLE `quiz_questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quiz_siswa`
--
ALTER TABLE `quiz_siswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rps`
--
ALTER TABLE `rps`
  MODIFY `id_rps` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_jawaban_siswa`
--
ALTER TABLE `tbl_jawaban_siswa`
  MODIFY `id_jawaban` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_soal`
--
ALTER TABLE `tbl_soal`
  MODIFY `id_soal` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_ujian`
--
ALTER TABLE `tbl_ujian`
  MODIFY `id_ujian` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tugas_siswa`
--
ALTER TABLE `tugas_siswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ujian_soal`
--
ALTER TABLE `ujian_soal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
