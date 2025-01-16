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
    <li class="nav-item d-none d-sm-inline-block <?= ($page ?? '') === 'dashboard' ? 'active' : '' ?>">
      <a href="" class="nav-link">Dashboard</a>
    </li>
    <li class="nav-item d-none d-sm-inline-block <?= ($page ?? '') === 'profile' ? 'active' : '' ?>">
      <!-- <a href="/user/profile/" class="nav-link">Edit Profile</a> -->
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
    <div class="user-panel my-3 py-2 d-flex rounded-lg <?= ($page ?? '') === 'profile' ? 'bg-yellow' : '' ?>">
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
        <li class="nav-item">
          <a href="<?= base_url('cms/users')?>" class="nav-link active">
            <i class="nav-icon fas fa-globe"></i>
            <p>
              Users
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?= base_url('cms/sample');?>" class="nav-link <?= ($page ?? '') === 'dashboard' ? 'active' : '' ?>">
            <i class="nav-icon fas fa-home"></i>
            <p>
              Roles
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link <?= ($page ?? '') === 'article' ? 'active' : '' ?>">
            <i class="nav-icon fas fa-scroll"></i>
            <p>
              Sell In
            </p>
          </a>
        </li>

        <!-- Users Menu with Submenu -->
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link <?= ($page ?? '') === 'users' ? 'active' : '' ?>">
            <i class="nav-icon fas fa-users"></i>
            <p>
              Users
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?= base_url('cms/users/subuser1') ?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Sub User 1</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= base_url('cms/users/subuser2') ?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Sub User 2</p>
              </a>
            </li>
          </ul>
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>
