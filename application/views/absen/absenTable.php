<div class="container-table100">
  <div class="wrap-table100">
    <div class="table100">
      <table class="custom-table table-absen" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th style="white-space: nowrap">#</th>
            <th>Username</th>
            <th>Jam Kerja</th>
            <th>Absen Masuk</th>
            <th>Foto Masuk</th>
            <th>Absen Pulang</th>
            <th>Foto Pulang</th>
            <th>Toko</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($data !== null) {
            $i = 1;
            foreach ($data as $x) {
          ?>
              <tr>
                <td><?= $i; ?></td>
                <td><?= $x['krywn_username']; ?></td>
                <td>
                  <?php
                  if ($x['time_pulang'] != 0) {
                    $mnt_diff = round(abs($x['time_pulang'] - $x['time_masuk']) / 60, 2);
                    $jam_kerja = floor($mnt_diff / 60);
                    $mnt_kerja = floor($mnt_diff - ($jam_kerja * 60));

                    echo $jam_kerja . ' jam ' . $mnt_kerja . ' menit';
                  } else { ?>
                    <span class="badge badge-danger">Masih Bekerja</span>
                  <?php
                  }
                  ?>
                </td>
                <td><?= date('d/m/Y H:i', $x['time_masuk']); ?></td>
                <td>
                  <a href="<?= base_url('upload/absen/') . $x['foto_masuk']; ?>" data-lightbox="image-1" data-title="<?= 'Absensi pada waktu ' . date('d/m/Y H:i', $x['time_masuk']) . ' oleh ' . $x['krywn_username']; ?>">
                    <img src="<?= base_url('upload/absen/') . $x['foto_masuk']; ?>" style="width: 50px;">
                  </a>
                </td>
                <td>
                  <?php if ($x['time_pulang'] == 0) { ?>
                    <span class="badge badge-danger">Masih Bekerja</span>
                  <?php } else {
                    echo date('d/m/Y H:i', $x['time_pulang']);
                  } ?>
                </td>
                <td>
                  <?php
                  if (empty($x['foto_pulang']) && $x['time_pulang'] == 0) {
                  ?>
                    <a href="<?= base_url('upload/absen/') . 'working.png'; ?>" data-lightbox="image-1" data-title="<?= 'Absensi pada waktu ' . date('d/m/Y H:i', $x['time_pulang']) . ' oleh ' . $x['krywn_username']; ?>">
                      <img src="<?= base_url('upload/absen/') . 'working.png'; ?>" style="width: 50px;">
                    </a>
                  <?php
                  } else if (empty($x['foto_pulang']) && $x['time_pulang'] != 0) {
                  ?>
                    <span class="badge badge-danger">Tidak Absen Pulang</span>
                  <?php
                  } else {
                  ?>
                    <a href="<?= base_url('upload/absen/') . $x['foto_pulang']; ?>" data-lightbox="image-1" data-title="<?= 'Absensi pada waktu ' . date('d/m/Y H:i', $x['time_pulang']) . ' oleh ' . $x['krywn_username']; ?>">
                      <img src="<?= base_url('upload/absen/') . $x['foto_pulang']; ?>" style="width: 50px;">
                    </a>
                  <?php
                  }
                  ?>
                </td>
                <td><?= $x['t_nama']; ?></td>
              </tr>
          <?php
              $i++;
            }
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>