<?php
class Operasional_model extends CI_Model
{
  public function getAllToko()
  {
    $sql = "
      SELECT *
      FROM toko
      WHERE id != 1
    ";
    return $this->db->query($sql)->result_array();
  }

  public function getTokoById($toko_id)
  {
    $sql = "
      SELECT *
      FROM toko
      WHERE id = $toko_id
      LIMIT 1
    ";
    return $this->db->query($sql)->result_array();
  }

  public function getListOperasionalByToko($toko_id)
  {
    $sql = "
      SELECT *
      FROM operasional
      WHERE toko_id = $toko_id
    ";
    return $this->db->query($sql)->result_array();
  }

  public function getDataOperasional($id)
  {
    $sql = "
      SELECT *
      FROM operasional
      WHERE id = $id
      LIMIT 1
    ";
    return $this->db->query($sql)->result_array();
  }

  public function tambahOperasional()
  {
    $data = array(
      "id" => '',
      "keperluan" => $this->input->post('keperluan'),
      "biaya" => $this->input->post('biaya'),
      "jenis_uang" => $this->input->post('jenis_uang'),
      "toko_id" => $this->input->post('toko_id'),
      "created_at" => time()
    );

    $this->db->insert('operasional', $data);
    return ($this->db->affected_rows() != 1) ? FALSE : TRUE;
  }

  public function updateOperasional()
  {
    $data = array(
      "keperluan" => $this->input->post('keperluan'),
      "biaya" => $this->input->post('biaya'),
      "jenis_uang" => $this->input->post('jenis_uang'),
      "created_at" => time()
    );

    $this->db->where('id', $this->input->post('id'));
    $this->db->update('operasional', $data);
    return ($this->db->affected_rows() != 1) ? FALSE : TRUE;
  }

  public function deleteOperasional($id)
  {
    $this->db->where('id', $id);
    $this->db->delete('operasional'); // Untuk mengeksekusi perintah delete data
  }
}
