<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta property="og:title" content="<?=$meta['title']?>" />
        <meta property="og:description" content="<?=$meta['description']?>" />

        <!-- AdminLTE CSS -->
        <link rel="stylesheet" href="<?= base_url('assets/css/adminlte.min.css') ?>">
        <!-- FontAwesome Icons -->
        <link rel="stylesheet" href="<?= base_url('assets/fontawesome/fa6_beta3/all.min.css') ?>">
        <link rel="icon" href="<?= base_url('assets/img/lmi_logo.ico') ?>" type="image/x-icon">

        <title><?=$meta['title']?></title>
        <?php if(!empty($css)) : ?>
            <?php foreach($css as $path) : ?>
                <link rel="stylesheet" type="text/css" href="<?= base_url() . $path?>">
            <?php endforeach; ?>
        <?php endif; ?>
        <!-- jQuery and Bootstrap Bundle (for dropdown functionality) -->
        <script type="text/javascript" src="<?= base_url();?>assets/js/jquery-3.7.1.min.js" ></script>
        <script type="text/javascript" src="<?= base_url();?>assets/js/cms_custom.js" ></script>
        <script type="text/javascript" src="<?= base_url();?>assets/js/bootstrap.bundle.min.js" ></script>
        <script type="text/javascript" src="<?= base_url();?>assets/js/sweetalert2@11.js" ></script>
        <!-- AdminLTE JS -->
        <script type="text/javascript" src="<?= base_url();?>assets/js/adminlte.min.js" ></script>
  
    </head>