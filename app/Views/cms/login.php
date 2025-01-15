<!DOCTYPE html>
<html lang="en">
<?php
    $account_type = 'Email';
?>
<body class="text-center" style="background: url('<?= base_url("assets/cms/img/cms_login.jpg") ?>') center/cover #004494; position: relative">
    <div class="justify-content-center container d-flex flex-column" style="min-height: 100vh; max-width: 476px">
        <!-- <p class="mt-5"><a href="/"><img src="/logo_dark.png" alt="Logo" width="150px"></a></p> -->
        <form  name="loginForm" class="container shadow d-flex flex-column justify-content-center pb-1 pt-3 text-white">
            <h1 class="mb-4">Login LMI cms</h1>
            <div class="callout callout-warning alert" role="alert" hidden style="margin-bottom: 0px !important;"></div>
            <input type="text" name="username" placeholder="username" class="form-control mb-2 username" id="username">
            <input type="password" name="password" autocomplete="current-password" placeholder="Password" class="form-control mb-2 password" id="password">
            <button class="btn-primary btn btn-block mb-3" id="btn_login"  type="button">Login</button>
            <div class="separator mb-3">Or</div>
            <a href="/register" class="btn d-flex align-items-center btn-light border-secondary mb-2">
                <span class="mx-auto">Register</span>
            </a>
            
        </form>
    </div>
</body>

</html>

<script>
var base_url = '<?= base_url();?>';

</script>
