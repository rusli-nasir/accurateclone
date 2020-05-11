<?php
class Kasir_model extends CI_Model
{
  public function getCategoryProduct($toko_id)
  {
    $sql = "
    SELECT DISTINCT k.nama, k.class, k.id
    FROM inventory i
    JOIN produk p
      on p.SKU = i.produk_SKU
    JOIN kategori_produk k
      ON k.id = p.kategori_produk_id
    WHERE i.toko_id = $toko_id
    ORDER BY k.id ASC
    ";
    $query = $this->db->query($sql);
    return $query->result_array();
  }

  public function getAllProduct($toko_id)
  {
    $sql = "
    SELECT i.id as inv_id, p.SKU as sku, p.nama, p.foto, p.harga_jual, p.diskon, p.kategori_produk_id as kategori_id, i.tersedia
    FROM inventory i
    JOIN produk p
      ON p.SKU = i.produk_SKU
    WHERE i.toko_id = $toko_id
    ";
    $query = $this->db->query($sql);
    return $query->result_array();
  }

  public function getProductName($sku)
  {
    $sql = "
      SELECT nama
      FROM produk
      WHERE SKU = '$sku'
      LIMIT 1
    ";
    $query = $this->db->query($sql);
    return $query->result_array();
  }

  public function getAllToko()
  {
    return $this->db->get('toko')->result_array();
  }

  public function getInvoiceData($inv_id)
  {
    $sql = "
      SELECT i.time, i.kode_invoice, k.nama as k_nama, i.jenis_pembayaran, t.nama as t_nama, t.alamat as t_alamat, c.nama as c_nama, i.total as grand_total, i.tanggal
      FROM invoice i
      JOIN toko t
        ON t.id = i.toko_id
      JOIN karyawan k
        ON k.username = i.karyawan_username
      JOIN customer c
        ON c.id = i.customer_id
      WHERE i.id = $inv_id
      LIMIT 1
    ";
    $query = $this->db->query($sql);
    return $query->result_array();
  }

  public function getInvoiceDataByCustId($cust_id)
  {
    $sql = "
      SELECT i.id as inv_id, i.tanggal, i.kode_invoice, k.nama as k_nama, i.jenis_pembayaran, t.nama as t_nama, t.alamat as t_alamat, c.nama as c_nama, i.total as grand_total, c.cp, c.email
      FROM invoice i
      JOIN toko t
        ON t.id = i.toko_id
      JOIN karyawan k
        ON k.username = i.karyawan_username
      JOIN customer c
        ON c.id = i.customer_id
      WHERE i.customer_id = $cust_id
      LIMIT 1
    ";
    $query = $this->db->query($sql);
    return $query->result_array();
  }

  public function getInvoiceItemsData($inv_id)
  {
    $sql = "
      SELECT p.SKU as sku, p.nama as nama_pdk, ii.jumlah_pembelian as qty, ii.jumlah_diskon as diskon, ii.subtotal 
      FROM invoice_items ii
      JOIN produk p
        ON p.SKU = ii.produk_SKU
      WHERE invoice_id = $inv_id
    ";
    $query = $this->db->query($sql);
    return $query->result_array();
  }

  public function tambahPengunjungBeli($data)
  {
    $this->db->insert('pengunjung', $data);
    $id = $this->db->insert_id();
    if (!isset($id)) {
      $id = FALSE;
    }

    if ($this->db->affected_rows() == 1) {
      $callback = array(
        'id' => $id,
        'status' => TRUE
      );
      return $callback;
    } else {
      $callback = array(
        'id' => $id,
        'status' => FALSE
      );
      return $callback;
    }
  }

  public function deletePengunjung($id)
  {
    $this->db->where('id', $id);
    $this->db->delete('pengunjung');
  }

