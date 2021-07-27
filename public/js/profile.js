$(document ).ready(function(){
    //login
    $("#edit-media .dev-form").on('click', '.group-action button',function(){                       
        var link = $(".dev-form").attr("action");       
        var title = $(".dev-form #frm-title input").val();
        if(title==""){            
            new PNotify({
                title: 'Lỗi',
                text: 'Vui lòng nhập tên file.',                         
                hide: true,
                delay: 6000,
            });
        }else{          
            $(".dev-form").append('<div class="loadding"><img src="'+location.protocol + "//" + location.host+'/public/images/loading_red.gif" alt="loadding..."/></div>')
            return true;
        }
        return false;
    });
    //login
    $("#edit-profile .dev-form").on('click', '.group-action button',function(){                       
        var link = $(".dev-form").attr("action");       
        var name = $(".dev-form #frm-name input").val();
        var phone = $(".dev-form #frm-phone input").val();
        var about = $(".dev-form #frm-about input").val();
        var address = $(".dev-form #frm-address input").val();        
        if(name==""){            
            new PNotify({
                title: 'Lỗi',
                text: 'Vui lòng nhập họ & tên.',                         
                hide: true,
                delay: 6000,
            });
        }else{          
            $(".dev-form").append('<div class="loadding"><img src="'+location.protocol + "//" + location.host+'/public/images/loading_red.gif" alt="loadding..."/></div>')
            return true;
        }
        return false;
    });
    //
    $("#edit-password .dev-form").on('click', '.group-action button',function(){
        var link = $(".dev-form").attr("action");       
        var oldPass = $(".dev-form #frm-oldPass input").val();
        var newPass = $(".dev-form #frm-newPass input").val();
        var conPass = $(".dev-form #frm-confirmPass input").val();
        var errors = new Array();
        var error_count = 0;
        if(oldPass==""){
            errors[0] = "Vui lòng nhập mật khẩu cũ.";
        }else{
            errors[0] = "";
        }
        if(newPass==""){
            errors[1] = "Vui lòng nhập mật khẩu mới.";
        }else{
            errors[1] = "";
        }
        if(conPass!=newPass){
            errors[2] = "Mật khẩu nhập lại không khớp.";
        }else{
            errors[2] = "";
        }
        var i;
        var html = "<ul>";
        for(i = 0; i < errors.length; i++){
            if(errors[i] != ""){
                html +='<li>'+errors[i]+'</li>';
                error_count += 1;
            }
        }
        html += "</ul>";
        if(error_count>0){
            new PNotify({
                title: 'Lỗi dữ liệu ('+error_count+')',
                text: html,                         
                hide: true,
                delay: 6000,
            });
        }else{          
            $(".dev-form").append('<div class="loadding"><img src="'+location.protocol + "//" + location.host+'/public/images/loading_red.gif" alt="loadding..."/></div>')
            return true;
        }
        return false;
    });
    /**
     * dell select item
     */
     $("#check-all").click(function(){
        if($(this).find("input").is(":checked")){           
            $(".dev-form tbody .check input").prop("checked", true);
            $(".dev-form .table").before('<button class="dell-all btn btn-top">Xóa</button>');
            $(".dev-form .table").after('<button class="dell-all btn btn-bottom">Xóa</button>');
        }else{          
            $(".dev-form .dell-all").remove();          
            $(".dev-form tbody .check input").prop('checked', false);
        }
    })
     $(".dev-form tbody .check").click(function(){
        var items = new Array();
        $(".dev-form tbody tr").each(function(){
            if($(this).find(".check input").is(":checked")){
                items.push($(this).find("input").val());
            }
        });     
        if(items.length>0){
            $(".dev-form .dell-all").remove();
            $(".dev-form .table").before('<button class="dell-all btn btn-top">Xóa</button>');
            $(".dev-form .table").after('<button class="dell-all btn btn-bottom">Xóa</button>');
        }else{
            $(".dev-form .dell-all").remove();
        }
    });
    //delete media file
    $("#media .delete").click(function(){
        var href = $(this).attr("href");
        (new PNotify({
            title: 'Xóa',
            text: 'Bạn muốn xóa ảnh này?',
            icon: 'glyphicon glyphicon-question-sign',
            type: 'error',
            hide: false,
            confirm: {
                confirm: true
            },
            buttons: {
                closer: false,
                sticker: false
            },
            history: {
                history: false
            }
        })).get().on('pnotify.confirm', function() {                
            window.location.href = href;
        });
        return false;
    });
    //delete media files are choose
    $("#media").on('click','.dell-all',function(){
        var _token = $("form input[name='_token']").val();
        var items = new Array();
        $(".dev-form tbody tr").each(function(){
            if($(this).find(".check input").is(":checked")){
                items.push($(this).find("input").val());
            }
        });
        if(items<0){                
            new PNotify({
                title: 'Lỗi dữ liệu',
                text: 'Vui lòng chọn ít nhất 1 hàng cần xóa.!',                         
                hide: true,
                delay: 6000,
            });
        }else{
            $(".dev-form").append('<div class="loadding"><img src="'+location.protocol + "//" + location.host+'/public/images/loading_red.gif" alt="loadding..."/></div>')
            $.ajax({
                type:'POST',            
                url:$("#media .dev-form").attr("action"),
                cache: false,
                data:{
                    '_token': _token,
                    'items': JSON.stringify(items)
                },
            }).done(function(data) {
                if(data=="success"){
                    $(".dev-form .loading").remove();
                    $(".dev-form tbody .check input").prop('checked', false);
                    $.each(items, function(index, value){                            
                        $(".dev-form #image-"+value).remove();
                    });
                    items = new Array();                                                
                    new PNotify({
                        title: 'Thành công',
                        text: 'Xóa thành công.',
                        type: 'success',
                        hide: true,
                        delay: 2000,
                    });                     
                }else{
                    new PNotify({
                        title: 'Lỗi',
                        text: 'Trình duyệt không hỗ trợ javascript.',                           
                        hide: true,
                        delay: 2000,
                    });
                }                   
            });
        }
        return false;
    });
    //media library
    $("#pro-header").on('click','.library',function(){
        $("#library-op #file-detail").empty();
        var _token = $("#pro-header form input[name='_token']").val();     
        var link = $("#pro-header form").attr("action");                
        $("#library-op .modal-footer .btn-primary").addClass($(this).attr("id"));
        $("#library-op").modal('toggle');        
        $.ajax({
            type:'POST',            
            url:link,
            cache: false,
            data:{
                '_token': _token
            },
            success:function(data){
                $('#library-op .modal-body #files').html(data);                
            }
        })
        return false;           
    });
    //detail media file
    $("#library-op.single .modal-body").on('click', '.list-media li', function(){           
        $(".list-media li").removeClass("active");
        $(this).addClass('active');
        var img_link = $(".list-media li.active img").attr("data-image");
        var img_alt = $(".list-media li.active img").attr("alt");
        var img_date = $(".list-media li.active img").attr("data-date");
        var img_id = $(".list-media li.active").attr("id").split("-");
        var html ="<div class='wrap'>";     
        html += "<h3>Thông tin file</h3>";
        html += "<img src='"+img_link+"' alt='"+img_alt+"' />";
        html +="<h4>"+img_alt+"</h4>";
        html +="<p class='date'>"+img_date+"</p>";
        html +="<a href='#' class='delete' id='"+img_id[1]+"'>Xóa ảnh</a>";
        html +="</div>";
        $("#library-op #file-detail").html(html);
    });
    //change banner profile  
    $("#library-op .group-action").on('click', '.pro-banner', function(){
        var _token = $("#library-op .tab-content #media input[name='_token']").val();
        var id = $("#file-detail .delete").attr("id");
        var link = $("#pro-header #pro-banner").attr("data-route");
        var url_img = $("#file-detail img").attr("src");        
        if(id==""){
            new PNotify({
                title: 'Lỗi dữ liệu ('+error_count+')',
                text: 'Bạn chưa chọn ảnh!',                         
                hide: true,
                delay: 6000,
            });
        }else{
            $.ajax({
                type:'POST',            
                url:link,
                cache: false,
                data:{
                    '_token': _token,
                    'id': id
                },
                success:function(data){
                    if(data!="error"){
                        $(".pro-avatar").attr("style","background-image:url("+url_img+")");
                        $("#library-op").modal('toggle');
                    }else{
                       new PNotify({
                            title: 'Lỗi dữ liệu',
                            text: 'Bạn chưa chọn ảnh!',                         
                            hide: true,
                            delay: 6000,
                        }); 
                    }
                }
            })
        }
        return false;
    });
    //change avatar  
    $("#library-op .group-action").on('click', '.pro-picture', function(){
        var _token = $("#library-op .tab-content #media input[name='_token']").val();
        var id = $("#file-detail .delete").attr("id");
        var link = $("#pro-header #pro-picture").attr("data-route");
        var title_img = $("#file-detail h4").text();        
        if(id==""){
            new PNotify({
                title: 'Lỗi dữ liệu ('+error_count+')',
                text: 'Bạn chưa chọn ảnh!',                         
                hide: true,
                delay: 6000,
            });
        }else{
            $.ajax({
                type:'POST',            
                url:link,
                cache: false,
                data:{
                    '_token': _token,
                    'id': id
                },
                success:function(data){
                    if(data!="error"){
                        title_img = "/image/"+title_img+"/174/174";
                        $(".pro-avatar .picture img").attr("src",title_img);
                        $("#library-op").modal('toggle');
                    }else{
                       new PNotify({
                            title: 'Lỗi dữ liệu',
                            text: 'Bạn chưa chọn ảnh!',                         
                            hide: true,
                            delay: 6000,
                        }); 
                    }
                }
            })
        }
        return false;
    });
    //delete media
    $("#library-op #file-detail").on('click', '.delete', function(){
        var _token = $("#library-op .tab-content #media input[name='_token']").val();
        var id = $(this).attr("id");
        var link = $("#library-op .tab-content #media form").attr("action");
        $.ajax({
            type:'POST',            
            url:link,
            cache: false,
            data:{
                '_token': _token,
                'id': id
            },
            success:function(data){
                if(data!="error"){
                    $("#library-op .modal-body #image-"+id).remove();
                    $("#library-op #file-detail").empty();
                    if(data!="success"){
                        $("#avatar img").attr("src", data);
                    }
                }
            }
        })
        return false;
    });
    //change avatar
    $(".profile .pro-avatar .picture").click(function(){
        var _token = $("form input[name='_token']").val();
    });
});