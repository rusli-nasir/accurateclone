<?php
foreach ($list_barang_faktur as $data) {
?>
  <tr>
    <td>
      <?= $data['kode_barang'] ?>
    </td>
    <td>
      <?= $data['keterangan'] ?>
    </td>
    <td>
      <?= $data['qty_beli'] ?>
    </td>
    <td>
      <?= $data['qty_terima'] ?>
    </td>
    <td>
      <?= $data['unit'] ?>
    </td>
    <td>
      <?= 'Rp ' . number_format($data['harga_unit'], 0, ".", ".") ?>
    </td>
    <td>
      <?= $data['diskon'] . '%' ?>
    </td>
    <td>
      <?= 'Rp ' . number_format($data['harga_unit'], 0, ".", ".") ?>
    </td>
    <td>
      <div class="form-group">
        <input type="hidden" name="id_stok_faktur[<?= $data['id_barang_faktur'] ?>]" value="<?= $data['id_stok_faktur'] ?>">
        <input type="hidden" name="id_barang_pesanan[<?= $data['id_barang_faktur'] ?>]" value="<?= $data['id_barang_pesanan'] ?>">
        <select class="form-control pilih-gudang" name="update_terima_gudang[<?= $data['id_barang_faktur'] ?>]">
          <?php
          foreach ($gudang as $x) {
          ?>
            <option value="<?= $x['id'] ?>" <?php if ($x['id'] == $data['gudang_id']) echo 'selected'; ?>><?= $x['nama_gudang'] ?></option>
          <?php
          }
          ?>
        </select>
      </div>
    </td>
  </tr>
<?php
}
?>