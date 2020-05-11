<?php
class Karyawan_model extends CI_Model
{
  protected $table = 'karyawan';

  public function viewTable()
  {
    return $this->db->get($this->table)->result();
  }

  // Fungsi untuk validasi form tambah dan ubah
  public function validation($mode)
  {
    if ($mode == "savenew") {
      $this->form_validation->set_rules('input_nama', 'Nama', 'trim|required');
      $this->form_validation->set_rules('input_username', 'Username', 'trim|required|is_unique[karyawan.username]');
      $this->form_validation->set_rules('input_password', 'Password', 'trim|required|min_length[8]|max_length[24]');
      $this->form_validation->set_rules('input_passconf', 'Password Konfirmasi', 'trim|required|matches[input_password]');
      $this->form_validation->set_rules('input_peran', 'Peran', 'trim|required');
      $this->form_validation->set_rules('input_toko', 'Penempatan Kerja', 'trim|required');
      // $this->form_validation->set_rules('input_shift', 'Penempatan Kerja', 'trim|required');
    } else if ($mode == "savenewadmin") {
      $this->form_validation->set_rules('input_nama', 'Nama', 'trim|required');
      $this->form_validation->set_rules('input_username', 'Username', 'trim|required|is_unique[karyawan.username]');
      $this->form_validation->set_rules('input_password', 'Password', 'trim|required|min_length[8]|max_length[24]');
      $this->form_validation->set_rules('input_passconf', 'Password Konfirmasi', 'trim|required|matches[input_password]');
      $this->form_validation->set_rules('input_peran', 'Peran', 'trim|required');
    } else if ($mode == "withpass") {
      $this->form_validation->set_rules('input_nama', 'Nama', 'trim|required');
      $this->form_validation->set_rules('input_password', 'Password', 'trim|required|min_length[8]|max_length[24]');
      $this->form_validation->set_rules('input_passconf', 'Password Konfirmasi', 'trim|required|matches[input_password]');
      $this->form_validation->set_rules('input_peran', 'Peran', 'trim|required');
      $this->form_validation->set_rules('input_toko', 'Penempatan Kerja', 'trim|required');
      // $this->form_validation->set_rules('input_shift', 'Penempatan Kerja', 'trim|required');
    } else if ($mode == "withoutpass") {
      $this->form_validation->set_rules('input_nama', 'Nama', 'trim|required');
      $this->form_validation->set_rules('input_peran', 'Peran', 'trim|required');
      $this->form_validation->set_rules('input_peran', 'Peran', 'trim|required');
      $this->form_validation->set_rules('input_toko', 'Penempatan Kerja', 'trim|required');
      // $this->form_validation->set_rules('input_shift', 'Penempatan Kerja', 'trim|required');
    } else if ($mode == "withpassadmin") {
      $this->form_validation->set_rules('input_nama', 'Nama', 'trim|required');
      $this->form_validation->set_rules('input_password', 'Password', 'trim|required|min_length[8]|max_length[24]');
      $this->form_validation->set_rules('input_passconf', 'Password Konfirmasi', 'trim|required|matches[input_password]');
      $this->form_validation->set_rules('input_peran', 'Peran', 'trim|required');
    } else if ($mode == "withoutpassadmin") {
      $this->form_validation->set_rules('input_nama', 'Nama', 'trim|required');
      $this->form_validation->set_rules('input_peran', 'Peran', 'trim|required');
    } else if ($mode == 'withpassowner') {
      $this->form_validation->set_rules('input_nama', 'Nama', 'trim|required');
      $this->form_validation->set_rules('input_password', 'Password', 'trim|required|min_length[8]|max_length[24]');
      $this->form_validation->set_rules('input_passconf', 'Password Konfirmasi', 'trim|required|matches[input_password]');
    } else if ($mode == 'withoutpassowner') {
      $this->form_validation->set_rules('input_nama', 'Nama', 'trim|required');
    }

    if ($this->form_validation->run()) // Jika validasi benar
      return true; // Maka kembalikan hasilnya dengan TRUE
    else // Jika ada data yang tidak sesuai validasi
      return false; // Maka kembalikan hasilnya dengan FALSE
  }