  public function tambahCustomer()
  {
    $mode = $this->input->post('contact_mode');

    if ($mode == "email") {
      $data = array(
        'nama' => $this->input->post('nama'),
        'email' => $this->input->post('contact'),
        'cp' => ""
      );
      $this->db->insert('customer', $data);
    } else {
      $data = array(
        'nama' => $this->input->post('nama'),
        'email' => "",
        'cp' => $this->input->post('contact')
      );

      $this->db->insert('customer', $data);
    }
    $id = $this->db->insert_id();
    return (isset($id)) ? $id : FALSE;
  }

  public function getCustomerData($id)
  {
    $sql = "
    SELECT nama, email, cp
    FROM customer 
    WHERE id = $id
    LIMIT 1
    ";
    $query = $this->db->query($sql);
    return $query->result_array();
  }

  public function deleteCustomer($id)
  {
    $this->db->where('id', $id);
    $this->db->delete('customer');
  }

  public function prosesInvoice($cust_id, $total)
  {
    $last_row_invoice = $this->db->select('kode_invoice, tanggal')->order_by('id', "desc")->limit(1)->get('invoice')->row_array();

    if (empty($last_row_invoice)) {
      $iAkhir = 1;
    } else if ($last_row_invoice['tanggal'] == date("Y-m-d")) {
      $iAkhir = (int) explode('/', $last_row_invoice['kode_invoice'])[3];
      $iAkhir++;
    } else {
      $iAkhir = 1;
    }

    $metode = $this->input->post('metode');

    $charset = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $base = strlen($charset);
    $result = '';
    $now = explode(' ', microtime())[1];
    while ($now >= $base) {
      $i = $now % $base;
      $result = $charset[$i] . $result;
      $now /= $base;
    }
    $inv = substr($result, -3);

    $data = array(
      "kode_invoice" => "INV/" . date("dmy") . "/" . $inv . "/" . $iAkhir,
      "toko_id" => $this->input->post('toko_id'),
      "customer_id" => $cust_id,
      "karyawan_username" => $this->session->userdata('uname'),
      "tanggal" => date('Y-m-d'),
      "time" => time(),
      "jenis_pembayaran" => $metode,
      "total" => $total,
      "status" => 0
    );

    $this->db->insert('invoice', $data);

    $id = $this->db->insert_id();
    return (isset($id)) ? $id : FALSE;
  }

  public function deleteInvoice($id)
  {
    $this->db->where('id', $id);
    $this->db->delete('invoice');
  }

  public function getKodeInvoice($inv_id)
  {
    $sql = "
      SELECT kode_invoice as kd_inv
      FROM invoice
      WHERE id = $inv_id
      LIMIT 1
    ";
    $query = $this->db->query($sql);
    return $query->result_array();
  }

  public function updateCustomer($id, $data)
  {
    $this->db->where('id', $id);
    $this->db->update('customer', $data);
  }

  public function updateInventory($sku, $qty, $toko_id)
  {
    $sql = "
    SELECT id, tersedia, minimal
    FROM inventory
    WHERE produk_SKU = '$sku' AND toko_id = $toko_id
    LIMIT 1
    ";
    $query = $this->db->query($sql);
    $tsd = $query->row_array();
    $tsd_bfr = (int) $tsd['tersedia'];
    $qty_beli = (int) $qty;
    $tsd_after = $tsd_bfr - $qty_beli;
    $data = array(
      "tersedia" => $tsd_after
    );
    $this->db->where('id', $tsd['id']);
    $this->db->update('inventory', $data);
    if ($this->db->affected_rows() == 1) {
      $callback = array(
        'id_inv' => $tsd['id'],
        'tsd_bfr' => $tsd_bfr,
        'tsd_after' => $tsd_after,
        'tsd_min' => $tsd['minimal'],
        'sku' => $sku,
        'status' => TRUE
      );
      return $callback;
    } else {
      $callback = array(
        'id_inv' => $tsd['id'],
        'tsd_bfr' => $tsd_bfr,
        'status' => FALSE
      );
      return $callback;
    }
  }

