function formCheck() {
  nama_gudang = $('#nama_gudang').val();
  penanggung_jawab = $('#penanggung_jawab').val();

  if (nama_gudang != '' && penanggung_jawab != '')
    return true;
  else {
    if (nama_gudang != '') {
      $('#nama_gudang').removeClass("input-error");
      $('#error-nama-kosong').hide();
    } else {
      $('#nama_gudang').addClass("input-error");
      $('#error-nama-kosong').show();
    }
    if (penanggung_jawab != '') {
      $('#penanggung_jawab').removeClass("input-error");
      $('#error-penanggungjawab-kosong').hide();
    } else {
      $('#penanggung_jawab').addClass("input-error");
      $('#error-penanggungjawab-kosong').show();
    }
    scrollToTop();
    return false;
  }
}

var resubmit = false;

$(document).ready(function () {
  $('#form-tambah-gudang').submit(function (event) {
    event.preventDefault();
    if (resubmit)
      return;

    resubmit = true;
    if (formCheck()) {
      $.ajax({
        url: base_url + "Persediaan/DaftarGudang/tambahGudang", // URL tujuan
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
    resubmit = false;
  });
});