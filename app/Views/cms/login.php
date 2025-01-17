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
        <form id="loginFormAdmin">
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="text" id="username" name="username" placeholder="Enter your email">
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
</body>

</html>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
var base_url = '<?= base_url();?>';
    $(document).ready(function () {
        $("#loginFormAdmin").on("submit", function (e) {
            e.preventDefault(); 

            let isValid = true;
            const username = $("#username").val().trim();
            const password = $("#password").val().trim();
            const usernamePattern = /^[^@]+@[^@]+$/;

            if (username === "" && password === "") {
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

            // if (!usernamePattern.test(emailadd)) {
            //     isValid = false;
            //     Swal.fire({
            //         icon: "warning",
            //         title: "Invalid Email Address",
            //         text: "The Email Address must contain an '@' and a name after it.",
            //         allowOutsideClick: false,
            //         allowEscapeKey: false,
            //     });
            //     e.preventDefault();
            //     return;
            // }

            if (username === "") {
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
                $.post(base_url + 'cms/login/validate_log', { 
                    username: username, 
                    password: password 
                }, function (response) {
                    try {
                        const parsedResponse = JSON.parse(response);
                        const resultCount = parsedResponse.count;
                        const result = parsedResponse.result;

                        console.log("Parsed Response:", parsedResponse);
                        console.log("Result Count:", resultCount);

                        if (resultCount === 3) {
                            Swal.fire({
                                icon: "success",
                                title: "Login Successful",
                                text: "Welcome " + username + " !",
                                timer: 2000,
                                showConfirmButton: false,
                                didOpen: () => {
                                    Swal.showLoading();
                                }
                            }).then(() => {
                                location.href = base_url +'cms/home';
                            });
                        } else if (resultCount === 2) {
                            Swal.fire({
                                icon: "warning",
                                title: "Inactive",
                                text: "This Account is Inactive",
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                            });
                        } else if (resultCount === 1 || resultCount === 0) {
                            Swal.fire({
                                icon: "error",
                                title: "Login Failed",
                                text: parsedResponse.message || "Incorrect Email Address or Password.",
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                            });
                        } else if (resultCount === 4) {
                            Swal.fire({
                                icon: "error",
                                title: "Login Failed",
                                text: "This account is Blocked/Locked",
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                            });
                        } else if (resiltCount === 5) {
                            Swal.fire({
                                icon: "error",
                                title: "Login Failed",
                                text: "Expired Account",
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                            });
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "Login Failed",
                                text: "It seem's that you're not in my database",
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                            });
                        }   
                    } catch (error) {
                        console.error("Error parsing response:", error, response);
                        Swal.fire({
                            icon: "error",
                            title: "Server Error",
                            text: "Unexpected response from the server. Please try again later.",
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
