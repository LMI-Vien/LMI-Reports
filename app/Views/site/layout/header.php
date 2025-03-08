<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta property="og:title" content="<?=$meta['title']?>" />
        <meta property="og:description" content="<?=$meta['description']?>" />

        <!-- AdminLTE CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2.0/dist/css/adminlte.min.css">
        <!-- FontAwesome Icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

        <title><?=$meta['title']?></title>
        <?php if(!empty($css)) : ?>
            <?php foreach($css as $path) : ?>
                <link rel="stylesheet" type="text/css" href="<?= base_url() . $path?>">
            <?php endforeach; ?>
        <?php endif; ?>
        <!-- jQuery and Bootstrap Bundle (for dropdown functionality) -->
        <script type="text/javascript" src="<?= base_url();?>assets/js/jquery-3.7.1.min.js" ></script>
        <script type="text/javascript" src="<?= base_url();?>assets/js/cms_custom.js" ></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <!-- AdminLTE JS -->
        <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2.0/dist/js/adminlte.min.js"></script>
        </head>