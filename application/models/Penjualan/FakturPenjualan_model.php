<?php
class FakturPenjualan_model extends CI_Model
{
  public function getTableFakturPenjualan()
  {
    $sql = "
      SELECT ff.id AS id_faktur, ff.tanggal, fk.id AS id_pengiriman, p.nama_pelanggan, ff.total_biaya, ff.uang_muka
      FROM penjualan_form_faktur_penjualan ff
      JOIN penjualan_form_pengiriman_barang fk
        ON fk.id = ff.penjualan_form_pengiriman_barang_id
      JOIN penjualan_form_pesanan_penjualan fp
        ON fp.id = ff.penjualan_form_pesanan_penjualan_id
      JOIN daftar_pelanggan p
        ON p.id = fp.daftar_pelanggan_id
    ";
    return $this->db->query($sql)->result_array();
  }

  public function getListPengirimanNotDone()
  {
    $sql = "
      SELECT fk.id AS id_pengiriman, fk.tanggal
      FROM penjualan_form_pengiriman_barang fk
      JOIN penjualan_form_pesanan_penjualan fp
        ON fp.id = fk.penjualan_form_pesanan_penjualan_id
      WHERE fk.is_done = 0
    ";
    return $this->db->query($sql)->result_array();
  }

  public function getDataFormFakturPenjualan($id_delivery)
  {
    $sql = "
      SELECT fk.id AS id_delivery, fp.id AS id_pesanan, fk.tanggal AS tanggal_kirim, fp.tanggal_penjualan, p.nama_pelanggan, p.alamat AS tagihan_ke, fp.alamat_ship_to, fp.deskripsi, fp.diskon_overall, fp.is_uang_muka
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
      SELECT b.kode_barang, b.keterangan, s.stok AS qty_terkirim, b.unit, s.persediaan_daftar_gudang_id AS id_gudang_dikirim, dp.harga_unit, dp.diskon
      FROM penjualan_form_pengiriman_barang fk
      JOIN penjualan_daftar_barang_pengiriman_barang dk
        ON dk.penjualan_form_pengiriman_barang_id = fk.id
      JOIN penjualan_daftar_barang_pesanan_penjualan dp
        ON dk.persediaan_daftar_barang_id = dp.persediaan_daftar_barang_id
      JOIN persediaan_daftar_barang b
        ON b.id = dk.persediaan_daftar_barang_id
      JOIN persediaan_stok_barang s
        ON s.id = dk.persediaan_stok_barang_id
      WHERE fk.id = $id_delivery AND fk.penjualan_form_pesanan_penjualan_id = dp.penjualan_form_pesanan_penjualan_id
    ";
    $list_barang = $this->db->query($sql)->result_array();

    foreach ($list_barang as $key => $val) {
      $jml = (int) $val['qty_terkirim'];
      $jml = $jml * -1;
      $list_barang[$key]['qty_terkirim'] = $jml;
      $harga = (int) $val['harga_unit'];
      $diskon = (int) $val['diskon'];
      $subtotal = $jml * $harga;
      $subtotal = $subtotal - ($subtotal * $diskon / 100);
      $list_barang[$key]['subtotal'] = $subtotal;
    }
    return $list_barang;
  }

  public function getNewIdFaktur()
  {
    $this->db->select('id');
    $this->db->from('penjualan_form_faktur_penjualan');
    $this->db->order_by('id', 'DESC');
    $this->db->limit(1);
    $last_id = $this->db->get()->row_array();

    $id_faktur = 0;
    if (!empty($last_id))
      $id_faktur = $last_id['id'];
    $id_faktur++;

    return $id_faktur;
  }

  private function _convertToKodeFaktur($id_form, $last_id)
  {
    $kode_pesanan = '';
    $digit = floor(log10($last_id) + 1);
    if ($digit <= 3)
      $kode_pesanan = str_pad($id_form, 3, '0', STR_PAD_LEFT);
    else
      $kode_pesanan = str_pad($id_form, $digit, '0', STR_PAD_LEFT);

    return 'SI-' . $kode_pesanan;
  }

  public function getKodeFakturNow($id_form)
  {
    $last_id = $this->getNewIdFaktur();
    return $this->_convertToKodeFaktur($id_form, $last_id);
  }

  public function simpanFakturPenjualan()
  {
    $uang_muka = 0;
    $data_form = array(
      'id' => $_POST['id_faktur'],
      'tanggal' => $_POST['tanggal_faktur'],
      'penjualan_form_pesanan_penjualan_id' => $_POST['id_pesanan'],
      'penjualan_form_pengiriman_barang_id' => $_POST['id_delivery'],
      'uang_muka' => $uang_muka,
      'total_biaya' => $_POST['total_biaya']
    );

    $this->db->trans_begin();
    $this->db->insert('penjualan_form_faktur_penjualan', $data_form);

    $update_delivery = array(
      'is_done' => 1
    );

    $this->db->where('id', $_POST['id_delivery']);
    $this->db->update('penjualan_form_pengiriman_barang', $update_delivery);

    $this->db->distinct();
    $this->db->select('persediaan_daftar_barang_id AS id_barang');
    $this->db->from('penjualan_daftar_barang_pesanan_penjualan');
    $this->db->where('penjualan_form_pesanan_penjualan_id', $_POST['id_pesanan']);
    $list_barang = $this->db->get()->result_array();

    $status_selesai = true;
    foreach ($list_barang as $barang) {
      $this->db->select('SUM(qty_jual) AS total_pesan, SUM(qty_terkirim) AS total_kirim');
      $this->db->from('penjualan_daftar_barang_pesanan_penjualan');
      $where = array(
        'persediaan_daftar_barang_id' => $barang['id_barang'],
        'penjualan_form_pesanan_penjualan_id' => $_POST['id_pesanan']
      );
      $this->db->where($where);
      $total = $this->db->get()->row_array();

      if ($total['total_pesan'] != $total['total_kirim'])
        $status_selesai = false;
    }

    $update_pesanan = array(
      'is_biaya_kirim_done' => 1
    );
    $this->db->where('id', $_POST['id_pesanan']);
    $this->db->update('penjualan_form_pesanan_penjualan', $update_pesanan);

    if ($status_selesai) {
      $update_pesanan = array(
        'is_done' => 1
      );
      $this->db->where('id', $_POST['id_pesanan']);
      $this->db->update('penjualan_form_pesanan_penjualan', $update_pesanan);
    }

    if ($this->db->trans_status() === FALSE) {
      $this->db->trans_rollback();
      return false;
    } else {
      $this->db->trans_commit();
      return true;
    }
  }

