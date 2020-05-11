<?php if ($model !== null) {
  foreach ($model as $data) {
    ?>
    <tr class="row-notifikasi" <?php if ($data['is_baca'] == 1) echo 'style="background-color:#d2e9d7"'; ?>>
      <input type="hidden" value="<?= $data['is_baca']; ?>" class="row-is_baca">
      <input type="hidden" value="<?= $data['id']; ?>" class="row-id">
      <td><?= date('d/m/Y H:i', $data['waktu']); ?></td>
      <td><?= $data['deskripsi']; ?></td>
      <td>
        <?php if ($data['is_baca'] == 0) { ?>
          <span class="badge badge-danger">Belum dibaca</span>
        <?php } else { ?>
          <span class="badge badge-success">Sudah dibaca</span>
        <?php } ?>
      </td>
    </tr>
<?php
  }
}
?>