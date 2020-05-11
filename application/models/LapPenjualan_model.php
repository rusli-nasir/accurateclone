<?php
class LapPenjualan_model extends CI_Model
{
  protected $table = 'invoice';

  public function viewTable()
  {
    $sql = "
    SELECT i.id, i.kode_invoice, t.nama AS t_nama, c.nama, k.username, i.jenis_pembayaran, i.total, i.status
    FROM invoice i
    JOIN  customer c
      ON i.customer_id = c.id
    JOIN karyawan k
      ON i.karyawan_username = k.username
    JOIN toko t
      ON t.id = i.toko_id
    ";
    $query = $this->db->query($sql);
    return $query->result();
  }

  public function viewTableByToko($toko_id)
  {
    $sql = "
    SELECT i.id, i.kode_invoice, t.nama AS t_nama, c.nama, k.username, i.jenis_pembayaran, i.total, i.status
    FROM invoice i
    JOIN  customer c
      ON i.customer_id = c.id
    JOIN karyawan k
      ON i.karyawan_username = k.username
    JOIN toko t
      ON t.id = i.toko_id
    WHERE t.id = $toko_id
    ";
    $query = $this->db->query($sql);
    return $query->result();
  }

  public function getDataInvoice($inv_id)
  {
    $sql = "
    SELECT i.id as inv_id, i.kode_invoice, t.nama as t_nama, c.nama as c_nama, k.nama as k_nama, i.jenis_pembayaran, i.total, i.time, c.email, c.cp, i.status
    FROM invoice i
    JOIN  customer c
      ON i.customer_id = c.id
    JOIN karyawan k
      ON i.karyawan_username = k.username
    JOIN toko t
      ON i.toko_id = t.id
    WHERE i.id = $inv_id
    LIMIT 1
    ";
    $query = $this->db->query($sql);
    return $query->result_array();
  }

  public function getDataInvoiceItems($inv_id)
  {
    $sql = "
    SELECT i.id, i.produk_SKU AS sku, i.harga, i.jumlah_pembelian AS qty, i.jumlah_diskon AS diskon, i.subtotal, i.status
    FROM invoice_items i
    WHERE invoice_id = $inv_id
    ";
    $query = $this->db->query($sql);
    return $query->result_array();
  }

  public function getAllToko()
  {
    $sql = "
    SELECT id, nama
    FROM toko
    WHERE
      id != 1
    ";
    $query = $this->db->query($sql);
    return $query->result_array();
  }

  public function getNamaToko($id)
  {
    $sql = "
    SELECT nama
    FROM toko
    WHERE
      id = $id
    ";
    $query = $this->db->query($sql);
    return $query->result_array();
  }

  public function getDataCustomerByInv($inv_id)
  {
    $sql = "
    SELECT *
    FROM customer c
    WHERE id IN (
      SELECT customer_id
        FROM invoice
        WHERE id = $inv_id
    )
    ";
    $query = $this->db->query($sql);
    return $query->result_array();
  }

  public function getKodeInvoiceById($inv_id)
  {
    $sql = "
      SELECT kode_invoice
      FROM invoice
      WHERE id = $inv_id
      LIMIT 1
    ";
    $query = $this->db->query($sql);
    return $query->result_array();
  }

  public function updateContactCustomer($cust_id, $mode, $data)
  {
    $sql = "
      SELECT *
      FROM customer
      WHERE id = $cust_id
      LIMIT 1
    ";
    $data_cust = $this->db->query($sql)->result_array()[0];

    if ($mode == 'email' && !empty($data_cust['email'])) {
      $this->db->where('id', $cust_id);
      $this->db->update('customer', $data);
    } else if ($mode == 'sms' && !empty($data_cust['cp'])) {
      $this->db->where('id', $icust_idd);
      $this->db->update('customer', $data);
    } else if ($mode == 'email' && empty($data_cust['email'])) {
      $data['cp'] = '';
      $this->db->where('id', $cust_id);
      $this->db->update('customer', $data);
    } else if ($mode == 'sms' && empty($data_cust['cp'])) {
      $data['email'] = '';
      $this->db->where('id', $cust_id);
      $this->db->update('customer', $data);
    }
  }

