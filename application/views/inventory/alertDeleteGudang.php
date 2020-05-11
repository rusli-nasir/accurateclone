<?php
$no = 1;
foreach ($model as $data) { ?>
  <?= $no; ?>. <?= $data['nama']; ?><br>
<?php $no++;
} ?>