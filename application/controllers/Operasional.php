<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Operasional extends CI_Controller
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
      $this->load->model('Operasional_model'); // Load SiswaModel ke controller ini
      $this->load->model('Notifikasi_model');
    }
  }

  public function index()
  {
    $this->load->library('cart');
    $this->cart->destroy();

    $data['title'] = "Operasional";
    $data['not_read'] = $this->Notifikasi_model->getNotRead();
    $data['model'] = $this->Operasional_model->getAllToko();

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar');
    $this->load->view('templates/topbar');
    $this->load->view('operasional/index', $data);
    $this->load->view('templates/footer');
  }

  public function view($toko_id)
  {
    $data['not_read'] = $this->Notifikasi_model->getNotRead();
    $data['toko'] = $this->Operasional_model->getTokoById($toko_id)[0];
    $data['title'] = "Operasional " . $data['toko']['nama'];
    $data['ops'] = $this->Operasional_model->getListOperasionalByToko($toko_id);

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar');
    $this->load->view('templates/topbar');
    $this->load->view('operasional/view', $data);
    $this->load->view('templates/footer');
  }

  public function save()
  {
    $insert = $this->Operasional_model->tambahOperasional();

    if ($insert) {
      $data = array(
        'status' => 'sukses',
        'pesan' => '<div class="alert alert-success alert-dismissible fade show isi-pesan-sukses" role="alert">Data operasional baru berhasil ditambahakan!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>'
      );
      echo json_encode($data);
    } else {
      $data = array(
        'status' => 'error',
        'pesan' => '<div class="alert alert-danger alert-dismissible fade show isi-pesan-sukses" role="alert" >Data operasional gagal ditambahakan!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>'
      );
      echo json_encode($data);
    }
  }

  public function update()
  {
    $update = $this->Operasional_model->updateOperasional();

    if ($update) {
      $data = array(
        'status' => 'sukses',
        'pesan' => '<div class="alert alert-success alert-dismissible fade show isi-pesan-sukses" role="alert">Data operasional berhasil diedit!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>'
      );
      echo json_encode($data);
    } else {
      $data = array(
        'status' => 'error',
        'pesan' => '<div class="alert alert-danger alert-dismissible fade show isi-pesan-sukses" role="alert" >Data operasional gagal diedit!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>'
      );
      echo json_encode($data);
    }
  }

  public function delete($id)
  {
    $this->Operasional_model->deleteOperasional($id);

    $data = array(
      'status' => 'sukses',
      'pesan' => '<div class="alert alert-success alert-dismissible fade show isi-pesan-sukses" role="alert">Data operasional berhasil dihapus!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>'
    );
    echo json_encode($data);
  }

  public function getViewTable($toko_id)
  {
    $ops = $this->Operasional_model->getListOperasionalByToko($toko_id);
    $html = $this->load->view('operasional/viewTable', array('ops' => $ops));
    echo json_encode($html);
  }

  public function getDataOperasional($id)
  {
    $callback = $this->Operasional_model->getDataOperasional($id)[0];
    echo json_encode($callback);
  }
}
