<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Upload extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->load->model('Api_auth_model');
  }

  public function index()
  {
    $dir = './upload/absen';
    $image = $this->input->post('image');
    $username = $this->input->post('username');

    if (!file_exists($dir)) {
      mkdir($dir, 0777, true);
    }

    $image_name = $dir . '/' . time() . '.jpeg';

    if (file_put_contents($image_name, base64_decode($image))) {

      $callback = array(
        'message' => 'File has been uploaded',
        'status' => 'OK',
        'username' => $username
      );
      echo json_encode($callback);
    } else {

      $callback = array(
        'message' => 'File upload failed',
        'status' => 'Error'
      );
      echo json_encode($callback);
    }
  }
}
