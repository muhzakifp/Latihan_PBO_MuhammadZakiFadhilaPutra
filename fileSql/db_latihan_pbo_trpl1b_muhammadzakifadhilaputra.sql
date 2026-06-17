-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 17, 2026 at 04:48 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_latihan_pbo_trpl1b_muhammadzakifadhilaputra`
--

-- --------------------------------------------------------

--
-- Table structure for table `tabel_tiket`
--

CREATE TABLE `tabel_tiket` (
  `id_tiket` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_film` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jadwal_tayang` datetime NOT NULL,
  `jumlah_kursi` int NOT NULL,
  `harga_dasar_tiket` int NOT NULL,
  `jenis_studio` enum('Regular','IMAX','Velvet') COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipe_audio` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lokasi_baris` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kacamata_3d_id` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `efek_gerak_fitur` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bantal_selimut_pack` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `layanan_butler` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tabel_tiket`
--

INSERT INTO `tabel_tiket` (`id_tiket`, `nama_film`, `jadwal_tayang`, `jumlah_kursi`, `harga_dasar_tiket`, `jenis_studio`, `tipe_audio`, `lokasi_baris`, `kacamata_3d_id`, `efek_gerak_fitur`, `bantal_selimut_pack`, `layanan_butler`) VALUES
('TKT-IMX-001', 'Gundala: Rise of Heroes', '2026-07-02 19:00:00', 2, 75000, 'IMAX', 'IMAX 12-Channel', 'Row D', '3D-GLS-01', 'Motion-Active', NULL, NULL),
('TKT-IMX-002', 'Godzilla x Kong: New Kingdom', '2026-07-02 21:45:00', 2, 75000, 'IMAX', 'IMAX 12-Channel', 'Row C', '3D-GLS-02', 'Motion-Active', NULL, NULL),
('TKT-IMX-003', 'The Avengers: Secret Wars', '2026-07-03 13:00:00', 1, 75000, 'IMAX', 'IMAX 6-Channel', 'Row B', '3D-GLS-03', 'Standard-Vibe', NULL, NULL),
('TKT-IMX-004', 'Avatar: The Tulkun Rider', '2026-07-04 16:00:00', 3, 80000, 'IMAX', 'IMAX 12-Channel', 'Row E', '3D-GLS-04', 'Motion-Active', NULL, NULL),
('TKT-IMX-005', 'Fast X: Part 2', '2026-07-04 20:00:00', 2, 80000, 'IMAX', 'IMAX 12-Channel', 'Row A', '3D-GLS-05', 'Heavy-Rumble', NULL, NULL),
('TKT-IMX-006', 'Jurassic World: New Era', '2026-07-05 11:30:00', 4, 75000, 'IMAX', 'IMAX 6-Channel', 'Row F', '3D-GLS-06', 'Standard-Vibe', NULL, NULL),
('TKT-IMX-007', 'Superman', '2026-07-05 15:00:00', 2, 80000, 'IMAX', 'IMAX 12-Channel', 'Row G', '3D-GLS-07', 'Motion-Active', NULL, NULL),
('TKT-REG-001', 'KKN di Desa Penari 2: Badarawuhi', '2026-07-01 13:00:00', 2, 40000, 'Regular', 'Dolby Digital', 'Row G', NULL, NULL, NULL, NULL),
('TKT-REG-002', 'Siksa Kubur', '2026-07-01 15:30:00', 1, 40000, 'Regular', 'Dolby Digital', 'Row F', NULL, NULL, NULL, NULL),
('TKT-REG-003', 'Agak Laen 2', '2026-07-01 18:00:00', 3, 45000, 'Regular', 'Dolby Atmos', 'Row E', NULL, NULL, NULL, NULL),
('TKT-REG-004', 'Mencuri Raden Saleh: Heist Baru', '2026-07-02 12:00:00', 2, 40000, 'Regular', 'Dolby Digital', 'Row H', NULL, NULL, NULL, NULL),
('TKT-REG-005', 'Pengabdi Setan 3', '2026-07-02 21:00:00', 2, 45000, 'Regular', 'Dolby Atmos', 'Row D', NULL, NULL, NULL, NULL),
('TKT-REG-006', 'Dilan 199X', '2026-07-03 14:15:00', 1, 40000, 'Regular', 'Dolby Digital', 'Row J', NULL, NULL, NULL, NULL),
('TKT-REG-007', 'Petualangan Sherina 3', '2026-07-03 17:30:00', 4, 45000, 'Regular', 'Dolby Atmos', 'Row C', NULL, NULL, NULL, NULL),
('TKT-VLV-001', 'Ada Apa Dengan Cinta? 3', '2026-07-03 18:00:00', 2, 120000, 'Velvet', 'Dolby Atmos', 'Sofa 01', NULL, NULL, 'Premium Pack A', 'Full Butler Service'),
('TKT-VLV-002', 'Laskar Pelangi: Sisi Baru', '2026-07-03 20:30:00', 2, 120000, 'Velvet', 'Dolby Atmos', 'Sofa 02', NULL, NULL, 'Premium Pack B', 'Standard Butler Service'),
('TKT-VLV-003', 'Bumi Manusia: Part 2', '2026-07-04 14:00:00', 2, 130000, 'Velvet', 'Dolby Atmos', 'Sofa 05', NULL, NULL, 'Luxury Suite Pack', 'VIP Butler Service'),
('TKT-VLV-004', 'Nanti Kita Cerita Tentang Hari Ini: End', '2026-07-04 17:00:00', 2, 120000, 'Velvet', 'DTS-X', 'Sofa 03', NULL, NULL, 'Standard Pillow Only', 'Call-Button Service'),
('TKT-VLV-005', 'Sewu Dino 2', '2026-07-05 19:30:00', 2, 130000, 'Velvet', 'Dolby Atmos', 'Sofa 07', NULL, NULL, 'Luxury Suite Pack', 'VIP Butler Service'),
('TKT-VLV-006', 'Kereta Berdarah 2', '2026-07-05 22:15:00', 2, 120000, 'Velvet', 'DTS-X', 'Sofa 04', NULL, NULL, 'Premium Pack A', 'Standard Butler Service');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tabel_tiket`
--
ALTER TABLE `tabel_tiket`
  ADD PRIMARY KEY (`id_tiket`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
