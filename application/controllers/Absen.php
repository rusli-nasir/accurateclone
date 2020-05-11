<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Absen extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    //validasi jika user belum login
    if ($this->session->userdata('role') > 3) {
      $url_kasir = base_url('Kasir');
      redirect($url_kasir);
    }

    if ($this->session->userdata('masuk') != TRUE) {
      $url = base_url('Auth');
      redirect($url);
    } else {
      $this->load->model('Notifikasi_model');
      $this->load->model('Absen_model');
      $this->autoCloseAbsensi();
    }
    // $this->load->model('Notifikasi_model');
    // $this->load->model('Absen_model');
  }

  private function autoCloseAbsensi()
  {
    $id = $this->Absen_model->getIdAbsenNotClosed();

    foreach ($id as $x) {
      $this->Absen_model->processClosingAbsensi($x['id']);
    }
  }

  public function index()
  {
    $this->load->library('cart');
    $this->cart->destroy();
    $data['title'] = "Absensi Karyawan";
    $data['not_read'] = $this->Notifikasi_model->getNotRead();
    $data['first_date_of_record'] = $this->Absen_model->getFirstDateOfRecord();
    $data['last_date_of_record'] = $this->Absen_model->getLastDateOfRecord();
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar');
    $this->load->view('templates/topbar', $data);
    $this->load->view('absen/index');
    $this->load->view('templates/footer');
  }

  public function getFirstAndLastRecordDate()
  {
    $start = $this->Absen_model->getFirstDateOfRecord();
    $end = $this->Absen_model->getLastDateOfRecord();
    $start = date('Y/m/d', $start);
    $end = date('Y/m/d', $end);

    $data = array(
      'start' => $start,
      'end' => $end
    );
    echo json_encode($data);
  }

  public function getViewtableAbsen()
  {
    $start = $this->input->post('start');
    $end = $this->input->post('end');
    $start = (int) strtotime($start . ' 00:00:00');
    $end = (int) strtotime($end . ' 23:59:59');

    $data = $this->Absen_model->getDataAbsensi($start, $end);
    $html = $this->load->view('absen/absenTable', array('data' => $data), true);

    $callback = array(
      'html' => $html,
      'range' => date('j F Y', $start) . ' s/d ' . date('j F Y', $end)
    );
    echo json_encode($callback);
  }
}
