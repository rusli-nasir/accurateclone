var nilai_form_sebelum_edit = '';

$(document).ready(function () {
  { // Event tiap checkboxes
    // Check All
    $("#check_all_fitur").click(function () {
      $('input:checkbox').not(this).prop('checked', this.checked);
    });

    // Persediaan
    $('#persediaan').click(function () {
      $('.persediaan').not(this).prop('checked', this.checked);
    });
    $('.persediaan').change(function () {
      if ($('.persediaan:input:checked').length > 0) {
        $('#persediaan').prop('checked', true);
      } else
        $('#persediaan').prop('checked', false);
    });


    // Penjualan
    $('#penjualan').click(function () {
      $('.penjualan').not(this).prop('checked', this.checked);
    });
    $('.penjualan').change(function () {
      if ($('.penjualan:input:checked').length > 0) {
        $('#penjualan').prop('checked', true);
      } else
        $('#penjualan').prop('checked', false);
    });

    // Pembelian
    $('#pembelian').click(function () {
      $('.pembelian').not(this).prop('checked', this.checked);
    });
    $('.pembelian').change(function () {
      if ($('.pembelian:input:checked').length > 0) {
        $('#pembelian').prop('checked', true);
      } else
        $('#pembelian').prop('checked', false);
    });
    // Daftar
    $('#daftar').click(function () {
      $('.daftar').not(this).prop('checked', this.checked);
    });
    $('.daftar').change(function () {
      if ($('.daftar:input:checked').length > 0) {
        $('#daftar').prop('checked', true);
      } else
        $('#daftar').prop('checked', false);
    });
  }

  nilai_form_sebelum_edit = $('#form-edit').serialize();

  $('#form-edit').submit(function () {
    if (!$('#nama_divisi').val()) {
      $('.error_nama_divisi').show();
      $('#nama_divisi').addClass("input-error");
      scrollToTop();
      return false;
    } else {
      $('.error_nama_divisi').hide();

      if (nilai_form_sebelum_edit == $(this).serialize()) {
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
        return false;
      } else {
        return true;
      }

      return false;
    }
    return false;
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