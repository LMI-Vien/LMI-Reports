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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    </head>

    <script>
        var no_records = '<?= dialog("no_records");?>';
        var form_empty_error = "<?= dialog("form_empty");?>";
        var data_exist = '<?= dialog("data_exist");?>';
        var form_script = "<?= dialog("form_script");?>";
        var confirm_add_message = '<?= confirm("confirm_add"); ?>';
        var confirm_save_message = '<?= confirm("confirm_save"); ?>';
        var success_save_message = '<?= dialog("add_success"); ?>'; 
        var confirm_update_message = '<?= confirm("confirm_update"); ?>';
        var confirm_cancel_message = '<?= confirm("confirm_cancel"); ?>';
        var success_update_message = '<?= dialog("update_success"); ?>';
        var success_unpublish_message = '<?= dialog("unpublish_success"); ?>';
        var confirm_publish_message = '<?= confirm("confirm_publish"); ?>';
        var success_publish_message = '<?= dialog("publish_success"); ?>';
        var confirm_delete_message = '<?= confirm("confirm_delete"); ?>';
        var success_delete_message = '<?= dialog("delete_success"); ?>';
        var confirm_unblock_message = '<?= confirm("confirm_unblock"); ?>';
        var success_unblock_message = "<?= dialog("unblock_success"); ?>";
        var confirm_unpublish_message = '<?= confirm("confirm_unpublish"); ?>';
        var failed_transaction_message = '<?= dialog("failed_transaction"); ?>';
        var missing_user_input_message = '<?= dialog("missing_input"); ?>';
        var error_value_used = '<?= dialog("value_used"); ?>';
        var success_delete_message = '<?= dialog("delete_success"); ?>';
        var confirm_export_message = '<?= confirm("confirm_export"); ?>';
        var base_url = '<?= base_url();?>';
        var csrf_name = "<?= csrf_token(); ?>";
        var csrf_hash = "<?= csrf_hash(); ?>";
    </script>