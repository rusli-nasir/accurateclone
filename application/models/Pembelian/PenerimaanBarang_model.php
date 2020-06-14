<?php
class PenerimaanBarang_model extends CI_Model
{
  public function getTablePenerimaanBarang()
  {
    $sql = "
      SELECT ft.pembelian_form_pesanan_pembelian_id, ft.id, ft.tanggal, s.nama_pemasok, ft.deskripsi
      FROM pembelian_form_penerimaan_barang ft
      JOIN pembelian_form_pesanan_pembelian fb
        ON fb.id = ft.pembelian_form_pesanan_pembelian_id
      JOIN daftar_pemasok s
        ON s.id = fb.supplier_id
      ORDER BY ft.pembelian_form_pesanan_pembelian_id DESC
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

  public function getListBarangPesanan($form_pembelian_id)
  {
    $sql = "
      SELECT b.kode_barang, b.keterangan, d.qty_beli, b.unit, b.default_gudang_id, d.id AS id_barang_pesanan, d.qty_diterima, b.id AS id_barang
      FROM pembelian_daftar_barang_pesanan_pembelian d
      JOIN persediaan_daftar_barang b
        ON b.id = d.persediaan_daftar_barang_id
      WHERE pembelian_form_pesanan_pembelian_id = $form_pembelian_id
    ";
    return $this->db->query($sql)->result_array();
  }

  public function getDataFormPesananPembelian($form_pembelian_id)
  {
    $sql = "
      SELECT f.id, f.tanggal, s.nama_pemasok, s.alamat AS alamat_pemasok
      FROM pembelian_form_pesanan_pembelian f
      JOIN daftar_pemasok s
        ON s.id = f.supplier_id
      WHERE f.id = $form_pembelian_id
      LIMIT 1
    ";
    return $this->db->query($sql)->row_array();
  }

  public function simpanPenerimaanBarang()
  {
    $data_form = array(
      'tanggal' => $_POST['tanggal'],
      'deskripsi' => $_POST['deskripsi'],
      'pembelian_form_pesanan_pembelian_id' => $_POST['id_pesanan'],
    );

    $this->db->trans_begin();
    $this->db->insert('pembelian_form_penerimaan_barang', $data_form);
    $id_form = $this->db->insert_id();

    $this->_updateAndCreatePenerimaan($id_form);

    if ($this->db->trans_status() === FALSE) {
      $this->db->trans_rollback();
      return false;
    } else {
      $this->db->trans_commit();
      return true;
    }
  }

  private function _updateAndCreatePenerimaan($id_form)
  {
    $insert_id_barang_pesanan = $_POST['insert_id_barang_pesanan'];
    $insert_qty_terima = $_POST['insert_qty_terima'];
    $insert_terima_gudang = $_POST['insert_terima_gudang'];
    $id_daftar_barang = $_POST['id_daftar_barang'];

    foreach ($insert_id_barang_pesanan as $key => $val) {
      // Update nilai qty diterima pada table daftar barang pembelian
      $update_qty = array(
        'qty_diterima' => $insert_qty_terima[$key]
      );
      $this->db->where('id', $val);
      $this->db->update('pembelian_daftar_barang_pesanan_pembelian', $update_qty);

      // Menambahkan stok barang pada table stok
      $insert_stok = array(
        'persediaan_daftar_barang_id' => $id_daftar_barang[$key],
        'stok' => $insert_qty_terima[$key],
        'persediaan_daftar_gudang_id' => $insert_terima_gudang[$key],
        'persediaan_form_penyesuaian_stok_id' => 0,
        'persediaan_form_pindah_barang_id' => 0
      );
      $this->db->insert('persediaan_stok_barang', $insert_stok);
      $id_insert_stok = $this->db->insert_id();

      // Menambahkan data barang yang diterima pada table daftar barang penerimaan
      $insert_terima = array(
        'persediaan_daftar_barang_id' => $id_daftar_barang[$key],
        'qty_terima' => $insert_qty_terima[$key],
        'persediaan_stok_barang_id' => $id_insert_stok,
        'pembelian_form_penerimaan_barang_id' => $id_form
      );
      $this->db->insert('pembelian_daftar_barang_penerimaan_barang', $insert_terima);
    }
  }

  public function getDataFormPenerimaanBarang($id_penerimaan)
  {
    $sql = "
      SELECT fb.id AS id_pesanan, s.nama_pemasok, s.alamat AS alamat_pemasok, ft.deskripsi, ft.tanggal
      FROM pembelian_form_penerimaan_barang ft
      JOIN pembelian_form_pesanan_pembelian fb
      ON fb.id = ft.pembelian_form_pesanan_pembelian_id
      JOIN daftar_pemasok s
      ON s.id = fb.supplier_id
      WHERE ft.id = $id_penerimaan
      LIMIT 1
      ";
    return $this->db->query($sql)->row_array();
  }

  public function getListBarangPesananForEdit($id_form_pesanan)
  {
    $sql = "
    SELECT b.kode_barang, b.keterangan, dp.qty_beli, tb.qty_terima AS qty_diterima, b.unit, s.persediaan_daftar_gudang_id AS gudang_id, dp.id AS id_barang_pesanan, b.id AS id_barang
    FROM pembelian_daftar_barang_penerimaan_barang tb
    JOIN persediaan_daftar_barang b
      ON b.id = tb.persediaan_daftar_barang_id
    JOIN persediaan_stok_barang s
      ON s.id = tb.persediaan_stok_barang_id
    LEFT JOIN pembelian_daftar_barang_pesanan_pembelian dp
      ON dp.persediaan_daftar_barang_id = tb.persediaan_daftar_barang_id
    WHERE dp.pembelian_form_pesanan_pembelian_id = $id_form_pesanan
    ";
    return $this->db->query($sql)->result_array();
  }

  public function editPenerimaanBarang($id_form)
  {
    $data_form = array(
      'tanggal' => $_POST['tanggal'],
      'deskripsi' => $_POST['deskripsi']
    );

    $this->db->trans_begin();
    $this->db->where('id', $id_form);
    $this->db->update('pembelian_form_penerimaan_barang', $data_form);

    $this->_updateEditPenerimaan($id_form);

    if ($this->db->trans_status() === FALSE) {
      $this->db->trans_rollback();
      return false;
    } else {
      $this->db->trans_commit();
      return true;
    }
  }

  private function _updateEditPenerimaan($id_form)
  {
    $insert_id_barang_pesanan = $_POST['insert_id_barang_pesanan'];
    $insert_qty_terima = $_POST['insert_qty_terima'];
    $insert_terima_gudang = $_POST['insert_terima_gudang'];
    $id_daftar_barang = $_POST['id_daftar_barang'];

    foreach ($insert_id_barang_pesanan as $key => $val) {
      // Update nilai qty diterima pada table daftar barang pembelian
      $update_qty = array(
        'qty_diterima' => $insert_qty_terima[$key]
      );
      $this->db->where('id', $val);
      $this->db->update('pembelian_daftar_barang_pesanan_pembelian', $update_qty);

      // Update stok barang pada table stok
      $this->db->select('id AS id_penerimaan_barang, persediaan_stok_barang_id as id_stok');
      $this->db->from('pembelian_daftar_barang_penerimaan_barang');
      $where_stok = array(
        "pembelian_form_penerimaan_barang_id" => $id_form,
        "persediaan_daftar_barang_id" => $id_daftar_barang[$key]
      );
      $this->db->where($where_stok);
      $this->db->limit(1);
      $data_penerimaan = $this->db->get()->row_array();

      $update_stok = array(
        'stok' => $insert_qty_terima[$key],
        'persediaan_daftar_gudang_id' => $insert_terima_gudang[$key]
      );
      $this->db->where('id', $data_penerimaan['id_stok']);
      $this->db->update('persediaan_stok_barang', $update_stok);

      // Update data barang yang diterima pada table daftar barang penerimaan
      $update_penerimaan = array(
        'qty_terima' => $insert_qty_terima[$key]
      );
      $this->db->where('id', $data_penerimaan['id_penerimaan_barang']);
      $this->db->update('pembelian_daftar_barang_penerimaan_barang', $update_penerimaan);
    }
  }

  public function hapusPenerimaanBarang($id_form_penerimaan)
  {
    $this->db->trans_begin();

    $this->_resetQtyTerimaBarangPesanan($id_form_penerimaan);

    $this->db->select('id AS id_barang_terima, persediaan_stok_barang_id AS id_stok');
    $this->db->from('pembelian_daftar_barang_penerimaan_barang');
    $this->db->where('pembelian_form_penerimaan_barang_id  ', $id_form_penerimaan);
    $list_barang_terima = $this->db->get()->result_array();

    $this->_deleteDaftarPenerimaanBarang($list_barang_terima);
    $this->_deleteStokPenerimaanBarang($list_barang_terima);

    $this->db->where('id', $id_form_penerimaan);
    $this->db->delete('pembelian_form_penerimaan_barang');

    if ($this->db->trans_status() === FALSE) {
      $this->db->trans_rollback();
      return false;
    } else {
      $this->db->trans_commit();
      return true;
    }
  }

  public function getIdFormPesananByIdFormPenerimaan($id_form_penerimaan)
  {
    $this->db->select('pembelian_form_pesanan_pembelian_id AS id_form_pesanan');
    $this->db->from('pembelian_form_penerimaan_barang');
    $this->db->where('id  ', $id_form_penerimaan);
    $this->db->limit(1);
    return $this->db->get()->row_array()['id_form_pesanan'];
  }

  private function _resetQtyTerimaBarangPesanan($id_form_penerimaan)
  {
    $id_form_pesanan = $this->getIdFormPesananByIdFormPenerimaan($id_form_penerimaan);

    $update_qty_terima = array(
      'qty_diterima' => 0
    );
    $this->db->where('pembelian_form_pesanan_pembelian_id', $id_form_pesanan);
    $this->db->update('pembelian_daftar_barang_pesanan_pembelian', $update_qty_terima);
  }

  private function _deleteDaftarPenerimaanBarang($list_barang_terima)
  {
    foreach ($list_barang_terima as $x) {
      $this->db->where('id', $x['id_barang_terima']);
      $this->db->delete('pembelian_daftar_barang_penerimaan_barang');
    }
  }

  private function _deleteStokPenerimaanBarang($list_barang_terima)
  {
    foreach ($list_barang_terima as $x) {
      $this->db->where('id', $x['id_stok']);
      $this->db->delete('persediaan_stok_barang');
    }
  }
}
