<?php
class Api_auth_model extends CI_Model
{
  public function cekUser($uname)
  {
    $sql = "
      SELECT *
      FROM karyawan
      WHERE username = '$uname'
      LIMIT 1
    ";

    if ($this->db->query($sql)->num_rows() > 0) {
      return true;
    } else {
      return false;
    }
  }

  public function login($uname, $pass)
  {
    $sql = "
      SELECT password
      FROM karyawan
      WHERE username = '$uname'
      LIMIT 1
    ";

    $data = $this->db->query($sql)->row_array();

    if (password_verify($pass, $data['password'])) {
      return true;
    } else {
      return false;
    }
  }

  public function getUserData($uname)
  {
    $sql = "
      SELECT *
      FROM karyawan
      WHERE username = '$uname'
      LIMIT 1
    ";

    return $this->db->query($sql)->row_array();
  }
}
