<?php
foreach ($list_barang_beli as $data) {
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
      <?= $data['qty_beli'] - $data['qty_diterima'] ?>
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
        <select class="form-control pilih-gudang" name="insert_terima_gudang[<?= $data['id_barang_beli'] ?>]">
          <?php
          foreach ($gudang as $x) {
          ?>
            <option value="<?= $x['id'] ?>" <?php if ($x['id'] == $data['default_gudang_id']) echo 'selected'; ?>><?= $x['nama_gudang'] ?></option>
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