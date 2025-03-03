var formData = {
    email: '',
    password: ''
};

window.addEventListener('DOMContentLoaded', (event) => {
    var browser = navigator.userAgent.toLowerCase();
    if (browser.indexOf('firefox') > -1) {
        document.getElementsByTagName("form")[0].style.background = document.getElementsByTagName("body")[0].style.backgroundColor;
    }
});

$(document).on('click','#btn_login',()=>{
    //alert(base_url);
    var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;


    formData['email'] = $('#email').val();
    formData['password'] = $('#password').val();

    if(formData.email.length === 0 && formData.password.length === 0) {
        $('.error-feedback').css('display','block');
        $('.error-feedback span').text('Username and password were empty.');
    }
    else if(formData.email.length === 0) {  
        $('.error-feedback').css('display','block');
        $('.error-feedback span').text('Username was empty.');
    }
    else if(formData.password.length === 0) {
        $('.error-feedback').css('display','block');
        $('.error-feedback span').text('Password was empty');
    }
     else {
     //  user pass based login
        $.post(base_url + 'login/auth', {data: formData},
        (response) => {
            var result = response.trim();
            if(result === 'valid') {
                $('.error-feedback').css('display','none');
                location.href = base_url+'dashboard';
            }
            else{
                $('.error-feedback').css('display','block');
                $('.error-feedback span').text('Username or password provided is incorrect.');
            }
        });
    }

}).on('keypress', '#password', (e)=> {
    if(e.keyCode === 13) {
        $('.btn_login').click();
    }
});