<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengguna extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->load->model('AksesKontrol_model');
    // $this->AksesKontrol_model->cekAutentikasi();
    $this->load->model('Daftar/Pengguna_model');
  }

  public function index()
  {
    $data['menu_sidebar'] = $this->AksesKontrol_model->getMenuEnabledForSidebar();
    $data['pengguna'] = $this->Pengguna_model->getTablePengguna();
    $data['divisi'] = $this->Pengguna_model->getTableDivisi();
    $data['title'] = "Daftar | Pengguna";
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar');
    $this->load->view('templates/topbar');
    if ($this->AksesKontrol_model->cekHakAksesFitur())
      $this->load->view('daftar/pengguna/index', $data);
    else
      $this->load->view('templates/error_hak_akses');
    $this->load->view('templates/footer');
  }

  public function checkUsernameUnique()
  {
    $username = $_POST['input_username'];

    $data = $this->Pengguna_model->checkUsernameUnique($username);

    if (empty($data))
      echo json_encode(true);
    else
      echo json_encode(false);
  }

  public function checkUsernameUniqueWhenEdit()
  {
    $username_sesudah = $_POST['username_sesudah'];
    $username_sebelum = $_POST['username_sebelum'];

    if ($username_sebelum == $username_sesudah) {
      echo json_encode(true);
    } else {
      $data = $this->Pengguna_model->checkUsernameUnique($username_sesudah);

      if (empty($data))
        echo json_encode(true);
      else
        echo json_encode(false);
    }
  }

  public function tambahPengguna()
  {
    if (!empty($_POST)) {
      $status_insert = $this->Pengguna_model->simpanPengguna();
      if ($status_insert)
        $this->session->set_flashdata('suksesTambahPengguna', '<div class="alert alert-success alert-dismissible fade show mt-4 mb-4" role="alert" style="margin: 0;font-size: 1.2rem">Pengguna dengan nama ' . $_POST['input_nama'] . ' berhasil ditambahkan!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
      else
        $this->session->set_flashdata('errorTambahPengguna', '<div class="alert alert-danger alert-dismissible fade show mt-4 mb-4" role="alert" style="margin: 0;font-size: 1.2rem">Pengguna dengan nama ' . $_POST['input_nama'] . ' gagal ditambahkan!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
      echo json_encode(base_url('Daftar/Pengguna'));
    } else {

      $data['menu_sidebar'] = $this->AksesKontrol_model->getMenuEnabledForSidebar();
      $data['divisi'] = $this->Pengguna_model->getTableDivisi();

      $data['title'] = "Daftar | Pengguna";
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar');
      $this->load->view('templates/topbar');
      $this->load->view('daftar/pengguna/tambahPengguna');
      // if ($this->AksesKontrol_model->cekHakAksesFitur())
      //   $this->load->view('daftar/pengguna/tambahPengguna');
      // else
      //   $this->load->view('templates/error_hak_akses');
      $this->load->view('templates/footer');
    }
  }

  public function editPengguna($username = '')
  {
    if ($username == '')
      redirect('Daftar/Pengguna');

    if (!empty($_POST)) {
      $status = $this->Pengguna_model->editPengguna($username);
      if ($status)
        $this->session->set_flashdata('suksesUpdatePengguna', '<div class="alert alert-success alert-dismissible fade show mt-4 mb-4" role="alert" style="margin: 0;font-size: 1.2rem">Pengguna ' . $username . ' berhasil di update!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
      else
        $this->session->set_flashdata('suksesUpdatePengguna', '<div class="alert alert-danger alert-dismissible fade show mt-4 mb-4" role="alert" style="margin: 0;font-size: 1.2rem">Pengguna ' . $username . ' gagal di update!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
      echo json_encode(base_url('Daftar/Pengguna'));
    } else {

      $data['menu_sidebar'] = $this->AksesKontrol_model->getMenuEnabledForSidebar();
      $data['pengguna'] = $this->Pengguna_model->getPenggunaByUsername($username);
      $data['divisi'] = $this->Pengguna_model->getTableDivisi();

      $data['title'] = "Daftar | Pengguna";
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar');
      $this->load->view('templates/topbar');
      if ($this->AksesKontrol_model->cekHakAksesFitur())
        $this->load->view('daftar/pengguna/editPengguna');
      else
        $this->load->view('templates/error_hak_akses');
      $this->load->view('templates/footer');
    }
  }

  public function hapusPengguna($username = '')
  {
    if ($username == '')
      redirect('Daftar/Pengguna');
    else {

      $status = $this->Pengguna_model->hapusPengguna($username);

      if ($status)
        $this->session->set_flashdata('suksesHapusPengguna', '<div class="alert alert-success alert-dismissible fade show mt-4 mb-4" role="alert" style="margin: 0;font-size: 1.2rem">Pengguna ' . $username . ' berhasil di hapus!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
      else
        $this->session->set_flashdata('errorHapusPengguna', '<div class="alert alert-danger alert-dismissible fade show mt-4 mb-4" role="alert" style="margin: 0;font-size: 1.2rem">Pengguna ' . $username . ' gagal di hapus!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
      redirect('Daftar/Pengguna');
    }
  }

  // --------------------------------------------------------------------------------------------------------
  //                                        DIVISI
  // --------------------------------------------------------------------------------------------------------


  public function tambahDivisi()
  {
    if (!empty($_POST)) {
      $nama_divisi_dari_return = $this->Pengguna_model->simpanDivisi();
      $this->session->set_flashdata('suksesTambahDivisi', '<div class="alert alert-success alert-dismissible fade show mt-4 mb-4" role="alert" style="margin: 0;font-size: 1.2rem">Divisi ' . $nama_divisi_dari_return . ' berhasil ditambahkan!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
      echo json_encode(base_url('Daftar/Pengguna'));
    } else {
      $data['menus'] = $this->Pengguna_model->getMenus();
      $data['features'] = $this->Pengguna_model->getFeatures();
      $data['menu_sidebar'] = $this->AksesKontrol_model->getMenuEnabledForSidebar();
      $data['title'] = "Daftar | Pengguna";
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar');
      $this->load->view('templates/topbar');
      if ($this->AksesKontrol_model->cekHakAksesFitur())
        $this->load->view('daftar/pengguna/tambahDivisi');
      else
        $this->load->view('templates/error_hak_akses');
      $this->load->view('templates/footer');
    }
  }

  public function AJAXGetListOfMenuAndFeaturesId()
  {
    echo json_encode($this->Pengguna_model->AJAXGetListOfMenuAndFeaturesId());
  }

  public function editDivisi($divisi_id = 0)
  {
    if ($divisi_id == 0)
      redirect('Daftar/Pengguna');

    if (!empty($_POST)) {
      var_dump($_POST);
      $nama_divisi_dari_return = $this->Pengguna_model->editDivisi($divisi_id);
      $this->session->set_flashdata('suksesUpdateDivisi', '<div class="alert alert-success alert-dismissible fade show mt-4 mb-4" role="alert" style="margin: 0;font-size: 1.2rem">Divisi ' . $nama_divisi_dari_return . ' berhasil di update!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
      redirect('Daftar/Pengguna');
    } else {
      $data['divisi_id'] = $divisi_id;
      $data['menus'] = $this->Pengguna_model->getMenus();
      $data['features'] = $this->Pengguna_model->getFeatures();
      $data['hak_menus'] = $this->Pengguna_model->getHakAksesMenuByDivisiId($divisi_id);
      $data['hak_fitur'] = $this->Pengguna_model->getHakAksesFiturByDivisiId($divisi_id);
      $data['menu_sidebar'] = $this->AksesKontrol_model->getMenuEnabledForSidebar();
      $data['nama_divisi'] = $this->Pengguna_model->getNamaDivisiById($divisi_id);
      $data['hak_akses_menu'] = $this->Pengguna_model->getHakAksesDivisiForMenuById($divisi_id);
      $data['hak_akses_fitur'] = $this->Pengguna_model->getHakAksesDivisiForFiturById($divisi_id);

      $data['title'] = "Daftar | Pengguna";
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar');
      $this->load->view('templates/topbar');
      $this->load->view('daftar/pengguna/editDivisi');
      // if ($this->AksesKontrol_model->cekHakAksesFitur())
      //   $this->load->view('daftar/pengguna/editDivisi');
      // else
      //   $this->load->view('templates/error_hak_akses');
      $this->load->view('templates/footer');
    }
  }

  public function hapusDivisi($divisi_id = 0)
  {
    if ($divisi_id == 0)
      redirect('Daftar/Pengguna');
    else {

      $nama_divisi_dari_return = $this->Pengguna_model->hapusDivisi($divisi_id);
      $this->session->set_flashdata('suksesHapusDivisi', '<div class="alert alert-success alert-dismissible fade show mt-4 mb-4" role="alert" style="margin: 0;font-size: 1.2rem">Divisi ' . $nama_divisi_dari_return . ' berhasil di hapus!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
      redirect('Daftar/Pengguna');
    }
  }
}
