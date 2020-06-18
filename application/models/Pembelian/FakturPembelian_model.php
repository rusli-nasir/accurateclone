<?php
class FakturPembelian_model extends CI_Model
{
  public function getTableFakturPembelian()
  {
    $sql = "
      SELECT ff.id AS id_faktur, ff.tanggal, fp.id AS id_pesanan, s.nama_pemasok, ff.nilai_faktur, ff.uang_muka
      FROM pembelian_form_faktur_pembelian ff
      JOIN pembelian_form_pesanan_pembelian fp
        ON fp.id = ff.pembelian_form_pesanan_pembelian_id
      JOIN daftar_pemasok s
        ON s.id = fp.supplier_id
    ";
    return $this->db->query($sql)->result_array();
  }

  public function getTablePesanan()
  {
    $this->db->select('id, tanggal');
    $this->db->from('pembelian_form_pesanan_pembelian');
    $this->db->where('is_done', 0);
    $this->db->order_by('id', 'DESC');
    $list_pesanan = $this->db->get()->result_array();

    $this->db->select('id');
    $this->db->from('pembelian_form_pesanan_pembelian');
    $this->db->order_by('id', 'DESC');
    $this->db->limit(1);
    $last_id_temp = $this->db->get()->row_array();

    $last_id = 1;
    if (!empty($last_id_temp))
      $last_id = $last_id_temp['id'];

    foreach ($list_pesanan as $key => $val) {
      $id_pesanan = $list_pesanan[$key]['id'];
      $kode_pesanan = '';
      $digit = floor(log10($last_id) + 1);

      if ($digit <= 3)
        $kode_pesanan = str_pad($id_pesanan, 3, '0', STR_PAD_LEFT);
      else
        $kode_pesanan = str_pad($id_pesanan, $digit, '0', STR_PAD_LEFT);

      $list_pesanan[$key]['no'] = 'B-' . $kode_pesanan;
    }
    return $list_pesanan;
  }

  public function getLastKodeFakturPembelian()
  {
    $this->db->select('id');
    $this->db->from('pembelian_form_faktur_pembelian');
    $this->db->order_by('id', 'DESC');
    $this->db->limit(1);
    $last_id = $this->db->get()->row_array();

    $id_pesanan = 0;
    if (!empty($last_id))
      $id_pesanan = $last_id['id'];

    $id_pesanan++;

    $kode_invoice = '';
    $digit = floor(log10($id_pesanan) + 1);

    if ($digit <= 3)
      $kode_invoice = str_pad($id_pesanan, 3, '0', STR_PAD_LEFT);
    else
      $kode_invoice = str_pad($id_pesanan, $digit, '0', STR_PAD_LEFT);

    $data = array(
      'id' => $id_pesanan,
      'kode' => 'INV-' . $kode_invoice
    );
    return $data;
  }

  private function _convertToKodeInvoice($id_form, $last_id)
  {
    $kode_invoice = '';
    $digit = floor(log10($last_id) + 1);
    if ($digit <= 3)
      $kode_invoice = str_pad($id_form, 3, '0', STR_PAD_LEFT);
    else
      $kode_invoice = str_pad($id_form, $digit, '0', STR_PAD_LEFT);

    return 'INV-' . $kode_invoice;
  }

  public function getKodeInvoiceNow($id_form)
  {
    $last_id = $this->getLastKodeFakturPembelian()['id'];
    return $this->_convertToKodeInvoice($id_form, $last_id);
  }

  public function simpanFakturPembelian()
  {
    $jumlah_dp = 0;

    if (!empty($_POST['jumlah_dp']))
      $jumlah_dp = (int) $_POST['jumlah_dp'];

    $data_form = array(
      'id' => $_POST['id_faktur_pembelian'],
      'tanggal' => $_POST['tanggal_faktur'],
      'nilai_faktur' => $_POST['nilai_faktur'],
      'uang_muka' => $jumlah_dp,
      'is_row_dp' => 0,
      'pembelian_form_pesanan_pembelian_id' => $_POST['id_form_pesanan']
    );

    $this->db->trans_begin();
    $this->db->insert('pembelian_form_faktur_pembelian', $data_form);

    $this->_updateAndCreateBarangFakturPembelian($_POST['id_faktur_pembelian'], $_POST['id_form_pesanan']);

    if ($this->db->trans_status() === FALSE) {
      $this->db->trans_rollback();
      return false;
    } else {
      $this->db->trans_commit();
      return true;
    }
  }

