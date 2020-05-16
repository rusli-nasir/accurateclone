<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penjualan extends CI_Controller
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
    $data['list_fitur'] = $this->AksesKontrol_model->getFiturEnabledForRedirect();
    $data['title'] = "Penjualan";
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar');
    if ($this->AksesKontrol_model->cekHakAksesMenu())
      $this->load->view('redirect');
    else
      $this->load->view('templates/error_hak_akses');
    $this->load->view('templates/footer');
  }
}
