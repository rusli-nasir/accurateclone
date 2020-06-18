<!-- Page Wrapper -->
<div id="wrapper">

  <!-- Sidebar -->
  <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex flex-column justify-content-center mb-2 mt-2" href="<?= base_url(); ?>">
      <div class="sidebar-brand-icon rotate-n-15">
        <i class="fas fa-hat-wizard"></i>
      </div>
      <div class="sidebar-brand-text mx-3">MULIA GRAFIKA</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <?php
    foreach ($menu_sidebar as $menu) {
    ?>
      <!-- Nav Item -->
      <li class="nav-item">
        <a href="<?= base_url('redirect/' . $menu['link_menu']); ?>" class="load-link nav-link 
        <?php if ($this->uri->segment(1) == $menu['link_menu'] || $this->uri->segment(2) == $menu['link_menu']) {
          echo "active";
        } ?>">
          <i class="fas fa-fw <?= $menu['icon']; ?>"></i>
          <span><?= $menu['nama_menu']; ?></span>
        </a>
      </li>
    <?php } ?>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block mt-3">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline sidebar-toggle">
      <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

  </ul>
  <!-- End of Sidebar -->