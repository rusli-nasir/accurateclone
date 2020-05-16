var nilai_form_sebelum_edit = '';

function gabungSemuaValue() {
  nama_divisi = $('#nama_divisi').val();
  temp = 'nama_divisi=' + nama_divisi;

  // Gabung value ke temp
  if ($('#buku_besar').is(":checked"))
    temp = temp + '&buku_besar=on';
  form_buku_besar = $('#form_buku_besar').serialize();
  if (form_buku_besar != '')
    temp = temp + '&' + form_buku_besar;

  if ($('#kas_bank').is(":checked"))
    temp = temp + '&kas_bank=on';
  form_kas_bank = $('#form_kas_bank').serialize();
  if (form_kas_bank != '')
    temp = temp + '&' + form_kas_bank;

  if ($('#persediaan').is(":checked"))
    temp = temp + '&persediaan=on';
  form_persediaan = $('#form_persediaan').serialize();
  if (form_persediaan != '')
    temp = temp + '&' + form_persediaan;

  if ($('#penjualan').is(":checked"))
    temp = temp + '&penjualan=on';
  form_penjualan = $('#form_penjualan').serialize();
  if (form_penjualan != '')
    temp = temp + '&' + form_penjualan;

  if ($('#pembelian').is(":checked"))
    temp = temp + '&pembelian=on';
  form_pembelian = $('#form_pembelian').serialize();
  if (form_pembelian != '')
    temp = temp + '&' + form_pembelian;

  if ($('#aset_tetap').is(":checked"))
    temp = temp + '&aset_tetap=on';
  form_aset_tetap = $('#form_aset_tetap').serialize();
  if (form_aset_tetap != '')
    temp = temp + '&' + form_aset_tetap;

  if ($('#daftar').is(":checked"))
    temp = temp + '&daftar=on';
  form_daftar = $('#form_daftar').serialize();
  if (form_daftar != '')
    temp = temp + '&' + form_daftar;

  if ($('#rma').is(":checked"))
    temp = temp + '&rma=on';
  form_rma = $('#form_rma').serialize();
  if (form_rma != '')
    temp = temp + '&' + form_rma;

  if ($('#efaktur').is(":checked"))
    temp = temp + '&efaktur=on';
  form_efaktur = $('#form_efaktur').serialize();
  if (form_efaktur != '')
    temp = temp + '&' + form_efaktur;

  return temp;
}

