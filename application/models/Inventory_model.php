<?php
class Inventory_model extends CI_Model
{
  protected $table = 'inventory';

  public function getDataInventory($id_inventory)
  {
    $sql = "
    SELECT i.id, i.produk_SKU AS sku, i.tersedia, i.minimal, i.toko_id, t.nama AS nama_toko
    FROM inventory i
    JOIN  produk p
      ON i.produk_SKU = p.SKU
    JOIN toko t
      ON i.toko_id = t.id
    WHERE
      i.id = $id_inventory
    LIMIT 1
    ";
    $query = $this->db->query($sql);
    return $query->result_array();
  }

  public function getDataInventoryBySKU($sku)
  {
    $sql = "
    SELECT i.id, i.produk_SKU
    FROM inventory i
    WHERE
      i.produk_SKU = '$sku'
    LIMIT 1
    ";
    $query = $this->db->query($sql);
    return $query->result_array();
  }

  public function getDataPencarianGudang($gudang)
  {
    $sql = "
      SELECT p.SKU, p.nama, p.foto
      FROM produk p
      WHERE SKU NOT IN
        (
          SELECT produk_SKU
            FROM inventory
            WHERE toko_id = $gudang
        )
    ";
    $query = $this->db->query($sql);
    return $query->result_array();
  }

  public function getDataPencarianToko($toko_id)
  {
    $sql = "
      SELECT i.produk_SKU as SKU, p.nama, p.foto, p.kategori_produk_id as kategori, i.tersedia
      FROM inventory i
      JOIN produk p
        ON i.produk_SKU = p.SKU
      WHERE i.toko_id = 1 AND i.produk_SKU NOT IN (SELECT produk_SKU from inventory WHERE toko_id = $toko_id)
    ";
    $query = $this->db->query($sql);
    return $query->result_array();
  }

  public function getJumlahGudang($sku)
  {
    $sql = "
    SELECT tersedia
    FROM inventory
    WHERE toko_id = 1 AND produk_SKU = '$sku'
    LIMIT 1
    ";
    $query = $this->db->query($sql);
    return $query->row_array();
  }

  public function viewTable($toko_id)
  {
    $sql = "
    SELECT p.nama AS nama_produk, i.produk_SKU AS sku, i.tersedia, i.minimal, t.nama AS nama_toko, p.foto, i.id AS id_inv
    FROM inventory i
    JOIN  produk p
      ON i.produk_SKU = p.SKU
    JOIN toko t
      ON i.toko_id = t.id
    WHERE
      i.toko_id = $toko_id
    ";
    $query = $this->db->query($sql);
    return $query->result_array();
  }

  public function validation()
  {
    $this->form_validation->set_rules('input_sku', 'SKU', "trim|required");
    $this->form_validation->set_rules('input_tersedia', 'Jumlah Tersedia', 'required');
    $this->form_validation->set_rules('input_minimal', 'Jumlah Minimal', 'required');

    if ($this->form_validation->run()) // Jika validasi benar
      return true; // Maka kembalikan hasilnya dengan TRUE
    else // Jika ada data yang tidak sesuai validasi
      return false; // Maka kembalikan hasilnya dengan FALSE
  }

  public function save($toko)
  {
    $data = array(
      "produk_SKU" => $this->input->post('input_sku'),
      "tersedia" => $this->input->post('input_tersedia'),
      "minimal" => $this->input->post('input_minimal'),
      "toko_id" => $toko
    );

    $this->db->insert($this->table, $data); // Untuk mengeksekusi perintah insert data

    if ($toko != 1) {
      $tsdBfr = (int) $this->input->post('input_tersedia_gudang');
      $tsdAdd = (int) $data['tersedia'];
      $update_tsd = $tsdBfr - $tsdAdd;
      $sku = $data['produk_SKU'];
      $sql = "
        UPDATE inventory
        SET tersedia = $update_tsd
        WHERE toko_id = 1 AND produk_SKU = '$sku'
      ";
      $this->db->query($sql);
    }
  }

