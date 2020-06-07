<?php
class InfoPerusahaan_model extends CI_Model
{
  public function getInfoPerusahaan()
  {
    $this->db->select('*');
    $this->db->from('info_perusahaan');
    $this->db->where('id', 1);
    return $this->db->get()->row_array();
  }

  public function simpanPerusahaan()
  {
    $data = array(
      'nama_perusahaan' => $_POST['nama'],
      'alamat' => $_POST['alamat'],
      'telepon ' => $_POST['telepon']
    );

    $this->db->trans_begin();

    $this->db->where('id', 1);
    $this->db->update('info_perusahaan', $data);

    if ($this->db->trans_status() === FALSE) {
      $this->db->trans_rollback();
      return false;
    } else {
      $this->db->trans_commit();
      return true;
    }
  }
}
