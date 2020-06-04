<?php
defined('BASEPATH') or exit('No direct script access allowed');

class BarangJasa extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->load->model('AksesKontrol_model');
    $this->AksesKontrol_model->cekAutentikasi();
    $this->load->model('Persediaan/BarangJasa_model');
    $this->load->model('Persediaan/DaftarGudang_model');
  }

  public function index()
  {
    $data['barang_per_gudang'] = $this->BarangJasa_model->getBarangPerGudang();
    $data['list_gudang'] = $this->DaftarGudang_model->getTableGudang();
    $data['table_all'] = $this->BarangJasa_model->getTableAll();
    $data['table_kategori'] = $this->BarangJasa_model->getTableKategoriBarang();
    $data['menu_sidebar'] = $this->AksesKontrol_model->getMenuEnabledForSidebar();
    $data['title'] = "Persediaan | Barang dan Jasa";
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar');
    $this->load->view('templates/topbar');
    if ($this->AksesKontrol_model->cekHakAksesFitur())
      $this->load->view('persediaan/barang_jasa/index');
    else
      $this->load->view('templates/error_hak_akses');
    $this->load->view('templates/footer');
  }

  // ====================================================================================================
  //                    KATEGORI BARANG
  // ====================================================================================================

  public function tambahKategoriBarang()
  {
    if (!empty($_POST)) {
      $status_insert = $this->BarangJasa_model->tambahKategoriBarang();
      if ($status_insert)
        $this->session->set_flashdata('sukses', '<div class="alert alert-success alert-dismissible fade show mt-4 mb-4" role="alert" style="margin: 0;font-size: 1.2rem">Kategori barang dengan nama ' . $_POST['nama_kategori'] . ' berhasil ditambahkan!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
      else
        $this->session->set_flashdata('error', '<div class="alert alert-danger alert-dismissible fade show mt-4 mb-4" role="alert" style="margin: 0;font-size: 1.2rem">Kategori barang dengan nama ' . $_POST['nama_kategori'] . ' gagal ditambahkan!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
      echo json_encode(base_url('Persediaan/BarangJasa'));
    } else {
      $data['menu_sidebar'] = $this->AksesKontrol_model->getMenuEnabledForSidebar();
      $data['title'] = "Persediaan | Barang dan Jasa";
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar');
      $this->load->view('templates/topbar');
      if ($this->AksesKontrol_model->cekHakAksesFitur())
        $this->load->view('persediaan/barang_jasa/tambahKategoriBarang');
      else
        $this->load->view('templates/error_hak_akses');
      $this->load->view('templates/footer');
    }
  }

  public function editKategoriBarang($id = 0)
  {
    if ($id == 0)
      redirect('Persediaan/BarangJasa');

    if (!empty($_POST)) {
      $status_insert = $this->BarangJasa_model->editKategoriBarang($id);
      if ($status_insert)
        $this->session->set_flashdata('sukses', '<div class="alert alert-success alert-dismissible fade show mt-4 mb-4" role="alert" style="margin: 0;font-size: 1.2rem">Kategori barang berhasil diupdate dengan nama ' . $_POST['nama_kategori'] . ' !<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
      else
        $this->session->set_flashdata('error', '<div class="alert alert-danger alert-dismissible fade show mt-4 mb-4" role="alert" style="margin: 0;font-size: 1.2rem">Kategori barang gagal diupdate dengan nama ' . $_POST['nama_kategori'] . ' !<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
      echo json_encode(base_url('Persediaan/BarangJasa'));
    } else {
      $data['kategori_barang'] = $this->BarangJasa_model->getKategoriBarangById($id);
      $data['menu_sidebar'] = $this->AksesKontrol_model->getMenuEnabledForSidebar();
      $data['title'] = "Persediaan | Barang dan Jasa";
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar');
      $this->load->view('templates/topbar');
      if ($this->AksesKontrol_model->cekHakAksesFitur())
        $this->load->view('persediaan/barang_jasa/editKategoriBarang');
      else
        $this->load->view('templates/error_hak_akses');
      $this->load->view('templates/footer');
    }
  }

  public function hapusKategoriBarang($id = 0)
  {
    if ($this->AksesKontrol_model->cekHakAksesFitur()) {
      if ($id == 0)
        redirect('Persediaan/BarangJasa');
      else {

        $nama_kategori = $this->BarangJasa_model->getKategoriBarangById($id)['nama_kategori'];
        $status = $this->BarangJasa_model->hapusKategoriBarang($id);

        if ($status)
          $this->session->set_flashdata('sukses', '<div class="alert alert-success alert-dismissible fade show mt-4 mb-4" role="alert" style="margin: 0;font-size: 1.2rem">Kategori ' . $nama_kategori . ' berhasil di hapus!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        else
          $this->session->set_flashdata('error', '<div class="alert alert-danger alert-dismissible fade show mt-4 mb-4" role="alert" style="margin: 0;font-size: 1.2rem">Kategori ' . $nama_kategori . ' gagal di hapus!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        redirect('Persediaan/BarangJasa');
      }
    } else {
      $data['title'] = "Persediaan | Barang dan Jasa | Hapus Kategori Barang";
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar');
      $this->load->view('templates/topbar');
      $this->load->view('templates/error_hak_akses');
      $this->load->view('templates/footer');
    }
  }

  // ====================================================================================================
  //                    BARANG DAN JASA
  // ====================================================================================================

  public function tambahBarangJasa()
  {
    if (!empty($this->input->post())) {
      var_dump($this->input->post());
      $status_insert = $this->BarangJasa_model->tambahBarangJasa();
      if ($status_insert)
        $this->session->set_flashdata('sukses', '<div class="alert alert-success alert-dismissible fade show mt-4 mb-4" role="alert" style="margin: 0;font-size: 1.2rem">Barang / jasa dengan kode ' . $_POST['kode_barang'] . ' berhasil ditambahkan!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
      else
        $this->session->set_flashdata('error', '<div class="alert alert-danger alert-dismissible fade show mt-4 mb-4" role="alert" style="margin: 0;font-size: 1.2rem">Barang / jasa dengan kode ' . $_POST['kode_barang'] . ' gagal ditambahkan!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
      redirect('Persediaan/BarangJasa');
    } else {
      $data['date'] = date('Y-m-d');
      $data['list_gudang'] = $this->DaftarGudang_model->getTableGudang();
      $data['kategori_barang'] = $this->BarangJasa_model->getTableKategoriBarang();
      $data['menu_sidebar'] = $this->AksesKontrol_model->getMenuEnabledForSidebar();
      $data['title'] = "Persediaan | Barang dan Jasa";
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar');
      $this->load->view('templates/topbar');
      if ($this->AksesKontrol_model->cekHakAksesFitur())
        $this->load->view('persediaan/barang_jasa/tambahBarangJasa');
      else
        $this->load->view('templates/error_hak_akses');
      $this->load->view('templates/footer');
    }
  }

  public function editBarangJasa($id_barang)
  {
    if (!empty($this->input->post())) {
      var_dump($this->input->post());
      $status_edit = $this->BarangJasa_model->editBarangJasa($id_barang);
      if ($status_edit)
        $this->session->set_flashdata('sukses', '<div class="alert alert-success alert-dismissible fade show mt-4 mb-4" role="alert" style="margin: 0;font-size: 1.2rem">Barang / jasa dengan kode ' . $_POST['kode_barang'] . ' berhasil diupdate!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
      else
        $this->session->set_flashdata('error', '<div class="alert alert-danger alert-dismissible fade show mt-4 mb-4" role="alert" style="margin: 0;font-size: 1.2rem">Barang / jasa dengan kode ' . $_POST['kode_barang'] . ' gagal diupdate!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
      redirect('Persediaan/BarangJasa');
    } else {
      $data['date'] = date('Y-m-d');
      $data['data_barang'] = $this->BarangJasa_model->getBarangJasaById($id_barang);
      $data['list_gudang'] = $this->DaftarGudang_model->getTableGudang();
      $data['kategori_barang'] = $this->BarangJasa_model->getTableKategoriBarang();
      $data['menu_sidebar'] = $this->AksesKontrol_model->getMenuEnabledForSidebar();
      $data['title'] = "Persediaan | Barang dan Jasa";
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar');
      $this->load->view('templates/topbar');
      if ($this->AksesKontrol_model->cekHakAksesFitur())
        $this->load->view('persediaan/barang_jasa/editBarangJasa');
      else
        $this->load->view('templates/error_hak_akses');
      $this->load->view('templates/footer');
    }
  }

  public function hapusBarangJasa($id_barang = 0)
  {
    if ($this->AksesKontrol_model->cekHakAksesFitur()) {
      if ($id_barang == 0)
        redirect('Persediaan/BarangJasa');
      else {

        $kode_barang = $this->BarangJasa_model->getBarangJasaById($id_barang)['kode_barang'];
        $status = $this->BarangJasa_model->hapusBarangJasa($id_barang);

        if ($status)
          $this->session->set_flashdata('sukses', '<div class="alert alert-success alert-dismissible fade show mt-4 mb-4" role="alert" style="margin: 0;font-size: 1.2rem">Barang / jasa dengan kode ' . $kode_barang . ' berhasil dihapus!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        else
          $this->session->set_flashdata('error', '<div class="alert alert-danger alert-dismissible fade show mt-4 mb-4" role="alert" style="margin: 0;font-size: 1.2rem">Barang / jasa dengan kode ' . $kode_barang . ' gagal dihapus!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        redirect('Persediaan/BarangJasa');
      }
    } else {
      $data['title'] = "Persediaan | Barang dan Jasa | Hapus Kategori Barang";
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar');
      $this->load->view('templates/topbar');
      $this->load->view('templates/error_hak_akses');
      $this->load->view('templates/footer');
    }
  }
}
