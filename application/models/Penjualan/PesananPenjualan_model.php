<?php
class PesananPenjualan_model extends CI_Model
{
  public function getTablePesananPenjualan()
  {
    $sql = "
      SELECT f.id, f.tanggal_penjualan, f.is_done AS status, p.nama_pelanggan, f.is_uang_muka, f.total_biaya, f.deskripsi
      FROM penjualan_form_pesanan_penjualan f
      JOIN daftar_pelanggan p
        ON p.id = f.daftar_pelanggan_id
      ORDER BY f.id ASC
    ";
    $list_pembelian = $this->db->query($sql)->result_array();

    $last_id = $this->getLastKodePesananPenjualan()['id'];
    foreach ($list_pembelian as $key => $val) {
      $list_pembelian[$key]['no'] = $this->_convertToKodePenjualan($val['id'], $last_id);

      // $jumlah_dp = 0;
      // if ($list_pembelian[$key]['is_uang_muka'] == 1) {
      //   $this->db->select('nilai_faktur');
      //   $this->db->from('pembelian_form_faktur_pembelian');
      //   $where = array(
      //     'is_row_dp' => 1,
      //     'pembelian_form_pesanan_pembelian_id ' => $list_pembelian[$key]['id'],
      //   );
      //   $this->db->where($where);
      //   $this->db->limit(1);
      //   $uang_muka = $this->db->get()->row_array()['nilai_faktur'];
      //   $jumlah_dp = (int) $uang_muka;
      // }
      // $list_pembelian[$key]['jumlah_dp'] = $jumlah_dp;
    }
    return $list_pembelian;
  }

  public function getStokBarangTotalByIdBarang($id_barang)
  {
    $total_stok = 0;

    $this->db->select('saldo_awal_kuantitas');
    $this->db->from('persediaan_daftar_barang');
    $this->db->where('id', $id_barang);
    $this->db->limit(1);
    $saldo_awal = $this->db->get()->row_array();

    if (!empty($saldo_awal['saldo_awal_kuantitas']))
      $total_stok += (int) $saldo_awal['saldo_awal_kuantitas'];

    $this->db->select('SUM(stok) AS total_stok');
    $this->db->from('persediaan_stok_barang');
    $where = array(
      'persediaan_daftar_barang_id' => $id_barang
    );
    $this->db->where($where);
    $temp_stok = $this->db->get()->row_array();
    $total_stok += (int) $temp_stok['total_stok'];

    return $total_stok;
  }

  public function getStokBarangByGudangId($id_gudang, $id_barang)
  {
    $total_stok = 0;

    $this->db->select('saldo_awal_kuantitas, saldo_awal_gudang_id');
    $this->db->from('persediaan_daftar_barang');
    $this->db->where('id', $id_barang);
    $this->db->limit(1);
    $saldo_awal = $this->db->get()->row_array();

    if (!empty($saldo_awal)) {
      if ($id_gudang == $saldo_awal['saldo_awal_gudang_id'])
        $total_stok += (int) $saldo_awal['saldo_awal_kuantitas'];
    }

    $this->db->select('SUM(stok) AS total_stok');
    $this->db->from('persediaan_stok_barang');
    $where = array(
      'persediaan_daftar_barang_id' => $id_barang,
      'persediaan_daftar_gudang_id' => $id_gudang
    );
    $this->db->where($where);
    $temp_stok = $this->db->get()->row_array();
    $total_stok += (int) $temp_stok['total_stok'];

    return $total_stok;
  }

  public function getLastKodePesananPenjualan()
  {
    $this->db->select('id');
    $this->db->from('penjualan_form_pesanan_penjualan');
    $this->db->order_by('id', 'DESC');
    $this->db->limit(1);
    $last_id = $this->db->get()->row_array();

    $id_pesanan = 0;
    if (!empty($last_id))
      $id_pesanan = $last_id['id'];

    $id_pesanan++;

    $kode_pesanan = '';
    $digit = floor(log10($id_pesanan) + 1);

    if ($digit <= 3)
      $kode_pesanan = str_pad($id_pesanan, 3, '0', STR_PAD_LEFT);
    else
      $kode_pesanan = str_pad($id_pesanan, $digit, '0', STR_PAD_LEFT);

    $data = array(
      'id' => $id_pesanan,
      'kode_pesanan' => 'SO-' . $kode_pesanan
    );
    return $data;
  }

