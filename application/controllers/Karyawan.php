<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Karyawan extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    if ($this->session->userdata('role') > 3) {
      $url_kasir = base_url('Kasir');
      redirect($url_kasir);
    }

    if ($this->session->userdata('role') > 3) {
      $url_kasir = base_url('Kasir');
      redirect($url_kasir);
    }

    if ($this->session->userdata('masuk') != TRUE) {
      $url = base_url();
      redirect($url);
    } else {
      $this->load->model('Karyawan_model'); // Load SiswaModel ke controller ini
      $this->load->model('Notifikasi_model');
    }
  }

  public function index()
  {
    $this->load->library('cart');
    $this->cart->destroy();
    $data['title'] = "Karyawan";
    $data['not_read'] = $this->Notifikasi_model->getNotRead();
    $data['model'] = $this->Karyawan_model->viewTable();
    $this->load->model('Toko_model');
    $data['toko'] = $this->Toko_model->viewTable();
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar');
    $this->load->view('templates/topbar');
    $this->load->view('karyawan/index', $data);
    $this->load->view('templates/footer');
  }

  public function simpan()
  {
    $peran = $this->input->post('input_peran');
    if ($peran == 3) {
      $peran = "savenewadmin";
    } else {
      $peran = "savenew";
    }
    if ($this->Karyawan_model->validation($peran)) { // Jika validasi sukses atau hasil validasi adalah true
      $this->Karyawan_model->save(); // Panggil fungsi save() yang ada di SiswaModel.php
      $html = $this->load->view('karyawan/viewTable', array('model' => $this->Karyawan_model->viewTable()), true);

      $callback = array(
        'status' => 'sukses',
        'pesan' => '<div class="alert alert-success alert-dismissible fade show" role="alert">Pengguna baru berhasil ditambahkan!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>',
        'html' => $html
      );
    } else {
      $callback = array(
        'status' => 'gagal',
        'pesan' => validation_errors()
      );
    }

    echo json_encode($callback);
  }

  public function edit($username, $mode)
  {
    $sql = "SELECT kode_peran FROM karyawan WHERE username = '$username' LIMIT 1";
    $peran = $this->db->query($sql)->result_array()[0]['kode_peran'];
    if ($peran > 0 && $peran <= 2) {
      if ($mode == 'else')
        $mode = 'withoutpassowner';
      else
        $mode = 'withpassowner';
    } else if ($peran = 3) {
      if ($mode == 'else')
        $mode = 'withoutpassadmin';
      else
        $mode = 'withpassadmin';
    } else {
      if ($mode == 'else')
        $mode = 'withoutpass';
      else
        $mode = 'withpass';
    }
    if ($this->Karyawan_model->validation($mode)) { // Jika validasi sukses atau hasil validasi adalah true

      $this->Karyawan_model->edit($username, $mode); // Panggil fungsi edit() yang ada di SiswaModel.php}

      // Load ulang view.php agar data yang baru bisa muncul di tabel pada view.php
      $html = $this->load->view('karyawan/viewTable', array('model' => $this->Karyawan_model->viewTable()), true);

      $callback = array(
        'status' => 'sukses',
        'pesan' => '<div class="alert alert-success alert-dismissible fade show" role="alert">Data pengguna berhasil di-edit!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>',
        'html' => $html
      );
    } else {
      $callback = array(
        'status' => 'gagal',
        'pesan' => validation_errors()
      );
    }
    echo json_encode($callback);
  }

  public function delete($id)
  {
    $this->Karyawan_model->delete($id); // Panggil fungsi delete() yang ada di SiswaModel.php

    // Load ulang view.php agar data yang baru bisa muncul di tabel pada view.php
    $html = $this->load->view('karyawan/viewTable', array('model' => $this->Karyawan_model->viewTable()), true);

    $callback = array(
      'status' => 'sukses',
      'pesan' => '<div class="alert alert-success alert-dismissible fade show" role="alert">Data pengguna telah dihapus.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>',
      'html' => $html
    );

    echo json_encode($callback);
  }

  public function getRoleId()
  {
    $data = array(
      'role' => $this->session->userdata('role')
    );
    echo json_encode($data);
  }
}
