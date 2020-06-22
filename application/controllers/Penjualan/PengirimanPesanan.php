<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PengirimanPesanan extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->load->model('AksesKontrol_model');
    $this->AksesKontrol_model->cekAutentikasi();
    $this->load->model('Persediaan/DaftarGudang_model');
    $this->load->model('Penjualan/PesananPenjualan_model');
    $this->load->model('Penjualan/PengirimanPesanan_model');
  }

  public function index()
  {
    $data['list_pengiriman'] = $this->PengirimanPesanan_model->getTablePengiriman();
    $data['menu_sidebar'] = $this->AksesKontrol_model->getMenuEnabledForSidebar();
    $data['title'] = "Penjualan | Pengiriman Pesanan";
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar');
    $this->load->view('templates/topbar');
    if ($this->AksesKontrol_model->cekHakAksesFitur())
      $this->load->view('penjualan/pengiriman_pesanan/index');
    else
      $this->load->view('templates/error_hak_akses');
    $this->load->view('templates/footer');
  }

  private function _getTablePesanan()
  {
    $list_pesanan = $this->PengirimanPesanan_model->getTablePesanan();

    foreach ($list_pesanan as $key => $val) {
      $list_pesanan[$key]['no'] = $this->PesananPenjualan_model->getKodePenjualanNow($val['id']);
    }

    return $list_pesanan;
  }

  private function _getDataFormPesananPenjualan($id_form)
  {
    $data_form = $this->PengirimanPesanan_model->getDataFormPesananPenjualan($id_form);
    $data_form['id_delivery'] = $this->PengirimanPesanan_model->getNewIdDelivery();
    $data_form['no_delivery'] = $this->PengirimanPesanan_model->getKodeDeliveryNow($data_form['id_delivery']);
    $data_form['no_pesanan'] = $this->PesananPenjualan_model->getKodePenjualanNow($data_form['id_pesanan']);
    return $data_form;
  }

  private function _getListRowBarangPesanan($id_form_pesanan)
  {
    $list_barang_pesanan = $this->PengirimanPesanan_model->getListRowBarangPesanan($id_form_pesanan);
    foreach ($list_barang_pesanan as $key => $barang) {
      $list_barang_pesanan[$key]['stok_terbaru'] = $this->PesananPenjualan_model->getStokBarangByGudangId($barang['default_gudang_id'], $barang['id_barang']);
    }
    return $list_barang_pesanan;
  }

  public function getViewFormPengirimanPesanan($id_form_pesanan)
  {
    $data_form = $this->_getDataFormPesananPenjualan($id_form_pesanan);
    $list_barang_pesanan = $this->_getListRowBarangPesanan($id_form_pesanan);
    $list_gudang = $this->DaftarGudang_model->getTableGudang();

    $html = $this->load->view('penjualan/pengiriman_pesanan/viewFormPengirimanPesanan', array('data_form' => $data_form, 'list_barang_pesanan' => $list_barang_pesanan, 'list_gudang' => $list_gudang), true);
    $data = array(
      'html' => $html
    );
    echo json_encode($data);
  }

  public function addRowBarangPengirimanPesanan($id_barang_pesanan)
  {
    $data_barang = $this->PengirimanPesanan_model->getDataRowBarangPesanan($id_barang_pesanan);
    $list_gudang = $this->DaftarGudang_model->getTableGudang();
    $data_barang['stok_terbaru'] = $this->PesananPenjualan_model->getStokBarangByGudangId($data_barang['default_gudang_id'], $data_barang['id_barang']);
    $html = $this->load->view('penjualan/pengiriman_pesanan/addRowBarangPengiriman', array('data' => $data_barang, 'list_gudang' => $list_gudang), true);

    $data = array(
      'html' => $html
    );
    echo json_encode($data);
  }

  public function getStokBarangTerbaruByGudangId($id_gudang, $id_barang)
  {
    $stok = $this->PesananPenjualan_model->getStokBarangByGudangId($id_gudang, $id_barang);
    $data = array(
      'stok' => $stok
    );
    echo json_encode($data);
  }

  public function tambahPengirimanPesanan()
  {
    if (!empty($_POST)) {
      var_dump($_POST);
      $status_insert = $this->PengirimanPesanan_model->simpanPengirimanPesanan();
      $kode_delivery = $this->PengirimanPesanan_model->getKodeDeliveryNow($_POST['id_delivery']);
      var_dump($status_insert);
      if ($status_insert)
        $this->session->set_flashdata('sukses', '<div class="alert alert-success alert-dismissible fade show mt-4 mb-4" role="alert" style="margin: 0;font-size: 1.2rem">Pengiriman pesanan ' . $kode_delivery . ' berhasil ditambahkan!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
      else
        $this->session->set_flashdata('error', '<div class="alert alert-danger alert-dismissible fade show mt-4 mb-4" role="alert" style="margin: 0;font-size: 1.2rem">Pengiriman pesanan ' . $kode_delivery . ' gagal ditambahkan!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
      redirect('Penjualan/PengirimanPesanan');
    } else {
      $data['list_pesanan'] = $this->_getTablePesanan();
      $data['menu_sidebar'] = $this->AksesKontrol_model->getMenuEnabledForSidebar();
      $data['title'] = "Penjualan | Pengiriman Pesanan";
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar');
      $this->load->view('templates/topbar');
      if ($this->AksesKontrol_model->cekHakAksesFitur())
        $this->load->view('penjualan/pengiriman_pesanan/tambahPengirimanPesanan');
      else
        $this->load->view('templates/error_hak_akses');
      $this->load->view('templates/footer');
    }
  }

  private function _getDataFormPengirimanPesanan($id_delivery)
  {
    $data_form = $this->PengirimanPesanan_model->getDataFormPengirimanPesanan($id_delivery);
    $data_form['no_delivery'] = $this->PengirimanPesanan_model->getKodeDeliveryNow($data_form['id_delivery']);
    $data_form['no_pesanan'] = $this->PesananPenjualan_model->getKodePenjualanNow($data_form['id_pesanan']);
    return $data_form;
  }

  public function addRowBarangPengirimanPesananForEdit($id_barang_pesanan)
  {
    $data_barang = $this->PengirimanPesanan_model->getDataRowBarangPesanan($id_barang_pesanan);
    $list_gudang = $this->DaftarGudang_model->getTableGudang();
    $html = $this->load->view('penjualan/pengiriman_pesanan/addRowBarangPengirimanForEdit', array('data' => $data_barang, 'list_gudang' => $list_gudang), true);

    $data = array(
      'html' => $html
    );
    echo json_encode($data);
  }

  public function editPengirimanPesanan($id_pengiriman = 0)
  {
    if ($id_pengiriman == 0)
      redirect('Penjualan/PengirimanPesanan');

    if (!empty($_POST)) {
      var_dump($_POST);
      $is_done = $this->PesananPenjualan_model->checkIsPesananPenjualanDone($_POST['id_pesanan']);
      var_dump($is_done);
      $kode_delivery = $this->PengirimanPesanan_model->getKodeDeliveryNow($_POST['id_delivery']);

      if (!$is_done) {
        $status = $this->PengirimanPesanan_model->editPengirimanPesanan($id_pengiriman);
        if ($status)
          $this->session->set_flashdata('sukses', '<div class="alert alert-success alert-dismissible fade show mt-4 mb-4" role="alert" style="margin: 0;font-size: 1.2rem">Form pengiriman barang ' . $kode_delivery . ' berhasil diupdate!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        else
          $this->session->set_flashdata('error', '<div class="alert alert-danger alert-dismissible fade show mt-4 mb-4" role="alert" style="margin: 0;font-size: 1.2rem">Form pengiriman barang ' . $kode_delivery . ' gagal diupdate!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
      } else {
        $this->session->set_flashdata('error', '<div class="alert alert-danger alert-dismissible fade show mt-4 mb-4" role="alert" style="margin: 0;font-size: 1.2rem">Form pengiriman barang ' . $kode_delivery . ' gagal diupdate karena pesanan penjualan sudah selesai!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
      }
      redirect('Penjualan/PengirimanPesanan');
    } else {
      $data['list_gudang'] = $this->DaftarGudang_model->getTableGudang();
      $data['data_form'] = $this->_getDataFormPengirimanPesanan($id_pengiriman);
      $data['list_barang_pesanan'] = $this->_getListRowBarangPesanan($data['data_form']['id_pesanan']);
      $data['list_barang_pengiriman'] = $this->PengirimanPesanan_model->getListRowBarangPengirimanPesanan($id_pengiriman);
      $data['id_pengiriman'] = $id_pengiriman;
      $data['menu_sidebar'] = $this->AksesKontrol_model->getMenuEnabledForSidebar();
      $data['title'] = "Penjualan | Pengiriman Pesanan";
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar');
      $this->load->view('templates/topbar');
      if ($this->AksesKontrol_model->cekHakAksesFitur())
        $this->load->view('penjualan/pengiriman_pesanan/editPengirimanPesanan');
      else
        $this->load->view('templates/error_hak_akses');
      $this->load->view('templates/footer');
    }
  }

  public function hapusPengirimanPesanan($id_delivery = 0, $id_pesanan = 0)
  {
    if ($this->AksesKontrol_model->cekHakAksesFitur()) {
      if ($id_delivery == 0)
        redirect('Penjualan/PengirimanPesanan');
      else {
        $kode_delivery = $this->PengirimanPesanan_model->getKodeDeliveryNow($id_delivery);
        $is_done = $this->PesananPenjualan_model->checkIsPesananPenjualanDone($id_pesanan);
        if (!$is_done) {
          $status = $this->PengirimanPesanan_model->hapusPengirimanPesanan($id_delivery);
          var_dump($status);
          if ($status)
            $this->session->set_flashdata('sukses', '<div class="alert alert-success alert-dismissible fade show mt-4 mb-4" role="alert" style="margin: 0;font-size: 1.2rem">Pengiriman pesanan "' . $kode_delivery . '" berhasil dihapus!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
          else
            $this->session->set_flashdata('error', '<div class="alert alert-danger alert-dismissible fade show mt-4 mb-4" role="alert" style="margin: 0;font-size: 1.2rem">Pengiriman pesanan "' . $kode_delivery . '" gagal dihapus!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        } else {
          $this->session->set_flashdata('error', '<div class="alert alert-danger alert-dismissible fade show mt-4 mb-4" role="alert" style="margin: 0;font-size: 1.2rem">Pengiriman pesanan "' . $kode_delivery . '" tidak bisa dihapus karena pesanan sudah selesai!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        }
        redirect('Penjualan/PengirimanPesanan');
      }
    } else {
      $data['title'] = "Penjualan | Pengiriman Pesanan | Pengiriman Pesanan";
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar');
      $this->load->view('templates/topbar');
      $this->load->view('templates/error_hak_akses');
      $this->load->view('templates/footer');
    }
  }
}
