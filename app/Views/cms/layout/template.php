    
	<?php 
		$uri = current_url(true); 
	?>
	<?= view("cms/layout/header", $meta); ?>
	<body>
  <div class="wrapper">
    <?= view('cms/layout/navbar') ?>
    <div class="content-wrapper p-4">
      <div class="container">
        <div class="card">
          <div class="card-body text-center">
            <h1 class="mb-4">Welcome to Portal!</h1>
            <div class="btn-group btn-block">
              <!-- <a href="/user/article/" class="btn btn-outline-primary py-4">
                <i class="fas fa-2x fa-info"></i><br>
                data1 
              </a>
              <a href="/user/manage/" class="btn btn-outline-primary py-4">
                <i class="fas fa-2x fa-users"></i><br>
                data 2
              </a> -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>

<?php if(!empty($js)) : ?>
    <?php foreach($js as $path) : ?>
        <script defer type="text/javascript" src="<?= base_url() . $path; ?>?v=1"></script>
    <?php endforeach; ?>
<?php endif; ?>
<script type="text/javascript">
	var base_url = "<?= base_url();?>";
</script>

