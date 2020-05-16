<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Notifikasi extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->load->model('AksesKontrol_model');
    $this->AksesKontrol_model->cekAutentikasi();
  }

  public function index()
  {
    $data['menu_sidebar'] = $this->AksesKontrol_model->getMenuEnabledForSidebar();
    $data['title'] = "Notifikasi";
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar');
    $this->load->view('errors/html/under_construction');
    $this->load->view('templates/footer');
  }
}
