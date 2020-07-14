<?php
defined('BASEPATH') or exit('No direct script access allowed');

class FakturPenjualan extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->load->model('AksesKontrol_model');
    $this->AksesKontrol_model->cekAutentikasi();
    $this->load->model('Persediaan/DaftarGudang_model');
    $this->load->model('Penjualan/PengirimanPesanan_model');
    $this->load->model('Penjualan/PesananPenjualan_model');
    $this->load->model('Penjualan/FakturPenjualan_model');
  }

  private function _getTableFaktur()
  {
    $table = $this->FakturPenjualan_model->getTableFakturPenjualan();
    foreach ($table as $key => $data) {
      $table[$key]['no_faktur'] = $this->FakturPenjualan_model->getKodeFakturNow($data['id_faktur']);
      if ($data['id_pengiriman'])
        $table[$key]['no_pengiriman'] = $this->PengirimanPesanan_model->getKodeDeliveryNow($data['id_pengiriman']);
      else
        $table[$key]['no_pengiriman'] = '-';
    }
    return $table;
  }

  public function index()
  {
    $data['list_faktur'] = $this->_getTableFaktur();
    $data['menu_sidebar'] = $this->AksesKontrol_model->getMenuEnabledForSidebar();
    $data['title'] = "Penjualan | Faktur Penjualan";
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar');
    $this->load->view('templates/topbar');
    if ($this->AksesKontrol_model->cekHakAksesFitur())
      $this->load->view('penjualan/faktur_penjualan/index');
    else
      $this->load->view('templates/error_hak_akses');
    $this->load->view('templates/footer');
  }

  private function _getListPengirimanNotDone()
  {
    $list_pengiriman = $this->FakturPenjualan_model->getListPengirimanNotDone();
    foreach ($list_pengiriman as $key => $val) {
      $list_pengiriman[$key]['no'] = $this->PengirimanPesanan_model->getKodeDeliveryNow($val['id_pengiriman']);
    }
    return $list_pengiriman;
  }

  private function _getDataFormPengirimanPesanan($id_delivery)
  {
    $data_form = $this->FakturPenjualan_model->getDataFormFakturPenjualan($id_delivery);
    $data_form['no_delivery'] = $this->PengirimanPesanan_model->getKodeDeliveryNow($data_form['id_delivery']);
    $data_form['no_pesanan'] = $this->PesananPenjualan_model->getKodePenjualanNow($data_form['id_pesanan']);
    return $data_form;
  }

  public function getViewFormFakturPenjualan($id_delivery)
  {
    $list_gudang = $this->DaftarGudang_model->getTableGudang();
    $list_barang_pengiriman = $this->FakturPenjualan_model->getListRowBarangPengirimanPesanan($id_delivery);
    $data_form = $this->_getDataFormPengirimanPesanan($id_delivery);
    $data_form['id_faktur'] = $this->FakturPenjualan_model->getNewIdFaktur();
    $data_form['no_faktur'] = $this->FakturPenjualan_model->getKodeFakturNow($data_form['id_faktur']);

    $html = $this->load->view('penjualan/faktur_penjualan/viewFormFakturPenjualan', array('data_form' => $data_form, 'list_barang_pengiriman' => $list_barang_pengiriman, 'list_gudang' => $list_gudang), true);
    $data = array(
      'html' => $html
    );
    echo json_encode($data);
  }

  public function tambahFakturPenjualan()
  {
    if (!empty($_POST)) {
      // var_dump($_POST);
      $status_insert = $this->FakturPenjualan_model->simpanFakturPenjualan();
      $kode_faktur = $this->FakturPenjualan_model->getKodeFakturNow($_POST['id_faktur']);
      // var_dump($status_insert);
      if ($status_insert)
        $this->session->set_flashdata('sukses', '<div class="alert alert-success alert-dismissible fade show mt-4 mb-4" role="alert" style="margin: 0;font-size: 1.2rem">Faktur penjualan ' . $kode_faktur . ' berhasil ditambahkan!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
      else
        $this->session->set_flashdata('error', '<div class="alert alert-danger alert-dismissible fade show mt-4 mb-4" role="alert" style="margin: 0;font-size: 1.2rem">Faktur penjualan ' . $kode_faktur . ' gagal ditambahkan!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
      redirect('Penjualan/FakturPenjualan');
    } else {
      $data['list_pengiriman'] = $this->_getListPengirimanNotDone();
      $data['menu_sidebar'] = $this->AksesKontrol_model->getMenuEnabledForSidebar();
      $data['title'] = "Penjualan | Faktur Penjualan";
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar');
      $this->load->view('templates/topbar');
      if ($this->AksesKontrol_model->cekHakAksesFitur())
        $this->load->view('penjualan/faktur_penjualan/tambahFakturPenjualan');
      else
        $this->load->view('templates/error_hak_akses');
      $this->load->view('templates/footer');
    }
  }

  private function _getDataFormFakturPenjualan($id_faktur)
  {
    $data_form = $this->FakturPenjualan_model->getDataFormFakturPenjualanForEdit($id_faktur);
    $data_form['no_pesanan'] = $this->PesananPenjualan_model->getKodePenjualanNow($data_form['id_pesanan']);
    $data_form['no_faktur'] = $this->FakturPenjualan_model->getKodeFakturNow($data_form['id_faktur']);

    if ($data_form['is_row_dp'] == 0) {
      $data_form['no_delivery'] = $this->PengirimanPesanan_model->getKodeDeliveryNow($data_form['id_delivery']);
    }
    return $data_form;
  }

  public function editFakturPenjualan($id_faktur = 0)
  {
    if ($id_faktur == 0)
      redirect('Penjualan/FakturPenjualan');

    if (!empty($_POST)) {
      // var_dump($_POST);
      $status_insert = $this->FakturPenjualan_model->editFakturPenjualan();
      $kode_faktur = $this->FakturPenjualan_model->getKodeFakturNow($_POST['id_faktur']);
      // // var_dump($status_insert);
      if ($status_insert)
        $this->session->set_flashdata('sukses', '<div class="alert alert-success alert-dismissible fade show mt-4 mb-4" role="alert" style="margin: 0;font-size: 1.2rem">Faktur penjualan ' . $kode_faktur . ' berhasil diupdate!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
      else
        $this->session->set_flashdata('error', '<div class="alert alert-danger alert-dismissible fade show mt-4 mb-4" role="alert" style="margin: 0;font-size: 1.2rem">Faktur penjualan ' . $kode_faktur . ' gagal diupdate!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
      redirect('Penjualan/FakturPenjualan');
    } else {
      $data['data_form'] = $this->_getDataFormFakturPenjualan($id_faktur);
      $data['list_gudang'] = $this->DaftarGudang_model->getTableGudang();
      if ($data['data_form']['is_row_dp'] == 0) {
        if ($data['data_form']['is_uang_muka'] == 1)
          $data['data_dp_faktur'] = $this->FakturPenjualan_model->getDataDPFakturByIdPesanan($data['data_form']['id_pesanan']);
        $data['list_barang_pengiriman'] = $this->FakturPenjualan_model->getListRowBarangPengirimanPesanan($data['data_form']['id_delivery']);
      } else {
        $data['data_dp_faktur'] = $this->FakturPenjualan_model->getDataDPFaktur($id_faktur);
        $data['list_barang_pengiriman'] = false;
      }
      $data['menu_sidebar'] = $this->AksesKontrol_model->getMenuEnabledForSidebar();
      $data['title'] = "Penjualan | Faktur Penjualan";
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar');
      $this->load->view('templates/topbar');
      if ($this->AksesKontrol_model->cekHakAksesFitur())
        $this->load->view('penjualan/faktur_penjualan/editFakturPenjualan');
      else
        $this->load->view('templates/error_hak_akses');
      $this->load->view('templates/footer');
    }
  }

  public function hapusFakturPenjualan($id_faktur = 0)
  {
    if ($this->AksesKontrol_model->cekHakAksesFitur()) {
      if ($id_faktur == 0)
        redirect('Penjualan/FakturPenjualan');
      else {
        $kode_faktur = $this->FakturPenjualan_model->getKodeFakturNow($id_faktur);
        if (!$this->FakturPenjualan_model->isRowFakturDP($id_faktur)) {
          $status = $this->FakturPenjualan_model->hapusFakturPenjualan($id_faktur);
          // var_dump($status);
          if ($status)
            $this->session->set_flashdata('sukses', '<div class="alert alert-success alert-dismissible fade show mt-4 mb-4" role="alert" style="margin: 0;font-size: 1.2rem">Faktur penjualan "' . $kode_faktur . '" berhasil dihapus!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
          else
            $this->session->set_flashdata('error', '<div class="alert alert-danger alert-dismissible fade show mt-4 mb-4" role="alert" style="margin: 0;font-size: 1.2rem">Faktur penjualan "' . $kode_faktur . '" gagal dihapus!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        } else {
          $data_faktur = $this->FakturPenjualan_model->getDataFormFakturPenjualanForEdit($id_faktur);

          if (!$this->PesananPenjualan_model->isFakturEverCreated($data_faktur['id_pesanan'])) {
            $status = $this->FakturPenjualan_model->hapusFakturPenjualan($id_faktur);
            // var_dump($status);
            if ($status)
              $this->session->set_flashdata('sukses', '<div class="alert alert-success alert-dismissible fade show mt-4 mb-4" role="alert" style="margin: 0;font-size: 1.2rem">Faktur penjualan DP "' . $kode_faktur . '" berhasil dihapus!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            else
              $this->session->set_flashdata('error', '<div class="alert alert-danger alert-dismissible fade show mt-4 mb-4" role="alert" style="margin: 0;font-size: 1.2rem">Faktur penjualan DP "' . $kode_faktur . '" gagal dihapus!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
          } else {
            $this->session->set_flashdata('error', '<div class="alert alert-danger alert-dismissible fade show mt-4 mb-4" role="alert" style="margin: 0;font-size: 1.2rem">Faktur penjualan DP "' . $kode_faktur . '" gagal dihapus karena sudah terjadi transaksi pada pesanan ini!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
          }
        }
        redirect('Penjualan/FakturPenjualan');
      }
    } else {
      $data['title'] = "Penjualan | Faktur Penjualan | Hapus Faktur Penjualan";
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar');
      $this->load->view('templates/topbar');
      $this->load->view('templates/error_hak_akses');
      $this->load->view('templates/footer');
    }
  }
}
