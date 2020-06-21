<thead>
  <tr>
    <th style="width: 30%;">Kode</th>
    <th style="width: 40%;">Keterangan</th>
    <th style="width: 25%;">Stok</th>
    <th style="width: 5%;"></th>
  </tr>
</thead>
<tbody id="data-table-user">
  <?php
  foreach ($model as $x) {
  ?>

    <tr>
      <td><?= $x['kode_barang']; ?></td>
      <td><?= $x['keterangan']; ?></td>
      <td>
        <div class="form-group">
          <input type="text" class="form-control" id="stok_di_gudang_<?= $x['id_barang'] ?>" value="<?= $x['stok']; ?>" readonly>
          <span class="text-danger hide-any" id="error-stok-kosong-<?= $x['id_barang'] ?>">*Barang ini tidak memiliki stok untuk dijual</span>
        </div>
      </td>
      <td class="edit-column text-center">
        <div class="btn-tambah-list-barang" data-id="<?= $x['id_barang'] ?>">
          <i class="fas fa-plus"></i>
        </div>
      </td>
    </tr>

  <?php
  }
  ?>
</tbody>