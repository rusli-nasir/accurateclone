<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Customer extends CI_Controller
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
      $this->load->model('Customer_model'); // Load SiswaModel ke controller ini
      $this->load->model('Notifikasi_model');
    }
  }

  public function index()
  {
    $this->load->library('cart');
    $this->cart->destroy();

    $this->load->model('Toko_model');

    $data['title'] = "Customer";
    $data['not_read'] = $this->Notifikasi_model->getNotRead();
    $data['toko'] = $this->Toko_model->viewTable();
    $data['cust'] = $this->Customer_model->getCustomerByToko($data['toko'][1]['id']);

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar');
    $this->load->view('templates/topbar');
    $this->load->view('customer/index', $data);
    $this->load->view('templates/footer');
  }

  public function getViewTable($toko_id, $mode)
  {
    $cust = $this->Customer_model->getCustomerByToko($toko_id);
    $html = $this->load->view('customer/viewTable', array('cust' => $cust, 'mode' => $mode));

    echo json_encode($html);
  }

  public function dataTables($mode, $view_mode)
  {
    $tgl_start = $_POST['tgl_start'];
    $tgl_end = $_POST['tgl_end'];
    $search = $_POST['search']['value']; // Ambil data yang di ketik user pada textbox pencarian
    $limit = $_POST['length']; // Ambil data limit per page
    $start = $_POST['start']; // Ambil data start
    $order_index = $_POST['order'][0]['column']; // Untuk mengambil index yg menjadi acuan untuk sorting
    $order_field = $_POST['columns'][$order_index]['data']; // Untuk mengambil nama field yg menjadi acuan untuk sorting
    $order_ascdesc = $_POST['order'][0]['dir']; // Untuk menentukan order by "ASC" atau "DESC"

    $sql_total = $this->Customer_model->count_all($mode, $tgl_start, $tgl_end, $view_mode); // Panggil fungsi count_all pada SiswaModel
    $sql_data = $this->Customer_model->filter($search, $limit, $start, $order_field, $order_ascdesc, $mode, $tgl_start, $tgl_end, $view_mode); // Panggil fungsi filter pada SiswaModel
    $sql_filter = $this->Customer_model->count_filter($search, $mode, $tgl_start, $tgl_end, $view_mode); // Panggil fungsi count_filter pada SiswaModel

    $callback = array(
      'draw' => $_POST['draw'], // Ini dari datatablenya
      'recordsTotal' => $sql_total,
      'recordsFiltered' => $sql_filter,
      'data' => $sql_data
    );

    header('Content-Type: application/json');
    echo json_encode($callback); // Convert array $callback ke json
  }
}
