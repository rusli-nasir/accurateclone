<?php
foreach ($model as $data) {
  ?>
  <tr>
    <td class="align-middle text-center"></td>
    <td class="align-middle">
      <a href="#" data-id="<?= $data->id; ?>" class="open-modal-edit"><?= $data->nama; ?></a>
      <input type="hidden" class="value-nama" value="<?= $data->nama; ?>">
    </td>
  </tr>
<?php
}
?>