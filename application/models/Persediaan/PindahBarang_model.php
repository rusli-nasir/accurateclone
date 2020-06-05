<?php
class PindahBarang_model extends CI_Model
{
  public function getTablePemindahanBarang()
  {
    $sql = "
      SELECT f.id, f.tanggal, f.keterangan, g_dari.nama_gudang AS dari_gudang, g_ke.nama_gudang AS ke_gudang
      FROM persediaan_form_pindah_barang f
      JOIN persediaan_daftar_gudang g_dari
        ON g_dari.id = f.dari_gudang_id
      JOIN persediaan_daftar_gudang g_ke
        ON g_ke.id = f.ke_gudang_id
    ";
    return $this->db->query($sql)->result_array();
  }

  public function getKetFormPemindahanBarang($id_form)
  {
    $this->db->select('keterangan');
    $this->db->from('persediaan_form_pindah_barang');
    $this->db->where('id', $id_form);
    return $this->db->get()->row_array()['keterangan'];
  }

  public function getDataPersediaanPerBarang($id_barang)
  {
    $this->db->select('id, kode_barang, keterangan');
    $this->db->from('persediaan_daftar_barang');
    $this->db->where('id', $id_barang);
    $data_barang = $this->db->get()->row_array();
    return $data_barang;
  }

  public function getBarangFromGudangId($gudang_id)
  {
    $this->db->select('id, kode_barang, keterangan, saldo_awal_kuantitas, saldo_awal_gudang_id ');
    $this->db->from('persediaan_daftar_barang');
    $this->db->order_by('kode_barang', 'ASC');
    $list_barang = $this->db->get()->result_array();

    $barang_per_gudang = array();

    $i = 0;
    foreach ($list_barang as $barang) {
      $total_stok = 0;
      $total_stok_all = 0;
      if ($gudang_id == $barang['saldo_awal_gudang_id']) {
        $total_stok += $barang['saldo_awal_kuantitas'];
        $total_stok_all += $barang['saldo_awal_kuantitas'];
      }

      $this->db->select('SUM(stok) AS total_stok');
      $this->db->from('persediaan_stok_barang');
      $where = array(
        'persediaan_daftar_barang_id' => $barang['id'],
        'persediaan_daftar_gudang_id' => $gudang_id
      );
      $this->db->where($where);
      $temp_stok = $this->db->get()->row_array();
      $total_stok += $temp_stok['total_stok'];

      $this->db->select('SUM(stok) AS total_stok');
      $this->db->from('persediaan_stok_barang');
      $where = array(
        'persediaan_daftar_barang_id' => $barang['id']
      );
      $this->db->where($where);
      $temp_stok = $this->db->get()->row_array();
      $total_stok_all += $temp_stok['total_stok'];

      if ($total_stok > 0) {
        $barang_per_gudang[$i]['id'] = $barang['id'];
        $barang_per_gudang[$i]['kode_barang'] = $barang['kode_barang'];
        $barang_per_gudang[$i]['keterangan'] = $barang['keterangan'];
        $barang_per_gudang[$i]['stok'] = $total_stok;
        $barang_per_gudang[$i]['total_stok_all'] = $total_stok_all;
      }

      $i++;
    }
    return $barang_per_gudang;
  }

  public function getBarangAddedFromGudangId($gudang_id)
  {
    $sql = "
      SELECT DISTINCT(persediaan_daftar_barang_id) AS id
      FROM persediaan_stok_barang
      WHERE persediaan_form_pindah_barang_id = $gudang_id
      ORDER BY persediaan_daftar_barang_id ASC
    ";
    return $this->db->query($sql)->result_array();
  }

  public function getListDataBarangPemindahanBarang($dari_id, $ke_id)
  {
    $sql = "
      SELECT b.id, b.kode_barang, b.keterangan, s.stok AS jumlah_pindah, b.saldo_awal_kuantitas
      FROM persediaan_stok_barang s
      JOIN persediaan_daftar_barang b
        ON b.id = s.persediaan_daftar_barang_id
      WHERE s.persediaan_daftar_gudang_id =  $ke_id
      ORDER BY b.kode_barang
    ";
    $list_barang = $this->db->query($sql)->result_array();

    $i = 0;
    foreach ($list_barang as $barang) {
      $total_stok = 0;
      $total_stok += $barang['saldo_awal_kuantitas'];

      $this->db->select('SUM(stok) AS total_stok');
      $this->db->from('persediaan_stok_barang');
      $where = array(
        'persediaan_daftar_barang_id' => $barang['id']
      );
      $this->db->where($where);
      $temp_stok = $this->db->get()->row_array();
      $total_stok += $temp_stok['total_stok'];

      $list_barang[$i]['stok_sekarang'] = $total_stok;

      $i++;
    }
    return $list_barang;
  }

  public function getListIdStokFromPemindahanBarang($form_id)
  {
    $this->db->select('id AS id_stok, persediaan_daftar_barang_id AS id_barang');
    $this->db->from('persediaan_stok_barang');
    $this->db->order_by('persediaan_form_pindah_barang_id', $form_id);
    return $this->db->get()->result_array();
  }

