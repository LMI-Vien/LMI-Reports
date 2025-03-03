
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
        
        <?php if(!empty($css)) : ?>
            <?php foreach($css as $path) : ?>
                <link rel="stylesheet" type="text/css" href="<?= base_url() . $path?>">
            <?php endforeach; ?>
        <?php endif; ?>
    </head>