$(document).ready(function () {
  { // Init
    $('#container-wait').show();
    $.ajax({
      url: base_url + "Daftar/Pengguna/AJAXGetListOfMenuAndFeaturesId", // URL tujuan
      type: "GET", // Tentukan type nya POST atau GET
      dataType: "json",
      beforeSend: function (e) {
        if (e && e.overrideMimeType) {
          e.overrideMimeType("application/jsoncharset=UTF-8")
        }
      },
      success: function (response) {
        // sukses
        menu = response[0];
        fitur = response[1];

        menu.forEach(function (data) {
          id_from_server = '#' + data.html_id_menu + '-x';
          id_for_form = '#' + data.html_id_menu;
          value_from_server = $(id_from_server).val();

          if (value_from_server == 1)
            $(id_for_form).prop('checked', true);
        });

        i = 0;
        fitur.forEach(function (data) {
          id_from_server = '#' + data.html_id_fitur + '-x';
          id_for_form = '#' + data.html_id_fitur;
          value_from_server = $(id_from_server).val();
          if (value_from_server == 1) {
            $(id_for_form).prop('checked', true);
          }
        });

        // Set value sebelum edit untuk compare
        nilai_form_sebelum_edit = gabungSemuaValue();

        $('#container-wait').hide();
      },
      error: function (xhr, ajaxOptions, thrownError) {
        // error
        alert(xhr.responseText) // munculkan alert
        $('#container-wait').hide();
      }
    });
  }

  { // Event tiap checkboxes
    // Check All
    $("#check_all_fitur").click(function () {
      $('input:checkbox').not(this).prop('checked', this.checked);
    });

    // Buku Besar
    $('#buku_besar').click(function () {
      $('.buku_besar').not(this).prop('checked', this.checked);
    });
    $('.buku_besar').change(function () {
      if ($('#form_buku_besar input:checked').length > 0) {
        $('#buku_besar').prop('checked', true);
      } else
        $('#buku_besar').prop('checked', false);
    });

    // Kas Bank
    $('#kas_bank').click(function () {
      $('.kas_bank').not(this).prop('checked', this.checked);
    });
    $('.kas_bank').change(function () {
      if ($('#form_kas_bank input:checked').length > 0) {
        $('#kas_bank').prop('checked', true);
      } else
        $('#kas_bank').prop('checked', false);
    });

    // Persediaan
    $('#persediaan').click(function () {
      $('.persediaan').not(this).prop('checked', this.checked);
    });
    $('.persediaan').change(function () {
      if ($('#form_persediaan input:checked').length > 0) {
        $('#persediaan').prop('checked', true);
      } else
        $('#persediaan').prop('checked', false);
    });

    // Penjualan
    $('#penjualan').click(function () {
      $('.penjualan').not(this).prop('checked', this.checked);
    });
    $('.penjualan').change(function () {
      if ($('#form_penjualan input:checked').length > 0) {
        $('#penjualan').prop('checked', true);
      } else
        $('#penjualan').prop('checked', false);
    });

    // Pembelian
    $('#pembelian').click(function () {
      $('.pembelian').not(this).prop('checked', this.checked);
    });
    $('.pembelian').change(function () {
      if ($('#form_pembelian input:checked').length > 0) {
        $('#pembelian').prop('checked', true);
      } else
        $('#pembelian').prop('checked', false);
    });

    // Aset Tetap
    $('#aset_tetap').click(function () {
      $('.aset_tetap').not(this).prop('checked', this.checked);
    });
    $('.aset_tetap').change(function () {
      if ($('#form_aset_tetap input:checked').length > 0) {
        $('#aset_tetap').prop('checked', true);
      } else
        $('#aset_tetap').prop('checked', false);
    });

    // Aset Tetap
    $('#aset_tetap').click(function () {
      $('.aset_tetap').not(this).prop('checked', this.checked);
    });
    $('.aset_tetap').change(function () {
      if ($('#form_aset_tetap input:checked').length > 0) {
        $('#aset_tetap').prop('checked', true);
      } else
        $('#aset_tetap').prop('checked', false);
    });

    // Daftar
    $('#daftar').click(function () {
      $('.daftar').not(this).prop('checked', this.checked);
    });
    $('.daftar').change(function () {
      if ($('#form_daftar input:checked').length > 0) {
        $('#daftar').prop('checked', true);
      } else
        $('#daftar').prop('checked', false);
    });

    // RMA
    $('#rma').click(function () {
      $('.rma').not(this).prop('checked', this.checked);
    });
    $('.rma').change(function () {
      if ($('#form_rma input:checked').length > 0) {
        $('#rma').prop('checked', true);
      } else
        $('#rma').prop('checked', false);
    });

    // E-Faktur
    $('#efaktur').click(function () {
      $('.efaktur').not(this).prop('checked', this.checked);
    });
    $('.efaktur').change(function () {
      if ($('#form_efaktur input:checked').length > 0) {
        $('#efaktur').prop('checked', true);
      } else
        $('#efaktur').prop('checked', false);
    });
  }

  $('#btn-save-edit-pengguna').click(function () {
    nama_divisi = $('#nama_divisi').val();
    if (!nama_divisi) {
      $('.error_nama_divisi').show();
      $('#nama_divisi').addClass("input-error");
      scrollToTop();
    } else {
      $('.error_nama_divisi').hide();

      serializedForm = gabungSemuaValue();

      if (serializedForm == nilai_form_sebelum_edit) {
        $.confirm({
          title: 'Error',
          content: 'Data divisi tidak ada yang dirubah.',
          type: 'red',
          typeAnimated: true,
          buttons: {
            CLOSE: function () {
              window.location.replace(base_url + 'Daftar/Pengguna');
            }
          }
        });
      } else {
        divisi_id = $('#divisi_id').val();
        $.ajax({
          url: base_url + "Daftar/Pengguna/editDivisi/" + divisi_id, // URL tujuan
          type: "POST", // Tentukan type nya POST atau GET
          data: serializedForm, // Ambil semua data yang ada didalam tag form
          dataType: "json",
          beforeSend: function (e) {
            if (e && e.overrideMimeType) {
              e.overrideMimeType("application/jsoncharset=UTF-8")
            }
          },
          success: function (response) {
            // sukses
            // console.log(response);
            window.location.replace(response);
          },
          error: function (xhr, ajaxOptions, thrownError) {
            // error
            console.log(xhr.responseText) // munculkan alert
          }
        });

      }
    }
  });

  $('#btn-delete-pengguna').click(function () {
    divisi_id = $('#divisi_id').val();

    $.confirm({
      title: 'Hapus Data Karyawan',
      content: 'Anda yakin ingin menghapus data karyawan ini?',
      type: 'red',
      typeAnimated: true,
      buttons: {
        delete: {
          text: 'DELETE',
          btnClass: 'btn-red',
          action: function () {
            window.location.replace(base_url + 'Daftar/Pengguna/hapusDivisi/' + divisi_id);
          }
        },
        close: {
          text: 'CANCEL',
          action: function () {}
        }
      }
    });
  });

});