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

  private function _getTablePenerimaanBarang()
  {
    $list_penerimaan = $this->PenerimaanBarang_model->getTablePenerimaanBarang();

    foreach ($list_penerimaan as $key => $val) {
      $id_pesanan = $val['pembelian_form_pesanan_pembelian_id'];
      $list_penerimaan[$key]['no_pesanan'] = $this->PesananPembelian_model->getKodeBeliNow($id_pesanan);
    }
    return $list_penerimaan;
  }

  public function index()
  {
    $data['list_penerimaan'] = $this->_getTablePenerimaanBarang();
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

  public function tambahPenerimaanBarang()
  {
    if (!empty($_POST)) {
      var_dump($_POST);
      $status_insert = $this->PenerimaanBarang_model->simpanPenerimaanBarang();
      var_dump($status_insert);
      if ($status_insert)
        $this->session->set_flashdata('sukses', '<div class="alert alert-success alert-dismissible fade show mt-4 mb-4" role="alert" style="margin: 0;font-size: 1.2rem">Form penerimaan barang berhasil ditambahkan!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
      else
        $this->session->set_flashdata('error', '<div class="alert alert-danger alert-dismissible fade show mt-4 mb-4" role="alert" style="margin: 0;font-size: 1.2rem">Form penerimaan barang gagal ditambahkan!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
      redirect('Pembelian/PenerimaanBarang');
    } else {
      $data['list_pesanan'] = $this->PenerimaanBarang_model->getTablePesanan();
      $data['supplier'] = $this->Pemasok_model->getTablePemasok();
      $data['menu_sidebar'] = $this->AksesKontrol_model->getMenuEnabledForSidebar();
      $data['title'] = "Pembelian | Penerimaan Barang";
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

  public function editPenerimaanBarang($id_form_penerimaan = 0)
  {
    if ($id_form_penerimaan == 0)
      redirect('Pembelian/PenerimaanBarang');

    if (!empty($_POST)) {
      var_dump($_POST);
      $is_done = $this->PesananPembelian_model->checkIsPesananPembelianDone($_POST['id_pesanan_diterima']);
      var_dump($is_done);
      $kode_pesanan = $_POST['kode_pesanan_diterima'];

      if (!$is_done) {
        $status = $this->PenerimaanBarang_model->editPenerimaanBarang($id_form_penerimaan);
        if ($status)
          $this->session->set_flashdata('sukses', '<div class="alert alert-success alert-dismissible fade show mt-4 mb-4" role="alert" style="margin: 0;font-size: 1.2rem">Form penerimaan barang untuk pesanan ' . $kode_pesanan . ' berhasil diupdate!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        else
          $this->session->set_flashdata('error', '<div class="alert alert-danger alert-dismissible fade show mt-4 mb-4" role="alert" style="margin: 0;font-size: 1.2rem">Form penerimaan barang untuk pesanan ' . $kode_pesanan . ' gagal diupdate!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
      } else {
        $this->session->set_flashdata('error', '<div class="alert alert-danger alert-dismissible fade show mt-4 mb-4" role="alert" style="margin: 0;font-size: 1.2rem">Form penerimaan barang gagal diupdate karena pesanan ' . $kode_pesanan . ' sudah selesai!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
      }
      redirect('Pembelian/PenerimaanBarang');
    } else {
      $data['id_form_penerimaan'] = $id_form_penerimaan;
      $data['data_form'] = $this->PenerimaanBarang_model->getDataFormPenerimaanBarang($id_form_penerimaan);
      $data['kode_pesanan'] = $this->PesananPembelian_model->getKodeBeliNow($data['data_form']['id_pesanan']);
      $data['list_barang_pesanan'] = $this->PenerimaanBarang_model->getListBarangPesananForEdit($data['data_form']['id_pesanan']);
      $data['list_gudang'] = $this->DaftarGudang_model->getTableGudang();
      $data['menu_sidebar'] = $this->AksesKontrol_model->getMenuEnabledForSidebar();
      $data['title'] = "Pembelian | Penerimaan Barang";
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar');
      $this->load->view('templates/topbar');
      if ($this->AksesKontrol_model->cekHakAksesFitur())
        $this->load->view('pembelian/penerimaan_barang/editPenerimaanBarang');
      else
        $this->load->view('templates/error_hak_akses');
      $this->load->view('templates/footer');
    }
  }

  public function hapusPenerimaanBarang($id_form_penerimaan = 0)
  {
    if ($this->AksesKontrol_model->cekHakAksesFitur()) {
      if ($id_form_penerimaan == 0)
        redirect('Pembelian/PenerimaanBarang');
      else {
        $id_form_pesanan = $this->PenerimaanBarang_model->getIdFormPesananByIdFormPenerimaan($id_form_penerimaan);
        $kode_beli = $this->PesananPembelian_model->getKodeBeliNow($id_form_pesanan);
        $is_done = $this->PesananPembelian_model->checkIsPesananPembelianDone($id_form_pesanan);

        if (!$is_done) {
          $status = $this->PenerimaanBarang_model->hapusPenerimaanBarang($id_form_penerimaan);
          // var_dump($status);
          if ($status)
            $this->session->set_flashdata('sukses', '<div class="alert alert-success alert-dismissible fade show mt-4 mb-4" role="alert" style="margin: 0;font-size: 1.2rem">Penerimaan barang untuk pesanan "' . $kode_beli . '" berhasil di hapus!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
          else
            $this->session->set_flashdata('error', '<div class="alert alert-danger alert-dismissible fade show mt-4 mb-4" role="alert" style="margin: 0;font-size: 1.2rem">Penerimaan barang untuk pesanan "' . $kode_beli . '" gagal di hapus!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        } else {
          $this->session->set_flashdata('error', '<div class="alert alert-danger alert-dismissible fade show mt-4 mb-4" role="alert" style="margin: 0;font-size: 1.2rem">Penerimaan barang untuk pesanan "' . $kode_beli . '" gagal di hapus karena pesanan ini sudah selesai!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        }
        redirect('Pembelian/PenerimaanBarang');
      }
    } else {
      $data['title'] = "Persediaan | Penerimaan Barang | Hapus Penerimaan Barang";
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar');
      $this->load->view('templates/topbar');
      $this->load->view('templates/error_hak_akses');
      $this->load->view('templates/footer');
    }
  }
}
