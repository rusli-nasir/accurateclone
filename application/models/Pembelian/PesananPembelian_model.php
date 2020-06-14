<?php
class PesananPembelian_model extends CI_Model
{
  public function getDaftarAlamat()
  {
    $this->db->select('alamat');
    $this->db->from('info_perusahaan');
    $this->db->where('id', 1);
    $this->db->limit(1);
    $alamat_utama = $this->db->get()->row_array()['alamat'];

    $this->db->select('nama_gudang, alamat');
    $this->db->from('persediaan_daftar_gudang');
    $list_gudang = $this->db->get()->result_array();

    $list_alamat = [];
    $list_alamat[0]['nama'] = 'Alamat Utama';
    $list_alamat[0]['alamat'] = $alamat_utama;

    $i = 1;
    foreach ($list_gudang as $gudang) {
      $list_alamat[$i]['nama'] = $gudang['nama_gudang'];
      $list_alamat[$i]['alamat'] = $gudang['alamat'];
      $i++;
    }
    return $list_alamat;
  }

  public function getTableBarang()
  {
    $this->db->select('id, kode_barang, keterangan');
    $this->db->from('persediaan_daftar_barang');
    $this->db->order_by('kode_barang', 'ASC');
    return $this->db->get()->result_array();
  }

  public function getTablePesananPembelian()
  {
    $sql = "
      SELECT f.id, f.tanggal, f.is_done AS status, s.nama_pemasok, f.total_biaya, f.deskripsi
      FROM pembelian_form_pesanan_pembelian f
      JOIN daftar_pemasok s
        ON s.id = f.supplier_id
      ORDER BY f.id ASC
    ";
    $list_pembelian = $this->db->query($sql)->result_array();

    $last_id = $this->getLastKodePesananPembelian()['id'];
    foreach ($list_pembelian as $key => $val) {
      $list_pembelian[$key]['no'] = $this->_convertToKodeBeli($val['id'], $last_id);
    }
    return $list_pembelian;
  }

  public function getLastKodePesananPembelian()
  {
    $this->db->select('id');
    $this->db->from('pembelian_form_pesanan_pembelian');
    $this->db->order_by('id', 'DESC');
    $this->db->limit(1);
    $last_id = $this->db->get()->row_array();

    $id_pesanan = 0;
    if (!empty($last_id))
      $id_pesanan = $last_id['id'];

    $id_pesanan++;

    $kode_pesanan = '';
    $digit = floor(log10($id_pesanan) + 1);

    if ($digit <= 3)
      $kode_pesanan = str_pad($id_pesanan, 3, '0', STR_PAD_LEFT);
    else
      $kode_pesanan = str_pad($id_pesanan, $digit, '0', STR_PAD_LEFT);

    $data = array(
      'id' => $id_pesanan,
      'kode_pesanan' => 'B-' . $kode_pesanan
    );
    return $data;
  }

  private function _convertToKodeBeli($id_form, $last_id)
  {
    $kode_pesanan = '';
    $digit = floor(log10($last_id) + 1);
    if ($digit <= 3)
      $kode_pesanan = str_pad($id_form, 3, '0', STR_PAD_LEFT);
    else
      $kode_pesanan = str_pad($id_form, $digit, '0', STR_PAD_LEFT);

    return 'B-' . $kode_pesanan;
  }

  public function getKodeBeliNow($id_form)
  {
    $last_id = $this->getLastKodePesananPembelian()['id'];
    return $this->_convertToKodeBeli($id_form, $last_id);
  }

  public function getBarangPemeblianAdded($id_barang)
  {
    $this->db->select('id, kode_barang, keterangan, unit');
    $this->db->from('persediaan_daftar_barang');
    $this->db->where('id', $id_barang);
    $data_barang = $this->db->get()->row_array();

    return $data_barang;
  }

  public function simpanPesananPembelian()
  {
    $is_uang_muka = 0;
    if (!empty($_POST['is_uang_muka_enabled']))
      $is_uang_muka = 1;

    $is_hitung_ppn = 0;
    if (!empty($_POST['is_hitung_ppn']))
      $is_hitung_ppn = 1;

    $data_form = array(
      'id' => $_POST['id_pesanan'],
      'tanggal' => $_POST['tanggal'],
      'supplier_id' => $_POST['supplier_id'],
      'alamat_ship_to' => $_POST['alamat_diterima'],
      'deskripsi' => $_POST['deskripsi'],
      'subtotal_overall' => $_POST['subtotal_overall'],
      'pengiriman_via' => $_POST['pengiriman_via'],
      'biaya_pengiriman' => $_POST['biaya_pengiriman'],
      'diskon_overall' => $_POST['diskon_overall'],
      'jumlah_diskon_overall' => $_POST['jumlah_diskon_overall'],
      'is_hitung_ppn' => $is_hitung_ppn,
      'pajak_ppn' => $_POST['pajak_ppn'],
      'total_biaya' => $_POST['total_biaya'],
      'is_uang_muka' => $is_uang_muka,
      'is_done' => 0
    );

    $this->db->trans_begin();
    $this->db->insert('pembelian_form_pesanan_pembelian', $data_form);

    $this->_simpanPesananPembelianPerBarang($_POST['id_pesanan']);

    if ($this->db->trans_status() === FALSE) {
      $this->db->trans_rollback();
      return false;
    } else {
      $this->db->trans_commit();
      return true;
    }
  }

