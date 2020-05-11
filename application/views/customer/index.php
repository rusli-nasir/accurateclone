<div class="row">
  <div class="col-12 col-lg-5 mr-4 mb-3">

    <div class="card">
      <div class="card-header">
        Tampilkan Data Customer dari Toko :
      </div>
      <div class="card-body">
        <select class="form-control" id="list-toko">
          <option value="all" rel="Semua Toko">Semua Toko</option>
          <?php foreach ($toko as $x) {
            if ($x['id'] != 1) { ?>
              <option value="<?= $x['id'] ?>" rel="<?= $x['nama'] ?>"><?= $x['nama'] ?></option>
          <?php }
          } ?>
        </select>
      </div>
    </div>
  </div>

  <div class="col-12 col-lg-5">

    <div class="card">
      <div class="card-header">
        Opsi Data Yang Ditampilkan
      </div>
      <div class="card-body">
        <div class="form-group">
          <label for="list-view">Pilihan Opsi</label>
          <select class="form-control" id="list-view">
            <option value="all">Email & No. HP</option>
            <option value="email">Email</option>
            <option value="cp">No. HP</option>
          </select>
        </div>
      </div>
    </div>
  </div>
</div>


<div class="row">

  <div class="col-12 mb-4 mt-4">
    <h4 class="text-gray-800" id="judul-toko-inventory"><?= $toko[1]['nama']; ?></h4>
  </div>

  <div class="col-12">
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary" id="judul-list-inventory">List Customer <?= $toko[1]['nama']; ?></h6>
      </div>
      <div class="card-body">
        <div class="table100">
          <table class="custom-table table-customer" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>NO</th>
                <th>Dibuat</th>
                <th>Toko</th>
                <th>Nama</th>
                <th class="col-email">Email</th>
                <th class="col-cp">No. HP</th>
              </tr>
            </thead>
            <tbody id="view-table-customer">
            </tbody>
          </table>
        </div>
      </div>
    </div>

  </div>
</div>