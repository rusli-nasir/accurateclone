<div class="row">
    <div class="col-12 col-md-8 col-lg-6 mx-auto">

        <?php if ($mode == 'email') { ?>

            <?php if ($status == 'sukses') { ?>
                <div class="alert alert-success" role="alert">
                    Invoice via <?= $mode; ?> berhasil terkirim!
                </div>
            <?php } else { ?>
                <div class="alert alert-success" role="alert">
                    Invoice via <?= $mode; ?> gagal dikirimkan ke customer!
                </div>
            <?php } ?>

            <div class="card">
                <div class="card-header">
                    Invoice <?= $mode; ?>
                </div>
                <div class="card-body text-center">
                    <div>
                    <?php if ($status == 'sukses') { ?>
                        Pengiriman invoice <?= $inv['kode_invoice']; ?> atas nama <?= $inv['c_nama']; ?> sudah berhasil dikirim melalui <?= $mode; ?> ke email <?= $inv['c_email']; ?>.
                    <?php } else { ?>
                        Pengiriman invoice <?= $inv['kode_invoice']; ?> atas nama <?= $inv['c_nama']; ?> melalui <?= $mode; ?> ke <?= $inv['c_email']; ?> gagal dikirimkan. Coba kirim ulang dengan format isian yang benar!
                    <?php } ?>
                    </div>

                    <a href="<?= base_url('LapPenjualan'); ?>" class="btn btn-primary btn-icon-split mt-4 mb-2 load-link">
                        <span class="icon text-white-50">
                            <i class="fas fa-chevron-left"></i>
                        </span>
                        <span class="text">Kembali</span>
                    </a>
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
                    <div class="mt-4 mb-3 d-block">

                        <?php if ($status == 0) { ?>
                            Pengiriman invoice <?= $inv['kode_invoice']; ?> atas nama <?= $inv['c_nama']; ?> sudah berhasil dikirim melalui <?= $mode; ?> ke nomor <?= $inv['c_cp']; ?>.
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
                    
                    <div>
                        <a href="<?= base_url('LapPenjualan'); ?>" class="btn btn-primary btn-icon-split mb-3 load-link">
                            <span class="icon text-white-50">
                                <i class="fas fa-chevron-left"></i>
                            </span>
                            <span class="text">Kembali</span>
                        </a>
                    </div>
                </div>
            </div>

        <?php } ?>

    </div>
</div>