  private function _updateAndCreateBarangFakturPembelian($id_faktur_pembelian, $id_form_pesanan)
  {
    $insert_terima_gudang = $_POST['insert_terima_gudang'];

    foreach ($insert_terima_gudang as $id_barang_pesanan => $gudang_id) {

      $this->db->select('qty_beli, qty_diterima, persediaan_daftar_barang_id AS id_barang');
      $this->db->from('pembelian_daftar_barang_pesanan_pembelian');
      $this->db->where('id', $id_barang_pesanan);
      $this->db->limit(1);
      $barang_pesanan = $this->db->get()->row_array();

      // Update status pesanan pembelian menjadi selesai
      $update_status = array(
        'is_done' => 1
      );
      $this->db->where('id', $id_form_pesanan);
      $this->db->update('pembelian_form_pesanan_pembelian', $update_status);

      // Update qty terima barang pada table pesanan
      $update_qty = array(
        'qty_diterima' => $barang_pesanan['qty_beli']
      );
      $this->db->where('id', $id_barang_pesanan);
      $this->db->update('pembelian_daftar_barang_pesanan_pembelian', $update_qty);

      // Menambahkan stok barang pada table stok
      $insert_stok = array(
        'persediaan_daftar_barang_id' => $barang_pesanan['id_barang'],
        'stok' => $barang_pesanan['qty_beli'] - $barang_pesanan['qty_diterima'],
        'persediaan_daftar_gudang_id' => $gudang_id,
        'persediaan_form_penyesuaian_stok_id' => 0,
        'persediaan_form_pindah_barang_id' => 0
      );
      $this->db->insert('persediaan_stok_barang', $insert_stok);
      $id_insert_stok = $this->db->insert_id();

      // Menambahkan data barang yang diterima pada table daftar barang faktur pembelian
      $insert_terima = array(
        'persediaan_daftar_barang_id' => $barang_pesanan['id_barang'],
        'qty_terima' => $barang_pesanan['qty_beli'] - $barang_pesanan['qty_diterima'],
        'persediaan_stok_barang_id' => $id_insert_stok,
        'pembelian_form_faktur_pembelian_id' => $id_faktur_pembelian
      );
      $this->db->insert('pembelian_daftar_barang_faktur_pembelian', $insert_terima);
    }
  }

  public function getDataFormFakturPembelian($id_faktur)
  {
    $sql = "
      SELECT ff.id AS id_faktur, fp.id AS id_pesanan, ff.tanggal AS tanggal_faktur, fp.tanggal AS tanggal_pesanan, fp.deskripsi, fp.pengiriman_via, fp.is_uang_muka, fp.subtotal_overall, fp.diskon_overall, fp.jumlah_diskon_overall, fp.pajak_ppn, fp.biaya_pengiriman, fp.total_biaya, s.nama_pemasok, s.alamat AS alamat_pemasok, ff.is_row_dp
      FROM pembelian_form_faktur_pembelian ff
      JOIN pembelian_form_pesanan_pembelian fp
        ON fp.id = ff.pembelian_form_pesanan_pembelian_id
      JOIN daftar_pemasok s
        ON s.id = fp.supplier_id
      WHERE ff.id = $id_faktur
      LIMIT 1
    ";
    return $this->db->query($sql)->row_array();
  }

  public function getListDataBarangFakturPembelian($id_pesanan, $id_faktur)
  {
    $sql = "
      SELECT b.id AS id_barang, df.id AS id_barang_faktur, dp.id AS id_barang_pesanan, s.id AS id_stok_faktur, b.kode_barang, b.keterangan, dp.qty_beli, df.qty_terima, b.unit, dp.harga_unit, dp.diskon, dp.subtotal, s.persediaan_daftar_gudang_id AS gudang_id
      FROM pembelian_daftar_barang_faktur_pembelian df
      JOIN persediaan_daftar_barang b
        ON b.id = df.persediaan_daftar_barang_id
      JOIN persediaan_stok_barang s
        ON s.id = df.persediaan_stok_barang_id
      LEFT JOIN pembelian_daftar_barang_pesanan_pembelian dp
        ON dp.persediaan_daftar_barang_id = df.persediaan_daftar_barang_id
      WHERE dp.pembelian_form_pesanan_pembelian_id = $id_pesanan AND df.pembelian_form_faktur_pembelian_id = $id_faktur
    ";
    return $this->db->query($sql)->result_array();
  }

  public function getDataDPFaktur($id_faktur)
  {
    $this->db->select('*');
    $this->db->from('pembelian_data_dp_faktur_pembelian');
    $this->db->where('pembelian_form_faktur_pembelian_id', $id_faktur);
    $this->db->limit(1);
    return $this->db->get()->row_array();
  }

