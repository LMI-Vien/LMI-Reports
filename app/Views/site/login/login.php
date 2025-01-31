
<?php
    $account_type = 'Username';
?>

<body>
    <div class="login-container">
        <!-- Logo Section -->
        <div class="logo">
            <img src="/assets/img/lifestrong-logo-hi-res.webp" alt="Company Logo">
        </div>
        <h1>Login</h1>
        <form id="loginFormUser">
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="text" id="emailadd" name="emailadd" placeholder="Enter your email">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password">
            </div>
            <button type="submit" class="btn">Login</button>
            <!-- <div class="form-footer">
                <p>Don't have an account? <a href="/register">Sign up</a></p>
            </div> -->
            <div class="form-group">
                <hr>
                <div class="google-sign-container">
                    <a href="">
                        <img src="<?= base_url('/assets/img/google-sign.webp'); ?>" class="google-sign-img" alt="Sign in with Google">
                    </a>
                </div>
            </div>
        </form>
    </div>

    
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
var base_url = '<?= base_url();?>';
    $(document).ready(function () {
        $("#loginFormUser").on("submit", function (e) {
            e.preventDefault(); 

            let isValid = true;
            const emailadd = $("#emailadd").val().trim();
            const password = $("#password").val().trim();
            const usernamePattern = /^[^@]+@[^@]+$/;

            if (emailadd === "" && password === "") {
                isValid = false;
                Swal.fire({
                    icon: "error",
                    title: "Fill up the Fields",
                    text: "Email Address and Password is required.",
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                });
                e.preventDefault();
                return;
            }

            if (!usernamePattern.test(emailadd)) {
                isValid = false;
                Swal.fire({
                    icon: "warning",
                    title: "Invalid Email Address",
                    text: "The Email Address must contain an '@' and a name after it.",
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                });
                e.preventDefault();
                return;
            }

            if (emailadd === "") {
                isValid = false;
                Swal.fire({
                    icon: "warning",
                    title: "Fill up the email",
                    text: "Email Address is required.",
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                });
                e.preventDefault();
                return; 
            }

            if (password === "") {
                isValid = false;
                Swal.fire({
                    icon: "warning",
                    title: "Fill up the password",
                    text: "Password is required.",
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                });
                e.preventDefault();
                return;
            }

            if (isValid) {
                $.post(base_url + 'login/auth', { 
                    data: { email: emailadd, password: password } 
                }, function (response) {
                    var result = response.trim();

                    if (result === "valid") {
                        Swal.fire({
                            icon: "success",
                            title: "Login Successful",
                            text: "Welcome " + emailadd + " !",
                            timer: 2000,
                            showConfirmButton: false,
                            didOpen: () => {
                                Swal.showLoading(); 
                            }
                        }).then(() => {
                            location.href = base_url+'dashboard';
                        });
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Login Failed",
                            text: "Incorrect Email Address or Password.",
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                        });
                    }
                }).fail(function () {
                    Swal.fire({
                        icon: "error",
                        title: "Server Error",
                        text: "There was an error processing your request. Please try again later.",
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                    });
                });
            }
        });
    });
</script>
</body>


