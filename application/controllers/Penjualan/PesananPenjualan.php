<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PesananPenjualan extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->load->model('AksesKontrol_model');
    $this->AksesKontrol_model->cekAutentikasi();
    $this->load->model('Daftar/JasaPengiriman_model');
    $this->load->model('Daftar/Pelanggan_model');
    $this->load->model('Persediaan/DaftarGudang_model');
    $this->load->model('Persediaan/BarangJasa_model');
    $this->load->model('Penjualan/PesananPenjualan_model');
  }

  public function index()
  {
    $data['list_pesanan'] = $this->PesananPenjualan_model->getTablePesananPenjualan();
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

  public function getViewTablePilihBarang()
  {
    $list_gudang = $this->BarangJasa_model->getTableGudang();
    $list_barang = $this->BarangJasa_model->getTableAll();
    $html = $this->load->view('penjualan/pesanan_penjualan/tablePilihBarang', array('model' => $list_barang, 'list_gudang' => $list_gudang), true);
    $data = array(
      'html' => $html
    );
    echo json_encode($data);
  }

  public function getStokAktualBarangByGudangId($id_gudang, $id_barang)
  {
    $stok = 0;

    if ($id_gudang == 'kosong')
      $stok = $this->PesananPenjualan_model->getStokBarangTotalByIdBarang($id_barang);
    else
      $stok = $this->PesananPenjualan_model->getStokBarangByGudangId($id_gudang, $id_barang);

    $data = array(
      'stok' => $stok
    );
    echo json_encode($data);
  }

  public function addRowPesananPenjualan($id_barang)
  {
    $data_barang = $this->PesananPenjualan_model->getRowDataBarangPenjualan($id_barang);
    // echo json_encode($data_barang);
    $html = $this->load->view('penjualan/pesanan_penjualan/addRowPesananPenjualan', array('model' => $data_barang), true);
    $data = array(
      'html' => $html
    );
    echo json_encode($data);
  }

  public function addRowPesananPenjualanForEdit($id_barang)
  {
    $data_barang = $this->PesananPenjualan_model->getRowDataBarangPenjualan($id_barang);
    // echo json_encode($data_barang);
    $html = $this->load->view('penjualan/pesanan_penjualan/addRowPesananPenjualanForEdit', array('model' => $data_barang), true);
    $data = array(
      'html' => $html
    );
    echo json_encode($data);
  }

  public function tambahPesananPenjualan()
  {
    if (!empty($_POST)) {
      var_dump($_POST);
      $status_insert = $this->PesananPenjualan_model->simpanPesananPenjualan();
      $kode_penjualan = $this->PesananPenjualan_model->getKodePenjualanNow($_POST['id_pesanan']);
      var_dump($status_insert);
      if ($status_insert)
        $this->session->set_flashdata('sukses', '<div class="alert alert-success alert-dismissible fade show mt-4 mb-4" role="alert" style="margin: 0;font-size: 1.2rem">Pesanan penjualan ' . $kode_penjualan . ' berhasil ditambahkan!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
      else
        $this->session->set_flashdata('error', '<div class="alert alert-danger alert-dismissible fade show mt-4 mb-4" role="alert" style="margin: 0;font-size: 1.2rem">Pesanan penjualan ' . $kode_penjualan . ' gagal ditambahkan!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
      redirect('Penjualan/PesananPenjualan');
    } else {
      $data['kode_pesanan'] = $this->PesananPenjualan_model->getLastKodePesananPenjualan();
      $data['pelanggan'] = $this->Pelanggan_model->getTablePelanggan();
      $data['ship_via'] = $this->JasaPengiriman_model->getTableJasaPengiriman();
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

  public function editPesananPenjualan($id_pesanan = 0)
  {
    if ($id_pesanan == 0)
      redirect('Penjualan/PesananPenjualan');

    if (!empty($_POST)) {
      var_dump($_POST);
      $status_insert = $this->PesananPenjualan_model->editPesananPenjualan($id_pesanan);
      $kode_penjualan = $this->PesananPenjualan_model->getKodePenjualanNow($id_pesanan);
      var_dump($status_insert);
      if ($status_insert)
        $this->session->set_flashdata('sukses', '<div class="alert alert-success alert-dismissible fade show mt-4 mb-4" role="alert" style="margin: 0;font-size: 1.2rem">Pesanan penjualan ' . $kode_penjualan . ' berhasil diupdate!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
      else
        $this->session->set_flashdata('error', '<div class="alert alert-danger alert-dismissible fade show mt-4 mb-4" role="alert" style="margin: 0;font-size: 1.2rem">Pesanan penjualan ' . $kode_penjualan . ' gagal diupdate!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
      redirect('Penjualan/PesananPenjualan');
    } else {
      $data['id_form'] = $id_pesanan;
      $data['data_form'] = $this->PesananPenjualan_model->getDataFormPesananPenjualan($id_pesanan);
      $data['list_barang_jual'] = $this->PesananPenjualan_model->getListRowDataBarangPenjualan($id_pesanan);

      $data['pelanggan'] = $this->Pelanggan_model->getTablePelanggan();
      $data['ship_via'] = $this->JasaPengiriman_model->getTableJasaPengiriman();

      $data['menu_sidebar'] = $this->AksesKontrol_model->getMenuEnabledForSidebar();
      $data['title'] = "Pembelian | Pesanan Pembelian";
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar');
      $this->load->view('templates/topbar');
      if ($this->AksesKontrol_model->cekHakAksesFitur())
        $this->load->view('penjualan/pesanan_penjualan/editPesananPenjualan');
      else
        $this->load->view('templates/error_hak_akses');
      $this->load->view('templates/footer');
    }
  }

  public function hapusPesananPenjualan($id_form = 0)
  {
    if ($this->AksesKontrol_model->cekHakAksesFitur()) {
      if ($id_form == 0)
        redirect('Penjualan/PesananPenjualan');
      else {
        $kode_pesanan = $this->PesananPenjualan_model->getKodePenjualanNow($id_form);
        $is_done = $this->PesananPenjualan_model->checkIsPesananPenjualanDone($id_form);
        if (!$is_done) {
          $status = $this->PesananPenjualan_model->hapusPesananPembelian($id_form);
          var_dump($status);
          if ($status)
            $this->session->set_flashdata('sukses', '<div class="alert alert-success alert-dismissible fade show mt-4 mb-4" role="alert" style="margin: 0;font-size: 1.2rem">Pesanan penjualan "' . $kode_pesanan . '" berhasil dihapus!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
          else
            $this->session->set_flashdata('error', '<div class="alert alert-danger alert-dismissible fade show mt-4 mb-4" role="alert" style="margin: 0;font-size: 1.2rem">Pesanan penjualan "' . $kode_pesanan . '" gagal dihapus!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        } else {
          $this->session->set_flashdata('error', '<div class="alert alert-danger alert-dismissible fade show mt-4 mb-4" role="alert" style="margin: 0;font-size: 1.2rem">Pesanan penjualan "' . $kode_pesanan . '" tidak bisa dihapus karena pesanan sudah selesai!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        }
        redirect('Penjualan/PesananPenjualan');
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
