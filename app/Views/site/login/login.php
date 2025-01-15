
<?php
    $account_type = 'Username';
?>

<body class="text-center" style="background: url(https://images.unsplash.com/photo-1444723121867-7a241cacace9?ixlib=rb-1.2.1&auto=format&fit=crop&w=1953&q=80) center/cover #004494; position: relative">
    <div class="justify-content-center container d-flex flex-column" style="min-height: 100vh; max-width: 476px">
        <!-- <p class="mt-5"><a href="/"><img src="/logo_dark.png" alt="Logo" width="150px"></a></p> -->
        <form name="loginForm" class="container shadow d-flex flex-column justify-content-center pb-1 pt-3 text-white">
            <h1 class="mb-4">Login LMI</h1>
            <div class="error-feedback"><i class="fas fa-exclamation-circle"></i><span>Please fill out all required fields</span></div>
            <input type="text" name="email" placeholder="email" class="form-control mb-2 email" id="email">
            <input type="password" name="password" autocomplete="current-password" placeholder="Password" class="form-control mb-2 password" id="password">
            <button class="btn-primary btn btn-block mb-3" id="btn_login"  type="button">Sign In</button>
            <div class="separator mb-3">Or</div>
            <a href="#" class="btn d-flex align-items-center btn-light border-secondary mb-2">
                <span class="mx-auto">Sign in with Google</span>
            </a>
        </form>
    </div>
</body>


<script>
var base_url = '<?= base_url();?>';
</script>