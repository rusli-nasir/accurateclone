<div class="row">
  <div class="col-12">
    <h4 class="mb-3">Tambah Divisi Baru</h4>
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col-4 pr-5">

            <h5 class="mb-4">Informasi Divisi</h5>
            <div class="form-group">
              <label for="input_nama">Nama Divisi<span style="color: red">*</span></label>
              <input type="text" class="form-control" name="nama_divisi" id="nama_divisi" maxlength="50">
              <span class="error_nama_divisi hide-any text-danger">Nama Divisi Harus Di Isi</span>
            </div>

          </div>

          <div class="col-8">
            <h5 class="mb-4">Hak Akses Fitur</h5>

            <div class="form-group mb-3">
              <input type="checkbox" name="check_all_fitur" id="check_all_fitur">
              <label for="check_all_fitur">Check All</label>
            </div>

            <div class="row">
              <div class="col-6">

                <div class="mb-2">
                  <div class="form-group m-0">
                    <input type="checkbox" name="buku_besar" id="buku_besar">
                    <label for=" buku_besar">Buku Besar</label>
                  </div>

                  <form id="form_buku_besar">

                    <div class="form-group ml-3 m-0">
                      <input type="checkbox" name="info_perusahaan" id="info_perusahaan" class="buku_besar">
                      <label for="info_perusahaan">Info Perusahaan</label>
                    </div>
                    <div class="form-group ml-3 m-0">
                      <input type="checkbox" name="mata_uang" id="mata_uang" class="buku_besar">
                      <label for="mata_uang">Mata Uang</label>
                    </div>
                    <div class="form-group ml-3 m-0">
                      <input type="checkbox" name="daftar_akun" id="daftar_akun" class="buku_besar">
                      <label for="daftar_akun">Daftar Akun</label>
                    </div>
                    <div class="form-group ml-3 m-0">
                      <input type="checkbox" name="laporan_keuangan" id="laporan_keuangan" class="buku_besar">
                      <label for="laporan_keuangan">Laporan Keuangan</label>
                    </div>
                    <div class="form-group ml-3 m-0">
                      <input type="checkbox" name="bukti_jurnal" id="bukti_jurnal" class="buku_besar">
                      <label for="bukti_jurnal">Bukti Jurnal Umum</label>
                    </div>
                    <div class="form-group ml-3 m-0">
                      <input type="checkbox" name="proses_akhir_bulan" id="proses_akhir_bulan" class="buku_besar">
                      <label for="proses_akhir_bulan">Proses Akhir Bulan</label>
                    </div>

                  </form>
                </div>

                <div class="mb-2">
                  <div class="form-group m-0">
                    <input type="checkbox" name="kas_bank" id="kas_bank">
                    <label for="kas_bank">Kas Bank</label>
                  </div>

                  <form id="form_kas_bank">

                    <div class="form-group ml-3 m-0">
                      <input type="checkbox" name="buku_bank" id="buku_bank" class="kas_bank">
                      <label for="buku_bank">Buku Bank</label>
                    </div>
                    <div class="form-group ml-3 m-0">
                      <input type="checkbox" name="penerimaan" id="penerimaan" class="kas_bank">
                      <label for="penerimaan">Penerimaan</label>
                    </div>
                    <div class="form-group ml-3 m-0">
                      <input type="checkbox" name="pembayaran" id="pembayaran" class="kas_bank">
                      <label for="pembayaran">Pembayaran</label>
                    </div>
                    <div class="form-group ml-3 m-0">
                      <input type="checkbox" name="rekonsiliasi_bank" id="rekonsiliasi_bank" class="kas_bank">
                      <label for="rekonsiliasi_bank">Rekonsiliasi Bank</label>
                    </div>
                  </form>
                </div>

                <div class="mb-2">
                  <div class="form-group m-0">
                    <input type="checkbox" name="persediaan" id="persediaan">
                    <label for="persediaan">Persediaan</label>
                  </div>

                  <form id="form_persediaan">

                    <div class="form-group ml-3 m-0">
                      <input type="checkbox" name="daftar_gudang" id="daftar_gudang" class="persediaan">
                      <label for="daftar_gudang">Daftar Gudang</label>
                    </div>
                    <div class="form-group ml-3 m-0">
                      <input type="checkbox" name="grup" id="grup" class="persediaan">
                      <label for="grup">Grup</label>
                    </div>
                    <div class="form-group ml-3 m-0">
                      <input type="checkbox" name="barang_dan_jasa" id="barang_dan_jasa" class="persediaan">
                      <label for="barang_dan_jasa">Barang dan Jasa</label>
                    </div>
                    <div class="form-group ml-3 m-0">
                      <input type="checkbox" name="penyesuaian_persediaan" id="penyesuaian_persediaan" class="persediaan">
                      <label for="penyesuaian_persediaan">Penyesuaian Persediaan</label>
                    </div>
                    <div class="form-group ml-3 m-0">
                      <input type="checkbox" name="pembiayaan_pesanan" id="pembiayaan_pesanan" class="persediaan">
                      <label for="pembiayaan_pesanan">Pembiayaan Pesanan</label>
                    </div>
                    <div class="form-group ml-3 m-0">
                      <input type="checkbox" name="set_harga_penjualan" id="set_harga_penjualan" class="persediaan">
                      <label for="set_harga_penjualan">Set Harga Penjualan</label>
                    </div>
                    <div class="form-group ml-3 m-0">
                      <input type="checkbox" name="pindah_barang" id="pindah_barang" class="persediaan">
                      <label for="pindah_barang">Pindah Barang</label>
                    </div>
                  </form>
                </div>

                <div class="mb-2">
                  <div class="form-group m-0">
                    <input type="checkbox" name="penjualan" id="penjualan">
                    <label for="penjualan">Penjualan</label>
                  </div>

                  <form id="form_penjualan">

                    <div class="form-group ml-3 m-0">
                      <input type="checkbox" name="penawaran_penjualan" id="penawaran_penjualan" class="penjualan">
                      <label for="penawaran_penjualan">Penawaran Penjualan</label>
                    </div>
                    <div class="form-group ml-3 m-0">
                      <input type="checkbox" name="pesanan_penjualan" id="pesanan_penjualan" class="penjualan">
                      <label for="pesanan_penjualan">Pesanan Penjualan</label>
                    </div>
                    <div class="form-group ml-3 m-0">
                      <input type="checkbox" name="pengiriman_pesanan" id="pengiriman_pesanan" class="penjualan">
                      <label for="pengiriman_pesanan">Pengiriman Pesanan</label>
                    </div>
                    <div class="form-group ml-3 m-0">
                      <input type="checkbox" name="faktur_penjualan" id="faktur_penjualan" class="penjualan">
                      <label for="faktur_penjualan">Faktur Penjualan</label>
                    </div>
                    <div class="form-group ml-3 m-0">
                      <input type="checkbox" name="penerimaan_penjualan" id="penerimaan_penjualan" class="penjualan">
                      <label for="penerimaan_penjualan">Penerimaan Penjualan</label>
                    </div>
                    <div class="form-group ml-3 m-0">
                      <input type="checkbox" name="retur_penjualan" id="retur_penjualan" class="penjualan">
                      <label for="retur_penjualan">Retur Penjualan</label>
                    </div>

                  </form>
                </div>

              </div>

              <div class="col-6">

                <div class="mb-2">
                  <div class="form-group m-0">
                    <input type="checkbox" name="pembelian" id="pembelian">
                    <label for="pembelian">Pembelian</label>
                  </div>

                  <form id="form_pembelian">

                    <div class="form-group ml-3 m-0">
                      <input type="checkbox" name="permintaan_pembelian" id="permintaan_pembelian" class="pembelian">
                      <label for="permintaan_pembelian">Permintaan Pembelian</label>
                    </div>
                    <div class="form-group ml-3 m-0">
                      <input type="checkbox" name="pesanan_pembelian" id="pesanan_pembelian" class="pembelian">
                      <label for="pesanan_pembelian">Pesanan Pembelian</label>
                    </div>
                    <div class="form-group ml-3 m-0">
                      <input type="checkbox" name="penerimaan_barang" id="penerimaan_barang" class="pembelian">
                      <label for="penerimaan_barang">Penerimaan Barang</label>
                    </div>
                    <div class="form-group ml-3 m-0">
                      <input type="checkbox" name="faktur_pembelian" id="faktur_pembelian" class="pembelian">
                      <label for="faktur_pembelian">Faktur Pembelian</label>
                    </div>
                    <div class="form-group ml-3 m-0">
                      <input type="checkbox" name="pembayaran_pembelian" id="pembayaran_pembelian" class="pembelian">
                      <label for="pembayaran_pembelian">Pembayaran Pembelian</label>
                    </div>
                    <div class="form-group ml-3 m-0">
                      <input type="checkbox" name="retur_pembelian" id="retur_pembelian" class="pembelian">
                      <label for="retur_pembelian">Retur Pembelian</label>
                    </div>

                  </form>
                </div>

                <div class="mb-2">
                  <div class="form-group m-0">
                    <input type="checkbox" name="aset_tetap" id="aset_tetap">
                    <label for="aset_tetap">Aset Tetap</label>
                  </div>

                  <form id="form_aset_tetap">
                    <div class="form-group ml-3 m-0">
                      <input type="checkbox" name="aktiva_tetap_baru" id="aktiva_tetap_baru" class="aset_tetap">
                      <label for="aktiva_tetap_baru">Aktiva Tetap Baru</label>
                    </div>
                    <div class="form-group ml-3 m-0">
                      <input type="checkbox" name="tipe_aktiva_tetap_pajak" id="tipe_aktiva_tetap_pajak" class="aset_tetap">
                      <label for="tipe_aktiva_tetap_pajak">Tipe Aktiva Tetap Pajak</label>
                    </div>
                    <div class="form-group ml-3 m-0">
                      <input type="checkbox" name="tipe_aktiva_tetap" id="tipe_aktiva_tetap" class="aset_tetap">
                      <label for="tipe_aktiva_tetap">Tipe Aktiva Tetap</label>
                    </div>
                    <div class="form-group ml-3 m-0">
                      <input type="checkbox" name="daftar_aktiva_tetap" id="daftar_aktiva_tetap" class="aset_tetap">
                      <label for="daftar_aktiva_tetap">Daftar Aktiva Tetap</label>
                    </div>

                  </form>
                </div>

                <div class="mb-2">
                  <div class="form-group m-0">
                    <input type="checkbox" name="daftar" id="daftar">
                    <label for="daftar">Daftar</label>
                  </div>

                  <form id="form_daftar">

                    <div class="form-group ml-3 m-0">
                      <input type="checkbox" name="pemasok" id="pemasok" class="daftar">
                      <label for="pemasok">Pemasok</label>
                    </div>
                    <div class="form-group ml-3 m-0">
                      <input type="checkbox" name="pelanggan" id="pelanggan" class="daftar">
                      <label for="pelanggan">Pelanggan</label>
                    </div>
                    <div class="form-group ml-3 m-0">
                      <input type="checkbox" name="penjual" id="penjual" class="daftar">
                      <label for="penjual">Penjual</label>
                    </div>
                    <div class="form-group ml-3 m-0">
                      <input type="checkbox" name="pengguna" id="pengguna" class="daftar">
                      <label for="pengguna">Pengguna</label>
                    </div>

                  </form>
                </div>

                <div class="mb-2">
                  <div class="form-group m-0">
                    <input type="checkbox" name="rma" id="rma">
                    <label for="rma">RMA</label>
                  </div>

                  <form id="form_rma">

                    <div class="form-group ml-3 m-0">
                      <input type="checkbox" name="klaim_pelanggan" id="klaim_pelanggan" class="rma">
                      <label for="klaim_pelanggan">Klaim Pelanggan</label>
                    </div>
                    <div class="form-group ml-3 m-0">
                      <input type="checkbox" name="aktivitas_proses_klaim" id="aktivitas_proses_klaim" class="rma">
                      <label for="aktivitas_proses_klaim">Aktivitas Proses Klaim</label>
                    </div>
                    <div class="form-group ml-3 m-0">
                      <input type="checkbox" name="faktur_penjualan" id="faktur_penjualan" class="rma">
                      <label for="faktur_penjualan">Faktur Penjualan</label>
                    </div>

                  </form>
                </div>

                <div class="mb-2">
                  <div class="form-group m-0">
                    <input type="checkbox" name="efaktur" id="efaktur">
                    <label for="efaktur">E - Faktur</label>
                  </div>

                  <form id="form_efaktur">

                    <div class="form-group ml-3 m-0">
                      <input type="checkbox" name="spt" id="spt" class="efaktur">
                      <label for="spt">SPT Masa PPN (e-Spt, e-Faktur)</label>
                    </div>

                  </form>
                </div>

              </div>
            </div>
          </div>

        </div>
        <div class="row">
          <div class="col-12 d-flex flex-row-reverse">
            <button type="submit" id="btn-save-pengguna" class="btn btn-primary btn-icon-split btn-lg">
              <span class="icon text-white-50">
                <i class="fas fa-save"></i>
              </span>
              <span class="text">Save</span>
            </button>
            <div class="row">
              <div class="col-12 d-flex flex-row-reverse">
                <button type="submit" id="btn-tes" class="btn btn-danger btn-icon-split btn-lg">
                  <span class="icon text-white-50">
                    <i class="fas fa-save"></i>
                  </span>
                  <span class="text">TES</span>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>