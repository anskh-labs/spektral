-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 11, 2024 at 04:06 AM
-- Server version: 11.2.2-MariaDB
-- PHP Version: 8.2.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `spektral`
--

-- --------------------------------------------------------

--
-- Table structure for table `dbo_dokumentasi_pembinaan`
--

CREATE TABLE `dbo_dokumentasi_pembinaan` (
  `id` int(11) UNSIGNED NOT NULL,
  `permintaan_id` int(11) UNSIGNED DEFAULT NULL,
  `judul` varchar(255) NOT NULL,
  `berita` text NOT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `tanggal` date NOT NULL,
  `is_active` tinyint(4) UNSIGNED NOT NULL DEFAULT 1,
  `create_by` int(11) UNSIGNED DEFAULT NULL,
  `update_by` int(11) UNSIGNED DEFAULT NULL,
  `create_at` int(11) UNSIGNED DEFAULT NULL,
  `update_at` int(11) UNSIGNED DEFAULT NULL,
  `approve_by` int(11) UNSIGNED DEFAULT NULL,
  `approve_at` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `dbo_dokumentasi_pembinaan`
--

INSERT INTO `dbo_dokumentasi_pembinaan` (`id`, `permintaan_id`, `judul`, `berita`, `gambar`, `tanggal`, `is_active`, `create_by`, `update_by`, `create_at`, `update_at`, `approve_by`, `approve_at`) VALUES
(1, NULL, 'Kepala BPS Provinsi Riau, melakukan kunjungan ke beberapa media terkemuka di Provinsi Riau', 'Didampingi tim Humas, Diseminasi dan Agro ST2023. Drs. Misfaruddin M.Si mengawali kunjungannya ke stasiun TVRI Riau, yang beralamat di jalan Durian, Kota Pekanbaru. Disambut dengan hangat oleh Ketua LPP TVRI Stasiun Riau, Darma Setiawan, S.E. beserta jajarannya. Misfaruddin menyampaikan ucapan terima kasih atas kolaborasi yang sudah berjalan baik antara BPS dengan TVRI selama ini. Seluruh Indikator strategis yang dihasilkan oleh BPS Provinsi Riau selalu diberitakan secara berimbang oleh TVRI. <br>Selanjutnya, Misfar juga menyampaikan bahwa BPS Provinsi Riau mempunyai 2 agenda besar yang akan dilaksanakan dalam waktu dekat ini. Agenda besar yang pertama yaitu Forum Konsultasi Publik (FKP) hasil pendataan lapangan Registrasi Sosial Ekonomi (Regsosek) yang saat ini masih dalam tahap pengolahan. FKP Regsosek itu sendiri akan dilaksanakan di Bulan Mei 2023 nanti. Selain itu juga disampaikan agenda besar yang kedua yaitu kegiatan lapangan Sensus Pertanian 2023 yang akan dilaksanakan pada bulan Juni dan Juli. Terkait 2 agenda besar ini, Misfar berharap, TVRI dapat membantu kembali BPS dalam mensosialisasikannya kepada masyarakat. <br>Dengan agenda silaturahmi yang sama, rombongan BPS Provinsi Riau selanjutnya berkunjung ke kantor Riau Pos yang beralamat di Gedung Graha Pena Riau. Diterima oleh Pimpinan Redaksi Firman Agus beserta jajarannya. Selain menyampaikan indikator strategis Provinsi Riau selama tahun 2022 yang sudah dihasilkan oleh BPS, Misfar juga tak lupa meminta dukungan sosialisasi untuk kegiatan FKP Regsosek dan kegiatan lapangan Sensus Pertanian ST2023.<br>Sebelum meninggalkan Gedung Graha Pena, tak lupa Bang Fen, sapaan akrab Firman Agus mengundang BPS untuk dapat mengikuti turnamen badminton yang akan diselenggarakan oleh Riau Pos tanggal 22 Februari yang akan datang.', '1717923387.jpg', '2023-02-07', 1, 2, 2, 1717920581, 1718003962, NULL, NULL),
(2, NULL, 'FGD Potensi Desa Provinsi Riau 2024', 'Pekanbaru (29/02/2024) Pendataan Potensi Desa (Podes 2024) kini hadir kembali di tahun 2024, tepatnya akan dilaksanakan pada Mei 2024. Berbagai persiapan dilakukan dalam rangka meningkatkan sinergi antarlembaga sekaligus memantapkan persiapan pelaksanaan Podes 2024, salah satunya pelaksanaan Focus Group Discussion (FGD) Pendataan Podes yang dilaksanakan pada 29 Februari 2024 di Aula Lantai III BPS Provinsi Riau. FGD yang dihadiri oleh Dinas Pemberdayaan Masyarakat Desa, Kependudukan, dan Pencatatan Sipil Provinsi Riau; Dinas Komunikasi, Informatika, dan Statistik Provinsi; dan 24 dinas/Lembaga di ruang lingkup pemerintahan Provinsi Riau bertujuan untuk mengumpulkan data pendukung Podes yang akan dijadikan sebagai alat kontrol pada evaluasi kualitas data.<br>Pembukaan acara dan diskusi dipimpin langsung oleh Meita Komalasari, SST, M.Si selaku Ketua Tim Statistik Sosial. Pendataan Podes 2024 ini nantinya akan menghasilkan data berbasis kewilayahan yang dimiliki oleh semua tingkatan wilayah administrasi pemerintahan: kabupaten/kota, kecamatan, dan desa/kelurahan. Selain itu, Podes 2024 juga digunakan untuk pembentukan Indeks Kesulitan Geografis (IKG) yang dapat digunakan untuk memetakan wilayah kantong kemiskinan dan untuk pengalokasian dana desa.', '1717920814.jpg', '2024-02-29', 1, 2, 2, 1717920814, 1718003840, NULL, NULL),
(3, NULL, 'FGD Indeks Demokrasi Indonesia (IDI)', 'Pekanbaru (14/03/2024), Indeks Demokrasi Indonesia (IDI) merupakan ukuran pembangunan politik yang digunakan pemerintah pada Rencana Pembangunan Jangka Menengah Nasional (RPJMN) 2010-2014, 2015-2019, serta 2020-2024.<br>IDI adalah <em>Fact-Based Information</em>, karena sebagian besar datanya berasal dari kejadian nyata yang bisa diobservasi dan diintervensi. IDI merupakan kerja bersama instansi pemerintah yaitu Kementrian Koordinator Bidang Politik Hukum dan Keamanan (Kemenkopolhukam), BPS, Badan Perencanaan Pembangunan Nasional (Bappenas), Kementrian Dalam Negeri (Kemendagri), serta Pemerintah Daerah.<br>Penyelanggaran acara Focus Group Discussion IDI yang bertempat di Aula Badan Kesatuan Bangsa dan Politik (Bakesbangpol) Provinsi Riau dihadiri secara langsung oleh Kepala BPS Provinsi Riau, Asep Riyadi dan Kepala Bakesbangpol Provinsi Riau Jenri Salmon Ginting beserta jajarannya.<br>Agenda ini terselenggara sebagai salah satu upaya peningkatan aspek pembentuk IDI, yakni aspek kesetaraan, kebebasan, dan kapasitas lembaga demokrasi.', '1717920913.jpg', '2024-03-14', 1, 2, 2, 1717920913, 1718003848, NULL, NULL),
(4, NULL, 'Bimbingan Teknis Seksi Penjaminan Kualitas Data Kanwil DJP Riau Tahun 2023', 'Pekanbaru (Kamis, 12 Oktober 2023), Kepala BPS Provinsi Riau Bapak Asep Riyadi, S.Si, MM berkesempatan untuk menjadi narasumber dan memberikan paparan materi terkait Perkembangan Ekonomi Riau 2023 dan Prospek 2024 dalam kegiatan Bimbingan Teknis Seksi Penjaminan Kualitas Data Kanwil DJP Riau, dengan tema â€œMelangkah Bersama Dalam Meningkatkan Kualitas Data.â€ Kegiatan ini berlangsung di meeting hall Fox Hotel Pekanbaru.<br>Kegiatan Bimtek yang diusung oleh Kanwil DJP Riau ini menghadirkan jajaran pejabat struktural dalam hal ini Kepala Seksi Penjaminan Kualitas Data dari seluruh KPP Pratama yang tersebar di 8 wilayah kabupaten/kota di Provinsi Riau. Adapun tujuan dari kegiatan Bimtek ini adalah untuk meningkatkan literasi para pejabat yang bertanggungjawab terhadap penjaminan kualitas data di lingkungan KPP Pratama terhadap statistik, baik secara teknis maupun empiris terutama yang berkaitan dengan potensi utama penerimaan pajak di Provinsi Riau, yakni sektor perkebunan sawit dan industri pengolahan. Hal ini sejalan dengan yang disampaikan oleh Ibu Laela Nikulina selaku Kepala Bidang Data Potensi Perpajakan Kanwil DJP Riau pada narasi pembukaan yang beliau sampaikan.<br>Dalam kesempatan ini Kepala BPS Provinsi Riau menyampaikan betapa penting dan strategisnya posisi pajak terhadap pendapatan negara, DJP harus selalu memiliki target terkait apakah penerimaan pajak akan menurun, stagnan, atau meningkat di setiap tahun pajak, berangkat dari hal tersebut juga harus diantisipasi apakah pembiayaan negara akan surplus atau defisit. Dari sisi praktisnya hal ini tentu saja tidak terlepas dari data-data statistik beserta indikator-indikator strategis yang ada di wilayah yang bersangkutan. Dengan lebih dipahaminya makna dari setiap indikator-indikator statistik yang relevan dengan lingkup perpajakan, maka diharapkan potensi penerimaan pajak akan dapat lebih dioptimalkan.', '1717984351.jpg', '2023-10-12', 1, 2, 2, 1717921032, 1718003624, NULL, NULL),
(6, NULL, 'Asep Riyadi Menjadi Narasumber Dalam Acara Milad ke-22 Prodi Matematika UIN SUSKA Riau', 'Pekanbaru (04/06/2024), Dalam rangkaian acara peringatan Milad Program Studi (Prodi) Matematika Fakultas Sains dan Teknologi Universitas Islam Negeri Sultan Syarif Kasim (UIN SUSKA) Riau, Kepala BPS Provinsi Riau Asep Riyadi S.Si., M.M. hadir sebagai narasumber seminar dengan tema â€œPeran Strategis Statistikawan dalam Dunia Industri di Era Digitalâ€ yang berlangsung di Aula Rektorat lantai 5 Kampus UIN SUSKA Riau.<br>Acara dihadiri sekaligus dibuka oleh Wakil Rektor III UIN Suska Riau Prof.Edi Erwan, S.Pt., M.Sc., Ph.D. Dalam pembukaan Milad Prodi Matematika UIN SUSKA Riau yang ke-22 ini beliau menuturkan bahwa Prodi Matematika UIN SUSKA Riau telah mendapatkan Predikat Unggul dan akan terus berupaya untuk menjadi program studi yang berdaya saing. Turut hadir pula Dekan Fakultas Sains dan Teknologi, Dr. Hartono, M.Pd. serta Ketua Prodi Matematika Fakultas Sains dan Teknologi, Wartono, M.Sc.<br>Asep Riyadi dalam paparannya mengajak seluruh mahasiwa yang hadir untuk bangga sebagai mahasiswa Prodi Matematika dan memberi motivasi kepada mahasiswa agar bersiap menghadapi megatrend dunia 2045 pilar pembangunan Indonesia 2045 bertumpu pada pembangunan manusia dan penguasaan IPTEK, pembangunan ekonomi yang berkelanjutan, pemerataan pembangunan, serta pemantapan ketahanan nasional dan tata kelola kepemerintahan. Asep Riyadi juga menjelaskan peran statistisi di era digital serta essential skills yang harus dimiliki mulai dari statistical knowledge, data analysis, AI understanding, serta communication. Kebutuhan akan staistisi di dunia industri semakin menggeliat dengan didorong penggunaan Big Data yang terhubung dengan berbagai kepentingan di banyak sektor.', '1717984431.jpg', '2024-06-04', 1, 2, 2, 1717984431, 1718635567, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `dbo_kategori_modul_literasi`
--

CREATE TABLE `dbo_kategori_modul_literasi` (
  `id` tinyint(4) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `create_at` int(11) UNSIGNED DEFAULT NULL,
  `update_at` int(11) UNSIGNED DEFAULT NULL,
  `create_by` int(11) UNSIGNED DEFAULT NULL,
  `update_by` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `dbo_kategori_modul_literasi`
--

INSERT INTO `dbo_kategori_modul_literasi` (`id`, `nama`, `deskripsi`, `create_at`, `update_at`, `create_by`, `update_by`) VALUES
(1, 'Statistik Sosial', 'Modul ini berisi penjelasan mengenai statistik sosial seperti kesehatan, kemiskinan, pendidikan, kependudukan, dan ketenagakerjaan.', 1717575406, NULL, 2, NULL),
(2, 'Statistik Produksi', 'Modul ini berisi penjelasan mengenai statisti produksi seperti  pertambangan, energi, industri pengolahan, pertanian, kehutanan, peternakan, perikanan, dll.', 1717575406, NULL, 2, NULL),
(3, 'Statistik Distribusi', 'Modul ini berisi penjelasan mengenai statistik distribusi seperti harga, inflasi, pariwisata, perdagangan, transportasi, akomodasi, dll.', 1717575406, NULL, 2, NULL),
(4, 'Statistik Neraca Wilayah dan Analisis Statistik', 'Modul ini berisi penjelasan mengenai statistik neraca willayah seperti pertumbuhan ekonomi, PDRB, IPM, IPG, dll.', 1717575406, NULL, 2, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `dbo_kategori_modul_pembinaan`
--

CREATE TABLE `dbo_kategori_modul_pembinaan` (
  `id` tinyint(4) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `create_at` int(11) UNSIGNED DEFAULT NULL,
  `update_at` int(11) UNSIGNED DEFAULT NULL,
  `create_by` int(11) UNSIGNED DEFAULT NULL,
  `update_by` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `dbo_kategori_modul_pembinaan`
--

INSERT INTO `dbo_kategori_modul_pembinaan` (`id`, `nama`, `deskripsi`, `create_at`, `update_at`, `create_by`, `update_by`) VALUES
(1, 'EPSS - Satu Data Indonesia (SDI)', 'Modul Satu Data Indonesia (SDI) memuat penjelasan tentang tata kelola data pemerintah di Indonesia yang sejalan dengan kebijakan SDI meliputi pengertian, prinsip-prinsip, penyelenggara, dan penyelenggaraan SDI.', 1717575406, NULL, 2, NULL),
(2, 'EPSS - Kualitas Data', 'Modul  Kualitas  Data  memuat  pemahaman  terkait  penjaminan  kualitas, penjelasan terkait quality gates, serta panduan praktis dalam menyusun quality gates pada kegiatan statistik.', 1717575406, NULL, 2, NULL),
(3, 'EPSS - Proses Bisnis Statistik', 'Modul Proses Bisnis Statistik memuat tahapan penyelenggaraan kegiatan survei dan kompilasi produk administrasi statistik dengan menerapkan ketentuan Satu Data Indonesia serta Generic Statistical Process Business Model (GSBPM).', 1717575406, NULL, 2, NULL),
(4, 'EPSS - Kelembagaan', 'Modul Kelembagaan berisikan penjelasan tentang hal-hal apa saja dari sisi kelembagaan yang perlu ditingkatkan oleh setiap institusi dalam menyelenggarakan kegiatan statistik, diantaranya mencakup independensi, profesionalitas, netralitas, objektivitas, dan transparansi.', 1717575406, NULL, 2, NULL),
(5, 'EPSS - Sistem Statistik Nasional (SSN)', 'Modul Sistem Statistik Nasional ini memuat penjelasan tentang Sistem Statistik Nasional (SSN), meliputi pengertian, jenis-jenis statistik, dan kegiatan statistic, serta penjelasan tentang penyelenggaraan kegiatan statistik.', 1722218286, NULL, 2, NULL),
(6, 'Desa/Kelurahan Cinta Statistik', 'Modul Desa/Kelurahan Cinta Statistik berisi penjelasan terkait pembinaan statistik di pemerinahan desa/kelurahan.', 1722218286, NULL, 2, NULL),
(7, 'Umum dan Peraturan', 'Modul Umum dan Peraturan berisi penjelasan mengenai dasar hukum dan peraturan terkait pembinaan statistik, selain itu juga memuat modul yang umum yang tidak diklasifikasikan ke kategori yang ada.', 1722218286, NULL, 2, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `dbo_migrations`
--

CREATE TABLE `dbo_migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `action` varchar(20) NOT NULL,
  `create_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `dbo_migrations`
--

INSERT INTO `dbo_migrations` (`id`, `migration`, `action`, `create_at`) VALUES
(1, 'm0001_user.php', 'up', '2024-02-12 05:08:26'),
(2, 'm0001_user.php', 'seed', '2024-02-12 05:08:26'),
(3, 'm0002_modul.php', 'up', '2024-02-13 04:14:41'),
(4, 'm0003_testimoni.php', 'up', '2024-02-26 07:43:27'),
(5, 'm0003_testimoni.php', 'seed', '2024-02-26 07:48:35'),
(6, 'm0004_modul_category.php', 'up', '2024-05-28 09:40:04'),
(7, 'm0005_pembinaan.php', 'up', '2024-06-04 02:36:26'),
(8, 'm0006_pembinaan_category.php', 'up', '2024-06-04 02:55:32'),
(9, 'm0007_status_permintaan.php', 'up', '2024-06-04 03:21:22'),
(10, 'm0006_pembinaan_category.php', 'seed', '2024-06-04 03:21:31'),
(11, 'm0007_status_permintaan.php', 'seed', '2024-06-04 03:21:31'),
(12, 'm0008_pembinaan_message.php', 'up', '2024-06-05 07:22:28'),
(13, 'm0009_email_template.php', 'up', '2024-06-05 07:50:16'),
(15, 'm0009_email_template.php', 'seed', '2024-06-05 08:15:59'),
(16, 'm0004_modul_category.php', 'seed', '2024-06-05 08:16:46'),
(17, 'm0010_dokumentasi_pembinaan.php', 'up', '2024-06-07 10:41:01');

-- --------------------------------------------------------

--
-- Table structure for table `dbo_model_pembinaan`
--

CREATE TABLE `dbo_model_pembinaan` (
  `id` tinyint(4) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `create_at` int(11) UNSIGNED NOT NULL,
  `update_at` int(11) UNSIGNED DEFAULT NULL,
  `create_by` int(10) UNSIGNED DEFAULT NULL,
  `update_by` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `dbo_model_pembinaan`
--

INSERT INTO `dbo_model_pembinaan` (`id`, `nama`, `create_at`, `update_at`, `create_by`, `update_by`) VALUES
(1, 'Pertemuan virtual/daring', 1717471291, NULL, 2, NULL),
(2, 'Pertemuan langsung dalam bentuk rapat', 1717471291, NULL, 2, NULL),
(3, 'Pertemuan langsung dalam bentuk FGD', 1717471291, NULL, 2, NULL),
(4, 'Pertemuan langsung dalam bentuk Musrenbang', 1717471291, NULL, 2, NULL),
(5, 'Pertemuan langsung lainnya', 1717471291, NULL, 2, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `dbo_modul_gsbpm`
--

CREATE TABLE `dbo_modul_gsbpm` (
  `id` tinyint(4) UNSIGNED NOT NULL,
  `tahapan` varchar(255) NOT NULL,
  `isi` text NOT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `create_by` int(11) UNSIGNED DEFAULT NULL,
  `update_by` int(11) UNSIGNED DEFAULT NULL,
  `create_at` int(11) UNSIGNED DEFAULT NULL,
  `update_at` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `dbo_modul_gsbpm`
--

INSERT INTO `dbo_modul_gsbpm` (`id`, `tahapan`, `isi`, `gambar`, `link`, `create_by`, `update_by`, `create_at`, `update_at`) VALUES
(0, 'Proses Bisnis Statistik', '<p style=\"text-align: justify;\"><i>Generic Statistical Business Process Model (GSBPM)</i> merupakan kumpulan aktivitas berkaitan dan terstruktur untuk mengubah data input menjadi informasi statistik yang disajikan melalui produk fisik maupun digital. GSBPM pertama kali dikembangkan oleh UNECE/Eurostat/OECD Group on Statistics Metadata (METIS) berdasarkan pada model yang biasa digunakan oleh Statistics Selandia Baru. GSBPM diadopsi secara luas dan menjadi rujukan komunitas statistik di dunia, salah satunya oleh Badan Pusat Statistik selaku National Statistics Office (NSO) di Indonesia dalam bentuk Satu Data Indonesia sesuai dengan Perpres No. 39 Tahun 2019. Dengan penerapan rangkaian tahapan dan aktivitas dalam penyelenggaran kegiatan statistik sesuai tahapan SDI maupun GSBPM dapat mewujudkan cita-cita Sistem Statistik Nasional (SSN) dalam mendukung pembangunan nasional. Terdapat 8 (delapan) tingkatan dalam model proses bisnis kegiatan statistik ini : 1) <i>Specify Needs</i>, 2) <i>Design</i>, 3) <i>Build</i>, 4) <i>Collect</i>, 5) <i>Process</i>, 6) <i>Analyse</i>, 7) <i>Disseminate</i>, dan 8) <i>Evaluate</i>.</p>', 'gsbpm.gif', NULL, 2, NULL, 1723103020, NULL),
(1, '1 - Specify Needs', '<p style=\"text-align: justify;\">Fase <i>Specify Needs</i> terdiri dari beberapa sub-process sebagai berikut :</p><ol style=\"list-style: decimal;\"><li>Mengidentifikasi Kebutuhan Dapat ditentukan berdasarkan perumusan masalah yang dikembangkan.</li><li>Konsultasi & Konfirmasi Kebutuhan Tersedia informasi kebutuhan data hasil konfirmasi dengan pihak terkait.</li><li>Minnetonka Tujuan Dapat berupa output dalam bentuk data atau indikator statistik yang diperlukan.</li><li>Identifikasi Konsep & Definisi: Rincian definisi variabel, manfaat, dan darimana diperoleh. Dapat merujuk pada Glosarium yang terdapat pada Website indah.bps.go.id</li><li>Memeriksa ketersediaan data Info ketersediaan data (misalnya pada instansi lain), dapat diperiksa pada website maupun publikasi terkait.</li><li>Membuat TOR atau proposal kegiatan Periksa apakah anggaran tersedia.</li></ol>', NULL, 'specify-needs.pdf', 2, NULL, 1723103306, NULL),
(2, '2 - Design', '<p style=\"text-align: justify;\">Fase <i>Design</i> terdiri dari beberapa sub-process sebagai berikut :</p><ol style=\"list-style: decimal;\"><li>Merancang output Tentukan output yang akan dihasilkan seperti tabel, grafik, dan analisis mengenai data.</li><li>Merancang deskripsi variabel Pastikan tersedia konsep, defiisi, ukuran, satuan, dan klasifikasi.</li><li>Merancang pengumpulan data Tentukan metode pengumpulan data yang akan digunakan.</li><li>Merancang kerangka sampel Tentukan kerangka sampel, jumlah sampel, alokasi sampel unit analisis.</li><li>Merancang metode pengambilan sampel Metode pengambilan sampel terdiri dari dua jenis, yaitu <i>probability sampling</i> dan <i>non-probability sampling</i>.</li><li>Merancang pengolahan dan analisis Meliputi rancangan pengkodean (coding), editing, imputasi, estimasi, pengintegrasian, validasi, dan finalisasi data.</li><li>Merancang sistem dan alur kerja Merancang alur kerja mulai dari pengumpulan data sampai dengan diseminasi beserta penjelasan rinci pada setiap proses.</li></ol>', NULL, 'design-and-build.pdf', 2, NULL, 1723103394, NULL),
(3, '3 - Build', '<p style=\"text-align: justify;\">Fase <i>Build</i> terdiri dari beberapa sub-process sebagai berikut :</p><ol style=\"list-style: decimal;\"><li>Membuat instrumen pengumpulan data (kuesioner): Menentukan jenis serta urutan pertanyaan.</li><li>Membangun komponen proses dan diseminasi: Membangun alat yang akan digunakan untuk proses data, juga komponen penyusun diseminasi.</li><li>Menguji sistem, instrumen, dan proses bisnis statistik: Melakukan uji validitas dan uji reliabilitas kuesioner.</li><li>Memastikan alur kerja berjalan dengan baik.</li><li>Finalisasi sistem.</li></ol>', NULL, 'design-and-build.pdf', 2, NULL, 1723103443, NULL),
(4, '4 - Collect', '<p style=\"text-align: justify;\">Fase <i>Collect</i> terdiri dari beberapa sub-process sebagai berikut :</p><ol style=\"list-style: decimal;\"><li>Membangun kerangka sampel dan pemilihan sampel: Memilih sampel (jika menggunakan sampel).</li><li>Mempersiapkan pengumpulan data melalui pelatihan petugas: Mempersiapkan petugas yang andal sesuai SOP dan memahami konsep dan definisi.</li><li>Melakukan pengumpulan data Pelaksanaan pengumpulan data.</li><li>Finalisasi pengumpulan data: Dilakukan pengecekan untuk menghindari kesalahan.</li></ol>', NULL, 'collect.pdf', 2, NULL, 1723103500, NULL),
(5, '5 - Process', '<p style=\"text-align: justify;\">Fase <i>Process</i> terdiri dari beberapa sub-process sebagai berikut :</p><ol style=\"list-style: decimal;\"><li>Integrasi data: Melakukan entri data dan mengintegrasikan data yang telah dikumpulkan.</li><li>Penyuntingan (editing), penyahihan (validation), dan imputasi: Melakukan cleaning data, imputasi (jika perlu).</li><li>Menghitung penimbang (weight): Supaya karakteristik populasi dapat terukur secara baik, maka digunakanlah penimbang/bobot (weight). Penimbang (weight) adalah suatu nilai yang menyatakan seberapa besar unit sampel mewakili karakteristik populasinya.</li><li>Melakukan estimasi dan agregasi: Finalisasi dataset/data mikro yang dihasilkan.</li></ol>', NULL, 'process.pdf', 2, NULL, 1723103552, NULL),
(6, '6 - Analyse', '<p style=\"text-align: justify;\">Fase <i>Analyse</i> terdiri dari beberapa sub-process sebagai berikut :</p><ol style=\"list-style: decimal;\"><li>Menyiapkan naskah output (tabulasi): Data mentah <i>(raw data)</i> telah ditransformasi sesuai dengan output ataupun indikator yang akan ditampilkan.</li><li>Penyahihan output (pemeriksaan konsistensi antartabel): Validasi dilakukan dengan cara membandingkan antara hasil yang diharapkan dengan output yang dihasilkan.</li><li>Interpretasi output: Menafsir dan menjelaskan output dengan menggunakan analisis statistik yang telah direncanakan pada tahap sebelumnya.</li><li>Penerapan Disclosure Control: Memastikan bahwa data dan metadata yang akan dipublikasikan tidak melanggar kerahasiaan.</li><li>Finalisasi output.</li></ol>', NULL, 'analyse.pdf', 2, NULL, 1723103609, NULL),
(7, '7 - Disseminate', '<p style=\"text-align: justify;\">Fase <i>Disseminate</i> terdiri dari beberapa sub-process sebagai berikut :</p><ol style=\"list-style: decimal;\"><li>Sinkronisasi antara data dengan metadata: Keseluruhan informasi akan kegiatan statistik dikumpulkan menjadi metadata kegiatan statistik.</li><li>Menghasilkan produk diseminasi proses pengemasan dan penyajian agar dapat dimanfaatkan oleh pengguna data.</li><li>Manajemen rilis produk diseminasi: Pengelolaan rilis produk statistik meliputi penyiapan jadwal dan sarana penyebaran informasi akan produk statistik yang dirilis organisasi, penyediaan produk ke pengguna data, termasuk juga pengaturan mekanisme pembagian akses data yang bersifat rahasia kepada pemangku kepentingan tertentu.</li><li>Mempromosikan produk diseminasi: Langkah aktif untuk memperkenalkan ke khalayak seluas mungkin tentang produk-produk statistik yang telah dihasilkan.</li><li>Manajemen user support: Menyediakan layanan pendukung tambahan untuk memenuhi kebutuhan pengguna data.</li></ol>', NULL, 'disseminate-and-evaluate.pdf', 2, NULL, 1723103650, NULL),
(8, '8 - Evaluate', '<p style=\"text-align: justify;\">Fase <i>Evaluate</i> terdiri dari beberapa sub-process sebagai berikut :</p><ol style=\"list-style: decimal;\"><li>Mengumpulkan masukan evaluasi: Materi atau bahan evaluasi dapat dikumpulkan pada tiap tahapan, mulai dari perencanaan hingga penyebarluasan. Masukan dapat berupa saran dari pengguna data, umpan balik kepuasan pengguna data, saran dari petugas, dsb..</li><li>Evaluasi hasil: Laporan Evaluasi berisi berbagai kendala yang ditemui beserta rekomendasi solusi perbaikan yang diperlukan.</li></ol>', NULL, 'disseminate-and-evaluate.pdf', 2, NULL, 1723103690, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `dbo_modul_literasi`
--

CREATE TABLE `dbo_modul_literasi` (
  `id` int(11) UNSIGNED NOT NULL,
  `nama` varchar(100) NOT NULL,
  `deskripsi` text NOT NULL,
  `kategori` tinyint(4) UNSIGNED NOT NULL,
  `link` varchar(255) NOT NULL,
  `is_active` int(4) UNSIGNED NOT NULL DEFAULT 0,
  `create_by` int(11) UNSIGNED DEFAULT NULL,
  `update_by` int(11) UNSIGNED DEFAULT NULL,
  `create_at` int(11) UNSIGNED DEFAULT NULL,
  `update_at` int(11) UNSIGNED DEFAULT NULL,
  `approve_by` int(11) UNSIGNED DEFAULT NULL,
  `approve_at` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `dbo_modul_literasi`
--

INSERT INTO `dbo_modul_literasi` (`id`, `nama`, `deskripsi`, `kategori`, `link`, `is_active`, `create_by`, `update_by`, `create_at`, `update_at`, `approve_by`, `approve_at`) VALUES
(1, 'DUMMY MODUL 1', 'Modul ini berisi Metodologi Sensus dan Survei', 1, 'DUMMY_MODUL_1.pdf', 0, 2, 2, 1708932736, 1718173670, NULL, NULL),
(2, 'DUMMY MODUL 2', 'Modul ini berisi Pengisian dan Evaluasi Metadata Statistik', 1, 'DUMMY_MODUL_2.pdf', 0, 2, 2, 1708932736, 1718640631, NULL, NULL),
(3, 'DUMMY MODUL 3', 'Modul ini berisi Statistik Sektoral 1 - Sosialisasi 26072023', 1, 'DUMMY_MODUL_3.pdf', 0, 2, NULL, 1708932736, NULL, NULL, NULL),
(16, 'DUMMY MODUL 16', 'Modul ini berisi Pemanfaatan Data Pendidikan', 2, 'DUMMY_MODUL_16.pdf', 0, 2, NULL, 1708932736, NULL, NULL, NULL),
(17, 'DUMMY MODUL 17', 'Modul ini berisi Statistik Hortikultura', 2, 'DUMMY_MODUL_17.pdf', 0, 2, NULL, 1708932736, NULL, NULL, NULL),
(18, 'DUMMY MODUL 18', 'Modul ini berisi Statistik Ketenagakerjaan', 2, 'DUMMY_MODUL_18.pdf', 0, 2, NULL, 1708932736, NULL, NULL, NULL),
(31, 'DUMMY MODUL 31', 'Modul ini berisi Modul Indikator Konstruksi Triwulanan_Riau', 3, 'DUMMY_MODUL_31.pdf', 0, 2, NULL, 1708932736, NULL, NULL, NULL),
(32, 'DUMMY MODUL 32', 'Modul ini berisi Kerangka sampel area', 3, 'DUMMY_MODUL_32.pdf', 0, 2, 2, 1708932736, 1718173786, NULL, NULL),
(34, 'DUMMY MODUL 34', 'Modul ini berisi Statistik Distribusi Ekspor', 4, 'DUMMY_MODUL_34.pdf', 0, 2, NULL, 1708932736, NULL, NULL, NULL),
(35, 'DUMMY MODUL 35', 'Modul ini berisi Statistik Distribusi Impor', 4, 'DUMMY_MODUL_35.pdf', 0, 2, NULL, 1708932736, NULL, NULL, NULL),
(36, 'DUMMY MODUL 36', 'Modul ini berisi Statistik Distribusi Perdagangan Dalam Negeri', 4, 'DUMMY_MODUL_36.pdf', 0, 2, NULL, 1708932736, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `dbo_modul_pembinaan`
--

CREATE TABLE `dbo_modul_pembinaan` (
  `id` int(11) UNSIGNED NOT NULL,
  `nama` varchar(100) NOT NULL,
  `deskripsi` text NOT NULL,
  `kategori` tinyint(4) UNSIGNED NOT NULL,
  `link` varchar(255) NOT NULL,
  `is_active` tinyint(4) UNSIGNED NOT NULL DEFAULT 0,
  `create_by` int(11) UNSIGNED DEFAULT NULL,
  `update_by` int(11) UNSIGNED DEFAULT NULL,
  `create_at` int(11) UNSIGNED DEFAULT NULL,
  `update_at` int(11) UNSIGNED DEFAULT NULL,
  `approve_by` int(11) UNSIGNED DEFAULT NULL,
  `approve_at` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `dbo_modul_pembinaan`
--

INSERT INTO `dbo_modul_pembinaan` (`id`, `nama`, `deskripsi`, `kategori`, `link`, `is_active`, `create_by`, `update_by`, `create_at`, `update_at`, `approve_by`, `approve_at`) VALUES
(1, 'Metodologi Sensus dan Survei', 'Modul ini berisi Metodologi Sensus dan Survei', 1, '1702348658_e88bec1145b5994d80ad.pdf', 0, 2, 2, 1708932736, 1718173670, NULL, NULL),
(2, 'Pengisian dan Evaluasi Metadata Statistik', 'Modul ini berisi Pengisian dan Evaluasi Metadata Statistik', 1, '1702880333_37a72a2c14dbb85c67ac.pdf', 0, 2, 2, 1708932736, 1718640631, NULL, NULL),
(3, 'Statistik Sektoral 1 - Sosialisasi 26072023', 'Modul ini berisi Statistik Sektoral 1 - Sosialisasi 26072023', 1, '1702881087_51677e187ca841657f4f.pdf', 0, 2, NULL, 1708932736, NULL, NULL, NULL),
(4, 'Statistik Sektoral 3 - Formulir New Romantik', 'Modul ini berisi Statistik Sektoral 3 - Formulir New Romantik', 1, '1702881490_1fe2c15526dc121f065f.pdf', 0, 2, NULL, 1708932736, NULL, NULL, NULL),
(5, 'Statistik Sektoral 4 - Panduan Aplikasi Romantik (Pengguna)', 'Modul ini berisi Statistik Sektoral 4 - Panduan Aplikasi Romantik (Pengguna)', 1, '1702881728_87feed7a5005a8fe75b3.pdf', 0, 2, NULL, 1708932736, NULL, NULL, NULL),
(6, 'Statistik Sektoral 5 - Panduan Pemeriksaan Romantik 30052023', 'Modul ini berisi Statistik Sektoral 5 - Panduan Pemeriksaan Romantik 30052023', 1, '1702881790_9a88601f98436493acc8.pdf', 0, 2, NULL, 1708932736, NULL, NULL, NULL),
(7, 'Statistik Sektoral 6 - Pemeriksaan Metodologi_Romantik', 'Modul ini berisi Statistik Sektoral 6 - Pemeriksaan Metodologi_Romantik', 1, '1702882444_2fd721bf6f7d0c7ac45c.pdf', 0, 2, NULL, 1708932736, NULL, NULL, NULL),
(8, 'Statistik Sektoral 7 - Sosialisasi Perubahan Aplikasi Romantik', 'Modul ini berisi Statistik Sektoral 7 - Sosialisasi Perubahan Aplikasi Romantik', 1, '1702882459_76c5cfde6c5c22966ebc.pdf', 0, 2, NULL, 1708932736, NULL, NULL, NULL),
(9, 'Koordinasi Metadata 1 - Metadata Statistik', 'Modul ini berisi Koordinasi Metadata 1 - Metadata Statistik', 1, '1702884236_487f385af7ace62e1981.pdf', 0, 2, NULL, 1708932736, NULL, NULL, NULL),
(10, 'Koordinasi Metadata 3 - Forum Satu Data Tingkat Daerah', 'Modul ini berisi Koordinasi Metadata 3 - Forum Satu Data Tingkat Daerah', 1, '1702884292_6f429fa2eb1003dfe0b4.pdf', 0, 2, NULL, 1708932736, NULL, NULL, NULL),
(11, 'Koordinasi Metadata 2- Input Metadata', 'Modul ini berisi Koordinasi Metadata 2- Input Metadata', 1, '1702884412_7df0d5fd878588ca7a21.pdf', 0, 2, NULL, 1708932736, NULL, NULL, NULL),
(12, 'Koordinasi Metadata 4 - Strategi Penguatan Statistik Sektoral', 'Modul ini berisi Koordinasi Metadata 4 - Strategi Penguatan Statistik Sektoral', 1, '1702884446_65cbfc480f4e51739e2a.pdf', 0, 2, NULL, 1708932736, NULL, NULL, NULL),
(13, 'Metadata', 'Modul ini berisi Metadata', 1, '1705974774_9f8fd723db4ffb7a82a7.pdf', 0, 2, NULL, 1708932736, NULL, NULL, NULL),
(14, 'Modul pengumpulan dan pengolahan data', 'Modul ini berisi Modul pengumpulan dan pengolahan data', 1, '1705974982_a7a3e21fc38342dd34d4.pdf', 0, 2, NULL, 1708932736, NULL, NULL, NULL),
(15, 'Perka BPS No.5 th 2020', 'Modul ini berisi Perka BPS No.5 th 2020', 1, '1705975298_6e7703e78de54a7a05f5.pdf', 0, 2, NULL, 1708932736, NULL, NULL, NULL),
(16, 'Pemanfaatan Data Pendidikan', 'Modul ini berisi Pemanfaatan Data Pendidikan', 2, '1702365510_95c86d6c53dfc9ab4875.pdf', 0, 2, NULL, 1708932736, NULL, NULL, NULL),
(17, 'Statistik Hortikultura', 'Modul ini berisi Statistik Hortikultura', 2, '1702366452_289d3f19e8b55e9c3191.pdf', 0, 2, NULL, 1708932736, NULL, NULL, NULL),
(18, 'Statistik Ketenagakerjaan', 'Modul ini berisi Statistik Ketenagakerjaan', 2, '1702366527_f98b1557d91efa210822.pdf', 0, 2, NULL, 1708932736, NULL, NULL, NULL),
(19, 'Statistik Kependudukan', 'Modul ini berisi Statistik Kependudukan', 2, '1702366553_0eac2c68589699e01b1d.pdf', 0, 2, NULL, 1708932736, NULL, NULL, NULL),
(20, 'Pengantar Modal Sosial', 'Modul ini berisi Pengantar Modal Sosial', 2, '1702370171_c1c34197175fc85f6086.pdf', 0, 2, NULL, 1708932736, NULL, NULL, NULL),
(21, 'Statistik Sektoral 6 - Pemeriksaan Metodologi_Romantik', 'Modul ini berisi Statistik Sektoral 6 - Pemeriksaan Metodologi_Romantik', 2, '1702882083_cbf24646ae1f1a9a1cef.pdf', 0, 2, NULL, 1708932736, NULL, NULL, NULL),
(22, 'Modul Indeks Kebahagiaan_Riau', 'Modul ini berisi Modul Indeks Kebahagiaan_Riau', 2, '1705563199_609134fc3a270d0ceb75.pdf', 0, 2, NULL, 1708932736, NULL, NULL, NULL),
(23, 'Modul IPM_Riau', 'Modul ini berisi Modul IPM_Riau', 2, '1705563284_01b03e18f495ee401fe4.pdf', 0, 2, NULL, 1708932736, NULL, NULL, NULL),
(24, 'Modul Kemiskinan_Riau_compressed', 'Modul ini berisi Modul Kemiskinan_Riau_compressed', 2, '1705563309_472caeb25ad3c54b0e26.pdf', 0, 2, NULL, 1708932736, NULL, NULL, NULL),
(25, 'Modul Parameter Demografi PROYEKSI PENDUDUK_Riau_compressed', 'Modul ini berisi Modul Parameter Demografi PROYEKSI PENDUDUK_Riau_compressed', 2, '1705563350_beac70b90c58e73cfd12.pdf', 0, 2, NULL, 1708932736, NULL, NULL, NULL),
(26, 'Modul Parameter Demografi MORTALITAS_rIAU_compressed', 'Modul ini berisi Modul Parameter Demografi MORTALITAS_rIAU_compressed', 2, '1705563383_da667e1919924e2337e6.pdf', 0, 2, NULL, 1708932736, NULL, NULL, NULL),
(27, 'Modul Parameter Demografi FERTILITAS_Riau_compressed', 'Modul ini berisi Modul Parameter Demografi FERTILITAS_Riau_compressed', 2, '1705563411_8acb4f15ecabfab9e517.pdf', 0, 2, NULL, 1708932736, NULL, NULL, NULL),
(28, 'Modul Indeks Demokrasi Indonesia', 'Modul ini berisi Modul Indeks Demokrasi Indonesia', 2, '1705563710_dd75ec09e6cf26f95d14.pdf', 0, 2, NULL, 1708932736, NULL, NULL, NULL),
(31, 'Modul Indikator Konstruksi Triwulanan_Riau', 'Modul ini berisi Modul Indikator Konstruksi Triwulanan_Riau', 3, '1705993763_99f493ddbfe804926189.pdf', 0, 2, NULL, 1708932736, NULL, NULL, NULL),
(32, 'Kerangka sampel area', 'Modul ini berisi Kerangka sampel area', 3, '1718173786.pdf', 0, 2, 2, 1708932736, 1718173786, NULL, NULL),
(34, 'Statistik Distribusi Ekspor', 'Modul ini berisi Statistik Distribusi Ekspor', 4, '1702366494_93900220e9d32ac6c875.pdf', 0, 2, NULL, 1708932736, NULL, NULL, NULL),
(35, 'Statistik Distribusi Impor', 'Modul ini berisi Statistik Distribusi Impor', 4, '1702369774_731fad68087ecba6ce00.pdf', 0, 2, NULL, 1708932736, NULL, NULL, NULL),
(36, 'Statistik Distribusi Perdagangan Dalam Negeri', 'Modul ini berisi Statistik Distribusi Perdagangan Dalam Negeri', 4, '1702370104_1be2a628e6c7e5c3c569.pdf', 0, 2, NULL, 1708932736, NULL, NULL, NULL),
(37, 'Statistik Distribusi Transportasi', 'Modul ini berisi Statistik Distribusi Transportasi', 4, '1702371354_9501ad17bf2d0394d4e6.pdf', 0, 2, NULL, 1708932736, NULL, NULL, NULL),
(38, 'Modul PDRB_Riau', 'Modul ini berisi Modul PDRB_Riau', 4, '1705974134_79bc55ccb3ed2a955a69.pdf', 0, 2, NULL, 1708932736, NULL, NULL, NULL),
(39, 'Pertumbuhan Ekonomi', 'Modul ini berisi Pertumbuhan Ekonomi', 4, '1705974382_319ff957395f98294084.pdf', 0, 2, NULL, 1708932736, 1717406508, NULL, NULL),
(47, 'DUMMY MODUL 47', 'Modul ini berisi Metodologi Sensus dan Survei', 5, 'DUMMY_MODUL_47.pdf', 0, 2, 2, 1708932736, 1718173670, NULL, NULL),
(48, 'DUMMY MODUL 48', 'Modul ini berisi Pengisian dan Evaluasi Metadata Statistik', 5, 'DUMMY_MODUL_48.pdf', 0, 2, 2, 1708932736, 1718640631, NULL, NULL),
(49, 'DUMMY MODUL 49', 'Modul ini berisi Statistik Sektoral 1 - Sosialisasi 26072023', 5, 'DUMMY_MODUL_49.pdf', 0, 2, NULL, 1708932736, NULL, NULL, NULL),
(50, 'DUMMY MODUL 50', 'Modul ini berisi Pemanfaatan Data Pendidikan', 6, 'DUMMY_MODUL_50.pdf', 0, 2, NULL, 1708932736, NULL, NULL, NULL),
(51, 'DUMMY MODUL 51', 'Modul ini berisi Statistik Hortikultura', 6, 'DUMMY_MODUL_51.pdf', 0, 2, NULL, 1708932736, NULL, NULL, NULL),
(52, 'DUMMY MODUL 52', 'Modul ini berisi Statistik Ketenagakerjaan', 6, 'DUMMY_MODUL_52.pdf', 0, 2, NULL, 1708932736, NULL, NULL, NULL),
(53, 'DUMMY MODUL 53', 'Modul ini berisi Modul Indikator Konstruksi Triwulanan_Riau', 7, 'DUMMY_MODUL_53.pdf', 0, 2, NULL, 1708932736, NULL, NULL, NULL),
(54, 'DUMMY MODUL 54', 'Modul ini berisi Kerangka sampel area', 7, 'DUMMY_MODUL_54.pdf', 0, 2, 2, 1708932736, 1718173786, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `dbo_permintaan`
--

CREATE TABLE `dbo_permintaan` (
  `id` int(11) UNSIGNED NOT NULL,
  `produsen_data` tinyint(4) UNSIGNED NOT NULL DEFAULT 1,
  `deskripsi` varchar(255) NOT NULL,
  `model_pembinaan` tinyint(4) UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `waktu` time NOT NULL,
  `lokasi` varchar(255) NOT NULL,
  `surat` varchar(255) NOT NULL,
  `email_pic` varchar(255) NOT NULL,
  `nama_pic` varchar(100) NOT NULL,
  `hp_pic` varchar(20) NOT NULL,
  `status` tinyint(4) UNSIGNED NOT NULL,
  `create_by` int(11) UNSIGNED NOT NULL,
  `update_by` int(11) UNSIGNED DEFAULT NULL,
  `create_at` int(11) UNSIGNED DEFAULT NULL,
  `update_at` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `dbo_permintaan`
--

INSERT INTO `dbo_permintaan` (`id`, `produsen_data`, `deskripsi`, `model_pembinaan`, `tanggal`, `waktu`, `lokasi`, `surat`, `email_pic`, `nama_pic`, `hp_pic`, `status`, `create_by`, `update_by`, `create_at`, `update_at`) VALUES
(10, 1, 'Penjelasan kualitas data statistik', 1, '2024-07-13', '20:51:00', 'Zoom meeting', '1720533259.pdf', 'dadangsunandar@gmail.com', 'dadang sunandar', '08128797689879', 3, 1, NULL, 1720533259, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `dbo_pesan_permintaan`
--

CREATE TABLE `dbo_pesan_permintaan` (
  `id` int(11) UNSIGNED NOT NULL,
  `permintaan_id` int(11) UNSIGNED NOT NULL,
  `waktu` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `pesan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `dbo_pesan_permintaan`
--

INSERT INTO `dbo_pesan_permintaan` (`id`, `permintaan_id`, `waktu`, `user_id`, `pesan`) VALUES
(19, 10, 1722877322, 2, 'tes');

-- --------------------------------------------------------

--
-- Table structure for table `dbo_status_permintaan`
--

CREATE TABLE `dbo_status_permintaan` (
  `id` tinyint(4) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `create_at` int(11) UNSIGNED NOT NULL,
  `update_at` int(11) UNSIGNED DEFAULT NULL,
  `create_by` int(11) UNSIGNED DEFAULT NULL,
  `update_by` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `dbo_status_permintaan`
--

INSERT INTO `dbo_status_permintaan` (`id`, `nama`, `create_at`, `update_at`, `create_by`, `update_by`) VALUES
(1, 'Dibuka', 1717471291, NULL, NULL, NULL),
(2, 'Diproses', 1717471291, NULL, NULL, NULL),
(3, 'Menunggu balasan', 1717471291, NULL, NULL, NULL),
(4, 'Disetujui', 1717471291, NULL, NULL, NULL),
(5, 'Ditutup', 1717471291, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `dbo_template_email`
--

CREATE TABLE `dbo_template_email` (
  `id` varchar(100) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `pesan` text NOT NULL,
  `create_at` int(11) NOT NULL,
  `update_at` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `dbo_template_email`
--

INSERT INTO `dbo_template_email` (`id`, `nama`, `judul`, `pesan`, `create_at`, `update_at`, `status`) VALUES
('client_reply', 'Pengguna menyampaikan pesan', 'Re: [#%ticket_id%] Tanggapan Pengguna | SPEKTRAL', '<p>Halo %supervisor_name%,</p><p>Pengguna telah mengirimkan pesan pada permintaan pembinaan yang ditugaskan ke Anda.</p><p><a href=\\\"%url%\\\" target=\\\"_blank\\\">Lihat Sekarang</a></p><p>Terimakasih, BPS Provinsi Riau</p>', 1717575359, NULL, 1),
('lost_password', 'Konfirmasi lupa password', 'Pemulihan password | SPEKTRAL', '<p>Halo %client_name%,</p><p>Kami telah menerima permintaan anda untuk mengatur ulang password.</p><p>Klik tautan di bawah ini untuk memasukkan password yang baru</p><p><a href=\\\"%url%\\\" target=\\\"_blank\\\">Ubah Sekarang</a></p><p>Terimakasih, BPS Provinsi Riau</p>', 1717575359, NULL, 1),
('new_ticket', 'Pembuatan permintaan pembinaan baru', '[#%ticket_id%] Permintaan pembinaan baru | SPEKTRAL', '<p>Halo %client_name%,</p><p>Terimakasih telah menghubungi kami. Ini adalah jawaban otomatis sebagai konfirmasi bahwa permintaan Anda telah diterima. Petugas kami akan memprosesnya sesegera mungkin.</p><p>Untuk catatan Anda, rincian tiket tercantum di bawah ini. Saat membalas, pastikan bahwa ID tiket disimpan di baris subjek untuk memastikan bahwa balasan Anda dilacak dengan tepat.</p><p>ID: %ticket_id% <br />Deskripsi: %ticket_description%</p><p>Anda dapat memeriksa status atau membalas tiket ini secara online di: %url%</p><p>Terimakasih, BPS Provinsi Riau</p>', 1717575359, NULL, 1),
('new_ticket_supervisor_notification', 'Pemberitahuan permintaan pembinaan baru', 'Pemberitahuan permintaan pembinaan baru | SPEKTRAL', '<p>Halo %supervisor_name%,</p><p>Permintaan pembinaan baru telah dibuat dan ditugaskan untuk Anda, silakan masuk ke backend SPEKTRAL untuk memprosesnya.</p><p>ID: %ticket_id% <br />Deskripsi: %ticket_description%</p><p><a href=\\\"%url%\\\" target=\\\"_blank\\\">Proses Sekarang</a></p><p>Terimakasih, BPS Provinsi Riau</p>', 1717575359, NULL, 1),
('registration', 'Registrasi pengguna', 'Registrasi pengguna | SPEKTRAL', '<p>Halo %client_name%,</p><p>Terimakasih telah registrasi. Ini adalah jawaban otomatis sebagai konfirmasi bahwa registrasi Anda telah tersimpan di kami.</p><p>Klik tautan di bawah ini untuk memverifikasi akun email Anda untuk mendapatkan akses penuh pada SPEKTRAL BPS Provinsi Riau.</p><p><a href=\\\"%url%\\\" target=\\\"_blank\\\">Aktifkan Sekarang</a></p><p>Terimakasih, BPS Provinsi Riau</p>', 1717575359, NULL, 1),
('supervisor_reply', 'Supervisor menjawab', 'Re: [#%ticket_id%] Tanggapan Petugas | SPEKTRAL', '<p>Halo %client_name%,</p><p>Petugas kami telah menanggapi permintaan anda.</p><p><a href=\\\"%url%\\\" target=\\\"_blank\\\">Lihat Sekarang</a></p><p>Terimakasih, BPS Provinsi Riau</p>', 1717575359, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `dbo_testimoni`
--

CREATE TABLE `dbo_testimoni` (
  `id` int(11) UNSIGNED NOT NULL,
  `pesan` varchar(255) NOT NULL,
  `rating` tinyint(4) UNSIGNED NOT NULL DEFAULT 5,
  `is_active` tinyint(4) UNSIGNED NOT NULL DEFAULT 1,
  `create_at` int(11) UNSIGNED NOT NULL,
  `update_at` int(11) UNSIGNED DEFAULT NULL,
  `create_by` int(11) UNSIGNED DEFAULT NULL,
  `update_by` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `dbo_testimoni`
--

INSERT INTO `dbo_testimoni` (`id`, `pesan`, `rating`, `is_active`, `create_at`, `update_at`, `create_by`, `update_by`) VALUES
(1, 'Our members are so impressed. It\'s intuitive. It\'s clean. It\'s distraction free. If you\'re building a community.', 5, 1, 1708933715, NULL, 1, NULL),
(2, 'Spektral is exactly what I\'ve been looking for.', 4, 1, 1708933715, NULL, 1, NULL),
(3, 'Spektral makes me more productive and gets the job done in a fraction of the time. I\'m glad I found spektral.', 5, 1, 1708933715, 1718070728, 1, NULL),
(4, 'I can\'t say enough about Spektral. Spektral has really helped our business.', 4, 1, 1708933715, NULL, 1, NULL),
(8, 'coba', 5, 1, 1718628947, NULL, 2, NULL),
(10, 'Terima kasih', 4, 1, 1720532967, NULL, 23, NULL),
(11, 'good', 5, 1, 1722570873, NULL, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `dbo_tingkat_instansi`
--

CREATE TABLE `dbo_tingkat_instansi` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `nama` varchar(100) NOT NULL,
  `create_at` int(10) UNSIGNED DEFAULT NULL,
  `update_at` int(10) UNSIGNED DEFAULT NULL,
  `create_by` int(10) UNSIGNED DEFAULT NULL,
  `update_by` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `dbo_tingkat_instansi`
--

INSERT INTO `dbo_tingkat_instansi` (`id`, `nama`, `create_at`, `update_at`, `create_by`, `update_by`) VALUES
(1, 'Kementerian/Lembaga', 1722213463, NULL, 2, NULL),
(2, 'Pemerintahan Provinsi', 1722213463, NULL, 2, NULL),
(3, 'Pemerintahan Kabupaten/Kota', 1722213463, NULL, 2, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `dbo_user`
--

CREATE TABLE `dbo_user` (
  `id` int(11) UNSIGNED NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `nama` varchar(100) NOT NULL,
  `nip` varchar(18) NOT NULL,
  `jabatan` varchar(255) NOT NULL,
  `instansi` varchar(255) NOT NULL,
  `tingkat` tinyint(4) UNSIGNED NOT NULL,
  `nomor_wa` varchar(100) NOT NULL,
  `role` varchar(255) NOT NULL,
  `token` varchar(255) DEFAULT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `is_active` tinyint(4) UNSIGNED NOT NULL DEFAULT 0,
  `create_at` int(11) UNSIGNED DEFAULT NULL,
  `update_at` int(11) UNSIGNED DEFAULT NULL,
  `update_by` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `dbo_user`
--

INSERT INTO `dbo_user` (`id`, `email`, `password`, `nama`, `nip`, `jabatan`, `instansi`, `tingkat`, `nomor_wa`, `role`, `token`, `reset_token`, `is_active`, `create_at`, `update_at`, `update_by`) VALUES
(1, 'user@example.com', '$2y$10$Si0VQuuecfQZ8iUx6/gPKePPdRgwRu7GzEJzfcuwF0NajnK4PTNyK', 'User', '123456789012345678', 'Fungsional Ahli Muda', 'Dinas XXXY', 2, '12345678911', 'user', NULL, NULL, 1, 1707714506, 1723325584, 1),
(2, 'khaerulanas@bps.go.id', '$2y$10$aQTRt124wCdvlWfw5.DzA./.Ivn/IauOdOnGnJt2vmQnC/9SWdLKO', 'Khaerul Anas', '198510272009021002', 'Prakom Ahli Muda', 'BPS Provinsi Riau', 2, '085325843834', 'user,operator,supervisor,viewer,admin', NULL, NULL, 1, 1707714506, 1723325560, NULL),
(14, 'dadangsunandar@bps.go.id', NULL, 'Dadang Sunandar SST, M.T', '198311082007011004', 'Pranata Komputer Ahli Muda BPS Provinsi', 'BPS Provinsi Riau', 2, '12345678910', 'user,operator,supervisor,viewer,admin', NULL, NULL, 1, 1718241332, 1723326422, NULL),
(23, 'dadangsunandar@gmail.com', '$2y$10$MBWMDjASf7eFmZrprQ4kpuYvP2Pvvbqa0IKXnX1boeEIZfhd7X892', 'dadang sunandar', '198311082007011004', 'Kabid', 'OPD', 2, '08128779087622', 'user', NULL, NULL, 1, 1720532818, 1722852894, NULL),
(24, 'emiliad@bps.go.id', NULL, 'Emilia Dharmayanthi SST, M.Si.', '197905132000122002', 'Statistisi Ahli Madya BPS Provinsi', 'BPS Provinsi Riau', 2, '12345678910', 'user,operator,supervisor,viewer,admin', NULL, NULL, 1, 1721697451, 1723326429, NULL),
(25, 'bekti.indasari@bps.go.id', NULL, 'Bekti Indasari S.Stat.', '199603052019032001', 'Statistisi Ahli Pertama BPS Provinsi', 'BPS Provinsi Riau', 2, '12345678910', 'user,operator', NULL, NULL, 1, 1721698740, 1723326455, NULL),
(26, 'asep.riyadi@bps.go.id', NULL, 'Asep Riyadi S.Si., M.M', '196701181989011001', 'Kepala BPS Provinsi', 'BPS Provinsi Riau', 2, '12345678910', 'user,viewer', NULL, NULL, 1, 1721785555, NULL, NULL),
(27, 'gumilar@bps.go.id', NULL, 'Agung Gumilar Triyanto SST, M.Si.', '197711071999121001', 'Pranata Komputer Ahli Madya BPS Provinsi', 'BPS Provinsi Riau', 2, '12345678910', 'user,viewer', NULL, NULL, 1, 1721787483, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dbo_dokumentasi_pembinaan`
--
ALTER TABLE `dbo_dokumentasi_pembinaan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dbo_dokumentasi_pembinaan_ibfk_1` (`create_by`),
  ADD KEY `dbo_dokumentasi_pembinaan_ibfk_2` (`update_by`),
  ADD KEY `permintaan_id` (`permintaan_id`),
  ADD KEY `approve_by` (`approve_by`);

--
-- Indexes for table `dbo_kategori_modul_literasi`
--
ALTER TABLE `dbo_kategori_modul_literasi`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nama` (`nama`),
  ADD KEY `create_by` (`create_by`),
  ADD KEY `update_by` (`update_by`);

--
-- Indexes for table `dbo_kategori_modul_pembinaan`
--
ALTER TABLE `dbo_kategori_modul_pembinaan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nama` (`nama`),
  ADD KEY `create_by` (`create_by`),
  ADD KEY `update_by` (`update_by`);

--
-- Indexes for table `dbo_migrations`
--
ALTER TABLE `dbo_migrations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `migration` (`migration`,`action`);

--
-- Indexes for table `dbo_model_pembinaan`
--
ALTER TABLE `dbo_model_pembinaan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nama` (`nama`),
  ADD KEY `dbo_model_pembinaan_ibfk_1` (`create_by`),
  ADD KEY `dbo_model_pembinaan_ibfk_2` (`update_by`);

--
-- Indexes for table `dbo_modul_gsbpm`
--
ALTER TABLE `dbo_modul_gsbpm`
  ADD PRIMARY KEY (`id`),
  ADD KEY `create_by` (`create_by`),
  ADD KEY `update_by` (`update_by`);

--
-- Indexes for table `dbo_modul_literasi`
--
ALTER TABLE `dbo_modul_literasi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `create_by` (`create_by`),
  ADD KEY `update_by` (`update_by`),
  ADD KEY `kategori` (`kategori`),
  ADD KEY `approve_by` (`approve_by`);

--
-- Indexes for table `dbo_modul_pembinaan`
--
ALTER TABLE `dbo_modul_pembinaan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kategori` (`kategori`),
  ADD KEY `create_by` (`create_by`),
  ADD KEY `update_by` (`update_by`),
  ADD KEY `approve_by` (`approve_by`);

--
-- Indexes for table `dbo_permintaan`
--
ALTER TABLE `dbo_permintaan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dbo_pembinaan_ibfk_1` (`model_pembinaan`),
  ADD KEY `create_by` (`create_by`),
  ADD KEY `update_by` (`update_by`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `dbo_pesan_permintaan`
--
ALTER TABLE `dbo_pesan_permintaan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permintaan_id` (`permintaan_id`,`user_id`,`waktu`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `dbo_status_permintaan`
--
ALTER TABLE `dbo_status_permintaan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nama` (`nama`),
  ADD KEY `create_by` (`create_by`),
  ADD KEY `update_by` (`update_by`);

--
-- Indexes for table `dbo_template_email`
--
ALTER TABLE `dbo_template_email`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dbo_testimoni`
--
ALTER TABLE `dbo_testimoni`
  ADD PRIMARY KEY (`id`),
  ADD KEY `create_by` (`create_by`),
  ADD KEY `update_by` (`update_by`);

--
-- Indexes for table `dbo_tingkat_instansi`
--
ALTER TABLE `dbo_tingkat_instansi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `create_by` (`create_by`),
  ADD KEY `update_by` (`update_by`);

--
-- Indexes for table `dbo_user`
--
ALTER TABLE `dbo_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `tingkat` (`tingkat`),
  ADD KEY `update_by` (`update_by`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dbo_dokumentasi_pembinaan`
--
ALTER TABLE `dbo_dokumentasi_pembinaan`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `dbo_migrations`
--
ALTER TABLE `dbo_migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `dbo_modul_literasi`
--
ALTER TABLE `dbo_modul_literasi`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `dbo_modul_pembinaan`
--
ALTER TABLE `dbo_modul_pembinaan`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `dbo_permintaan`
--
ALTER TABLE `dbo_permintaan`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `dbo_pesan_permintaan`
--
ALTER TABLE `dbo_pesan_permintaan`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `dbo_testimoni`
--
ALTER TABLE `dbo_testimoni`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `dbo_user`
--
ALTER TABLE `dbo_user`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `dbo_dokumentasi_pembinaan`
--
ALTER TABLE `dbo_dokumentasi_pembinaan`
  ADD CONSTRAINT `dbo_dokumentasi_pembinaan_ibfk_2` FOREIGN KEY (`create_by`) REFERENCES `dbo_user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `dbo_dokumentasi_pembinaan_ibfk_3` FOREIGN KEY (`update_by`) REFERENCES `dbo_user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `dbo_dokumentasi_pembinaan_ibfk_4` FOREIGN KEY (`permintaan_id`) REFERENCES `dbo_permintaan` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `dbo_dokumentasi_pembinaan_ibfk_5` FOREIGN KEY (`approve_by`) REFERENCES `dbo_user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `dbo_kategori_modul_literasi`
--
ALTER TABLE `dbo_kategori_modul_literasi`
  ADD CONSTRAINT `dbo_kategori_modul_literasi_ibfk_1` FOREIGN KEY (`create_by`) REFERENCES `dbo_user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `dbo_kategori_modul_literasi_ibfk_2` FOREIGN KEY (`update_by`) REFERENCES `dbo_user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `dbo_kategori_modul_pembinaan`
--
ALTER TABLE `dbo_kategori_modul_pembinaan`
  ADD CONSTRAINT `dbo_kategori_modul_pembinaan_ibfk_1` FOREIGN KEY (`create_by`) REFERENCES `dbo_user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `dbo_kategori_modul_pembinaan_ibfk_2` FOREIGN KEY (`update_by`) REFERENCES `dbo_user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `dbo_model_pembinaan`
--
ALTER TABLE `dbo_model_pembinaan`
  ADD CONSTRAINT `dbo_model_pembinaan_ibfk_1` FOREIGN KEY (`create_by`) REFERENCES `dbo_user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `dbo_model_pembinaan_ibfk_2` FOREIGN KEY (`update_by`) REFERENCES `dbo_user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `dbo_modul_gsbpm`
--
ALTER TABLE `dbo_modul_gsbpm`
  ADD CONSTRAINT `dbo_modul_gsbpm_ibfk_1` FOREIGN KEY (`create_by`) REFERENCES `dbo_user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `dbo_modul_gsbpm_ibfk_2` FOREIGN KEY (`update_by`) REFERENCES `dbo_user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `dbo_modul_gsbpm_ibfk_3` FOREIGN KEY (`create_by`) REFERENCES `dbo_user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `dbo_modul_gsbpm_ibfk_4` FOREIGN KEY (`update_by`) REFERENCES `dbo_user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `dbo_modul_literasi`
--
ALTER TABLE `dbo_modul_literasi`
  ADD CONSTRAINT `dbo_modul_literasi_ibfk_1` FOREIGN KEY (`create_by`) REFERENCES `dbo_user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `dbo_modul_literasi_ibfk_2` FOREIGN KEY (`update_by`) REFERENCES `dbo_user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `dbo_modul_literasi_ibfk_3` FOREIGN KEY (`kategori`) REFERENCES `dbo_kategori_modul_literasi` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `dbo_modul_literasi_ibfk_4` FOREIGN KEY (`approve_by`) REFERENCES `dbo_user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `dbo_modul_pembinaan`
--
ALTER TABLE `dbo_modul_pembinaan`
  ADD CONSTRAINT `dbo_modul_pembinaan_ibfk_1` FOREIGN KEY (`kategori`) REFERENCES `dbo_kategori_modul_pembinaan` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `dbo_modul_pembinaan_ibfk_2` FOREIGN KEY (`create_by`) REFERENCES `dbo_user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `dbo_modul_pembinaan_ibfk_3` FOREIGN KEY (`update_by`) REFERENCES `dbo_user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `dbo_modul_pembinaan_ibfk_4` FOREIGN KEY (`approve_by`) REFERENCES `dbo_user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `dbo_permintaan`
--
ALTER TABLE `dbo_permintaan`
  ADD CONSTRAINT `dbo_permintaan_ibfk_1` FOREIGN KEY (`model_pembinaan`) REFERENCES `dbo_model_pembinaan` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `dbo_permintaan_ibfk_2` FOREIGN KEY (`create_by`) REFERENCES `dbo_user` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `dbo_permintaan_ibfk_3` FOREIGN KEY (`update_by`) REFERENCES `dbo_user` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `dbo_permintaan_ibfk_4` FOREIGN KEY (`status`) REFERENCES `dbo_status_permintaan` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `dbo_pesan_permintaan`
--
ALTER TABLE `dbo_pesan_permintaan`
  ADD CONSTRAINT `dbo_pesan_permintaan_ibfk_1` FOREIGN KEY (`permintaan_id`) REFERENCES `dbo_permintaan` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `dbo_pesan_permintaan_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `dbo_user` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `dbo_status_permintaan`
--
ALTER TABLE `dbo_status_permintaan`
  ADD CONSTRAINT `dbo_status_permintaan_ibfk_1` FOREIGN KEY (`create_by`) REFERENCES `dbo_user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `dbo_status_permintaan_ibfk_2` FOREIGN KEY (`update_by`) REFERENCES `dbo_user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `dbo_testimoni`
--
ALTER TABLE `dbo_testimoni`
  ADD CONSTRAINT `dbo_testimoni_ibfk_1` FOREIGN KEY (`create_by`) REFERENCES `dbo_user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `dbo_testimoni_ibfk_2` FOREIGN KEY (`update_by`) REFERENCES `dbo_user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `dbo_tingkat_instansi`
--
ALTER TABLE `dbo_tingkat_instansi`
  ADD CONSTRAINT `dbo_tingkat_instansi_ibfk_1` FOREIGN KEY (`create_by`) REFERENCES `dbo_user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `dbo_tingkat_instansi_ibfk_2` FOREIGN KEY (`update_by`) REFERENCES `dbo_user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `dbo_user`
--
ALTER TABLE `dbo_user`
  ADD CONSTRAINT `dbo_user_ibfk_1` FOREIGN KEY (`tingkat`) REFERENCES `dbo_tingkat_instansi` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `dbo_user_ibfk_2` FOREIGN KEY (`update_by`) REFERENCES `dbo_user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
