<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pelanggan extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->load->model('AksesKontrol_model');
    $this->AksesKontrol_model->cekAutentikasi();
    $this->load->model('Daftar/Pelanggan_model');
  }

  public function index()
  {
    $data['list_pelanggan'] = $this->Pelanggan_model->getTablePelanggan();
    $data['menu_sidebar'] = $this->AksesKontrol_model->getMenuEnabledForSidebar();
    $data['title'] = "Daftar | Pelanggan";
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar');
    $this->load->view('templates/topbar');
    if ($this->AksesKontrol_model->cekHakAksesFitur())
      $this->load->view('daftar/pelanggan/index', $data);
    else
      $this->load->view('templates/error_hak_akses');
    $this->load->view('templates/footer');
  }

  public function tambahPelanggan()
  {
    if (!empty($_POST)) {
      var_dump($_POST);
      $status_insert = $this->Pelanggan_model->simpanPelanggan();
      if ($status_insert)
        $this->session->set_flashdata('sukses', '<div class="alert alert-success alert-dismissible fade show mt-4 mb-4" role="alert" style="margin: 0;font-size: 1.2rem">Pelanggan ' . $_POST['nama'] . ' berhasil ditambahkan!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
      else
        $this->session->set_flashdata('error', '<div class="alert alert-danger alert-dismissible fade show mt-4 mb-4" role="alert" style="margin: 0;font-size: 1.2rem">Pelanggan ' . $_POST['nama'] . ' gagal ditambahkan!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
      redirect('Daftar/Pelanggan');
    } else {
      $data['menu_sidebar'] = $this->AksesKontrol_model->getMenuEnabledForSidebar();
      $data['title'] = "Daftar | Pelanggan";
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar');
      $this->load->view('templates/topbar');
      if ($this->AksesKontrol_model->cekHakAksesFitur())
        $this->load->view('daftar/pelanggan/tambahPelanggan', $data);
      else
        $this->load->view('templates/error_hak_akses');
      $this->load->view('templates/footer');
    }
  }

  public function editPelanggan($id_pelanggan = 0)
  {
    if ($id_pelanggan == 0)
      redirect('Daftar/Pelanggan');

    if (!empty($_POST)) {
      var_dump($_POST);
      $status_insert = $this->Pelanggan_model->editPelanggan($id_pelanggan);
      if ($status_insert)
        $this->session->set_flashdata('sukses', '<div class="alert alert-success alert-dismissible fade show mt-4 mb-4" role="alert" style="margin: 0;font-size: 1.2rem">Pelanggan ' . $_POST['nama'] . ' berhasil diupdate!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
      else
        $this->session->set_flashdata('error', '<div class="alert alert-danger alert-dismissible fade show mt-4 mb-4" role="alert" style="margin: 0;font-size: 1.2rem">Pelanggan ' . $_POST['nama'] . ' gagal diupdate!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
      redirect('Daftar/Pelanggan');
    } else {
      $data['id'] = $id_pelanggan;
      $data['pelanggan'] = $this->Pelanggan_model->getPelangganById($id_pelanggan);
      $data['menu_sidebar'] = $this->AksesKontrol_model->getMenuEnabledForSidebar();
      $data['title'] = "Daftar | Pelanggan";
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar');
      $this->load->view('templates/topbar');
      if ($this->AksesKontrol_model->cekHakAksesFitur())
        $this->load->view('daftar/pelanggan/editPelanggan', $data);
      else
        $this->load->view('templates/error_hak_akses');
      $this->load->view('templates/footer');
    }
  }

  public function hapusPelanggan($id = 0)
  {
    if ($this->AksesKontrol_model->cekHakAksesFitur()) {
      if ($id == 0)
        redirect('Daftar/Pelanggan');
      else {
        $nama = $this->Pelanggan_model->getPelangganById($id)['nama_pelanggan'];
        $status = $this->Pelanggan_model->hapusPelanggan($id);
        // var_dump($status);
        if ($status)
          $this->session->set_flashdata('sukses', '<div class="alert alert-success alert-dismissible fade show mt-4 mb-4" role="alert" style="margin: 0;font-size: 1.2rem">Pelanggan "' . $nama . '" berhasil di hapus!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        else
          $this->session->set_flashdata('error', '<div class="alert alert-danger alert-dismissible fade show mt-4 mb-4" role="alert" style="margin: 0;font-size: 1.2rem">Pelanggan "' . $nama . '" gagal di hapus!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        redirect('Daftar/Pelanggan');
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