  public function update($id, $toko_id)
  {
    if ($toko_id != 1) {
      $min = $this->input->post('input_minimal');
      $tsd_bfr = (int) $this->input->post('input_tersedia_bfr');
      $tsd_after = (int) $this->input->post('input_tersedia');
      $sku = $this->input->post('input_sku');

      $sql = "
        UPDATE inventory
        SET tersedia = $tsd_after, minimal = $min
        WHERE toko_id = $toko_id AND id = $id
      ";
      $this->db->query($sql);

      $tsd_selisih = $tsd_after - $tsd_bfr;
      $tsd_gudang = (int) $this->input->post('input_tersedia_gudang');
      $tsd_update = $tsd_gudang - $tsd_selisih;

      $sql = "
        UPDATE inventory
        SET tersedia = $tsd_update
        WHERE toko_id = 1 AND produk_SKU = '$sku'
      ";
      $this->db->query($sql);
    } else {
      $data = array(
        "tersedia" => $this->input->post('input_tersedia')
      );
      $this->db->where('id', $id);
      $this->db->update('inventory', $data);
    }
  }

  public function delete($id)
  {
    $this->db->where('id', $id);
    $this->db->delete($this->table); // Untuk mengeksekusi perintah delete data
  }

  public function cekAnySelainGudang($sku)
  {
    $sql = "
      SELECT t.nama
      FROM inventory i
      JOIN toko t
        ON t.id = i.toko_id
      WHERE produk_SKU = '$sku' AND toko_id NOT IN (1)
    ";
    return $this->db->query($sql)->result_array();
  }

  public function filter($search, $limit, $start, $order_field, $order_ascdesc, $mode)
  {
    $this->db->select(array("ROW_NUMBER() OVER (ORDER BY $order_field) AS num", 'i.id', 'p.SKU as sku', 'p.nama as p_nama', 'i.tersedia', 'i.minimal', 't.nama AS t_nama', 't.id as t_id'));
    $this->db->from('inventory i');
    $this->db->join('produk p', 'p.SKU = i.produk_SKU');
    $this->db->join('toko t', 't.id = i.toko_id');

    if ($mode != "all") {
      $this->db->where('i.toko_id', $mode);
    }

    $this->db->group_start();
    $this->db->like('p.SKU', $search); // Untuk menambahkan query where LIKE
    $this->db->or_like('p.nama', $search); // Untuk menambahkan query where OR LIKE
    $this->db->or_like('t.nama', $search); // Untuk menambahkan query where OR LIKE
    $this->db->group_end();

    $this->db->order_by($order_field, $order_ascdesc); // Untuk menambahkan query ORDER BY
    $this->db->limit($limit, $start); // Untuk menambahkan query LIMIT

    // $results = $this->db->get_compiled_select();

    $results = $this->db->get()->result_array();

    $i = 0;
    foreach ($results as $x) {
      $results[$i]['url'] = base_url('Inventory/editInventory/') . $x['id'] . '/' . $x['t_id'];
      $i++;
    }

    return $results; // Eksekusi query sql sesuai kondisi diatas
  }

  public function count_all($mode)
  {
    $this->db->from('inventory i');
    if ($mode != 'all') {
      $this->db->where('toko_id', $mode);
    }
    return $this->db->get()->num_rows(); // Untuk menghitung semua data siswa
  }

  public function count_filter($search, $mode)
  {
    $this->db->select('i.id');
    $this->db->from('inventory i');
    $this->db->join('produk p', 'p.SKU = i.produk_SKU');
    $this->db->join('toko t', 't.id = i.toko_id');

    if ($mode != "all") {
      $this->db->where('i.toko_id', $mode);
    }

    $this->db->group_start();
    $this->db->like('p.SKU', $search); // Untuk menambahkan query where LIKE
    $this->db->or_like('p.nama', $search); // Untuk menambahkan query where OR LIKE
    $this->db->or_like('t.nama', $search); // Untuk menambahkan query where OR LIKE
    $this->db->group_end();

    return $this->db->get()->num_rows(); // Untuk menghitung jumlah data sesuai dengan filter pada textbox pencarian
  }
}
