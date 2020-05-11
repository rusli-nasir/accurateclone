<?php
class Notifikasi_model extends CI_Model
{
  protected $table = 'notifikasi';

  public function viewTable()
  {
    $sql = "
      SELECT * 
      FROM `notifikasi`
      ORDER BY waktu DESC
    ";
    $query = $this->db->query($sql);
    return $query->result_array();
  }

  public function updateTerbaca()
  {
    $id = $this->input->post('id');
    $data = array(
      "is_baca" => 1
    );

    $this->db->where('id', $id);
    $this->db->update($this->table, $data); // Untuk mengeksekusi perintah update data
    return ($this->db->affected_rows() != 1) ? false : true;
  }

  public function getNotRead()
  {
    $sql = "
      SELECT COUNT(*) as not_read
      FROM notifikasi
      WHERE is_baca = 0
    ";
    $query = $this->db->query($sql);
    return $query->result_array();
  }
}
