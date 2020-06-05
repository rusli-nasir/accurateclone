<?php
class PenyeseuaianPersediaan_model extends CI_Model
{
  public function getTableBarang()
  {
    $this->db->select('id, kode_barang, keterangan');
    $this->db->from('persediaan_daftar_barang');
    $this->db->order_by('kode_barang', 'ASC');
    return $this->db->get()->result_array();
  }

  public function getTablePenyeseuaianPersediaan()
  {
    $this->db->select('*');
    $this->db->from('persediaan_form_penyesuaian_stok');
    $this->db->order_by('tanggal', 'ASC');
    return $this->db->get()->result_array();
  }

  private function _getTotalCurrentQtyPerBarang($id_barang, $saldo_awal)
  {
    $this->db->select('SUM(stok) AS total_stok');
    $this->db->from('persediaan_stok_barang');
    $this->db->where('persediaan_daftar_barang_id', $id_barang);
    $total_stok_except_saldo_awal = $this->db->get()->row_array()['total_stok'];

    return $saldo_awal + $total_stok_except_saldo_awal;
  }

  public function getDataPersediaanPerBarang($id_barang)
  {
    $this->db->select('id, kode_barang, keterangan, default_gudang_id, saldo_awal_kuantitas');
    $this->db->from('persediaan_daftar_barang');
    $this->db->where('id', $id_barang);
    $data_barang = $this->db->get()->row_array();

    $data_barang['stok'] = $this->_getTotalCurrentQtyPerBarang($id_barang, $data_barang['saldo_awal_kuantitas']);

    return $data_barang;
  }

  public function simpanPenyeseuaianPersediaan()
  {
    $data_form = array(
      'tanggal' => $_POST['tanggal'],
      'keterangan' => $_POST['keterangan']
    );

    $this->db->trans_begin();
    $this->db->insert('persediaan_form_penyesuaian_stok', $data_form);
    $id_form = $this->db->insert_id();

    $this->_simpanPenyeseuaianPersediaanPerBarang($id_form);

    if ($this->db->trans_status() === FALSE) {
      $this->db->trans_rollback();
      return false;
    } else {
      $this->db->trans_commit();
      return true;
    }
  }

  private function _simpanPenyeseuaianPersediaanPerBarang($id_form)
  {
    $insert_id_barang = $_POST['insert_id_barang'];
    $insert_current_qty = $_POST['insert_current_qty'];
    $insert_new_qty = $_POST['insert_new_qty'];
    $insert_gudang = $_POST['insert_gudang'];

    foreach ($insert_id_barang as $key => $val) {
      $insert = array(
        'persediaan_daftar_barang_id' => $val,
        'stok' => $insert_new_qty[$key] - $insert_current_qty[$key],
        'persediaan_daftar_gudang_id' => $insert_gudang[$key],
        'persediaan_form_penyesuaian_stok_id' => $id_form,
        'persediaan_form_pindah_barang_id' => 0
      );
      $this->db->insert('persediaan_stok_barang', $insert);
    }
  }

  public function getDataFormPenyeseuaianPersediaan($id_form)
  {
    $this->db->select('*');
    $this->db->from('persediaan_form_penyesuaian_stok');
    $this->db->where('id', $id_form);
    $this->db->limit(1);
    return $this->db->get()->row_array();
  }

  public function getListDataBarangPenyeseuaianPersediaan($id_form)
  {
    $sql = "
      SELECT s.id AS id_stok, b.id AS id_barang, b.kode_barang, b.keterangan, s.stok, s.persediaan_daftar_gudang_id
      FROM persediaan_stok_barang s
      JOIN persediaan_daftar_barang b
        ON b.id = s.persediaan_daftar_barang_id
      WHERE s.persediaan_form_penyesuaian_stok_id = $id_form
    ";
    return $this->db->query($sql)->result_array();
  }

  public function editPenyeseuaianPersediaan($id_form)
  {
    $update_form = array(
      'tanggal' => $_POST['tanggal'],
      'keterangan' => $_POST['keterangan']
    );

    $this->db->trans_begin();

    $this->db->where('id', $id_form);
    $this->db->update('persediaan_form_penyesuaian_stok', $update_form);

    $this->_editPenyeseuaianPersediaanPerBarang();

    if ($this->db->trans_status() === FALSE) {
      $this->db->trans_rollback();
      return false;
    } else {
      $this->db->trans_commit();
      return true;
    }
  }

  private function _editPenyeseuaianPersediaanPerBarang()
  {
    $update_id_stok = $_POST['update_id_stok'];
    $is_delete = $_POST['is_delete'];
    $update_selisih_stok = $_POST['update_selisih_stok'];
    $update_gudang = $_POST['update_gudang'];

    foreach ($update_id_stok as $key => $val) {
      if ($is_delete[$key] == '0') {
        $update = array(
          'stok' => $update_selisih_stok[$key],
          'persediaan_daftar_gudang_id' => $update_gudang[$key]
        );
        $this->db->where('id', $val);
        $this->db->update('persediaan_stok_barang', $update);
      } else {
        $this->db->where('id', $val);
        $this->db->delete('persediaan_stok_barang');
      }
    }
  }

  public function getKetFormPenyesuaianPersediaan($id_form)
  {
    $this->db->select('keterangan');
    $this->db->from('persediaan_form_penyesuaian_stok');
    $this->db->where('id', $id_form);
    return $this->db->get()->row_array()['keterangan'];
  }

  public function hapusPenyeseuaianPersediaan($id_form)
  {
    $this->db->trans_begin();

    $sql = "
      SELECT s.id
      FROM persediaan_form_penyesuaian_stok f
      JOIN persediaan_stok_barang s
        ON f.id = s.persediaan_form_penyesuaian_stok_id
      WHERE f.id = $id_form
    ";
    $list_stok_barang = $this->db->query($sql)->result_array();

    foreach ($list_stok_barang as $x) {
      $this->db->where('id', $x['id']);
      $this->db->delete('persediaan_stok_barang');
    }

    $this->db->where('id', $id_form);
    $this->db->delete('persediaan_form_penyesuaian_stok');

    if ($this->db->trans_status() === FALSE) {
      $this->db->trans_rollback();
      return false;
    } else {
      $this->db->trans_commit();
      return true;
    }
  }
}
