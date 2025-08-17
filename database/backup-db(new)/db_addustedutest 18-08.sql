-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 17, 2025 at 07:05 PM
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
(1, 21101140, 1, 1, 'WIN_20241104_17_06_10_Pro3.mp4', '123', ' 212', 'WIN_20231030_13_35_02_Pro1.jpg'),
(2, 21101140, 1, 1, 'WIN_20241104_17_06_10_Pro4.mp4', '13334', ' 1212', 'WIN_20231030_13_35_02_Pro2.jpg'),
(3, 21101141, 2, 1, 'WIN_20241104_17_06_10_Pro5.mp4', 'ssssssssssssssssssssssssssssssssssssssssssssssssss', ' https://www.youtube.com/watch?v=_eDpH4hMW1o&amp;list=RDN9bKBAA22Go&amp;index=27', 'WIN_20231030_13_35_02_Pro3.jpg'),
(5, 21101140, 1, 1, 'WIN_20241104_17_06_10_Pro12.mp4', 'aku', ' aku', 'WIN_20231030_13_35_02_Pro10.jpg'),
(7, 21101140, 2, 1, 'WIN_20241104_17_06_10_Pro13.mp4', 'wcwcwcw', 'cwcwcwc', 'WIN_20231030_13_35_02_Pro11.jpg'),
(9, 21101140, 1, 1, 'WIN_20241104_17_06_10_Pro21.mp4', 'aaa', 'aaa', 'WIN_20231030_13_35_02_Pro19.jpg'),
(10, 21101140, 2, 1, 'WIN_20241104_17_06_10_Pro22.mp4', 'asxasxasx', 'axasxaxasxa', 'WIN_20231030_13_35_02_Pro20.jpg'),
(11, 21101140, 1, 4, 'WIN_20241104_17_06_10_Pro23.mp4', 'test', 'https://www.youtube.com/', 'WIN_20231030_13_35_02_Pro21.jpg'),
(12, 21101140, 1, 4, 'WIN_20241104_17_06_10_Pro20.mp4', 'dqwdw', ' wqdwqd', 'WIN_20231030_13_35_02_Pro18.jpg'),
(13, 21101140, 1, 1, 'https://www.youtube.com/embed/A6TU-WfYARI?rel=0', 'administrasi perkantoran merupakan', 'zoom.id', 'WIN_20231030_13_35_21_Pro.jpg'),
(14, 21101140, 1, 1, 'https://www.youtube.com/embed/cHt-gK9z4v8?rel=0', 'https://www.youtube.com/watch?v=cHt-gK9z4v8', ' https://www.youtube.com/watch?v=cHt-gK9z4v8', 'WIN_20231030_13_35_02_Pro28.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `materi`
--
ALTER TABLE `materi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_guru` (`id_guru`),
  ADD KEY `id_mapel` (`id_mapel`),
  ADD KEY `fk_materi_kelas` (`id_kelas`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `materi`
--
ALTER TABLE `materi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `materi`
--
ALTER TABLE `materi`
  ADD CONSTRAINT `fk_materi_guru` FOREIGN KEY (`id_guru`) REFERENCES `guru` (`nip`),
  ADD CONSTRAINT `fk_materi_mapel` FOREIGN KEY (`id_mapel`) REFERENCES `mata_pelajaran` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