  private function _simpanPesananPembelianPerBarang($id_form)
  {
    $insert_id_barang = $_POST['insert_id_barang'];
    $insert_qty_beli = $_POST['insert_qty_beli'];
    $insert_harga_unit = $_POST['insert_harga_unit'];
    $insert_diskon = $_POST['insert_diskon'];
    $insert_subtotal = $_POST['insert_subtotal'];

    foreach ($insert_id_barang as $key => $val) {
      $this->db->select('default_gudang_id');
      $this->db->from('persediaan_daftar_barang');
      $this->db->where('id', $val);
      $this->db->limit(1);
      $gudang = $this->db->get()->row_array()['default_gudang_id'];

      $insert = array(
        'persediaan_daftar_barang_id' => $val,
        'qty_beli' => $insert_qty_beli[$key],
        'harga_unit' => $insert_harga_unit[$key],
        'diskon' => $insert_diskon[$key],
        'subtotal' => $insert_subtotal[$key],
        'qty_diterima' => 0,
        'pembelian_form_pesanan_pembelian_id' => $id_form
      );
      $this->db->insert('pembelian_daftar_barang_pesanan_pembelian', $insert);
    }
  }

  public function getDataFormPesananPembelian($id_form)
  {
    $sql = "
      SELECT f.id, f.supplier_id, f.alamat_ship_to, f.deskripsi, f.tanggal, f.pengiriman_via, f.biaya_pengiriman, f.is_uang_muka, f.subtotal_overall, f.diskon_overall, f.jumlah_diskon_overall, f.pajak_ppn, f.total_biaya, s.alamat AS alamat_supplier, f.is_hitung_ppn
      FROM pembelian_form_pesanan_pembelian f
      JOIN daftar_pemasok s
        ON s.id = f.supplier_id
      WHERE f.id = $id_form
      LIMIT 1
    ";
    $data_form = $this->db->query($sql)->row_array();

    $last_id = $this->getLastKodePesananPembelian()['id'];
    $data_form['no'] = $this->_convertToKodeBeli($data_form['id'], $last_id);
    return $data_form;
  }

  public function getListDataBarangPesananPembelian($id_form)
  {
    $sql = "
    SELECT b.id AS id_barang, d.id AS id_barang_beli, b.kode_barang, b.keterangan, d.qty_beli, b.unit, d.harga_unit, d.diskon, d.subtotal, d.qty_diterima
    FROM pembelian_daftar_barang_pesanan_pembelian d
    JOIN persediaan_daftar_barang b
      ON b.id = d.persediaan_daftar_barang_id
    WHERE d.pembelian_form_pesanan_pembelian_id = $id_form
    ";
    return $this->db->query($sql)->result_array();
  }

  public function editPesananPembelian($id_form)
  {
    $is_uang_muka = 0;
    if (!empty($_POST['is_uang_muka_enabled']))
      $is_uang_muka = 1;

    $is_hitung_ppn = 0;
    if (!empty($_POST['is_hitung_ppn']))
      $is_hitung_ppn = 1;

    $data_form = array(
      'id' => $id_form,
      'tanggal' => $_POST['tanggal'],
      'supplier_id' => $_POST['supplier_id'],
      'alamat_ship_to' => $_POST['alamat_diterima'],
      'deskripsi' => $_POST['deskripsi'],
      'subtotal_overall' => $_POST['subtotal_overall'],
      'pengiriman_via' => $_POST['pengiriman_via'],
      'biaya_pengiriman' => $_POST['biaya_pengiriman'],
      'diskon_overall' => $_POST['diskon_overall'],
      'jumlah_diskon_overall' => $_POST['jumlah_diskon_overall'],
      'is_hitung_ppn' => $is_hitung_ppn,
      'pajak_ppn' => $_POST['pajak_ppn'],
      'total_biaya' => $_POST['total_biaya'],
      'is_uang_muka' => $is_uang_muka,
      'is_done' => 0
    );

    $this->db->trans_begin();
    $this->db->where('id', $id_form);
    $this->db->update('pembelian_form_pesanan_pembelian', $data_form);

    $this->_editPesananPembelianPerBarang($id_form);

    if ($this->db->trans_status() === FALSE) {
      $this->db->trans_rollback();
      return false;
    } else {
      $this->db->trans_commit();
      return true;
    }
  }

  private function _editPesananPembelianPerBarang($id_form)
  {
    $update_id_barang_beli = $_POST['update_id_barang_beli'];
    $update_qty_beli = $_POST['update_qty_beli'];
    $update_harga_unit = $_POST['update_harga_unit'];
    $update_diskon = $_POST['update_diskon'];
    $update_subtotal = $_POST['update_subtotal'];

    foreach ($update_id_barang_beli as $key => $val) {
      $update = array(
        'qty_beli' => $update_qty_beli[$key],
        'harga_unit' => $update_harga_unit[$key],
        'diskon' => $update_diskon[$key],
        'subtotal' => $update_subtotal[$key],
        'pembelian_form_pesanan_pembelian_id' => $id_form
      );
      $this->db->where('id', $val);
      $this->db->update('pembelian_daftar_barang_pesanan_pembelian', $update);
    }
  }

  public function hapusPesananPembelian($id_form)
  {
    $this->db->trans_begin();

    $this->db->select('id');
    $this->db->from('pembelian_daftar_barang_pesanan_pembelian');
    $this->db->where('pembelian_form_pesanan_pembelian_id ', $id_form);
    $list_barang = $this->db->get()->result_array();

    foreach ($list_barang as $x) {
      $this->db->where('id', $x['id']);
      $this->db->delete('pembelian_daftar_barang_pesanan_pembelian');
    }

    $this->db->where('id', $id_form);
    $this->db->delete('pembelian_form_pesanan_pembelian');

    if ($this->db->trans_status() === FALSE) {
      $this->db->trans_rollback();
      return false;
    } else {
      $this->db->trans_commit();
      return true;
    }
  }
}
