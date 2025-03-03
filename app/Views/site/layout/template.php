    
	<?php 
		$uri = current_url(true); 
	?>
	<?= view("site/layout/header", $meta); ?>
	<body>
	<?= view("site/layout/navigation"); ?>	
	<?= view($content); ?> 
	</body>
	<?= view("site/layout/footer"); ?>
</html>

<?php if(!empty($js)) : ?>
    <?php foreach($js as $path) : ?>
        <script defer type="text/javascript" src="<?= base_url() . $path; ?>?v=1"></script>
    <?php endforeach; ?>
<?php endif; ?>
<script type="text/javascript">
	var base_url = "<?= base_url();?>";
</script>

