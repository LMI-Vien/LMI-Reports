<!DOCTYPE html>
<html lang="en">
<?php
    $account_type = 'Email';
?>
<body>
<div class="register-container">
    <div class="logo">
        <img src="<?= base_url('assets/img/lifestrong-logo-hi-res.webp'); ?>" alt="Company Logo">
    </div>
    <!-- Form Header -->
    <div class="form-header">
        <h1>Create Account</h1>
    </div>

    <!-- Registration Form -->
    <form id="registerFormAdmin">
        <div class="register-form-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" placeholder="Enter your username">
        </div>
        <div class="register-form-group">
            <label for="email">Email Address</label>
            <input type="text" id="emailadd" name="emailadd" placeholder="Enter your email">
        </div>
        <div class="register-form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter your password">
        </div>
        <div class="register-form-group">
            <label for="confirm_password">Confirm Password</label>
            <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm your password">
        </div>
        <button type="submit" class="register-btn">Register</button>
        <div class="register-form-footer">
            <p>Already have an account? <a href="<?=base_url('cms/');?>">Login</a></p>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function () {
        $("#registerFormAdmin").on("submit", function (e) {
            e.preventDefault(); 
            let isValid = true;
            const username = $("#username").val().trim();
            const emailadd = $("#emailadd").val().trim();
            const password = $("#password").val().trim();
            const confirm_password = $("#confirm_password").val().trim();
            const usernamePattern = /^[^@]+@[^@]+$/;


            if (emailadd === "" && password === "" && username === "") {
                isValid = false;
                Swal.fire({
                    icon: "error",
                    title: "Fill up the fields",
                    text: "Username, Email Address and Password is required.",
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                });
                e.preventDefault();
                return;
            }

            if (username === "") {
                isValid = false;
                Swal.fire({
                    icon: "warning",
                    title: "Fill up the Username",
                    text: "Username is required.",
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
                    title: "Fill up the Email",
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

            if (password !== confirm_password){
                isValid = false;
                Swal.fire({
                    icon: "warning",
                    title: "Validation Error",
                    text: "Password does not match.",
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                });
                e.preventDefault();
                return;
            }

            // Allow form submission if everything is valid
            // if (isValid) {
            //     // Form will submit naturally
            // }
        });
    });
</script>
    
</body>
</html>