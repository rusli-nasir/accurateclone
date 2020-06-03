<?php
class BarangJasa_model extends CI_Model
{

  public function getTableKategoriBarang()
  {
    $this->db->select('*');
    $this->db->from('persediaan_kategori_barang');
    $this->db->order_by('nama_kategori', 'ASC');
    return $this->db->get()->result_array();
  }

  public function getTableAll()
  {
    $sql = "
    SELECT k.nama_kategori AS kategori, b.kode_barang, b.keterangan, b.tipe_barang, b.id AS id_barang, b.saldo_awal_kuantitas, h.harga1
    FROM persediaan_daftar_barang b
    JOIN persediaan_kategori_barang k
      ON k.id = b.persediaan_kategori_barang_id
    JOIN persediaan_harga_penjualan h
      ON h.persediaan_daftar_barang_id = b.id
    WHERE h.persediaan_form_set_harga_penjualan_id = 0
    ORDER BY k.nama_kategori, b.kode_barang
    ";
    return $this->db->query($sql)->result_array();
  }

  public function tambahKategoriBarang()
  {
    $data = array(
      'nama_kategori' => $_POST['nama_kategori']
    );
    $this->db->insert('persediaan_kategori_barang', $data);

    if ($this->db->affected_rows() == 1)
      return true;
    else
      return false;
  }

  public function getKategoriBarangById($id)
  {
    $this->db->select('*');
    $this->db->from('persediaan_kategori_barang');
    $this->db->where('id', $id);
    return $this->db->get()->row_array();
  }

  public function editKategoriBarang($id)
  {
    $data = array(
      'nama_kategori' => $_POST['nama_kategori']
    );
    $this->db->where('id', $id);
    $this->db->update('persediaan_kategori_barang', $data);

    if ($this->db->affected_rows() == 1)
      return true;
    else
      return false;
  }

  public function hapusKategoriBarang($id)
  {
    $this->db->where('id', $id);
    $this->db->delete('persediaan_kategori_barang');

    if ($this->db->affected_rows() == 1)
      return true;
    else
      return false;
  }

  public function tambahBarangJasa()
  {
    $this->db->trans_begin();
    $data_barang = array(
      'tipe_barang' => $_POST['tipe_barang'],
      'kode_barang' => $_POST['kode_barang'],
      'keterangan' => $_POST['keterangan'],
      'persediaan_kategori_barang_id ' => $_POST['kategori_barang'],
      'default_gudang_id ' => $_POST['gudang_default'],
      'unit' => $_POST['unit'],
      'saldo_awal_kuantitas' => $_POST['kuantitas_saldo_awal'],
      'saldo_awal_harga_per_unit' => $_POST['harga_per_unit_saldo_awal'],
      'saldo_awal_harga_pokok' => $_POST['harga_pokok_saldo_awal'],
      'saldo_awal_gudang_id ' => $_POST['gudang_saldo_awal'],
      'saldo_awal_tanggal' => $_POST['tanggal_saldo_awal']
    );
    $this->db->insert('persediaan_daftar_barang', $data_barang);
    $id_barang = $this->db->insert_id();

    $data_harga = array(
      'persediaan_daftar_barang_id' => $id_barang,
      'harga1' => $_POST['harga_jual'],
      'harga2' => 0,
      'harga3' => 0,
      'diskon' => $_POST['diskon_barang'],
      'persediaan_form_set_harga_penjualan_id' => 0
    );
    $this->db->insert('persediaan_harga_penjualan', $data_harga);

    if ($this->db->trans_status() === FALSE) {
      $this->db->trans_rollback();
      return false;
    } else {
      $this->db->trans_commit();
      return true;
    }
  }

  public function getBarangJasaById($id_barang)
  {
    $sql = "
    SELECT b.id AS id_barang, b.kode_barang, b.keterangan, b.persediaan_kategori_barang_id AS id_kategori_barang, b.default_gudang_id, h.harga1, h.diskon, b.saldo_awal_kuantitas, b.unit, b.saldo_awal_harga_per_unit, b.saldo_awal_harga_pokok, b.saldo_awal_gudang_id, b.saldo_awal_tanggal, b.tipe_barang
    FROM persediaan_daftar_barang b
    JOIN persediaan_kategori_barang k
      ON k.id = b.persediaan_kategori_barang_id
    JOIN persediaan_harga_penjualan h
      ON h.persediaan_daftar_barang_id = b.id
    WHERE h.persediaan_form_set_harga_penjualan_id = 0 AND b.id = $id_barang
    ORDER BY k.nama_kategori ASC
    LIMIT 1
    ";
    return $this->db->query($sql)->row_array();
  }

  public function editBarangJasa($id_barang)
  {
    $sql = "
      SELECT id
      FROM persediaan_harga_penjualan
      WHERE persediaan_daftar_barang_id = $id_barang
      LIMIT 1
    ";
    $id_harga = $this->db->query($sql)->row_array()['id'];

    $this->db->trans_begin();
    $data_barang = array(
      'tipe_barang' => $_POST['tipe_barang'],
      'kode_barang' => $_POST['kode_barang'],
      'keterangan' => $_POST['keterangan'],
      'persediaan_kategori_barang_id ' => $_POST['kategori_barang'],
      'default_gudang_id ' => $_POST['gudang_default'],
      'unit' => $_POST['unit'],
      'saldo_awal_kuantitas' => $_POST['kuantitas_saldo_awal'],
      'saldo_awal_harga_per_unit' => $_POST['harga_per_unit_saldo_awal'],
      'saldo_awal_harga_pokok' => $_POST['harga_pokok_saldo_awal'],
      'saldo_awal_gudang_id ' => $_POST['gudang_saldo_awal'],
      'saldo_awal_tanggal' => $_POST['tanggal_saldo_awal']
    );

    $this->db->where('id', $id_barang);
    $this->db->update('persediaan_daftar_barang', $data_barang);

    $data_harga = array(
      'harga1' => $_POST['harga_jual'],
      'diskon' => $_POST['diskon_barang']
    );
    $this->db->where('id', $id_harga);
    $this->db->update('persediaan_harga_penjualan', $data_harga);

    if ($this->db->trans_status() === FALSE) {
      $this->db->trans_rollback();
      return false;
    } else {
      $this->db->trans_commit();
      return true;
    }
  }

  function hapusBarangJasa($id_barang)
  {
    $this->db->trans_begin();

    $this->db->where('persediaan_daftar_barang_id', $id_barang);
    $this->db->delete('persediaan_harga_penjualan');
    $this->db->where('id', $id_barang);
    $this->db->delete('persediaan_daftar_barang');

    if ($this->db->trans_status() === FALSE) {
      $this->db->trans_rollback();
      return false;
    } else {
      $this->db->trans_commit();
      return true;
    }
  }
}
