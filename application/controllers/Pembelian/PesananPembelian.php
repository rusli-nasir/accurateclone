<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PesananPembelian extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->load->model('AksesKontrol_model');
    $this->AksesKontrol_model->cekAutentikasi();
    $this->load->model('Daftar/Pemasok_model');
    $this->load->model('Pembelian/PesananPembelian_model');
  }

  public function index()
  {
    $data['list_pesanan'] = $this->PesananPembelian_model->getTablePesananPembelian();
    $data['menu_sidebar'] = $this->AksesKontrol_model->getMenuEnabledForSidebar();
    $data['title'] = "Pembelian | Pesanan Pembelian";
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar');
    $this->load->view('templates/topbar');
    if ($this->AksesKontrol_model->cekHakAksesFitur())
      $this->load->view('pembelian/pesanan_pembelian/index');
    else
      $this->load->view('templates/error_hak_akses');
    $this->load->view('templates/footer');
  }

  public function addRowPesananPembelian($id_barang)
  {
    $data_barang = $this->PesananPembelian_model->getBarangPemeblianAdded($id_barang);
    $html = $this->load->view('pembelian/pesanan_pembelian/addRowPesananPembelian', array('model' => $data_barang), true);
    $data = array(
      'html' => $html
    );
    echo json_encode($data);
  }

  public function tambahPembelian()
  {
    if (!empty($_POST)) {
      var_dump($_POST);
      $status_insert = $this->PesananPembelian_model->simpanPesananPembelian();
      var_dump($status_insert);
      if ($status_insert)
        $this->session->set_flashdata('sukses', '<div class="alert alert-success alert-dismissible fade show mt-4 mb-4" role="alert" style="margin: 0;font-size: 1.2rem">Pesanan pembelian berhasil ditambahkan!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
      else
        $this->session->set_flashdata('error', '<div class="alert alert-danger alert-dismissible fade show mt-4 mb-4" role="alert" style="margin: 0;font-size: 1.2rem">Pesanan pembelian gagal ditambahkan!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
      redirect('Pembelian/PesananPembelian');
    } else {
      $data['kode_pesanan'] = $this->PesananPembelian_model->getLastKodePesananPembelian();
      $data['list_barang'] = $this->PesananPembelian_model->getTableBarang();
      $data['list_alamat'] = $this->PesananPembelian_model->getDaftarAlamat();
      $data['supplier'] = $this->Pemasok_model->getTablePemasok();
      $data['menu_sidebar'] = $this->AksesKontrol_model->getMenuEnabledForSidebar();
      $data['title'] = "Pembelian | Pesanan Pembelian";
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar');
      $this->load->view('templates/topbar');
      if ($this->AksesKontrol_model->cekHakAksesFitur())
        $this->load->view('pembelian/pesanan_pembelian/tambahPembelian');
      else
        $this->load->view('templates/error_hak_akses');
      $this->load->view('templates/footer');
    }
  }

  public function editPembelian($id_form = 0)
  {
    if ($id_form == 0)
      redirect('Pembelian/PesananPembelian');

    if (!empty($_POST)) {
      // var_dump($_POST);
      $kode_beli = $this->PesananPembelian_model->getKodeBeliNow($id_form);
      $is_done = $this->PesananPembelian_model->checkIsPesananPembelianDone($id_form);

      if (!$is_done) {
        $status_insert = $this->PesananPembelian_model->editPesananPembelian($id_form);
        if ($status_insert)
          $this->session->set_flashdata('sukses', '<div class="alert alert-success alert-dismissible fade show mt-4 mb-4" role="alert" style="margin: 0;font-size: 1.2rem">Pesanan pembelian ' . $kode_beli . ' berhasil diupdate!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        else
          $this->session->set_flashdata('error', '<div class="alert alert-danger alert-dismissible fade show mt-4 mb-4" role="alert" style="margin: 0;font-size: 1.2rem">Pesanan pembelian ' . $kode_beli . ' gagal diupdate!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
      } else {
        $this->session->set_flashdata('error', '<div class="alert alert-danger alert-dismissible fade show mt-4 mb-4" role="alert" style="margin: 0;font-size: 1.2rem">Pesanan pembelian ' . $kode_beli . ' tidak bisa diupdate karena pesanan sudah selesai!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
      }
      redirect('Pembelian/PesananPembelian');
    } else {
      $data['id_form'] = $id_form;
      $data['list_barang_beli'] = $this->PesananPembelian_model->getListDataBarangPesananPembelian($id_form);
      $data['data_form'] = $this->PesananPembelian_model->getDataFormPesananPembelian($id_form);
      $data['kode_pesanan'] = $this->PesananPembelian_model->getLastKodePesananPembelian();
      $data['list_barang'] = $this->PesananPembelian_model->getTableBarang();
      $data['supplier'] = $this->Pemasok_model->getTablePemasok();
      $data['menu_sidebar'] = $this->AksesKontrol_model->getMenuEnabledForSidebar();
      $data['title'] = "Pembelian | Pesanan Pembelian";
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar');
      $this->load->view('templates/topbar');
      if ($this->AksesKontrol_model->cekHakAksesFitur())
        $this->load->view('pembelian/pesanan_pembelian/editPembelian');
      else
        $this->load->view('templates/error_hak_akses');
      $this->load->view('templates/footer');
    }
  }

  public function hapusPembelian($id_form = 0)
  {
    if ($this->AksesKontrol_model->cekHakAksesFitur()) {
      if ($id_form == 0)
        redirect('Pembelian/PesananPembelian');
      else {
        $kode_beli = $this->PesananPembelian_model->getKodeBeliNow($id_form);
        $is_done = $this->PesananPembelian_model->checkIsPesananPembelianDone($id_form);
        if (!$is_done) {
          $status = $this->PesananPembelian_model->hapusPesananPembelian($id_form);
          var_dump($status);
          if ($status)
            $this->session->set_flashdata('sukses', '<div class="alert alert-success alert-dismissible fade show mt-4 mb-4" role="alert" style="margin: 0;font-size: 1.2rem">Pesanan pembelian "' . $kode_beli . '" berhasil dihapus!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
          else
            $this->session->set_flashdata('error', '<div class="alert alert-danger alert-dismissible fade show mt-4 mb-4" role="alert" style="margin: 0;font-size: 1.2rem">Pesanan pembelian "' . $kode_beli . '" gagal dihapus!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        } else {
          $this->session->set_flashdata('error', '<div class="alert alert-danger alert-dismissible fade show mt-4 mb-4" role="alert" style="margin: 0;font-size: 1.2rem">Pesanan pembelian "' . $kode_beli . '" tidak bisa dihapus karena pesanan sudah selesai!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        }
        redirect('Pembelian/PesananPembelian');
      }
    } else {
      $data['title'] = "Persediaan | Pesanan Pembelian | Hapus Pesanan Pembelian";
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar');
      $this->load->view('templates/topbar');
      $this->load->view('templates/error_hak_akses');
      $this->load->view('templates/footer');
    }
  }
}
