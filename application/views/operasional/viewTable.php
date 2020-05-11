<?php
$no = 1;
foreach ($ops as $data) {
?>

  <tr>
    <td><?= $no; ?></td>
    <td>
      <a href="" rel='<?= $data['id']; ?>' class="click-to-edit"><?= $data['keperluan']; ?></a>
    </td>
    <td><?= 'Rp ' . number_format($data['biaya'], 0, "", "."); ?></td>
    <td><?= $data['jenis_uang']; ?></td>
    <td><?= date('j-n-Y', strtotime($data['created_at'])); ?></td>
  </tr>

<?php $no++;
}
?>