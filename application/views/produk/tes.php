<form action="<?php echo base_url() . 'index.php/produk/upload_image' ?>" method="post" enctype="multipart/form-data">
  <input type="text" name="xjudul" placeholder="Judul">
  <input type="file" name="filefoto">
  <button type="submit">Upload</button>
</form>