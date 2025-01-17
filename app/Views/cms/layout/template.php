    
	<?php 
		$uri = current_url(true); 
        $data['pageOption'] = ['10', '20', '30', '40', '50'];
        //$session = session();
	?>
	<?= view("cms/layout/header", $meta); ?>
	<body>
  <div class="wrapper">
    <?= view("cms/layout/navbar", $data) ?>
    <?= view($content); ?> 
  </div>
</body>
</html>
<script type="text/javascript" src="<?= base_url();?>assets/js/numeral.min.js" ></script>
<?php if(!empty($js)) : ?>
    <?php foreach($js as $path) : ?>
        <script defer type="text/javascript" src="<?= base_url() . $path; ?>?v=1"></script>
    <?php endforeach; ?>
<?php endif; ?>
<script type="text/javascript">
	var base_url = "<?= base_url();?>";
</script>