  // Fungsi untuk melakukan simpan data ke tabel siswa
  public function save()
  {
    $data = array(
      "username" => $this->input->post('input_username'),
      "password" => password_hash($this->input->post('input_password'), PASSWORD_BCRYPT),
      "nama" => $this->input->post('input_nama'),
      "cp" => $this->input->post('input_cp'),
      "alamat" => $this->input->post('input_alamat'),
      "tanggal_gaji" => $this->input->post('input_tgl_gaji'),
      "jumlah_gaji" => $this->input->post('input_jml_gaji'),
      "kode_peran" => $this->input->post('input_peran'),
      "shift" => $this->input->post('input_shift'),
      "toko_id" => $this->input->post('input_toko'),
      "is_active" => $this->input->post('input_is_active')
    );
    $temp_is_active = $data['is_active'];
    if ($temp_is_active != '1')
      $data['is_active'] = '0';

    if ($data['tanggal_gaji'] == "")
      $data['tanggal_gaji'] = '0000/00/00';

    $this->db->insert($this->table, $data); // Untuk mengeksekusi perintah insert data
    json_encode($data);
  }

  // Fungsi untuk melakukan ubah data siswa berdasarkan ID siswa
  public function edit($username, $mode)
  {
    if ($mode == "withpassadmin") {
      $mode = "withpass";
    } else if ($mode == "withoutpassadmin") {
      $mode = "withoutpass";
    }

    if ($mode == "withpass") {
      $data = array(
        "password" => password_hash($this->input->post('input_password'), PASSWORD_BCRYPT),
        "nama" => $this->input->post('input_nama'),
        "cp" => $this->input->post('input_cp'),
        "alamat" => $this->input->post('input_alamat'),
        "tanggal_gaji" => $this->input->post('input_tgl_gaji'),
        "jumlah_gaji" => $this->input->post('input_jml_gaji'),
        "kode_peran" => $this->input->post('input_peran'),
        "shift" => $this->input->post('input_shift'),
        "toko_id" => $this->input->post('input_toko'),
        "is_active" => $this->input->post('input_is_active')
      );
      if ($data["tanggal_gaji"] == "" || $data["jumlah_gaji"] == "") {
        $data["tanggal_gaji"] = '0000/00/00';
        $data["jumlah_gaji"] = 0;
      }
    } else if ($mode == "withoutpass") {
      $data = array(
        "nama" => $this->input->post('input_nama'),
        "cp" => $this->input->post('input_cp'),
        "alamat" => $this->input->post('input_alamat'),
        "tanggal_gaji" => $this->input->post('input_tgl_gaji'),
        "jumlah_gaji" => $this->input->post('input_jml_gaji'),
        "kode_peran" => $this->input->post('input_peran'),
        "shift" => $this->input->post('input_shift'),
        "toko_id" => $this->input->post('input_toko'),
        "is_active" => $this->input->post('input_is_active')
      );
      if ($data["tanggal_gaji"] == "" || $data["jumlah_gaji"] == "") {
        $data["tanggal_gaji"] = '0000/00/00';
        $data["jumlah_gaji"] = 0;
      }
    } else if ($mode == "withpassowner") {
      $data = array(
        "nama" => $this->input->post('input_nama'),
        "cp" => $this->input->post('input_cp'),
        "password" => password_hash($this->input->post('input_password'), PASSWORD_BCRYPT),
      );
    } else if ($mode == "withoutpassowner") {
      $data = array(
        "nama" => $this->input->post('input_nama'),
        "cp" => $this->input->post('input_cp')
      );
    }

    if ($data['tanggal_gaji'] == "")
      $data['tanggal_gaji'] = '0000/00/00';

    $this->db->where('username', $username);
    $this->db->update($this->table, $data); // Untuk mengeksekusi perintah update data
  }

  public function delete($username)
  {
    $this->db->where('username', $username);
    $this->db->delete($this->table); // Untuk mengeksekusi perintah delete data
  }
}
