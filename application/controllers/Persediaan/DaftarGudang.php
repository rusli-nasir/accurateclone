<?php
defined('BASEPATH') or exit('No direct script access allowed');

class DaftarGudang extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->load->model('AksesKontrol_model');
    $this->AksesKontrol_model->cekAutentikasi();
    $this->load->model('Persediaan/DaftarGudang_model');
  }

  public function index()
  {
    $data['gudang'] = $this->DaftarGudang_model->getTableGudang();
    $data['menu_sidebar'] = $this->AksesKontrol_model->getMenuEnabledForSidebar();
    $data['title'] = "Persediaan | Daftar Gudang";
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar');
    $this->load->view('templates/topbar');
    if ($this->AksesKontrol_model->cekHakAksesFitur())
      $this->load->view('persediaan/daftar_gudang/index');
    else
      $this->load->view('templates/error_hak_akses');
    $this->load->view('templates/footer');
  }

  public function tambahGudang()
  {
    if (!empty($_POST)) {
      $status_insert = $this->DaftarGudang_model->tambahGudang();
      if ($status_insert)
        $this->session->set_flashdata('suksesTambahGudang', '<div class="alert alert-success alert-dismissible fade show mt-4 mb-4" role="alert" style="margin: 0;font-size: 1.2rem">Gudang dengan nama ' . $_POST['nama_gudang'] . ' berhasil ditambahkan!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
      else
        $this->session->set_flashdata('errorTambahGudang', '<div class="alert alert-danger alert-dismissible fade show mt-4 mb-4" role="alert" style="margin: 0;font-size: 1.2rem">Gudang dengan nama ' . $_POST['nama_gudang'] . ' gagal ditambahkan!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
      echo json_encode(base_url('Persediaan/DaftarGudang'));
    } else {
      $data['menu_sidebar'] = $this->AksesKontrol_model->getMenuEnabledForSidebar();
      $data['title'] = "Persediaan | Daftar Gudang";
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar');
      $this->load->view('templates/topbar');
      if ($this->AksesKontrol_model->cekHakAksesFitur())
        $this->load->view('persediaan/daftar_gudang/tambahGudang');
      else
        $this->load->view('templates/error_hak_akses');
      $this->load->view('templates/footer');
    }
  }

  public function editGudang($id = 0)
  {
    if ($id == 0)
      redirect('Persediaan/DaftarGudang');

    if (!empty($_POST)) {
      $status_insert = $this->DaftarGudang_model->editGudang($id);
      if ($status_insert)
        $this->session->set_flashdata('suksesEditGudang', '<div class="alert alert-success alert-dismissible fade show mt-4 mb-4" role="alert" style="margin: 0;font-size: 1.2rem">Gudang dengan nama ' . $_POST['nama_gudang'] . ' berhasil di update!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
      else
        $this->session->set_flashdata('errorEditGudang', '<div class="alert alert-danger alert-dismissible fade show mt-4 mb-4" role="alert" style="margin: 0;font-size: 1.2rem">Gudang dengan nama ' . $_POST['nama_gudang'] . ' gagal di update!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
      echo json_encode(base_url('Persediaan/DaftarGudang'));
    } else {
      $data['gudang'] = $this->DaftarGudang_model->getGudangById($id);
      $data['menu_sidebar'] = $this->AksesKontrol_model->getMenuEnabledForSidebar();
      $data['title'] = "Persediaan | Daftar Gudang";
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar');
      $this->load->view('templates/topbar');
      if ($this->AksesKontrol_model->cekHakAksesFitur())
        $this->load->view('persediaan/daftar_gudang/editGudang');
      else
        $this->load->view('templates/error_hak_akses');
      $this->load->view('templates/footer');
    }
  }

  public function hapusGudang($id = 0)
  {
    if ($this->AksesKontrol_model->cekHakAksesFitur()) {
      if ($id == 0)
        redirect('Persediaan/DaftarGudang');
      else {

        $nama_gudang = $this->DaftarGudang_model->getGudangById($id)['nama_gudang'];
        $status = $this->DaftarGudang_model->hapusGudang($id);

        if ($status)
          $this->session->set_flashdata('suksesHapusGudang', '<div class="alert alert-success alert-dismissible fade show mt-4 mb-4" role="alert" style="margin: 0;font-size: 1.2rem">Gudang ' . $nama_gudang . ' berhasil di hapus!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        else
          $this->session->set_flashdata('errorHapusGudang', '<div class="alert alert-danger alert-dismissible fade show mt-4 mb-4" role="alert" style="margin: 0;font-size: 1.2rem">Gudang ' . $nama_gudang . ' gagal di hapus!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        redirect('Persediaan/DaftarGudang');
      }
    } else {
      $data['title'] = "Persediaan | Daftar Gudang | Hapus Gudang";
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar');
      $this->load->view('templates/topbar');
      $this->load->view('templates/error_hak_akses');
      $this->load->view('templates/footer');
    }
  }
}
