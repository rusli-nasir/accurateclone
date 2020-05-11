<div id="table-view" class="table-responsive">
	<table class="table table-bordered">
		<tr>
			<th class="text-center">NO</th>
			<th>NIS</th>
			<th>NAMA</th>
			<th>JENIS KELAMIN</th>
			<th>TELP</th>
			<th>ALAMAT</th>
			<th colspan="2" class="text-center"><span class="glyphicon glyphicon-cog"></span></th>
		</tr>
		<?php
		$no = 1;
		foreach ($model as $data) {
			?>
		<tr>
			<td class="align-middle text-center"><?php echo $no; ?></td>
			<td class="align-middle"><?php echo $data->nis; ?></td>
			<td class="align-middle"><?php echo $data->nama; ?></td>
			<td class="align-middle"><?php echo $data->jenis_kelamin; ?></td>
			<td class="align-middle"><?php echo $data->telp; ?></td>
			<td class="align-middle"><?php echo $data->alamat; ?></td>
			<td class="align-middle text-center">
				<a href="#" data-id="<?php echo $data->id; ?>" data-toggle="modal" data-target="#form-modal" class="btn btn-default btn-form-ubah"><span class="glyphicon glyphicon-pencil"></span></a>

				<!-- Membuat sebuah textbox hidden yang akan digunakan untuk form ubah -->
				<input type="hidden" class="nis-value" value="<?php echo $data->nis; ?>">
				<input type="hidden" class="nama-value" value="<?php echo $data->nama; ?>">
				<input type="hidden" class="jeniskelamin-value" value="<?php echo $data->jenis_kelamin; ?>">
				<input type="hidden" class="telp-value" value="<?php echo $data->telp; ?>">
				<input type="hidden" class="alamat-value" value="<?php echo $data->alamat; ?>">
			</td>
			<td class="align-middle text-center">
				<a href="javascript:void();" data-id="<?php echo $data->id; ?>" data-toggle="modal" data-target="#delete-modal" class="btn btn-danger btn-alert-hapus"><span class="glyphicon glyphicon-erase"></span></a>
			</td>
		</tr>
		<?php
			$no++; // Tambah 1 setiap kali looping
		}
		?>
	</table>
</div>