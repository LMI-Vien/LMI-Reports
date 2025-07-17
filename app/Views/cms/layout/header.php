<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta property="og:title" content="<?=$meta['title']?>" />
        <meta property="og:description" content="<?=$meta['description']?>" />
        <title><?=$meta['title']?></title>
        
        <link rel="stylesheet" href="<?= base_url('assets/fonts/roboto.css') ?>">
        <link rel="icon" href="<?= base_url('assets/img/lmi_logo.ico') ?>" type="image/x-icon">
        
        <script type="text/javascript" src="<?= base_url();?>assets/js/jquery-3.7.1.min.js" ></script>
        <script type="text/javascript" src="<?= base_url();?>assets/js/cms_custom.js" ></script>
        <script type="text/javascript" src="<?= base_url();?>assets/js/sweetalert2@11.js" ></script>
        
        <!-- Include Material Icons -->
        <link rel="stylesheet" href="<?= base_url('assets/fonts/material-icons/icon.css') ?>">
        <!-- Include basic styling -->
        <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>">
        <?php if(!empty($css)) : ?>
            <?php foreach($css as $path) : ?>
                <link rel="stylesheet" type="text/css" href="<?= base_url() . $path?>">
            <?php endforeach; ?>
        <?php endif; ?>
        <script src="<?= base_url();?>assets/js/popper.min.js" ></script>
        <link rel="stylesheet" href="<?= base_url('assets/css/jquery-ui.css') ?>">
        
        <script src="<?= base_url();?>assets/js/jquery-ui.js" ></script>
        <script src="<?= base_url();?>assets/js/xlsx.full.min.js" ></script>
        <script src="<?= base_url();?>assets/js/FileSaver.min.js" ></script>
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
        var confirm_export_message = '<?= confirm("confirm_export"); ?>';
        var confirm_approve_message = '<?= confirm("confirm_approve"); ?>';
        var confirm_disapprove_message = '<?= confirm("confirm_disapprove"); ?>';
        var confirm_send_approval_message = '<?= confirm("confirm_send_approval"); ?>';
        var base_url = '<?= base_url();?>';
        var csrf_name = "<?= csrf_token(); ?>";
        var csrf_hash = "<?= csrf_hash(); ?>";
    </script>
