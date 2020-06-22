<?php
function getRandomRowId()
{
  $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
  return substr(str_shuffle($permitted_chars), 0, 10);
}
$random_row_id = getRandomRowId();
?>
<tr id="row_barang_<?= $random_row_id ?>" data-id="<?= $data['id_barang_pesanan'] ?>" data-row-id="<?= $random_row_id ?>" class="row_barang_added">
  <td>
    <div>
      <?= $data['kode_barang'] ?>
      <input type="hidden" id="id_barang_<?= $random_row_id ?>" value="<?= $data['id_barang'] ?>">
    </div>
  </td>
  <td>
    <?= $data['keterangan'] ?>
  </td>
  <td>
    <div class="form-group">
      <input type="hidden" value="<?= $data['id_barang'] ?>" name="insert_id_barang[<?= $random_row_id ?>]">
      <input type="text" class="form-control input_qty" id="insert_qty_kirim_<?= $random_row_id ?>" name="insert_qty_dikirim[<?= $random_row_id ?>]" value="0">
      <span class="text-danger hide-any" id="error-qty-kirim-lebih-dari-stok-<?= $random_row_id ?>">*Qty Dikirim melebihi dari stok tersedia di gudang</span>
    </div>
  </td>
  <td>
    <?= $data['unit'] ?>
  </td>
  <td>
    <div class="form-group">
      <select class="form-control pilih-gudang" name="insert_kirim_gudang[<?= $random_row_id ?>]" data-row-id="<?= $random_row_id ?>">
        <option value="kosong">--- Pilih Gudang ---</option>
        <?php
        foreach ($list_gudang as $x) {
        ?>
          <option value="<?= $x['id'] ?>" <?php if ($x['id'] == $data['default_gudang_id']) echo 'selected'; ?>><?= $x['nama_gudang'] ?></option>
        <?php
        }
        ?>
      </select>
    </div>
  </td>
  <td>
    <div class="form-group">
      <input type="text" class="form-control" id="stok_terbaru_<?= $random_row_id ?>" value="<?= $data['stok_terbaru']  ?>" readonly>
    </div>
  </td>
  <td class="edit-column text-center">
    <div class="btn-hapus-row-barang" data-row-id="<?= $random_row_id ?>">
      <i class="fas fa-trash"></i>
    </div>
  </td>
</tr>