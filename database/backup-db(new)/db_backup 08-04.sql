-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 08, 2025 at 06:18 PM
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
(47, 123456, 64, 'user', 'sqs', NULL, '2025-03-29 01:00:04', '2025-03-29 14:00:04', NULL, NULL, NULL),
(50, 123456, 43, 'user', '2ed22dqwwdwwd', NULL, '2025-03-29 01:39:20', '2025-03-29 14:39:20', '2025-03-31 15:58:43', NULL, '2025-03-29 09:26:37'),
(57, 0, 90, 'user', 's', NULL, '2025-03-30 00:01:13', '2025-03-30 12:01:13', NULL, NULL, NULL),
(58, 123456, 90, 'user', 'swd', NULL, '2025-03-30 00:01:54', '2025-03-30 12:01:54', NULL, NULL, NULL),
(59, 123456, 90, 'user', 'zzz', 58, '2025-03-30 00:28:45', '2025-03-30 12:28:45', NULL, NULL, NULL),
(61, 123456, 90, 'user', 'sssassd', 59, '2025-03-30 00:36:47', '2025-03-30 12:36:47', NULL, NULL, NULL),
(62, 18883, 90, 'addusttt', 'w', 57, '2025-03-30 01:10:45', '2025-03-30 13:10:45', NULL, NULL, NULL),
(78, 123456, 43, 'user', 'wdqd', NULL, '2025-03-31 08:50:41', '2025-03-31 20:50:41', NULL, NULL, NULL),
(79, 123456, 72, 'user', 'wdwd', NULL, '2025-03-31 08:57:05', '2025-03-31 20:57:05', NULL, NULL, NULL),
(80, 123456, 43, 'user', 'dqwdw', 78, '2025-03-31 08:58:54', '2025-03-31 20:58:54', NULL, NULL, NULL),
(81, 18883, 43, 'addusttt', 'f', 50, '2025-04-04 01:30:44', '2025-04-04 13:30:44', NULL, NULL, NULL),
(82, 123456, 43, 'user', 's', 81, '2025-04-08 08:18:33', '2025-04-08 20:18:33', NULL, NULL, NULL),
(83, 123456, 63, 'user', 'ssqq', NULL, '2025-04-08 09:20:59', '2025-04-08 21:20:59', '2025-04-08 16:28:58', NULL, NULL);

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
(21010240, 'guru1@gmail.com', 'guru terbaik', '$2y$10$5b/MJhDxwMBoOBZ0m4nofOCPrwn9XM/RZu7xuG528R7P71k629SUS', 'Matematika'),
(214748364, 'Dummy@gmail.com', 'Ahmad Saugi', '', 'Pendidikan Agama Islam'),
(214748365, 'zaidanline67@gmail.com', 'Saauky', '$2y$10$3qQ2TYrtQHy44LblPMexnu4ZQrCWD.dYh20P.sOL5cyo6Z48fJQEq', 'Matematika'),
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
(9, 7, 21, 'a', '1.00'),
(10, 8, 22, 'a', '1.00'),
(11, 8, 22, 'a', '1.00'),
(12, 9, 19, 'a', '1.00'),
(13, 9, 20, 'a', '0.00'),
(14, 10, 24, 'a', '1.00'),
(15, 11, 25, 'a', '1.00'),
(16, 11, 26, 'a', '1.00'),
(17, 12, 24, 'b', '0.00'),
(18, 13, 25, 'a', '1.00'),
(19, 13, 26, 'a', '1.00');

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
  `id_guru` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `materi`
--

