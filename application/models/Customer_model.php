<?php
class Customer_model extends CI_Model
{
  public function getCustomerByToko($toko_id)
  {
    $sql = "
      SELECT c.nama, c.cp, c.email, i.time
      FROM customer c
      JOIN invoice i
        ON i.customer_id = c.id
      WHERE i.toko_id = $toko_id
    ";
    return $this->db->query($sql)->result_array();
  }

  public function filter($search, $limit, $start, $order_field, $order_ascdesc, $mode, $tgl_start, $tgl_end, $view_mode)
  {
    $this->db->select(array("ROW_NUMBER() OVER (ORDER BY $order_field) AS num", 'c.nama', 'c.email', 'c.cp', 'i.time', 't.nama as t_nama'));
    $this->db->from('invoice i');
    $this->db->join('customer c', 'c.id = i.customer_id');
    $this->db->join('toko t', 't.id = i.toko_id');

    if ($mode != "all") {
      $this->db->where('i.toko_id', $mode);
    }

    $this->db->group_start();
    $this->db->like('c.nama', $search); // Untuk menambahkan query where LIKE
    $this->db->or_like('c.email', $search); // Untuk menambahkan query where OR LIKE
    $this->db->or_like('c.cp', $search); // Untuk menambahkan query where OR LIKE
    $this->db->group_end();

    if ($tgl_start != 'all' || $tgl_end != 'all') {
      $this->db->group_start();
      $where = "i.tanggal >= '$tgl_start' AND i.tanggal <= '$tgl_end'";
      $this->db->where($where);
      $this->db->group_end();
    }

    if ($view_mode == 'email') {
      $this->db->group_start();
      $where = "c.email != ''";
      $this->db->where($where);
      $this->db->group_end();
    } else if ($view_mode == 'cp') {
      $this->db->group_start();
      $where = "c.cp != ''";
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

  public function count_all($mode, $tgl_start, $tgl_end, $view_mode)
  {
    $this->db->select('c.id');
    $this->db->from('invoice i');
    $this->db->join('customer c', 'c.id = i.customer_id');
    $this->db->join('toko t', 't.id = i.toko_id');
    if ($mode != "all" && ($tgl_start != 'all' || $tgl_end != 'all')) {
      $this->db->where('t.id', $mode);
      $this->db->group_start();
      $where = "i.tanggal >= '$tgl_start' AND i.tanggal <= '$tgl_end'";
      $this->db->where($where);
      $this->db->group_end();
    } else if ($mode == 'all' && ($tgl_start != 'all' || $tgl_end != 'all')) {
      $where = "i.tanggal >= '$tgl_start' AND i.tanggal <= '$tgl_end'";
      $this->db->where($where);
    } else if ($mode != 'all' && ($tgl_start == 'all' || $tgl_end == 'all')) {
      $this->db->where('i.id', $mode);
    }
    return $this->db->get()->num_rows(); // Untuk menghitung semua data siswa
  }

  public function count_filter($search, $mode, $tgl_start, $tgl_end, $view_mode)
  {
    $this->db->select('i.id');
    $this->db->from('invoice i');
    $this->db->join('customer c', 'c.id = i.customer_id');
    $this->db->join('toko t', 't.id = i.toko_id');

    if ($mode != "all") {
      $this->db->where('i.toko_id', $mode);
    }

    $this->db->group_start();
    $this->db->like('c.nama', $search); // Untuk menambahkan query where LIKE
    $this->db->or_like('c.email', $search); // Untuk menambahkan query where OR LIKE
    $this->db->or_like('c.cp', $search); // Untuk menambahkan query where OR LIKE
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
