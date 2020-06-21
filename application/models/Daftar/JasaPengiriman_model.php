<?php
class JasaPengiriman_model extends CI_Model
{
  public function getTableJasaPengiriman()
  {
    $this->db->select('*');
    $this->db->from('daftar_jasa_pengiriman');
    $this->db->order_by('nama', 'ASC');
    return $this->db->get()->result_array();
  }

  public function getJasaPengirimanById($id)
  {
    $this->db->select('*');
    $this->db->from('daftar_jasa_pengiriman');
    $this->db->where('id', $id);
    $this->db->limit(1);
    return $this->db->get()->row_array();
  }

  public function simpanJasaPengiriman()
  {
    $this->db->trans_begin();

    $data = array(
      'nama' => $_POST['nama']
    );
    $this->db->insert('daftar_jasa_pengiriman', $data);

    if ($this->db->trans_status() === FALSE) {
      $this->db->trans_rollback();
      return false;
    } else {
      $this->db->trans_commit();
      return true;
    }
  }

  public function editJasaPengiriman($id)
  {
    $this->db->trans_begin();

    $data = array(
      'nama' => $_POST['nama']
    );
    $this->db->where('id', $id);
    $this->db->update('daftar_jasa_pengiriman', $data);

    if ($this->db->trans_status() === FALSE) {
      $this->db->trans_rollback();
      return false;
    } else {
      $this->db->trans_commit();
      return true;
    }
  }

  public function hapusJasaPengiriman($id)
  {
    $this->db->trans_begin();

    $this->db->where('id', $id);
    $this->db->delete('daftar_jasa_pengiriman');

    if ($this->db->trans_status() === FALSE) {
      $this->db->trans_rollback();
      return false;
    } else {
      $this->db->trans_commit();
      return true;
    }
  }
}
