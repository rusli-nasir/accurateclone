<?php
defined('BASEPATH') or exit('No direct script access allowed');

class LapPenjualan extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    if ($this->session->userdata('masuk') != TRUE) {
      $url = base_url();
      redirect($url);
    } else {
      $this->load->model('LapPenjualan_model'); // Load SiswaModel ke controller ini
      $this->load->model('Notifikasi_model');
    }
  }

  public function index()
  {
    $this->load->library('cart');
    $this->cart->destroy();

    $data['title'] = "Laporan Penjualan";
    $data['not_read'] = $this->Notifikasi_model->getNotRead();
    if ($this->session->userdata('role') <= 3)
      $data['model'] = $this->LapPenjualan_model->viewTable();
    else {
      $data['model'] = $this->LapPenjualan_model->viewTableByToko($this->session->userdata('toko'));
      $data['nama_toko'] = $this->LapPenjualan_model->getNamaToko($this->session->userdata('toko'))[0];
    }

    $data['toko'] = $this->LapPenjualan_model->getAllToko();

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar');
    $this->load->view('templates/topbar');
    $this->load->view('lap_penjualan/index', $data);
    $this->load->view('templates/footer');
  }

  public function getViewInvoiceDetails($inv_id)
  {
    $inv = $this->LapPenjualan_model->getDataInvoice($inv_id);
    $items = $this->LapPenjualan_model->getDataInvoiceItems($inv_id);
    $html = $this->load->view('lap_penjualan/viewInvoiceDetail', array('invoice' => $inv, 'items' => $items));
    echo json_encode($html);
  }

  public function getViewTableByToko($toko_id)
  {
    if ($toko_id == 'all')
      $model = $this->LapPenjualan_model->viewTable();
    else
      $model = $this->LapPenjualan_model->viewTableByToko($toko_id);

    $html = $this->load->view('lap_penjualan/viewTable', array('model' => $model));
    echo json_encode($html);
  }

  public function sendUlangInvoice($id_inv)
  {
    $data['title'] = "Kirim Ulang Invoice ke Customer";
    $data['not_read'] = $this->Notifikasi_model->getNotRead();
    $data['id_inv'] = $id_inv;
    $data['kd_inv'] = $this->LapPenjualan_model->getKodeInvoiceById($id_inv)[0]['kode_invoice'];
    $data['cust'] = $this->LapPenjualan_model->getDataCustomerByInv($id_inv)[0];

    if (empty($data['cust']['email']))
      $data['mode'] = 'sms';
    else
      $data['mode'] = 'email';

    if (!$this->_validation($data['mode'])) {
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar');
      $this->load->view('templates/topbar');
      $this->load->view('lap_penjualan/sendUlangInvoice', $data);
      $this->load->view('templates/footer');
    } else {
      if ($this->input->post('input_mode') == 'email') {
        $updateCust = array(
          'nama' => $this->input->post('input_nama'),
          'email' => $this->input->post('input_contact')
        );
        $this->LapPenjualan_model->updateContactCustomer($data['cust']['id'], 'email', $updateCust);

        if ($this->_sendInvoiceEmail($this->input->post('input_contact'), $id_inv) == 'sukses') {
          redirect('LapPenjualan/landingSuksesResendInvoice/email/sukses/' . $id_inv);
        } else {
          $this->session->set_flashdata('pesanResendInvoice', '<div class="alert alert-danger alert-dismissible fade show" role="alert">Invoice via email gagal dikirimkan!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
          redirect($this->uri->uri_string());
        }
      } else {
        $updateCust = array(
          'nama' => $this->input->post('input_nama'),
          'cp' => $this->input->post('input_contact')
        );
        $this->LapPenjualan_model->updateContactCustomer($data['cust']['id'], 'sms', $updateCust);

        $kirimSMS = $this->_sendInvoiceSMS($this->input->post('input_contact'), $id_inv);
        if ($kirimSMS == 0) {
          redirect(base_url('LapPenjualan/landingSuksesResendInvoice/sms/0/' . $id_inv));
        } else {
          if ($kirimSMS == 1)
            $this->session->set_flashdata('pesanResendInvoice', '<div class="alert alert-danger alert-dismissible fade show" role="alert">No. HP yang dimasukkan tidak valid!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
          if ($kirimSMS == 5)
            $this->session->set_flashdata('pesanResendInvoice', '<div class="alert alert-danger alert-dismissible fade show" role="alert">Userkey / passkey salah! Segera kontak Webmaster untuk diperbaiki!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
          if ($kirimSMS == 6)
            $this->session->set_flashdata('pesanResendInvoice', '<div class="alert alert-danger alert-dismissible fade show" role="alert">Konten SMS tidak diterima oleh pihak Zenziva! Tunggu beberapa saat lagi dan coba kirim ulang invoicenya!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
          if ($kirimSMS == 89)
            $this->session->set_flashdata('pesanResendInvoice', '<div class="alert alert-danger alert-dismissible fade show" role="alert">Pengiriman SMS berulang-ulang ke satu nomor dalam satu waktu! Tunggu beberapa saat lagi dan coba kirim ulang invoicenya!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
          if ($kirimSMS == 99)
            $this->session->set_flashdata('pesanResendInvoice', '<div class="alert alert-danger alert-dismissible fade show" role="alert">Credit SMS tidak mencukupi! Kontak Webmaster untuk isi ulang credit SMS di Zenziva!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
          redirect($this->uri->uri_string());
        }
      }
    }
  }

  private function _validation($mode)
  {
    if ($this->session->flashdata('modeUpdated'))
      $mode = $this->session->flashdata('modeUpdated');

    if ($mode == 'email') {
      $this->form_validation->set_rules('input_nama', 'Nama', 'trim|required');
      $this->form_validation->set_rules('input_contact', 'Email', 'trim|required|valid_email');
    } else {
      $this->form_validation->set_rules('input_nama', 'Nama', 'trim|required');
      $this->form_validation->set_rules('input_contact', 'No. HP', 'trim|required|min_length[10]');
    }

    if ($this->form_validation->run())
      return TRUE;
    else
      return FALSE;
  }

  private function _sendInvoiceEmail($contact, $inv_id)
  {
    $this->load->model('Kasir_model');
    $invoice = $this->Kasir_model->getInvoiceData($inv_id);
    $items = $this->Kasir_model->getInvoiceItemsData($inv_id);

    $invoice[0]['tanggal'] = date("j F Y", strtotime($invoice[0]['tanggal']));
    $html = $this->load->view('kasir/invoiceEmail', array('invoice' => $invoice[0], 'items' => $items), true);

    $this->load->config('email');
    $this->load->library('email');

    $from = $this->config->item('smtp_user');
    $to = $contact;
    $subject = 'Invoice Pembelian Item Rocketjaket Store';
    $message = $html;

    $this->email->set_mailtype("html");
    $this->email->set_newline("\r\n");
    $this->email->from($from);
    $this->email->to($to);
    $this->email->subject($subject);
    $this->email->message($message);

    $this->email->send();
    return 'sukses';
  }

  private function _sendInvoiceSMS($contact, $inv_id)
  {
    $this->load->model('Kasir_model');
    $invoice = $this->Kasir_model->getInvoiceData($inv_id);
    $msg =
      'Terima kasih ' . ucfirst($invoice[0]['c_nama']) . ' telah berbelanja di Rocketjaket. Invoice anda ' . $invoice[0]['kode_invoice'] . '.' . 'Detail pembelian : ';

    $items = $this->Kasir_model->getInvoiceItemsData($inv_id);
    $pdk_all = '';
    $i = 0;
    $len = count($items);
    foreach ($items as $x) {
      if ($i == $len - 1)
        $pdk_all = $pdk_all . $x['sku'] . '/' . $x['nama_pdk'] . ' ' . $x['qty'] . 'pcs subtotal = Rp ' . number_format($x['subtotal'], 0, ",", ".") . '.';
      else
        $pdk_all = $pdk_all . $x['sku'] . '/' . $x['nama_pdk'] . ' ' . $x['qty'] . 'pcs subtotal = Rp ' . number_format($x['subtotal'], 0, ",", ".") . ', ';
      $i++;
    }
    $msg = $msg . $pdk_all;

    $msg = $msg . ' Grand total : Rp ' . number_format($invoice[0]['grand_total'], 0, ",", ".");

    //proses sms
    $mobile = $contact;
    $message = $msg;
    $msgencode = urlencode($message);
    $userkey = "py4tb6";
    $passkey = "nh89fzd90z";
    $router = "";

    $postdata = array(
      'authkey' => $userkey,
      'mobile' => $mobile,
      'message' => $msgencode,
      'router' => $router
    );
    $url = "https://reguler.zenziva.net/apps/smsapi.php?userkey=$userkey&passkey=$passkey&nohp=$mobile&pesan=$msgencode";

    $ch  = curl_init();
    curl_setopt_array($ch, array(
      CURLOPT_URL => $url,
      CURLOPT_RETURNTRANSFER => TRUE,
      CURLOPT_POST => TRUE,
      CURLOPT_POSTFIELDS => $postdata
    ));

    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

    $output = curl_exec($ch);
    curl_close($ch);
    $xml = simplexml_load_string($output) or die("Error: Cannot create object");
    // Convert into json 
    $con = json_encode($xml);

    // Convert into associative array 
    $newArr = json_decode($con, true);


    $callback = $newArr['message']['status'];
    return $callback;
  }

  public function updateModeViaFlashdata()
  {
    $mode = $this->input->post('updatedMode');
    $this->session->set_flashdata('modeUpdated', $mode);
  }

  public function landingSuksesResendInvoice($mode, $status, $inv_id)
  {
    $data['title'] = "Sukses Mengirim Ulang Invoice Ke Customer";
    $data['not_read'] = $this->Notifikasi_model->getNotRead();
    $data['mode'] = $mode;
    $data['status'] = $status;
    $data['inv'] = $this->LapPenjualan_model->getInvoiceDataByInvId($inv_id)[0];

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar');
    $this->load->view('templates/topbar');
    $this->load->view('lap_penjualan/landingSuksesResendInvoice', $data);
    $this->load->view('templates/footer');
  }

  public function refund($inv_id)
  {
    $data['inv'] = $this->LapPenjualan_model->getDataInvoice($inv_id)[0];
    $data['not_read'] = $this->Notifikasi_model->getNotRead();
    $data['title'] = "Refund Pembelian";

    if ($data['inv']['status'] == 0) {
      $data['brg'] = $this->LapPenjualan_model->getDataInvoiceItems($inv_id);

      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar');
      $this->load->view('templates/topbar');
      $this->load->view('lap_penjualan/refund', $data);
      $this->load->view('templates/footer');
    } else {
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar');
      $this->load->view('templates/topbar');
      $this->load->view('lap_penjualan/wasRefund', $data);
      $this->load->view('templates/footer');
    }
  }

  public function getQtyBarangInvoice($id)
  {
    $qty = $this->LapPenjualan_model->getQtyBarangInvoiceById($id)[0]['qty'];
    echo $qty;
  }

  public function prosesRefund($inv_id, $is_refund_all)
  {
    $data = $this->input->post('data');
    $status = $this->LapPenjualan_model->prosesRefund($inv_id, $data, $is_refund_all);
    print_r($status);
  }

  public function landingRefund($inv_id, $status)
  {
    $data['inv'] = $this->LapPenjualan_model->getDataInvoice($inv_id)[0];
    $data['not_read'] = $this->Notifikasi_model->getNotRead();
    $data['title'] = "Status Refund";
    $data['status'] = $status;

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar');
    $this->load->view('templates/topbar');
    $this->load->view('lap_penjualan/landingRefund', $data);
    $this->load->view('templates/footer');
  }

  public function getStatusInv($inv_id)
  {
    $data = $this->LapPenjualan_model->getStatusInv($inv_id);

    $statusInv = $data['status'];

    $tgl_start = $data['tanggal'];
    $tgl_start = strtotime($tgl_start);
    $tgl_end = date('Y-m-d');
    $tgl_end = strtotime($tgl_end);
    $tgl_selisih = abs($tgl_end - $tgl_start);
    $selisih_hari = intval($tgl_selisih / 86400);

    if ($selisih_hari >= 0 && $selisih_hari <= 7)
      $statusTanggal = 1;
    else
      $statusTanggal = 0;

    $callback = array(
      'status_inv' => $statusInv,
      'status_tgl' => $statusTanggal,
    );

    echo json_encode($callback);
  }

  public function dataTables($mode)
  {
    $tgl_start = $_POST['tgl_start'];
    $tgl_end = $_POST['tgl_end'];
    $search = $_POST['search']['value']; // Ambil data yang di ketik user pada textbox pencarian
    $limit = $_POST['length']; // Ambil data limit per page
    $start = $_POST['start']; // Ambil data start
    $order_index = $_POST['order'][0]['column']; // Untuk mengambil index yg menjadi acuan untuk sorting
    $order_field = $_POST['columns'][$order_index]['data']; // Untuk mengambil nama field yg menjadi acuan untuk sorting
    $order_ascdesc = $_POST['order'][0]['dir']; // Untuk menentukan order by "ASC" atau "DESC"

    $sql_total = $this->LapPenjualan_model->count_all($mode, $tgl_start, $tgl_end); // Panggil fungsi count_all pada SiswaModel
    $sql_data = $this->LapPenjualan_model->filter($search, $limit, $start, $order_field, $order_ascdesc, $mode, $tgl_start, $tgl_end); // Panggil fungsi filter pada SiswaModel
    $sql_filter = $this->LapPenjualan_model->count_filter($search, $mode, $tgl_start, $tgl_end); // Panggil fungsi count_filter pada SiswaModel

    $callback = array(
      'draw' => $_POST['draw'], // Ini dari datatablenya
      'recordsTotal' => $sql_total,
      'recordsFiltered' => $sql_filter,
      'data' => $sql_data
    );

    header('Content-Type: application/json');
    echo json_encode($callback); // Convert array $callback ke json
  }

  public function tes()
  {
    $sql = "SELECT id, tersedia FROM inventory WHERE produk_SKU = '431' AND toko_id = 2 LIMIT 1";
    $query = $this->db->query($sql);
    return print_r($query->result_array()[0]);
  }
}
