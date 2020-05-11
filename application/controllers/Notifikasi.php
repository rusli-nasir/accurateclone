<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Notifikasi extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    //validasi jika user belum login
    if ($this->session->userdata('masuk') != TRUE) {
      $url = base_url();
      redirect($url);
    } else {
      $this->load->model('Notifikasi_model');
    }
  }

  public function index()
  {
    $this->load->library('cart');
    $this->cart->destroy();
    $data['title'] = "Notifikasi";
    $data['model'] = $this->Notifikasi_model->viewTable();
    $data['not_read'] = $this->Notifikasi_model->getNotRead();
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar');
    $this->load->view('templates/topbar', $data);
    $this->load->view('notifikasi/index', $data);
    $this->load->view('templates/footer');
  }

  public function terbaca()
  {
    if ($this->session->userdata['role'] == 2 || $this->session->userdata['role'] == 3)
      $this->Notifikasi_model->updateTerbaca();

    $model = $this->Notifikasi_model->viewTable();
    $html = $this->load->view('notifikasi/viewTable', array('model' => $model));

    echo json_encode($html);
  }
}
