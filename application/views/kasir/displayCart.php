<?php
if ($cart = $this->cart->contents()) {
  foreach ($cart as $item) {
    ?>
    <div class="barang-pembayaran barang<?= $item['rowid']; ?>">
      <div>
        <img src="<?php if ($item['image'] == "") echo base_url('upload/produk/') . 'noimage.png';
                      else echo base_url('upload/produk/') . $item['image']; ?>">
      </div>
      <div class="deskripsi-barang-pembayaran d-flex flex-column w-100">
        <span style="font-size: 0.9rem"><strong><?= $item['id']; ?></strong></span>
        <span style="font-size: 0.9rem;margin-bottom: 5px;"><?= $item['name']; ?></span>
        <span style="font-size: 0.8rem">Harga : Rp<?= number_format($item['price'], 0, ',', '.'); ?></span>
        <span style="font-size: 0.8rem">Diskon : Rp<?= number_format($item['diskon'], 0, ',', '.'); ?></span>
        <span style="font-size: 0.8rem">Subtotal : Rp<?= number_format(($item['price'] * $item['qty']) - ($item['diskon'] * $item['qty']), 0, ',', '.'); ?></span>
      </div>
      <div class="text-center">
        <span style="font-size: 0.8rem">Qty</span>
        <div class="container-qty">
          <span class="qty-barang-pembayaran"><strong><?= $item['qty']; ?></strong></span>
        </div>
      </div>
      <div class="text-center ml-3">
        <button type="button" class="clear-btn-style btn-tambah-beli" rel="<?= $item['id']; ?>" style="font-size:1.5rem">
          <input type="hidden" class="qty-tersedia" value="<?= $item['max_beli']; ?>" style="width:40px;">
          <i class="fas fa-chevron-circle-up"></i>
        </button>
        <button type="button" class="clear-btn-style btn-kurang-beli" rel="<?= $item['id']; ?>" style="font-size:1.5rem">
          <input type="hidden" class="cart-rowid" value="<?= $item['rowid']; ?>" style="width:40px;">
          <input type="hidden" class="bk-qty-terbeli" value="<?= $item['qty']; ?>" style="width:40px;">
          <i class="fas fa-chevron-circle-down"></i>
        </button>

      </div>
      <a type="button" rel="" class="btn btn-danger btn-circle btn-sm text-white ml-3" onclick="javascript:deleteOne('<?= $item['rowid']; ?>')">
        <i class="fas fa-trash"></i>
      </a>
    </div>
  <?php
    }
    ?>
<?php
}
?>