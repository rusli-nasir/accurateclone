<?php
defined('BASEPATH') or exit('No direct script access allowed');

class KategoriProduk extends CI_Controller
{
  public function __construct()
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
      $this->load->model('KategoriProduk_model'); // Load SiswaModel ke controller ini
      $this->load->model('Notifikasi_model');
    }
  }

  public function index()
  {
    $this->load->library('cart');
    $this->cart->destroy();
    $data['title'] = "Kategori Produk";
    $data['not_read'] = $this->Notifikasi_model->getNotRead();
    $data['model'] = $this->KategoriProduk_model->viewTable();

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar');
    $this->load->view('templates/topbar');
    $this->load->view('kategori_produk/index', $data);
    $this->load->view('templates/footer');
  }

  public function tambahKategori()
  {
    $data['title'] = "Tambah Kategori Produk Baru";
    $data['not_read'] = $this->Notifikasi_model->getNotRead();

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar');
    $this->load->view('templates/topbar');
    $this->load->view('kategori_produk/tambahkategori', $data);
    $this->load->view('templates/footer');
  }

  public function simpan()
  {
    if ($this->KategoriProduk_model->validation()) { // Jika validasi sukses atau hasil validasi adalah true
      $this->KategoriProduk_model->save(); // Panggil fungsi save() yang ada di SiswaModel.php
      $html = $this->load->view('kategori_produk/viewTable', array('model' => $this->KategoriProduk_model->viewTable()), true);

      $callback = array(
        'status' => 'sukses',
        'pesan' => '<div class="alert alert-success alert-dismissible fade show" role="alert">Kategori produk baru berhasil ditambahkan!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>',
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
    if ($this->KategoriProduk_model->validation()) { // Jika validasi sukses atau hasil validasi adalah true
      $this->KategoriProduk_model->edit($id);

      // Load ulang view.php agar data yang baru bisa muncul di tabel pada view.php
      $html = $this->load->view('kategori_produk/viewTable', array('model' => $this->KategoriProduk_model->viewTable()), true);

      $callback = array(
        'status' => 'sukses',
        'pesan' => '<div class="alert alert-success alert-dismissible fade show" role="alert">Data kategori produk berhasil di-edit!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>',
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
    $this->KategoriProduk_model->delete($id); // Panggil fungsi delete() yang ada di SiswaModel.php

    // Load ulang view.php agar data yang baru bisa muncul di tabel pada view.php
    $html = $this->load->view('kategori_produk/viewTable', array('model' => $this->KategoriProduk_model->viewTable()), true);

    $callback = array(
      'status' => 'sukses',
      'pesan' => '<div class="alert alert-success alert-dismissible fade show" role="alert">Data kategori produk telah dihapus!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>',
      'html' => $html
    );

    echo json_encode($callback);
  }
}
