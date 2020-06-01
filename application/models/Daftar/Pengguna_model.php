<?php
class Pengguna_model extends CI_Model
{
  public function getMenus()
  {
    $this->db->select('*');
    $this->db->from('utility_menu');
    return $this->db->get()->result_array();
  }

  public function getFeatures()
  {
    $this->db->select('*');
    $this->db->from('utility_fitur');
    return $this->db->get()->result_array();
  }
  // --------------------------------------------------------------------------------------------------------
  //                                        PENGGUNA
  // --------------------------------------------------------------------------------------------------------

  public function getTablePengguna()
  {
    $this->db->select('*');
    $this->db->from('pengguna');
    return $this->db->get()->result_array();
  }

  public function checkUsernameUnique($username)
  {
    $this->db->select('*');
    $this->db->from('pengguna');
    $this->db->where('username', $username);

    return $this->db->get()->row_array();
  }

  public function simpanPengguna()
  {
    $data = array(
      'username' => htmlspecialchars($_POST['input_username']),
      'password' => password_hash($_POST['input_password'], PASSWORD_BCRYPT),
      'nama' => $_POST['input_nama'],
      'cp' => $_POST['input_cp'],
      'alamat' => $_POST['input_alamat'],
      'divisi_id ' => $_POST['input_divisi']
    );
    $this->db->insert('pengguna', $data);

    if ($this->db->affected_rows() == 1)
      return true;
    else
      return false;
  }

  public function getPenggunaByUsername($username)
  {
    $this->db->select('*');
    $this->db->from('pengguna');
    $this->db->where('username', $username);
    return $this->db->get()->row_array();
  }

  public function editPengguna($username)
  {
    $data = array(
      'username' => htmlspecialchars($_POST['input_username']),
      'password' => password_hash($_POST['input_password'], PASSWORD_BCRYPT),
      'nama' => $_POST['input_nama'],
      'cp' => $_POST['input_cp'],
      'alamat' => $_POST['input_alamat'],
      'divisi_id ' => $_POST['input_divisi']
    );
    $this->db->where('username', $username);
    $this->db->update('pengguna', $data);

    if ($this->db->affected_rows() == 1)
      return true;
    else
      return false;
  }

  public function hapusPengguna($username)
  {
    $this->db->where('username', $username);
    $this->db->delete('pengguna');

    if ($this->db->affected_rows() == 1)
      return true;
    else
      return false;
  }

  // --------------------------------------------------------------------------------------------------------
  //                                        DIVISI
  // --------------------------------------------------------------------------------------------------------

  public function getTableDivisi()
  {
    $this->db->select('id, nama_divisi as nama');
    $this->db->from('divisi');
    return $this->db->get()->result_array();
  }

  public function AJAXGetListOfMenuAndFeaturesId()
  {
    $temp = array();
    $this->db->select('html_id_menu');
    $this->db->from('utility_menu');
    array_push($temp, $this->db->get()->result_array());
    $this->db->select('html_id_fitur');
    $this->db->from('utility_fitur');
    array_push($temp, $this->db->get()->result_array());
    return $temp;
  }

  public function getNamaDivisiById($divisi_id)
  {
    $this->db->select('nama_divisi');
    $this->db->from('divisi');
    $this->db->where('id', $divisi_id);
    return $this->db->get()->row_array();
  }

  public function getHakAksesDivisiForMenuById($divisi_id)
  {
    $sql = "
      SELECT um.html_id_menu, uh.is_enabled
      FROM utility_menu um
      JOIN utility_hak_akses_menu uh
        ON uh.utility_menu_id = um.id
      WHERE uh.divisi_id = $divisi_id
    ";
    return $this->db->query($sql)->result_array();
  }

  public function getHakAksesDivisiForFiturById($divisi_id)
  {
    $sql = "
    SELECT uf.html_id_fitur, uh.is_enabled
    FROM utility_fitur uf
    JOIN utility_hak_akses_fitur uh
      ON uh.utility_fitur_id = uf.id
    WHERE uh.divisi_id = $divisi_id
    ";
    return $this->db->query($sql)->result_array();
  }

  // --------------------------------------------------------------------------------------------------------
  //                                        SIMPAN DIVISI
  // --------------------------------------------------------------------------------------------------------

