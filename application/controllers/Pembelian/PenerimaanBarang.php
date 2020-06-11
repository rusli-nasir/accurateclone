<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PenerimaanBarang extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->load->model('AksesKontrol_model');
    $this->AksesKontrol_model->cekAutentikasi();
    $this->load->model('Daftar/Pemasok_model');
    $this->load->model('Persediaan/DaftarGudang_model');
    $this->load->model('Pembelian/PesananPembelian_model');
    $this->load->model('Pembelian/PenerimaanBarang_model');
  }

  public function index()
  {
    $data['menu_sidebar'] = $this->AksesKontrol_model->getMenuEnabledForSidebar();
    $data['title'] = "Pembelian | Penerimaan Barang";
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar');
    $this->load->view('templates/topbar');
    if ($this->AksesKontrol_model->cekHakAksesFitur())
      $this->load->view('pembelian/penerimaan_barang/index');
    else
      $this->load->view('templates/error_hak_akses');
    $this->load->view('templates/footer');
  }

  public function getTableListPesanan($supplier_id)
  {
    $list_barang = $this->PenerimaanBarang_model->getTablePesanan($supplier_id);
    $html = $this->load->view('pembelian/penerimaan_barang/tablePilihPesanan', array('model' => $list_barang), true);
    $data = array(
      'html' => $html
    );
    echo json_encode($data);
  }

  public function getListRowBarangPesanan()
  {
    $html = '';
    if (!empty($_POST['add_pesanan'])) {
      $list_form = $_POST['add_pesanan'];
      $list_gudang = $this->DaftarGudang_model->getTableGudang();
      foreach ($list_form as $key => $val) {
        $barang_pesanan = $this->PenerimaanBarang_model->getListBarangPesanan($val);
        $kode_pesanan['kode'] = $this->PesananPembelian_model->getKodeBeliNow($val);
        $kode_pesanan['id'] = $val;
        $view = $this->load->view('pembelian/penerimaan_barang/listRowBarangPesanan', array('model' => $barang_pesanan, 'list_gudang' => $list_gudang, 'kode_pesanan' => $kode_pesanan), true);
        $html = $html . $view;
      }
    }
    $data = array(
      'html' => $html
    );
    echo json_encode($data);
  }

  public function tambahPenerimaanBarang()
  {
    if (!empty($_POST)) {
      var_dump($_POST);
      // $status_insert = $this->PenerimaanBarang_model->simpanPenerimaanBarang();
      // if ($status_insert)
      //   $this->session->set_flashdata('sukses', '<div class="alert alert-success alert-dismissible fade show mt-4 mb-4" role="alert" style="margin: 0;font-size: 1.2rem">Form penerimaan barang berhasil ditambahkan!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
      // else
      //   $this->session->set_flashdata('error', '<div class="alert alert-danger alert-dismissible fade show mt-4 mb-4" role="alert" style="margin: 0;font-size: 1.2rem">Form penerimaan barang gagal ditambahkan!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
      // redirect('Pembelian/PenerimaanBarang');
    } else {
      $data['list_pesanan'] = $this->PenerimaanBarang_model->getTablePesanan(3);
      $data['kode_penerimaan'] = $this->PenerimaanBarang_model->getLastKodePenerimaanBarang();
      // $data['list_barang'] = $this->PesananPembelian_model->getTableBarang();
      // $data['list_alamat'] = $this->PesananPembelian_model->getDaftarAlamat();
      $data['supplier'] = $this->Pemasok_model->getTablePemasok();
      $data['menu_sidebar'] = $this->AksesKontrol_model->getMenuEnabledForSidebar();
      $data['title'] = "Pembelian | Pesanan Pembelian";
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar');
      $this->load->view('templates/topbar');
      if ($this->AksesKontrol_model->cekHakAksesFitur())
        $this->load->view('pembelian/penerimaan_barang/tambahPenerimaanBarang');
      else
        $this->load->view('templates/error_hak_akses');
      $this->load->view('templates/footer');
    }
  }
}
