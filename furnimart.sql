-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 03, 2025 at 02:40 PM
-- Server version: 5.7.24
-- PHP Version: 7.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `furnimart`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_jual`
--

CREATE TABLE `tb_jual` (
  `id_jual` varchar(10) NOT NULL,
  `id_user` varchar(10) DEFAULT NULL,
  `tgl_jual` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `no_transaksi` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_jualdtl`
--

CREATE TABLE `tb_jualdtl` (
  `id_jual` varchar(10) NOT NULL,
  `id_produk` varchar(10) NOT NULL,
  `qty` int(11) NOT NULL,
  `harga` decimal(10,2) NOT NULL,
  `diskon` decimal(5,2) DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_kategori`
--

CREATE TABLE `tb_kategori` (
  `id_kategori` varchar(10) NOT NULL,
  `nm_kategori` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_kategori`
--

INSERT INTO `tb_kategori` (`id_kategori`, `nm_kategori`) VALUES
('K001', 'Ruang Tamu'),
('K002', 'Ruang Makan'),
('K003', 'Kamar Tidur'),
('K004', 'Dapur & Pantry'),
('K005', 'Perkantoran'),
('K006', 'Rak & Penyimpanan'),
('K007', 'Outdoor & Taman'),
('K008', 'Dekorasi & Aksesori');

-- --------------------------------------------------------

--
-- Table structure for table `tb_pesanan`
--

CREATE TABLE `tb_pesanan` (
  `id_pesanan` varchar(10) NOT NULL,
  `id_produk` varchar(10) DEFAULT NULL,
  `qty` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `id_user` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_pesanan`
--

INSERT INTO `tb_pesanan` (`id_pesanan`, `id_produk`, `qty`, `total`, `id_user`) VALUES
('M001', 'P002', 1, 600000, 'U002'),
('M002', 'P005', 2, 800000, 'U002');

-- --------------------------------------------------------

--
-- Table structure for table `tb_produk`
--

CREATE TABLE `tb_produk` (
  `id_produk` varchar(10) NOT NULL,
  `nm_produk` varchar(255) NOT NULL,
  `harga` int(11) NOT NULL,
  `stok` int(11) NOT NULL,
  `desk` text,
  `id_kategori` varchar(10) DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_produk`
--

INSERT INTO `tb_produk` (`id_produk`, `nm_produk`, `harga`, `stok`, `desk`, `id_kategori`, `gambar`) VALUES
('P001', 'Sofa L', 6400000, 3, 'Sofa L /Sofa Sudut/Sofa L Minimalis/Kursi L /Sofa Tamu VENUS IVARO', 'K001', 'e0402eb930e8b30e7dddea2173f7a23f.jpg'),
('P002', 'Meja Tamu Minimalis', 600000, 5, 'Meja tamu minimalis,meja keluarga,meja minimalis modern', 'K001', '09f61ffb6e34b99ab9ce3d01a7e1c260.webp'),
('P003', 'Meja TV', 400000, 5, 'Meja Tv minimalis', 'K001', '588f7727211de0412e07bf39a5ec62c6.jpg'),
('P004', 'Kursi Bean Bag', 735000, 10, 'Kursi Santai Bean Bag', 'K001', '2d89537850d263de538ac4f76adc5af9.jpg'),
('P005', 'Kursi', 400000, 5, 'Kursi', 'K007', 'fb529259694e8ca55d9498152e9f6e37.png'),
('P006', 'Sofa', 1730000, 3, 'Sofa', 'K001', '14e4453e0d9580ff69687122b8993d50.png'),
('P007', 'Kursi Warna Orange', 500000, 5, 'Kursi', 'K007', 'e8c187f3e6aeb6da7ae6663997ec6854.png');

-- --------------------------------------------------------

--
-- Table structure for table `tb_user`
--

CREATE TABLE `tb_user` (
  `id_user` varchar(10) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` enum('admin','customer') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_user`
--

INSERT INTO `tb_user` (`id_user`, `username`, `password`, `status`) VALUES
('U001', 'admin', '$2y$10$IxlldD22I11421mUAUSZGeYxeb.6uRjB0JCtDhdj4NFliB/8eVebC', 'admin'),
('U002', 'dea', '$2y$10$RclucPgMS/o6u2ZIQMPDAujES3MPFPDzdh99QEWiOk4xXw7LqVo5S', 'customer');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_jual`
--
ALTER TABLE `tb_jual`
  ADD PRIMARY KEY (`id_jual`),
  ADD UNIQUE KEY `no_transaksi` (`no_transaksi`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `tb_jualdtl`
--
ALTER TABLE `tb_jualdtl`
  ADD PRIMARY KEY (`id_jual`,`id_produk`),
  ADD KEY `id_produk` (`id_produk`);

--
-- Indexes for table `tb_kategori`
--
ALTER TABLE `tb_kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `tb_pesanan`
--
ALTER TABLE `tb_pesanan`
  ADD PRIMARY KEY (`id_pesanan`),
  ADD KEY `id_produk` (`id_produk`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `tb_produk`
--
ALTER TABLE `tb_produk`
  ADD PRIMARY KEY (`id_produk`),
  ADD KEY `id_kategori` (`id_kategori`);

--
-- Indexes for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_jual`
--
ALTER TABLE `tb_jual`
  ADD CONSTRAINT `tb_jual_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `tb_user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_jualdtl`
--
ALTER TABLE `tb_jualdtl`
  ADD CONSTRAINT `tb_jualdtl_ibfk_1` FOREIGN KEY (`id_jual`) REFERENCES `tb_jual` (`id_jual`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_jualdtl_ibfk_2` FOREIGN KEY (`id_produk`) REFERENCES `tb_produk` (`id_produk`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_pesanan`
--
ALTER TABLE `tb_pesanan`
  ADD CONSTRAINT `tb_pesanan_ibfk_1` FOREIGN KEY (`id_produk`) REFERENCES `tb_produk` (`id_produk`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_pesanan_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `tb_user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_produk`
--
ALTER TABLE `tb_produk`
  ADD CONSTRAINT `tb_produk_ibfk_1` FOREIGN KEY (`id_kategori`) REFERENCES `tb_kategori` (`id_kategori`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
