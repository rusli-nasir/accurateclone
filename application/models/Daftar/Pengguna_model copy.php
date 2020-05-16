<?php
class Pengguna_model extends CI_Model
{
  public function getTableDivisi()
  {
    $this->db->select('id, nama_divisi as nama');
    $this->db->from('divisi');
    return $this->db->get()->result_array();
  }

  // public function getListOfFeatures()
  // {
  //   return array("buku_besar", "info_perusahaan", "mata_uang", "daftar_akun", "laporan_keuangan", "bukti_jurnal_umum", "proses_akhir_bulan", "kas_bank", "buku_bank", "penerimaan", "pembayaran", "rekonsiliasi_bank", "persediaan", "daftar_gudang", "grup", "barang_dan_jasa", "penyesuaian_persediaan", "pembiayaan_pesanan", "set_harga_penjualan", "pindah_barang", "penjualan", "penawaran_penjualan", "pesanan_penjualan", "pengiriman_pesanan", "faktur_penjualan", "penerimaan_penjualan", "retur_penjualan", "pembelian", "permintaan_pembelian", "pesanan_pembelian", "penerimaan_barang", "faktur_pembelian", "pembayaran_pembelian", "retur_pembelian", "aset_tetap", "tipe_aktiva_baru", "tipe_aktiva_tetap_pajak", "tipe_aktiva_tetap", "daftar_aktiva_tetap", "daftar", "pemasok", "pelanggan", "penjual", "pengguna", "rma", "klaim_pelanggan", "aktivitas_proses_klaim", "faktur_penjualan", "efaktur", "spt");
  // }

  private function _isAnyOnBigMenu($divisi_id, $kategori_fitur)
  {
    $sql = "
      SELECT kategori_fitur
      FROM hak_akses
      WHERE divisi_id = $divisi_id AND kategori_fitur=$kategori_fitur
      LIMIT 1
    ";
    $result = $this->db->query($sql)->row_array();

    if (empty($result))
      return false;
    else
      return true;
  }

  public function getHakAksesDivisi($divisi_id)
  {
    $this->db->select('html_id, is_enabled');
    $this->db->from('hak_akses');
    $this->db->where('divisi_id', $divisi_id);
    return $this->db->get()->result_array();
  }

  private function _getPostValue($name)
  {
    if (empty($_POST["$name"]))
      return '';
    else
      return $_POST["$name"];
  }

  private function _insertHakAkses($divisi_id, $data_ref, $kategori_fitur)
  {
    foreach ($data_ref as $hak) {
      if (empty($hak['is_enable']))
        $is_enabled = 0;
      else
        $is_enabled = 1;

      $temp = array(
        'divisi_id' => $divisi_id,
        'kategori_fitur' => $kategori_fitur,
        'fitur' => $hak['fitur'],
        'html_id' => $hak['html_id'],
        'is_enabled' => $is_enabled
      );

      $this->db->insert('hak_akses', $temp);
    }
  }

