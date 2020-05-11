<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Produk extends CI_Controller
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
      $this->load->model('Produk_model');
      $this->load->model('Notifikasi_model');
      $this->load->helper('form');

      $this->img_name = "noimage.png";
    }
  }

  public function index()
  {
    $this->load->library('cart');
    $this->cart->destroy();
    $data['title'] = "Produk";
    $data['not_read'] = $this->Notifikasi_model->getNotRead();
    $data['model'] = $this->Produk_model->viewTable();

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar');
    $this->load->view('templates/topbar');
    $this->load->view('produk/index', $data);
    $this->load->view('templates/footer');
  }

  public function tambahProduk()
  {
    $data['title'] = "Produk";
    $data['not_read'] = $this->Notifikasi_model->getNotRead();
    $this->load->model('KategoriProduk_model');
    $data['model'] = $this->KategoriProduk_model->viewTable();

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar');
    $this->load->view('templates/topbar');
    $this->load->view('produk/tambahProduk', $data);
    $this->load->view('templates/footer');
  }

  function save()
  {
    $this->_bkpForm();
    if ($this->Produk_model->validation("1")) { // Jika validasi sukses atau hasil validasi adalah true
      $insert = $this->Produk_model->save(); // Panggil fungsi save() yang ada di SiswaModel.php
      if ($insert == 1) {
        $this->session->set_flashdata('suksesAddProduk', '<div class="alert alert-success alert-dismissible fade show" role="alert" style="margin: 0">Produk berhasil ditambahkan!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        redirect('Produk');
      } else {
        show_404();
      }
    } else {
      $data['title'] = "Produk";
      $this->load->model('KategoriProduk_model');
      $data['model'] = $this->KategoriProduk_model->viewTable();

      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar');
      $this->load->view('templates/topbar');
      $this->load->view('produk/tambahProduk', $data);
      $this->load->view('templates/footer');
    }
  }

  public function editProduk($sku)
  {
    $data['title'] = "Edit Produk Baru";
    $data['not_read'] = $this->Notifikasi_model->getNotRead();
    $this->load->model('KategoriProduk_model');
    $data['category'] = $this->KategoriProduk_model->viewTable();
    $data['produk'] = $this->Produk_model->getData($sku);

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar');
    $this->load->view('templates/topbar');
    $this->load->view('produk/editProduk', $data);
    $this->load->view('templates/footer');
  }

  public function edit($sku)
  {
    if ($this->Produk_model->validation("2")) {
      $is_edit = $this->Produk_model->update($sku);
      if ($is_edit == 1) {
        $this->session->set_flashdata('suksesEditProduk', '<div class="alert alert-success alert-dismissible fade show" role="alert" style="margin: 0">Data produk berhasil di edit!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        redirect('Produk');
      } else {
        $this->session->set_flashdata('suksesEditProduk', '<div class="alert alert-warning alert-dismissible fade show" role="alert" style="margin: 0">Tidak terjadi perubahan data atau error!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        redirect('Produk');
      }
    } else {
      $data['title'] = "Edit Produk Baru";
      $data['not_read'] = $this->Notifikasi_model->getNotRead();
      $this->load->model('KategoriProduk_model');
      $data['category'] = $this->KategoriProduk_model->viewTable();
      $data['produk'] = $this->Produk_model->getData($sku);

      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar');
      $this->load->view('templates/topbar');
      $this->load->view('produk/editProduk', $data);
      $this->load->view('templates/footer');
    }
  }

  public function delete($sku)
  {
    $is_delete = $this->Produk_model->delete($sku);

    if ($is_delete == 1) {
      $this->session->set_flashdata('suksesEditProduk', '<div class="alert alert-success alert-dismissible fade show" role="alert" style="margin: 0">Produk berhasil di hapus!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
      redirect('Produk');
    } else {
      echo "error";
    }
  }

  public function _bkpForm()
  {
    $bkform = array(
      "is_error" => "1",
      "SKU" => $this->input->post('input_sku'),
      "kategori_produk_id" => $this->input->post('input_kategori'),
      "nama" => $this->input->post('input_nama'),
      "merk" => $this->input->post('input_merk'),
      "deskripsi" => $this->input->post('input_deskripsi'),
      "harga_modal" => $this->input->post('input_harga_modal'),
      "harga_jual" => $this->input->post('input_harga_jual'),
      "diskon" => $this->input->post('input_diskon'),
      "profit" => $this->input->post('input_profit')
    );
    $this->session->set_flashdata('bkp', $bkform);
  }
}
