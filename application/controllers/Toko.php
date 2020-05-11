<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Toko extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    if ($this->session->userdata('role') > 3) {
      $url_kasir = base_url('Kasir');
      redirect($url_kasir);
    }
    if ($this->session->userdata('masuk') != TRUE) {
      $url = base_url();
      redirect($url);
    } else {
      $this->load->model('toko_model'); // Load SiswaModel ke controller ini
      $this->load->model('Notifikasi_model');
    }
  }
  function index()
  {
    $this->load->library('cart');
    $this->cart->destroy();
    $data['title'] = "Cabang";
    $data['not_read'] = $this->Notifikasi_model->getNotRead();
    $data['model'] = $this->toko_model->viewTable();

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar');
    $this->load->view('templates/topbar', $data);
    $this->load->view('toko/index', $data);
    $this->load->view('templates/footer');
  }

  public function simpan()
  {
    if ($this->toko_model->validation()) { // Jika validasi sukses atau hasil validasi adalah true
      $this->toko_model->save(); // Panggil fungsi save() yang ada di SiswaModel.php
      $html = $this->load->view('toko/viewTable', array('model' => $this->toko_model->viewTable()), true);

      $callback = array(
        'status' => 'sukses',
        'pesan' => '<div class="alert alert-success alert-dismissible fade show" role="alert">Toko cabang baru berhasil ditambahkan!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>',
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

  public function edit($id)
  {
    if ($this->toko_model->validation()) { // Jika validasi sukses atau hasil validasi adalah true
      $tes = $this->toko_model->edit($id);

      // Load ulang view.php agar data yang baru bisa muncul di tabel pada view.php
      $html = $this->load->view('toko/viewTable', array('model' => $this->toko_model->viewTable()), true);

      $callback = array(
        'status' => 'sukses',
        'pesan' => '<div class="alert alert-success alert-dismissible fade show" role="alert">Data toko cabang berhasil di-edit!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>',
        'html' => $html,
        'tes' => $tes
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
    $this->toko_model->delete($id); // Panggil fungsi delete() yang ada di SiswaModel.php

    // Load ulang view.php agar data yang baru bisa muncul di tabel pada view.php
    $html = $this->load->view('toko/viewTable', array('model' => $this->toko_model->viewTable()), true);

    $callback = array(
      'status' => 'sukses',
      'pesan' => '<div class="alert alert-success alert-dismissible fade show" role="alert">Data kategori produk telah dihapus!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>',
      'html' => $html
    );

    echo json_encode($callback);
  }
}
