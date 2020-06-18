<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pemasok extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->load->model('AksesKontrol_model');
    $this->load->model('Daftar/Pemasok_model');
    $this->AksesKontrol_model->cekAutentikasi();
  }

  public function index()
  {
    $data['list_pemasok'] = $this->Pemasok_model->getTablePemasok();
    $data['menu_sidebar'] = $this->AksesKontrol_model->getMenuEnabledForSidebar();
    $data['title'] = "Daftar | Pemasok";
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar');
    $this->load->view('templates/topbar');
    if ($this->AksesKontrol_model->cekHakAksesFitur())
      $this->load->view('daftar/pemasok/index', $data);
    else
      $this->load->view('templates/error_hak_akses');
    $this->load->view('templates/footer');
  }

  public function tambahPemasok()
  {
    if (!empty($_POST)) {
      var_dump($_POST);
      $status_insert = $this->Pemasok_model->simpanPemasok();
      if ($status_insert)
        $this->session->set_flashdata('sukses', '<div class="alert alert-success alert-dismissible fade show mt-4 mb-4" role="alert" style="margin: 0;font-size: 1.2rem">Pemasok ' . $_POST['nama'] . ' berhasil ditambahkan!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
      else
        $this->session->set_flashdata('error', '<div class="alert alert-danger alert-dismissible fade show mt-4 mb-4" role="alert" style="margin: 0;font-size: 1.2rem">Pemasok ' . $_POST['nama'] . ' gagal ditambahkan!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
      redirect('Daftar/Pemasok');
    } else {
      $data['menu_sidebar'] = $this->AksesKontrol_model->getMenuEnabledForSidebar();
      $data['title'] = "Daftar | Pemasok";
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar');
      $this->load->view('templates/topbar');
      if ($this->AksesKontrol_model->cekHakAksesFitur())
        $this->load->view('daftar/pemasok/tambahPemasok', $data);
      else
        $this->load->view('templates/error_hak_akses');
      $this->load->view('templates/footer');
    }
  }

  public function editPemasok($id = 0)
  {
    if ($id == 0)
      redirect('Daftar/Pemasok');

    if (!empty($_POST)) {
      var_dump($_POST);
      $status_insert = $this->Pemasok_model->editPemasok($id);
      if ($status_insert)
        $this->session->set_flashdata('sukses', '<div class="alert alert-success alert-dismissible fade show mt-4 mb-4" role="alert" style="margin: 0;font-size: 1.2rem">Pemasok ' . $_POST['nama'] . ' berhasil ditambahkan!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
      else
        $this->session->set_flashdata('error', '<div class="alert alert-danger alert-dismissible fade show mt-4 mb-4" role="alert" style="margin: 0;font-size: 1.2rem">Pemasok ' . $_POST['nama'] . ' gagal ditambahkan!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
      redirect('Daftar/Pemasok');
    } else {
      $data['id'] = $id;
      $data['pemasok'] = $this->Pemasok_model->getPemasokById($id);
      $data['menu_sidebar'] = $this->AksesKontrol_model->getMenuEnabledForSidebar();
      $data['title'] = "Daftar | Pemasok";
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar');
      $this->load->view('templates/topbar');
      if ($this->AksesKontrol_model->cekHakAksesFitur())
        $this->load->view('daftar/pemasok/editPemasok', $data);
      else
        $this->load->view('templates/error_hak_akses');
      $this->load->view('templates/footer');
    }
  }

  public function hapusPemasok($id = 0)
  {
    if ($this->AksesKontrol_model->cekHakAksesFitur()) {
      if ($id == 0)
        redirect('Daftar/Pemasok');
      else {
        $nama = $this->Pemasok_model->getPemasokById($id)['nama_pemasok'];
        $status = $this->Pemasok_model->hapusPemasok($id);
        // var_dump($status);
        if ($status)
          $this->session->set_flashdata('sukses', '<div class="alert alert-success alert-dismissible fade show mt-4 mb-4" role="alert" style="margin: 0;font-size: 1.2rem">Pemasok "' . $nama . '" berhasil di hapus!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        else
          $this->session->set_flashdata('error', '<div class="alert alert-danger alert-dismissible fade show mt-4 mb-4" role="alert" style="margin: 0;font-size: 1.2rem">Pemasok "' . $nama . '" gagal di hapus!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        redirect('Daftar/Pemasok');
      }
    } else {
      $data['title'] = "Daftar | Pemasok | Hapus Pemasok";
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar');
      $this->load->view('templates/topbar');
      $this->load->view('templates/error_hak_akses');
      $this->load->view('templates/footer');
    }
  }
}
