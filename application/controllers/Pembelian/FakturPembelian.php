<?php
defined('BASEPATH') or exit('No direct script access allowed');

class FakturPembelian extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->load->model('AksesKontrol_model');
    $this->AksesKontrol_model->cekAutentikasi();
    $this->load->model('Pembelian/FakturPembelian_model');
    $this->load->model('Pembelian/PesananPembelian_model');
    $this->load->model('Daftar/Pemasok_model');
    $this->load->model('Persediaan/DaftarGudang_model');
  }

  private function _getKodeInvoiceAndKodePesanan($list_faktur)
  {
    $i = 0;
    foreach ($list_faktur as $x) {
      $list_faktur[$i]['no_pesanan'] =  $this->PesananPembelian_model->getKodeBeliNow($x['id_pesanan']);
      $list_faktur[$i]['no_faktur'] =  $this->FakturPembelian_model->getKodeInvoiceNow($x['id_faktur']);
      $i++;
    }
    return $list_faktur;
  }

  public function index()
  {
    $list_faktur = $this->FakturPembelian_model->getTableFakturPembelian();
    $data['list_faktur'] = $this->_getKodeInvoiceAndKodePesanan($list_faktur);
    $data['menu_sidebar'] = $this->AksesKontrol_model->getMenuEnabledForSidebar();
    $data['title'] = "Pembelian | Faktur Pembelian";
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar');
    $this->load->view('templates/topbar');
    if ($this->AksesKontrol_model->cekHakAksesFitur())
      $this->load->view('pembelian/faktur_pembelian/index');
    else
      $this->load->view('templates/error_hak_akses');
    $this->load->view('templates/footer');
  }

  public function getViewPenerimaanBarang($id_form_pembelian)
  {
    $data_form = $this->PenerimaanBarang_model->getDataFormPesananPembelian($id_form_pembelian);
    $list_barang_pesanan = $this->PenerimaanBarang_model->getListBarangPesanan($id_form_pembelian);
    $list_gudang = $this->DaftarGudang_model->getTableGudang();
    $html = $this->load->view('pembelian/penerimaan_barang/viewFormPenerimaanBarang', array('data_form' => $data_form, 'list_barang_pesanan' => $list_barang_pesanan, 'list_gudang' => $list_gudang), true);
    $data = array(
      'html' => $html
    );
    echo json_encode($data);
  }

  public function getViewFormFakturPembelian($id_pesanan)
  {
    $data_form = $this->PesananPembelian_model->getDataFormPesananPembelian($id_pesanan);
    $data_supplier = $this->Pemasok_model->getPemasokById($data_form['supplier_id']);
    $data_form['nama_supplier'] = $data_supplier['nama_pemasok'];
    $data_form['alamat_supplier'] = $data_supplier['alamat'];

    $data_dp = [];
    if ($data_form['is_uang_muka'] == 1) {
      $data_dp = $this->FakturPembelian_model->getDataDPFakturByIdPesanan($id_pesanan);
    }

    $list_barang_beli = $this->PesananPembelian_model->getListDataBarangPesananPembelian($id_pesanan);
    $data_gudang = $this->DaftarGudang_model->getTableGudang();

    $id_faktur = $this->FakturPembelian_model->getLastKodeFakturPembelian();

    $html = $this->load->view('pembelian/faktur_pembelian/viewFormFakturPembelian', array('data_form' => $data_form, 'list_barang_beli' => $list_barang_beli, 'gudang' => $data_gudang, 'id_faktur' => $id_faktur, 'data_dp_faktur' => $data_dp), true);
    $data = array(
      'html' => $html
    );
    echo json_encode($data);
  }

  public function tambahFakturPembelian()
  {
    if (!empty($_POST)) {
      var_dump($_POST);
      $status_insert = $this->FakturPembelian_model->simpanFakturPembelian();
      var_dump($status_insert);
      $kode_pesanan = $this->PesananPembelian_model->getKodeBeliNow($_POST['id_form_pesanan']);
      if ($status_insert)
        $this->session->set_flashdata('sukses', '<div class="alert alert-success alert-dismissible fade show mt-4 mb-4" role="alert" style="margin: 0;font-size: 1.2rem">Faktur pembelian berhasil ditambahkan dan pesanan ' . $kode_pesanan . ' sudah selesai !<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
      else
        $this->session->set_flashdata('error', '<div class="alert alert-danger alert-dismissible fade show mt-4 mb-4" role="alert" style="margin: 0;font-size: 1.2rem">Faktur pembelian gagal ditambahkan dan pesanan ' . $kode_pesanan . ' belum selesai !<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
      redirect('Pembelian/FakturPembelian');
    } else {
      $data['list_pesanan'] = $this->FakturPembelian_model->getTablePesanan();
      $data['menu_sidebar'] = $this->AksesKontrol_model->getMenuEnabledForSidebar();
      $data['title'] = "Pembelian | Pesanan Pembelian";
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar');
      $this->load->view('templates/topbar');
      if ($this->AksesKontrol_model->cekHakAksesFitur())
        $this->load->view('pembelian/faktur_pembelian/tambahFakturPembelian');
      else
        $this->load->view('templates/error_hak_akses');
      $this->load->view('templates/footer');
    }
  }

  private function _getDataFormFakturPembelian($id_faktur)
  {
    $data_form = $this->FakturPembelian_model->getDataFormFakturPembelian($id_faktur);
    $data_form['no_invoice'] = $this->FakturPembelian_model->getKodeInvoiceNow($id_faktur);
    $data_form['no_pesanan'] = $this->PesananPembelian_model->getKodeBeliNow($data_form['id_pesanan']);

    return $data_form;
  }

  public function editFakturPembelian($id_faktur)
  {
    if ($id_faktur == 0)
      redirect('Pembelian/FakturPembelian');

    if (!empty($_POST)) {
      var_dump($_POST);
      $status_insert = $this->FakturPembelian_model->editFakturPembelian();
      var_dump($status_insert);
      $kode_inv = $this->FakturPembelian_model->getKodeInvoiceNow($_POST['id_faktur_pembelian']);
      if ($status_insert)
        $this->session->set_flashdata('sukses', '<div class="alert alert-success alert-dismissible fade show mt-4 mb-4" role="alert" style="margin: 0;font-size: 1.2rem">Faktur pembelian ' . $kode_inv . ' behasil diupdate !<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
      else
        $this->session->set_flashdata('error', '<div class="alert alert-danger alert-dismissible fade show mt-4 mb-4" role="alert" style="margin: 0;font-size: 1.2rem">Faktur pembelian ' . $kode_inv . ' gagal diupdate !<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
      redirect('Pembelian/FakturPembelian');
    } else {
      $data['data_form'] = $this->_getDataFormFakturPembelian($id_faktur);

      if ($data['data_form']['is_row_dp'] == 0 && $data['data_form']['is_uang_muka'] == 1) {
        $data['list_barang_faktur'] = $this->FakturPembelian_model->getListDataBarangFakturPembelian($data['data_form']['id_pesanan'], $data['data_form']['id_faktur']);
        $data['data_dp_faktur'] = $this->FakturPembelian_model->getDataDPFakturByIdPesanan($data['data_form']['id_pesanan']);
      } else if ($data['data_form']['is_row_dp'] == 0 && $data['data_form']['is_uang_muka'] == 0)
        $data['list_barang_faktur'] = $this->FakturPembelian_model->getListDataBarangFakturPembelian($data['data_form']['id_pesanan'], $data['data_form']['id_faktur']);
      else if ($data['data_form']['is_row_dp'] == 1)
        $data['data_dp_faktur'] = $this->FakturPembelian_model->getDataDPFaktur($id_faktur);

      $data['gudang'] = $this->DaftarGudang_model->getTableGudang();
      $data['menu_sidebar'] = $this->AksesKontrol_model->getMenuEnabledForSidebar();
      $data['title'] = "Pembelian | Pesanan Pembelian";
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar');
      $this->load->view('templates/topbar');
      if ($this->AksesKontrol_model->cekHakAksesFitur())
        $this->load->view('pembelian/faktur_pembelian/editFakturPembelian');
      else
        $this->load->view('templates/error_hak_akses');
      $this->load->view('templates/footer');
    }
  }

  public function hapusFakturPembelian($id_faktur = 0)
  {
    if ($this->AksesKontrol_model->cekHakAksesFitur()) {
      if ($id_faktur == 0)
        redirect('Pembelian/FakturPembelian');
      else {
        $kode_inv = $this->FakturPembelian_model->getKodeInvoiceNow($id_faktur);
        $status = $this->FakturPembelian_model->hapusFakturPembelian($id_faktur);
        var_dump($status);
        if ($status)
          $this->session->set_flashdata('sukses', '<div class="alert alert-success alert-dismissible fade show mt-4 mb-4" role="alert" style="margin: 0;font-size: 1.2rem">Faktur pembelian ' . $kode_inv . ' behasil dihapus !<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        else
          $this->session->set_flashdata('error', '<div class="alert alert-danger alert-dismissible fade show mt-4 mb-4" role="alert" style="margin: 0;font-size: 1.2rem">Faktur pembelian ' . $kode_inv . ' gagal dihapus !<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        redirect('Pembelian/FakturPembelian');
      }
    } else {
      $data['title'] = "Persediaan | Faktur Pembelian | Hapus Faktur Pembelian";
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar');
      $this->load->view('templates/topbar');
      $this->load->view('templates/error_hak_akses');
      $this->load->view('templates/footer');
    }
  }
}
