<?php
class Pelanggan_model extends CI_Model
{
  public function getTablePelanggan()
  {
    $this->db->select('*');
    $this->db->from('daftar_pelanggan');
    $this->db->order_by('nama_pelanggan', 'ASC');
    return $this->db->get()->result_array();
  }

  public function getPelangganById($id)
  {
    $this->db->select('*');
    $this->db->from('daftar_pelanggan');
    $this->db->where('id', $id);
    $this->db->limit(1);
    return $this->db->get()->row_array();
  }

  public function simpanPelanggan()
  {
    $this->db->trans_begin();

    $data = array(
      'nama_pelanggan' => $_POST['nama'],
      'alamat' => $_POST['alamat'],
      'telepon' => $_POST['telepon'],
      'kontak' => $_POST['kontak']
    );
    $this->db->insert('daftar_pelanggan', $data);

    if ($this->db->trans_status() === FALSE) {
      $this->db->trans_rollback();
      return false;
    } else {
      $this->db->trans_commit();
      return true;
    }
  }

  public function editPelanggan($id)
  {
    $this->db->trans_begin();

    $data = array(
      'nama_pelanggan' => $_POST['nama'],
      'alamat' => $_POST['alamat'],
      'telepon' => $_POST['telepon'],
      'kontak' => $_POST['kontak']
    );
    $this->db->where('id', $id);
    $this->db->update('daftar_pelanggan', $data);

    if ($this->db->trans_status() === FALSE) {
      $this->db->trans_rollback();
      return false;
    } else {
      $this->db->trans_commit();
      return true;
    }
  }

  public function hapusPelanggan($id)
  {
    $this->db->trans_begin();

    $this->db->where('id', $id);
    $this->db->delete('daftar_pelanggan');

    if ($this->db->trans_status() === FALSE) {
      $this->db->trans_rollback();
      return false;
    } else {
      $this->db->trans_commit();
      return true;
    }
  }
}
