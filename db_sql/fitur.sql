-- ========================================================================================================================
--                                     UTILITY MENU
-- ========================================================================================================================

INSERT INTO utility_menu (nama_menu, link_menu, html_id_menu, icon)
VALUES ('Buku Besar', 'BukuBesar', 'buku_besar', 'fa-book');

INSERT INTO utility_menu (nama_menu, link_menu, html_id_menu, icon)
VALUES ('Kas Bank', 'KasBank', 'kas_bank', 'fa-money-check');

INSERT INTO utility_menu (nama_menu, link_menu, html_id_menu, icon)
VALUES ('Persediaan', 'Persediaan', 'persediaan', 'fa-boxes');

INSERT INTO utility_menu (nama_menu, link_menu, html_id_menu, icon)
VALUES ('Penjualan', 'Penjualan', 'penjualan', 'fa-cash-register');

INSERT INTO utility_menu (nama_menu, link_menu, html_id_menu, icon)
VALUES ('Pembelian', 'Pembelian', 'pembelian', 'fa-shopping-cart');

INSERT INTO utility_menu (nama_menu, link_menu, html_id_menu, icon)
VALUES ('Aset Tetap', 'AsetTetap', 'aset_tetap', 'fa-hotel');

INSERT INTO utility_menu (nama_menu, link_menu, html_id_menu, icon)
VALUES ('Daftar', 'Daftar', 'daftar', 'fa-list-ul');

INSERT INTO utility_menu (nama_menu, link_menu, html_id_menu, icon)
VALUES ('RMA', 'RMA', 'rma', 'fa-envelope-open-text');

INSERT INTO utility_menu (nama_menu, link_menu, html_id_menu, icon)
VALUES ('E-Faktur', 'EFaktur', 'efaktur', 'fa-cash-register');

-- ========================================================================================================================
--                                     UTILITY FITUR
-- ========================================================================================================================

INSERT INTO utility_fitur (utility_menu_id, nama_fitur, link_fitur, html_id_fitur, icon)
VALUES (1, 'Info Perusahaan', 'InfoPerusahaan', 'info_perusahaan', 'info_perusahaan.png');

INSERT INTO utility_fitur (utility_menu_id, nama_fitur, link_fitur, html_id_fitur, icon)
VALUES (1, 'Mata Uang', 'MataUang', 'mata_uang', 'mata_uang.png');

INSERT INTO utility_fitur (utility_menu_id, nama_fitur, link_fitur, html_id_fitur, icon)
VALUES (1, 'Daftar Akun', 'DaftarAkun', 'daftar_akun', 'daftar_akun.png');

INSERT INTO utility_fitur (utility_menu_id, nama_fitur, link_fitur, html_id_fitur, icon)
VALUES (1, 'Laporan Keuangan', 'LaporanKeuangan', 'laporan_keuangan', 'laporan_keuangan.png');

INSERT INTO utility_fitur (utility_menu_id, nama_fitur, link_fitur, html_id_fitur, icon)
VALUES (1, 'Bukti Jurnal Umum', 'BuktiJurnalUmum', 'bukti_jurnal', 'bukti_jurnal.png');

INSERT INTO utility_fitur (utility_menu_id, nama_fitur, link_fitur, html_id_fitur, icon)
VALUES (1, 'Proses Akhir Bulan', 'ProsesAkhirBulan', 'proses_akhir_bulan', 'proses_akhir_bulan.png');

-- ========================================================================================================================

INSERT INTO utility_fitur (utility_menu_id, nama_fitur, link_fitur, html_id_fitur, icon)
VALUES (2, 'Buku Bank', 'BukuBank', 'buku_bank', 'buku_bank.png');

INSERT INTO utility_fitur (utility_menu_id, nama_fitur, link_fitur, html_id_fitur, icon)
VALUES (2, 'Penerimaan', 'Penerimaan', 'penerimaan', 'penerimaan.png');

INSERT INTO utility_fitur (utility_menu_id, nama_fitur, link_fitur, html_id_fitur, icon)
VALUES (2, 'Pembayaran', 'Pembayaran', 'pembayaran', 'pembayaran.png');

