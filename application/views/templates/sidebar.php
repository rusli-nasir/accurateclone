<!-- Page Wrapper -->
<div id="wrapper">

  <!-- Sidebar -->
  <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex flex-column justify-content-center mb-2 mt-2" href="<?= base_url('Dashboard'); ?>">
      <div class="sidebar-brand-icon rotate-n-15">
        <i class="fas fa-rocket"></i>
      </div>
      <div class="sidebar-brand-text mx-3">ROCKETJAKET</div>
    </a>

    <?php if ($this->session->userdata('role') <= 3) : ?>
      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        OVERVIEW
      </div>

      <!-- Nav Item - Dashoard Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed <?php if ($this->uri->segment(1) == "Dashboard") {
                                        echo "active";
                                      } ?>" href="#" data-toggle="collapse" data-target="#collapseDashoard" aria-expanded="true" aria-controls="collapseDashoard">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span>
        </a>
        <div id="collapseDashoard" class="collapse" aria-labelledby="headingDashoard" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Overview:</h6>
            <a class="collapse-item <?php if ($this->uri->segment(1) == "Dashboard" && ($this->uri->segment(2) == "index" || $this->uri->segment(2) == "")) {
                                      echo "active";
                                    } ?>" href="<?= base_url('Dashboard'); ?>">Cards</a>
            <a class="collapse-item <?php if ($this->uri->segment(1) == "Dashboard" && $this->uri->segment(2) == "chart") {
                                      echo "active";
                                    } ?>" href="<?= base_url('Dashboard/chart'); ?>">Charts</a>
            <?php if ($this->session->userdata('role') <= 2) { ?>
              <a class="collapse-item <?php if ($this->uri->segment(1) == "Dashboard" && $this->uri->segment(2) == "net") {
                                        echo "active";
                                      } ?>" href="<?= base_url('Dashboard/net'); ?>">Net Profit</a>
            <?php } ?>
            <a class="collapse-item <?php if ($this->uri->segment(1) == "Dashboard" && $this->uri->segment(2) == "rankingProduk") {
                                      echo "active";
                                    } ?>" href="<?= base_url('Dashboard/rankingProduk'); ?>">Ranking Produk</a>
            <a class="collapse-item <?php if ($this->uri->segment(1) == "Dashboard" && $this->uri->segment(2) == "rankingKaryawan") {
                                      echo "active";
                                    } ?>" href="<?= base_url('Dashboard/rankingKaryawan'); ?>">Ranking Karyawan</a>
          </div>
        </div>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        POINT OF SALE
      </div>

      <!-- Nav Item - Kasir -->
      <li class="nav-item">
        <a href="<?= base_url('Kasir'); ?>" class="load-link nav-link 
        <?php if ($this->uri->segment(1) == "Kasir") {
          echo "active";
        } ?>">
          <i class="fas fa-fw fa-cash-register"></i>
          <span>Kasir</span>
        </a>
      </li>

      <!-- Nav Item - Laporan Penjualan -->
      <li class="nav-item">
        <a href="<?= base_url('LapPenjualan'); ?>" class="load-link nav-link 
        <?php if ($this->uri->segment(1) == "LapPenjualan") {
          echo "active";
        } ?>">
          <i class="fas fa-fw fa-file-invoice-dollar"></i>
          <span>Laporan Penjualan</span>
        </a>
      </li>

      <!-- Nav Item - Notifikasi -->
      <li class="nav-item">
        <a href="<?= base_url('Notifikasi'); ?>" class="load-link nav-link 
        <?php if ($this->uri->segment(1) == "Notifikasi") {
          echo "active";
        } ?>">
          <i class="fas fa-fw fa-bell"></i>
          <span>Notifikasi</span>
        </a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        INVENTORY
      </div>

      <!-- Nav Item - Inventory -->
      <li class="nav-item">
        <a class="nav-link collapsed <?php if ($this->uri->segment(1) == "Produk" || $this->uri->segment(1) == "KategoriProduk") {
                                        echo "active";
                                      } ?>" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
          <i class="fas fa-fw fa-tshirt"></i>
          <span>Produk</span>
        </a>
        <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar" style="z-index:1000">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Produk :</h6>
            <a class="load-link collapse-item <?php if ($this->uri->segment(1) == "Produk" && ($this->uri->segment(2) == "index" || $this->uri->segment(2) == "")) {
                                                echo "active";
                                              } ?>" href="<?= base_url('Produk'); ?>">Produk</a>
            <a class="load-link collapse-item <?php if ($this->uri->segment(1) == "KategoriProduk") {
                                                echo "active";
                                              } ?>" href="<?= base_url('KategoriProduk'); ?>">Kategori Produk</a>
          </div>
        </div>
      </li>

      <li class="nav-item">
        <a href="<?= base_url('Inventory'); ?>" class="load-link nav-link 
        <?php if ($this->uri->segment(1) == "Inventory") {
          echo "active";
        } ?>">
          <i class="fas fa-fw fa-boxes"></i>
          <span>Inventory</span>
        </a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        TOKO
      </div>

      <!-- Nav Item - Pengguna -->
      <li class="nav-item">
        <a href="<?= base_url('Absen'); ?>" class="load-link nav-link 
        <?php if ($this->uri->segment(1) == "Absen") {
          echo "active";
        } ?>">
          <i class="fas fa-fw fa-address-book"></i>
          <span>Absensi</span>
        </a>
      </li>

      <!-- Nav Item - Pengguna -->
      <li class="nav-item">
        <a href="<?= base_url('Karyawan'); ?>" class="load-link nav-link 
        <?php if ($this->uri->segment(1) == "Karyawan") {
          echo "active";
        } ?>">
          <i class="fas fa-fw fa-user-astronaut"></i>
          <span>Karyawan</span>
        </a>
      </li>

      <li class="nav-item">
        <a href="<?= base_url('Customer'); ?>" class="load-link nav-link 
        <?php if ($this->uri->segment(1) == "Customer") {
          echo "active";
        } ?>">
          <i class="fas fa-fw fa-child"></i>
          <span>Customer</span>
        </a>
      </li>

      <li class="nav-item">
        <a href="<?= base_url('Operasional'); ?>" class="load-link nav-link 
        <?php if ($this->uri->segment(1) == "Operasional") {
          echo "active";
        } ?>">
          <i class="fas fa-fw fa-donate"></i>
          <span>Operasional</span>
        </a>
      </li>

      <!-- Nav Item - Pengguna -->
      <li class="nav-item">
        <a href="<?= base_url('Toko'); ?>" class="load-link nav-link 
        <?php if ($this->uri->segment(1) == "Toko") {
          echo "active";
        } ?>">
          <i class="fas fa-fw fa-store-alt"></i>
          <span>Cabang</span>
        </a>
      </li>

    <?php else : ?>
      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        POINT OF SALE
      </div>

      <!-- Nav Item - Kasir -->
      <li class="nav-item">
        <a href="<?= base_url('Kasir'); ?>" class="load-link nav-link 
        <?php if ($this->uri->segment(1) == "Kasir") {
          echo "active";
        } ?>">
          <i class="fas fa-fw fa-cash-register"></i>
          <span>Kasir</span>
        </a>
      </li>

      <!-- Nav Item - Laporan Penjualan -->
      <li class="nav-item">
        <a href="<?= base_url('LapPenjualan'); ?>" class="load-link nav-link 
        <?php if ($this->uri->segment(1) == "LapPenjualan") {
          echo "active";
        } ?>">
          <i class="fas fa-fw fa-file-invoice-dollar"></i>
          <span>Laporan Penjualan</span>
        </a>
      </li>

      <!-- Nav Item - Notifikasi -->
      <li class="nav-item">
        <a href="<?= base_url('Notifikasi'); ?>" class="load-link nav-link 
        <?php if ($this->uri->segment(1) == "Notifikasi") {
          echo "active";
        } ?>">
          <i class="fas fa-fw fa-bell"></i>
          <span>Notifikasi</span>
        </a>
      </li>

    <?php endif; ?>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline sidebar-toggle">
      <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

  </ul>
  <!-- End of Sidebar -->