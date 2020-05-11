	// Fungsi ini akan dipanggil ketika tombol edit diklik
	$('#view-table').on('click', '.open-modal-edit', function () { // Ketika tombol dengan class btn-form-ubah pada div view di klik
		username = $(this).data('id') // Set variabel id dengan id yang kita set pada atribut data-id pada tag button edit

		$('#btn-save').hide() // Sembunyikan tombol simpan
		$('#btn-save-edit').show() // Munculkan tombol ubah

		// Set judul modal dialog menjadi Form Ubah Data
		$('#judul-modal-header').html('Edit Data Pengguna')

		var tr = $(this).closest('tr') // Cari tag tr paling terdekat
		var nama = tr.find('.value-nama').val() // Ambil nis dari input type hidden
		var cp = tr.find('.value-cp').val() // Ambil nis dari input type hidden
		var username = tr.find('.value-username').val() // Ambil nis dari input type hidden
		var password = tr.find('.value-password').val() // Ambil nis dari input type hidden
		var peran = tr.find('.value-peran').val() // Ambil nis dari input type hidden
		var jml_gaji = tr.find('.value-jml-gaji').val() // Ambil nis dari input type hidden
		var tgl_gaji = tr.find('.value-tgl-gaji').val() // Ambil nis dari input type hidden
		var is_active = tr.find('.value-is-active').val() // Ambil nis dari input type hidden

		$('#input_nama').val(nama) // Set value dari textbox nis yang ada di form
		$('#input_cp').val(cp) // Set value dari textbox nama yang ada di form
		$('#input_username').val(username) // Set value dari textbox nama yang ada di form
		$('#input_password').val(password) // Set value dari textbox nama yang ada di form
		// Peran
		$("#peran1").removeAttr('checked');
		$("#peran2").removeAttr('checked');
		$("#peran3").removeAttr('checked');
		if (peran == 1) {
			$("#peran1").attr('checked');
		} else if (peran == 2) {
			$("#peran2").attr('checked');
		} else {
			$("#peran3").attr('checked');
		}
		$('#input_jml_gaji').val(jml_gaji) // Set value dari textbox nama yang ada di form
		$('#input_tgl_gaji').val(tgl_gaji) // Set value dari textbox nama yang ada di form
		// Is_active
		if (is_active == 1)
			$("#input_is_active").attr('checked');
		else
			$("#input_is_active").removeAttr('checked');

		$('#custom-modal').addClass("show-modal")
	})