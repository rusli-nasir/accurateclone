<?php
if ($cust === null) { ?>
  <?php } else {
    $no = 1;
    foreach ($cust as $data) {
      ?>

    <?php if ($mode == 'all') { ?>
      <tr>
        <td><?= $no; ?></td>
        <td><?= $data['nama']; ?></td>
        <td><?= $data['email']; ?></td>
        <td><?= $data['cp']; ?></td>
        <td><?= date('j-n-Y H:i', $data['time']); ?></td>
      </tr>
    <?php } else if ($mode == 'email' && !empty($data['email']) && empty($data['cp'])) { ?>
      <tr>
        <td><?= $no; ?></td>
        <td><?= $data['nama']; ?></td>
        <td><?= $data['email']; ?></td>
        <td><?= $data['cp']; ?></td>
        <td><?= date('j-n-Y H:i', $data['time']); ?></td>
      </tr>
    <?php } else if ($mode == 'cp' && !empty($data['cp']) && empty($data['email'])) { ?>
      <tr>
        <td><?= $no; ?></td>
        <td><?= $data['nama']; ?></td>
        <td><?= $data['email']; ?></td>
        <td><?= $data['cp']; ?></td>
        <td><?= date('j-n-Y H:i', $data['time']); ?></td>
      </tr>
    <?php } ?>
<?php $no++;
  }
} ?>