<?php
$no = 1;
foreach ($model as $data) {
?>
  <tr>
    <td class="align-middle text-center"><?= $no; ?></td>
    <td class="align-middle">
      <a href="#" data-id="<?= $data->username; ?>" class="open-modal-edit"><?= $data->nama; ?></a>

      <input type="hidden" class="value-nama" value="<?= $data->nama; ?>">
      <input type="hidden" class="value-cp" value="<?= $data->cp; ?>">
      <input type="hidden" class="value-username" value="<?= $data->username; ?>">
      <input type="hidden" class="value-alamat" value="<?= $data->alamat; ?>">
      <input type="hidden" class="value-toko" value="<?= $data->toko_id; ?>">
      <input type="hidden" class="value-shift" value="<?= $data->shift; ?>">
      <input type="hidden" class="value-peran" value="<?= $data->kode_peran; ?>">
      <input type="hidden" class="value-jml-gaji" value="<?= $data->jumlah_gaji; ?>">
      <input type="hidden" class="temp-value-jml-gaji" value="<?= $data->jumlah_gaji; ?>">
      <input type="hidden" class="value-tgl-gaji" value="<?= $data->tanggal_gaji; ?>">
      <input type="hidden" class="temp-value-tgl-gaji" value="<?= $data->tanggal_gaji; ?>">
      <input type="hidden" class="value-is-active" value="<?= $data->is_active; ?>">
    </td>
    <td class="align-middle">
      <?php
      if ($data->kode_peran == 1)
        echo "Web Administrator";
      else if ($data->kode_peran == 2)
        echo "Owner";
      else if ($data->kode_peran == 3)
        echo "Admin";
      else
        echo "Karyawan";
      ?>
    </td>
    <td class="align-middle">
      <?php
      if ($data->kode_peran == 1 || $data->kode_peran == 2) {
        echo "-";
      } else {
        $DateTime = DateTime::createFromFormat('Y-m-d', $data->tanggal_gaji);
        echo $DateTime->format('j F');
      }
      ?>
    </td>
    <td class="align-middle">
      <?php
      if ($data->kode_peran == 1 || $data->kode_peran == 2) {
        echo "-";
      } else {
        echo "Rp " . number_format($data->jumlah_gaji, 0, ',', '.');
      }
      ?>

    </td>
    <td class="align-middle">
      <?php
      if ($data->is_active == 1) {
        echo '<span class="badge badge-primary status-aktif">ya</span>';
      } else {
        echo '<span class="badge badge-danger status-aktif">tidak</span>';
      }
      ?>
    </td>
  </tr>
<?php
  $no++; // Tambah 1 setiap kali looping
}
?>