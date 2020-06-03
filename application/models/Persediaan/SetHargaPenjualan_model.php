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
      SELECT h.id AS id_harga, b.kode_barang, b.keterangan, h.harga1, h.harga2, h.harga3, b.id AS id_barang
      FROM persediaan_harga_penjualan h
      JOIN persediaan_daftar_barang b
        ON b.id = h.persediaan_daftar_barang_id
      WHERE b.id = $id_barang AND persediaan_form_set_harga_penjualan_id = 0
      LIMIT 1
    ";
    return $this->db->query($sql)->row_array();
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
    $id_barang = $_POST['id_barang'];
    $harga1 = $_POST['harga1'];
    $harga2 = $_POST['harga2'];
    $harga3 = $_POST['harga3'];

    $data_harga = array();
    foreach ($harga1 as $key => $val) {
      $insert = array(
        'id_barang' => $id_barang[$key],
        'id_harga' => $key,
        'harga1' => $harga1[$key],
        'harga2' => $harga2[$key],
        'harga3' => $harga3[$key]
      );
      array_push($data_harga, $insert);
    }

    foreach ($data_harga as $data) {
      $insert = array(
        'persediaan_daftar_barang_id' => $data['id_barang'],
        'harga1' => $data['harga1'],
        'harga2' => $data['harga2'],
        'harga3' => $data['harga3'],
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
      SELECT b.id AS id_barang, h.id AS id_harga, b.kode_barang, b.keterangan, h.harga1, h.harga2, h.harga3
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


    if (!empty($_POST['id_barang']))
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
    $update_harga1 = $_POST['update_harga1'];
    $update_harga2 = $_POST['update_harga2'];
    $update_harga3 = $_POST['update_harga3'];

    $update_harga = array();
    foreach ($update_id_harga as $key => $val) {
      $insert = array(
        'id_harga' => $val,
        'harga1' => $update_harga1[$key],
        'harga2' => $update_harga2[$key],
        'harga3' => $update_harga3[$key],
        'is_delete' => $is_delete[$key],
      );
      array_push($update_harga, $insert);
    }

    foreach ($update_harga as $x) {
      if ($x['is_delete'] == '0') {
        $update = array(
          'harga1' => $x['harga1'],
          'harga2' => $x['harga2'],
          'harga3' => $x['harga3']
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
      WHERE f.id = 8
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
