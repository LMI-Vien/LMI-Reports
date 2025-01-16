    
	<?php 
		$uri = current_url(true); 
	?>
	<?= view("cms/layout/header", $meta); ?>
	<body>
  <div class="wrapper">
    <?= view('cms/layout/navbar') ?>
    <?= view($content); ?> 
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

