function formCheck() {
  nama = $('#nama').val();

  if (nama != '') {
    $('#nama').removeClass("input-error");
    $('#error-nama-kosong').hide();
    return true;
  } else {
    if (nama == '') {
      $('#nama').addClass("input-error");
      $('#error-nama-kosong').show();
    } else {
      $('#nama').removeClass("input-error");
      $('#error-nama-kosong').hide();
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