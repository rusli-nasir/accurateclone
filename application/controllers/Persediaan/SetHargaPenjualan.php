<?php
defined('BASEPATH') or exit('No direct script access allowed');

class SetHargaPenjualan extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->load->model('AksesKontrol_model');
    $this->AksesKontrol_model->cekAutentikasi();
    $this->load->model('Persediaan/SetHargaPenjualan_model');
  }

  public function index()
  {
    $data['list_set_harga'] = $this->SetHargaPenjualan_model->getTableSetHargaPenjualan();
    $data['menu_sidebar'] = $this->AksesKontrol_model->getMenuEnabledForSidebar();
    $data['title'] = "Persediaan | Set Harga Penjualan";
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar');
    $this->load->view('templates/topbar');
    if ($this->AksesKontrol_model->cekHakAksesFitur())
      $this->load->view('persediaan/set_harga_penjualan/index');
    else
      $this->load->view('templates/error_hak_akses');
    $this->load->view('templates/footer');
  }

  public function tambahSetHargaPenjualan()
  {
    if (!empty($_POST)) {
      var_dump($_POST);
      $status_insert = $this->SetHargaPenjualan_model->simpanSetHargaPenjualan();
      if ($status_insert)
        $this->session->set_flashdata('sukses', '<div class="alert alert-success alert-dismissible fade show mt-4 mb-4" role="alert" style="margin: 0;font-size: 1.2rem">Penyesuaian harga berhasil ditambahkan!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
      else
        $this->session->set_flashdata('error', '<div class="alert alert-danger alert-dismissible fade show mt-4 mb-4" role="alert" style="margin: 0;font-size: 1.2rem">Penyesuaian harga gagal ditambahkan!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
      redirect('Persediaan/SetHargaPenjualan');
    } else {
      $data['barang'] = $this->SetHargaPenjualan_model->getTableBarang();
      $data['menu_sidebar'] = $this->AksesKontrol_model->getMenuEnabledForSidebar();
      $data['title'] = "Persediaan | Set Harga Penjualan";
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar');
      $this->load->view('templates/topbar');
      if ($this->AksesKontrol_model->cekHakAksesFitur())
        $this->load->view('persediaan/set_harga_penjualan/tambahSetHargaPenjualan');
      else
        $this->load->view('templates/error_hak_akses');
      $this->load->view('templates/footer');
    }
  }

  public function addRowHargaPenjualanBarang($id_barang)
  {
    $harga_penjualan_barang = $this->SetHargaPenjualan_model->getDataHargaPenjualanBarangByIdBarang($id_barang);
    $html = $this->load->view('persediaan/set_harga_penjualan/addRowBarangTerpilih', array('model' => $harga_penjualan_barang), true);
    $data = array(
      'html' => $html
    );
    echo json_encode($data);
  }

  public function editSetHargaPenjualan($id_form = 0)
  {
    if ($id_form == 0)
      redirect('Persediaan/SetHargaPenjualan');

    if (!empty($_POST)) {
      var_dump($_POST);
      $status_insert = $this->SetHargaPenjualan_model->editSetHargaPenjualan($id_form);
      if ($status_insert)
        $this->session->set_flashdata('sukses', '<div class="alert alert-success alert-dismissible fade show mt-4 mb-4" role="alert" style="margin: 0;font-size: 1.2rem">Penyesuaian harga berhasil diupdate!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
      else
        $this->session->set_flashdata('error', '<div class="alert alert-danger alert-dismissible fade show mt-4 mb-4" role="alert" style="margin: 0;font-size: 1.2rem">Penyesuaian harga gagal diupdate!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
      redirect('Persediaan/SetHargaPenjualan');
    } else {
      $data['id_form'] = $id_form;
      $data['data_form'] = $this->SetHargaPenjualan_model->getDataFormSetHargaPenjualanId($id_form);
      $data['list_harga_per_barang'] = $this->SetHargaPenjualan_model->getListDataHargaBarangDisesuaikanByFormId($id_form);
      $data['barang'] = $this->SetHargaPenjualan_model->getTableBarang();
      $data['barang_added'] = $this->SetHargaPenjualan_model->getTableBarangHasBeenAdded($id_form);
      $data['menu_sidebar'] = $this->AksesKontrol_model->getMenuEnabledForSidebar();
      $data['title'] = "Persediaan | Set Harga Penjualan";
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar');
      $this->load->view('templates/topbar');
      if ($this->AksesKontrol_model->cekHakAksesFitur())
        $this->load->view('persediaan/set_harga_penjualan/editSetHargaPenjualan');
      else
        $this->load->view('templates/error_hak_akses');
      $this->load->view('templates/footer');
    }
  }

  public function hapusSetHargaPenjualan($id_form = 0)
  {
    if ($this->AksesKontrol_model->cekHakAksesFitur()) {
      if ($id_form == 0)
        redirect('Persediaan/SetHargaPenjualan');
      else {
        $keterangan = $this->SetHargaPenjualan_model->getKetFormSetHargaPenjualan($id_form);
        $status = $this->SetHargaPenjualan_model->hapusSetHargaPenjualanPerBarang($id_form);

        if ($status)
          $this->session->set_flashdata('sukses', '<div class="alert alert-success alert-dismissible fade show mt-4 mb-4" role="alert" style="margin: 0;font-size: 1.2rem">Penyesuaian harga ' . $keterangan . ' berhasil di hapus!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        else
          $this->session->set_flashdata('error', '<div class="alert alert-danger alert-dismissible fade show mt-4 mb-4" role="alert" style="margin: 0;font-size: 1.2rem">Penyesuaian harga ' . $keterangan . ' gagal di hapus!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        redirect('Persediaan/SetHargaPenjualan');
      }
    } else {
      $data['title'] = "Persediaan | Set Harga Penjualan | Hapus Penyesuaian Harga";
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar');
      $this->load->view('templates/topbar');
      $this->load->view('templates/error_hak_akses');
      $this->load->view('templates/footer');
    }
  }
}
