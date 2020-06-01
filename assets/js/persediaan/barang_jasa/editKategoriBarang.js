function formCheck() {
  nama_kategori = $('#nama_kategori').val();

  if (nama_kategori != '')
    return true;
  else {
    if (nama_kategori != '') {
      $('#nama_kategori').removeClass("input-error");
      $('#error-nama-kosong').hide();
    } else {
      $('#nama_kategori').addClass("input-error");
      $('#error-nama-kosong').show();
    }
    scrollToTop();
    return false;
  }
}

$(document).ready(function () {
  $('#form-tambah-kategori').submit(function (event) {
    event.preventDefault();

    if (formCheck()) {
      $.ajax({
        url: base_url + "Persediaan/BarangJasa/editKategoriBarang/" + $('#id_kategori_barang').val(), // URL tujuan
        type: "POST", // Tentukan type nya POST atau GET
        data: $(this).serialize(), // Ambil semua data yang ada didalam tag form
        dataType: "json",
        beforeSend: function (e) {
          if (e && e.overrideMimeType) {
            e.overrideMimeType("application/jsoncharset=UTF-8")
          }
        },
        success: function (response) {
          // sukses
          window.location.replace(response);
        },
        error: function (xhr, ajaxOptions, thrownError) {
          // error
          alert(xhr.responseText) // munculkan alert
        }
      });
    }
  });
});