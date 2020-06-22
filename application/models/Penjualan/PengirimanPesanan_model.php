<?php
class PengirimanPesanan_model extends CI_Model
{
  public function getTablePengiriman()
  {
    $sql = "
      SELECT fk.id AS id_pengiriman, fk.tanggal, p.nama_pelanggan, fk.deskripsi
      FROM penjualan_form_pengiriman_barang fk
      JOIN penjualan_form_pesanan_penjualan fp
        ON fp.id = fk.penjualan_form_pesanan_penjualan_id
      JOIN daftar_pelanggan p
        ON p.id = fp.daftar_pelanggan_id
    ";
    $list_pengiriman = $this->db->query($sql)->result_array();

    foreach ($list_pengiriman as $key => $val) {
      $list_pengiriman[$key]['no'] = $this->getKodeDeliveryNow($val['id_pengiriman']);
    }
    return $list_pengiriman;
  }

  public function getTablePesanan()
  {
    $this->db->select('id, tanggal_penjualan');
    $this->db->from('penjualan_form_pesanan_penjualan');
    $this->db->where('is_done', 0);
    $this->db->order_by('id', 'DESC');
    return $this->db->get()->result_array();
  }

  public function getDataFormPesananPenjualan($id_form)
  {
    $sql = "
      SELECT f.id AS id_pesanan, f.tanggal_penjualan, p.nama_pelanggan, p.alamat AS tagihan_ke, f.alamat_ship_to
      FROM penjualan_form_pesanan_penjualan f
      JOIN daftar_pelanggan p
        ON p.id = f.daftar_pelanggan_id
      WHERE f.id = $id_form
      LIMIT 1
    ";
    return $this->db->query($sql)->row_array();
  }

  public function getNewIdDelivery()
  {
    $this->db->select('id');
    $this->db->from('penjualan_form_pengiriman_barang');
    $this->db->order_by('id', 'DESC');
    $this->db->limit(1);
    $last_id = $this->db->get()->row_array();

    $id_pesanan = 0;
    if (!empty($last_id))
      $id_pesanan = $last_id['id'];
    $id_pesanan++;

    return $id_pesanan;
  }

  private function _convertToKodeDelivery($id_form, $last_id)
  {
    $kode_pesanan = '';
    $digit = floor(log10($last_id) + 1);
    if ($digit <= 3)
      $kode_pesanan = str_pad($id_form, 3, '0', STR_PAD_LEFT);
    else
      $kode_pesanan = str_pad($id_form, $digit, '0', STR_PAD_LEFT);

    return 'DO-' . $kode_pesanan;
  }

  public function getKodeDeliveryNow($id_form)
  {
    $last_id = $this->getNewIdDelivery();
    return $this->_convertToKodeDelivery($id_form, $last_id);
  }

  public function getListRowBarangPesanan($id_form_pesanan)
  {
    $sql = "
      SELECT b.id AS id_barang, dp.id AS id_barang_pesanan, b.kode_barang, b.keterangan, dp.qty_jual, dp.qty_terkirim, b.unit, b.default_gudang_id
      FROM penjualan_daftar_barang_pesanan_penjualan dp
      JOIN persediaan_daftar_barang b
        ON b.id = dp.persediaan_daftar_barang_id
      WHERE dp.penjualan_form_pesanan_penjualan_id = $id_form_pesanan
    ";
    return $this->db->query($sql)->result_array();
  }

  public function getDataRowBarangPesanan($id_barang_pesanan)
  {
    $sql = "
      SELECT b.id AS id_barang, dp.id AS id_barang_pesanan, b.kode_barang, b.keterangan, dp.qty_jual, dp.qty_terkirim, b.unit, b.default_gudang_id
      FROM penjualan_daftar_barang_pesanan_penjualan dp
      JOIN persediaan_daftar_barang b
        ON b.id = dp.persediaan_daftar_barang_id
      WHERE dp.id = $id_barang_pesanan
      LIMIT 1
    ";
    return $this->db->query($sql)->row_array();
  }

  public function simpanPengirimanPesanan()
  {
    $data_form = array(
      'id' => $_POST['id_delivery'],
      'tanggal' => $_POST['tanggal_kirim'],
      'deskripsi' => $_POST['deskripsi'],
      'penjualan_form_pesanan_penjualan_id' => $_POST['id_pesanan']
    );

    $this->db->trans_begin();
    $this->db->insert('penjualan_form_pengiriman_barang', $data_form);

    $this->_updateQtYTerkirimBarangPesanan();
    $this->_insertPengirimanToStok($_POST['id_delivery']);

    if ($this->db->trans_status() === FALSE) {
      $this->db->trans_rollback();
      return false;
    } else {
      $this->db->trans_commit();
      return true;
    }
  }