  public function getDataDPFakturByIdPesanan($id_pesanan)
  {
    $sql = "
      SELECT *
      FROM pembelian_form_faktur_pembelian ff
      JOIN pembelian_data_dp_faktur_pembelian dp
        ON ff.id = dp.pembelian_form_faktur_pembelian_id
      WHERE ff.pembelian_form_pesanan_pembelian_id = $id_pesanan
      LIMIT 1
    ";
    return $this->db->query($sql)->row_array();
  }

  public function editFakturPembelian()
  {
    $update_form = array(
      'tanggal' => $_POST['tanggal_faktur'],
      'nilai_faktur' => $_POST['nilai_faktur'],
      'uang_muka' => 0
    );

    $this->db->trans_begin();
    $this->db->where('id', $_POST['id_faktur_pembelian']);
    $this->db->update('pembelian_form_faktur_pembelian', $update_form);

    $this->_updateBarangFakturPembelian();

    if ($this->db->trans_status() === FALSE) {
      $this->db->trans_rollback();
      return false;
    } else {
      $this->db->trans_commit();
      return true;
    }
  }

  private function _updateBarangFakturPembelian()
  {
    $list_id_stok_faktur = $_POST['id_stok_faktur'];
    $update_terima_gudang = $_POST['update_terima_gudang'];

    foreach ($list_id_stok_faktur as $id_barang_faktur => $id_stok_faktur) {
      $update_stok = array(
        'persediaan_daftar_gudang_id' => $update_terima_gudang[$id_barang_faktur]
      );
      $this->db->where('id', $id_stok_faktur);
      $this->db->update('persediaan_stok_barang', $update_stok);
    }
  }

  public function hapusFakturPembelian($id_faktur)
  {
    $this->db->trans_begin();
    $this->db->select('pembelian_form_pesanan_pembelian_id AS id_pesanan');
    $this->db->from('pembelian_form_faktur_pembelian');
    $this->db->where('id', $id_faktur);
    $this->db->limit(1);
    $id_pesanan = $this->db->get()->row_array()['id_pesanan'];
    $sql = "
      SELECT df.id AS id_barang_faktur, s.id AS id_barang_stok, dp.id AS id_barang_pesanan, s.stok AS qty_terima, dp.qty_beli
      FROM pembelian_daftar_barang_faktur_pembelian df
      JOIN persediaan_stok_barang s
        ON s.id = df.persediaan_stok_barang_id
      LEFT JOIN pembelian_daftar_barang_pesanan_pembelian dp
        ON dp.persediaan_daftar_barang_id = df.persediaan_daftar_barang_id
      WHERE dp.pembelian_form_pesanan_pembelian_id = $id_pesanan AND df.pembelian_form_faktur_pembelian_id = $id_faktur
    ";
    $data_hapus = $this->db->query($sql)->result_array();

    foreach ($data_hapus as $x) {
      $this->_updateQtyBarangPesananPembelian($x['id_barang_pesanan'], $x['qty_beli'], $x['qty_terima']);
      $this->_deleteBarangFakturPembelian($x['id_barang_faktur']);
      $this->_deleteStokFakturPembelian($x['id_barang_stok']);
    }

    $this->db->where('id', $id_faktur);
    $this->db->delete('pembelian_form_faktur_pembelian');

    // Update status menjadi on process
    $update_is_done = array(
      'is_done' => 0
    );
    $this->db->where('id', $id_pesanan);
    $this->db->update('pembelian_form_pesanan_pembelian', $update_is_done);

    if ($this->db->trans_status() === FALSE) {
      $this->db->trans_rollback();
      return false;
    } else {
      $this->db->trans_commit();
      return true;
    }
  }

  private function _updateQtyBarangPesananPembelian($id_barang_pesanan, $qty_beli, $qty_terima)
  {
    $update_qty_pesanan = array(
      'qty_diterima' => $qty_beli - $qty_terima
    );
    $this->db->where('id', $id_barang_pesanan);
    $this->db->update('pembelian_daftar_barang_pesanan_pembelian', $update_qty_pesanan);
  }

  private function _deleteBarangFakturPembelian($id_barang_faktur)
  {
    $this->db->where('id', $id_barang_faktur);
    $this->db->delete('pembelian_daftar_barang_faktur_pembelian');
  }

  private function _deleteStokFakturPembelian($id_barang_stok)
  {
    $this->db->where('id', $id_barang_stok);
    $this->db->delete('persediaan_stok_barang');
  }
}