INSERT INTO utility_fitur (utility_menu_id, nama_fitur, link_fitur, html_id_fitur, icon)
VALUES (2, 'Rekonsiliasi Bank', 'RekonsiliasiBank', 'rekonsiliasi_bank', 'rekonsiliasi_bank.png');

-- ========================================================================================================================

INSERT INTO utility_fitur (utility_menu_id, nama_fitur, link_fitur, html_id_fitur, icon)
VALUES (3, 'Daftar Gudang', 'DaftarGudang', 'daftar_gudang', 'daftar_gudang.png');

INSERT INTO utility_fitur (utility_menu_id, nama_fitur, link_fitur, html_id_fitur, icon)
VALUES (3, 'Grup', 'Grup', 'grup', 'grup.png');

INSERT INTO utility_fitur (utility_menu_id, nama_fitur, link_fitur, html_id_fitur, icon)
VALUES (3, 'Barang dan Jasa', 'BarangJasa', 'barang_dan_jasa', 'barang_dan_jasa.png');

INSERT INTO utility_fitur (utility_menu_id, nama_fitur, link_fitur, html_id_fitur, icon)
VALUES (3, 'Penyeseuaian Persediaan', 'PenyeseuaianPersediaan', 'penyesuaian_persediaan', 'penyesuaian_persediaan.png');

INSERT INTO utility_fitur (utility_menu_id, nama_fitur, link_fitur, html_id_fitur, icon)
VALUES (3, 'Pembiayaan Pesanan', 'PembiayaanPesanan', 'pembiayaan_pesanan', 'pembiayaan_pesanan.png');

INSERT INTO utility_fitur (utility_menu_id, nama_fitur, link_fitur, html_id_fitur, icon)
VALUES (3, 'Set Harga Penjualan', 'SetHargaPenjualan', 'set_harga_penjualan', 'set_harga_penjualan.png');

INSERT INTO utility_fitur (utility_menu_id, nama_fitur, link_fitur, html_id_fitur, icon)
VALUES (3, 'Pindah Barang', 'PindahBarang', 'pindah_barang', 'pindah_barang.png');

-- ========================================================================================================================

INSERT INTO utility_fitur (utility_menu_id, nama_fitur, link_fitur, html_id_fitur, icon)
VALUES (4, 'Penawaran Penjualan', 'PenawaranPenjualan', 'penawaran_penjualan', 'penawaran_penjualan.png');

INSERT INTO utility_fitur (utility_menu_id, nama_fitur, link_fitur, html_id_fitur, icon)
VALUES (4, 'Pesanan Penjualan', 'PesananPenjualan', 'pesanan_penjualan', 'pesanan_penjualan.png');

INSERT INTO utility_fitur (utility_menu_id, nama_fitur, link_fitur, html_id_fitur, icon)
VALUES (4, 'Pengiriman Pesanan', 'PengirimanPesanan', 'pengiriman_pesanan', 'pengiriman_pesanan.png');

INSERT INTO utility_fitur (utility_menu_id, nama_fitur, link_fitur, html_id_fitur, icon)
VALUES (4, 'Faktur Penjualan', 'FakturPenjualan', 'faktur_penjualan', 'faktur_penjualan.png');

INSERT INTO utility_fitur (utility_menu_id, nama_fitur, link_fitur, html_id_fitur, icon)
VALUES (4, 'Penerimaan Penjualan', 'PenerimaanPenjualan', 'penerimaan_penjualan', 'penerimaan_penjualan.png');

INSERT INTO utility_fitur (utility_menu_id, nama_fitur, link_fitur, html_id_fitur, icon)
VALUES (4, 'Retur Penjualan', 'ReturPenjualan', 'retur_penjualan', 'retur_penjualan.png');

-- ========================================================================================================================

INSERT INTO utility_fitur (utility_menu_id, nama_fitur, link_fitur, html_id_fitur, icon)
VALUES (5, 'Permintaan Pembelian', 'PermintaanPembelian', 'permintaan_pembelian', 'permintaan_pembelian.png');

INSERT INTO utility_fitur (utility_menu_id, nama_fitur, link_fitur, html_id_fitur, icon)
VALUES (5, 'Pesanan Pembelian', 'PesananPembelian', 'pesanan_pembelian', 'pesanan_pembelian.png');