  public function rollbackUpdateInventory($id, $tsd_bfr)
  {
    $data = array(
      "tersedia" => $tsd_bfr
    );
    $this->db->where('id', $id);
    $this->db->update('inventory', $data);
  }

  public function notifikasiProdukLimit($toko_id, $tsd_after, $tsd_min, $sku)
  {
    $sql = "
    SELECT nama
    FROM toko
    WHERE id = $toko_id
    LIMIT 1
    ";
    $query = $this->db->query($sql);
    $toko = $query->row_array();

    $now = time();
    if ($tsd_after == 0) {
      $dscnotif = 'Produk dengan SKU ' . $sku . ' di toko ' . $toko['nama'] . ' stoknya sudah habis.';
      $sql = "
        INSERT INTO notifikasi (waktu, deskripsi, is_baca)
        VALUES ($now, '$dscnotif', 0)
        ";
    } else if ($tsd_after <= $tsd_min) {
      $dscnotif = 'Produk dengan SKU ' . $sku . ' di toko ' . $toko['nama'] . ' telah mencapai batas minimal produk. Sekarang hanya tersedia ' . $tsd_after . ' unit dengan batas minimal ' . $tsd_min . '.';
      $sql = "
        INSERT INTO notifikasi (waktu, deskripsi, is_baca)
        VALUES ($now, '$dscnotif', 0)
        ";
    }
    $this->db->query($sql);
  }

  public function prosesInvoiceDetails($data)
  {
    $this->db->insert('invoice_items', $data);
    $id = $this->db->insert_id();
    if (!isset($id)) {
      $id = FALSE;
    }
    if ($this->db->affected_rows() == 1) {
      $callback = array(
        'id' => $id,
        'status' => TRUE
      );
      return $callback;
    } else {
      $callback = array(
        'id' => $id,
        'status' => FALSE
      );
      return $callback;
    }
  }

  public function deleteInvoiceDetails($id)
  {
    $this->db->where('id', $id);
    $this->db->delete('invoice_items');
  }

  public function tambahPengunjungTidakBeli()
  {
    $tk_id = $this->input->post('toko_id');
    $data = array(
      'tanggal' => date('Y/m/d'),
      'is_beli' => 0,
      'toko_id' => $tk_id
    );
    $this->db->insert('pengunjung', $data);

    return $this->getPengunjungTidakBeli($tk_id);
  }

  public function getPengunjungTidakBeli($toko_id)
  {
    $now = date('Y/m/d');
    $sql = "
      SELECT COUNT(*) as tdk_beli
      FROM pengunjung
      WHERE tanggal = '$now' AND is_beli = 0 AND toko_id = '$toko_id'
    ";
    $query = $this->db->query($sql);
    $data = $query->result_array();
    return $data[0]['tdk_beli'];
  }

  public function getLaporanHariIni($toko_id)
  {
    $now = date('Y-m-d');
    $sql = "SELECT total FROM invoice WHERE tanggal = '$now' AND toko_id = $toko_id";
    $query = $this->db->query($sql);
    $data_invoice = $query->result_array();

    $transaksi = 0;
    $omset = 0;
    foreach ($data_invoice as $y) {
      $omset = $omset + $y['total'];
      $transaksi++;
    }
    $omset = 'Rp ' . number_format($omset, 0, ',', '.');

    $sql = "
      SELECT jumlah_pembelian
      FROM invoice_items
      WHERE invoice_id IN (
          SELECT id
          FROM invoice
          WHERE tanggal = '$now' AND toko_id = $toko_id
      )
    ";
    $query = $this->db->query($sql);
    $data_items = $query->result_array();

    $jml_brg = 0;
    if (!empty($data_items)) {
      foreach ($data_items as $x) {
        $jml_brg = $jml_brg + $x['jumlah_pembelian'];
      }
    }
    $x = array(
      'omset' => $omset,
      'transaksi' => $transaksi,
      'jml_brg' => $jml_brg
    );

    return $x;
  }
}
