<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PenyeseuaianPersediaan extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->load->model('AksesKontrol_model');
    $this->AksesKontrol_model->cekAutentikasi();
    $this->load->model('Persediaan/DaftarGudang_model');
    $this->load->model('Persediaan/PenyeseuaianPersediaan_model');
  }

  public function index()
  {
    $data['list_penyesuaian'] = $this->PenyeseuaianPersediaan_model->getTablePenyeseuaianPersediaan();
    $data['menu_sidebar'] = $this->AksesKontrol_model->getMenuEnabledForSidebar();
    $data['title'] = "Persediaan | Penyeseuaian Persediaan";
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar');
    $this->load->view('templates/topbar');
    if ($this->AksesKontrol_model->cekHakAksesFitur())
      $this->load->view('persediaan/penyesuaian_persediaan/index');
    else
      $this->load->view('templates/error_hak_akses');
    $this->load->view('templates/footer');
  }

  public function addRowPenyesuaianPersediaan($id_barang)
  {
    $gudang = $this->DaftarGudang_model->getTableGudang();
    $data_stok = $this->PenyeseuaianPersediaan_model->getDataPersediaanPerBarang($id_barang);
    $html = $this->load->view('persediaan/penyesuaian_persediaan/addRowPenyesuaianPersediaan', array('model' => $data_stok, 'gudang' => $gudang), true);
    $data = array(
      'html' => $html
    );
    echo json_encode($data);
  }

  public function tambahPenyeseuaianPersediaan()
  {
    if (!empty($_POST)) {
      // var_dump($_POST);
      $status_insert = $this->PenyeseuaianPersediaan_model->simpanPenyeseuaianPersediaan();
      if ($status_insert)
        $this->session->set_flashdata('sukses', '<div class="alert alert-success alert-dismissible fade show mt-4 mb-4" role="alert" style="margin: 0;font-size: 1.2rem">Penyesuaian harga berhasil ditambahkan!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
      else
        $this->session->set_flashdata('error', '<div class="alert alert-danger alert-dismissible fade show mt-4 mb-4" role="alert" style="margin: 0;font-size: 1.2rem">Penyesuaian harga gagal ditambahkan!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
      redirect('Persediaan/PenyeseuaianPersediaan');
    } else {
      $data['barang'] = $this->PenyeseuaianPersediaan_model->getTableBarang();
      $data['menu_sidebar'] = $this->AksesKontrol_model->getMenuEnabledForSidebar();
      $data['title'] = "Persediaan | Penyeseuaian Persediaan";
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar');
      $this->load->view('templates/topbar');
      if ($this->AksesKontrol_model->cekHakAksesFitur())
        $this->load->view('persediaan/penyesuaian_persediaan/tambahPenyeseuaianPersediaan');
      else
        $this->load->view('templates/error_hak_akses');
      $this->load->view('templates/footer');
    }
  }

  public function editPenyeseuaianPersediaan($id_form = 0)
  {
    if ($id_form == 0)
      redirect('Persediaan/SetHargaPenjualan');

    if (!empty($_POST)) {
      var_dump($_POST);
      $status = $this->PenyeseuaianPersediaan_model->editPenyeseuaianPersediaan($id_form);
      if ($status)
        $this->session->set_flashdata('sukses', '<div class="alert alert-success alert-dismissible fade show mt-4 mb-4" role="alert" style="margin: 0;font-size: 1.2rem">Penyesuaian harga berhasil diupdate!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
      else
        $this->session->set_flashdata('error', '<div class="alert alert-danger alert-dismissible fade show mt-4 mb-4" role="alert" style="margin: 0;font-size: 1.2rem">Penyesuaian harga gagal diupdate!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
      redirect('Persediaan/PenyeseuaianPersediaan');
    } else {
      $data['id_form'] = $id_form;
      $data['gudang'] = $this->DaftarGudang_model->getTableGudang();
      $data['list_barang_disesuaikan'] = $this->PenyeseuaianPersediaan_model->getListDataBarangPenyeseuaianPersediaan($id_form);
      $data['data_form'] = $this->PenyeseuaianPersediaan_model->getDataFormPenyeseuaianPersediaan($id_form);
      $data['barang'] = $this->PenyeseuaianPersediaan_model->getTableBarang();
      $data['menu_sidebar'] = $this->AksesKontrol_model->getMenuEnabledForSidebar();
      $data['title'] = "Persediaan | Penyeseuaian Persediaan";
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar');
      $this->load->view('templates/topbar');
      if ($this->AksesKontrol_model->cekHakAksesFitur())
        $this->load->view('persediaan/penyesuaian_persediaan/editPenyeseuaianPersediaan');
      else
        $this->load->view('templates/error_hak_akses');
      $this->load->view('templates/footer');
    }
  }

  public function hapusPenyeseuaianPersediaan($id_form = 0)
  {
    if ($this->AksesKontrol_model->cekHakAksesFitur()) {
      if ($id_form == 0)
        redirect('Persediaan/PenyeseuaianPersediaan');
      else {
        $keterangan = $this->PenyeseuaianPersediaan_model->getKetFormPenyesuaianPersediaan($id_form);
        $status = $this->PenyeseuaianPersediaan_model->hapusPenyeseuaianPersediaan($id_form);
        // var_dump($status);
        if ($status)
          $this->session->set_flashdata('sukses', '<div class="alert alert-success alert-dismissible fade show mt-4 mb-4" role="alert" style="margin: 0;font-size: 1.2rem">Penyesuaian persediaan "' . $keterangan . '" berhasil di hapus!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        else
          $this->session->set_flashdata('error', '<div class="alert alert-danger alert-dismissible fade show mt-4 mb-4" role="alert" style="margin: 0;font-size: 1.2rem">Penyesuaian persediaan "' . $keterangan . '" gagal di hapus!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        redirect('Persediaan/PenyeseuaianPersediaan');
      }
    } else {
      $data['title'] = "Persediaan | Penyeseuaian Persediaan | Hapus Penyesuaian Persediaan";
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar');
      $this->load->view('templates/topbar');
      $this->load->view('templates/error_hak_akses');
      $this->load->view('templates/footer');
    }
  }
}
