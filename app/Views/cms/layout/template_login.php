 <?php 
	$uri = current_url(true); 
?>
<?= view("cms/layout/header_login", $meta); ?>
<?= view($content); ?>
</html>
<?php if(!empty($js)) : ?>
    <?php foreach($js as $path) : ?>
        <script defer type="text/javascript" src="<?= base_url() . $path; ?>?v=2"></script>
    <?php endforeach; ?>
<?php endif; ?>


