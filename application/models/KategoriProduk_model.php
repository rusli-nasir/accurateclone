<?php
class KategoriProduk_model extends CI_Model
{
  protected $table = 'kategori_produk';

  public function viewTable()
  {
    $this->db->select('*');
    $this->db->from($this->table);
    $this->db->order_by('nama', 'ASC');
    return $this->db->get()->result();
  }

  // Fungsi untuk validasi form tambah dan ubah
  public function validation()
  {
    // Tambahkan if apakah $mode save atau update
    // Karena ketika update, NIS tidak harus divalidasi
    // Jadi NIS di validasi hanya ketika menambah data siswa saja

    $this->form_validation->set_rules('input_nama', 'Nama Kategori', 'trim|required');

    if ($this->form_validation->run()) // Jika validasi benar
      return true; // Maka kembalikan hasilnya dengan TRUE
    else // Jika ada data yang tidak sesuai validasi
      return false; // Maka kembalikan hasilnya dengan FALSE
  }

  public function save()
  {
    $charset = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
    $base = strlen($charset);
    $result = '';

    $now = explode(' ', microtime())[1];
    while ($now >= $base) {
      $i = $now % $base;
      $result = $charset[$i] . $result;
      $now /= $base;
    }

    $class = substr($result, -5);
    $data = array(
      "id" => null,
      "nama" => $this->input->post('input_nama'),
      "class" => $class
    );

    $this->db->insert($this->table, $data); // Untuk mengeksekusi perintah insert data
    json_encode($data);
  }

  // Fungsi untuk melakukan ubah data siswa berdasarkan ID siswa
  public function edit($id)
  {
    $data = array(
      "nama" => $this->input->post('input_nama')
    );

    $this->db->where('id', $id);
    $this->db->update($this->table, $data); // Untuk mengeksekusi perintah update data
  }

  public function delete($id)
  {
    $this->db->where('id', $id);
    $this->db->delete($this->table); // Untuk mengeksekusi perintah delete data
  }
}
