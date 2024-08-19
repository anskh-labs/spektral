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

--
-- Table structure for table `dbo_migrations`
--

CREATE TABLE `dbo_migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `action` varchar(20) NOT NULL,
  `create_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

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
