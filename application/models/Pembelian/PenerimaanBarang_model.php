<?php
class PenerimaanBarang_model extends CI_Model
{
  public function getLastKodePenerimaanBarang()
  {
    $this->db->select('id');
    $this->db->from('pembelian_form_penerimaan_barang');
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
      'kode' => 'T-' . $kode_pesanan
    );
    return $data;
  }

  public function getTablePesanan($supplier_id)
  {
    $this->db->select('id, tanggal');
    $this->db->from('pembelian_form_pesanan_pembelian');
    $this->db->where('supplier_id', $supplier_id);
    $this->db->order_by('id', 'DESC');
    $list_pesanan = $this->db->get()->result_array();

    $this->db->select('id');
    $this->db->from('pembelian_form_pesanan_pembelian');
    $this->db->order_by('id', 'DESC');
    $this->db->limit(1);
    $last_id_temp = $this->db->get()->row_array();

    $last_id = 1;
    if (!empty($last_id_temp))
      $last_id = $last_id_temp['id'];

    foreach ($list_pesanan as $key => $val) {
      $id_pesanan = $list_pesanan[$key]['id'];
      $kode_pesanan = '';
      $digit = floor(log10($last_id) + 1);

      if ($digit <= 3)
        $kode_pesanan = str_pad($id_pesanan, 3, '0', STR_PAD_LEFT);
      else
        $kode_pesanan = str_pad($id_pesanan, $digit, '0', STR_PAD_LEFT);

      $list_pesanan[$key]['no'] = 'B-' . $kode_pesanan;
    }
    return $list_pesanan;
  }

  public function getListBarangPesanan($form_id)
  {
    $sql = "
      SELECT b.kode_barang, b.keterangan, d.qty_beli, b.unit, b.default_gudang_id, d.id AS id_barang_pesanan
      FROM pembelian_daftar_barang_pesanan_pembelian d
      JOIN persediaan_daftar_barang b
        ON b.id = d.persediaan_daftar_barang_id
      WHERE pembelian_form_pesanan_pembelian_id = $form_id
    ";
    return $this->db->query($sql)->result_array();
  }

  public function simpanPenerimaanBarang()
  {
    $data_form = array(
      'id' => $_POST['id_penerimaan'],
      'tanggal' => $_POST['tanggal'],
      'supplier_id' => $_POST['supplier_id'],
      'deskripsi' => $_POST['deskripsi']
    );

    $this->db->trans_begin();
    $this->db->insert('pembelian_form_penerimaan_barang', $data_form);

    // $this->_simpanPesananPembelianPerBarang($_POST['id_pesanan']);
 
    if ($this->db->trans_status() === FALSE) {
      $this->db->trans_rollback();
      return false;
    } else {
      $this->db->trans_commit();
      return true;
    }
  }
}
