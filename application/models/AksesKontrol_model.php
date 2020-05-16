<?php
class AksesKontrol_model extends CI_Model
{
  public function cekAutentikasi()
  {
    if ($this->session->userdata('masuk') != TRUE)
      redirect('Auth');
  }

  public function cekHakAksesMenu()
  {
    $menu = $this->uri->segment(2);
    $username = $this->session->userdata('uname');

    $sql = "
      SELECT uh.is_enabled
      FROM pengguna p
      JOIN divisi d
        ON p.divisi_id = d.id
      JOIN utility_hak_akses_menu uh
        ON uh.divisi_id = d.id
      JOIN utility_menu um
        ON um.id = uh.utility_menu_id
      WHERE p.username = '$username' AND um.link_menu = '$menu'
      LIMIT 1
    ";
    $is_enabled = $this->db->query($sql)->row_array();

    if (!empty($is_enabled)) {
      if ($is_enabled['is_enabled'] == 1)
        return true;
      else
        return false;
    } else {
      return false;
    }
  }

  public function cekHakAksesFitur()
  {
    $fitur = $this->uri->segment(2);
    $username = $this->session->userdata('uname');

    $sql = "
      SELECT uh.is_enabled
      FROM pengguna p
      JOIN divisi d
        ON p.divisi_id = d.id
      JOIN utility_hak_akses_fitur uh
        ON uh.divisi_id = d.id
      JOIN utility_fitur uf
        ON uf.id = uh.utility_fitur_id
      WHERE p.username = '$username' AND uf.link_fitur = '$fitur'
      LIMIT 1
    ";
    $is_enabled = $this->db->query($sql)->row_array();

    if (!empty($is_enabled)) {
      if ($is_enabled['is_enabled'] == 1)
        return true;
      else
        return false;
    } else {
      return false;
    }
  }

  public function getMenuEnabledForSidebar()
  {
    $username = $this->session->userdata('uname');
    $sql = "
      SELECT um.nama_menu, um.link_menu, um.html_id_menu, um.icon
      FROM pengguna p
      JOIN divisi d
        ON p.divisi_id = d.id
      JOIN utility_hak_akses_menu uh
        ON uh.divisi_id = d.id
      JOIN utility_menu um
        ON um.id = uh.utility_menu_id
      WHERE p.username = '$username' AND uh.is_enabled = 1
    ";
    return $this->db->query($sql)->result_array();
  }

  public function getFiturEnabledForRedirect()
  {
    $menu = $this->uri->segment(2);
    $username = $this->session->userdata('uname');
    $sql = "
      SELECT uf.nama_fitur, uf.link_fitur, uf.icon, um.link_menu
      FROM pengguna p
      JOIN divisi d
        ON p.divisi_id = d.id
      JOIN utility_hak_akses_fitur uh
        ON uh.divisi_id = d.id
      JOIN utility_fitur uf
        ON uf.id = uh.utility_fitur_id
      JOIN utility_menu um
        ON um.id = uf.utility_menu_id
      WHERE p.username = '$username' AND uh.is_enabled = 1 AND um.link_menu = '$menu'
    ";
    return $this->db->query($sql)->result_array();
  }
}
