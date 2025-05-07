    
<?php 
	$uri = current_url(true); 
?>
	<?= view("site/layout/header", $meta); ?>
    <body class="hold-transition sidebar-mini layout-fixed">
	    <div class="wrapper">
			<?= view("site/layout/navigation"); ?>	
			<?= view($content); ?> 
		     <?= view("site/layout/footer"); ?> 
		<div>
<style>

.main-sidebar.sidebar-dark-yellow {
  background-color: #301311 !important;
}
    
/* Default hidden state for filter */
.filter-content {
  display: none;
  /* background-color: #301311; */
  padding: 10px;
  color: #c2c7d0;
  width: 100%;
  font-size: 0.85rem;
  position: absolute;
  left: 100%;
  top: 0;
  z-index: 1050;
}

.ui-autocomplete {
  z-index: 9999 !important;
}

.filter-icon {
  display: inline-block !important;  /* Ensure it is always visible */
}

.brand-link i {
  display: inline-block;
  font-size: 1.25rem;
  margin-left: 7px;
}

.main-sidebar {
  background-color: #301311 !important;
}

/* .brand-link {
  background-color: #301311 !important;
} */

/* Expanded Sidebar: Show filters normally */
body:not(.sidebar-collapse) .filter-content {
  display: block;
  position: static;
  width: 100%;
}

body.sidebar-collapse .main-sidebar:hover .filter-icon {
  display: inline-block !important;  /* Always show the icon */
}

/* Collapsed Sidebar: Show filters on hover */
body.sidebar-collapse .main-sidebar:hover .filter-hover .filter-content {
  display: block !important;
  position: static;
  padding: 15px;
  left: 100%;
  top: 0;
  width: 250px;
  z-index: 1050;
}

.main-header {
  position: sticky;
  top: 0;
  z-index: 1030;
  background-color: #fff; /* Or use your theme color */
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Optional visual polish */
}

///
.nav-item .nav-link {
  padding: 8px 10px; /* Adjust padding to fit */
}

.nav-item .nav-link span {
  font-size: 10px; /* Reduce font size for date */
  display: block;
}

///////
.announcement-card {
  margin-bottom: 20px;
  margin: 20px;
}

.announcement-box {
  margin: 20px;
}

.announcement-img {
  max-height: 150px;
  object-fit: cover;
  border-radius: 0.25rem;
}

.announcement-title {
  font-size: 1.2rem;
  font-weight: 600;
}

.announcement-desc {
  font-size: 0.9rem;
  color: #555;
}



////
.dashboard-row {
  display: flex;
  flex-wrap: wrap;
  gap: 15px;
  justify-content: space-between;
}

.dashboard-card {
  flex: 0 0 calc(12.5% - 15px); /* 8 boxes per row (12 / 8 = 1.5 col units each) */
  min-width: 150px;
}

.dashboard-card .card {
  height: 110px;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  margin-left: 20px;
}

.box-icon i {
  font-size: 1.6rem;
  margin-bottom: 8px;
}

.box-title {
  font-size: 0.85rem;
  margin-bottom: 5px;
  text-align: center;
}

.box-value {
  font-size: 1.3rem;
  font-weight: bold;
  margin: 0;
}

.navbar-nav .nav-link i {
  font-size: 1.2rem;
}

@media (max-width: 768px) {
  .navbar-nav .nav-item {
    margin-right: 5px;
  }
}

/* Optional: Make it scroll horizontally on very small screens */
@media (max-width: 992px) {
  .dashboard-row {
    flex-wrap: nowrap;
    overflow-x: auto;
  }

  .dashboard-card {
    flex: 0 0 auto;
  }
}
</style>  
    </body>
</html>

<?php if(!empty($js)) : ?>
    <?php foreach($js as $path) : ?>
        <script defer type="text/javascript" src="<?= base_url() . $path; ?>?v=1"></script>
    <?php endforeach; ?>
<?php endif; ?>
<script type="text/javascript">
	var base_url = "<?= base_url();?>";
  var url = "<?= base_url('cms/global_controller');?>";
</script>

