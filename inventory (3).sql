-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Waktu pembuatan: 10 Feb 2025 pada 15.07
-- Versi server: 5.7.39
-- Versi PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inventory`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_barang`
--

CREATE TABLE `tbl_barang` (
  `id_barang` varchar(255) NOT NULL,
  `nama_barang` varchar(255) NOT NULL,
  `harga` varchar(255) NOT NULL,
  `id_supplier` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_barang`
--

INSERT INTO `tbl_barang` (`id_barang`, `nama_barang`, `harga`, `id_supplier`) VALUES
('BRG-004', 'Colokan Listrik', '15000', 'SUP-001'),
('BRG-006', 'Semen Tiga Roda', '2000', 'SUP-003'),
('BRG-007', 'Keramik Kaca', '15000', 'SUP-001'),
('BRG-008', 'Aluminium Foil', '30000', 'SUP-003'),
('BRG-009', 'Pipa PVC', '25000', 'SUP-003'),
('BRG-010', 'Kunci Inggris', '20000', 'SUP-002'),
('BRG-011', 'Tang Potong', '18000', 'SUP-001'),
('BRG-012', 'Gergaji Besi', '22000', 'SUP-003'),
('BRG-013', 'Obeng Plus', '12000', 'SUP-002'),
('BRG-014', 'Meteran', '15000', 'SUP-002'),
('BRG-015', 'Paku Beton', '700', 'SUP-002'),
('BRG-016', 'Kawat Bendrat', '5000', 'SUP-003'),
('BRG-017', 'Bor Tangan', '200000', 'SUP-003'),
('BRG-018', 'Plafon Gypsum', '30000', 'SUP-003'),
('BRG-019', 'Kunci Pas', '25000', 'SUP-001'),
('BRG-020', 'Siku Besi', '20000', 'SUP-001'),
('BRG-021', 'Sekrup Kayu', '300', 'SUP-002'),
('BRG-022', 'Engsel Pintu', '1500', 'SUP-003'),
('BRG-023', 'Grendel Pintu', '3000', 'SUP-002'),
('BRG-024', 'Cat Besi', '40000', 'SUP-001'),
('BRG-025', 'Cangkul', '45000', 'SUP-001'),
('BRG-026', 'Sekop', '30000', 'SUP-002'),
('BRG-027', 'Palu', '20000', 'SUP-002'),
('BRG-028', 'Linggis', '50000', 'SUP-003'),
('BRG-031', 'Besi Beton', '15000', 'SUP-002'),
('BRG-034', 'Atap Seng', '100000', 'SUP-002'),
('BRG-035', 'Pintu Kayu', '500000', 'SUP-001'),
('BRG-036', 'Jendela Kayu', '400000', 'SUP-003'),
('BRG-037', 'Cat Anti Bocor', '60000', 'SUP-003'),
('BRG-038', 'Paku Seng', '200', 'SUP-002'),
('BRG-039', 'Papan Gypsum', '25000', 'SUP-003'),
('BRG-040', 'Kaca', '50000', 'SUP-001'),
('BRG-041', 'Engsel Jendela', '1200', 'SUP-001'),
('BRG-042', 'Klem Pipa', '800', 'SUP-003'),
('BRG-043', 'Sealant', '15000', 'SUP-002'),
('BRG-044', 'Alat Semprot Cat', '100000', 'SUP-002'),
('BRG-045', 'Kompas Bangunan', '250000', 'SUP-001'),
('BRG-046', 'Las Listrik', '500000', 'SUP-001'),
('BRG-047', 'Gerinda', '750000', 'SUP-002'),
('BRG-048', 'Kawat Las', '25000', 'SUP-003'),
('BRG-049', 'Masker Debu', '1000', 'SUP-002'),
('BRG-050', 'Sarung Tangan', '2000', 'SUP-001'),
('BRG-051', 'Keramik Kaca', '15000', 'SUP-001'),
('BRG-052', 'Saringan Pasir', '15000', 'SUP-001'),
('BRG-053', 'Colokan Listrik', '25000', 'SUP-003');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_barang_keluar`
--

CREATE TABLE `tbl_barang_keluar` (
  `id_barang_keluar` varchar(255) NOT NULL,
  `id_barang_masuk` varchar(255) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `tanggal_keluar` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_barang_keluar`
--

INSERT INTO `tbl_barang_keluar` (`id_barang_keluar`, `id_barang_masuk`, `jumlah`, `tanggal_keluar`) VALUES
('BRGK-001', 'BRGM-001', 4, '2025-02-10'),
('BRGK-002', 'BRGM-001', 4, '2025-02-10'),
('BRGK-003', 'BRGM-001', 4, '2025-02-10'),
('BRGK-004', 'BRGM-001', 4, '2025-02-10'),
('BRGK-005', 'BRGM-001', 4, '2025-02-10'),
('BRGK-006', 'BRGM-001', 4, '2025-02-10'),
('BRGK-007', 'BRGM-001', 4, '2025-02-10'),
('BRGK-008', 'BRGM-001', 4, '2025-02-10'),
('BRGK-009', 'BRGM-001', 4, '2025-02-10'),
('BRGK-010', 'BRGM-001', 4, '2025-02-10'),
('BRGK-011', 'BRGM-001', 4, '2025-02-10'),
('BRGK-012', 'BRGM-001', 4, '2025-02-10'),
('BRGK-013', 'BRGM-001', 4, '2025-02-10'),
('BRGK-014', 'BRGM-001', 4, '2025-02-10'),
('BRGK-015', 'BRGM-001', 4, '2025-02-10'),
('BRGK-016', 'BRGM-001', 4, '2025-02-10'),
('BRGK-017', 'BRGM-001', 4, '2025-02-10'),
('BRGK-018', 'BRGM-001', 4, '2025-02-10'),
('BRGK-019', 'BRGM-001', 4, '2025-02-10'),
('BRGK-020', 'BRGM-001', 4, '2025-02-10'),
('BRGK-021', 'BRGM-001', 4, '2025-02-10'),
('BRGK-022', 'BRGM-001', 4, '2025-02-10'),
('BRGK-023', 'BRGM-001', 11, '2025-02-10'),
('BRGK-024', 'BRGM-001', 11, '2025-02-10'),
('BRGK-025', 'BRGM-001', 10, '2025-02-10'),
('BRGK-026', 'BRGM-001', 10, '2025-02-10'),
('BRGK-027', 'BRGM-001', 10, '2025-02-10'),
('BRGK-028', 'BRGM-001', 10, '2025-02-10'),
('BRGK-029', 'BRGM-001', 10, '2025-02-10'),
('BRGK-030', 'BRGM-001', 10, '2025-02-10'),
('BRGK-031', 'BRGM-001', 10, '2025-02-10'),
('BRGK-032', 'BRGM-001', 10, '2025-02-10'),
('BRGK-033', 'BRGM-001', 10, '2025-02-10'),
('BRGK-034', 'BRGM-001', 10, '2025-02-10'),
('BRGK-035', 'BRGM-001', 10, '2025-02-10'),
('BRGK-036', 'BRGM-001', 10, '2025-02-10'),
('BRGK-037', 'BRGM-001', 10, '2025-02-10'),
('BRGK-038', 'BRGM-001', 10, '2025-02-10'),
('BRGK-039', 'BRGM-001', 10, '2025-02-10'),
('BRGK-040', 'BRGM-001', 10, '2025-02-10'),
('BRGK-041', 'BRGM-001', 10, '2025-02-10'),
('BRGK-042', 'BRGM-001', 10, '2025-02-10'),
('BRGK-043', 'BRGM-001', 10, '2025-02-10'),
('BRGK-044', 'BRGM-001', 10, '2025-02-10'),
('BRGK-045', 'BRGM-001', 10, '2025-02-10');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_barang_masuk`
--

CREATE TABLE `tbl_barang_masuk` (
  `id_barang_masuk` varchar(255) NOT NULL,
  `id_barang` varchar(255) NOT NULL,
  `id_pesanan` varchar(255) NOT NULL,
  `stok` int(11) NOT NULL,
  `tanggal_masuk` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_barang_masuk`
--

INSERT INTO `tbl_barang_masuk` (`id_barang_masuk`, `id_barang`, `id_pesanan`, `stok`, `tanggal_masuk`) VALUES
('BRGM-001', 'BRG-004', 'PSN-016', 1751, '2025-02-08');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_penjualan`
--

CREATE TABLE `tbl_penjualan` (
  `id_penjualan` varchar(255) NOT NULL,
  `id_barang` varchar(255) NOT NULL,
  `qty` int(11) NOT NULL,
  `total` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_penjualan`
--

INSERT INTO `tbl_penjualan` (`id_penjualan`, `id_barang`, `qty`, `total`) VALUES
('PJN-001', 'BRG-001', 20, 40000),
('PJN-002', 'BRG-003', 1, 2000),
('PJN-003', 'BRG-003', 12, 720000),
('PJN-004', 'BRG-003', 15, 900000),
('PJN-005', 'BRG-003', 10, 600000),
('PJN-006', 'BRG-003', 14, 840000),
('PJN-007', 'BRG-003', 18, 1080000),
('PJN-008', 'BRG-003', 16, 960000),
('PJN-009', 'BRG-003', 20, 1200000),
('PJN-010', 'BRG-003', 11, 660000),
('PJN-011', 'BRG-003', 19, 1140000),
('PJN-012', 'BRG-003', 13, 780000),
('PJN-013', 'BRG-003', 17, 1020000),
('PJN-014', 'BRG-003', 15, 900000),
('PJN-015', 'BRG-003', 10, 600000),
('PJN-016', 'BRG-003', 12, 720000),
('PJN-017', 'BRG-003', 18, 1080000),
('PJN-018', 'BRG-003', 14, 840000),
('PJN-019', 'BRG-003', 13, 780000),
('PJN-020', 'BRG-003', 19, 1140000),
('PJN-021', 'BRG-003', 16, 960000),
('PJN-022', 'BRG-003', 20, 1200000),
('PJN-023', 'BRG-003', 11, 660000),
('PJN-024', 'BRG-003', 17, 1020000),
('PJN-025', 'BRG-003', 14, 840000),
('PJN-026', 'BRG-003', 15, 900000),
('PJN-027', 'BRG-003', 12, 720000),
('PJN-028', 'BRG-003', 18, 1080000),
('PJN-029', 'BRG-003', 10, 600000),
('PJN-030', 'BRG-003', 13, 780000),
('PJN-031', 'BRG-003', 19, 1140000),
('PJN-032', 'BRG-003', 20, 1200000),
('PJN-033', 'BRG-004', 2, 40000),
('PJN-034', 'BRG-004', 3, 60000),
('PJN-035', 'BRG-004', 1, 20000),
('PJN-036', 'BRG-004', 4, 80000),
('PJN-037', 'BRG-004', 5, 100000),
('PJN-038', 'BRG-004', 2, 40000),
('PJN-039', 'BRG-004', 3, 60000),
('PJN-040', 'BRG-004', 4, 80000),
('PJN-041', 'BRG-004', 1, 20000),
('PJN-043', 'BRG-004', 3, 60000),
('PJN-044', 'BRG-004', 2, 40000),
('PJN-045', 'BRG-004', 4, 80000),
('PJN-046', 'BRG-004', 5, 100000),
('PJN-047', 'BRG-004', 1, 20000),
('PJN-048', 'BRG-004', 2, 40000),
('PJN-049', 'BRG-004', 4, 80000),
('PJN-050', 'BRG-004', 3, 60000),
('PJN-051', 'BRG-004', 5, 100000),
('PJN-052', 'BRG-004', 1, 20000),
('PJN-053', 'BRG-004', 2, 40000),
('PJN-054', 'BRG-004', 3, 60000),
('PJN-055', 'BRG-004', 4, 80000),
('PJN-056', 'BRG-004', 5, 100000),
('PJN-057', 'BRG-004', 1, 20000),
('PJN-058', 'BRG-004', 3, 60000),
('PJN-059', 'BRG-004', 2, 40000),
('PJN-060', 'BRG-004', 4, 80000),
('PJN-061', 'BRG-004', 5, 100000),
('PJN-062', 'BRG-004', 1, 20000),
('PJN-063', 'BRG-005', 120, 180000),
('PJN-064', 'BRG-005', 150, 225000),
('PJN-065', 'BRG-005', 100, 150000),
('PJN-066', 'BRG-005', 180, 270000),
('PJN-067', 'BRG-005', 200, 300000),
('PJN-068', 'BRG-005', 130, 195000),
('PJN-069', 'BRG-005', 160, 240000),
('PJN-070', 'BRG-005', 140, 210000),
('PJN-071', 'BRG-005', 190, 285000),
('PJN-072', 'BRG-005', 170, 255000),
('PJN-073', 'BRG-005', 150, 225000),
('PJN-074', 'BRG-005', 110, 165000),
('PJN-075', 'BRG-005', 180, 270000),
('PJN-076', 'BRG-005', 140, 210000),
('PJN-077', 'BRG-005', 190, 285000),
('PJN-078', 'BRG-005', 120, 180000),
('PJN-079', 'BRG-005', 160, 240000),
('PJN-080', 'BRG-005', 130, 195000),
('PJN-081', 'BRG-005', 170, 255000),
('PJN-082', 'BRG-005', 100, 150000),
('PJN-083', 'BRG-005', 200, 300000),
('PJN-084', 'BRG-005', 120, 180000),
('PJN-085', 'BRG-005', 150, 225000),
('PJN-086', 'BRG-005', 180, 270000),
('PJN-087', 'BRG-005', 110, 165000),
('PJN-088', 'BRG-005', 140, 210000),
('PJN-089', 'BRG-005', 190, 285000),
('PJN-090', 'BRG-005', 130, 195000),
('PJN-091', 'BRG-005', 160, 240000),
('PJN-092', 'BRG-006', 30, 60),
('PJN-093', 'BRG-004', 30, 450),
('PJN-094', 'BRG-004', 10, 150),
('PJN-095', 'BRG-004', 10, 150),
('PJN-096', 'BRG-004', 100, 1.5),
('PJN-097', 'BRG-005', 10, 20),
('PJN-098', 'BRG-004', 10, 0),
('PJN-099', 'BRG-004', 10, 0),
('PJN-100', 'BRG-004', 12, 180),
('PJN-101', 'BRG-004', 12, 180),
('PJN-102', 'BRG-004', 5, 75),
('PJN-103', 'BRG-004', 1000, 15),
('PJN-104', 'BRG-007', 50, 750),
('PJN-105', 'BRG-028', 20, 1),
('PJN-106', 'BRG-007', 40, 600),
('PJN-107', 'BRG-005', 1, 2),
('PJN-108', 'BRG-004', 12, 180),
('PJN-109', 'BRG-004', 9, 135),
('PJN-110', 'BRG-017', 10, 2),
('PJN-111', 'BRG-004', 15, 225),
('PJN-112', 'BRG-004', 5, 75),
('PJN-113', 'BRG-009', 10, 250),
('PJN-114', 'BRG-006', 2, 4),
('PJN-115', 'BRG-006', 2, 4),
('PJN-116', 'BRG-004', 2, 30),
('PJN-117', 'BRG-004', 2, 30),
('PJN-118', 'BRG-004', 2, 30);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_pesanan`
--

CREATE TABLE `tbl_pesanan` (
  `id_pesanan` varchar(255) NOT NULL,
  `id_barang` varchar(255) NOT NULL,
  `nama_barang` varchar(255) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `harga` float NOT NULL,
  `total` float NOT NULL,
  `id_supplier` varchar(255) NOT NULL,
  `status` enum('Menunggu Konfirmasi','Barang Di Pesan','Barang Diterima','Ke barang Masuk') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_pesanan`
--

INSERT INTO `tbl_pesanan` (`id_pesanan`, `id_barang`, `nama_barang`, `jumlah`, `harga`, `total`, `id_supplier`, `status`) VALUES
('PSN-001', 'BRG-004', 'Colokan Listrik', 134, 15000, 2010000, 'SUP-001', 'Ke barang Masuk'),
('PSN-002', 'BRG-005', 'Batu Bata', 6175, 2000, 12350000, 'SUP-003', 'Ke barang Masuk'),
('PSN-003', 'BRG-006', 'Semen Tiga Roda', 41, 2000, 82000, 'SUP-003', 'Ke barang Masuk'),
('PSN-004', 'BRG-004', 'Colokan Listrik', 171, 15000, 2565000, 'SUP-001', 'Ke barang Masuk'),
('PSN-005', 'BRG-004', 'Colokan Listrik', 387, 15000, 5805000, 'SUP-001', 'Ke barang Masuk'),
('PSN-006', 'BRG-028', 'Linggis', 100, 50000, 5000000, 'SUP-003', 'Ke barang Masuk'),
('PSN-007', 'BRG-007', 'Keramik Kaca', 20, 15000, 300000, 'SUP-001', 'Ke barang Masuk'),
('PSN-008', 'BRG-007', 'Keramik Kaca', 50, 15000, 750000, 'SUP-001', 'Ke barang Masuk'),
('PSN-009', 'BRG-035', 'Pintu Kayu', 1, 500000, 500000, 'SUP-001', 'Menunggu Konfirmasi'),
('PSN-010', 'BRG-053', 'Colokan Listrik', 7, 25000, 175000, 'SUP-003', 'Ke barang Masuk'),
('PSN-011', 'BRG-017', 'Bor Tangan', 30, 200000, 6000000, 'SUP-003', 'Ke barang Masuk'),
('PSN-012', 'BRG-017', 'Bor Tangan', 5, 200000, 1000000, 'SUP-003', 'Ke barang Masuk'),
('PSN-013', 'BRG-004', 'Colokan Listrik', 10, 15000, 150000, 'SUP-001', 'Ke barang Masuk'),
('PSN-014', 'BRG-004', 'Colokan Listrik', 30, 15000, 450000, 'SUP-001', 'Ke barang Masuk'),
('PSN-015', 'BRG-004', 'Colokan Listrik', 20, 15000, 300000, 'SUP-001', 'Ke barang Masuk'),
('PSN-016', 'BRG-004', 'Colokan Listrik', 1811, 15000, 27165000, 'SUP-001', 'Ke barang Masuk'),
('PSN-017', 'BRG-006', 'Semen Tiga Roda', 3, 2000, 6000, 'SUP-003', 'Menunggu Konfirmasi');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_supplier`
--

CREATE TABLE `tbl_supplier` (
  `id_supplier` varchar(255) NOT NULL,
  `nama_supplier` varchar(255) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `kategori` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_supplier`
--

INSERT INTO `tbl_supplier` (`id_supplier`, `nama_supplier`, `alamat`, `kategori`) VALUES
('SUP-001', 'TB Dadang', 'Kuningan', 'Kelistrikan'),
('SUP-002', 'TB Maman', 'Blok Pasar Rebo', 'Alat'),
('SUP-003', 'TB Nisa', 'Blok Pasar Kemis', 'Bahan Bangunan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_user`
--

CREATE TABLE `tbl_user` (
  `id_user` int(11) NOT NULL,
  `nama_lengkap` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','manager','gudang') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_user`
--

INSERT INTO `tbl_user` (`id_user`, `nama_lengkap`, `username`, `password`, `role`) VALUES
(7, 'ruli', 'ruli', '$2y$10$r2p0dJg0lb/MJJXTZmgK3uFsnCjlyHD2LAYnkbJajk/IccUqqriHK', 'gudang'),
(8, 'admin', 'admin', '$2y$10$81OswLcepPwS7cVADeVGmuTZySkmTcUJojwFZOhfinJbUsla4eJPO', 'admin'),
(10, 'dadang', 'dadang', '$2y$10$REydKPoI.o3UH.kcowUIUeT3rY2jiDIiH0pHJX6SQVJCEjwmMEg9y', 'manager'),
(11, 'dewi', 'dewi', '$2y$10$9Rc/i4JQSdR5oHWhVGuXK.BoYTxK6AtwmjDP2CroaXterwz.qETSW', 'manager');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tbl_barang`
--
ALTER TABLE `tbl_barang`
  ADD PRIMARY KEY (`id_barang`),
  ADD KEY `id_supplier` (`id_supplier`);

--
-- Indeks untuk tabel `tbl_barang_keluar`
--
ALTER TABLE `tbl_barang_keluar`
  ADD PRIMARY KEY (`id_barang_keluar`),
  ADD KEY `id_barang` (`id_barang_masuk`),
  ADD KEY `id_penjualan` (`id_barang_masuk`);

--
-- Indeks untuk tabel `tbl_barang_masuk`
--
ALTER TABLE `tbl_barang_masuk`
  ADD PRIMARY KEY (`id_barang_masuk`),
  ADD KEY `id_pesanan` (`id_pesanan`),
  ADD KEY `id_barang` (`id_barang`);

--
-- Indeks untuk tabel `tbl_penjualan`
--
ALTER TABLE `tbl_penjualan`
  ADD PRIMARY KEY (`id_penjualan`),
  ADD KEY `id_barang` (`id_barang`);

--
-- Indeks untuk tabel `tbl_pesanan`
--
ALTER TABLE `tbl_pesanan`
  ADD PRIMARY KEY (`id_pesanan`),
  ADD KEY `id_barang_supplier` (`id_barang`),
  ADD KEY `id_supplier` (`id_supplier`),
  ADD KEY `id_barang` (`id_barang`);

--
-- Indeks untuk tabel `tbl_supplier`
--
ALTER TABLE `tbl_supplier`
  ADD PRIMARY KEY (`id_supplier`);

--
-- Indeks untuk tabel `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