  public function simpanDivisi()
  {
    $data_divisi = array(
      'nama_divisi' => $_POST['nama_divisi']
    );
    $this->db->insert('divisi', $data_divisi);

    $sql = "
      SELECT id
      FROM divisi
      ORDER BY id DESC
      LIMIT 1
    ";
    $divisi_id = $this->db->query($sql)->row_array();

    if (!empty($divisi_id)) {
      echo 'masuk';
      $divisi_id = $divisi_id['id'];

      $data_buku_besar = array(
        array(
          "fitur" => 'BukuBesar',
          "html_id" => 'buku_besar',
          'is_enable' => $this->_getPostValue('info_perusahaan')
        ),
        array(
          "fitur" => 'InfoPerusahaan',
          "html_id" => 'info_perusahaan',
          'is_enable' => $this->_getPostValue('info_perusahaan')
        ),
        array(
          "fitur" => 'MataUang',
          "html_id" => 'mata_uang',
          'is_enable' => $this->_getPostValue('mata_uang')
        ),
        array(
          "fitur" => 'DaftarAkun',
          "html_id" => 'daftar_akun',
          'is_enable' => $this->_getPostValue('daftar_akun')
        ),
        array(
          "fitur" => 'LaporanKeuangan',
          "html_id" => 'laporan_keuangan',
          'is_enable' => $this->_getPostValue('laporan_keuangan')
        ),
        array(
          "fitur" => 'BuktiJurnalUmum',
          "html_id" => 'bukti_jurnal_umum',
          'is_enable' => $this->_getPostValue('bukti_jurnal_umum')
        ),
        array(
          "fitur" => 'ProsesAkhirBulan',
          "html_id" => 'proses_akhir_bulan',
          'is_enable' => $this->_getPostValue('proses_akhir_bulan')
        )
      );
      $data_kas_bank = array(
        array(
          "fitur" => 'KasBank',
          "html_id" => 'kas_bank',
          'is_enable' => $this->_getPostValue('buku_bank')
        ),
        array(
          "fitur" => 'BukuBank',
          "html_id" => 'buku_bank',
          'is_enable' => $this->_getPostValue('buku_bank')
        ),
        array(
          "fitur" => 'Penerimaan',
          "html_id" => 'penerimaan',
          'is_enable' => $this->_getPostValue('penerimaan')
        ),
        array(
          "fitur" => 'Pembayaran',
          "html_id" => 'pembayaran',
          'is_enable' => $this->_getPostValue('pembayaran')
        ),
        array(
          "fitur" => 'RekonsiliasiBank',
          "html_id" => 'rekonsiliasi_bank',
          'is_enable' => $this->_getPostValue('rekonsiliasi_bank')
        )
      );
      $data_persediaan = array(
        array(
          "fitur" => 'Persediaan',
          "html_id" => 'persediaan',
          'is_enable' => $this->_getPostValue('daftar_gudang')
        ),
        array(
          "fitur" => 'DaftarGudang',
          "html_id" => 'daftar_gudang',
          'is_enable' => $this->_getPostValue('daftar_gudang')
        ),
        array(
          "fitur" => 'Grup',
          "html_id" => 'grup',
          'is_enable' => $this->_getPostValue('grup')
        ),
        array(
          "fitur" => 'BarangJasa',
          "html_id" => 'barang_dan_jasa',
          'is_enable' => $this->_getPostValue('barang_dan_jasa')
        ),
        array(
          "fitur" => 'PenyeseuaianPersediaan',
          "html_id" => 'penyesuaian_persediaan',
          'is_enable' => $this->_getPostValue('penyesuaian_persediaan')
        ),
        array(
          "fitur" => 'PembiayaanPesanan',
          "html_id" => 'pembiayaan_pesanan',
          'is_enable' => $this->_getPostValue('pembiayaan_pesanan')
        ),
        array(
          "fitur" => 'SetHargaPenjualan',
          "html_id" => 'set_harga_penjualan',
          'is_enable' => $this->_getPostValue('set_harga_penjualan')
        ),
        array(
          "fitur" => 'PindahBarang',
          "html_id" => 'pindah_barang',
          'is_enable' => $this->_getPostValue('pindah_barang')
        )
      );
      $data_penjualan = array(
        array(
          "fitur" => 'Penjualan',
          "html_id" => 'penjualan',
          'is_enable' => $this->_getPostValue('penawaran_penjualan')
        ),
        array(
          "fitur" => 'PenawaranPenjualan',
          "html_id" => 'penawaran_penjualan',
          'is_enable' => $this->_getPostValue('pesanan_penjualan')
        ),
        array(
          "fitur" => 'PesananPenjualan',
          "html_id" => 'pesanan_penjualan',
          'is_enable' => $this->_getPostValue('pesanan_penjualan')
        ),
        array(
          "fitur" => 'PengirimanPesanan',
          "html_id" => 'pengiriman_pesanan',
          'is_enable' => $this->_getPostValue('pengiriman_pesanan')
        ),
        array(
          "fitur" => 'FakturPenjualan',
          "html_id" => 'faktur_penjualan',
          'is_enable' => $this->_getPostValue('faktur_penjualan')
        ),
        array(
          "fitur" => 'PenerimaanPenjualan',
          "html_id" => 'penerimaan_penjualan',
          'is_enable' => $this->_getPostValue('penerimaan_penjualan')
        ),
        array(
          "fitur" => 'ReturPenjualan',
          "html_id" => 'retur_penjualan',
          'is_enable' => $this->_getPostValue('retur_penjualan')
        )
      );
      $data_pembelian = array(
        array(
          "fitur" => 'Pembelian',
          "html_id" => 'pembelian',
          'is_enable' => $this->_getPostValue('permintaan_pembelian')
        ),
        array(
          "fitur" => 'PermintaanPembelian',
          "html_id" => 'permintaan_pembelian',
          'is_enable' => $this->_getPostValue('pesanan_pembelian')
        ),
        array(
          "fitur" => 'PesananPembelian',
          "html_id" => 'pesanan_pembelian',
          'is_enable' => $this->_getPostValue('pesanan_pembelian')
        ),
        array(
          "fitur" => 'PenerimaanBarang',
          "html_id" => 'penerimaan_barang',
          'is_enable' => $this->_getPostValue('penerimaan_barang')
        ),
        array(
          "fitur" => 'FakturPembelian',
          "html_id" => 'faktur_pembelian',
          'is_enable' => $this->_getPostValue('faktur_pembelian')
        ),
        array(
          "fitur" => 'PembayaranPembelian',
          "html_id" => 'pembayaran_pembelian',
          'is_enable' => $this->_getPostValue('pembayaran_pembelian')
        ),
        array(
          "fitur" => 'ReturPembelian',
          "html_id" => 'retur_pembelian',
          'is_enable' => $this->_getPostValue('retur_pembelian')
        )
      );
      $data_aset_tetap = array(
        array(
          "fitur" => 'AsetTetap',
          "html_id" => 'aset_tetap',
          'is_enable' => $this->_getPostValue('aset_tetap')
        ),
        array(
          "fitur" => 'AktivaTetapBaru',
          "html_id" => 'aktiva_tetap_baru',
          'is_enable' => $this->_getPostValue('aktiva_tetap_baru')
        ),
        array(
          "fitur" => 'TipeAktivaTetapPajak',
          "html_id" => 'tipe_aktiva_tetap_pajak',
          'is_enable' => $this->_getPostValue('tipe_aktiva_tetap_pajak')
        ),
        array(
          "fitur" => 'TipeAktivaTetap',
          "html_id" => 'tipe_aktiva_tetap',
          'is_enable' => $this->_getPostValue('tipe_aktiva_tetap')
        ),
        array(
          "fitur" => 'DaftarAktivaTetap',
          "html_id" => 'daftar_aktiva_tetap',
          'is_enable' => $this->_getPostValue('daftar_aktiva_tetap')
        )
      );
      $data_daftar = array(
        array(
          "fitur" => 'Daftar',
          "html_id" => 'daftar',
          'is_enable' => $this->_getPostValue('pemasok')
        ),
        array(
          "fitur" => 'Pemasok',
          "html_id" => 'pemasok',
          'is_enable' => $this->_getPostValue('pemasok')
        ),
        array(
          "fitur" => 'Pelanggan',
          "html_id" => 'pelanggan',
          'is_enable' => $this->_getPostValue('pelanggan')
        ),
        array(
          "fitur" => 'Penjual',
          "html_id" => 'penjual',
          'is_enable' => $this->_getPostValue('penjual')
        ),
        array(
          "fitur" => 'Pengguna',
          "html_id" => 'pengguna',
          'is_enable' => $this->_getPostValue('pengguna')
        )
      );
      $data_rma = array(
        array(
          "fitur" => 'RMA',
          "html_id" => 'rma',
          'is_enable' => $this->_getPostValue('klaim_pelanggan')
        ),
        array(
          "fitur" => 'KlaimPelanggan',
          "html_id" => 'klaim_pelanggan',
          'is_enable' => $this->_getPostValue('klaim_pelanggan')
        ),
        array(
          "fitur" => 'AktivitasProsesKlaim',
          "html_id" => 'aktivitas_proses_klaim',
          'is_enable' => $this->_getPostValue('aktivitas_proses_klaim')
        ),
        array(
          "fitur" => 'FakturPenjualan',
          "html_id" => 'faktur_penjualan',
          'is_enable' => $this->_getPostValue('faktur_penjualan')
        )
      );
      $data_efaktur = array(
        array(
          "fitur" => 'EFaktur',
          "html_id" => 'efaktur',
          'is_enable' => $this->_getPostValue('spt')
        ),
        array(
          "fitur" => 'SPTPPN',
          "html_id" => 'spt',
          'is_enable' => $this->_getPostValue('spt')
        )
      );

      $this->_insertHakAkses($divisi_id, $data_buku_besar, 'BukuBesar');
      $this->_insertHakAkses($divisi_id, $data_kas_bank, 'KasBank');
      $this->_insertHakAkses($divisi_id, $data_persediaan, 'Persediaan');
      $this->_insertHakAkses($divisi_id, $data_penjualan, 'Penjualan');
      $this->_insertHakAkses($divisi_id, $data_pembelian, 'Pembelian');
      $this->_insertHakAkses($divisi_id, $data_aset_tetap, 'AsetTetap');
      $this->_insertHakAkses($divisi_id, $data_daftar, 'Daftar');
      $this->_insertHakAkses($divisi_id, $data_rma, 'RMA');
      $this->_insertHakAkses($divisi_id, $data_efaktur, 'EFaktur');
    }
  }
}
