<?php
class SetHargaPenjualan_model extends CI_Model
{
  public function getTableBarang()
  {
    $this->db->select('id, kode_barang, keterangan');
    $this->db->from('persediaan_daftar_barang');
    $this->db->order_by('kode_barang', 'ASC');
    return $this->db->get()->result_array();
  }

  public function getTableSetHargaPenjualan()
  {
    $this->db->select('*');
    $this->db->from('persediaan_form_set_harga_penjualan');
    $this->db->order_by('tanggal', 'ASC');
    return $this->db->get()->result_array();
  }

  public function getDataHargaPenjualanBarangByIdBarang($id_barang)
  {
    $sql = "
      SELECT b.kode_barang, b.keterangan, h.harga_jual, b.id AS id_barang
      FROM persediaan_harga_penjualan h
      JOIN persediaan_daftar_barang b
        ON b.id = h.persediaan_daftar_barang_id
      WHERE b.id = $id_barang
      ORDER BY h.id DESC
      LIMIT 1
    ";
    $data_harga = $this->db->query($sql)->row_array();

    if (empty($data_harga)) {
      $sql = "
        SELECT id AS id_barang, kode_barang, keterangan, harga_jual
        FROM persediaan_daftar_barang
        WHERE id = $id_barang
        LIMIT 1
      ";
      $data_harga = $this->db->query($sql)->row_array();
    }

    return $data_harga;
  }

  public function simpanSetHargaPenjualan()
  {
    $data_form = array(
      'tanggal' => $_POST['tanggal'],
      'keterangan' => $_POST['keterangan']
    );

    $this->db->trans_begin();
    $this->db->insert('persediaan_form_set_harga_penjualan', $data_form);
    $id_form = $this->db->insert_id();

    $this->_simpanSetHargaPenjualanPerBarang($id_form);

    if ($this->db->trans_status() === FALSE) {
      $this->db->trans_rollback();
      return false;
    } else {
      $this->db->trans_commit();
      return true;
    }
  }

  private function _simpanSetHargaPenjualanPerBarang($id_form)
  {
    $id_barang = $_POST['insert_id_barang'];
    $harga_jual = $_POST['insert_harga_jual'];

    $data_harga = array();
    foreach ($id_barang as $key => $val) {
      $insert = array(
        'id_barang' => $val,
        'harga_jual' => $harga_jual[$val],
      );
      array_push($data_harga, $insert);
    }

    foreach ($data_harga as $data) {
      $insert = array(
        'persediaan_daftar_barang_id' => $data['id_barang'],
        'harga_jual' => $data['harga_jual'],
        'diskon' => 0,
        'persediaan_form_set_harga_penjualan_id' => $id_form
      );
      $this->db->insert('persediaan_harga_penjualan', $insert);
    }
  }

  public function getTableBarangHasBeenAdded($id_form)
  {
    $sql = "
      SELECT b.id AS id_barang, h.id AS id_harga
      FROM persediaan_daftar_barang b
      JOIN persediaan_harga_penjualan h
        ON b.id = h.persediaan_daftar_barang_id
      WHERE h.persediaan_form_set_harga_penjualan_id = $id_form
    ";
    return $this->db->query($sql)->result_array();
  }

  public function getDataFormSetHargaPenjualanId($id_form)
  {
    $this->db->select('*');
    $this->db->from('persediaan_form_set_harga_penjualan');
    $this->db->where('id', $id_form);
    $this->db->limit(1);
    return $this->db->get()->row_array();
  }

  public function getListDataHargaBarangDisesuaikanByFormId($id_form)
  {
    $sql = "
      SELECT b.id AS id_barang, h.id AS id_harga, b.kode_barang, b.keterangan, h.harga_jual
      FROM persediaan_harga_penjualan h
      JOIN persediaan_form_set_harga_penjualan f
        ON f.id = h.persediaan_form_set_harga_penjualan_id
      JOIN persediaan_daftar_barang b
        ON b.id = h.persediaan_daftar_barang_id
      WHERE f.id = $id_form
    ";
    return $this->db->query($sql)->result_array();
  }

  public function editSetHargaPenjualan($id_form)
  {
    $update_form = array(
      'tanggal' => $_POST['tanggal'],
      'keterangan' => $_POST['keterangan']
    );

    $this->db->trans_begin();

    $this->db->where('id', $id_form);
    $this->db->update('persediaan_form_set_harga_penjualan', $update_form);

    $this->_editSetHargaPenjualanPerBarang();


    if (!empty($_POST['insert_id_barang']))
      $this->_simpanSetHargaPenjualanPerBarang($id_form);

    if ($this->db->trans_status() === FALSE) {
      $this->db->trans_rollback();
      return false;
    } else {
      $this->db->trans_commit();
      return true;
    }
  }

  private function _editSetHargaPenjualanPerBarang()
  {
    $update_id_harga = $_POST['update_id_harga'];
    $is_delete = $_POST['is_delete'];
    $update_harga_jual = $_POST['update_harga_jual'];

    $update_harga = array();
    foreach ($update_id_harga as $key => $val) {
      $insert = array(
        'id_harga' => $val,
        'harga_jual' => $update_harga_jual[$key],
        'is_delete' => $is_delete[$key],
      );
      array_push($update_harga, $insert);
    }

    foreach ($update_harga as $x) {
      if ($x['is_delete'] == '0') {
        $update = array(
          'harga_jual' => $x['harga_jual']
        );
        $this->db->where('id', $x['id_harga']);
        $this->db->update('persediaan_harga_penjualan', $update);
      } else {
        $this->db->where('id', $x['id_harga']);
        $this->db->delete('persediaan_harga_penjualan');
      }
    }
  }

  public function getKetFormSetHargaPenjualan($id_form)
  {
    $this->db->select('keterangan');
    $this->db->from('persediaan_form_set_harga_penjualan');
    $this->db->where('id', $id_form);
    $this->db->limit(1);
    return $this->db->get()->row_array()['keterangan'];
  }

  public function hapusSetHargaPenjualanPerBarang($id_form)
  {
    $this->db->trans_begin();

    $sql = "
      SELECT h.id
      FROM persediaan_form_set_harga_penjualan f
      JOIN persediaan_harga_penjualan h
        ON f.id = h.persediaan_form_set_harga_penjualan_id
      WHERE f.id = $id_form
    ";
    $list_harga = $this->db->query($sql)->result_array();

    foreach ($list_harga as $x) {
      $this->db->where('id', $x['id']);
      $this->db->delete('persediaan_harga_penjualan');
    }

    $this->db->where('id', $id_form);
    $this->db->delete('persediaan_form_set_harga_penjualan');

    if ($this->db->trans_status() === FALSE) {
      $this->db->trans_rollback();
      return false;
    } else {
      $this->db->trans_commit();
      return true;
    }
  }
}