INSERT INTO utility_fitur (utility_menu_id, nama_fitur, link_fitur, html_id_fitur, icon)
VALUES (5, 'Penerimaan Barang', 'PenerimaanBarang', 'penerimaan_barang', 'penerimaan_barang.png');

INSERT INTO utility_fitur (utility_menu_id, nama_fitur, link_fitur, html_id_fitur, icon)
VALUES (5, 'Faktur Pembelian', 'FakturPembelian', 'faktur_pembelian', 'faktur_pembelian.png');

INSERT INTO utility_fitur (utility_menu_id, nama_fitur, link_fitur, html_id_fitur, icon)
VALUES (5, 'Pembayaran Pembelian', 'PembayaranPembelian', 'pembayaran_pembelian', 'pembayaran_pembelian.png');

INSERT INTO utility_fitur (utility_menu_id, nama_fitur, link_fitur, html_id_fitur, icon)
VALUES (5, 'Retur Pembelian', 'ReturPembelian', 'retur_pembelian', 'retur_pembelian.png');

-- ========================================================================================================================

INSERT INTO utility_fitur (utility_menu_id, nama_fitur, link_fitur, html_id_fitur, icon)
VALUES (6, 'Aktiva Tetap Baru', 'AktivaTetapBaru', 'aktiva_tetap_baru', 'aktiva_tetap_baru.png');

INSERT INTO utility_fitur (utility_menu_id, nama_fitur, link_fitur, html_id_fitur, icon)
VALUES (6, 'Tipe Aktiva Tetap Pajak', 'TipeAktivaTetapPajak', 'tipe_aktiva_tetap_pajak', 'tipe_aktiva_tetap_pajak.png');

INSERT INTO utility_fitur (utility_menu_id, nama_fitur, link_fitur, html_id_fitur, icon)
VALUES (6, 'Tipe Aktiva Tetap', 'TipeAktivaTetap', 'tipe_aktiva_tetap', 'tipe_aktiva_tetap.png');

INSERT INTO utility_fitur (utility_menu_id, nama_fitur, link_fitur, html_id_fitur, icon)
VALUES (6, 'Daftar Aktiva Tetap', 'DaftarAktivaTetap', 'daftar_aktiva_tetap', 'daftar_aktiva_tetap.png');

-- ========================================================================================================================

INSERT INTO utility_fitur (utility_menu_id, nama_fitur, link_fitur, html_id_fitur, icon)
VALUES (7, 'Pemasok', 'Pemasok', 'pemasok', 'pemasok.png');

INSERT INTO utility_fitur (utility_menu_id, nama_fitur, link_fitur, html_id_fitur, icon)
VALUES (7, 'Pelanggan', 'Pelanggan', 'pelanggan', 'pelanggan.png');

INSERT INTO utility_fitur (utility_menu_id, nama_fitur, link_fitur, html_id_fitur, icon)
VALUES (7, 'Penjual', 'Penjual', 'penjual', 'penjual.png');

INSERT INTO utility_fitur (utility_menu_id, nama_fitur, link_fitur, html_id_fitur, icon)
VALUES (7, 'Pengguna', 'Pengguna', 'pengguna', 'pengguna.png');

-- ========================================================================================================================

INSERT INTO utility_fitur (utility_menu_id, nama_fitur, link_fitur, html_id_fitur, icon)
VALUES (8, 'Klaim Pelanggan', 'KlaimPelanggan', 'klaim_pelanggan', 'klaim_pelanggan.png');

INSERT INTO utility_fitur (utility_menu_id, nama_fitur, link_fitur, html_id_fitur, icon)
VALUES (8, 'Aktivitas Proses Klaim', 'AktivitasProsesKlaim', 'aktivitas_proses_klaim', 'aktivitas_proses_klaim.png');

INSERT INTO utility_fitur (utility_menu_id, nama_fitur, link_fitur, html_id_fitur, icon)
VALUES (8, 'Faktur Penjualan', 'FakturPenjualan', 'faktur_penjualan', 'faktur_penjualan.png');


-- ========================================================================================================================

INSERT INTO utility_fitur (utility_menu_id, nama_fitur, link_fitur, html_id_fitur, icon)
VALUES (9, 'SPT Masa PPN (e-Spt, e-Faktur)', 'SPTPPN', 'efaktur', 'efaktur.png');