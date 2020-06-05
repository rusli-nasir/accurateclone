function formCheck() {
  nama = $('#nama').val();
  alamat = $('#alamat').val();

  if (nama != '' && alamat != '') {
    $('#nama').removeClass("input-error");
    $('#error-nama-kosong').hide();
    $('#alamat').removeClass("input-error");
    $('#error-alamat-kosong').hide();
    return true;
  } else {
    if (nama == '') {
      $('#nama').addClass("input-error");
      $('#error-nama-kosong').show();
    } else {
      $('#nama').removeClass("input-error");
      $('#error-nama-kosong').hide();
    }

    if (alamat == '') {
      $('#alamat').addClass("input-error");
      $('#error-alamat-kosong').show();
    } else {
      $('#alamat').removeClass("input-error");
      $('#error-alamat-kosong').hide();
    }
    return false;
  }
}

$(document).ready(function () {

  $('#form').submit(function () {
    if (formCheck())
      return true;
    else
      return false;
  });
});