  public function simpanDivisi()
  {
    $data_divisi = array(
      'nama_divisi' => $_POST['nama_divisi']
    );
    $this->db->insert('divisi', $data_divisi);

    $sql = "
      SELECT id
      FROM divisi
      ORDER BY id DESC
      LIMIT 1
    ";
    $divisi_id = $this->db->query($sql)->row_array()['id'];

    $this->_insertHakAksesMenu($divisi_id);
    $this->_insertHakAksesFitur($divisi_id);

    return $data_divisi['nama_divisi'];
  }

  private function _getMenuId($html_id_menu)
  {
    $sql = "
      SELECT id
      FROM utility_menu
      WHERE html_id_menu = '$html_id_menu'
      LIMIT 1
    ";

    return $this->db->query($sql)->row_array()['id'];
  }

  private function _getFiturId($html_id_fitur)
  {
    $sql = "
      SELECT id
      FROM utility_fitur
      WHERE html_id_fitur = '$html_id_fitur'
      LIMIT 1
    ";

    return $this->db->query($sql)->row_array()['id'];
  }

  private function _getBooleanFromCheckbox($value)
  {
    if (!empty($value))
      return 1;
    else
      return 0;
  }

  private function _insertHakAksesMenu($divisi_id)
  {
    $sql = "
      SELECT *
      FROM utility_menu
    ";
    $list_menu = $this->db->query($sql)->result_array();

    foreach ($list_menu as $menu) {

      $html_id_menu = $menu['html_id_menu'];
      $value_is_enabled = '';
      if (!empty($_POST[$html_id_menu]))
        $value_is_enabled = 'on';

      $data = array(
        'divisi_id' => $divisi_id,
        'utility_menu_id' => $this->_getMenuId($html_id_menu),
        'is_enabled' => $this->_getBooleanFromCheckbox($value_is_enabled)
      );

      $this->db->insert('utility_hak_akses_menu', $data);
    }
  }

  private function _insertHakAksesFitur($divisi_id)
  {
    $sql = "
      SELECT *
      FROM utility_fitur
    ";
    $list_fitur = $this->db->query($sql)->result_array();

    foreach ($list_fitur as $fitur) {

      $html_id_fitur = $fitur['html_id_fitur'];
      $value_is_enabled = '';
      if (!empty($_POST[$html_id_fitur]))
        $value_is_enabled = 'on';

      $data = array(
        'divisi_id' => $divisi_id,
        'utility_fitur_id' => $this->_getFiturId($html_id_fitur),
        'is_enabled' => $this->_getBooleanFromCheckbox($value_is_enabled)
      );

      // echo print_r($data);

      $this->db->insert('utility_hak_akses_fitur', $data);
    }
  }

  // --------------------------------------------------------------------------------------------------------
  //                                        EDIT DIVISI
  // --------------------------------------------------------------------------------------------------------

  public function getHakAksesMenuByDivisiId($divisi_id)
  {
    $sql = "
      SELECT um.html_id_menu, uh.is_enabled
      FROM divisi d
      JOIN utility_hak_akses_menu uh
        ON d.id = uh.divisi_id
      JOIN utility_menu um
        ON um.id = uh.utility_menu_id
      WHERE d.id = $divisi_id
    ";
    return $this->db->query($sql)->result_array();
  }

  public function getHakAksesFiturByDivisiId($divisi_id)
  {
    $sql = "
      SELECT uf.html_id_fitur, uh.is_enabled, um.html_id_menu
      FROM divisi d
      JOIN utility_hak_akses_fitur uh
        ON d.id = uh.divisi_id
      JOIN utility_fitur uf
        ON uf.id = uh.utility_fitur_id
      JOIN utility_menu um
        ON um.id = uf.utility_menu_id
      WHERE d.id = $divisi_id
    ";
    return $this->db->query($sql)->result_array();
  }

  public function editDivisi($divisi_id)
  {
    $data_divisi = array(
      'nama_divisi' => $_POST['nama_divisi']
    );

    $this->db->where('id', $divisi_id);
    $this->db->update('divisi', $data_divisi);

    $this->_updateHakAksesMenu($divisi_id);
    $this->_updateHakAksesFitur($divisi_id);

    return $data_divisi['nama_divisi'];
  }

