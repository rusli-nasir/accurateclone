<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kasir extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    //validasi jika user belum login
    if ($this->session->userdata('masuk') != TRUE) {
      $url = base_url();
      redirect($url);
    } else {
      $this->load->library('cart');
      $this->load->model('Kasir_model');
      $this->load->model('Toko_model');
      $this->load->model('Notifikasi_model');
    }
  }

  public function index()
  {
    $this->load->library('cart');
    $this->cart->destroy();
    $toko_id = $this->session->userdata('toko');

    if ($toko_id == 0) {

      $this->getTokoId();
    } else {

      $nama_toko = $this->Toko_model->getNamaToko($toko_id);
      $data['title'] = "Kasir " . $nama_toko[0]['nama'];
      $data['not_read'] = $this->Notifikasi_model->getNotRead();
      $data['datacat'] = $this->Kasir_model->getCategoryProduct($toko_id);
      $data['datapdk'] = $this->Kasir_model->getAllProduct($toko_id);
      $data['toko_id'] = $this->session->userdata('toko');
      $data['tdk_beli'] = $this->Kasir_model->getPengunjungTidakBeli($toko_id);
      $data['laporan'] = $this->Kasir_model->getLaporanHariIni($toko_id);
      if (empty($data['tdk_beli']))
        $data['tdk_beli'] = 0;


      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar');
      $this->load->view('templates/topbar', $data);
      $this->load->view('kasir/index', $data);
      $this->load->view('templates/footer');
    }
  }

  public function admin($toko_id)
  {
    $nama_toko = $this->Toko_model->getNamaToko($toko_id);
    $data['title'] = "Kasir " . $nama_toko[0]['nama'];
    $data['not_read'] = $this->Notifikasi_model->getNotRead();
    $data['datacat'] = $this->Kasir_model->getCategoryProduct($toko_id);
    $data['datapdk'] = $this->Kasir_model->getAllProduct($toko_id);
    $data['toko_id'] = $toko_id;
    $data['tdk_beli'] = $this->Kasir_model->getPengunjungTidakBeli($toko_id);
    if (empty($data['tdk_beli']))
      $data['tdk_beli'] = 0;
    $data['laporan'] = $this->Kasir_model->getLaporanHariIni($toko_id);

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar');
    $this->load->view('templates/topbar', $data);
    $this->load->view('kasir/index', $data);
    $this->load->view('templates/footer');
  }

  public function getTokoId()
  {
    $data['title'] = "Kasir";
    $data['not_read'] = $this->Notifikasi_model->getNotRead();
    $data['model'] = $this->Kasir_model->getAllToko();

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar');
    $this->load->view('templates/topbar', $data);
    $this->load->view('kasir/getTokoId', $data);
    $this->load->view('templates/footer');
  }

  public function add()
  {
    $sku = $this->input->post('sku');
    $this->load->model('Produk_model');
    $data = $this->Produk_model->getData($sku);

    $insertCart = array(
      'id' => $data['SKU'],
      'name' => $data['nama'],
      'price' => $data['harga_jual'],
      'image' => $data['foto'],
      'diskon' => $data['diskon'],
      'qty' => 1,
      'max_beli' => $this->input->post('max_beli')
    );

    $this->cart->insert($insertCart);

    $html = $this->load->view('kasir/displayCart');
    echo json_encode($html);
  }

  public function remove()
  {
    $rowid = $this->input->post('rowid');

    if ($rowid == "all") {
      $this->cart->destroy();
    } else {
      $remove = array(
        'rowid' => $rowid,
        'qty' => 0
      );
      $this->cart->update($remove);
    }
    $html = $this->load->view('kasir/displayCart');
    echo json_encode($html);
  }

  public function removeItemByOneQty()
  {
    $rowid = $this->input->post('rowid');
    $qty_after = $this->input->post('qty_after');

    if ($rowid == "all") {
      $this->cart->destroy();
    } else {
      $remove = array(
        'rowid' => $rowid,
        'qty' => $qty_after
      );
      $this->cart->update($remove);
    }
    $html = $this->load->view('kasir/displayCart');
    echo json_encode($html);
  }

  public function getTotalQtyCart($sku)
  {
    if ($cart = $this->cart->contents()) {
      foreach ($cart as $item) {
        if ($item['id'] == $sku) {
          echo $item['qty'];
        } else {
          echo 0;
        }
      }
    } else {
      echo 0;
    }
  }

  public function getGrandTotal()
  {
    if ($cart = $this->cart->contents()) {
      $grandtotal = 0;
      foreach ($cart as $item) {
        $grandtotal += ($item['price'] * $item['qty']) - ($item['diskon'] * $item['qty']);
      }

      $finaltotal = 'Rp' . number_format($grandtotal, 0, ',', '.');
      echo $finaltotal;
    } else {
      echo 0;
    }
  }

  public function getGrandTotalNumber()
  {
    if ($cart = $this->cart->contents()) {
      $grandtotal = 0;
      foreach ($cart as $item) {
        $grandtotal += ($item['price'] * $item['qty']) - ($item['diskon'] * $item['qty']);
      }
      return $grandtotal;
    } else {
      return 0;
    }
  }

  public function getGrandTotalNumberAjax()
  {
    if ($cart = $this->cart->contents()) {
      $grandtotal = 0;
      foreach ($cart as $item) {
        $grandtotal += ($item['price'] * $item['qty']) - ($item['diskon'] * $item['qty']);
      }
      echo $grandtotal;
    } else {
      echo 0;
    }
  }

  public function cekCartAny()
  {
    if ($this->cart->contents())
      echo "true";
    else
      echo "false";
  }

  public function prosesPembayaran()
  {
    $toko_id = $this->input->post('toko_id');
    $total = $this->getGrandTotalNumber();

    $jml_pengunjung_beli = $this->input->post('jml_cust');
    $data_tambah_pengunjung_beli = array();
    $inserted_pengunjung_beli = 0;
    for ($x = 0; $x < $jml_pengunjung_beli; $x++) {
      $data = array(
        'tanggal' => date('Y/m/d'),
        'is_beli' => 1,
        'toko_id' => $toko_id
      );
      $status_tambah_pengunjung_beli = $this->Kasir_model->tambahPengunjungBeli($data);
      array_push($data_tambah_pengunjung_beli, $status_tambah_pengunjung_beli);
      if ($status_tambah_pengunjung_beli['status'] === TRUE) {
        $inserted_pengunjung_beli++;
      }
    }

    $cust_id = $this->Kasir_model->tambahCustomer();

    $invoice_id = $this->Kasir_model->prosesInvoice($cust_id, $total);

    $mode = $this->input->post('contact_mode');
    $contact = $this->input->post('contact');

    $status_invoice_details_all = FALSE;
    $status_update_inventory = FALSE;
    $status_insert_invoice_details = FALSE;
    $data_insert_invoice_details = array();
    $data_update_inventory = array();
    if ($cart = $this->cart->contents()) :
      $total_items = 0;
      $inserted_inv_dtl = 0;
      $updated_inv_item = 0;
      foreach ($cart as $item) :
        $invoice_details = array(
          'invoice_id' => $invoice_id,
          'produk_SKU' => $item['id'],
          'harga' => $item['price'],
          'jumlah_pembelian' => $item['qty'],
          'jumlah_diskon' => $item['diskon'] * $item['qty'],
          'subtotal' => ($item['price'] * $item['qty']) - ($item['diskon'] * $item['qty']),
          'status' => 0
        );
        $total_items++;

        $inv_dtl = $this->Kasir_model->prosesInvoiceDetails($invoice_details);
        array_push($data_insert_invoice_details, $inv_dtl);
        if ($inv_dtl['status'] === TRUE)
          $inserted_inv_dtl++;

        $update_inventory_callback = $this->Kasir_model->updateInventory($invoice_details['produk_SKU'], $invoice_details['jumlah_pembelian'], $toko_id);
        array_push($data_update_inventory, $update_inventory_callback);

        if ($update_inventory_callback['status'] === TRUE)
          $updated_inv_item++;
      endforeach;
      $this->cart->destroy();

      if ($total_items == $inserted_inv_dtl)
        $status_insert_invoice_details = TRUE;

      if ($total_items == $updated_inv_item)
        $status_update_inventory = TRUE;

      if ($total_items == $inserted_inv_dtl && $total_items == $updated_inv_item)
        $status_invoice_details_all = TRUE;
    endif;

    $statusProsesInvoice = '';
    $statusReceipt = '';
    if ($inserted_pengunjung_beli == $jml_pengunjung_beli && $cust_id !== FALSE && $invoice_id !== FALSE && $status_invoice_details_all === TRUE) {
      foreach ($data_update_inventory as $x) {
        if ($x['status'] === TRUE) {
          if ($x['tsd_after'] <= $x['tsd_min'])
            $this->Kasir_model->notifikasiProdukLimit($toko_id, $x['tsd_after'], $x['tsd_min'], $x['sku']);
        }
      }

      if ($mode == "email") {
        $statusReceipt = $this->_sendInvoiceEmail($contact, $invoice_id);
      } else {
        $statusReceipt = $this->_sendInvoiceSMS($contact, $invoice_id);
      }
      $statusProsesInvoice = 'sukses';
      $this->session->set_flashdata('pesanBayar', '<div id="pesan-bayar" class="alert alert-success alert-dismissible fade show col-12" role="alert">Berhasil melakukan pembelian!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    } else {
      foreach ($data_tambah_pengunjung_beli as $x) {
        if ($x['status'] === TRUE)
          $this->Kasir_model->deletePengunjung($x['id']);
      }
      if ($cust_id !== FALSE)
        $this->Kasir_model->deleteCustomer($cust_id);
      if ($invoice_id !== FALSE)
        $this->Kasir_model->deleteInvoice($invoice_id);
      foreach ($data_insert_invoice_details as $x) {
        if ($x['status'] === TRUE)
          $this->Kasir_model->deletePengunjung($x['id']);
      }
      foreach ($data_update_inventory as $x) {
        if ($x['status'] === TRUE)
          $this->Kasir_model->rollbackUpdateInventory($x['id_inv'], $x['tsd_bfr']);
      }

      $statusProsesInvoice = 'error';
    }

    $cek_pengunjung = 0;
    if ($inserted_pengunjung_beli == $jml_pengunjung_beli)
      $cek_pengunjung = 1;
    $cek_customer = 0;
    if ($cust_id !== FALSE)
      $cek_customer = 1;
    $cek_invoice = 0;
    if ($invoice_id !== FALSE)
      $cek_customer = 1;
    $cek_invoice_items = 0;
    if ($status_insert_invoice_details !== FALSE)
      $cek_invoice_items = 1;
    $cek_update_inventory = 0;
    if ($status_update_inventory !== FALSE)
      $cek_update_inventory = 1;
    $tmp_statusReceipt;
    if ($mode == 'email')
      $tmp_statusReceipt = $statusReceipt;
    else
      $tmp_statusReceipt = $statusReceipt['xml_status'];
    $cekProsesInvoice = array(
      'pengunjung' => $cek_pengunjung,
      'customer' => $cek_customer,
      'invoice' => $cek_invoice,
      'invoice_items' => $cek_invoice_items,
      'update_inventory' => $cek_update_inventory,
      'status_invoice_all' => $statusProsesInvoice,
      'status_receipt' => $tmp_statusReceipt,
      'mode_receipt' => $mode,
      'cust_id' => $cust_id
    );

    echo json_encode($cekProsesInvoice);
  }

  private function _sendInvoiceSMS($contact, $inv_id)
  {
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


    $callback = array(
      'xml_status' => $newArr['message']['status']
    );
    return $callback;
  }

  private function _sendInvoiceEmail($contact, $inv_id)
  {
    $invoice = $this->Kasir_model->getInvoiceData($inv_id);
    $items = $this->Kasir_model->getInvoiceItemsData($inv_id);

    $invoice[0]['tanggal'] = date("j F Y H:i", $invoice[0]['time']);
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

  public function invoiceError($mode, $status, $id)
  {
    if ($this->session->flashdata('url_ori')) {
      $x = $this->session->flashdata('url_ori');
      $this->session->set_flashdata('url_orig', $x);
    }

    if ($mode == 'email') {
      $this->form_validation->set_rules('input_nama_customer', 'Nama', 'trim|required');
      $this->form_validation->set_rules('input_email_customer', 'Email', 'trim|required|valid_email');
      if (!$this->form_validation->run()) {
        $data['mode'] = $mode;
        $data['title'] = "Pengiriman Invoice Error";
        $data['not_read'] = $this->Notifikasi_model->getNotRead();
        $data['cust'] = $this->Kasir_model->getCustomerData($id)[0];

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar', $data);
        $this->load->view('kasir/invoiceError', $data);
        $this->load->view('templates/footer');
      } else { }
    } else {
      if (!$this->session->flashdata('statusSetelahKirimSMS')) {
        $sms_validation = $status;
      } else {
        $sms_validation = $this->session->flashdata('statusSetelahKirimSMS');
      }

      $this->form_validation->set_rules('input_nama_customer', 'Nama', 'trim|required');
      $this->form_validation->set_rules('input_cp_customer', 'No. HP', 'trim|required|min_length[10]');

      if (!$this->form_validation->run() && $sms_validation == 1) {
        $data['mode'] = 'SMS';
        $data['title'] = "Pengiriman Invoice Error";
        $data['not_read'] = $this->Notifikasi_model->getNotRead();
        $data['cust'] = $this->Kasir_model->getCustomerData($id)[0];
        $data['error_type'] = $sms_validation;

        $data['tes'] = $this->input->post('url_ori');

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar', $data);
        $this->load->view('kasir/invoiceError', $data);
        $this->load->view('templates/footer');
      } else {
        $contact = $this->input->post('input_cp_customer');
        $nama = $this->input->post('input_nama_customer');
        $data = array(
          'nama' => $nama,
          'cp' => $contact
        );
        $this->Kasir_model->updateCustomer($id, $data);
        $status_kirim_sms = $this->_sendUlangInvoiceSMS($contact, $nama, $id);

        $this->session->set_flashdata('statusSetelahKirimSMS', $status_kirim_sms);

        if ($status_kirim_sms == 1)
          redirect($this->uri->uri_string());
        else
          redirect("Kasir/landingStatusInvoice/$mode/$status_kirim_sms/$id");
      }
    }
  }

  public function landingStatusInvoice($mode, $status, $cust_id)
  {
    $data['title'] = "Status Pengiriman Invoice";
    $data['not_read'] = $this->Notifikasi_model->getNotRead();
    $data['mode'] = $mode;
    $data['status'] = $status;
    $data['inv'] = $this->Kasir_model->getInvoiceDataByCustId($cust_id)[0];
    $data['url_ori'] = $this->session->flashdata('url_orig');

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar');
    $this->load->view('templates/topbar', $data);
    $this->load->view('kasir/landingStatusInvoice', $data);
    $this->load->view('templates/footer');
  }

  private function _sendUlangInvoiceSMS($contact, $nama, $cust_id)
  {
    $invoice = $this->Kasir_model->getInvoiceDataByCustId($cust_id);
    $msg =
      'Terima kasih ' . ucfirst($invoice[0]['c_nama']) . ' telah berbelanja di Rocketjaket. Invoice anda ' . $invoice[0]['kode_invoice'] . '.' . 'Detail pembelian : ';

    $items = $this->Kasir_model->getInvoiceItemsData($invoice[0]['inv_id']);
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

  public function getViewKatalog($toko_id)
  {
    $datacat = $this->Kasir_model->getCategoryProduct($toko_id);
    $datapdk = $this->Kasir_model->getAllProduct($toko_id);
    $cari = $this->load->view('kasir/displayProdukCardCari', array('kategori' => $datacat, 'produk' => $datapdk));
    $katalog = $this->load->view('kasir/displayProdukCard', array('kategori' => $datacat, 'produk' => $datapdk));
    $html = array(
      'cari' => $cari,
      'katalog' => $katalog
    );
    echo json_encode($html);
  }

  public function tambahPengunjungTidakBeli()
  {
    $data = $this->Kasir_model->tambahPengunjungTidakBeli();
    echo $data;
  }

  public function getProdukCard()
  {
    $cat = $this->Kasir_model->getCategoryProduct($this->session->userdata('toko'));
    $pdk = $this->Kasir_model->getAllProduct($this->session->userdata('toko'));
  }

  public function tes()
  {
    // $now = date('Y-m-d');
    // $toko_id = 2;

    $sql = "
      SELECT total
      FROM invoice
      WHERE tanggal = '2019-10-23' AND toko_id = 2
    ";
    $query = $this->db->query($sql);
    $data_invoice = $query->result_array();
    print_r($data_invoice);
  }
}
