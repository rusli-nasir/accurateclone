var status_username = false;

function formCheck() {
  input_nama = $('#input_nama').val();
  input_username = $('#input_username').val();
  input_password = $('#input_password').val();
  input_passconf = $('#input_passconf').val();
  input_divisi = $('#input_divisi').val();

  $.ajax({
    url: base_url + "Daftar/Pengguna/checkUsernameUnique", // URL tujuan
    type: "POST", // Tentukan type nya POST atau GET
    data: 'input_username=' + $('#input_username').val(), // Ambil semua data yang ada didalam tag form
    dataType: "json",
    beforeSend: function (e) {
      if (e && e.overrideMimeType) {
        e.overrideMimeType("application/jsoncharset=UTF-8")
      }
    },
    success: function (response) {
      // sukses
      if (response) {
        if (input_username != '') {
          $('#status-username-unique').show();
          $('#status-username-notunique').hide();
          status_username = true;
        } else {
          $('#status-username-unique').hide();
          $('#status-username-notunique').hide();
          status_username = false;
        }
      } else {
        $('#status-username-unique').hide();
        $('#status-username-notunique').show();
        status_username = false;
      }
    },
    error: function (xhr, ajaxOptions, thrownError) {
      // error
      alert(xhr.responseText) // munculkan alert
    }
  });

  if (input_nama != '' && input_username != '' && input_password != '' && input_passconf != '' && input_password == input_passconf && input_divisi != 0 && status_username) {
    return true;
  } else {
    {
      if (status_username) {
        $('#input_username').removeClass("input-error");
        $('#status-username-unique').show();
        $('#status-username-notunique').hide();
      } else {
        $('#input_username').addClass("input-error");
        $('#status-username-unique').hide();
        $('#status-username-notunique').show();
      }

      if (input_nama == '') {

        $('#input_nama').addClass("input-error");
        $('#error-nama-kosong').show();
      } else {
        $('#input_nama').removeClass("input-error");
        $('#error-nama-kosong').hide();
      }

      if (input_username == '') {
        $('#input_username').addClass("input-error");
        $('#error-username-kosong').show();
      } else {
        $('#input_username').removeClass("input-error");
        $('#error-username-kosong').hide();
      }

      if (input_password == '') {
        $('#input_password').addClass("input-error");
        $('#error-password-kosong').show();
      } else {
        $('#error-password-kosong').hide();
        if (input_password.length < 9) {
          $('#input_password').addClass("input-error");
          $('#error-password-kurang').show();
        } else {
          $('#input_password').removeClass("input-error");
          $('#error-password-kurang').hide();
        }
      }

      if (input_passconf == '') {
        $('#input_passconf').addClass("input-error");
        $('#error-passwordconf-kosong').show();
      } else {
        $('#error-passwordconf-kosong').hide();
        if (input_password != input_passconf) {
          $('#input_passconf').addClass("input-error");
          $('#error-passwordconf-beda').show();
        } else {
          $('#input_passconf').removeClass("input-error");
          $('#error-passwordconf-beda').hide();
        }
      }

      if (input_divisi == 0) {
        $('#input_divisi').addClass("input-error");
        $('#error-divisi-kosong').show();
      } else {
        $('#input_divisi').removeClass("input-error");
        $('#error-divisi-kosong').hide();
      }
    }

    return false;
  }
}

$(document).ready(function () {
  $('#input_username').change(function () {
    $.ajax({
      url: base_url + "Daftar/Pengguna/checkUsernameUnique", // URL tujuan
      type: "POST", // Tentukan type nya POST atau GET
      data: 'input_username=' + $('#input_username').val(), // Ambil semua data yang ada didalam tag form
      dataType: "json",
      beforeSend: function (e) {
        if (e && e.overrideMimeType) {
          e.overrideMimeType("application/jsoncharset=UTF-8")
        }
      },
      success: function (response) {
        // sukses
        if (response) {
          if ($('#input_username').val() != '') {
            $('#status-username-unique').show();
            $('#status-username-notunique').hide();
            status_username = true;
          } else {
            $('#status-username-unique').hide();
            $('#status-username-notunique').hide();
            status_username = false;
          }
        } else {
          $('#status-username-unique').hide();
          $('#status-username-notunique').show();
          status_username = false;
        }
      },
      error: function (xhr, ajaxOptions, thrownError) {
        // error
        alert(xhr.responseText) // munculkan alert
      }
    });
  })
  $('#form-tambah-pengguna').submit(function (event) {
    event.preventDefault();
    if (formCheck()) {
      $.ajax({
        url: base_url + "Daftar/Pengguna/tambahPengguna", // URL tujuan
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
  })
});