INSERT INTO `materi` (`id`, `nama_guru`, `nama_mapel`, `video`, `deskripsi`, `kelas`, `linkform`, `modul`, `id_guru`) VALUES
(38, 'Saauky', 'Matematika', 'Matematika_-_Dummy_-_1.mp4', '                                        RG Squad, siapa yang pernah dengar kata aljabar? Ini merupakan satu cabang matematika dalam pemecahan masalah dengan menggunakan huruf-huruf untuk mewakili angka-angka. Berasal dari bahasa Arab, al-jabr yang artinya penyelesaian. Kamu tahu siapa penemunya? Ia merupakan cendikiawan bernama Al-Khawarizmi. Sekarang, mari kita simak lebih lanjut tentang definisi dan bentuk-bentuk aljabar secara lebih mendalam ya! s', 'X', NULL, '', 214748365),
(42, 'Saauky', 'Matematika', 'Matematika_-_Dummy_-_1.mp4', 'Dalam matematika dan ilmu komputer, Aljabar Boolean adalah struktur aljabar yang &quot;mencakup intisari&quot; operasi logika AND, OR, NOR, dan NAND dan juga teori himpunan untuk operasi union, interseksi dan komplemen. Penamaan Aljabar Boolean sendiri berasal dari nama seorang matematikawan asal Inggris, bernama George Boole.', 'X', NULL, '', 214748365),
(43, 'Saauky', 'Matematika', 'WhatsApp_Video_2025-03-11_at_07_52_16_6ef1509519.mp4', '                                                                                Aljabar linear adalah bidang studi matematika yang mempelajari sistem persamaan linear dan solusinya, vektor, serta transformasi linear. Matriks dan operasinya juga merupakan hal yang berkaitan erat dengan bidang aljabar linear.', 'XI', '                                        TEST.COM', 'riyo3.jpg', 214748365),
(44, 'Saauky', 'Matematika', 'Matematika_-_Dummy_3.mp4', 'Vektor merupakan kajian aljabar yang biasanya digunakan untuk memecahkan permasalahan fisika seperti gerak, gaya, dan sebagainya. ... Sebuah vektor bisa dinyatakan dalam bentuk geometri yang digambarkan sebagai sebuah ruas garis dengan arah tertentu dimana salah satunya merupakan pangkal dan satunya lagi merupakan ujung.', 'XI', NULL, '', 214748365),
(45, 'Saauky', 'Matematika', 'Matematika_-_Dummy_4.mp4', 'Vektor dalam matematika dan fisika adalah objek geometri yang memiliki besar dan arah. Vektor jika dilambangkan dengan tanda panah. Besar vektor proporsional dengan panjang panah dan arahnya bertepatan dengan arah panah. Vektor dapat melambangkan perpindahan dari titik A ke B. Vektor sering ditandai sebagai', 'XII', NULL, '', 214748365),
(46, 'Saauky', 'Matematika', 'Matematika_-_Dummy_5.mp4', 'Pecahan, atau disebut fraksi adalah istilah dalam matematika yang terdiri dari pembilang dan penyebut. Hakikat transaksi dalam bilangan pecahan adalah bagaimana cara menyederhanakan pembilang dan penyebut.', 'XII', NULL, '', 214748365),
(47, 'Zaaidan', 'IPA', 'IPA_-_Dummy_1.mp4', 'Fisika adalah salah satu disiplin akademik paling tua, mungkin yang tertua melalui astronomi yang juga termasuk di dalamnya.[6] Lebih dari dua milenia, fisika menjadi bagian dari Ilmu Alam bersama dengan kimia, biologi, dan cabang tertentu matematika, tetapi ketika munculnya revolusi ilmiah pada abad ke-17, ilmu alam berkembang sebagai program penelitian sendiri.[b] Fisika berkembang dengan banyak spesialisasi bidang ilmu lain, seperti biofisika dan kimia kuantum, dan batasan fisiknya tidak didefinisikan dengan jelas. Ilmu baru dalam fisika terkadang digunakan untuk menjelaskan mekanisme dasar sains lainnya[3] serta membuka jalan area penelitian lainnya seperti matematika dan filsafat.', 'X', NULL, '', NULL),
(50, 'Zaaidan', 'IPA', 'IPA_-_Dummy_2.mp4', 'Kristalisasi adalah proses pembentukan bahan padat dari pengendapan larutan, melt, atau lebih jarang pengendapan langsung dari gas. Kristalisasi juga merupakan teknik pemisahan kimia antara bahan padat-cair, di mana terjadi perpindahan massa dari suat zat terlarut dari cairan larutan ke fase kristal padat', 'X', NULL, '', NULL),
(51, 'Zaaidan', 'IPA', 'IPA_-_Dummy_3.mp4', 'Peleburan adalah proses reduksi bijih sehingga menjadi logam unsur yang dapat digunakan berbagai macam zat seperti karbid, hidrogen, logam aktif atau dengan cara elektrolisis. Pemilihan zat pereduksi ini tergantung dari kereaktifan masing-masing zat.', 'XI', NULL, '', NULL),
(52, 'Zaaidan', 'IPA', 'IPA_-_Dummy_4.mp4', 'Pencairan, pelelehan atau Peleburan adalah proses yang menghasilkan perubahan fase zat dari padat ke cair. Energi internal dari zat padat meningkat mencapai temperatur tertentu saat zat ini berubah menjadi cair.Benda yang telah mencair sepenuhnya disebut benda cair.', 'XI', NULL, '', NULL),
(53, 'Zaaidan', 'IPA', 'IPA_-_Dummy_5.mp4', 'Dalam ilmu fisika dan kimia, pembekuan adalah proses di mana cairan berubah menjadi padatan. Titik beku adalah temperatur di mana hal ini terjadi. Peleburan, adalah proses kebalikan dari pembekuan di mana padatan berubah manjadi cairan. Pada sebagian besar zat, titik beku dan titik lebur biasanya sama.', 'XII', NULL, '', NULL),
(54, 'Zaaidan', 'IPA', 'IPA_-_Dummy_6.mp4', 'Teknologi pembekuan makanan adalah teknologi mengawetkan makanan dengan menurunkan temperaturnya hingga di bawah titik beku air.', 'XII', NULL, '', NULL),
(55, 'Khaairan', 'Bahasa Inggris', 'Inggris_-_Dummy_1.mp4', 'Bahasa Inggris adalah bahasa Jermanik yang pertama kali dituturkan di Inggris pada Abad Pertengahan Awal dan saat ini merupakan bahasa yang paling umum digunakan di seluruh dunia.[4] Bahasa Inggris dituturkan sebagai bahasa pertama oleh mayoritas penduduk di berbagai negara, termasuk Britania Raya, Irlandia, Amerika Serikat, Kanada, Australia, Selandia Baru, dan sejumlah negara-negara Karibia; serta menjadi bahasa resmi di hampir 60 negara berdaulat. Bahasa Inggris adalah bahasa ibu ketiga yang paling banyak dituturkan di seluruh dunia, setelah bahasa Mandarin dan bahasa Spanyol.[5] Bahasa Inggris juga digunakan sebagai bahasa kedua dan bahasa resmi oleh Uni Eropa, Negara Persemakmuran, dan Perserikatan Bangsa-Bangsa, serta beragam organisasi lainnya.', 'X', NULL, '', NULL),
(56, 'Khaairan', 'Bahasa Inggris', 'Inggris_-_Dummy_2.mp4', 'Bahasa Inggris berkembang pertama kali di Kerajaan Anglo-Saxon Inggris dan di wilayah yang saat ini membentuk Skotlandia tenggara. Setelah meluasnya pengaruh Britania Raya pada abad ke-17 dan ke-20 melalui Imperium Britania, bahasa Inggris tersebar luas di seluruh dunia.[6][7][8] Di samping itu, luasnya penggunaan bahasa Inggris juga disebabkan oleh penyebaran kebudayaan dan teknologi Amerika Serikat yang mendominasi di sepanjang abad ke-20.[9] Hal-hal tersebut telah menyebabkan bahasa Inggris saat ini menjadi bahasa utama dan secara tidak resmi (de facto) dianggap sebagai lingua franca di berbagai belahan dunia.[10][11]', 'X', NULL, '', NULL),
(57, 'Khaairan', 'Bahasa Inggris', 'Inggris_-_Dummy_3.mp4', 'Menurut sejarahnya, bahasa Inggris berasal dari peleburan beragam dialek terkait, yang saat ini secara kolektif dikenal sebagai bahasa Inggris Kuno, yang dibawa ke pantai timur Pulau Britania oleh pendatang Jermanik (Anglo-Saxons) pada abad ke-5; kata English\' berasal dari nama Angles.[12] Suku Anglo-Saxons ini sendiri berasal dari wilayah Angeln (saat ini Schleswig-Holstein, Jerman). Bahasa Inggris awal juga dipengaruhi oleh bahasa Norse Kuno setelah Viking menaklukkan Inggris pada abad ke-9 dan ke-10.', 'XI', NULL, '', NULL),
(58, 'Khaairan', 'Bahasa Inggris', 'Inggris_-_Dummy_4.mp4', 'Penaklukan Normandia terhadap Inggris pada abad ke-11 menyebabkan bahasa Inggris juga mendapat pengaruh dari bahasa Prancis Norman, dan kosakata serta ejaan dalam bahasa Inggris mulai dipengaruhi oleh bahasa Latin Romawi (meskipun bahasa Inggris sendiri bukanlah rumpun bahasa Romawi),[13][14] yang kemudian dikenal dengan bahasa Inggris Pertengahan. Pergeseran Vokal yang dimulai di Inggris bagian selatan pada abad ke-15 adalah salah satu peristiwa bersejarah yang menandai peralihan bahasa Inggris Pertengahan menjadi bahasa Inggris Modern.', 'XI', NULL, '', NULL),
(59, 'Khaairan', 'Bahasa Inggris', 'Inggris_-_Dummy_5.mp4', 'Selain Anglo-Saxons dan Prancis Norman, sejumlah besar kata dalam bahasa Inggris juga berakar dari bahasa Latin, karena Latin adalah lingua franca Gereja Kristen dan bahasa utama di kalangan intelektual Eropa,[15] dan telah menjadi dasar kosakata bagi bahasa Inggris modern.', 'XII', NULL, '', NULL),
(60, 'Khaairan', 'Bahasa Inggris', 'Inggris_-_Dummy_6.mp4', 'Karena telah mengalami perpaduan beragam kata dari berbagai bahasa di sepanjang sejarah, bahasa Inggris modern memiliki kosakata yang sangat banyak, dengan pengejaan yang kompleks dan tidak teratur (irregular), khususnya vokal. Bahasa Inggris modern tidak hanya merupakan perpaduan dari bahasa-bahasa Eropa, tetapi juga dari berbagai bahasa di seluruh dunia. Oxford English Dictionary memuat daftar lebih dari 250.000 kata berbeda, tidak termasuk istilah-istilah teknis, sains, dan bahasa gaul yang jumlahnya juga sangat banyak.[16][17]', 'XII', NULL, '', NULL),
(61, 'Khairi Firdaus', 'Bahasa Indonesia', 'Indonesia_-_Dummy_1.mp4', 'Bahasa Indonesia adalah bahasa Melayu yang dijadikan sebagai bahasa resmi Republik Indonesia[1] dan bahasa persatuan bangsa Indonesia.[2] Bahasa Indonesia diresmikan penggunaannya setelah Proklamasi Kemerdekaan Indonesia, tepatnya sehari sesudahnya, bersamaan dengan mulai berlakunya konstitusi. Di Timor Leste, bahasa Indonesia berstatus sebagai bahasa kerja.', 'X', NULL, '', NULL),
(62, 'Khairi Firdaus', 'Bahasa Indonesia', 'Indonesia_-_Dummy_2.mp4', 'Dari sudut pandang linguistik, bahasa Indonesia adalah salah satu dari banyak varietas bahasa Melayu.[3] Dasar yang dipakai sebagai dasar bahasa Indonesia baku adalah bahasa Melayu Tinggi (&quot;Riau&quot;).[4][5] Dalam perkembangannya, ia mengalami perubahan akibat penggunaannya sebagai bahasa kerja di lingkungan administrasi kolonial dan berbagai proses pembakuan sejak awal abad ke-20. Penamaan &quot;bahasa Indonesia&quot; diawali sejak dicanangkannya Sumpah Pemuda, 28 Oktober 1928, untuk menghindari kesan &quot;imperialisme bahasa&quot; apabila nama bahasa Melayu tetap digunakan.[6] Proses ini menyebabkan berbedanya bahasa Indonesia saat ini dari varian bahasa Melayu yang digunakan di Riau maupun Semenanjung Malaya. Hingga saat ini, bahasa Indonesia merupakan bahasa yang hidup, yang terus menghasilkan kata-kata baru, baik melalui penciptaan maupun penyerapan dari bahasa daerah dan bahasa asing.', 'X', NULL, '', NULL),
(63, 'Khairi Firdaus', 'Bahasa Indonesia', 'Indonesia_-_Dummy_3.mp4', 'Meskipun dipahami dan dituturkan oleh lebih dari 90% warga Indonesia, bahasa Indonesia bukanlah bahasa ibu bagi kebanyakan penuturnya. Sebagian besar warga Indonesia menggunakan salah satu dari 748 bahasa yang ada di Indonesia sebagai bahasa ibu.[7] Istilah &quot;bahasa Indonesia&quot; paling umum dikaitkan dengan bahasa baku yang digunakan dalam situasi formal.[4] Ragam bahasa baku tersebut berhubungan diglosik dengan bentuk-bentuk bahasa Melayu vernacular yang digunakan sebagai peranti komunikasi sehari-hari.[4] Artinya, penutur bahasa Indonesia kerap kali menggunakan versi sehari-hari (colloquial) dan/atau mencampuradukkan dengan dialek Melayu lainnya atau bahasa ibunya. Meskipun demikian, bahasa Indonesia digunakan sangat luas di perguruan-perguruan, di media massa, sastra, perangkat lunak, surat-menyurat resmi, dan berbagai forum publik lainnya,[8] sehingga dapatlah dikatakan bahwa bahasa Indonesia digunakan oleh semua warga Indonesia.', 'XI', NULL, '', NULL),
(64, 'Khairi Firdaus', 'Bahasa Indonesia', 'Indonesia_-_Dummy_4.mp4', 'Aksara pertama dalam bahasa Melayu atau Jawi ditemukan di pesisir tenggara Pulau Sumatra, menunjukkan bahwa bahasa ini menyebar ke berbagai tempat di Nusantara dari wilayah ini, berkat penggunaannya oleh Kerajaan Sriwijaya yang menguasai jalur perdagangan. Istilah Melayu atau sebutan bagi wilayahnya sebagai Malaya sendiri berasal dari Kerajaan Malayu yang bertempat di Batang Hari, Jambi.', 'XI', NULL, '', NULL),
(65, 'Khairi Firdaus', 'Bahasa Indonesia', 'Indonesia_-_Dummy_5.mp4', 'stilah Melayu atau Malayu berasal dari Kerajaan Malayu, sebuah kerajaan Hindu-Buddha pada abad ke-7 di hulu sungai Batanghari, Jambi di pulau Sumatra, jadi secara geografis semula hanya mengacu kepada wilayah kerajaan tersebut yang merupakan sebagian dari wilayah pulau Sumatra. Dalam perkembangannya, pemakaian istilah Melayu mencakup wilayah geografis yang lebih luas dari wilayah Kerajaan Malayu tersebut, mencakup negeri-negeri di pulau Sumatra sehingga pulau tersebut disebut juga Bumi Melayu seperti disebutkan dalam Kakawin Nagarakretagama.', 'XII', NULL, '', NULL),
(67, 'Khairi Firdaus', 'Bahasa Indonesia', 'Indonesia_-_Dummy_6.mp4', 'Ibu kota Kerajaan Melayu semakin mundur ke pedalaman karena serangan Sriwijaya dan masyarakatnya diaspora keluar Bumi Melayu, belakangan masyarakat pendukungnya yang mundur ke pedalaman berasimilasi ke dalam masyarakat Minangkabau menjadi klan Malayu (suku Melayu Minangkabau) yang merupakan salah satu marga di Sumatra Barat. Sriwijaya berpengaruh luas hingga ke Filipina membawa penyebaran Bahasa Melayu semakin meluas, tampak dalam prasasti Keping Tembaga Laguna.\r\n\r\nBahasa Melayu kuno yang berkembang di Bumi Melayu tersebut berlogat &quot;o&quot; seperti Melayu Jambi, Minangkabau, Kerinci, Palembang dan Bengkulu. Semenanjung Malaka dalam Nagarakretagama disebut Hujung Medini artinya Semenanjung Medini.', 'XII', NULL, '', NULL),
(69, 'Ahmad Saugi', 'Pendidikan Agama Islam', 'Agama_Islam_-_Dummy_-_1.mp4', 'Islam (bahasa Arab: ???????, translit. al-isl?m?, Tentang suara ini dengarkan) adalah salah satu agama dari kelompok agama yang diterima oleh seorang nabi (agama samawi) yang mengajarkan monoteisme tanpa kompromi, iman terhadap wahyu, iman terhadap akhir zaman, dan tanggung jawab.[1] Bersama para pengikut Yudaisme dan Kekristenan, seluruh muslim–pengikut ajaran Islam–adalah anak turun Ibrahim.[2] Islam diikuti oleh 1,8 miliar orang di seluruh dunia sehingga menjadi agama terbesar kedua setelah Kristen.[3]', 'X', NULL, '', 214748364),
(70, 'Ahmad Saugi', 'Pendidikan Agama Islam', 'Agama_Islam_-_Dummy_-_2.mp4', 'Kata “isl?m” berasal dari bahasa Arab aslama - yuslimu dengan arti semantik sebagai berikut: tunduk dan patuh (khadha‘a wa istaslama), berserah diri, menyerahkan, memasrahkan (sallama), mengikuti (atba‘a), menunaikan, menyampaikan (add?), masuk dalam kedamaian, keselamatan, atau kemurnian (dakhala fi al-salm au al-silm au al-sal?m).[4] Dari istilah-istilah lain yang akar katanya sama, “isl?m” berhubungan erat dengan makna keselamatan, kedamaian, dan kemurnian.[5]', 'X', NULL, '', 214748364),
(71, 'Ahmad Saugi', 'Pendidikan Agama Islam', 'Agama_Islam_-_Dummy_-_3.mp4', 'Islam dapat juga disebut dengan iman, millah, dan syariah dalam pengertiannya sebagai aturan yang diturunkan oleh Allah melalui para utusan yang mencakup kepercayaan, keyakinan, adab, akhlak, perintah, dan larangan.[9] Agama Islam berdasarkan kewajiban untuk berserah diri dan menunaikan ajarannya disebut islam; jika dilihat berdasarkan kepercayaan terhadap Allah dan yang Dia turunkan, maka disebut iman; karena Islam itu diktatif dan terdokumentasikan, maka disebut millah; dan karena sumber hukumnya adalah Allah, maka disebut syariah.[9]', 'XI', NULL, '', 214748364),
(72, 'Ahmad Saugi', 'Pendidikan Agama Islam', 'Agama_Islam_-_Dummy_-_4.mp4', 'Allah, menurut ajaran Islam, adalah satu-satunya Tuhan yang berhak disembah, memiliki nama-nama terbaik, dan memiliki sifat dan karakter tertinggi.[11] Ajaran monoteisme Islam disebut tauhid, yang didefinisikan sebagai pengesaan Allah dalam hal-hal yang menjadi kekhususan Tuhan dan yang Dia wajibkan.[12] Pengesaan Allah dalam hal-hal kekhususan Tuhan dibagi menjadi dua bahasan: tauhid rububiyah dan tauhid asma\' wash-shifat, sedangkan pengesaan Allah dalam hal-hal yang Dia wajibkan dibahas dalam tauhid uluhiyah.[13]', 'XI', NULL, '', 214748364),
(73, 'Ahmad Saugi', 'Pendidikan Agama Islam', 'Agama_Islam_-_Dummy_-_4.mp4', 'Dalam tauhid rububiyah, Allah diakui sebagai satu-satunya Rabb (Yang Menguasai), sehingga semua selain Allah adalah ‘abd (hamba/budak/yang dikuasai).[14] Allah adalah Rabb Yang Berkuasa dalam penciptaan, pengurusan, dan kerajaan alam semesta.[15] Allah sebagai satu-satunya Pencipta adalah juga Yang Memberi rezeki, Yang Menghidupkan, Yang Mematikan, serta Yang Memberi kebaikan dan keburukan.[16] Allah yang mengurus segala sesuatu; semua urusan yang Dia tangani adalah kebaikan; dan Allah Mahakuasa terhadap apa yang Dia kehendaki.[16] Dalilnya adalah ayat dalam Alquran, “Segala penciptaan dan urusan menjadi hak-Nya.”[Al-A\'raf:54][15]', 'XII', NULL, '', 214748364),
(76, 'Ahmad Saugi', 'Pendidikan Agama Islam', 'Agama_Islam_-_Dummy_-_6.mp4', 'Islam adalah salah satu agama dari kelompok agama yang diterima oleh seorang nabi yang mengajarkan monoteisme tanpa kompromi, iman terhadap wahyu, iman terhadap akhir zaman, dan tanggung jawab. Bersama para pengikut Yudaisme dan Kekristenan, seluruh muslim–pengikut ajaran Islam–adalah anak turun Ibrahim.', 'XII', NULL, '', 214748364),
(77, 'Saauky', 'Matematika', 'Agama_Islam_-_Dummy_-_6.mp4', 'Test', 'X', NULL, '', 214748365),
(78, 'guru terbaik', 'Matematika', 'WhatsApp_Video_2025-03-11_at_07_52_16_6ef1509531.mp4', 'ewfewwdwdw', 'X', 'https://www.petanikode.com/git-branch/', 'riyo15.jpg', 21010240),
(88, 'guru terbaik', 'Matematika', 'WhatsApp_Video_2025-03-11_at_07_52_16_6ef1509536.mp4', 'xxx', 'XI', 'dwdqwd', '5141-11123-2-PB1.pdf', 21010240),
(89, 'guru terbaik', 'Matematika', '', 'wdwdw', 'XI', 'WDWD', '', 21010240),
(90, 'guru terbaik', 'Matematika', '', 'swdwd', 'XI', 'grgrg', '', 21010240),
(91, 'guru terbaik', 'Matematika', '', 'fwewfawf', 'X', 'dqwdqwdqwdwqd', '', 21010240),
(92, 'guru terbaik', 'Matematika', '', 'wfwefewfewf', 'XI', 'http://localhost/addustedu/admin/add_materi', '', 21010240),
(99, 'guru terbaik', 'Matematika', '', 'wdwdwd', 'X', 'dwdwd', '', 21010240),
(100, 'guru terbaik', 'Matematika', '', 'xxxxx', 'X', 'sqqqs', '', 21010240),
(101, 'guru terbaik', 'Matematika', 'WhatsApp_Video_2025-03-11_at_07_52_16_6ef1509535.mp4', 'sqsqdwdwdwdw', 'X', 'sqs', '4845-17134-1-PB1.pdf', 21010240),
(102, 'guru terbaik', 'Matematika', 'WhatsApp_Video_2025-03-11_at_07_52_16_6ef1509533.mp4', 'dwdw', 'X', ' dwdwd', 'riyo17.jpg', 21010240);

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
(9, 43, 'nasi goreng', 'efwefwefewfwfw', 30, 1, 1, '2025-04-04 09:18:58'),
(10, 88, 'nasi goreng', 'des', 30, 1, 1, '2025-04-06 04:48:32'),
(11, 88, 'dwwddw', 'dwwdwdwd', 30, 1, 1, '2025-04-06 05:08:10'),
(12, 90, 'ewfewfwe', 'wdqd', 30, 1, 1, '2025-04-06 05:58:36'),
(13, 89, 'dwdwd', 'dwwdwd', 30, 1, 1, '2025-04-06 06:02:52'),
(14, 100, 'qsqs', 'dwdw', 30, 1, 1, '2025-04-06 06:25:11');

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
(19, 9, 'fweewewf', 'pilihan', 'efewfw', 'few', 'ewfef', 'feww', 'a', 1),
(20, 9, 'fewew', 'pilihan', 'fwewfw', 'fewfe', 'fewf', 'ewfewf', 'b', 1),
(21, 10, 'fefe', 'pilihan', 'fe', 'eff', 'fef', 'efef', 'a', 1),
(22, 11, 'wdwdwdwd', 'pilihan', 'dwdd', 'wdwd', 'dwdwd', 'dwdwd', 'a', 1),
(23, 10, 'dqwdqwdwq', 'pilihan', 'wdqqwdq', 'dqwqwdqw', 'dqwqd', 'dqwqd', 'a', 4),
(24, 12, 'wdwddwddwd', 'pilihan', 'dwwdw', 'dwwd', 'dwwd', 'dwd', 'a', 1),
(25, 13, 'wdwdw', 'pilihan', 'dwwd', 'dwdw', 'dwdw', 'dwwdw', 'a', 1),
(26, 13, 'edefre', 'pilihan', 'ffefe', 'fwefwfw', 'efewfew', 'fwfew', 'a', 1),
(27, 14, 'wdwdwd', 'pilihan', 'dwwdwd', 'dwwd', 'dwdwd', 'dww', 'a', 1);

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
(7, 10, 123456, '2025-04-06 05:08:49', '2025-04-06 05:09:19', 'completed', '0.00'),
(8, 11, 123456, '2025-04-06 05:09:23', '2025-04-06 05:10:02', 'completed', '100.00'),
(9, 9, 123456, '2025-04-06 05:11:02', '2025-04-06 05:11:09', 'completed', '50.00'),
(10, 12, 123456, '2025-04-06 06:01:00', '2025-04-06 06:01:57', 'completed', '0.00'),
(11, 13, 123456, '2025-04-06 06:03:58', '2025-04-06 06:04:19', 'completed', '100.00'),
(12, 12, 18883, '2025-04-06 06:06:24', '2025-04-06 06:06:27', 'completed', '0.00'),
(13, 13, 18883, '2025-04-06 06:07:03', '2025-04-06 06:07:10', 'completed', '100.00');

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
(0, 'addust', '$2y$10$cYm/i5rWupzWKrc92nX4EublfQgeyyZl4AQyu2e4rbKFQUwc8iv9u', '', 'default.jpg', 1, 1742275981, ''),
(39, 'Syaauqi Zaaidan', '$2y$10$djI2M/FQH2k3H7b6tLK5X.MZG1R.wrARoR6NerH3tsScNnsNCnexa', 'zaidanline67@gmail.com', '73349393_156861225523800_2119508204152772215_n_(1)6.jpg', 1, 1586163321, 'X'),
(47, 'andikafahrezi', '$2y$10$Elu2/9GQ0xS41Q3iLxSet.mOe9fa5HCJaUNw6s6m.v4Gp9YDh3GQu', 'andikafahrezi10@gmail.com', 'default.jpg', 1, 1734259635, 'X'),
(18883, 'addusttt', '$2y$10$X10AlJrzNt6KT6MqPhfTlOsjv5ZKYtj.3YqtNZwLnif0pfUeDzX82', 'addust1@gmail.com', 'default.jpg', 1, 1742454210, 'XI'),
(123456, 'user', '$2y$10$6o.1PVKeTRO9gRBObACpYe8cbkP19daJYQVYNv7v4HnCyqjoLpp96', 'user@gmail.com', 'default.jpg', 1, 1735200089, 'XI'),
(181816, 'qsqwdqwd', '$2y$10$YJppxwZ1JOt3s1/Xf9rgWewsjN8ZIhK1b.F39GcTmVS0uy5oOlhDK', 'testwd@gmail.com', 'default.jpg', 1, 1742296726, 'X'),
(211011, 'addust', '$2y$10$jxtWU6XSRAaV/kU0UqlUeurzzcp9EFVEuXJmwiGUrOSLjK9oSvjB6', '', 'default.jpg', 1, 1742276422, ''),
(232332, 'aasdadee qw', '$2y$10$XGjEhDkyCFYClYrBgClGH.Qou1LLCa4ptAVm2ufTw0ErdITzn9P2K', 'testwewe1@gmail.com', 'default.jpg', 1, 1742295476, ''),
(456789, 'nasi gile', '$2y$10$LwYTyg0Usc1SNcQe50HY3.7ZWcRIy926dKlbLA8bZrWtgFMoTZMvq', '', 'default.jpg', 1, 1739114168, 'XII');

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
(1, 123456, 43, 'uploads/tugas/ef374d594df9289b35e8b51cb4a4a4be.jpg', 'riyo.jpg', 'image/jpeg', 44, 'dwqdqwd', '100.00', '2025-04-07 09:09:01', '2025-04-07 10:33:55'),
(2, 123456, 43, '/5248fd6a96c9b5c6b46cca56d8169779.jpg', 'riyo.jpg', 'image/jpeg', 44, 'kamu baik', '50.00', '2025-04-07 09:32:30', '2025-04-07 10:34:08'),
(3, 123456, 88, 'assets/materi_tugas/4bc3d83074247454dd3cf0aa2787cdd1.jpg', 'riyo (JPG)', 'image/jpeg', 44, 'tidak cukup baik', '40.00', '2025-04-07 10:03:46', '2025-04-08 16:10:27'),
(4, 123456, 63, 'assets/materi_tugas/8e406c56e419f1b5a41d9b93c0a212e1.jpg', 'riyo (JPG)', 'image/jpeg', 44, NULL, NULL, '2025-04-08 16:09:23', NULL);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `jawaban_siswa`
--
ALTER TABLE `jawaban_siswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `materi`
--
ALTER TABLE `materi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT for table `materi_status`
--
ALTER TABLE `materi_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quiz`
--
ALTER TABLE `quiz`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `quiz_questions`
--
ALTER TABLE `quiz_questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `quiz_siswa`
--
ALTER TABLE `quiz_siswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `token`
--
ALTER TABLE `token`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `tugas_siswa`
--
ALTER TABLE `tugas_siswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
-- Constraints for table `tugas_siswa`
--
ALTER TABLE `tugas_siswa`
  ADD CONSTRAINT `tugas_siswa_ibfk_1` FOREIGN KEY (`siswa_id`) REFERENCES `siswa` (`nis`),
  ADD CONSTRAINT `tugas_siswa_ibfk_2` FOREIGN KEY (`materi_id`) REFERENCES `materi` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
