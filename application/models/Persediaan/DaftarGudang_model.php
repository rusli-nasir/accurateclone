<?php
class DaftarGudang_model extends CI_Model
{
  public function getTableGudang()
  {
    $this->db->select('*');
    $this->db->from('daftar_gudang');
    return $this->db->get()->result_array();
  }

  public function tambahGudang()
  {
    $data = array(
      'nama_gudang' => $_POST['nama_gudang'],
      'keterangan' => $_POST['keterangan'],
      'alamat' => $_POST['alamat'],
      'penanggung_jawab' => $_POST['penanggung_jawab']
    );
    $this->db->insert('daftar_gudang', $data);

    if ($this->db->affected_rows() == 1)
      return true;
    else
      return false;
  }

  public function getGudangById($id)
  {
    $this->db->select('*');
    $this->db->from('daftar_gudang');
    $this->db->where('id', $id);
    return $this->db->get()->row_array();
  }

  public function editGudang($id)
  {
    $data = array(
      'nama_gudang' => $_POST['nama_gudang'],
      'keterangan' => $_POST['keterangan'],
      'alamat' => $_POST['alamat'],
      'penanggung_jawab' => $_POST['penanggung_jawab']
    );
    $this->db->where('id', $id);
    $this->db->update('daftar_gudang', $data);

    if ($this->db->affected_rows() == 1)
      return true;
    else
      return false;
  }

  public function hapusGudang($id)
  {
    $this->db->where('id', $id);
    $this->db->delete('daftar_gudang');

    if ($this->db->affected_rows() == 1)
      return true;
    else
      return false;
  }
}
