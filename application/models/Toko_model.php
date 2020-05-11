<?php
class Toko_model extends CI_Model
{
  protected $table = 'toko';

  public function viewTable()
  {
    return $this->db->get($this->table)->result_array();
  }

  public function getNamaToko($toko_id)
  {
    $sql = "
    SELECT t.nama
    FROM toko t
    WHERE
      t.id = $toko_id
    LIMIT 1
    ";
    $query = $this->db->query($sql);
    return $query->result_array();
  }

  // Fungsi untuk validasi form tambah dan ubah
  public function validation()
  {
    // Tambahkan if apakah $mode save atau update
    // Karena ketika update, NIS tidak harus divalidasi
    // Jadi NIS di validasi hanya ketika menambah data siswa saja

    $this->form_validation->set_rules('input_nama', 'Nama Toko Cabang', 'trim|required');
    $this->form_validation->set_rules('input_alamat', 'Alamat Toko Cabang', 'trim|required');

    if ($this->form_validation->run()) // Jika validasi benar
      return true; // Maka kembalikan hasilnya dengan TRUE
    else // Jika ada data yang tidak sesuai validasi
      return false; // Maka kembalikan hasilnya dengan FALSE
  }

  public function save()
  {
    $data = array(
      "nama" => $this->input->post('input_nama'),
      "alamat" => $this->input->post('input_alamat')
    );

    $this->db->insert($this->table, $data);
  }

  public function edit($id)
  {
    $data = array(
      "nama" => $this->input->post('input_nama'),
      "alamat" => $this->input->post('input_alamat')
    );

    $this->db->where('id', $id);
    $this->db->update($this->table, $data); // Untuk mengeksekusi perintah update data
    return ($this->db->affected_rows() != 1) ? false : true;
  }

  public function delete($id)
  {
    $this->db->where('id', $id);
    $this->db->delete($this->table); // Untuk mengeksekusi perintah delete data
  }
}
