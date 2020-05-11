<!-- DataTales Example -->
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">List Notifikasi</h6>
  </div>
  <div class="card-body">
    <div class="container-table100">
      <div class="wrap-table100">
        <div class="table100">
          <table class="custom-table table-notif" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>Waktu</th>
                <th>Deskripsi Notifikasi</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody id="data-table-notifikasi">
              <?php $this->load->view('notifikasi/viewTable', array('model' => $model)); // Load file view.php dan kirim data siswanya 
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>