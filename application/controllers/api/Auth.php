<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->load->model('Api_auth_model');
  }

  public function index()
  {
    $uname = $this->input->post('email');
    $pass = $this->input->post('password');

    $cek = $this->Api_auth_model->cekUser($uname);

    if (!$cek) {
      $response = array('status' => false, 'message' => 'User Tidak Terdaftar');
      echo json_encode($response);
    } else {
      $login = $this->Api_auth_model->login($uname, $pass);

      if ($login) {
        $userData = $this->Api_auth_model->getUserData($uname);
        $response = array('status' => true, 'message' => 'success', 'username' => $uname, 'nama' => $userData['nama']);
        echo json_encode($response);
      } else {
        $response = array('status' => false, 'message' => 'Password Salah');
        echo json_encode($response);
      }
    }
  }
}
