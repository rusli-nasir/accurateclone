<?php
function getRandomRowId()
{
  $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
  return substr(str_shuffle($permitted_chars), 0, 10);
}

foreach ($model as $data) {
  $random_row_id = getRandomRowId();
  $data['qty_terkirim'] = $data['qty_terkirim'] * -1;
?>
  <tr id="row_barang_<?= $random_row_id ?>" data-id="<?= $data['id_barang_pesanan'] ?>" data-row-id="<?= $random_row_id ?>" data-is-any-before="yes" class="row_barang_added">
    <td>
      <div>
        <?= $data['kode_barang'] ?>
      </div>
    </td>
    <td>
      <?= $data['keterangan'] ?>
    </td>
    <td>
      <div class="form-group">
        <input type="hidden" id="is_delete_<?= $random_row_id ?>" name="update_is_delete[<?= $random_row_id ?>]" value="0">
        <input type="hidden" value="<?= $data['id_barang_pengiriman'] ?>" name="update_id_barang_pengiriman[<?= $random_row_id ?>]">
        <input type="text" class="form-control input_qty" id="update_qty_kirim_<?= $random_row_id ?>" name="update_qty_dikirim[<?= $random_row_id ?>]" value="<?= $data['qty_terkirim'] ?>">
        <span class="text-danger hide-any" id="error-qty-kirim-lebih-dari-stok-<?= $random_row_id ?>">*Qty Dikirim melebihi dari stok tersedia di gudang</span>
      </div>
    </td>
    <td>
      <?= $data['unit'] ?>
    </td>
    <td>
      <div class="form-group">
        <select class="form-control pilih-gudang" name="update_kirim_gudang[<?= $random_row_id ?>]" data-row-id="<?= $random_row_id ?>">
          <option value="kosong">--- Pilih Gudang ---</option>
          <?php
          foreach ($list_gudang as $x) {
          ?>
            <option value="<?= $x['id'] ?>" <?php if ($x['id'] == $data['id_gudang_dikirim']) echo 'selected'; ?>><?= $x['nama_gudang'] ?></option>
          <?php
          }
          ?>
        </select>
      </div>
    </td>
    <td class="edit-column text-center">
      <div class="btn-hapus-row-barang" data-row-id="<?= $random_row_id ?>" data-is-update="yes">
        <i class="fas fa-trash"></i>
      </div>
    </td>
  </tr>
<?php
}
?>