<?php if ($model !== null) {
  foreach ($model as $data) {
    ?>
    <tr>
      <td><a href="#" class="link-view-invoice" rel="<?= $data->id; ?>"><?= $data->kode_invoice; ?></a> </td>
      <td><?= $data->username; ?></td>
      <td><?= $data->nama; ?></td>
      <td><?= $data->t_nama; ?></td>
      <td><?= $data->jenis_pembayaran; ?></td>
      <td class="total-invoice-table">Rp <?= number_format($data->total, 0, "", "."); ?></td>
      <td class="text-center">
        <?php if ($data->status == 0) { ?>
          <span class="badge badge-pill badge-success">Sukses</span>
        <?php } else if ($data->status == 1) { ?>
          <span class="badge badge-pill badge-warning">Refund Sebagian</span>
        <?php } else { ?>
          <span class="badge badge-pill badge-danger">Refund</span>
        <?php } ?>
      </td>
    </tr>
<?php
  }
}
?>