  public function getInvoiceDataByInvId($inv_id)
  {
    $sql = "
      SELECT i.kode_invoice, c.nama as c_nama, c.cp as c_cp, c.email as c_email, i.tanggal
      FROM invoice i
      JOIN customer c
        ON c.id = i.customer_id
      WHERE i.id = $inv_id
      LIMIT 1
    ";
    $query = $this->db->query($sql);
    return $query->result_array();
  }

  public function getQtyBarangInvoiceById($id)
  {
    $sql = "SELECT jumlah_pembelian as qty FROM invoice_items WHERE id=$id LIMIT 1";
    $query = $this->db->query($sql);
    return $query->result_array();
  }

  public function prosesRefund($inv_id, $data, $is_refund_all)
  {
    $sql = "SELECT toko_id FROM invoice WHERE id = $inv_id LIMIT 1";
    $toko_id = $this->db->query($sql)->result_array()[0]['toko_id'];
    $is_do_refund = 0;

    foreach ($data as $x) {
      if ($x['jml_refund'] > 0) {
        $id = $x['id'];
        $sql = "SELECT * FROM invoice_items WHERE id = $id LIMIT 1";
        $data_inv_dtl = $this->db->query($sql)->result_array()[0];

        if ($x['jml_refund'] < $data_inv_dtl['jumlah_pembelian']) {
          $final_qty = $data_inv_dtl['jumlah_pembelian'] - $x['jml_refund'];

          $diskon_persatuan =  $data_inv_dtl['jumlah_diskon'] / $data_inv_dtl['jumlah_pembelian'];
          $diskon_final = $final_qty * $diskon_persatuan;

          $subtotal_persatuan = $data_inv_dtl['subtotal'] / $data_inv_dtl['jumlah_pembelian'];
          $subtotal_final = $subtotal_persatuan * $final_qty;

          $data_update = array(
            "jumlah_pembelian" => $final_qty,
            "jumlah_diskon" => $diskon_final,
            "subtotal" => $subtotal_final
          );
          $this->db->where('id', $id);
          $this->db->update('invoice_items', $data_update);

          $data_insert = array(
            'invoice_id' => $inv_id,
            'produk_SKU' => $data_inv_dtl['produk_SKU'],
            'harga' => $data_inv_dtl['harga'],
            'jumlah_pembelian' => $x['jml_refund'],
            'jumlah_diskon' => 0,
            'subtotal' => 0,
            'status' => 1
          );
          $this->db->insert('invoice_items', $data_insert);
        } else if ($x['jml_refund'] == $data_inv_dtl['jumlah_pembelian']) {
          $data_update = array(
            "jumlah_pembelian" => 0,
            "jumlah_diskon" => 0,
            "subtotal" => 0,
            'status' => 2
          );

          $this->db->where('id', $id);
          $this->db->update('invoice_items', $data_update);
        }

        $qty_update_inventory = $x['jml_refund'];
        $sku_update_inventory = $data_inv_dtl['produk_SKU'];
        $sql = "SELECT id, tersedia FROM inventory WHERE produk_SKU = $sku_update_inventory AND toko_id = $toko_id LIMIT 1";
        $query_inventory = $this->db->query($sql);
        $data_inventory = $query_inventory->result_array()[0];
        $inventory_bfr = $data_inventory['tersedia'];
        $inventory_after = $inventory_bfr + $qty_update_inventory;
        $data_update = array(
          'tersedia' => $inventory_after

        );
        $this->db->where('id', $data_inventory['id']);
        $this->db->update('inventory', $data_update);

        $is_do_refund = 1;
      }
    }

    if ($is_do_refund == 1) {

      if ($is_refund_all == 1) {
        $data_update = array(
          'total' => 0,
          'status' => 2
        );
      } else {
        $grand_total_update = 0;
        $sql = "SELECT * FROM invoice_items WHERE invoice_id = $inv_id AND status = 0";
        $data_brg = $this->db->query($sql)->result_array();
        foreach ($data_brg as $x) {
          $grand_total_update = $grand_total_update + $x['subtotal'];
        }
        $data_update = array(
          'status' => 1,
          'total' => $grand_total_update
        );
      }
      $this->db->where('id', $inv_id);
      $this->db->update('invoice', $data_update);

      return true;
    }
  }

