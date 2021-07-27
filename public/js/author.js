$(document ).ready(function(){
     $("header .btn-login").on('click', function() {
        $("#login-op").modal("show");
        $("#regiter-op").modal("hide");
        // $("#login-op #tab-login").css("display","block");
        return false;
    });
    $(".signup").on('click', function() {
        $("#login-op").modal("hide");
        $("#regiter-op").modal("show");
        // $("#regiter-op #tab-register").css("display","block");
        return false;
    });

    //login
    $(".login-form").on('click', '#frm-submit .btn',function(){
        var errors = new Array();
        var error_count = 0;
        var _token = $(".login-form input[name='_token']").val(); 
        var link = $(".login-form").attr("action");
        var pass = $(".login-form #frm-pass input").val();
        var email = $(".login-form #frm-email input").val();
        console.log(pass);
        if(pass == "") errors.push("Vui lòng nhập mật khẩu");
        if(email == "" || validateEmail(email) == false) errors.push("Email không đúng định dạng.");
        var i;
        var html = "<ul>";
        for(i = 0; i < errors.length; i++){
            if(errors[i] != ""){
                html +='<li>'+errors[i]+'</li>';
                error_count += 1;
            }
        }
        if(error_count>0){
            html += "</ul>";
            new PNotify({
                title: 'Lỗi dữ liệu ('+error_count+')',
                text: html,
                hide: true,
                delay: 6000,
            });
        }else{ 
            $('#overlay').show();
            $('.loading').show();
            $.ajax({
                type:'POST',
                url:link,
                cache: false,
                data:{
                    '_token' : _token,
                    'pass' : pass,
                    'email' : email,
                },
            }).done(function(data) { 
                $('#overlay').hide();
                $('.loading').hide();
                if(data.message == "success"){
                    window.location.href = data.url;
                }else{
                    new PNotify({
                        title: 'lỗi đăng nhập',
                        text: 'Email/Mật khẩu không đúng.',
                        type: 'error',
                        hide: true,
                        delay: 2000,
                    });
                }
            });
        }   
        return false;
    });
	//register
	$(".register-frm").on('click', '#frm-submit .btn',function(){
        var errors = new Array();
        var error_count = 0;
        var _token = $(".register-frm input[name='_token']").val(); 
        var link = $(".register-frm").attr("action");
        var name = $(".register-frm #frm-name input").val();
        var email = $(".register-frm #frm-email input").val();
        var pass = $(".register-frm #frm-password input").val();
        var passConfirm = $(".register-frm #frm-passConfirm input").val();
        //var captcha = $(".register-frm #frm-captcha input").val();
        if(name=="") errors.push("Vui lòng nhập họ tên");
        if(email=="" || validateEmail(email)==false) errors.push("Email không đúng định dạng.");
        if(pass=="") errors.push("Vui lòng nhập mật khẩu");
        if(passConfirm == "" || passConfirm != pass) errors.push("Mật khẩu nhập lại không khớp");
        //if(captcha=="") errors.push("Vui lòng nhập captcha");
        var i;
        var html = "<ul>";
        for(i = 0; i < errors.length; i++){
            if(errors[i] != ""){
                html +='<li>'+errors[i]+'</li>';
                error_count += 1;
            }
        }               
        if(error_count>0){
            html += "</ul>";
            new PNotify({
                title: 'Lỗi dữ liệu ('+error_count+')',
                text: html,
                hide: true,
                delay: 6000,
            });
        }else{
            $('#overlay').show();
            $('.loading').show();
            $.ajax({
                type:'POST',
                url:link,
                cache: false,
                data:{
                    '_token': _token,
                    'name': name,
                    'email': email,
                    'pass': pass,
                    //'captcha': captcha,
                },
            }).done(function(data) {
                $('#overlay').hide();
                $('.loading').hide();
                if(data.message=="success"){
                     new PNotify({
                        title: 'Thành công',
                        text: 'Chúc mừng bạn đã đăng ký thành công.',
                        type: 'success',
                        hide: true,
                        delay: 2000,
                    });
                    $("#regiter-op").modal("hide");
                    $('header .avatar-info').html(data.html);
                    $("#login-op").modal("show");
                    
                }else{
                    new PNotify({
                        title: 'Lỗi',
                        text: printErrorMsg(data.error),
                        type: 'error',
                        hide: true,
                        delay: 2000,
                    });
                }
            });
        }   
        return false;
    });
    //captcha
   /* $('#frm-captcha').on('click','i.fa-sync-alt',function(e){
        e.preventDefault();
        var anchor = $(this);
        var captcha = anchor.prev('img');
        $.ajax({
            type: "GET",
            url: '/ajax_regen_captcha',
        }).done(function( msg ) {
            captcha.attr('src', msg);
        });
    }); */      
});
//print errors
function printErrorMsg (msg) {
    var html = "<ul>";
    $.each( msg, function( key, value ) {
        html +='<li>'+value+'</li>';
    });
    html +="</ul>";
    return html;
}
//validate email
function validateEmail($email) {
  var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
  return emailReg.test( $email );
}