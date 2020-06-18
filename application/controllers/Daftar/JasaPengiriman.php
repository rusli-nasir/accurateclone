<?php
defined('BASEPATH') or exit('No direct script access allowed');

class JasaPengiriman extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->load->model('AksesKontrol_model');
    $this->AksesKontrol_model->cekAutentikasi();
    $this->load->model('Daftar/JasaPengiriman_model');
  }

  public function index()
  {
    $data['list_pengiriman'] = $this->JasaPengiriman_model->getTableJasaPengiriman();
    $data['menu_sidebar'] = $this->AksesKontrol_model->getMenuEnabledForSidebar();
    $data['title'] = "Daftar | Jasa Pengiriman";
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar');
    $this->load->view('templates/topbar');
    if ($this->AksesKontrol_model->cekHakAksesFitur())
      $this->load->view('daftar/jasa_pengiriman/index', $data);
    else
      $this->load->view('templates/error_hak_akses');
    $this->load->view('templates/footer');
  }

  public function tambahJasaPengiriman()
  {
    if (!empty($_POST)) {
      var_dump($_POST);
      $status_insert = $this->JasaPengiriman_model->simpanJasaPengiriman();
      if ($status_insert)
        $this->session->set_flashdata('sukses', '<div class="alert alert-success alert-dismissible fade show mt-4 mb-4" role="alert" style="margin: 0;font-size: 1.2rem">Jasa Pengiriman ' . $_POST['nama'] . ' berhasil ditambahkan!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
      else
        $this->session->set_flashdata('error', '<div class="alert alert-danger alert-dismissible fade show mt-4 mb-4" role="alert" style="margin: 0;font-size: 1.2rem">Jasa Pengiriman ' . $_POST['nama'] . ' gagal ditambahkan!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
      redirect('Daftar/JasaPengiriman');
    } else {
      $data['menu_sidebar'] = $this->AksesKontrol_model->getMenuEnabledForSidebar();
      $data['title'] = "Daftar | Jasa Pengiriman";
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar');
      $this->load->view('templates/topbar');
      if ($this->AksesKontrol_model->cekHakAksesFitur())
        $this->load->view('daftar/jasa_pengiriman/tambahJasaPengiriman', $data);
      else
        $this->load->view('templates/error_hak_akses');
      $this->load->view('templates/footer');
    }
  }

  public function editJasaPengiriman($id = 0)
  {
    if ($id == 0)
      redirect('Daftar/JasaPengiriman');

    if (!empty($_POST)) {
      var_dump($_POST);
      $status_insert = $this->JasaPengiriman_model->editJasaPengiriman($id);
      if ($status_insert)
        $this->session->set_flashdata('sukses', '<div class="alert alert-success alert-dismissible fade show mt-4 mb-4" role="alert" style="margin: 0;font-size: 1.2rem">Jasa Pengiriman ' . $_POST['nama'] . ' berhasil diupdate!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
      else
        $this->session->set_flashdata('error', '<div class="alert alert-danger alert-dismissible fade show mt-4 mb-4" role="alert" style="margin: 0;font-size: 1.2rem">Jasa Pengiriman ' . $_POST['nama'] . ' gagal diupdate!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
      redirect('Daftar/JasaPengiriman');
    } else {
      $data['id'] = $id;
      $data['pengiriman'] = $this->JasaPengiriman_model->getJasaPengirimanById($id);
      $data['menu_sidebar'] = $this->AksesKontrol_model->getMenuEnabledForSidebar();
      $data['title'] = "Daftar | Jasa Pengiriman";
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar');
      $this->load->view('templates/topbar');
      if ($this->AksesKontrol_model->cekHakAksesFitur())
        $this->load->view('daftar/jasa_pengiriman/editJasaPengiriman', $data);
      else
        $this->load->view('templates/error_hak_akses');
      $this->load->view('templates/footer');
    }
  }

  public function hapusJasaPengiriman($id = 0)
  {
    if ($this->AksesKontrol_model->cekHakAksesFitur()) {
      if ($id == 0)
        redirect('Daftar/JasaPengiriman');
      else {
        $nama = $this->JasaPengiriman_model->getJasaPengirimanById($id)['nama'];
        $status = $this->JasaPengiriman_model->hapusJasaPengiriman($id);
        // var_dump($status);
        if ($status)
          $this->session->set_flashdata('sukses', '<div class="alert alert-success alert-dismissible fade show mt-4 mb-4" role="alert" style="margin: 0;font-size: 1.2rem">Jasa Pengiriman "' . $nama . '" berhasil di hapus!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        else
          $this->session->set_flashdata('error', '<div class="alert alert-danger alert-dismissible fade show mt-4 mb-4" role="alert" style="margin: 0;font-size: 1.2rem">Jasa Pengiriman "' . $nama . '" gagal di hapus!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        redirect('Daftar/JasaPengiriman');
      }
    } else {
      $data['title'] = "Daftar | Jasa Pengiriman | Hapus Jasa Pengiriman";
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar');
      $this->load->view('templates/topbar');
      $this->load->view('templates/error_hak_akses');
      $this->load->view('templates/footer');
    }
  }
}