  private function _updateQtYTerkirimBarangPesanan()
  {
    $total_qty_barang_pesanan_dikirim = $_POST['total_qty_barang_pesanan_dikirim'];

    foreach ($total_qty_barang_pesanan_dikirim as $id_barang_pesanan => $qty_dikirim) {
      $update = array(
        'qty_terkirim' => $qty_dikirim
      );
      $this->db->where('id', $id_barang_pesanan);
      $this->db->update('penjualan_daftar_barang_pesanan_penjualan', $update);
    }
  }

  private function _insertPengirimanToStok($id_delivery)
  {
    $insert_id_barang = $_POST['insert_id_barang'];
    $insert_qty_dikirim = $_POST['insert_qty_dikirim'];
    $insert_kirim_gudang = $_POST['insert_kirim_gudang'];

    foreach ($insert_id_barang as $key => $id_barang) {
      $stok_berkurang = (int) $insert_qty_dikirim[$key];
      $stok_berkurang = -$stok_berkurang;
      $insert_stok = array(
        'persediaan_daftar_barang_id' => $id_barang,
        'stok' => $stok_berkurang,
        'persediaan_daftar_gudang_id' => $insert_kirim_gudang[$key],
        'persediaan_form_penyesuaian_stok_id' => 0,
        'persediaan_form_pindah_barang_id' => 0,
      );
      $this->db->insert('persediaan_stok_barang', $insert_stok);
      $id_insert_stok = $this->db->insert_id();

      $insert_pengiriman = array(
        'persediaan_daftar_barang_id' => $id_barang,
        'persediaan_stok_barang_id' => $id_insert_stok,
        'penjualan_form_pengiriman_barang_id' => $id_delivery
      );
      $this->db->insert('penjualan_daftar_barang_pengiriman_barang', $insert_pengiriman);
    }
  }

  public function getDataFormPengirimanPesanan($id_delivery)
  {
    $sql = "
      SELECT fk.id AS id_delivery, fp.id AS id_pesanan, fk.tanggal AS tanggal_kirim, fp.tanggal_penjualan, p.nama_pelanggan, p.alamat AS tagihan_ke, fp.alamat_ship_to, fk.deskripsi
      FROM penjualan_form_pengiriman_barang fk
      JOIN penjualan_form_pesanan_penjualan fp
        ON fp.id = fk.penjualan_form_pesanan_penjualan_id
      JOIN daftar_pelanggan p
        ON p.id = fp.daftar_pelanggan_id
      WHERE fk.id = $id_delivery
      LIMIT 1
    ";

    return $this->db->query($sql)->row_array();
  }

  public function getListRowBarangPengirimanPesanan($id_delivery)
  {
    $sql = "
      SELECT dk.id AS id_barang_pengiriman, dp.id AS id_barang_pesanan, b.kode_barang, b.keterangan, s.stok AS qty_terkirim, b.unit, s.persediaan_daftar_gudang_id AS id_gudang_dikirim
      FROM penjualan_daftar_barang_pengiriman_barang dk
      JOIN penjualan_form_pengiriman_barang fk
        ON fk.id = dk.penjualan_form_pengiriman_barang_id
      JOIN penjualan_daftar_barang_pesanan_penjualan dp
        ON dp.penjualan_form_pesanan_penjualan_id = fk.penjualan_form_pesanan_penjualan_id
      JOIN persediaan_daftar_barang b
        ON b.id = dk.persediaan_daftar_barang_id
      JOIN persediaan_stok_barang s
        ON s.id = dk.persediaan_stok_barang_id
      WHERE fk.id = $id_delivery
    ";
    return $this->db->query($sql)->result_array();
  }

  public function editPengirimanPesanan($id_delivery)
  {
    $data_form = array(
      'tanggal' => $_POST['tanggal_kirim'],
      'deskripsi' => $_POST['deskripsi']
    );

    $this->db->trans_begin();
    $this->db->where('id', $id_delivery);
    $this->db->update('penjualan_form_pengiriman_barang', $data_form);

    $this->_updateQtYTerkirimBarangPesanan();
    $this->_updatePengirimanToStok($id_delivery);

    if (!empty($_POST['insert_id_barang']))
      $this->_insertPengirimanToStok($_POST['id_delivery']);

    if ($this->db->trans_status() === FALSE) {
      $this->db->trans_rollback();
      return false;
    } else {
      $this->db->trans_commit();
      return true;
    }
  }

