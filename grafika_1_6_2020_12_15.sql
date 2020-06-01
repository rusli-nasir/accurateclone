-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 01, 2020 at 07:14 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `grafika`
--

-- --------------------------------------------------------

--
-- Table structure for table `divisi`
--

CREATE TABLE `divisi` (
  `id` int(11) NOT NULL,
  `nama_divisi` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `divisi`
--

INSERT INTO `divisi` (`id`, `nama_divisi`) VALUES
(1, 'Supervisor');

-- --------------------------------------------------------

--
-- Table structure for table `pengguna`
--

CREATE TABLE `pengguna` (
  `username` varchar(20) NOT NULL,
  `password` varchar(60) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `cp` varchar(20) NOT NULL,
  `alamat` text NOT NULL,
  `divisi_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pengguna`
--

INSERT INTO `pengguna` (`username`, `password`, `nama`, `cp`, `alamat`, `divisi_id`) VALUES
('eekrain', '$2y$10$IkjRBdtxVZiDAyTWAT2UDuVO7P0.EPNOy4IQ873PXmIwJvxAvkTse', 'Ardian Eka Candra', '', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `persediaan_daftar_barang`
--

CREATE TABLE `persediaan_daftar_barang` (
  `id` int(11) NOT NULL,
  `tipe_barang` varchar(20) NOT NULL,
  `kode_barang` varchar(10) NOT NULL,
  `keterangan` varchar(50) NOT NULL,
  `persediaan_kategori_barang_id` int(11) NOT NULL,
  `default_gudang_id` int(11) NOT NULL,
  `unit` varchar(3) NOT NULL,
  `saldo_awal_kuantitas` int(11) NOT NULL,
  `saldo_awal_harga_per_unit` bigint(20) NOT NULL,
  `saldo_awal_harga_pokok` bigint(20) NOT NULL,
  `saldo_awal_gudang_id` int(11) NOT NULL,
  `saldo_awal_tanggal` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `persediaan_daftar_barang`
--

INSERT INTO `persediaan_daftar_barang` (`id`, `tipe_barang`, `kode_barang`, `keterangan`, `persediaan_kategori_barang_id`, `default_gudang_id`, `unit`, `saldo_awal_kuantitas`, `saldo_awal_harga_per_unit`, `saldo_awal_harga_pokok`, `saldo_awal_gudang_id`, `saldo_awal_tanggal`) VALUES
(2, 'Persediaan', 'Led-Ph-15', 'LED Philips 15 Watt', 3, 3, 'pcs', 50, 10000, 300000, 3, '2020-06-01'),
(3, 'Persediaan', 'Led-Ph-30', 'LED Philips 30 Watt', 3, 3, 'pcs', 30, 25000, 1250000, 3, '2020-06-01');

-- --------------------------------------------------------

--
-- Table structure for table `persediaan_daftar_gudang`
--

CREATE TABLE `persediaan_daftar_gudang` (
  `id` int(11) NOT NULL,
  `nama_gudang` varchar(50) NOT NULL,
  `keterangan` text NOT NULL,
  `alamat` text NOT NULL,
  `penanggung_jawab` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `persediaan_daftar_gudang`
--

INSERT INTO `persediaan_daftar_gudang` (`id`, `nama_gudang`, `keterangan`, `alamat`, `penanggung_jawab`) VALUES
(3, 'Gudang Belakang', '', '', 'Eko Patriot'),
(4, 'ASH', '', '', 'Jojo'),
(5, 'COBA', '', '', 'JOJI');

-- --------------------------------------------------------

--
-- Table structure for table `persediaan_harga_penjualan`
--

CREATE TABLE `persediaan_harga_penjualan` (
  `id` int(11) NOT NULL,
  `persediaan_daftar_barang_id` int(11) NOT NULL,
  `harga1` bigint(20) NOT NULL,
  `harga2` bigint(20) NOT NULL,
  `harga3` bigint(20) NOT NULL,
  `harga4` bigint(20) NOT NULL,
  `harga5` bigint(20) NOT NULL,
  `diskon` int(11) NOT NULL,
  `persediaan_form_set_harga_penjualan_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `persediaan_harga_penjualan`
--

INSERT INTO `persediaan_harga_penjualan` (`id`, `persediaan_daftar_barang_id`, `harga1`, `harga2`, `harga3`, `harga4`, `harga5`, `diskon`, `persediaan_form_set_harga_penjualan_id`) VALUES
(1, 2, 35000, 0, 0, 0, 0, 0, 0),
(2, 3, 50000, 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `persediaan_kategori_barang`
--

CREATE TABLE `persediaan_kategori_barang` (
  `id` int(11) NOT NULL,
  `nama_kategori` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `persediaan_kategori_barang`
--

INSERT INTO `persediaan_kategori_barang` (`id`, `nama_kategori`) VALUES
(3, 'Elektronik'),
(4, 'Kontol'),
(5, 'Kacang');

-- --------------------------------------------------------

--
-- Table structure for table `utility_fitur`
--

CREATE TABLE `utility_fitur` (
  `id` int(11) NOT NULL,
  `utility_menu_id` int(11) NOT NULL,
  `nama_fitur` varchar(50) NOT NULL,
  `link_fitur` varchar(50) NOT NULL,
  `html_id_fitur` varchar(50) NOT NULL,
  `icon` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `utility_fitur`
--

INSERT INTO `utility_fitur` (`id`, `utility_menu_id`, `nama_fitur`, `link_fitur`, `html_id_fitur`, `icon`) VALUES
(1, 1, 'Info Perusahaan', 'InfoPerusahaan', 'info_perusahaan', 'info_perusahaan.png'),
(2, 1, 'Mata Uang', 'MataUang', 'mata_uang', 'mata_uang.png'),
(3, 1, 'Daftar Akun', 'DaftarAkun', 'daftar_akun', 'daftar_akun.png'),
(4, 1, 'Laporan Keuangan', 'LaporanKeuangan', 'laporan_keuangan', 'laporan_keuangan.png'),
(5, 1, 'Bukti Jurnal Umum', 'BuktiJurnalUmum', 'bukti_jurnal', 'bukti_jurnal.png'),
(6, 1, 'Proses Akhir Bulan', 'ProsesAkhirBulan', 'proses_akhir_bulan', 'proses_akhir_bulan.png'),
(7, 2, 'Buku Bank', 'BukuBank', 'buku_bank', 'buku_bank.png'),
(8, 2, 'Penerimaan', 'Penerimaan', 'penerimaan', 'penerimaan.png'),
(9, 2, 'Pembayaran', 'Pembayaran', 'pembayaran', 'pembayaran.png'),
(10, 2, 'Rekonsiliasi Bank', 'RekonsiliasiBank', 'rekonsiliasi_bank', 'rekonsiliasi_bank.png'),
(11, 3, 'Daftar Gudang', 'DaftarGudang', 'daftar_gudang', 'daftar_gudang.png'),
(12, 3, 'Grup', 'Grup', 'grup', 'grup.png'),
(13, 3, 'Barang dan Jasa', 'BarangJasa', 'barang_dan_jasa', 'barang_dan_jasa.png'),
(14, 3, 'Penyeseuaian Persediaan', 'PenyeseuaianPersediaan', 'penyesuaian_persediaan', 'penyesuaian_persediaan.png'),
(15, 3, 'Pembiayaan Pesanan', 'PembiayaanPesanan', 'pembiayaan_pesanan', 'pembiayaan_pesanan.png'),
(16, 3, 'Set Harga Penjualan', 'SetHargaPenjualan', 'set_harga_penjualan', 'set_harga_penjualan.png'),
(17, 3, 'Pindah Barang', 'PindahBarang', 'pindah_barang', 'pindah_barang.png'),
(18, 4, 'Penawaran Penjualan', 'PenawaranPenjualan', 'penawaran_penjualan', 'penawaran_penjualan.png'),
(19, 4, 'Pesanan Penjualan', 'PesananPenjualan', 'pesanan_penjualan', 'pesanan_penjualan.png'),
(20, 4, 'Pengiriman Pesanan', 'PengirimanPesanan', 'pengiriman_pesanan', 'pengiriman_pesanan.png'),
(21, 4, 'Faktur Penjualan', 'FakturPenjualan', 'faktur_penjualan', 'faktur_penjualan.png'),
(22, 4, 'Penerimaan Penjualan', 'PenerimaanPenjualan', 'penerimaan_penjualan', 'penerimaan_penjualan.png'),
(23, 4, 'Retur Penjualan', 'ReturPenjualan', 'retur_penjualan', 'retur_penjualan.png'),
(24, 5, 'Permintaan Pembelian', 'PermintaanPembelian', 'permintaan_pembelian', 'permintaan_pembelian.png'),
(25, 5, 'Pesanan Pembelian', 'PesananPembelian', 'pesanan_pembelian', 'pesanan_pembelian.png'),
(26, 5, 'Penerimaan Barang', 'PenerimaanBarang', 'penerimaan_barang', 'penerimaan_barang.png'),
(27, 5, 'Faktur Pembelian', 'FakturPembelian', 'faktur_pembelian', 'faktur_pembelian.png'),
(28, 5, 'Pembayaran Pembelian', 'PembayaranPembelian', 'pembayaran_pembelian', 'pembayaran_pembelian.png'),
(29, 5, 'Retur Pembelian', 'ReturPembelian', 'retur_pembelian', 'retur_pembelian.png'),
(30, 6, 'Aktiva Tetap Baru', 'AktivaTetapBaru', 'aktiva_tetap_baru', 'aktiva_tetap_baru.png'),
(31, 6, 'Tipe Aktiva Tetap Pajak', 'TipeAktivaTetapPajak', 'tipe_aktiva_tetap_pajak', 'tipe_aktiva_tetap_pajak.png'),
(32, 6, 'Tipe Aktiva Tetap', 'TipeAktivaTetap', 'tipe_aktiva_tetap', 'tipe_aktiva_tetap.png'),
(33, 6, 'Daftar Aktiva Tetap', 'DaftarAktivaTetap', 'daftar_aktiva_tetap', 'daftar_aktiva_tetap.png'),
(34, 7, 'Pemasok', 'Pemasok', 'pemasok', 'pemasok.png'),
(35, 7, 'Pelanggan', 'Pelanggan', 'pelanggan', 'pelanggan.png'),
(36, 7, 'Penjual', 'Penjual', 'penjual', 'penjual.png'),
(37, 7, 'Pengguna', 'Pengguna', 'pengguna', 'pengguna.png'),
(38, 8, 'Klaim Pelanggan', 'KlaimPelanggan', 'klaim_pelanggan', 'klaim_pelanggan.png'),
(39, 8, 'Aktivitas Proses Klaim', 'AktivitasProsesKlaim', 'aktivitas_proses_klaim', 'aktivitas_proses_klaim.png'),
(40, 8, 'Faktur Penjualan', 'FakturPenjualan', 'faktur_penjualan', 'faktur_penjualan.png'),
(41, 9, 'SPT Masa PPN (e-Spt, e-Faktur)', 'SPTPPN', 'efaktur', 'efaktur.png');

-- --------------------------------------------------------

--
-- Table structure for table `utility_hak_akses_fitur`
--

CREATE TABLE `utility_hak_akses_fitur` (
  `id` int(11) NOT NULL,
  `divisi_id` int(11) NOT NULL,
  `utility_fitur_id` int(11) NOT NULL,
  `is_enabled` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `utility_hak_akses_fitur`
--

INSERT INTO `utility_hak_akses_fitur` (`id`, `divisi_id`, `utility_fitur_id`, `is_enabled`) VALUES
(1, 1, 1, 1),
(2, 1, 2, 1),
(3, 1, 3, 1),
(4, 1, 4, 1),
(5, 1, 5, 1),
(6, 1, 6, 1),
(7, 1, 7, 1),
(8, 1, 8, 1),
(9, 1, 9, 1),
(10, 1, 10, 1),
(11, 1, 11, 1),
(12, 1, 12, 1),
(13, 1, 13, 1),
(14, 1, 14, 1),
(15, 1, 15, 1),
(16, 1, 16, 1),
(17, 1, 17, 1),
(18, 1, 18, 1),
(19, 1, 19, 1),
(20, 1, 20, 1),
(21, 1, 21, 1),
(22, 1, 22, 1),
(23, 1, 23, 1),
(24, 1, 24, 1),
(25, 1, 25, 1),
(26, 1, 26, 1),
(27, 1, 27, 1),
(28, 1, 28, 1),
(29, 1, 29, 1),
(30, 1, 30, 1),
(31, 1, 31, 1),
(32, 1, 32, 1),
(33, 1, 33, 1),
(34, 1, 34, 1),
(35, 1, 35, 1),
(36, 1, 36, 1),
(37, 1, 37, 1),
(38, 1, 38, 1),
(39, 1, 39, 1),
(40, 1, 21, 1),
(41, 1, 41, 1);

-- --------------------------------------------------------

--
-- Table structure for table `utility_hak_akses_menu`
--

CREATE TABLE `utility_hak_akses_menu` (
  `id` int(11) NOT NULL,
  `divisi_id` int(11) NOT NULL,
  `utility_menu_id` int(11) NOT NULL,
  `is_enabled` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `utility_hak_akses_menu`
--

INSERT INTO `utility_hak_akses_menu` (`id`, `divisi_id`, `utility_menu_id`, `is_enabled`) VALUES
(1, 1, 1, 1),
(2, 1, 2, 1),
(3, 1, 3, 1),
(4, 1, 4, 1),
(5, 1, 5, 1),
(6, 1, 6, 1),
(7, 1, 7, 1),
(8, 1, 8, 1),
(9, 1, 9, 1);

-- --------------------------------------------------------

--
-- Table structure for table `utility_menu`
--

CREATE TABLE `utility_menu` (
  `id` int(11) NOT NULL,
  `nama_menu` varchar(50) NOT NULL,
  `link_menu` varchar(50) NOT NULL,
  `html_id_menu` varchar(50) NOT NULL,
  `icon` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `utility_menu`
--

INSERT INTO `utility_menu` (`id`, `nama_menu`, `link_menu`, `html_id_menu`, `icon`) VALUES
(1, 'Buku Besar', 'BukuBesar', 'buku_besar', 'fa-book'),
(2, 'Kas Bank', 'KasBank', 'kas_bank', 'fa-money-check'),
(3, 'Persediaan', 'Persediaan', 'persediaan', 'fa-boxes'),
(4, 'Penjualan', 'Penjualan', 'penjualan', 'fa-cash-register'),
(5, 'Pembelian', 'Pembelian', 'pembelian', 'fa-shopping-cart'),
(6, 'Aset Tetap', 'AsetTetap', 'aset_tetap', 'fa-hotel'),
(7, 'Daftar', 'Daftar', 'daftar', 'fa-list-ul'),
(8, 'RMA', 'RMA', 'rma', 'fa-envelope-open-text'),
(9, 'E-Faktur', 'EFaktur', 'efaktur', 'fa-cash-register');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `divisi`
--
ALTER TABLE `divisi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `persediaan_daftar_barang`
--
ALTER TABLE `persediaan_daftar_barang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK gudang` (`default_gudang_id`,`saldo_awal_gudang_id`),
  ADD KEY `FK gudang saldo awal` (`saldo_awal_gudang_id`),
  ADD KEY `FK kategori barang` (`persediaan_kategori_barang_id`);

--
-- Indexes for table `persediaan_daftar_gudang`
--
ALTER TABLE `persediaan_daftar_gudang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `persediaan_harga_penjualan`
--
ALTER TABLE `persediaan_harga_penjualan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK barang_jasa` (`persediaan_daftar_barang_id`),
  ADD KEY `FK form_set_harga` (`persediaan_form_set_harga_penjualan_id`) USING BTREE;

--
-- Indexes for table `persediaan_kategori_barang`
--
ALTER TABLE `persediaan_kategori_barang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `utility_fitur`
--
ALTER TABLE `utility_fitur`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK utility_menu` (`utility_menu_id`) USING BTREE;

--
-- Indexes for table `utility_hak_akses_fitur`
--
ALTER TABLE `utility_hak_akses_fitur`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `utility_hak_akses_menu`
--
ALTER TABLE `utility_hak_akses_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `utility_menu`
--
ALTER TABLE `utility_menu`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `divisi`
--
ALTER TABLE `divisi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `persediaan_daftar_barang`
--
ALTER TABLE `persediaan_daftar_barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `persediaan_daftar_gudang`
--
ALTER TABLE `persediaan_daftar_gudang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `persediaan_harga_penjualan`
--
ALTER TABLE `persediaan_harga_penjualan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `persediaan_kategori_barang`
--
ALTER TABLE `persediaan_kategori_barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `utility_fitur`
--
ALTER TABLE `utility_fitur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `utility_hak_akses_fitur`
--
ALTER TABLE `utility_hak_akses_fitur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `utility_hak_akses_menu`
--
ALTER TABLE `utility_hak_akses_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `utility_menu`
--
ALTER TABLE `utility_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `persediaan_daftar_barang`
--
ALTER TABLE `persediaan_daftar_barang`
  ADD CONSTRAINT `FK gudang default` FOREIGN KEY (`default_gudang_id`) REFERENCES `persediaan_daftar_gudang` (`id`),
  ADD CONSTRAINT `FK gudang saldo awal` FOREIGN KEY (`saldo_awal_gudang_id`) REFERENCES `persediaan_daftar_gudang` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK kategori` FOREIGN KEY (`persediaan_kategori_barang_id`) REFERENCES `persediaan_kategori_barang` (`id`);

--
-- Constraints for table `persediaan_harga_penjualan`
--
ALTER TABLE `persediaan_harga_penjualan`
  ADD CONSTRAINT `FK barang_jasa` FOREIGN KEY (`persediaan_daftar_barang_id`) REFERENCES `persediaan_daftar_barang` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `utility_fitur`
--
ALTER TABLE `utility_fitur`
  ADD CONSTRAINT `FK utility_menu` FOREIGN KEY (`utility_menu_id`) REFERENCES `utility_menu` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
