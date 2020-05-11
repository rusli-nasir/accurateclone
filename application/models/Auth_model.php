<?php
class Auth_model extends CI_Model
{
  protected $table = 'karyawan';

  public function validation()
  {
    $this->form_validation->set_rules('username', 'Username', 'trim|required');
    $this->form_validation->set_rules('password', 'Password', 'trim|required');

    if ($this->form_validation->run()) // Jika validasi benar
      return true; // Maka kembalikan hasilnya dengan TRUE
    else // Jika ada data yang tidak sesuai validasi
      return false; // Maka kembalikan hasilnya dengan FALSE
  }

  public function getUserData($uname)
  {
    return $this->db->get_where($this->table, ['username' => $uname])->row_array();
  }
}