  private function _getHargaJualTerbaruByIdBarang($id_barang)
  {
    $harga_terbaru = 0;
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
      $harga_terbaru = $temp['harga_jual'];
    } else
      $harga_terbaru = $temp['harga_jual'];
    return $harga_terbaru;
  }

  private function _convertToKodePenjualan($id_form, $last_id)
  {
    $kode_pesanan = '';
    $digit = floor(log10($last_id) + 1);
    if ($digit <= 3)
      $kode_pesanan = str_pad($id_form, 3, '0', STR_PAD_LEFT);
    else
      $kode_pesanan = str_pad($id_form, $digit, '0', STR_PAD_LEFT);

    return 'SO-' . $kode_pesanan;
  }

  public function getKodePenjualanNow($id_form)
  {
    $last_id = $this->getLastKodePesananPenjualan()['id'];
    return $this->_convertToKodePenjualan($id_form, $last_id);
  }

  public function getRowDataBarangPenjualan($id_barang)
  {
    $this->db->select('*');
    $this->db->from('persediaan_daftar_barang');
    $this->db->where('id', $id_barang);
    $this->db->limit(1);
    $data_barang =  $this->db->get()->row_array();
    $data_barang['harga_jual_terbaru'] = $this->_getHargaJualTerbaruByIdBarang($id_barang);
    $data_barang['stok_terbaru'] = $this->getStokBarangTotalByIdBarang($id_barang);
    return $data_barang;
  }

  public function getListRowDataBarangPenjualan($id_pesanan)
  {
    $sql = "
      SELECT b.id AS id_barang, dp.id AS id_barang_pesanan, b.kode_barang, b.keterangan, dp.qty_jual, b.unit, dp.harga_unit, dp.diskon, dp.subtotal, dp.qty_terkirim
      FROM penjualan_daftar_barang_pesanan_penjualan dp
      JOIN persediaan_daftar_barang b
        ON b.id = dp.persediaan_daftar_barang_id
      WHERE dp.penjualan_form_pesanan_penjualan_id = $id_pesanan
    ";
    $list_barang =  $this->db->query($sql)->result_array();

    foreach ($list_barang as $key => $val) {
      $list_barang[$key]['stok_terbaru'] = $this->getStokBarangTotalByIdBarang($val['id_barang']);
    }

    return $list_barang;
  }

  public function simpanPesananPenjualan()
  {
    $is_uang_muka = 0;
    if (!empty($_POST['is_uang_muka_enabled']))
      $is_uang_muka = 1;

    $data_form = array(
      'id' => $_POST['id_pesanan'],
      'tanggal_penjualan' => $_POST['tanggal_penjualan'],
      'ship_date' => $_POST['ship_date'],
      'daftar_jasa_pengiriman_id ' => $_POST['ship_via'],
      'daftar_pelanggan_id ' => $_POST['order_by_pelanggan_id'],
      'alamat_ship_to' => $_POST['alamat_ship_to'],
      'deskripsi' => $_POST['deskripsi'],
      'subtotal_overall' => $_POST['subtotal_overall'],
      'diskon_overall' => $_POST['diskon_overall'],
      'jumlah_diskon_overall' => $_POST['jumlah_diskon_overall'],
      'biaya_pengiriman' => $_POST['biaya_pengiriman'],
      'total_biaya' => $_POST['total_biaya'],
      'is_uang_muka' => $is_uang_muka,
      'is_done' => 0
    );

    $this->db->trans_begin();
    $this->db->insert('penjualan_form_pesanan_penjualan', $data_form);

    // if ($is_uang_muka == 1) {
    //   $this->db->select('id');
    //   $this->db->from('pembelian_form_faktur_pembelian');
    //   $this->db->order_by('id', 'DESC');
    //   $this->db->limit(1);
    //   $last_id = $this->db->get()->row_array();

    //   $id_faktur = 0;
    //   if (!empty($last_id))
    //     $id_faktur = $last_id['id'];
    //   $id_faktur++;

    //   $insert_dp = array(
    //     'id' => $id_faktur,
    //     'tanggal' => $_POST['tanggal'],
    //     'nilai_faktur' => $_POST['jumlah_dp'],
    //     'uang_muka' => 0,
    //     'is_row_dp' => 1,
    //     'pembelian_form_pesanan_pembelian_id' => $_POST['id_pesanan']
    //   );
    //   $this->db->insert('pembelian_form_faktur_pembelian', $insert_dp);

    //   $insert_dp = array(
    //     'deskripsi' => $_POST['deskripsi_dp'],
    //     'jumlah_dp' => $_POST['jumlah_dp'],
    //     'pembelian_form_faktur_pembelian_id' => $id_faktur
    //   );
    //   $this->db->insert('pembelian_data_dp_faktur_pembelian', $insert_dp);
    // }

    $this->_simpanPesananPenjualanPerBarang($_POST['id_pesanan']);

    if ($this->db->trans_status() === FALSE) {
      $this->db->trans_rollback();
      return false;
    } else {
      $this->db->trans_commit();
      return true;
    }
  }

  private function _simpanPesananPenjualanPerBarang($id_form)
  {
    $insert_id_barang = $_POST['insert_id_barang'];
    $insert_qty_jual = $_POST['insert_qty_jual'];
    $insert_harga_unit = $_POST['insert_harga_unit'];
    $insert_diskon = $_POST['insert_diskon'];
    $insert_subtotal = $_POST['insert_subtotal'];

    foreach ($insert_id_barang as $key => $id_barang) {
      $insert = array(
        'persediaan_daftar_barang_id' => $id_barang,
        'qty_jual' => $insert_qty_jual[$key],
        'harga_unit' => $insert_harga_unit[$key],
        'diskon' => $insert_diskon[$key],
        'subtotal' => $insert_subtotal[$key],
        'qty_terkirim' => 0,
        'penjualan_form_pesanan_penjualan_id' => $id_form
      );
      $this->db->insert('penjualan_daftar_barang_pesanan_penjualan', $insert);
    }
  }

  public function getDataFormPesananPenjualan($id_form)
  {
    $sql = "
      SELECT f.id, f.tanggal_penjualan, f.ship_date, f.is_done AS status, p.id AS id_pelanggan, p.alamat AS alamat_pelanggan, f.is_uang_muka, f.total_biaya, f.deskripsi, f.alamat_ship_to, f.daftar_jasa_pengiriman_id, f.subtotal_overall, f.diskon_overall, f.jumlah_diskon_overall, f.biaya_pengiriman
      FROM penjualan_form_pesanan_penjualan f
      JOIN daftar_pelanggan p
        ON p.id = f.daftar_pelanggan_id
      WHERE f.id = $id_form
      LIMIT 1
    ";
    $data_form = $this->db->query($sql)->row_array();

    $last_id = $this->getLastKodePesananPenjualan()['id'];
    $data_form['no'] = $this->_convertToKodePenjualan($data_form['id'], $last_id);

    // if ($data_form['is_uang_muka'] == 1) {
    //   $sql = "
    //     SELECT dp.deskripsi, dp.jumlah_dp, ff.id AS id_faktur_dp, dp.id AS id_faktur_data_dp
    //     FROM pembelian_form_faktur_pembelian ff
    //     JOIN pembelian_data_dp_faktur_pembelian dp
    //       ON ff.id = dp.pembelian_form_faktur_pembelian_id
    //     WHERE ff.pembelian_form_pesanan_pembelian_id = 4
    //     LIMIT 1
    //   ";
    //   $data_dp = $this->db->query($sql)->row_array();
    //   $data_form['id_faktur_dp'] = $data_dp['id_faktur_dp'];
    //   $data_form['id_faktur_data_dp'] = $data_dp['id_faktur_data_dp'];
    //   $data_form['deskripsi_dp'] = $data_dp['deskripsi'];
    //   $data_form['jumlah_dp'] = $data_dp['jumlah_dp'];
    // } else {
    //   $data_form['deskripsi_dp'] = 'Down Payment';
    //   $data_form['jumlah_dp'] = 0;
    // }
    return $data_form;
  }

  public function checkIsPesananPenjualanDone($id_form)
  {
    $this->db->select('is_done');
    $this->db->from('penjualan_form_pesanan_penjualan');
    $this->db->where('id', $id_form);
    $this->db->limit(1);
    $is_done = $this->db->get()->row_array()['is_done'];

    if ($is_done == 1)
      return true;
    else
      return false;
  }

  public function editPesananPenjualan($id_form)
  {
    $is_uang_muka = 0;
    if (!empty($_POST['is_uang_muka_enabled']))
      $is_uang_muka = 1;

    $update_form = array(
      'id' => $id_form,
      'tanggal_penjualan' => $_POST['tanggal_penjualan'],
      'ship_date' => $_POST['ship_date'],
      'daftar_jasa_pengiriman_id ' => $_POST['ship_via'],
      'daftar_pelanggan_id ' => $_POST['order_by_pelanggan_id'],
      'alamat_ship_to' => $_POST['alamat_ship_to'],
      'deskripsi' => $_POST['deskripsi'],
      'subtotal_overall' => $_POST['subtotal_overall'],
      'diskon_overall' => $_POST['diskon_overall'],
      'jumlah_diskon_overall' => $_POST['jumlah_diskon_overall'],
      'biaya_pengiriman' => $_POST['biaya_pengiriman'],
      'total_biaya' => $_POST['total_biaya'],
      'is_uang_muka' => $is_uang_muka,
      'is_done' => 0
    );

    $this->db->trans_begin();
    $this->db->where('id', $id_form);
    $this->db->update('penjualan_form_pesanan_penjualan', $update_form);

    // if ($is_uang_muka == 1) {
    //   $this->db->select('id');
    //   $this->db->from('pembelian_form_faktur_pembelian');
    //   $this->db->order_by('id', 'DESC');
    //   $this->db->limit(1);
    //   $last_id = $this->db->get()->row_array();

    //   $id_faktur = 0;
    //   if (!empty($last_id))
    //     $id_faktur = $last_id['id'];
    //   $id_faktur++;

    //   $insert_dp = array(
    //     'id' => $id_faktur,
    //     'tanggal' => $_POST['tanggal'],
    //     'nilai_faktur' => $_POST['jumlah_dp'],
    //     'uang_muka' => 0,
    //     'is_row_dp' => 1,
    //     'pembelian_form_pesanan_pembelian_id' => $_POST['id_pesanan']
    //   );
    //   $this->db->insert('pembelian_form_faktur_pembelian', $insert_dp);

    //   $insert_dp = array(
    //     'deskripsi' => $_POST['deskripsi_dp'],
    //     'jumlah_dp' => $_POST['jumlah_dp'],
    //     'pembelian_form_faktur_pembelian_id' => $id_faktur
    //   );
    //   $this->db->insert('pembelian_data_dp_faktur_pembelian', $insert_dp);
    // }

    if (!empty($_POST['update_id_barang_pesanan']))
      $this->_updatePesananPenjualanPerBarang($id_form);

    if (!empty($_POST['insert_id_barang']))
      $this->_simpanPesananPenjualanPerBarang($id_form);

    if ($this->db->trans_status() === FALSE) {
      $this->db->trans_rollback();
      return false;
    } else {
      $this->db->trans_commit();
      return true;
    }
  }

  private function _updatePesananPenjualanPerBarang($id_form)
  {
    $update_id_barang_pesanan = $_POST['update_id_barang_pesanan'];
    $update_qty_jual = $_POST['update_qty_jual'];
    $update_harga_unit = $_POST['update_harga_unit'];
    $update_diskon = $_POST['update_diskon'];
    $update_subtotal = $_POST['update_subtotal'];
    $update_is_delete = $_POST['update_is_delete'];

    foreach ($update_id_barang_pesanan as $key => $id_pesanan_barang) {
      if ($update_is_delete[$key] == 0) {
        $update = array(
          'qty_jual' => $update_qty_jual[$key],
          'harga_unit' => $update_harga_unit[$key],
          'diskon' => $update_diskon[$key],
          'subtotal' => $update_subtotal[$key],
          'penjualan_form_pesanan_penjualan_id' => $id_form
        );
        $this->db->where('id', $id_pesanan_barang);
        $this->db->update('penjualan_daftar_barang_pesanan_penjualan', $update);
      } else {
        $this->db->where('id', $id_pesanan_barang);
        $this->db->delete('penjualan_daftar_barang_pesanan_penjualan');
      }
    }
  }

  public function hapusPesananPembelian($id_form)
  {
    $this->db->trans_begin();

    // $this->db->select('is_uang_muka');
    // $this->db->from('pembelian_form_pesanan_pembelian');
    // $this->db->where('id', $id_form);
    // $this->db->limit(1);
    // $is_uang_muka = (int) $this->db->get()->row_array()['is_uang_muka'];

    // if ($is_uang_muka == 1) {
    //   $this->db->select('id');
    //   $this->db->from('pembelian_form_faktur_pembelian');
    //   $this->db->where('pembelian_form_pesanan_pembelian_id', $id_form);
    //   $this->db->limit(1);
    //   $id_faktur_dp = (int) $this->db->get()->row_array()['id'];

    //   $this->db->select('id');
    //   $this->db->from('pembelian_data_dp_faktur_pembelian');
    //   $this->db->where('pembelian_form_faktur_pembelian_id', $id_faktur_dp);
    //   $this->db->limit(1);
    //   $id_faktur_data_dp = (int) $this->db->get()->row_array()['id'];

    //   $this->db->where('id', $id_faktur_data_dp);
    //   $this->db->delete('pembelian_data_dp_faktur_pembelian');
    //   $this->db->where('id', $id_faktur_dp);
    //   $this->db->delete('pembelian_form_faktur_pembelian');
    // }

    $this->db->select('id');
    $this->db->from('penjualan_daftar_barang_pesanan_penjualan');
    $this->db->where('penjualan_form_pesanan_penjualan_id', $id_form);
    $list_barang = $this->db->get()->result_array();

    foreach ($list_barang as $x) {
      $this->db->where('id', $x['id']);
      $this->db->delete('penjualan_daftar_barang_pesanan_penjualan');
    }

    $this->db->where('id', $id_form);
    $this->db->delete('penjualan_form_pesanan_penjualan');

    if ($this->db->trans_status() === FALSE) {
      $this->db->trans_rollback();
      return false;
    } else {
      $this->db->trans_commit();
      return true;
    }
  }
}
