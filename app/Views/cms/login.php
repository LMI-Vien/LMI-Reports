<!DOCTYPE html>
<html lang="en">
<?php
    $account_type = 'Email';
?>
<body class="text-center">
    <div class="login-container">
        <!-- Logo Section -->
        <div class="logo">
            <img src="<?= base_url('assets/img/lifestrong-logo-hi-res.webp'); ?>" alt="Company Logo">
        </div>
        <h1>CMS Login</h1>
        <form id="loginFormAdmin" method="post">
            <div class="form-group">
                <label for="email">Username</label>
                <input type="text" id="username" name="username" placeholder="Enter your username">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password">
            </div>
            <button type="submit" class="btn">Login</button>
            <div class="form-footer">
                <p>Don't have an account? <a href="<?= base_url('cms/registration');?>">Sign up</a></p>
            </div>
        </form>
    </div>

<script>
    var baseUrl = '<?= base_url();?>';
    $(document).ready(function () {
        localStorage.removeItem('activeSubMenu');
        localStorage.removeItem('activeMenu');
        $("#loginFormAdmin").on("submit", function (e) {
            e.preventDefault();

            const username = $("#username").val().trim();
            const password = $("#password").val().trim();
            const emailPattern = /^[^@]+@[^@]+$/;
            
            if (!username && !password) {
                return modal.alert_custom("Fill up the Fields.", "Email Address and Password are required.", "error");
            }

            if (!username) {
                return modal.alert_custom("Fill up the email.", "Email Address is required.", "warning");
            }

            if (!password) {
                return modal.alert_custom("Fill up the password.", "Password is required.", "warning");
            }

            $.post(baseUrl + 'cms/login/validate_log', { username, password })
                .done(function (response) {
                    try {
                        const { count: resultCount, message, attempts } = is_json(response);
                        const FEEDBACK = attempts || message || "Incorrect Email Address or Password.";

                        const messages = {
                            3: ["Login Successful.", `Welcome ${username} !`, "success", () => location.href = baseUrl + 'cms/home'],
                            2: ["Inactive.", "This Account is Inactive.", "warning"],
                            1: ["Login Failed.", FEEDBACK, "error"],
                            0: ["Login Failed.", FEEDBACK, "error"],
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
</html>
