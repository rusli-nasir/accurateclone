<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PesananPenjualan extends CI_Controller
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
    $data['title'] = "Penjualan | Pesanan Penjualan";
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar');
    $this->load->view('templates/topbar');
    if ($this->AksesKontrol_model->cekHakAksesFitur())
      $this->load->view('penjualan/pesanan_penjualan/index');
    else
      $this->load->view('templates/error_hak_akses');
    $this->load->view('templates/footer');
  }

  public function tambahPesananPenjualan()
  {
    if (!empty($_POST)) {
      var_dump($_POST);
      // $status_insert = $this->PesananPembelian_model->simpanPesananPembelian();
      // var_dump($status_insert);
      // if ($status_insert)
      //   $this->session->set_flashdata('sukses', '<div class="alert alert-success alert-dismissible fade show mt-4 mb-4" role="alert" style="margin: 0;font-size: 1.2rem">Pesanan pembelian berhasil ditambahkan!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
      // else
      //   $this->session->set_flashdata('error', '<div class="alert alert-danger alert-dismissible fade show mt-4 mb-4" role="alert" style="margin: 0;font-size: 1.2rem">Pesanan pembelian gagal ditambahkan!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
      // redirect('Pembelian/PesananPembelian');
    } else {
      // $data['kode_pesanan'] = $this->PesananPembelian_model->getLastKodePesananPembelian();
      // $data['list_barang'] = $this->PesananPembelian_model->getTableBarang();
      // $data['list_alamat'] = $this->PesananPembelian_model->getDaftarAlamat();
      // $data['supplier'] = $this->Pemasok_model->getTablePemasok();
      $data['menu_sidebar'] = $this->AksesKontrol_model->getMenuEnabledForSidebar();
      $data['title'] = "Pembelian | Pesanan Pembelian";
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar');
      $this->load->view('templates/topbar');
      if ($this->AksesKontrol_model->cekHakAksesFitur())
        $this->load->view('penjualan/pesanan_penjualan/tambahPesananPenjualan');
      else
        $this->load->view('templates/error_hak_akses');
      $this->load->view('templates/footer');
    }
  }
}