  private function _getHakAksesMenuIdForUpdate($divisi_id, $html_id_menu)
  {
    $sql = "
      SELECT um.html_id_menu, uh.id AS hak_id, uh.divisi_id, uh.is_enabled
      FROM utility_menu um
      JOIN utility_hak_akses_menu uh
        ON um.id = uh.utility_menu_id
      WHERE uh.divisi_id = $divisi_id AND um.html_id_menu = '$html_id_menu'
      LIMIT 1
    ";
    return $this->db->query($sql)->row_array()['hak_id'];
  }

  private function _updateHakAksesMenu($divisi_id)
  {
    $sql = "
      SELECT *
      FROM utility_menu
    ";
    $list_menu = $this->db->query($sql)->result_array();

    foreach ($list_menu as $menu) {

      $html_id_menu = $menu['html_id_menu'];
      $value_is_enabled = '';
      if (!empty($_POST[$html_id_menu]))
        $value_is_enabled = 'on';

      $id_hak_akses_menu = $this->_getHakAksesMenuIdForUpdate($divisi_id, $html_id_menu);

      $data = array(
        'is_enabled' => $this->_getBooleanFromCheckbox($value_is_enabled)
      );

      $this->db->where('id', $id_hak_akses_menu);
      $this->db->update('utility_hak_akses_menu', $data);
    }
  }

  private function _getHakAksesFiturIdForUpdate($divisi_id, $html_id_menu)
  {
    $sql = "
      SELECT uf.html_id_fitur, uh.id AS hak_id, uh.divisi_id, uh.is_enabled
      FROM utility_fitur uf
      JOIN utility_hak_akses_fitur uh
        ON uf.id = uh.utility_fitur_id
      WHERE uh.divisi_id = $divisi_id AND uf.html_id_fitur = '$html_id_menu'
      LIMIT 1
    ";
    return $this->db->query($sql)->row_array()['hak_id'];
  }

  private function _updateHakAksesFitur($divisi_id)
  {
    $sql = "
      SELECT *
      FROM utility_fitur
    ";
    $list_fitur = $this->db->query($sql)->result_array();

    foreach ($list_fitur as $fitur) {

      $html_id_fitur = $fitur['html_id_fitur'];
      $value_is_enabled = '';
      if (!empty($_POST[$html_id_fitur]))
        $value_is_enabled = 'on';

      $id_hak_akses_fitur = $this->_getHakAksesFiturIdForUpdate($divisi_id, $html_id_fitur);

      $data = array(
        'is_enabled' => $this->_getBooleanFromCheckbox($value_is_enabled)
      );

      $this->db->where('id', $id_hak_akses_fitur);
      $this->db->update('utility_hak_akses_fitur', $data);
    }
  }

  // --------------------------------------------------------------------------------------------------------
  //                                        HAPUS DIVISI
  // --------------------------------------------------------------------------------------------------------

  public function hapusDivisi($divisi_id)
  {
    $this->db->select('id');
    $this->db->from('utility_hak_akses_fitur');
    $this->db->where('divisi_id ', $divisi_id);

    $hak_fitur = $this->db->get()->result_array();

    foreach ($hak_fitur as $id) {
      $this->db->where('id', $id['id']);
      $this->db->delete('utility_hak_akses_fitur');
    }

    $this->db->select('id');
    $this->db->from('utility_hak_akses_menu');
    $this->db->where('divisi_id ', $divisi_id);

    $hak_menu = $this->db->get()->result_array();

    foreach ($hak_menu as $id) {
      $this->db->where('id', $id['id']);
      $this->db->delete('utility_hak_akses_menu');
    }

    $this->db->select('nama_divisi');
    $this->db->from('divisi');
    $this->db->where('id ', $divisi_id);

    $nama_divisi = $this->db->get()->row_array();

    $this->db->where('id', $divisi_id);
    $this->db->delete('divisi');

    return $nama_divisi;
  }

  // --------------------------------------------------------------------------------------------------------
  //                                        END OF FUNCTIONS
  // --------------------------------------------------------------------------------------------------------
}
