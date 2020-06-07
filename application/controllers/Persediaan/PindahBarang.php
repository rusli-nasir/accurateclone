<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PindahBarang extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->load->model('AksesKontrol_model');
    $this->AksesKontrol_model->cekAutentikasi();
    $this->load->model('Persediaan/DaftarGudang_model');
    $this->load->model('Persediaan/PindahBarang_model');
  }

  public function index()
  {
    $data['list_pemindahan'] = $this->PindahBarang_model->getTablePemindahanBarang();
    $data['menu_sidebar'] = $this->AksesKontrol_model->getMenuEnabledForSidebar();
    $data['title'] = "Persediaan | Pindah Barang";
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar');
    $this->load->view('templates/topbar');
    if ($this->AksesKontrol_model->cekHakAksesFitur())
      $this->load->view('persediaan/pindah_barang/index');
    else
      $this->load->view('templates/error_hak_akses');
    $this->load->view('templates/footer');
  }

  public function getTableBarangFromGudangId($id_gudang)
  {
    $list_barang = $this->PindahBarang_model->getBarangFromGudangId($id_gudang);
    $html = $this->load->view('persediaan/pindah_barang/tablePilihBarang', array('model' => $list_barang), true);
    $data = array(
      'html' => $html
    );
    echo json_encode($data);
  }

  public function addRowPemindahanBarang($id_barang)
  {
    $data_barang = $this->PindahBarang_model->getDataPersediaanPerBarang($id_barang);
    $html = $this->load->view('persediaan/pindah_barang/addRowPemindahanBarang', array('model' => $data_barang), true);
    $data = array(
      'html' => $html,
      'id' => $id_barang
    );
    echo json_encode($data);
  }

  public function tambahPemindahanBarang()
  {
    if (!empty($_POST)) {
      var_dump($_POST);
      $status_insert = $this->PindahBarang_model->simpanPemindahanBarang();
      if ($status_insert)
        $this->session->set_flashdata('sukses', '<div class="alert alert-success alert-dismissible fade show mt-4 mb-4" role="alert" style="margin: 0;font-size: 1.2rem">Pemindahan barang berhasil ditambahkan!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
      else
        $this->session->set_flashdata('error', '<div class="alert alert-danger alert-dismissible fade show mt-4 mb-4" role="alert" style="margin: 0;font-size: 1.2rem">Pemindahan barang gagal ditambahkan!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
      redirect('Persediaan/PindahBarang');
    } else {
      $data['list_gudang'] = $this->DaftarGudang_model->getTableGudang();
      $data['menu_sidebar'] = $this->AksesKontrol_model->getMenuEnabledForSidebar();
      $data['title'] = "Persediaan | Pindah Barang";
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar');
      $this->load->view('templates/topbar');
      if ($this->AksesKontrol_model->cekHakAksesFitur())
        $this->load->view('persediaan/pindah_barang/tambahPemindahanBarang');
      else
        $this->load->view('templates/error_hak_akses');
      $this->load->view('templates/footer');
    }
  }

  public function editPemindahanBarang($id_form = 0)
  {
    if ($id_form == 0)
      redirect('Persediaan/PindahBarang');

    if (!empty($_POST)) {
      var_dump($_POST);
      $status_insert = $this->PindahBarang_model->editPemindahanBarang($id_form);
      if ($status_insert)
        $this->session->set_flashdata('sukses', '<div class="alert alert-success alert-dismissible fade show mt-4 mb-4" role="alert" style="margin: 0;font-size: 1.2rem">Pemindahan barang berhasil diupdate!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
      else
        $this->session->set_flashdata('error', '<div class="alert alert-danger alert-dismissible fade show mt-4 mb-4" role="alert" style="margin: 0;font-size: 1.2rem">Pemindahan barang gagal diupdate!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
      redirect('Persediaan/PindahBarang');
    } else {
      $data['id_form'] = $id_form;
      $data['list_id_stok'] = $this->PindahBarang_model->getListIdStokFromPemindahanBarang($id_form);
      $data['data_form'] = $this->PindahBarang_model->getDataFormPemindahanBarang($id_form);
      $data['list_barang_dipindah'] = $this->PindahBarang_model->getListDataBarangPemindahanBarang($data['data_form']['dari_id'], $data['data_form']['ke_id']);
      $data['data_barang'] = $this->PindahBarang_model->getBarangFromGudangId($data['data_form']['dari_id']);
      $data['barang_added'] = $this->PindahBarang_model->getBarangAddedFromGudangId($id_form);
      $data['list_gudang'] = $this->DaftarGudang_model->getTableGudang();
      $data['menu_sidebar'] = $this->AksesKontrol_model->getMenuEnabledForSidebar();
      $data['title'] = "Persediaan | Pindah Barang";
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar');
      $this->load->view('templates/topbar');
      if ($this->AksesKontrol_model->cekHakAksesFitur())
        $this->load->view('persediaan/pindah_barang/editPemindahanBarang');
      else
        $this->load->view('templates/error_hak_akses');
      $this->load->view('templates/footer');
    }
  }

  public function hapusPemindahanBarang($id_form = 0)
  {
    if ($this->AksesKontrol_model->cekHakAksesFitur()) {
      if ($id_form == 0)
        redirect('Persediaan/PindahBarang');
      else {
        $keterangan = $this->PindahBarang_model->getKetFormPemindahanBarang($id_form);
        $status = $this->PindahBarang_model->hapusPemindahanBarang($id_form);
        // var_dump($status);
        if ($status)
          $this->session->set_flashdata('sukses', '<div class="alert alert-success alert-dismissible fade show mt-4 mb-4" role="alert" style="margin: 0;font-size: 1.2rem">Pemindahan barang "' . $keterangan . '" berhasil di hapus!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        else
          $this->session->set_flashdata('error', '<div class="alert alert-danger alert-dismissible fade show mt-4 mb-4" role="alert" style="margin: 0;font-size: 1.2rem">Pemindahan barang "' . $keterangan . '" gagal di hapus!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        redirect('Persediaan/PindahBarang');
      }
    } else {
      $data['title'] = "Persediaan | Pindah Barang | Hapus Pemindahan Barang";
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar');
      $this->load->view('templates/topbar');
      $this->load->view('templates/error_hak_akses');
      $this->load->view('templates/footer');
    }
  }
}
