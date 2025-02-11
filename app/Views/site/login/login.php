
<?php
    $account_type = 'emailadd';
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

<script>
var base_url = '<?= base_url();?>';
$(document).ready(function () {
    $("#loginFormUser").on("submit", function (e) {
        e.preventDefault();

        const emailadd = $("#emailadd").val().trim();
        const password = $("#password").val().trim();
        const emailPattern = /^[^@]+@[^@]+$/;
        
        if (!emailadd && !password) {
            return modal.alert_custom("Fill up the Fields.", "Email Address and Password are required.", "error");
        }
        
        if (!emailPattern.test(emailadd)) {
            return modal.alert_custom("Invalid Email Address.", "The Email Address must contain an '@' and a name after it.", "warning");
        }

        if (!emailadd) {
            return modal.alert_custom("Fill up the email.", "Email Address is required.", "warning");
        }

        if (!password) {
            return modal.alert_custom("Fill up the password.", "Password is required.", "warning");
        }

        $.post(base_url + 'login/validate_log', { emailadd, password })
            .done(function (response) {
                try {
                    const parsedResponse = is_json(response);
                    const resultCount = parsedResponse.count;
                    const attempts = "Incorrect Email Address or Password.";

                    console.log("ATTEMPTS REMAINING:", attempts);
                    console.log("Result Count:", resultCount);

                    const messages = {
                        3: ["Login Successful.", `Welcome ${emailadd} !`, "success", () => location.href = base_url + 'dashboard'],
                        2: ["Inactive.", "This Account is Inactive.", "warning"],
                        1: ["Login Failed.", attempts, "error"],
                        0: ["Login Failed.", attempts, "error"],
                        4: ["Login Failed.", "This account is Blocked/Locked.", "error"],
                        5: ["Login Failed.", "Expired Account.", "error"],
                        6: ["Password is Expired.", "Expired Account.", "error"]
                    };

                    if (messages[resultCount]) {
                        modal.alert_custom(...messages[resultCount]);
                    } else {
                        modal.alert_custom("Login Failed.", "It seems that you're not in my database.", "error");
                    }
                } catch (error) {
                    modal.alert_custom("Error.", "Server Error.", "Unexpected response from the server. Please try again later.");
                }
            })
            .fail(function () {
                modal.alert_custom("Error.", "Server Error.", "There was an error processing your request. Please try again later.");
            });
    });
});
</script>
</body>


