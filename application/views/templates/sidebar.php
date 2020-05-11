<!-- Page Wrapper -->
<div id="wrapper">

  <!-- Sidebar -->
  <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex flex-column justify-content-center mb-2 mt-2" href="<?= base_url('Dashboard'); ?>">
      <div class="sidebar-brand-icon rotate-n-15">
        <i class="fas fa-rocket"></i>
      </div>
      <div class="sidebar-brand-text mx-3">GRAFIKA</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Nav Item -->
    <li class="nav-item">
      <a href="<?= base_url('redirect/BukuBesar'); ?>" class="load-link nav-link 
        <?php if ($this->uri->segment(1) == "BukuBesar" || $this->uri->segment(2) == "BukuBesar") {
          echo "active";
        } ?>">
        <i class="fas fa-fw fa-book"></i>
        <span>Buku Besar</span>
      </a>
    </li>

    <!-- Nav Item -->
    <li class="nav-item">
      <a href="<?= base_url('redirect/KasBank'); ?>" class="load-link nav-link 
        <?php if ($this->uri->segment(1) == "KasBank" || $this->uri->segment(2) == "KasBank") {
          echo "active";
        } ?>">
        <i class="fas fa-fw fa-money-check"></i>
        <span>Kas Bank</span>
      </a>
    </li>

    <!-- Nav Item -->
    <li class="nav-item">
      <a href="<?= base_url('redirect/Persediaan'); ?>" class="load-link nav-link 
        <?php if ($this->uri->segment(1) == "Persediaan" || $this->uri->segment(2) == "Persediaan") {
          echo "active";
        } ?>">
        <i class="fas fa-fw fa-boxes"></i>
        <span>Persediaan</span>
      </a>
    </li>

    <!-- Nav Item -->
    <li class="nav-item">
      <a href="<?= base_url('redirect/Penjualan'); ?>" class="load-link nav-link 
        <?php if ($this->uri->segment(1) == "Penjualan" || $this->uri->segment(2) == "Penjualan") {
          echo "active";
        } ?>">
        <i class="fas fa-fw fa-cash-register"></i>
        <span>Penjualan</span>
      </a>
    </li>

    <!-- Nav Item -->
    <li class="nav-item">
      <a href="<?= base_url('redirect/Pembelian'); ?>" class="load-link nav-link 
        <?php if ($this->uri->segment(1) == "Pembelian" || $this->uri->segment(2) == "Pembelian") {
          echo "active";
        } ?>">
        <i class="fas fa-fw fa-shopping-cart"></i>
        <span>Pembelian</span>
      </a>
    </li>

    <!-- Nav Item -->
    <li class="nav-item">
      <a href="<?= base_url('redirect/AsetTetap'); ?>" class="load-link nav-link 
        <?php if ($this->uri->segment(1) == "AsetTetap" || $this->uri->segment(2) == "AsetTetap") {
          echo "active";
        } ?>">
        <i class="fas fa-fw fa-hotel"></i>
        <span>Aset Tetap</span>
      </a>
    </li>

    <!-- Nav Item -->
    <li class="nav-item">
      <a href="<?= base_url('redirect/Daftar'); ?>" class="load-link nav-link 
        <?php if ($this->uri->segment(1) == "Daftar" || $this->uri->segment(2) == "Daftar") {
          echo "active";
        } ?>">
        <i class="fas fa-fw fa-list-ul"></i>
        <span>Daftar</span>
      </a>
    </li>

    <!-- Nav Item -->
    <li class="nav-item">
      <a href="<?= base_url('redirect/RMA'); ?>" class="load-link nav-link 
        <?php if ($this->uri->segment(1) == "RMA" || $this->uri->segment(2) == "RMA") {
          echo "active";
        } ?>">
        <i class="fas fa-fw fa-envelope-open-text"></i>
        <span>RMA</span>
      </a>
    </li>

    <!-- Nav Item -->
    <li class="nav-item">
      <a href="<?= base_url('redirect/EFaktur'); ?>" class="load-link nav-link 
        <?php if ($this->uri->segment(1) == "EFaktur" || $this->uri->segment(2) == "EFaktur") {
          echo "active";
        } ?>">
        <i class="fas fa-fw fa-cash-register"></i>
        <span>E-Faktur</span>
      </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block mt-3">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline sidebar-toggle">
      <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

  </ul>
  <!-- End of Sidebar -->