  public function simpanPemindahanBarang()
  {
    $data_form = array(
      'tanggal' => $_POST['tanggal'],
      'keterangan' => $_POST['keterangan'],
      'dari_gudang_id ' => $_POST['dari_gudang'],
      'ke_gudang_id ' => $_POST['ke_gudang']
    );

    $this->db->trans_begin();
    $this->db->insert('persediaan_form_pindah_barang', $data_form);
    $id_form = $this->db->insert_id();

    $this->_simpanPemindahanBarang($_POST['dari_gudang'], $_POST['ke_gudang'], $id_form);

    if ($this->db->trans_status() === FALSE) {
      $this->db->trans_rollback();
      return false;
    } else {
      $this->db->trans_commit();
      return true;
    }
  }

  private function _simpanPemindahanBarang($dari_id, $ke_id, $id_form)
  {
    $insert_id_barang = $_POST['insert_id_barang'];
    $insert_qty_pindah = $_POST['insert_qty_pindah'];

    foreach ($insert_id_barang as $key => $val) {
      $insert = array(
        'persediaan_daftar_barang_id' => $val,
        'stok' => -$insert_qty_pindah[$key],
        'persediaan_daftar_gudang_id' => $dari_id,
        'persediaan_form_penyesuaian_stok_id' => 0,
        'persediaan_form_pindah_barang_id' => $id_form
      );
      $this->db->insert('persediaan_stok_barang', $insert);

      $insert = array(
        'persediaan_daftar_barang_id' => $val,
        'stok' => $insert_qty_pindah[$key],
        'persediaan_daftar_gudang_id' => $ke_id,
        'persediaan_form_penyesuaian_stok_id' => 0,
        'persediaan_form_pindah_barang_id' => $id_form
      );
      $this->db->insert('persediaan_stok_barang', $insert);
    }
  }

  public function getDataFormPemindahanBarang($id_form)
  {
    $sql = "
      SELECT f.id, f.tanggal, f.keterangan, g_dari.id AS dari_id, g_ke.id AS ke_id, g_dari.alamat AS dari_alamat, g_ke.alamat AS ke_alamat
      FROM persediaan_form_pindah_barang f
      JOIN persediaan_daftar_gudang g_dari
        ON g_dari.id = f.dari_gudang_id
      JOIN persediaan_daftar_gudang g_ke
        ON g_ke.id = f.ke_gudang_id
      WHERE f.id = $id_form
      LIMIT 1
    ";
    return $this->db->query($sql)->row_array();
  }

  public function editPemindahanBarang($id_form)
  {
    $data_form = array(
      'tanggal' => $_POST['tanggal'],
      'keterangan' => $_POST['keterangan'],
      'dari_gudang_id ' => $_POST['dari_gudang'],
      'ke_gudang_id ' => $_POST['ke_gudang']
    );

    $this->db->trans_begin();
    $this->db->where('id', $id_form);
    $this->db->update('persediaan_form_pindah_barang', $data_form);

    $this->_editPemindahanBarang($_POST['dari_gudang'], $_POST['ke_gudang'], $id_form);

    if (!empty($_POST['insert_id_barang']))
      $this->_simpanPemindahanBarang($_POST['dari_gudang'], $_POST['ke_gudang'], $id_form);

    if ($this->db->trans_status() === FALSE) {
      $this->db->trans_rollback();
      return false;
    } else {
      $this->db->trans_commit();
      return true;
    }
  }

  private function _editPemindahanBarang($dari_id, $ke_id, $id_form)
  {
    $update_id_barang = $_POST['update_id_barang'];
    $update_id_stok = $_POST['update_id_stok'];
    $update_qty_pindah = $_POST['update_qty_pindah'];
    $update_is_delete = $_POST['is_delete'];

    foreach ($update_id_barang as $key => $val) {
      if ($update_is_delete[$key] == '0') {
        $update = array(
          'stok' => -$update_qty_pindah[$key],
          'persediaan_daftar_gudang_id' => $dari_id,
          'persediaan_form_pindah_barang_id' => $id_form
        );
        $this->db->where('id', $update_id_stok[$key][0]);
        $this->db->update('persediaan_stok_barang', $update);

        $update = array(
          'stok' => $update_qty_pindah[$key],
          'persediaan_daftar_gudang_id' => $ke_id,
          'persediaan_form_pindah_barang_id' => $id_form
        );
        $this->db->where('id', $update_id_stok[$key][1]);
        $this->db->update('persediaan_stok_barang', $update);
      } else {
        $this->db->where('id', $update_id_stok[$key][0]);
        $this->db->delete('persediaan_stok_barang');
        $this->db->where('id', $update_id_stok[$key][1]);
        $this->db->delete('persediaan_stok_barang');
      }
    }
  }

  public function hapusPemindahanBarang($id_form)
  {
    $this->db->trans_begin();

    $sql = "
      SELECT s.id
      FROM persediaan_form_pindah_barang f
      JOIN persediaan_stok_barang s
        ON f.id = s.persediaan_form_pindah_barang_id
      WHERE f.id = $id_form
    ";
    $list_stok_barang = $this->db->query($sql)->result_array();

    foreach ($list_stok_barang as $x) {
      $this->db->where('id', $x['id']);
      $this->db->delete('persediaan_stok_barang');
    }

    $this->db->where('id', $id_form);
    $this->db->delete('persediaan_form_pindah_barang');

    if ($this->db->trans_status() === FALSE) {
      $this->db->trans_rollback();
      return false;
    } else {
      $this->db->trans_commit();
      return true;
    }
  }
}
