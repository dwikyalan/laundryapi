-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 05 Mei 2020 pada 12.18
-- Versi Server: 10.1.30-MariaDB
-- PHP Version: 5.6.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bersihlaundry`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_admin`
--

CREATE TABLE `tb_admin` (
  `id` varchar(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `level` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_admin`
--

INSERT INTO `tb_admin` (`id`, `nama`, `password`, `level`) VALUES
('KSR180001', 'admin', 'YWRtaW4=', 'Admin');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_detail_transaksi`
--

CREATE TABLE `tb_detail_transaksi` (
  `id_detail_transaksi` int(11) NOT NULL,
  `id_transaksi` varchar(50) NOT NULL,
  `id_paket` varchar(50) NOT NULL,
  `tgl_transaksi` date NOT NULL,
  `harga` varchar(50) NOT NULL,
  `tgl_pengiriman` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_detail_transaksi`
--

INSERT INTO `tb_detail_transaksi` (`id_detail_transaksi`, `id_transaksi`, `id_paket`, `tgl_transaksi`, `harga`, `tgl_pengiriman`) VALUES
(1, 'TRN-20200420100440-7', 'PKT20001', '2020-05-05', '4000', '0000-00-00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_komplain`
--

CREATE TABLE `tb_komplain` (
  `id_komplain` int(11) NOT NULL,
  `id_konsumen` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `komplain` text NOT NULL,
  `balasan` text NOT NULL,
  `gambar` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_konsumen`
--

CREATE TABLE `tb_konsumen` (
  `id_konsumen` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `alamat` text NOT NULL,
  `hp` varchar(13) NOT NULL,
  `email` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `jenis_kelamin` varchar(50) NOT NULL,
  `gambar` varchar(250) NOT NULL,
  `activated` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `group_user` int(11) NOT NULL,
  `last_login` datetime NOT NULL,
  `last_update` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_konsumen`
--

INSERT INTO `tb_konsumen` (`id_konsumen`, `nama`, `alamat`, `hp`, `email`, `username`, `password`, `jenis_kelamin`, `gambar`, `activated`, `created`, `group_user`, `last_login`, `last_update`) VALUES
(1, 'dimas', 'sidoarjo', '0879464946', 'dimas@gmail.com', 'dimas risky', '7d49e40f4b3d8f68c19406a58303f826', 'L', '', 1, '2020-04-21 06:06:34', 0, '0000-00-00 00:00:00', '2020-04-21 06:06:34'),
(12, 'aku', 'malang', '0484544', 'dwikyalanadi@gmail.com', 'aku', '89ccfac87d8d06db06bf3211cb2d69ed', 'L', '', 1, '2020-04-21 06:09:01', 0, '0000-00-00 00:00:00', '2020-04-21 06:09:01'),
(13, 'samis', 'malang', '075767', 'samid@gmail.com', 'samid', '183302b157a276e7304caab75d9f45d2', 'L', '', 1, '2020-04-23 07:12:28', 2, '0000-00-00 00:00:00', '2020-04-23 07:12:28'),
(14, 'z', 'z', '86464', 'sjksks', 'z', 'fbade9e36a3f36d3d676c1b808451dd7', 'P', '', 1, '2020-04-28 07:18:09', 2, '0000-00-00 00:00:00', '2020-04-28 07:18:09');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_paket`
--

CREATE TABLE `tb_paket` (
  `id_paket` varchar(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `harga` varchar(50) NOT NULL,
  `deskripsi` text NOT NULL,
  `gambar` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_paket`
--

INSERT INTO `tb_paket` (`id_paket`, `nama`, `harga`, `deskripsi`, `gambar`) VALUES
('PKT20001', 'Cuci Kering Setrika', '5000', 'Cuci', ''),
('PKT20002', 'Setrika', '4000', 'Setrika', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_transaksi`
--

CREATE TABLE `tb_transaksi` (
  `id_transaksi` varchar(50) NOT NULL,
  `id_konsumen` int(11) NOT NULL,
  `id_paket` varchar(50) NOT NULL,
  `tgl_transaksi` date NOT NULL,
  `tgl_pengiriman` date NOT NULL,
  `jml_kilo` varchar(11) NOT NULL,
  `total_harga` varchar(50) NOT NULL,
  `status_laundry` varchar(50) NOT NULL,
  `status_pembayaran` varchar(50) NOT NULL,
  `bukti_transfer` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_transaksi`
--

INSERT INTO `tb_transaksi` (`id_transaksi`, `id_konsumen`, `id_paket`, `tgl_transaksi`, `tgl_pengiriman`, `jml_kilo`, `total_harga`, `status_laundry`, `status_pembayaran`, `bukti_transfer`) VALUES
('TRN-20200420100440-7', 12, 'PKT20001', '2020-05-05', '0000-00-00', '', '', '', 'Belum Lunas', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_admin`
--
ALTER TABLE `tb_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_detail_transaksi`
--
ALTER TABLE `tb_detail_transaksi`
  ADD PRIMARY KEY (`id_detail_transaksi`),
  ADD KEY `fk_transaksi` (`id_transaksi`),
  ADD KEY `fk_paket2` (`id_paket`);

--
-- Indexes for table `tb_komplain`
--
ALTER TABLE `tb_komplain`
  ADD PRIMARY KEY (`id_komplain`);

--
-- Indexes for table `tb_konsumen`
--
ALTER TABLE `tb_konsumen`
  ADD PRIMARY KEY (`id_konsumen`);

--
-- Indexes for table `tb_paket`
--
ALTER TABLE `tb_paket`
  ADD PRIMARY KEY (`id_paket`);

--
-- Indexes for table `tb_transaksi`
--
ALTER TABLE `tb_transaksi`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD KEY `fk_paket` (`id_paket`),
  ADD KEY `fk_konsumen` (`id_konsumen`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_detail_transaksi`
--
ALTER TABLE `tb_detail_transaksi`
  MODIFY `id_detail_transaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_konsumen`
--
ALTER TABLE `tb_konsumen`
  MODIFY `id_konsumen` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `tb_detail_transaksi`
--
ALTER TABLE `tb_detail_transaksi`
  ADD CONSTRAINT `fk_paket2` FOREIGN KEY (`id_paket`) REFERENCES `tb_paket` (`id_paket`),
  ADD CONSTRAINT `fk_transaksi` FOREIGN KEY (`id_transaksi`) REFERENCES `tb_transaksi` (`id_transaksi`);

--
-- Ketidakleluasaan untuk tabel `tb_transaksi`
--
ALTER TABLE `tb_transaksi`
  ADD CONSTRAINT `fk_konsumen` FOREIGN KEY (`id_konsumen`) REFERENCES `tb_konsumen` (`id_konsumen`),
  ADD CONSTRAINT `fk_paket` FOREIGN KEY (`id_paket`) REFERENCES `tb_paket` (`id_paket`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