  public function getStatusInv($inv_id)
  {
    $sql = "SELECT status, tanggal FROM invoice WHERE id = $inv_id LIMIT 1";
    return $this->db->query($sql)->result_array()[0];
  }

  public function filter($search, $limit, $start, $order_field, $order_ascdesc, $mode, $tgl_start, $tgl_end)
  {
    $this->db->select('i.id, i.kode_invoice, k.nama AS k_nama, i.jenis_pembayaran, i.total, i.status, c.nama AS c_nama, t.nama AS t_nama, i.time');
    $this->db->from('invoice i');
    $this->db->join('customer c', 'c.id = i.customer_id');
    $this->db->join('toko t', 't.id = i.toko_id');
    $this->db->join('karyawan k', 'k.username = i.karyawan_username');

    if ($mode != "all") {
      $this->db->where('i.toko_id', $mode);
    }

    $this->db->group_start();
    $this->db->like('i.kode_invoice', $search); // Untuk menambahkan query where LIKE
    $this->db->or_like('i.karyawan_username', $search); // Untuk menambahkan query where OR LIKE
    $this->db->or_like('c.nama', $search); // Untuk menambahkan query where OR LIKE
    $this->db->or_like('t.nama', $search); // Untuk menambahkan query where OR LIKE
    $this->db->group_end();

    if ($tgl_start != 'all' || $tgl_end != 'all') {
      $this->db->group_start();
      $where = "i.tanggal >= '$tgl_start' AND i.tanggal <= '$tgl_end'";
      $this->db->where($where);
      $this->db->group_end();
    }

    $this->db->order_by($order_field, $order_ascdesc); // Untuk menambahkan query ORDER BY
    $this->db->limit($limit, $start); // Untuk menambahkan query LIMIT

    // $results = $this->db->get_compiled_select();

    $results = $this->db->get()->result_array();
    $i = 0;
    foreach ($results as $x) {
      $results[$i]['time'] = date('d-m-y H:i:s', $x['time']);
      $i++;
    }

    return $results; // Eksekusi query sql sesuai kondisi diatas
  }

  public function count_all($mode, $tgl_start, $tgl_end)
  {
    $this->db->from('invoice');
    if ($mode != "all" && ($tgl_start != 'all' || $tgl_end != 'all')) {
      $this->db->where('toko_id', $mode);
      $this->db->group_start();
      $where = "tanggal >= '$tgl_start' AND tanggal <= '$tgl_end'";
      $this->db->where($where);
      $this->db->group_end();
    } else if ($mode == 'all' && ($tgl_start != 'all' || $tgl_end != 'all')) {
      $where = "tanggal >= '$tgl_start' AND tanggal <= '$tgl_end'";
      $this->db->where($where);
    } else if ($mode != 'all' && ($tgl_start == 'all' || $tgl_end == 'all')) {
      $this->db->where('toko_id', $mode);
    }
    return $this->db->get()->num_rows(); // Untuk menghitung semua data siswa
  }

  public function count_filter($search, $mode, $tgl_start, $tgl_end)
  {
    $this->db->select('i.id');
    $this->db->from('invoice i');
    $this->db->join('customer c', 'c.id = i.customer_id');
    $this->db->join('toko t', 't.id = i.toko_id');

    if ($mode != "all") {
      $this->db->where('i.toko_id', $mode);
    }

    $this->db->group_start();
    $this->db->like('i.kode_invoice', $search); // Untuk menambahkan query where LIKE
    $this->db->or_like('i.karyawan_username', $search); // Untuk menambahkan query where OR LIKE
    $this->db->or_like('c.nama', $search); // Untuk menambahkan query where OR LIKE
    $this->db->or_like('t.nama', $search); // Untuk menambahkan query where OR LIKE
    $this->db->group_end();

    if ($tgl_start != 'all' || $tgl_end != 'all') {
      $this->db->group_start();
      $where = "i.tanggal >= '$tgl_start' AND i.tanggal <= '$tgl_end'";
      $this->db->where($where);
      $this->db->group_end();
    }

    return $this->db->get()->num_rows(); // Untuk menghitung jumlah data sesuai dengan filter pada textbox pencarian
  }
}
