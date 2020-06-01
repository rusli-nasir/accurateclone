<?php
foreach ($model as $x) {
?>
  <tr>
    <td></td>
    <td><?= $x['nama_kategori'] ?></td>
    <td class="edit-column text-center">
      <a href="<?= base_url('Persediaan/BarangJasa/editKategoriBarang/') . $x['id']; ?>">
        <i class="fas fa-edit"></i>Edit
      </a>
    </td>
  </tr>

<?php
}
?>