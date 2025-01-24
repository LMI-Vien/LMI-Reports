<style>
.main-sidebar {
  background-color: #301311;
}


</style>
<nav class="main-header navbar navbar-expand navbar-white elevation-2">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
    <li class="nav-item d-none d-sm-inline-block <?= ($PageUrl ?? '') === 'home' ? 'active' : '' ?>">
    </li>
  </ul>

  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">
    <!-- Messages Dropdown Menu -->
    <li class="nav-item">
      <a class="nav-link" href="<?= base_url('cms/login/sign_out');?>">
        <i class="fa fa-sign-out-alt mr-2"></i> Sign Out 
      </a>
    </li>
  </ul>
</nav>

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-yellow elevation-4">
  <!-- Brand Logo -->
  <a href="<?= base_url('cms/home')?>" class="brand-link">
    <img src="<?= base_url();?>assets/img/lmi_logo_box.png" alt="AdminLTE Logo" class="brand-image" style="opacity: .8">
    <span class="brand-text font-weight-light">LMI Portal</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel my-3 py-2 d-flex rounded-lg <?= ($PageUrl ?? '') === 'profile' ? 'bg-yellow' : '' ?>">
      <div class="image">
        <img src="" alt="">
      </div>
      <div class="info">
        <a href="#" class="d-block">Preference</a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
        <!-- Users Menu with Submenu -->
        <li class="nav-item has-treeview <?= in_array($PageUrl ?? '', ['Users', 'Roles']) ? 'menu-open' : '' ?> <?= in_array($PageUrl ?? '', ['Users', 'Roles']) ? 'active' : '' ?>">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-user"></i>
            <p>
              Users
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?= base_url('cms/users') ?>" class="nav-link <?= ($PageUrl ?? '') === 'Users' ? 'active' : '' ?>">
                <i class="far fa-user nav-icon"></i>
                <p>User</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= base_url('cms/roles') ?>" class="nav-link <?= ($PageUrl ?? '') === 'Roles' ? 'active' : '' ?>">
                <i class="fas fa-user-tag nav-icon"></i>
                <p>Role</p>
              </a>
            </li>
          </ul>
        </li>
        
        <!-- Masterfile Menu with Submenu -->
        <li class="nav-item has-treeview <?= in_array($PageUrl ?? '', ['Agency', 'Area', 'Brand Ambassador', 'Team', 'Store/Branch']) ? 'menu-open' : '' ?> <?= in_array($PageUrl ?? '', ['Agency', 'Area', 'Brand Ambassador', 'Team', 'Store/Branch']) ? 'active' : '' ?>">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-file"></i>
            <p>
              Masterfile
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?= base_url('cms/agency') ?>" class="nav-link <?= ($PageUrl ?? '') === 'Agency' ? 'active' : '' ?>">
                <i class="fas fa-building nav-icon"></i>
                <p>Agency</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= base_url('cms/area') ?>" class="nav-link">
                <i class="fas fa-map-marker-alt nav-icon"></i>
                <p>Area</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= base_url('cms/area-sales-coordinator') ?>" class="nav-link">
                <i class="fas fa-users-cog nav-icon"></i>
                <p>Area Sales Coordinator</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= base_url('cms/brand-ambassador') ?>" class="nav-link <?= ($PageUrl ?? '') === 'Brand Ambassador' ? 'active' : '' ?>">
                <i class="fas fa-user-tie nav-icon"></i>
                <p>Brand Ambassador</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= base_url('cms/store-branch') ?>"  class="nav-link <?= ($PageUrl ?? '') === 'Store/Branch' ? 'active' : '' ?>">
                <i class="fas fa-store nav-icon"></i>
                <p>Store/Branch</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= base_url('cms/team') ?>" class="nav-link <?= ($PageUrl ?? '') === 'Team' ? 'active' : '' ?>">
                <i class="fas fa-users nav-icon"></i>
                <p>Team</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item">
          <a href="<?= base_url('cms/site-menu') ?>" class="nav-link <?= ($PageUrl ?? '') === 'Site Menu' ? 'active' : '' ?>">
            <i class="nav-icon fas fa-bars"></i>
            <p>
              Site Menu
            </p>
          </a>
        </li>
      </ul>
    </nav>


    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>