  private function _updatePengirimanToStok($id_delivery)
  {
    $update_id_barang_pengiriman = $_POST['update_id_barang_pengiriman'];
    $update_qty_dikirim = $_POST['update_qty_dikirim'];
    $update_kirim_gudang = $_POST['update_kirim_gudang'];
    $update_is_delete = $_POST['update_is_delete'];

    foreach ($update_id_barang_pengiriman as $key => $id_barang_pengiriman) {
      $this->db->select('persediaan_stok_barang_id AS id_stok');
      $this->db->from('penjualan_daftar_barang_pengiriman_barang');
      $this->db->where('id', $id_barang_pengiriman);
      $this->db->limit(1);
      $id_stok = $this->db->get()->row_array()['id_stok'];

      if ($update_is_delete[$key] == 0) {
        $stok_berkurang = (int) $update_qty_dikirim[$key];
        $stok_berkurang = -$stok_berkurang;
        $update_stok = array(
          'stok' => $stok_berkurang,
          'persediaan_daftar_gudang_id' => $update_kirim_gudang[$key]
        );
        $this->db->where('id', $id_stok);
        $this->db->update('persediaan_stok_barang', $update_stok);
      } else {
        $this->db->where('id', $id_barang_pengiriman);
        $this->db->delete('penjualan_daftar_barang_pengiriman_barang');
        $this->db->where('id', $id_stok);
        $this->db->delete('persediaan_stok_barang');
      }
    }
  }

  public function hapusPengirimanPesanan($id_delivery)
  {
    $this->db->trans_begin();

    $sql = "
      SELECT bp.id AS id_barang_pesanan, bp.persediaan_daftar_barang_id AS id_barang, bp.qty_terkirim
      FROM penjualan_form_pengiriman_barang fk
      JOIN penjualan_form_pesanan_penjualan fp
        ON fp.id = fk.penjualan_form_pesanan_penjualan_id
      JOIN penjualan_daftar_barang_pesanan_penjualan bp
        ON bp.penjualan_form_pesanan_penjualan_id = fp.id
      WHERE fk.id = $id_delivery
    ";
    $barang_pesanan = $this->db->query($sql)->result_array();

    foreach ($barang_pesanan as $bp) {
      $stok_dikirim_dari_pengiriman = 0;
      $id_barang = $bp['id_barang'];
      $sql = "
        SELECT SUM(s.stok) AS stok_dikirim
        FROM penjualan_form_pengiriman_barang fk
        JOIN penjualan_form_pesanan_penjualan fp
          ON fp.id = fk.penjualan_form_pesanan_penjualan_id
        JOIN penjualan_daftar_barang_pesanan_penjualan bp
          ON bp.penjualan_form_pesanan_penjualan_id = fp.id
        JOIN penjualan_daftar_barang_pengiriman_barang bk
          ON bk.persediaan_daftar_barang_id = bp.persediaan_daftar_barang_id
        JOIN persediaan_stok_barang s
          ON s.id = bk.persediaan_stok_barang_id
        WHERE s.persediaan_daftar_barang_id = $id_barang
      ";
      $stok_dikirim_by_db = $this->db->query($sql)->row_array();
      if (!empty($stok_dikirim_by_db['stok_dikirim'])) {
        $stok_dikirim_dari_pengiriman = (int) $stok_dikirim_by_db['stok_dikirim'];
        $stok_dikirim_dari_pengiriman = $stok_dikirim_dari_pengiriman * -1;
      }

      $update_stok_dikirim_after_delete = (int) $bp['qty_terkirim'];
      $update_stok_dikirim_after_delete = $update_stok_dikirim_after_delete - $stok_dikirim_dari_pengiriman;

      $update_barang_pesanan_terkirim = array(
        'qty_terkirim' => $update_stok_dikirim_after_delete
      );
      $this->db->where('id', $bp['id_barang_pesanan']);
      $this->db->update('penjualan_daftar_barang_pesanan_penjualan', $update_barang_pesanan_terkirim);
    }

    $sql = "
      SELECT bk.id AS id_barang_pengiriman, bk.persediaan_stok_barang_id AS id_stok_pengiriman
      FROM penjualan_daftar_barang_pengiriman_barang bk
      JOIN penjualan_form_pengiriman_barang fk
        ON fk.id = bk.penjualan_form_pengiriman_barang_id
      WHERE fk.id = $id_delivery
    ";
    $list_delete = $this->db->query($sql)->result_array();

    foreach ($list_delete as $delete) {
      $this->db->where('id', $delete['id_barang_pengiriman']);
      $this->db->delete('penjualan_daftar_barang_pengiriman_barang');
      $this->db->where('id', $delete['id_stok_pengiriman']);
      $this->db->delete('persediaan_stok_barang');
    }

    $this->db->where('id', $id_delivery);
    $this->db->delete('penjualan_form_pengiriman_barang');

    if ($this->db->trans_status() === FALSE) {
      $this->db->trans_rollback();
      return false;
    } else {
      $this->db->trans_commit();
      return true;
    }
  }
}
