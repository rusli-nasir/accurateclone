<?php
class Auth_model extends CI_Model
{
  protected $table = 'pengguna';

  public function getWhereToRedirect($username)
  {
    $sql = "
      SELECT um.link_menu
      FROM pengguna p
      JOIN divisi d
        ON p.divisi_id = d.id
      JOIN utility_hak_akses_menu uh
        ON uh.divisi_id = d.id
      JOIN utility_menu um
        ON um.id = uh.utility_menu_id
      WHERE uh.is_enabled = 1 AND p.username = '$username'
      LIMIT 1
    ";

    return $this->db->query($sql)->row_array();
  }

  public function validation()
  {
    $this->form_validation->set_rules('username', 'Username', 'trim|required');
    $this->form_validation->set_rules('password', 'Password', 'required');

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
