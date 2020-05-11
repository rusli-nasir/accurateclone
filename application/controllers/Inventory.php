<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Inventory extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    //validasi jika user belum login
    if ($this->session->userdata('role') > 3) {
      $url_kasir = base_url('Kasir');
      redirect($url_kasir);
    }

    if (!$this->session->userdata('masuk')) {
      $url = base_url();
      redirect($url);
    } else {
      $this->load->model('Inventory_model');
      $this->load->model('Notifikasi_model');
    }
  }

  public function index()
  {
    $this->load->library('cart');
    $this->cart->destroy();
    $data['title'] = "Inventory";
    $data['not_read'] = $this->Notifikasi_model->getNotRead();
    $this->load->model('Toko_model');
    $this->load->model('Inventory_model');
    $data['model'] = $this->Toko_model->viewTable();
    $data['inv'] = $this->Inventory_model->viewTable(1);
    $data['toko_id'] = 1;

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar');
    $this->load->view('templates/topbar', $data);
    $this->load->view('inventory/index', $data);
    $this->load->view('templates/footer');
  }

  public function index2($toko_id)
  {
    $data['title'] = "Inventory";
    $data['not_read'] = $this->Notifikasi_model->getNotRead();
    $this->load->model('Toko_model');
    $this->load->model('Inventory_model');
    $data['model'] = $this->Toko_model->viewTable();
    $data['inv'] = $this->Inventory_model->viewTable($toko_id);
    $data['toko_id'] = $toko_id;
    $data['nama_toko'] = $this->Toko_model->getNamaToko($toko_id);

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar');
    $this->load->view('templates/topbar', $data);
    $this->load->view('inventory/index2', $data);
    $this->load->view('templates/footer');
  }

  public function tambahInventory($toko)
  {
    if ($this->Inventory_model->validation()) {
      $this->Inventory_model->save($toko);
      $this->session->set_flashdata('suksesInventory', '<div class="alert alert-success alert-dismissible fade show mt-4 mb-4" role="alert" style="margin: 0">Produk berhasil ditambahkan ke dalam inventory!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
      redirect('Inventory/index2/' . $toko);
    } else {
      $data['title'] = "Tambah Inventory";
      $data['not_read'] = $this->Notifikasi_model->getNotRead();
      $this->load->model('Toko_model');
      if ($toko == 1) {
        $data['status_gudang'] = 1;
        $data['produk_cari'] = $this->Inventory_model->getDataPencarianGudang($toko);
      } else {
        $data['status_gudang'] = 0;
        $data['produk_cari'] = $this->Inventory_model->getDataPencarianToko($toko);
      }
      $data['nama_toko'] = $this->Toko_model->getNamaToko($toko);
      $data['toko_id'] = $toko;

      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar');
      $this->load->view('templates/topbar', $data);
      $this->load->view('inventory/tambahInventory', $data);
      $this->load->view('templates/footer');
    }
  }

  public function editInventory($id_inventory, $toko_id)
  {
    if ($this->Inventory_model->validation()) {
      $this->Inventory_model->update($id_inventory, $toko_id);
      $this->session->set_flashdata('suksesInventory', '<div class="alert alert-success alert-dismissible fade show mt-4 mb-4" role="alert" style="margin: 0">Data inventory produk berhasil di-edit!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
      redirect('Inventory/index2/' . $toko_id);
    } else {
      $data['title'] = "Edit Inventory";
      $data['not_read'] = $this->Notifikasi_model->getNotRead();
      $this->load->model('Produk_model');
      $this->load->model('Toko_model');
      $data['model'] = $this->Produk_model->viewTable();
      $data['inside'] = $this->Inventory_model->getDataInventory($id_inventory);
      if ($toko_id == 1) {
        $data['status_gudang'] = 1;
      } else {
        $data['status_gudang'] = 0;
      }
      $jml = $this->Inventory_model->getJumlahGudang($data['inside'][0]['sku']);
      $data['jml_tersedia'] = $jml['tersedia'];

      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar');
      $this->load->view('templates/topbar', $data);
      $this->load->view('inventory/editInventory', $data);
      $this->load->view('templates/footer');
    }
  }

  public function delete($id_inventory, $toko_id)
  {
    $this->Inventory_model->delete($id_inventory); // Panggil fungsi delete() yang ada di SiswaModel.php
    $this->session->set_flashdata('suksesInventory', '<div class="alert alert-danger alert-dismissible fade show mt-4 mb-4" role="alert" style="margin: 0">Data inventory produk berhasil di-hapus!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    redirect('Inventory/index2/' . $toko_id);
  }

  public function getViewTable($toko_id)
  {
    $this->load->model('Inventory_model');
    $data = $this->Inventory_model->viewTable($toko_id);
    $html = $this->load->view('inventory/viewTable', array('inv' => $data, 'toko_id' => $toko_id));
    echo json_encode($html);
  }

  public function cekProdukSama($sku)
  {
    $tes = $this->Inventory_model->getDataInventoryBySKU($sku);

    if (empty($tes)) {
      $callback = array(
        'status' => 'kosong'
      );
    } else {
      $callback = array(
        'status' => 'isi',
        'id' => $tes[0]['id']
      );
    }
    echo json_encode($callback);
  }

  public function tes()
  {
    $tes = $this->Inventory_model->tes();
    echo $tes;
  }

  public function cekDelete($id_inv)
  {
    $get_sku = $this->Inventory_model->getDataInventory($id_inv);
    $tes = $this->Inventory_model->cekAnySelainGudang($get_sku[0]['sku']);
    $html = $this->load->view('inventory/alertDeleteGudang', array('model' => $tes), true);

    if (empty($tes)) {
      $data = array(
        'status' => 'safe'
      );
    } else {
      $data = array(
        'status' => 'danger',
        'html' => $html
      );
    }

    echo json_encode($data);
  }

  public function dataTables($mode)
  {
    $search = $_POST['search']['value']; // Ambil data yang di ketik user pada textbox pencarian
    $limit = $_POST['length']; // Ambil data limit per page
    $start = $_POST['start']; // Ambil data start
    $order_index = $_POST['order'][0]['column']; // Untuk mengambil index yg menjadi acuan untuk sorting
    $order_field = $_POST['columns'][$order_index]['data']; // Untuk mengambil nama field yg menjadi acuan untuk sorting
    $order_ascdesc = $_POST['order'][0]['dir']; // Untuk menentukan order by "ASC" atau "DESC"

    $sql_total = $this->Inventory_model->count_all($mode); // Panggil fungsi count_all pada SiswaModel
    $sql_data = $this->Inventory_model->filter($search, $limit, $start, $order_field, $order_ascdesc, $mode); // Panggil fungsi filter pada SiswaModel
    $sql_filter = $this->Inventory_model->count_filter($search, $mode); // Panggil fungsi count_filter pada SiswaModel

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
