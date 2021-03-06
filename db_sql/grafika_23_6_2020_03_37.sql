-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 22, 2020 at 10:36 PM
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
-- Table structure for table `daftar_jasa_pengiriman`
--

CREATE TABLE `daftar_jasa_pengiriman` (
  `id` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `daftar_jasa_pengiriman`
--

INSERT INTO `daftar_jasa_pengiriman` (`id`, `nama`) VALUES
(4, 'Pick Up'),
(5, 'COD'),
(6, 'JNE'),
(7, 'JNT');

-- --------------------------------------------------------

--
-- Table structure for table `daftar_pelanggan`
--

CREATE TABLE `daftar_pelanggan` (
  `id` int(11) NOT NULL,
  `nama_pelanggan` varchar(80) NOT NULL,
  `alamat` text NOT NULL,
  `telepon` varchar(20) NOT NULL,
  `kontak` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `daftar_pelanggan`
--

INSERT INTO `daftar_pelanggan` (`id`, `nama_pelanggan`, `alamat`, `telepon`, `kontak`) VALUES
(3, 'CASH', 'CASH', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `daftar_pemasok`
--

CREATE TABLE `daftar_pemasok` (
  `id` int(11) NOT NULL,
  `nama_pemasok` varchar(80) NOT NULL,
  `alamat` text NOT NULL,
  `telepon` varchar(20) NOT NULL,
  `kontak` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `daftar_pemasok`
--

INSERT INTO `daftar_pemasok` (`id`, `nama_pemasok`, `alamat`, `telepon`, `kontak`) VALUES
(3, 'PT. Philips', 'Jakarta Selatan', '21312342', 'Pak Budi'),
(4, 'PT. Panasonic', 'Jakarta Utara', '12312453', 'Pak Joko');

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
(4, 'Supervisor');

-- --------------------------------------------------------

--
-- Table structure for table `info_perusahaan`
--

CREATE TABLE `info_perusahaan` (
  `id` int(11) NOT NULL,
  `nama_perusahaan` varchar(80) NOT NULL,
  `alamat` text NOT NULL,
  `telepon` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `info_perusahaan`
--

INSERT INTO `info_perusahaan` (`id`, `nama_perusahaan`, `alamat`, `telepon`) VALUES
(1, 'Grafika', 'Cibaduyut, Bandung', '0274-081081');

-- --------------------------------------------------------

--
-- Table structure for table `pembelian_daftar_barang_faktur_pembelian`
--

CREATE TABLE `pembelian_daftar_barang_faktur_pembelian` (
  `id` int(11) NOT NULL,
  `persediaan_daftar_barang_id` int(11) NOT NULL,
  `qty_terima` int(11) NOT NULL,
  `persediaan_stok_barang_id` int(11) NOT NULL,
  `pembelian_form_faktur_pembelian_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pembelian_daftar_barang_faktur_pembelian`
--

INSERT INTO `pembelian_daftar_barang_faktur_pembelian` (`id`, `persediaan_daftar_barang_id`, `qty_terima`, `persediaan_stok_barang_id`, `pembelian_form_faktur_pembelian_id`) VALUES
(9, 14, 140, 53, 1),
(17, 13, 100, 61, 2),
(18, 14, 30, 62, 3);

-- --------------------------------------------------------

--
-- Table structure for table `pembelian_daftar_barang_penerimaan_barang`
--

CREATE TABLE `pembelian_daftar_barang_penerimaan_barang` (
  `id` int(11) NOT NULL,
  `persediaan_daftar_barang_id` int(11) NOT NULL,
  `qty_terima` int(11) NOT NULL,
  `persediaan_stok_barang_id` int(11) NOT NULL,
  `pembelian_form_penerimaan_barang_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pembelian_daftar_barang_penerimaan_barang`
--

INSERT INTO `pembelian_daftar_barang_penerimaan_barang` (`id`, `persediaan_daftar_barang_id`, `qty_terima`, `persediaan_stok_barang_id`, `pembelian_form_penerimaan_barang_id`) VALUES
(3, 14, 60, 51, 8);

-- --------------------------------------------------------

--
-- Table structure for table `pembelian_daftar_barang_pesanan_pembelian`
--

CREATE TABLE `pembelian_daftar_barang_pesanan_pembelian` (
  `id` int(11) NOT NULL,
  `persediaan_daftar_barang_id` int(11) NOT NULL,
  `qty_beli` int(11) NOT NULL,
  `harga_unit` bigint(20) NOT NULL,
  `diskon` int(11) NOT NULL,
  `subtotal` bigint(20) NOT NULL,
  `qty_diterima` int(11) NOT NULL,
  `pembelian_form_pesanan_pembelian_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pembelian_daftar_barang_pesanan_pembelian`
--

INSERT INTO `pembelian_daftar_barang_pesanan_pembelian` (`id`, `persediaan_daftar_barang_id`, `qty_beli`, `harga_unit`, `diskon`, `subtotal`, `qty_diterima`, `pembelian_form_pesanan_pembelian_id`) VALUES
(11, 14, 200, 10000, 10, 1800000, 200, 3),
(15, 14, 30, 12000, 0, 360000, 30, 4),
(16, 13, 100, 10000, 0, 1000000, 100, 5);

-- --------------------------------------------------------

--
-- Table structure for table `pembelian_data_dp_faktur_pembelian`
--

CREATE TABLE `pembelian_data_dp_faktur_pembelian` (
  `id` int(11) NOT NULL,
  `deskripsi` varchar(100) NOT NULL,
  `jumlah_dp` bigint(20) NOT NULL,
  `pembelian_form_faktur_pembelian_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `pembelian_form_faktur_pembelian`
--

CREATE TABLE `pembelian_form_faktur_pembelian` (
  `id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `nilai_faktur` bigint(20) NOT NULL,
  `uang_muka` bigint(20) NOT NULL,
  `is_row_dp` tinyint(1) NOT NULL,
  `pembelian_form_pesanan_pembelian_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pembelian_form_faktur_pembelian`
--

INSERT INTO `pembelian_form_faktur_pembelian` (`id`, `tanggal`, `nilai_faktur`, `uang_muka`, `is_row_dp`, `pembelian_form_pesanan_pembelian_id`) VALUES
(1, '2020-06-15', 2280000, 0, 0, 3),
(2, '2020-06-22', 1000000, 0, 0, 5),
(3, '2020-06-22', 1260000, 0, 0, 4);

-- --------------------------------------------------------

--
-- Table structure for table `pembelian_form_penerimaan_barang`
--

CREATE TABLE `pembelian_form_penerimaan_barang` (
  `id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `deskripsi` text NOT NULL,
  `pembelian_form_pesanan_pembelian_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pembelian_form_penerimaan_barang`
--

INSERT INTO `pembelian_form_penerimaan_barang` (`id`, `tanggal`, `deskripsi`, `pembelian_form_pesanan_pembelian_id`) VALUES
(8, '2020-06-15', 'Pengiriman tahap pertama', 3);

-- --------------------------------------------------------

--
-- Table structure for table `pembelian_form_pesanan_pembelian`
--

CREATE TABLE `pembelian_form_pesanan_pembelian` (
  `id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `alamat_ship_to` text NOT NULL,
  `deskripsi` text NOT NULL,
  `subtotal_overall` bigint(20) NOT NULL,
  `pengiriman_via` varchar(50) NOT NULL,
  `biaya_pengiriman` bigint(20) NOT NULL,
  `diskon_overall` int(11) NOT NULL,
  `jumlah_diskon_overall` bigint(20) NOT NULL,
  `is_hitung_ppn` tinyint(1) NOT NULL,
  `pajak_ppn` bigint(20) NOT NULL,
  `total_biaya` bigint(20) NOT NULL,
  `is_uang_muka` tinyint(1) NOT NULL,
  `is_done` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pembelian_form_pesanan_pembelian`
--

INSERT INTO `pembelian_form_pesanan_pembelian` (`id`, `tanggal`, `supplier_id`, `alamat_ship_to`, `deskripsi`, `subtotal_overall`, `pengiriman_via`, `biaya_pengiriman`, `diskon_overall`, `jumlah_diskon_overall`, `is_hitung_ppn`, `pajak_ppn`, `total_biaya`, `is_uang_muka`, `is_done`) VALUES
(3, '2020-06-14', 3, 'Cibaduyut, Bandung', 'Untuk reseller jogja', 1800000, 'JNE', 300000, 0, 0, 1, 180000, 2280000, 0, 1),
(4, '2020-06-22', 3, 'Bantul, Jogja', '', 1260000, '', 0, 0, 0, 0, 0, 1260000, 0, 1),
(5, '2020-06-22', 4, 'Bantul, Jogja', '', 1000000, '', 0, 0, 0, 0, 0, 1000000, 0, 1);

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
('eekrain', '$2y$10$k9N4AkYkZbeLM803I9cAH.FKEwYs6Cyk9eT4k9uPHNU8qcQ49USK6', 'Ardian Eka Candra', '089668957876', 'Jogja', 4);

-- --------------------------------------------------------

--
-- Table structure for table `penjualan_daftar_barang_pengiriman_barang`
--

CREATE TABLE `penjualan_daftar_barang_pengiriman_barang` (
  `id` int(11) NOT NULL,
  `persediaan_daftar_barang_id` int(11) NOT NULL,
  `persediaan_stok_barang_id` int(11) NOT NULL,
  `penjualan_form_pengiriman_barang_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `penjualan_daftar_barang_pesanan_penjualan`
--

CREATE TABLE `penjualan_daftar_barang_pesanan_penjualan` (
  `id` int(11) NOT NULL,
  `persediaan_daftar_barang_id` int(11) NOT NULL,
  `qty_jual` int(11) NOT NULL,
  `harga_unit` bigint(20) NOT NULL,
  `diskon` int(11) NOT NULL,
  `subtotal` bigint(20) NOT NULL,
  `qty_terkirim` int(11) NOT NULL,
  `penjualan_form_pesanan_penjualan_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `penjualan_daftar_barang_pesanan_penjualan`
--

INSERT INTO `penjualan_daftar_barang_pesanan_penjualan` (`id`, `persediaan_daftar_barang_id`, `qty_jual`, `harga_unit`, `diskon`, `subtotal`, `qty_terkirim`, `penjualan_form_pesanan_penjualan_id`) VALUES
(1, 14, 330, 20000, 0, 6600000, 0, 1),
(2, 15, 33, 35000, 0, 1155000, 0, 2);

-- --------------------------------------------------------

--
-- Table structure for table `penjualan_form_pengiriman_barang`
--

CREATE TABLE `penjualan_form_pengiriman_barang` (
  `id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `deskripsi` text NOT NULL,
  `penjualan_form_pesanan_penjualan_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `penjualan_form_pesanan_penjualan`
--

CREATE TABLE `penjualan_form_pesanan_penjualan` (
  `id` int(11) NOT NULL,
  `tanggal_penjualan` date NOT NULL,
  `ship_date` date NOT NULL,
  `daftar_jasa_pengiriman_id` int(11) NOT NULL,
  `daftar_pelanggan_id` int(11) NOT NULL,
  `alamat_ship_to` text NOT NULL,
  `deskripsi` text NOT NULL,
  `subtotal_overall` bigint(20) NOT NULL,
  `diskon_overall` int(11) NOT NULL,
  `jumlah_diskon_overall` bigint(20) NOT NULL,
  `biaya_pengiriman` bigint(20) NOT NULL,
  `total_biaya` bigint(20) NOT NULL,
  `is_uang_muka` tinyint(1) NOT NULL,
  `is_done` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `penjualan_form_pesanan_penjualan`
--

INSERT INTO `penjualan_form_pesanan_penjualan` (`id`, `tanggal_penjualan`, `ship_date`, `daftar_jasa_pengiriman_id`, `daftar_pelanggan_id`, `alamat_ship_to`, `deskripsi`, `subtotal_overall`, `diskon_overall`, `jumlah_diskon_overall`, `biaya_pengiriman`, `total_biaya`, `is_uang_muka`, `is_done`) VALUES
(1, '2020-06-19', '2020-06-19', 5, 3, 'CASH', 'Coba Jual', 6600000, 0, 0, 0, 6600000, 0, 0),
(2, '2020-06-19', '2020-06-19', 4, 3, 'CASH', 'Coba Jual 2', 1155000, 0, 0, 50000, 1205000, 0, 0);

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
  `saldo_awal_tanggal` date NOT NULL,
  `harga_jual` bigint(20) NOT NULL,
  `diskon` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `persediaan_daftar_barang`
--

INSERT INTO `persediaan_daftar_barang` (`id`, `tipe_barang`, `kode_barang`, `keterangan`, `persediaan_kategori_barang_id`, `default_gudang_id`, `unit`, `saldo_awal_kuantitas`, `saldo_awal_harga_per_unit`, `saldo_awal_harga_pokok`, `saldo_awal_gudang_id`, `saldo_awal_tanggal`, `harga_jual`, `diskon`) VALUES
(13, 'Persediaan', 'Led-Pns-15', 'Led Panasonic 15 Watt', 3, 3, 'pcs', 50, 15000, 750000, 3, '2020-06-04', 25000, 0),
(14, 'Persediaan', 'Led-Ph-15', 'Led Philips 15 Watt', 3, 3, 'pcs', 100, 12000, 1200000, 3, '2020-06-04', 20000, 0),
(15, 'Persediaan', 'Led-Ph-30', 'Led Philips 30 Watt', 3, 3, 'pcs', 70, 20000, 1400000, 3, '2020-06-04', 35000, 0);

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
(3, 'Gudang Belakang', '', 'Krapyak, Sewon, Bantul', 'Eko Patriot'),
(4, 'Gudang 2', '', 'Sleman, Jogja', 'Jojo'),
(5, 'Gudang 1', '', 'Bantul, Jogja', 'JOJI'),
(6, 'Workshop', '', 'Jogja', 'Bp. Ian');

-- --------------------------------------------------------

--
-- Table structure for table `persediaan_form_penyesuaian_stok`
--

CREATE TABLE `persediaan_form_penyesuaian_stok` (
  `id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `persediaan_form_pindah_barang`
--

CREATE TABLE `persediaan_form_pindah_barang` (
  `id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `keterangan` text NOT NULL,
  `dari_gudang_id` int(11) NOT NULL,
  `ke_gudang_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `persediaan_form_set_harga_penjualan`
--

CREATE TABLE `persediaan_form_set_harga_penjualan` (
  `id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `persediaan_harga_penjualan`
--

CREATE TABLE `persediaan_harga_penjualan` (
  `id` int(11) NOT NULL,
  `persediaan_daftar_barang_id` int(11) NOT NULL,
  `harga_jual` bigint(20) NOT NULL,
  `diskon` int(11) NOT NULL,
  `persediaan_form_set_harga_penjualan_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
(3, 'Lampu LED'),
(5, 'Kacang');

-- --------------------------------------------------------

--
-- Table structure for table `persediaan_stok_barang`
--

CREATE TABLE `persediaan_stok_barang` (
  `id` int(11) NOT NULL,
  `persediaan_daftar_barang_id` int(11) NOT NULL,
  `stok` int(11) NOT NULL,
  `persediaan_daftar_gudang_id` int(11) NOT NULL,
  `persediaan_form_penyesuaian_stok_id` int(11) NOT NULL,
  `persediaan_form_pindah_barang_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `persediaan_stok_barang`
--

INSERT INTO `persediaan_stok_barang` (`id`, `persediaan_daftar_barang_id`, `stok`, `persediaan_daftar_gudang_id`, `persediaan_form_penyesuaian_stok_id`, `persediaan_form_pindah_barang_id`) VALUES
(51, 14, 60, 3, 0, 0),
(53, 14, 140, 3, 0, 0),
(61, 13, 100, 5, 0, 0),
(62, 14, 30, 5, 0, 0);

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
(11, 3, 'Daftar Gudang', 'DaftarGudang', 'daftar_gudang', 'daftar_gudang.png'),
(13, 3, 'Barang dan Jasa', 'BarangJasa', 'barang_dan_jasa', 'barang_dan_jasa.png'),
(14, 3, 'Penyeseuaian Persediaan', 'PenyeseuaianPersediaan', 'penyesuaian_persediaan', 'penyesuaian_persediaan.png'),
(16, 3, 'Set Harga Penjualan', 'SetHargaPenjualan', 'set_harga_penjualan', 'set_harga_penjualan.png'),
(17, 3, 'Pindah Barang', 'PindahBarang', 'pindah_barang', 'pindah_barang.png'),
(19, 4, 'Pesanan Penjualan', 'PesananPenjualan', 'pesanan_penjualan', 'pesanan_penjualan.png'),
(20, 4, 'Pengiriman Pesanan', 'PengirimanPesanan', 'pengiriman_pesanan', 'pengiriman_pesanan.png'),
(21, 4, 'Faktur Penjualan', 'FakturPenjualan', 'faktur_penjualan', 'faktur_penjualan.png'),
(25, 5, 'Pesanan Pembelian', 'PesananPembelian', 'pesanan_pembelian', 'pesanan_pembelian.png'),
(26, 5, 'Penerimaan Barang', 'PenerimaanBarang', 'penerimaan_barang', 'penerimaan_barang.png'),
(27, 5, 'Faktur Pembelian', 'FakturPembelian', 'faktur_pembelian', 'faktur_pembelian.png'),
(34, 7, 'Pemasok', 'Pemasok', 'pemasok', 'pemasok.png'),
(35, 7, 'Pelanggan', 'Pelanggan', 'pelanggan', 'pelanggan.png'),
(37, 7, 'Pengguna', 'Pengguna', 'pengguna', 'pengguna.png'),
(42, 7, 'Jasa Pengiriman', 'JasaPengiriman', 'jasa_pengiriman', 'pengiriman_pesanan.png');

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
(86, 4, 11, 1),
(87, 4, 13, 1),
(88, 4, 14, 1),
(90, 4, 16, 1),
(91, 4, 17, 1),
(93, 4, 19, 1),
(94, 4, 20, 1),
(95, 4, 21, 1),
(99, 4, 25, 1),
(100, 4, 26, 1),
(101, 4, 27, 1),
(104, 4, 34, 1),
(105, 4, 35, 1),
(107, 4, 37, 1),
(108, 4, 42, 1);

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
(1, 4, 1, 1),
(18, 4, 3, 1),
(19, 4, 4, 1),
(20, 4, 5, 1),
(21, 4, 7, 1);

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
(1, 'Info Perusahaan', 'InfoPerusahaan', 'info_perusahaan', 'fa-hotel'),
(3, 'Persediaan', 'Persediaan', 'persediaan', 'fa-boxes'),
(4, 'Penjualan', 'Penjualan', 'penjualan', 'fa-cash-register'),
(5, 'Pembelian', 'Pembelian', 'pembelian', 'fa-shopping-cart'),
(7, 'Daftar', 'Daftar', 'daftar', 'fa-list-ul');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `daftar_jasa_pengiriman`
--
ALTER TABLE `daftar_jasa_pengiriman`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `daftar_pelanggan`
--
ALTER TABLE `daftar_pelanggan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `daftar_pemasok`
--
ALTER TABLE `daftar_pemasok`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `divisi`
--
ALTER TABLE `divisi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `info_perusahaan`
--
ALTER TABLE `info_perusahaan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pembelian_daftar_barang_faktur_pembelian`
--
ALTER TABLE `pembelian_daftar_barang_faktur_pembelian`
  ADD PRIMARY KEY (`id`),
  ADD KEY `INDEX barang faktur_pembelian` (`persediaan_daftar_barang_id`),
  ADD KEY `INDEX stok faktur_pembelian` (`persediaan_stok_barang_id`),
  ADD KEY `INDEX form faktur_pembelian` (`pembelian_form_faktur_pembelian_id`) USING BTREE;

--
-- Indexes for table `pembelian_daftar_barang_penerimaan_barang`
--
ALTER TABLE `pembelian_daftar_barang_penerimaan_barang`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `INDEX stok` (`persediaan_stok_barang_id`) USING BTREE,
  ADD KEY `INDEX barang` (`persediaan_daftar_barang_id`) USING BTREE,
  ADD KEY `INDEX form` (`pembelian_form_penerimaan_barang_id`);

--
-- Indexes for table `pembelian_daftar_barang_pesanan_pembelian`
--
ALTER TABLE `pembelian_daftar_barang_pesanan_pembelian`
  ADD PRIMARY KEY (`id`),
  ADD KEY `INDEX form` (`pembelian_form_pesanan_pembelian_id`) USING BTREE,
  ADD KEY `INDEX barang` (`persediaan_daftar_barang_id`);

--
-- Indexes for table `pembelian_data_dp_faktur_pembelian`
--
ALTER TABLE `pembelian_data_dp_faktur_pembelian`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pembelian_form_faktur_pembelian`
--
ALTER TABLE `pembelian_form_faktur_pembelian`
  ADD PRIMARY KEY (`id`),
  ADD KEY `INDEX pesanan faktur_pembelian` (`pembelian_form_pesanan_pembelian_id`) USING BTREE;

--
-- Indexes for table `pembelian_form_penerimaan_barang`
--
ALTER TABLE `pembelian_form_penerimaan_barang`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `INDEX penerimaan barang form pesanan` (`pembelian_form_pesanan_pembelian_id`) USING BTREE;

--
-- Indexes for table `pembelian_form_pesanan_pembelian`
--
ALTER TABLE `pembelian_form_pesanan_pembelian`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `penjualan_daftar_barang_pengiriman_barang`
--
ALTER TABLE `penjualan_daftar_barang_pengiriman_barang`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `INDEX stok daftar_pengiriman_barang` (`persediaan_stok_barang_id`),
  ADD KEY `INDEX barang daftar_pengiriman_barang` (`persediaan_daftar_barang_id`),
  ADD KEY `INDEX form daftar_pengiriman_barang` (`penjualan_form_pengiriman_barang_id`);

--
-- Indexes for table `penjualan_daftar_barang_pesanan_penjualan`
--
ALTER TABLE `penjualan_daftar_barang_pesanan_penjualan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `INDEX barang barang_pesanan` (`persediaan_daftar_barang_id`),
  ADD KEY `INDEX form barang_pesanan` (`penjualan_form_pesanan_penjualan_id`);

--
-- Indexes for table `penjualan_form_pengiriman_barang`
--
ALTER TABLE `penjualan_form_pengiriman_barang`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQUE form_pesanan pengiririman_barang` (`penjualan_form_pesanan_penjualan_id`) USING BTREE;

--
-- Indexes for table `penjualan_form_pesanan_penjualan`
--
ALTER TABLE `penjualan_form_pesanan_penjualan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `INDEX jasa_pengiriman form` (`daftar_jasa_pengiriman_id`),
  ADD KEY `INDEX pelanggan form` (`daftar_pelanggan_id`);

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
-- Indexes for table `persediaan_form_penyesuaian_stok`
--
ALTER TABLE `persediaan_form_penyesuaian_stok`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `persediaan_form_pindah_barang`
--
ALTER TABLE `persediaan_form_pindah_barang`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `FK dari_gudang` (`dari_gudang_id`),
  ADD KEY `FK ke_gudang` (`ke_gudang_id`) USING BTREE;

--
-- Indexes for table `persediaan_form_set_harga_penjualan`
--
ALTER TABLE `persediaan_form_set_harga_penjualan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `persediaan_harga_penjualan`
--
ALTER TABLE `persediaan_harga_penjualan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK form` (`persediaan_form_set_harga_penjualan_id`),
  ADD KEY `FK daftar_barang` (`persediaan_daftar_barang_id`) USING BTREE;

--
-- Indexes for table `persediaan_kategori_barang`
--
ALTER TABLE `persediaan_kategori_barang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `persediaan_stok_barang`
--
ALTER TABLE `persediaan_stok_barang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK gudang` (`persediaan_daftar_gudang_id`) USING BTREE,
  ADD KEY `FK barang` (`persediaan_daftar_barang_id`) USING BTREE;

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
-- AUTO_INCREMENT for table `daftar_jasa_pengiriman`
--
ALTER TABLE `daftar_jasa_pengiriman`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `daftar_pelanggan`
--
ALTER TABLE `daftar_pelanggan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `daftar_pemasok`
--
ALTER TABLE `daftar_pemasok`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `divisi`
--
ALTER TABLE `divisi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `info_perusahaan`
--
ALTER TABLE `info_perusahaan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pembelian_daftar_barang_faktur_pembelian`
--
ALTER TABLE `pembelian_daftar_barang_faktur_pembelian`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `pembelian_daftar_barang_penerimaan_barang`
--
ALTER TABLE `pembelian_daftar_barang_penerimaan_barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pembelian_daftar_barang_pesanan_pembelian`
--
ALTER TABLE `pembelian_daftar_barang_pesanan_pembelian`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `pembelian_data_dp_faktur_pembelian`
--
ALTER TABLE `pembelian_data_dp_faktur_pembelian`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `pembelian_form_penerimaan_barang`
--
ALTER TABLE `pembelian_form_penerimaan_barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `penjualan_daftar_barang_pengiriman_barang`
--
ALTER TABLE `penjualan_daftar_barang_pengiriman_barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `penjualan_daftar_barang_pesanan_penjualan`
--
ALTER TABLE `penjualan_daftar_barang_pesanan_penjualan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `persediaan_daftar_barang`
--
ALTER TABLE `persediaan_daftar_barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `persediaan_daftar_gudang`
--
ALTER TABLE `persediaan_daftar_gudang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `persediaan_form_penyesuaian_stok`
--
ALTER TABLE `persediaan_form_penyesuaian_stok`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `persediaan_form_pindah_barang`
--
ALTER TABLE `persediaan_form_pindah_barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `persediaan_form_set_harga_penjualan`
--
ALTER TABLE `persediaan_form_set_harga_penjualan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `persediaan_harga_penjualan`
--
ALTER TABLE `persediaan_harga_penjualan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `persediaan_kategori_barang`
--
ALTER TABLE `persediaan_kategori_barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `persediaan_stok_barang`
--
ALTER TABLE `persediaan_stok_barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `utility_fitur`
--
ALTER TABLE `utility_fitur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `utility_hak_akses_fitur`
--
ALTER TABLE `utility_hak_akses_fitur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- AUTO_INCREMENT for table `utility_hak_akses_menu`
--
ALTER TABLE `utility_hak_akses_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `utility_menu`
--
ALTER TABLE `utility_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pembelian_daftar_barang_faktur_pembelian`
--
ALTER TABLE `pembelian_daftar_barang_faktur_pembelian`
  ADD CONSTRAINT `FK barang faktur_pembelian` FOREIGN KEY (`persediaan_daftar_barang_id`) REFERENCES `persediaan_daftar_barang` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK form faktur_pembelian` FOREIGN KEY (`pembelian_form_faktur_pembelian_id`) REFERENCES `pembelian_form_faktur_pembelian` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK stok faktur_pembelian` FOREIGN KEY (`persediaan_stok_barang_id`) REFERENCES `persediaan_stok_barang` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `pembelian_daftar_barang_penerimaan_barang`
--
ALTER TABLE `pembelian_daftar_barang_penerimaan_barang`
  ADD CONSTRAINT `FK barang penerimaan_barang` FOREIGN KEY (`persediaan_daftar_barang_id`) REFERENCES `persediaan_daftar_barang` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK form penerimaan_barang` FOREIGN KEY (`pembelian_form_penerimaan_barang_id`) REFERENCES `pembelian_form_penerimaan_barang` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK stok penerimaan_barang` FOREIGN KEY (`persediaan_stok_barang_id`) REFERENCES `persediaan_stok_barang` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `pembelian_daftar_barang_pesanan_pembelian`
--
ALTER TABLE `pembelian_daftar_barang_pesanan_pembelian`
  ADD CONSTRAINT `FK barang_pesanan_pembelian` FOREIGN KEY (`persediaan_daftar_barang_id`) REFERENCES `persediaan_daftar_barang` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK form_pesanan_pembelian` FOREIGN KEY (`pembelian_form_pesanan_pembelian_id`) REFERENCES `pembelian_form_pesanan_pembelian` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `pembelian_form_faktur_pembelian`
--
ALTER TABLE `pembelian_form_faktur_pembelian`
  ADD CONSTRAINT `FK pesanan faktur_pembelian` FOREIGN KEY (`pembelian_form_pesanan_pembelian_id`) REFERENCES `pembelian_form_pesanan_pembelian` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `pembelian_form_penerimaan_barang`
--
ALTER TABLE `pembelian_form_penerimaan_barang`
  ADD CONSTRAINT `FK penerimaan barang form pesanan` FOREIGN KEY (`pembelian_form_pesanan_pembelian_id`) REFERENCES `pembelian_form_pesanan_pembelian` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `penjualan_daftar_barang_pengiriman_barang`
--
ALTER TABLE `penjualan_daftar_barang_pengiriman_barang`
  ADD CONSTRAINT `FK barang daftar_pengiriman_barang` FOREIGN KEY (`persediaan_daftar_barang_id`) REFERENCES `persediaan_daftar_barang` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK form daftar_pengiriman_barang` FOREIGN KEY (`penjualan_form_pengiriman_barang_id`) REFERENCES `penjualan_form_pengiriman_barang` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK stok daftar_pengiriman_barang` FOREIGN KEY (`persediaan_stok_barang_id`) REFERENCES `persediaan_stok_barang` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `penjualan_daftar_barang_pesanan_penjualan`
--
ALTER TABLE `penjualan_daftar_barang_pesanan_penjualan`
  ADD CONSTRAINT `FK barang barang_pesanan_penjualan` FOREIGN KEY (`persediaan_daftar_barang_id`) REFERENCES `persediaan_daftar_barang` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK form barang_pesanan_penjualan` FOREIGN KEY (`penjualan_form_pesanan_penjualan_id`) REFERENCES `penjualan_form_pesanan_penjualan` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `penjualan_form_pengiriman_barang`
--
ALTER TABLE `penjualan_form_pengiriman_barang`
  ADD CONSTRAINT `FK form_pesanan pengiririman_barang` FOREIGN KEY (`penjualan_form_pesanan_penjualan_id`) REFERENCES `penjualan_form_pesanan_penjualan` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `penjualan_form_pesanan_penjualan`
--
ALTER TABLE `penjualan_form_pesanan_penjualan`
  ADD CONSTRAINT `FK jasa_pengiriman form_pesanan_penjualan` FOREIGN KEY (`daftar_jasa_pengiriman_id`) REFERENCES `daftar_jasa_pengiriman` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK pelanggan form_pesanan_penjualan` FOREIGN KEY (`daftar_pelanggan_id`) REFERENCES `daftar_pelanggan` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `persediaan_daftar_barang`
--
ALTER TABLE `persediaan_daftar_barang`
  ADD CONSTRAINT `FK gudang default` FOREIGN KEY (`default_gudang_id`) REFERENCES `persediaan_daftar_gudang` (`id`),
  ADD CONSTRAINT `FK gudang saldo awal` FOREIGN KEY (`saldo_awal_gudang_id`) REFERENCES `persediaan_daftar_gudang` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK kategori` FOREIGN KEY (`persediaan_kategori_barang_id`) REFERENCES `persediaan_kategori_barang` (`id`);

--
-- Constraints for table `persediaan_form_pindah_barang`
--
ALTER TABLE `persediaan_form_pindah_barang`
  ADD CONSTRAINT `FK dari_gudang` FOREIGN KEY (`dari_gudang_id`) REFERENCES `persediaan_daftar_gudang` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK ke_gudang` FOREIGN KEY (`ke_gudang_id`) REFERENCES `persediaan_daftar_gudang` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `persediaan_harga_penjualan`
--
ALTER TABLE `persediaan_harga_penjualan`
  ADD CONSTRAINT `FK daftar_barang` FOREIGN KEY (`persediaan_daftar_barang_id`) REFERENCES `persediaan_daftar_barang` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK form` FOREIGN KEY (`persediaan_form_set_harga_penjualan_id`) REFERENCES `persediaan_form_set_harga_penjualan` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `persediaan_stok_barang`
--
ALTER TABLE `persediaan_stok_barang`
  ADD CONSTRAINT `FK barang` FOREIGN KEY (`persediaan_daftar_barang_id`) REFERENCES `persediaan_daftar_barang` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK gudang` FOREIGN KEY (`persediaan_daftar_gudang_id`) REFERENCES `persediaan_daftar_gudang` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `utility_fitur`
--
ALTER TABLE `utility_fitur`
  ADD CONSTRAINT `FK utility_menu` FOREIGN KEY (`utility_menu_id`) REFERENCES `utility_menu` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
