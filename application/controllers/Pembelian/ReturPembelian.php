<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ReturPembelian extends CI_Controller
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
    $data['title'] = "Pembelian | Retur Pembelian";
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar');
    $this->load->view('templates/topbar');
    if ($this->AksesKontrol_model->cekHakAksesFitur())
      $this->load->view('errors/html/under_construction');
    else
      $this->load->view('templates/error_hak_akses');
    $this->load->view('templates/footer');
  }
}
