<?php
class BarangJasa_model extends CI_Model
{
  public function getTableGudang()
  {
    $this->db->select('*');
    $this->db->from('persediaan_daftar_gudang');
    $this->db->order_by('nama_gudang', 'ASC');
    return $this->db->get()->result_array();
  }

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
      SELECT k.nama_kategori AS kategori, b.kode_barang, b.keterangan, b.tipe_barang, b.id AS id_barang, b.saldo_awal_kuantitas
      FROM persediaan_daftar_barang b
      JOIN persediaan_kategori_barang k
        ON k.id = b.persediaan_kategori_barang_id
      ORDER BY k.nama_kategori, b.kode_barang
    ";
    $data_barang = $this->db->query($sql)->result_array();

    $data_barang = $this->_getHargaJualTerbaru($data_barang);
    $data_barang = $this->_getStokBarangTerbaru($data_barang);

    return $data_barang;
  }

  private function _getHargaJualTerbaru($list_barang)
  {
    $i = 0;
    foreach ($list_barang as $data_barang) {
      $id_barang = $data_barang['id_barang'];
      $sql = "
        SELECT h.harga_jual
        FROM persediaan_form_set_harga_penjualan f
        JOIN persediaan_harga_penjualan h
          ON f.id = h.persediaan_form_set_harga_penjualan_id
        WHERE h.persediaan_daftar_barang_id = $id_barang
        ORDER BY f.id DESC
        LIMIT 1
      ";
      $temp = $this->db->query($sql)->row_array();

      if (empty($temp)) {
        $this->db->select('harga_jual');
        $this->db->from('persediaan_daftar_barang');
        $this->db->where('id', $id_barang);
        $temp = $this->db->get()->row_array();
      }

      $list_barang[$i]['harga_jual'] = $temp['harga_jual'];
      $i++;
    }
    return $list_barang;
  }

  private function _getStokBarangTerbaru($list_barang)
  {
    $i = 0;
    foreach ($list_barang as $data_barang) {
      $id_barang = $data_barang['id_barang'];

      $this->db->select('SUM(stok) AS total_stok');
      $this->db->from('persediaan_stok_barang');
      $this->db->where('persediaan_daftar_barang_id', $id_barang);
      $total_stok = $this->db->get()->row_array();

      $list_barang[$i]['stok'] = $data_barang['saldo_awal_kuantitas'] + $total_stok['total_stok'];
      $i++;
    }
    return $list_barang;
  }

  public function getBarangPerGudang()
  {
    $list_gudang = $this->getTableGudang();
    $this->db->select('id, kode_barang, keterangan, saldo_awal_kuantitas, saldo_awal_gudang_id ');
    $this->db->from('persediaan_daftar_barang');
    $this->db->order_by('kode_barang', 'ASC');
    $list_barang = $this->db->get()->result_array();

    $barang_per_gudang = array();

    $i = 0;
    foreach ($list_barang as $barang) {
      $barang_per_gudang[$i]['kode_barang'] = $barang['kode_barang'];
      $barang_per_gudang[$i]['keterangan'] = $barang['keterangan'];
      foreach ($list_gudang as $gudang) {
        $total_stok = 0;
        if ($gudang['id'] == $barang['saldo_awal_gudang_id'])
          $total_stok += $barang['saldo_awal_kuantitas'];

        $this->db->select('SUM(stok) AS total_stok');
        $this->db->from('persediaan_stok_barang');
        $where = array(
          'persediaan_daftar_barang_id' => $barang['id'],
          'persediaan_daftar_gudang_id' => $gudang['id']
        );
        $this->db->where($where);
        $temp_stok = $this->db->get()->row_array();
        $total_stok += $temp_stok['total_stok'];

        $barang_per_gudang[$i]['stok_per_gudang'][$gudang['nama_gudang']] = $total_stok;
      }
      $i++;
    }
    return $barang_per_gudang;
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
      'saldo_awal_tanggal' => $_POST['tanggal_saldo_awal'],
      'harga_jual' => $_POST['harga_jual'],
      'diskon' => $_POST['diskon_barang']
    );
    $this->db->insert('persediaan_daftar_barang', $data_barang);
    $id_barang = $this->db->insert_id();

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
    SELECT b.id AS id_barang, b.kode_barang, b.keterangan, b.persediaan_kategori_barang_id AS id_kategori_barang, b.default_gudang_id, b.saldo_awal_kuantitas, b.unit, b.saldo_awal_harga_per_unit, b.saldo_awal_harga_pokok, b.saldo_awal_gudang_id, b.saldo_awal_tanggal, b.tipe_barang, b.harga_jual, b.diskon
    FROM persediaan_daftar_barang b
    JOIN persediaan_kategori_barang k
      ON k.id = b.persediaan_kategori_barang_id
    WHERE b.id = $id_barang
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
