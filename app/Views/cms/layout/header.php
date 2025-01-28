<!DOCTYPE html>
<html lang="en">
    <head>

       
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta property="og:title" content="<?=$meta['title']?>" />
        <meta property="og:description" content="<?=$meta['description']?>" />
        <title><?=$meta['title']?></title>
        
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
        <script type="text/javascript" src="<?= base_url();?>assets/js/jquery-3.7.1.min.js" ></script>
        <script type="text/javascript" src="<?= base_url();?>assets/js/cms_custom.js" ></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <!-- Include Material Icons -->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <!-- Include basic styling -->
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
        <?php if(!empty($css)) : ?>
            <?php foreach($css as $path) : ?>
                <link rel="stylesheet" type="text/css" href="<?= base_url() . $path?>">
            <?php endforeach; ?>
        <?php endif; ?>
    </head>

    <script>
        var no_records = 'No records to show.';
        var form_empty_error = "This is a required field.";
        var form_script = "may script ka";
        var csrf_name = "<?= csrf_token(); ?>";
        var csrf_hash = "<?= csrf_hash(); ?>";
    </script>