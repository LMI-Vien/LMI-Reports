$(document).on('click', '#btn_login', function() {
  
    setTimeout(function(){
        $('.callout').hide();
        var url = base_url + "cms/login/validate_log";
        var data = {
          username: $('.username').val(), 
          password: $('.password').val()
        } 

        aJax.post(url,data,function(result){
            var obj = is_json(result);
            var result_count = obj.count;

            if(result_count == 0 || result_count == 1){

                var encoded_username = document.getElementById("username");
                var encoded_password = document.getElementById("password");

                if($('.username').val() == '' || $('.password').val() == ''){

                    var callout_message = '';

                    if($('.username').val() == ''){
                        callout_message += 'Username is required. ';
                        encoded_username.style.border = "thin solid red";
                    }else{
                        encoded_username.removeAttribute("style");
                    }

                    if($('.password').val() == ''){
                        callout_message += 'Password is required.';
                        encoded_password.style.border = "thin solid red";
                    }else{
                        encoded_password.removeAttribute("style");
                    }

                    $('.callout-warning').text(callout_message);
                    $('.callout-warning').show();

                }else if(result_count == 0 || result_count == 1 ){
                    encoded_username.style.border = "thin solid red";
                    encoded_password.style.border = "thin solid red";
                    $('.callout-warning').html("Login Failed: Incorrect <?=$account_type;?> or password. "+obj.message+"");
                    $('.callout-warning').addClass('callout-warning').removeClass('callout-success');
                    $('.callout-warning').show();
                }
            }else if(result_count == 2){
                $('.callout-warning').html("Your account has been deactivated. Please contact the administrator immediately.");
                $('.callout-warning').addClass('callout-warning').removeClass('callout-success');
                $('.callout-warning').show();
            }else if(result_count == 3){    
                $('#username').css("border", "#d2d6de solid 1px");
                $('#password').css("border", "#d2d6de solid 1px");
                location.href = base_url+ 'cms/home';
            }else if (result_count == 4){
                $('.callout-warning').addClass('callout-danger').removeClass('callout-warning').removeClass('callout-success').html("We’re sorry, your account has been blocked due to too many recent failed login attempts. Please try again after 5 minutes.");
                $('.callout-danger').show();
            }else if(result_count == 5){
                $('.callout-warning').removeClass('callout-success');
                $('.callout-warning').removeClass('callout-danger');
                $('.callout-warning').html('Password is expired. We sent you an email to reset your password.');
                $('.callout-warning').show();
            }else if (result_count == 6){
                $('.callout-warning').addClass('callout-danger').removeClass('callout-warning').removeClass('callout-success').html("We’re sorry, your account has been blocked due to too many recent failed login attempts. Please contact the administrator immediately.");
                $('.callout-danger').show();
            }
        });

    }, 300);
});

$(document).on("keypress", "#username, #password", function(e) {             
    if(e.keyCode == 13){
        $("#btn_login").click();
    }
});