<div class="d-flex justify-content-between">
  <div>
    <div class="mb-1"><strong>#Kode Invoice</strong></div>
    <div><?= $invoice[0]['kode_invoice']; ?></div>
    <div class="mb-1 mt-2"><strong>Nama Customer</strong></div>
    <div><?= $invoice[0]['c_nama']; ?></div>
    <div class="mb-1 mt-2"><strong>Kontak Customer</strong></div>
    <div>
      <?php
      if ($invoice[0]['email'] != "")
        echo $invoice[0]['email'];
      else
        echo $invoice[0]['cp'];
      ?>
    </div>
    <div class="mb-1 mt-2"><strong>Metode Pembayaran</strong></div>
    <div><?= $invoice[0]['jenis_pembayaran']; ?></div>
  </div>
  <div>
    <div class="mb-1"><strong>Dibuat</strong></div>
    <div>
      <?= date('j F Y H:i', $invoice[0]['time']); ?>
    </div>
    <div class="mb-1 mt-2"><strong>Karyawan</strong></div>
    <div><?= $invoice[0]['k_nama']; ?></div>
    <div class="mb-1 mt-2"><strong>Toko</strong></div>
    <div><?= $invoice[0]['t_nama']; ?></div>
    <div class="mb-1 mt-2"><strong>Status</strong></div>
    <div>
      <?php if ($invoice[0]['status'] == 0) echo 'Sukses';
      else if ($invoice[0]['status'] == 1) echo 'Refund Sebagian';
      else if ($invoice[0]['status'] == 2) echo 'Refund'; ?>
    </div>
  </div>
</div>
<hr>
<h6 class="mt-4 mb-3"><strong>Detail Produk Terjual</strong></h6>
<div class="w-100">
  <table class="table table-bordered" cellspacing="0" style="border-right: 0;border-left:0;">
    <thead>
      <tr>
        <th style="border-left:0">No</th>
        <th>SKU</th>
        <th>Harga</th>
        <th>Qty</th>
        <th>Diskon</th>
        <th>Subtotal</th>
        <th style="border-right:0">Status</th>
      </tr>
    </thead>
    <tfoot>
      <tr>
        <th colspan="5" style="border-left:0">
          <p class="text-right mr-4 my-0">Total</p>
        </th>
        <th style="border-right:0"><?= 'Rp ' . number_format($invoice[0]['total'], 0, ',', '.'); ?></th>
        <th></th>
      </tr>
    </tfoot>
    <tbody id="data-table-kategori">
      <?php
      $no = 1;
      foreach ($items as $data) {
        ?>
        <tr>
          <td style="border-left:0"><?= $no; ?></td>
          <td><?= $data['sku']; ?></td>
          <td><?= 'Rp ' . number_format($data['harga'], 0, ',', '.'); ?></td>
          <td><?= $data['qty']; ?></td>
          <td><?= 'Rp ' . number_format($data['diskon'], 0, ',', '.'); ?></td>
          <td><?= 'Rp ' . number_format($data['subtotal'], 0, ',', '.'); ?></td>
          <td class="text-center" style="border-right:0">
            <?php if ($data['status'] == 0) { ?>
              <span class="badge badge-pill badge-success">Sukses</span>
            <?php } else if ($data['status'] == 1) { ?>
              <span class="badge badge-pill badge-warning">Refund<br>Sebagian</span>
            <?php } else { ?>
              <span class="badge badge-pill badge-danger">Refund</span>
            <?php } ?>
          </td>
        </tr>
      <?php
        $no++;
      } ?>
    </tbody>
  </table>
</div>