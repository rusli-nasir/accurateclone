<?php
class Pemasok_model extends CI_Model
{
  public function getTablePemasok()
  {
    $this->db->select('*');
    $this->db->from('daftar_pemasok');
    return $this->db->get()->result_array();
  }

  public function getPemasokById($id)
  {
    $this->db->select('*');
    $this->db->from('daftar_pemasok');
    $this->db->where('id', $id);
    $this->db->limit(1);
    return $this->db->get()->row_array();
  }

  public function simpanPemasok()
  {
    $this->db->trans_begin();

    $data = array(
      'nama_pemasok' => $_POST['nama'],
      'alamat' => $_POST['alamat'],
      'telepon' => $_POST['telepon'],
      'kontak' => $_POST['kontak']
    );
    $this->db->insert('daftar_pemasok', $data);

    if ($this->db->trans_status() === FALSE) {
      $this->db->trans_rollback();
      return false;
    } else {
      $this->db->trans_commit();
      return true;
    }
  }

  public function editPemasok($id)
  {
    $this->db->trans_begin();

    $data = array(
      'nama_pemasok' => $_POST['nama'],
      'alamat' => $_POST['alamat'],
      'telepon' => $_POST['telepon'],
      'kontak' => $_POST['kontak']
    );
    $this->db->where('id', $id);
    $this->db->update('daftar_pemasok', $data);

    if ($this->db->trans_status() === FALSE) {
      $this->db->trans_rollback();
      return false;
    } else {
      $this->db->trans_commit();
      return true;
    }
  }

  public function hapusPemasok($id)
  {
    $this->db->trans_begin();

    $this->db->where('id', $id);
    $this->db->delete('daftar_pemasok');

    if ($this->db->trans_status() === FALSE) {
      $this->db->trans_rollback();
      return false;
    } else {
      $this->db->trans_commit();
      return true;
    }
  }
}