  public function getDataFormFakturPenjualanForEdit($id_faktur)
  {
    $sql = "
      SELECT ff.id AS id_faktur, fk.id AS id_delivery, fp.id AS id_pesanan, fk.tanggal AS tanggal_kirim, fp.tanggal_penjualan, p.nama_pelanggan, p.alamat AS tagihan_ke, fp.alamat_ship_to, fp.deskripsi, fp.diskon_overall, fp.is_uang_muka
      FROM penjualan_form_faktur_penjualan ff
      JOIN penjualan_form_pengiriman_barang fk
        ON fk.id = ff.penjualan_form_pengiriman_barang_id
      JOIN penjualan_form_pesanan_penjualan fp
        ON fp.id = ff.penjualan_form_pesanan_penjualan_id
      JOIN daftar_pelanggan p
        ON p.id = fp.daftar_pelanggan_id
      WHERE ff.id = $id_faktur
      LIMIT 1
    ";
    return $this->db->query($sql)->row_array();
  }

  public function editFakturPenjualan()
  {
    $uang_muka = 0;
    $update_form = array(
      'id' => $_POST['id_faktur'],
      'tanggal' => $_POST['tanggal_faktur'],
      'penjualan_form_pesanan_penjualan_id' => $_POST['id_pesanan'],
      'penjualan_form_pengiriman_barang_id' => $_POST['id_delivery'],
      'uang_muka' => $uang_muka,
      'total_biaya' => $_POST['total_biaya']
    );

    $this->db->trans_begin();

    $this->db->where('id', $_POST['id_faktur']);
    $this->db->update('penjualan_form_faktur_penjualan', $update_form);

    if ($this->db->trans_status() === FALSE) {
      $this->db->trans_rollback();
      return false;
    } else {
      $this->db->trans_commit();
      return true;
    }
  }

  public function hapusFakturPenjualan($id_faktur)
  {
    $this->db->select('penjualan_form_pesanan_penjualan_id, penjualan_form_pengiriman_barang_id');
    $this->db->from('penjualan_form_faktur_penjualan');
    $this->db->where('id', $id_faktur);
    $this->db->limit(1);
    $data_faktur = $this->db->get()->row_array();

    $is_first_faktur = true;
    $this->db->select('id, penjualan_form_pesanan_penjualan_id');
    $this->db->from('penjualan_form_faktur_penjualan');
    $this->db->where('id', $data_faktur['penjualan_form_pesanan_penjualan_id']);
    $this->db->order_by('id', 'ASC');
    $list_faktur_pesanan_sama = $this->db->get()->result_array();
    if ($list_faktur_pesanan_sama[0]['id'] != $id_faktur)
      $is_first_faktur = false;

    $this->db->trans_begin();

    $this->db->where('id', $id_faktur);
    $this->db->delete('penjualan_form_faktur_penjualan');

    $update_delivery = array(
      'is_done' => 0
    );
    $this->db->where('id', $data_faktur['penjualan_form_pengiriman_barang_id']);
    $this->db->update('penjualan_form_pengiriman_barang', $update_delivery);

    if ($is_first_faktur) {
      $update_pesanan = array(
        'is_biaya_kirim_done' => 0
      );
      $this->db->where('id', $data_faktur['penjualan_form_pesanan_penjualan_id']);
      $this->db->update('penjualan_form_pesanan_penjualan', $update_pesanan);
    }

    $this->db->distinct();
    $this->db->select('persediaan_daftar_barang_id AS id_barang');
    $this->db->from('penjualan_daftar_barang_pesanan_penjualan');
    $this->db->where('penjualan_form_pesanan_penjualan_id', $_POST['id_pesanan']);
    $list_barang = $this->db->get()->result_array();
    $status_selesai = true;
    foreach ($list_barang as $barang) {
      $this->db->select('SUM(qty_jual) AS total_pesan, SUM(qty_terkirim) AS total_kirim');
      $this->db->from('penjualan_daftar_barang_pesanan_penjualan');
      $where = array(
        'persediaan_daftar_barang_id' => $barang['id_barang'],
        'penjualan_form_pesanan_penjualan_id' => $_POST['id_pesanan']
      );
      $this->db->where($where);
      $total = $this->db->get()->row_array();

      if ($total['total_pesan'] != $total['total_kirim'])
        $status_selesai = false;
    }
    $update_pesanan = array();
    if ($status_selesai) {
      $update_pesanan = array(
        'is_done' => 1
      );
    } else {
      $update_pesanan = array(
        'is_done' => 0
      );
    }
    $this->db->where('id', $_POST['id_pesanan']);
    $this->db->update('penjualan_form_pesanan_penjualan', $update_pesanan);

    if ($this->db->trans_status() === FALSE) {
      $this->db->trans_rollback();
      return false;
    } else {
      $this->db->trans_commit();
      return true;
    }
  }
}
