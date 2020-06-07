<?php
defined('BASEPATH') or exit('No direct script access allowed');

class InfoPerusahaan extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->load->model('AksesKontrol_model');
    $this->AksesKontrol_model->cekAutentikasi();
    $this->load->model('InfoPerusahaan_model');
  }

  public function index()
  {
    if (!empty($_POST)) {
      var_dump($_POST);
      $status_insert = $this->InfoPerusahaan_model->simpanPerusahaan();
      if ($status_insert)
        $this->session->set_flashdata('sukses', '<div class="alert alert-success alert-dismissible fade show mt-4 mb-4" role="alert" style="margin: 0;font-size: 1.2rem">Data perusahaan berhasi diupdate!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
      else
        $this->session->set_flashdata('error', '<div class="alert alert-danger alert-dismissible fade show mt-4 mb-4" role="alert" style="margin: 0;font-size: 1.2rem">Data perusahaan gagal diupdate!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
      redirect('redirect/InfoPerusahaan');
    } else {
      $data['data'] = $this->InfoPerusahaan_model->getInfoPerusahaan();
      $data['menu_sidebar'] = $this->AksesKontrol_model->getMenuEnabledForSidebar();
      $data['title'] = "Info Perusahaan";
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar');
      $this->load->view('templates/topbar');
      if ($this->AksesKontrol_model->cekHakAksesMenu())
        $this->load->view('info_perusahaan/index');
      else
        $this->load->view('templates/error_hak_akses');
      $this->load->view('templates/footer');
    }
  }
}
