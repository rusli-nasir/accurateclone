<div class="row">
	<div class="col-12 col-md-8 col-lg-6 mx-auto">

		<?php if ($mode == 'email') { ?>

			<div class="card">
				<div class="card-header">
					Invoice <?= $mode; ?>
				</div>
				<div class="card-body text-center">
				</div>
			</div>

		<?php } else { ?>

			<?php if ($status == 0) { ?>
				<div class="alert alert-success" role="alert">
					Invoice via <?= $mode; ?> berhasil terkirim!
				</div>
			<?php } ?>

			<?php if ($status == 5) { ?>
				<div class="alert alert-danger" role="alert">
					Error! Kontak Webmaster!
				</div>
			<?php } ?>

			<?php if ($status == 6 && $status == 89) { ?>
				<div class="alert alert-danger" role="alert">
					Error! Coba Sesaat Lagi!
				</div>
			<?php } ?>

			<?php if ($status == 6 && $status == 99) { ?>
				<div class="alert alert-danger" role="alert">
					Credit SMS habis! Kontak Webmaster!
				</div>
			<?php } ?>

			<div class="card">
				<div class="card-header">
					Invoice <?= $mode; ?>
				</div>
				<div class="card-body text-center">
					<div class="mt-4 mb-3">

						<?php if ($status == 0) { ?>
							Pengiriman invoice <?= $inv['kode_invoice']; ?> atas nama <?= $inv['c_nama']; ?> sudah berhasil dikirim melalui <?= $mode; ?> ke nomor <?= $inv['cp']; ?>.
						<?php } ?>

						<?php if ($status == 5) { ?>
							User / Passkey Zenziva API tidak valid. Kontak webmaster !
						<?php } ?>

						<?php if ($status == 6) { ?>
							Konten SMS tidak disetujui pihak zenziva. Tunggu sesaat lalu coba kirim ulang melalui Laporan Penjualan!
						<?php } ?>

						<?php if ($status == 89) { ?>
							Pengiriman SMS berulang-ulang ke satu nomor yang sama berkali-kali. Coba tunggu sesaat lalu kirim ulang melalui Laporan Penjualan!
						<?php } ?>

						<?php if ($status == 99) { ?>
							Credit SMS Zenziva sudah habis! Mohon kontak Webmaster untuk isi ulang credit!
						<?php } ?>

					</div>

					<a href="<?= base_url('Kasir'); ?>" class="btn btn-primary btn-icon-split mb-3">
						<span class="icon text-white-50">
							<i class="fas fa-chevron-left"></i>
						</span>
						<span class="text">Kembali</span>
					</a>
				</div>
			</div>

		<?php } ?>

	</div>
</div>