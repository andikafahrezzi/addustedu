-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 31, 2025 at 07:07 AM
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
  `email` varchar(255) NOT NULL,
  `nama_guru` varchar(128) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_type` enum('guru') NOT NULL DEFAULT 'guru',
  `image` varchar(255) NOT NULL,
  `id_mapel` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `guru_mapel`
--

CREATE TABLE `guru_mapel` (
  `id` int(11) NOT NULL,
  `id_guru` varchar(20) CHARACTER SET latin1 NOT NULL,
  `id_mapel` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
(14, 'Baca Tulis Quran', 'Baca Tulis Quran');

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
('0014946300', 'AHMAD RAMADHAN', '$2y$10$TcIYiamdY.MF/Fb7VzW5oO3VyGLizmYJgrt91H3YkUNVscExdtGQ2', 'siswa@gmail.com', 'default.jpg', 1, '2025-08-31', 3, 'siswa'),
('0028290024', 'Gysen Wangsa', '$2y$10$kBcCYHy6tjkQvNI1FZyA0Oc1mVRFp39DSlmxDDSFdid5H.aBvCj.2', 'siswa@gmail.com', 'default.jpg', 1, '2025-08-31', 3, 'siswa'),
('0031344056', 'Muhamad Safeih', '$2y$10$eCD6zjTj1K4JdJKlM2t6KOtg3h7eUZXs9fWLbjuEhCJ0dCDmdTGem', 'siswa@gmail.com', 'default.jpg', 1, '2025-08-31', 3, 'siswa'),
('0039378456', 'Rimpi', '$2y$10$TfBzB5gjOgUynKXoAFlcCeV1gV8HD.i6pNogj.PK01qZ9.gXtGu1q', 'siswa@gmail.com', 'default.jpg', 1, '2025-08-31', 3, 'siswa'),
('0042184528', 'Michael Agustian', '$2y$10$NM.Q.XgG/zA6tcG59lgOfOqREhr1DJrmm6fLxiI4JFsoldhLt6/V6', 'siswa@gmail.com', 'default.jpg', 1, '2025-08-31', 3, 'siswa'),
('0044795891', 'PUTRI SYAKILLAH ANASTASYAH', '$2y$10$1CucqVkxHdqrppCoPzYBHezhDoWxu2VuITcD1iNO4LQFHJesKGHGy', 'siswa@gmail.com', 'default.jpg', 1, '2025-08-31', 3, 'siswa'),
('0044875032', 'Firda Atikah Putri', '$2y$10$IKJvp4fnvLLP8oC7nGoKS.0px7LSpPcedo8J8CAIqny8u4Tmo4vLG', 'siswa@gmail.com', 'default.jpg', 1, '2025-08-31', 3, 'siswa'),
('0045351054', 'ADJIE ADITYA NUGRAHA', '$2y$10$L37vnmD/B14dF/57TyDM9OA2URZmTnp1dXELUu3bNskvY42djDdWu', 'siswa@gmail.com', 'default.jpg', 1, '2025-08-31', 3, 'siswa'),
('0045683849', 'Adelia Dian Megareta', '$2y$10$cfHIWQD.ENy/pdxTAu1vWO1mnFjP0reiq1/W5HZQekTbKW5bFLnnW', 'siswa@gmail.com', 'default.jpg', 1, '2025-08-31', 3, 'siswa'),
('0046215859', 'PUTRA MARHAEN', '$2y$10$1kFyljUNdKQK1LLTC7h5Nu4JZkaYutmUa27voiSvj688W5H9vmYy.', 'siswa@gmail.com', 'default.jpg', 1, '2025-08-31', 3, 'siswa'),
('0051192742', 'ANGGA ERLANGGA PUTRA', '$2y$10$casv6PRips7jtHobnjAW6e4pDntk8c8UNFTcqpgKRH.npD9JAeN3a', 'siswa@gmail.com', 'default.jpg', 1, '2025-08-31', 3, 'siswa'),
('0052818825', 'Muhammad Rogib', '$2y$10$tBBGeiCsECSiBL6Jtg6ZFe5y5i.gZZux22CtMFBr/aAcU39aSYp9C', 'siswa@gmail.com', 'default.jpg', 1, '2025-08-31', 3, 'siswa'),
('0058595046', 'Muhamad Rizky Andrean', '$2y$10$fjrol62zzv8HVTVA09y3c.tYSS4mkU2Yidqvw5NzaQobVN3wzy1Zm', 'siswa@gmail.com', 'default.jpg', 1, '2025-08-31', 3, 'siswa'),
('0062303354', 'Lydia Listiawan', '$2y$10$IGdAxhkgzK/zoJwDpLPrm.Ja9vimeLsXRL5gyvMfvl0ICr1s7M2pS', 'siswa@gmail.com', 'default.jpg', 1, '2025-08-31', 3, 'siswa'),
('0063301626', 'Muhammad Adi Saputra', '$2y$10$4F1h7yySYUpaahPsSoDBR.2XxbiBseBTWiztsaEkJoYG4qA.jByTm', 'siswa@gmail.com', 'default.jpg', 1, '2025-08-31', 2, 'siswa'),
('0064797771', 'MUHAMMAD DIKI MIFTACHHUDIN', '$2y$10$8JMu4rXD22IgqPKdmssA8ebE/itixhhnEUPoIKf7rDxxUjcPV0k5q', 'siswa@gmail.com', 'default.jpg', 1, '2025-08-31', 3, 'siswa'),
('0065165563', 'Vazia Zulia vasha', '$2y$10$IIgrwvLLUNMWYyaZrKYfy.qBr1bj31jQNQ93cDcXViGWmZzHzJ7P2', 'siswa@gmail.com', 'default.jpg', 1, '2025-08-31', 3, 'siswa'),
('0066988913', 'Bunga Nur Aulia', '$2y$10$SbMjHbCwuk955QhWYRWZkOxQ3vq6RKRqLVxlbHl9uK6AjKEeotD8a', 'siswa@gmail.com', 'default.jpg', 1, '2025-08-31', 3, 'siswa'),
('0073601675', 'Rizky Agusti', '$2y$10$SaAKojfgczL9TJM3WBApxuXYuKeb8uDhG6zNAA8bxSZyJ28yurTQK', 'siswa@gmail.com', 'default.jpg', 1, '2025-08-31', 2, 'siswa'),
('0073767204', 'RHEVA DESFARINI', '$2y$10$ZbS6nqt5Aa8oiuBX01o7oObVB3y7Taw9xgMzJFqlO.t4ue5LJgg26', 'siswa@gmail.com', 'default.jpg', 1, '2025-08-31', 3, 'siswa'),
('0077490337', 'GADIS GITA LAUREN', '$2y$10$aup/eKD6ffgGtnFK6rEVDeVQJX1zfrq7r1bK9OuxvIGS014jlmf8W', 'siswa@gmail.com', 'default.jpg', 1, '2025-08-31', 3, 'siswa'),
('0079552543', 'VICKY DWI VERNANDA', '$2y$10$A1lH/xjxs1OMFiY1YluD2Om/9HiV6BvWE1xqsgUUXBPnVoKGR4SAi', 'siswa@gmail.com', 'default.jpg', 1, '2025-08-31', 3, 'siswa'),
('0079655473', 'M.TRISTAN RIVALDY', '$2y$10$t..pmLzRYAXzCKWA0dTFVOuxHyB06fTxLuzJ0KPbMRVSe2vxKFWJ.', 'siswa@gmail.com', 'default.jpg', 1, '2025-08-31', 3, 'siswa'),
('0079948350', 'NURJELANI', '$2y$10$IMaRNhQ/dTqpW4CEYjFe7OjzSvMzQXqcwtMgCv0i2OBk4jHPUr4Eq', 'siswa@gmail.com', 'default.jpg', 1, '2025-08-31', 3, 'siswa'),
('0082779275', 'Putri aurelia', '$2y$10$Yfm6JG.FqfLSDS2zOd8mnuFSHA1SWdtbC6r4tAbQ9JoezEe5X2Nk2', 'siswa@gmail.com', 'default.jpg', 1, '2025-08-31', 3, 'siswa'),
('0084276194', 'ALDI SUPARDI', '$2y$10$Lf2GpB80zU14RThVQhHq5OQ4kzLaBVKeWJIjF/lJhBzcY7yghgfhm', 'siswa@gmail.com', 'default.jpg', 1, '2025-08-31', 3, 'siswa'),
('0084617145', 'Washfi Faraz Kamilah', '$2y$10$AffZdBCSkS8swCqI6C2k7uurbDm8sj3bJyr6MWw/0ZF4HPXs3Ak/.', 'siswa@gmail.com', 'default.jpg', 1, '2025-08-31', 2, 'siswa'),
('0084764574', 'Eva', '$2y$10$lMWac3b928TfWPgDfVJHYe4jVmCNM0bfQn/9mejGstV/mtatw8Zci', 'siswa@gmail.com', 'default.jpg', 1, '2025-08-31', 2, 'siswa'),
('0086207880', 'DIMAS YOGA RAMADHAN', '$2y$10$LqdGYi1Pt3Q.oJRZ9UHnGuZbB2Dt5un6bMlKKpIgHojqgaWmZQkKm', 'siswa@gmail.com', 'default.jpg', 1, '2025-08-31', 2, 'siswa'),
('0086769753', 'SHEILA NATASYA', '$2y$10$xnw.rdfOp0UdFDbB0XvIKubNdK6m14Fiul0QM2KmRuPzEbBtDRBHW', 'siswa@gmail.com', 'default.jpg', 1, '2025-08-31', 3, 'siswa'),
('0087211088', 'AZKIYATU ZAHRA', '$2y$10$.pIGPmBrc6cahHx.ZGM1AOVSJI0X1P.vUs88ZdaRqQWAgFYrT7wC2', 'siswa@gmail.com', 'default.jpg', 1, '2025-08-31', 2, 'siswa'),
('0087217408', 'Zavio Rizki Saputra', '$2y$10$qW.jl4gd8S7o/k2hLgjb1OEY1UHA9q25HbOk7tp2i2h.2hOvlji0S', 'siswa@gmail.com', 'default.jpg', 1, '2025-08-31', 3, 'siswa'),
('0087337628', 'KHAERUN NURI', '$2y$10$/v0ByLFZZwXvO2DKzQnKterzqA7/d9ubWBRdEJgTxuDnxOmilG/iC', 'siswa@gmail.com', 'default.jpg', 1, '2025-08-31', 2, 'siswa'),
('0089969128', 'AHMAD SYAHRONI', '$2y$10$Cpeqya4YkqcC79SAGGt.Y.yVTVBDAduPbYKjs7rLuFVYjHnbQqaCK', 'siswa@gmail.com', 'default.jpg', 1, '2025-08-31', 3, 'siswa'),
('0091031828', 'MEIDY MAQFIRAH', '$2y$10$rtiGtwiL.Z6RlyNiKBvLJuR3ERoafL0Qj5BQ.FTUYDxIwD2Rpyv0K', 'siswa@gmail.com', 'default.jpg', 1, '2025-08-31', 2, 'siswa'),
('0092516158', 'Kholilurohman', '$2y$10$zXPu4/Bvkz9evg8G/tvR1ONdmtVEnMmJs/gdgRyi5qvhkBpFncVD2', 'siswa@gmail.com', 'default.jpg', 1, '2025-08-31', 2, 'siswa'),
('0093590373', 'TAZKIYAH NURMALA', '$2y$10$dbcUOMJbGtkmGK49T/ZjtuIkIuFJCTpTfHIdRKplEF0/65eBUW0HC', 'siswa@gmail.com', 'default.jpg', 1, '2025-08-31', 3, 'siswa'),
('0093801678', 'Arif Rahman Tiar', '$2y$10$EjBQP./DGFWT232WZ3wsu.weyZsjOVSe2wSpLH7mLkJznfzDjg.3e', 'siswa@gmail.com', 'default.jpg', 1, '2025-08-31', 3, 'siswa'),
('0094063500', 'SONGO ABABIL', '$2y$10$F.Gc8Tw/PGm1u7UNxWG0iuyRAzJy95Qo70o3b.L.9v18eEjB/Nubq', 'siswa@gmail.com', 'default.jpg', 1, '2025-08-31', 2, 'siswa'),
('0095416290', 'FAHMI RIDHO', '$2y$10$ngmXFHFbcHuDRdhmC7NOteZtj2OwVIC066955OjyY6Dj.i.1kUqLO', 'siswa@gmail.com', 'default.jpg', 1, '2025-08-31', 1, 'siswa'),
('0095454453', 'MUHAMAD FIRMANSYAH', '$2y$10$M90vgPD0KGu47xktseAoo.rkfbAqrrpdnxNCwZwOvB9mWdgGQ8bJ6', 'siswa@gmail.com', 'default.jpg', 1, '2025-08-31', 3, 'siswa'),
('0096317085', 'RAISYA RAMADHANI', '$2y$10$DyCA2CprDuxgjUiMF7X55u681R915Aeuzfrd6sU1UbzlsFjbeWqUu', 'siswa@gmail.com', 'default.jpg', 1, '2025-08-31', 3, 'siswa'),
('0096325350', 'Muhammad Raihan', '$2y$10$EeuVYh4A5ti8JJKSVEcQ.esOPxzJSDb6xexQopi4Qj9M2UD5heYXK', 'siswa@gmail.com', 'default.jpg', 1, '2025-08-31', 2, 'siswa'),
('0098026915', 'SYAHRUL AL HAJJ DZULFIKAR', '$2y$10$rGUlDgPpHMJGDg2aPUnWo./OBRfqK9xOvONtAm7MUCaeXmGLWue2.', 'siswa@gmail.com', 'default.jpg', 1, '2025-08-31', 2, 'siswa'),
('0099268185', 'AHMAD FIRAS BAHIRA', '$2y$10$g/RDA1Ri53rKo0Yfq7Dmj..Cq4JiU9AnavmmDUHpZga29F0rUNJAO', 'siswa@gmail.com', 'default.jpg', 1, '2025-08-31', 3, 'siswa'),
('0101839911', 'Sri Wahyuni', '$2y$10$2NmRUNFg0BRxdIkYK9gh8OAF5BiYXSohbLNlEM1LSKXT2X2DjWTPC', 'siswa@gmail.com', 'default.jpg', 1, '2025-08-31', 2, 'siswa'),
('0103361826', 'Noviyanti', '$2y$10$ExP1nD/Lu6HdFEt/EK2JLOmeg.HBWbqz7GiWPZVxwnIMM2Bz/2uu.', 'siswa@gmail.com', 'default.jpg', 1, '2025-08-31', 2, 'siswa'),
('0104991736', 'MUHAMAD AUZAI', '$2y$10$5JSFcjl2xypQ3DhEsj7xBucwdZbAqXZj.IpzMQgFlmZrztMFdAEtm', 'siswa@gmail.com', 'default.jpg', 1, '2025-08-31', 2, 'siswa'),
('0105778035', 'SAIDA', '$2y$10$HP9gOCT8yJqgwxqgIT9aKeS7s/4nsyp/xFidYWL0drAIAqG4IJYma', 'siswa@gmail.com', 'default.jpg', 1, '2025-08-31', 2, 'siswa'),
('0107037461', 'Alvian Yusuf Handoko', '$2y$10$cV57kYIV8pPpY7eM1qguTO8NezI6Gt2iU/9X5L5ZY8jzOBkK3jRnK', 'siswa@gmail.com', 'default.jpg', 1, '2025-08-31', 2, 'siswa'),
('0128301889', 'MUHAMMAD DWI ANDRE ARAFAH', '$2y$10$UjLr6u30IbNrsKCDII8mhuSSzau1Q5nFvSKvuAc7mp0cApLGgvem.', 'siswa@gmail.com', 'default.jpg', 1, '2025-08-31', 1, 'siswa'),
('12345678', 'Muttakim Saefullah', '$2y$10$32Ip4QKdT2uAERbdv220uepLmlP76l2tQvFyWZs5L6mT/FlDH5S4.', 'siswa@gmail.com', 'default.jpg', 1, '2025-08-31', 2, 'siswa'),
('2021383151', 'Fina Wardawiyah', '$2y$10$ZQ7L2.U8Ury.Yv4pe01u.u0N3sRPnvjNcr2IlpmF4iChqq1hdxtH2', 'siswa@gmail.com', 'default.jpg', 1, '2025-08-31', 3, 'siswa'),
('2052804732', 'Ibra Wimarta', '$2y$10$i/XYGfaA09NRq72IpY0IsuV4nPnia/1aiVh7Ja2nQds1DZrgUkm7W', 'siswa@gmail.com', 'default.jpg', 1, '2025-08-31', 3, 'siswa'),
('2061010927', 'Sinta', '$2y$10$YNdu0g4xPAoYb/CxoP7loOT7MDrXQlfndLZa.19KUHDkJbtBGPns2', 'siswa@gmail.com', 'default.jpg', 1, '2025-08-31', 3, 'siswa'),
('2065234615', 'Khairunnisa', '$2y$10$dsGQFvJCgv1SPCdaw0h3BuAlTWX0flqvGaEyg86dbRdb0vOn1lgCS', 'siswa@gmail.com', 'default.jpg', 1, '2025-08-31', 3, 'siswa'),
('2078814025', 'Maulana Indra Prama', '$2y$10$aeAd/nCmjHXtgPq0LNIoe.omTDM66wDGU4v24IEFn73HAsdO1qOXu', 'siswa@gmail.com', 'default.jpg', 1, '2025-08-31', 3, 'siswa'),
('2082533938', 'Noval Adrian Wijaya', '$2y$10$kZckm.T2jMCYJl.LtyXFe.c9eRiqzKa6Raj9yy8mCd8B9gaAI2omm', 'siswa@gmail.com', 'default.jpg', 1, '2025-08-31', 3, 'siswa'),
('2098350667', 'Fitri', '$2y$10$YnCofv/b6ruidF94dgcR5u4tQRno1p8GaVwCHVZh6LoWfbkW1nHd6', 'siswa@gmail.com', 'default.jpg', 1, '2025-08-31', 3, 'siswa'),
('3016839237', 'Siti Inayah Haq', '$2y$10$qBHIy2ml98nZU.ehXb2xEu.wpLuOlOr7y1jWBk1/WG/6bHB2Rd3gS', 'siswa@gmail.com', 'default.jpg', 1, '2025-08-31', 2, 'siswa'),
('3044755103', 'Ahmad Khorib', '$2y$10$cBvPBDtcYKjYc34I8vmvEe6QlDMa5UVX2YynuOia7Qzbkqm5ZwHuu', 'siswa@gmail.com', 'default.jpg', 1, '2025-08-31', 2, 'siswa'),
('3045646933', 'Usli Imam Safei', '$2y$10$0tGbTI32RgRK68q398wlQuAQ3ZaN9NL1uKy3YOnd.j//PvT7o3P7G', 'siswa@gmail.com', 'default.jpg', 1, '2025-08-31', 3, 'siswa'),
('3061461498', 'MUHAMMAD SAYYID FATUR ROHMAN', '$2y$10$pm8tjOitcJ87VSCdUgist.wjf9IgTt82E1FTTpaOakEtuH.yu37oW', 'siswa@gmail.com', 'default.jpg', 1, '2025-08-31', 3, 'siswa'),
('3063319075', 'Muhammad Maulana Ilyas', '$2y$10$YFrH3QcaEKIFUSABcZrKVeLsxwyXhC8833SILhYCYMsgoANiw6GWm', 'siswa@gmail.com', 'default.jpg', 1, '2025-08-31', 3, 'siswa'),
('3068576912', 'Aida', '$2y$10$XaT7G.AmBd3C.2v5RHrAxunQ.IhcR5DqVe6EDg4iGy.6H7GT2N1b2', 'siswa@gmail.com', 'default.jpg', 1, '2025-08-31', 2, 'siswa'),
('3072235768', 'Muhammad Taju Syarop Fauzi', '$2y$10$vNvxo/RdqAzbuveFrQfnn.NtcxwAu0tQP7WdvfwSgXzVTSBn3Hgj.', 'siswa@gmail.com', 'default.jpg', 1, '2025-08-31', 3, 'siswa'),
('3073203066', 'Muhammad Rynaldi', '$2y$10$FR6GQYh9HCKQqHUm1i.l/.Annwwbqa.jzcDKwP5XoQndfkpZqY9Jm', 'siswa@gmail.com', 'default.jpg', 1, '2025-08-31', 2, 'siswa'),
('3080556625', 'HAPIZ YUSRI', '$2y$10$G2tuAsRMaWXnjb1V8HJt7.ZEYRrqfhEnJKEHsXQvFGGbKIj1ISC06', 'siswa@gmail.com', 'default.jpg', 1, '2025-08-31', 3, 'siswa'),
('3091558263', 'Muhammad Husni Makki Sonhaji', '$2y$10$C07UrCwKJVPxwhK4/s75gOpzwp.WCoiZuXGwkpRUMjgFdc4ny9eNO', 'siswa@gmail.com', 'default.jpg', 1, '2025-08-31', 2, 'siswa'),
('3107966544', 'Najwa Putri Awaliyah', '$2y$10$oT76AEPm3KhNZL8XeaEx4Oq3UDXnoMHn9HSnDqUJswM6kKZYpIUdS', 'siswa@gmail.com', 'default.jpg', 1, '2025-08-31', 3, 'siswa'),
('3124368879', 'RIZKI FAUZI', '$2y$10$nHFwP6ErXqGidHY.hgetuOVSjra9Kymhqotd3z9OtiT0S1YHu/J/m', 'siswa@gmail.com', 'default.jpg', 1, '2025-08-31', 2, 'siswa'),
('3128153661', 'MUHAMMAD SYAFIQ ZAKY ISKANDAR', '$2y$10$kA1T7iRRvU9TxxjUCkWAver9MKLplmivM47tkcCB6uF5gKwM5D7gS', 'siswa@gmail.com', 'default.jpg', 1, '2025-08-31', 2, 'siswa'),
('3146882349', 'Laila Khanza Az Zahra', '$2y$10$goromjikkB6FvWBXRVEfnuCN3A4EWBph27b3p6mlnpbJTgrVztFry', 'siswa@gmail.com', 'default.jpg', 1, '2025-08-31', 1, 'siswa'),
('3745065752', 'KARTONO', '$2y$10$XMZKEx4S33.pV15UQUbv7esiGiH9ywctqrgFob1eOpYMQOuLTO1uK', 'siswa@gmail.com', 'default.jpg', 1, '2025-08-31', 2, 'siswa'),
('3749766539', 'ZAINUDIN', '$2y$10$wkcrMIEiAQLl.GcDGBiax.sHqpDpx1Wt2EsOUvgflkzVLasqNfl2.', 'siswa@gmail.com', 'default.jpg', 1, '2025-08-31', 3, 'siswa'),
('3762315024', 'Nurlaela', '$2y$10$m9yeROLq7F3QEejg.kG26eitmuBNqUPliKqFpGqCanPgbtfkkg0K6', 'siswa@gmail.com', 'default.jpg', 1, '2025-08-31', 3, 'siswa'),
('3839354749', 'SYAIPUDIN', '$2y$10$ObXL7MBsOi3ES2EskPRx8.Xvdln37wthrnT8kAdzi/80HX2ejT.06', 'siswa@gmail.com', 'default.jpg', 1, '2025-08-31', 2, 'siswa'),
('3898374246', 'Apiyah', '$2y$10$.CLpK3f3urIaoWrfvDErMeufXajhZLYG1yrXkIPHvQBatuHX2zx.C', 'siswa@gmail.com', 'default.jpg', 1, '2025-08-31', 2, 'siswa'),
('3957922406', 'Dwi Bayu Pribadi', '$2y$10$Eo5Wn/j9yZRMGrjRM6Ei9uS0BuwjWW2ydWm98mV5WT2adPrvRZK8.', 'siswa@gmail.com', 'default.jpg', 1, '2025-08-31', 2, 'siswa'),
('3994681926', 'Khumaeratur Rodhiyah', '$2y$10$mPfp7IeRA0K0BqNNt79H3ON2B38wHlQowaWyDv8w783kCAARf0u1W', 'siswa@gmail.com', 'default.jpg', 1, '2025-08-31', 3, 'siswa'),
('9779152739', 'Jamsuri', '$2y$10$Tz8nPz.eaokWDDO6CzF8WuRM6f0dkjDA0t9CHhfZTkBvTldeRMZqW', 'siswa@gmail.com', 'default.jpg', 1, '2025-08-31', 3, 'siswa'),
('9804913006', 'Mukri', '$2y$10$YIwoKP9ZE05eHCm607XGJOKFDvOLM/3MY8yrk.9Qk.qgjJKj6.FGm', 'siswa@gmail.com', 'default.jpg', 1, '2025-08-31', 3, 'siswa'),
('9996776172', 'Wiji Sanuri', '$2y$10$LsI.GIvvBzJhtm06jeYX8OSZlEX7HecsZnXQNMJn1I3fqbjW6wP2m', 'siswa@gmail.com', 'default.jpg', 1, '2025-08-31', 3, 'siswa');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

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
