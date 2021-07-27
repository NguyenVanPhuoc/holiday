$(document ).ready(function(){
    $('.scrollbar-inner').scrollbar();
    //add hexagon menu
    /*var hex_color = $('.main-nav li .has-icon > span').attr('class');
    var hex_html = '<span class="hexagon '+hex_color+'"></span>';
    $('.main-nav li .my-trip').append('<span class="icon"><span class="hexagon '+hex_color+'"></span></span>');
    $('.main-nav li .wish-list').append('<span class="icon"><span class="hexagon '+hex_color+'"></span></span>');
    $('.main-nav li .all-tour').append('<span class="icon"><span class="hexagon '+hex_color+'"></span></span>');*/
    if($('.main-nav').length){
        $('.main-nav li .has-icon').each(function(){
            var hex_color = $(this).find('span').attr('class'); 
            var hex_html = '<span class="hexagon '+hex_color+'"></span>';
            $(this).append('<span class="icon"><span class="hexagon '+hex_color+'"></span></span>');
            $(this).parents('li').addClass(hex_color);
        });
    }
    $('.main-nav > ul > li a .destinations').parents('li').mouseover(function(){
        if($('.sub-destination .item').length){
            var h_img = $('.sub-destination .col-md-2:first-child .item').outerHeight(); 
            $('.sub-destination .col-md-2:last-child .thumb > img').css('min-height', h_img).css('width', 'auto');
        }
    });
    $("header .sub-destination").detach().appendTo($(".main-menu .destinations").parents('li'));
    $("header .sub-tour-style").detach().appendTo($(".main-menu .tour-style").parents('li'));
    //back to top
    if($('#backtotop').length > 0){
        $(window).scroll(function() {
            if($(window).scrollTop() >200) {
              $('#backtotop').fadeIn();
              } else {
              $('#backtotop').fadeOut();
              }
            });
        $('#backtotop').click(function() {
            $('html, body').animate({scrollTop:0},500);
        });
    };
    //tab video hompage
    $('.travel-experience .tab-content:first-child').show();
    $('.travel-experience .tab-video li a').click(function(e){
        e.preventDefault();
        var tab_id = $(this).attr('href');
        $('.travel-experience .tab-content').hide();
        $('.travel-experience .tab-content').each(function(){
            var iframe = $(this).find('iframe').attr('src');  
            var temp = String(iframe).replace('?autoplay=1', '');
            $(this).find('iframe').attr('src', temp);
        });
        var iframe_active = $('#'+tab_id).find('iframe').attr('src');
        iframe_active += '?autoplay=1'; 
        $('#'+tab_id).find('iframe').attr('src', iframe_active); //custom auto play embed youtube
        $('#'+tab_id).fadeIn();
        return false;
    });    
    //check change password
    $(".check-password input").change(function(){
        if($(this).is(':checked')){
            $(".change-password input").prop('disabled', false);
            $(this).val("on");          
        }else{
            $(".change-password input").prop('disabled', true);
            $(this).val("");                
        }
        $(".change-password").slideToggle(100);
    });    
    //dropdown
    $(".dropdown-menu").on('click','.list-item a',function(){ console.log('sdfsd');
        var value = $(this).attr("href").split("#");
        var text = $(this).text();
        $(this).parents('.dropdown-menu').find('li').removeClass('active');        
        $(this).parents('.dropdown').find('.dropdown-toggle').attr("data-value",value[1]);
        $(this).parents('.dropdown').find('.dropdown-toggle').text(text);
        $(this).parent('li').addClass('active');
    });    
    //contact
    $(".frm-contact").on('click', '.btn-group button',function(){        
        var errors = new Array();
        var error_count = 0;
        var _token = $(".frm-contact input[name='_token']").val();        
        var name = $(".frm-contact #frm-name input").val();
        var email = $(".frm-contact #frm-email input").val();
        var phone = $(".frm-contact #frm-phone input").val();
        var address = $(".frm-contact #frm-address input").val();
        var message = $(".frm-contact #frm-message textarea").val();
        if(name==""){
            errors[0] = "Vui lòng nhập họ tên";
        }else{
            errors[0] = "";
        }        
        if(email=="" || validateEmail(email)==false){
            errors[1] = "Email không đúng định dạng.";
        }else{
            errors[1] = "";
        }
        if(phone==""){
            errors[2] = "Vui lòng nhập số phone.";
        }else{
            errors[2] = "";
        }
        if(phone==""){
            errors[3] = "Vui lòng nhập địa chỉ của bạn.";
        }else{
            errors[3] = "";
        }
        if(message==""){
            errors[4] = "Vui lòng nhập nội dung.";
        }else{
            errors[4] = "";
        }
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
            $("#contact-page .frm-contact").append('<div class="loadding"><img src="'+location.protocol + "//" + location.host+'/public/images/loading_red.gif" alt="loadding..."/></div>')
            $.ajax({
                type:'POST',            
                url:$(".frm-contact").attr("action"),
                cache: false,
                data:{
                    '_token': _token,
                    'name': name,                    
                    'email': email,
                    'phone': phone,
                    'address': address,
                    'message': message
                },
            }).done(function(data) {
                $(".frm-contact .loadding").remove();
                if(data!="error"){
                    $(".frm-contact #frm-name input").val("");                    
                    $(".frm-contact #frm-email input").val("");
                    $(".frm-contact #frm-phone input").val("");
                    $(".frm-contact #frm-address input").val("");
                    $(".frm-contact #frm-message textarea").val("");
                    errors = [];            
                    error_count = 0;                        
                    new PNotify({
                        title: 'Gửi thành công',
                        text: data,
                        type: 'success',
                        hide: true,
                        delay: 2000,
                    });
                }else{
                    new PNotify({
                        title: 'Trình duyệt không hỗ trợ javascript.',
                        text: error,                            
                        hide: true,
                        delay: 2000,
                    });
                }                   
            });
        }   
        return false;
    });
    //socical share buttons
    var popupSize = {
        width: 780,
        height: 550
    };
    $(".social-share").on('click', 'ul li a', function(e){
        var
            verticalPos = Math.floor(($(window).width() - popupSize.width) / 2),
            horisontalPos = Math.floor(($(window).height() - popupSize.height) / 2);
        var popup = window.open($(this).prop('href'), 'social',
            'width='+popupSize.width+',height='+popupSize.height+
            ',left='+verticalPos+',top='+horisontalPos+
            ',location=0,menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1');
        if (popup) {
            popup.focus();
            e.preventDefault();
        }
    });
    //captcha
    $('#frm-captcha i.fa-refresh').on('click', function(e){
        e.preventDefault();     
        var anchor = $(this);
        var captcha = anchor.prev('img');     
        $.ajax({
            type: "GET",
            url: '/ajax_regen_captcha',
        }).done(function( msg ) {
            captcha.attr('src', msg);
        });
    });
    /*
    * Biig Holiday
    */
   //top filter content
    $('body').click(function(e){
        var target = $( e.target );
        if(target.is('.chose-value')){
            $('.popup-filter').removeClass('active');
            target.parents('.has-select').find('.popup-filter').addClass('active');
        }
        else{
            $('.popup-filter').removeClass('active');
        }
    });
    //chose value top filter
    $('#content').on('click', '.filter-top .popup-filter li',function(){ 
        var value = $(this).attr('data-value'); 
        var text = $(this).text();
        $(this).parents('.has-select').find('.value').attr('data-value', value);
        $(this).parents('.has-select').find('.value').text(text);
    });
    //filter tour by taxonomy
    $('.package-tours-content').on('click', '#sidebar .list-filter-tour li',function(e){
        e.preventDefault();
        if($(this).parents('.list-filter-tour').hasClass('list-duration')){ 
            if($(this).hasClass('active')){
                $(this).removeClass('active');
                $(this).find('input').prop('checked', false);
            } 
            else{
                $('#sidebar .list-duration li').removeClass('active');
                $('#sidebar .list-duration li input').prop('checked', false);
                $(this).addClass('active');
                $(this).find('input').prop('checked', true);
            }
            /*if($(this).find('input').is(':checked')){
                $(this).find('input').prop('checked', false);
            }
            else{
                $('#sidebar .list-duration li input').prop('checked', false);
                $(this).find('input').prop('checked', true);
            }*/
        }
        else{
            if($(this).hasClass('active')){
                $(this).removeClass('active');
                $(this).find('input').prop('checked', false);
            } 
            else{
                $(this).addClass('active');
                $(this).find('input').prop('checked', true);
            }
        } 
    });
    /*
    * Single Tour
    */
    //.gr-info-fixed
    if($('.single-tour .gr-info').length){
        var top_grInfo = $('.single-tour .gr-info').offset().top;
        var height_grInfo = $('.single-tour .gr-info').outerHeight();
        $(window).scroll(function(){
            var top_window = $(window).scrollTop();
            if(top_window > (top_grInfo + height_grInfo))
               $('.single-tour .gr-info-fixed').fadeIn(); 
            else
                $('.single-tour .gr-info-fixed').hide();
        });
    }
    //schedule single tour
    $('.list-schedule .item .view').click(function(){
        $(this).parents('.col-md-6').addClass('active');
        //$(this).parents('.item').find('.desc .brief').hide();
        $(this).parents('.item').find('.desc .detail').addClass('is-show');
        $(this).parents('.item').find('.list-icons').addClass('is-show');
        $(this).hide();
        $(this).parents('.item').find('.collapse').fadeIn();
        $('.list-schedule .col-md-6').each(function(){
            var current_height = $(this).find('.item').outerHeight();
            var element = $(this).index() + 1; 
            var next_element = element + 1;
            if($(this).is(':nth-child(2n+1)')){
                $('.list-schedule .col-md-6:nth-child('+ next_element + ')').css('min-height', current_height + 180);
                $('.list-schedule .col-md-6:nth-child('+ next_element + ') .item').css('margin-top', current_height - 150);
            }
        });
        $([document.documentElement, document.body]).animate({
            scrollTop: $(this).parents('.item').offset().top - 200
        }, 500);
    });
    $('.list-schedule .item .collapse').click(function(){
        $(this).parents('.col-md-6').removeClass('active');
        $(this).parents('.item').find('.desc .detail').removeClass('is-show');
        $(this).parents('.item').find('.list-icons').removeClass('is-show');
        //$(this).parents('.item').find('.desc .brief').fadeIn();
        $(this).hide();
        $(this).parents('.item').find('.view').fadeIn();
        $('.list-schedule .col-md-6').each(function(){
            var current_height = $(this).find('.item').outerHeight();
            var element = $(this).index() + 1; 
            var next_element = element + 1;
            if($(this).is(':nth-child(2n+1)')){
                $('.list-schedule .col-md-6:nth-child('+ next_element + ')').css('min-height', current_height + 180);
                $('.list-schedule .col-md-6:nth-child('+ next_element + ') .item').css('margin-top', current_height - 150);
            }
        });
        $([document.documentElement, document.body]).animate({
            scrollTop: $(this).parents('.item').offset().top - 200
        }, 500);
    });
    //expand all schedule tour
    $('.detail-schedule-sec .expand-all').click(function(){
        //$('.list-schedule .item .brief').hide();
        $('.list-schedule .item .detail').addClass('is-show');
        $('.list-schedule .item .list-icons').addClass('is-show');
        $('.list-schedule .item .view').hide();
        $('.list-schedule .item .collapse').fadeIn();
        $(this).hide();
        $('.detail-schedule-sec .collapse-all').fadeIn();
        $('.list-schedule .col-md-6').each(function(){
            var current_height = $(this).find('.item').outerHeight();
            var element = $(this).index() + 1; 
            var next_element = element + 1;
            if($(this).is(':nth-child(2n+1)')){
                $('.list-schedule .col-md-6:nth-child('+ next_element + ')').css('min-height', current_height + 180);
                $('.list-schedule .col-md-6:nth-child('+ next_element + ') .item').css('margin-top', current_height - 150);
            }
        });
    });
    //collapse all schedule tour
    $('.detail-schedule-sec .collapse-all').click(function(){
        $('.list-schedule .item .detail').removeClass('is-show');
        $('.list-schedule .item .list-icons').removeClass('is-show');
        //$('.list-schedule .item .brief').fadeIn();
        $('.list-schedule .item .collapse').hide();
        $('.list-schedule .item .view').fadeIn();
        $(this).hide();
        $('.detail-schedule-sec .expand-all').fadeIn();
        $('.list-schedule .col-md-6').each(function(){
            var current_height = $(this).find('.item').outerHeight();
            var element = $(this).index() + 1; 
            var next_element = element + 1;
            if($(this).is(':nth-child(2n+1)')){
                $('.list-schedule .col-md-6:nth-child('+ next_element + ')').css('min-height', current_height + 180);
                $('.list-schedule .col-md-6:nth-child('+ next_element + ') .item').css('margin-top', current_height - 150);
            }
        });
    });
    //back to start in list schedule tour
    $('.detail-schedule-sec .back-to-start').click(function(){
        $([document.documentElement, document.body]).animate({
            scrollTop: $(".detail-schedule-sec").offset().top - 100
        }, 1000);
        return false;
    });
    //tour brief scroll to tour detail
    $('.tour-brief table td a, .table-list-schedule ul li a').click(function(){ 
        var day = $(this).attr('href');
        //scroll to element of list schedule
        $([document.documentElement, document.body]).animate({
            scrollTop: $(".list-schedule "+day).offset().top - 200
        }, 1000);
        $(".list-schedule "+day).find('.brief').hide();
        $(".list-schedule "+day).find('.detail').fadeIn();
        $(".list-schedule "+day).find('.view').hide();
        $(".list-schedule "+day).find('.collapse').fadeIn();
        $('.list-schedule .col-md-6').each(function(){
            var current_height = $(this).find('.item').outerHeight();
            var element = $(this).index() + 1; 
            var next_element = element + 1;
            if($(this).is(':nth-child(2n+1)')){
                $('.list-schedule .col-md-6:nth-child('+ next_element + ')').css('min-height', current_height + 180);
                $('.list-schedule .col-md-6:nth-child('+ next_element + ') .item').css('margin-top', current_height - 150);
            }
        });
        /*$('.table-list-schedule ul li').each(function(){ 
            console.log(index, $('.table-list-schedule ul li:first-child').outerHeight(true));
            if(!$('.table-list-schedule ul li:first-child').is(':visible')){
                $('.table-list-schedule ul li:first-child').css('visibility', 'visible');
            }
            if(($(this).index() + 2) < index) { h_scrollTo += $('.table-list-schedule ul li').eq(index-1).height(); }
        });
        console.log(h_scrollTo);*/
        return false;
    });
    //quick search sidebar
    $('#sidebar .quick-search .box-item .title').click(function(){
        if($(this).parents('.box-item').hasClass('active')){
            $(this).parents('.box-item').removeClass('active');
        }
        else{
            $(this).parents('.box-item').addClass('active');
        }
        $(this).parents('.box-item').find('ul').slideToggle();
    });
    $('#sidebar .quick-search .box-item li').click(function(){
        var parent = $(this).closest('.box-item ');
        if(parent.hasClass('single-value')){
            /*$('#sidebar .quick-search .single-value li').removeClass('active');
            $(this).addClass('active');
            $('#sidebar .quick-search .single-value li input').prop('checked', false);
            $(this).find('input').prop('checked', true);*/
            parent.find('li').removeClass('active');
            $(this).addClass('active');
            parent.find('li input').prop('checked', false);
            $(this).find('input').prop('checked', true);
        }
        else{
            if($(this).hasClass('active')){
                $(this).removeClass('active');
                $(this).find('input').prop('checked', false);
            }
            else{
                $(this).addClass('active');
                $(this).find('input').prop('checked', true);
            }
            //$('.single-tour .quick-search [name=des]').attr('value', arr_des_id);
        }
    });
    $('#sidebar .quick-search .submit a').click(function(e){
        e.preventDefault();
        var form = $(this).closest('form');
        var link = form.attr('action');
        if(form.hasClass('send-ajax')){
            $.ajax({
                type:'GET',            
                url: link,
                cache: false,
                data: form.serialize(),
                beforeSend: function () { 
                    $('#overlay').fadeIn();
                    $('img.loading').fadeIn();
                },
                success:function(data){ 
                    $('#overlay').fadeOut();
                    $('img.loading').fadeOut();
                    if(data.msg == 'success'){
                        if(data.url != undefined && data.url != '')
                            window.location.href = data.url;
                    }
                }
            });
        }else{
            var params = '';
            form.find('.box-item').each(function(){
                var array_value = $($(this).find('input:checked')).map(function(){return $(this).val();}).get();
                var name = $(this).find('input').attr('name');
                name = name.replace('[]', '');  
                if($(this).index() == 0){
                    params += '?';
                }else{
                    params += '&';
                }
                 params += name + '=' + array_value.toString();
            });
            link += params;
            window.location.href = link;
        }
    });
    //fixed group group-fixed sidebar when scroll
    if($('#sidebar .group-fixed').length){
        var height_topHeader = $('header .top').outerHeight() + $('menu-top').outerHeight();
        var distance_arrow = $('.back-to-start').offset().top; 
        $(window).scroll(function(){
            distance_arrow = $('.back-to-start').offset().top; 
            var height_window = $(window).scrollTop();
            var width_sidebar = $('#sidebar .gr-not-fixed').outerWidth();
            var distance_sidebar = $('#sidebar .gr-not-fixed').offset().top;
            //var height_sidebar = $('#sidebar').outerHeight() - $('#sidebar .group-fixed').outerHeight();
            var height_sidebar = $('#sidebar .gr-not-fixed').outerHeight(); 
            //if have list heading
            if($('.table-heading').length){
                if(height_sidebar < $('.table-heading').offset().top + $('.table-heading').outerHeight())
                    height_sidebar = $('.table-heading').offset().top - distance_sidebar + height_topHeader;
            }
            if( (height_window > (distance_sidebar + height_sidebar + 650)) && (height_window < (distance_arrow - height_topHeader - 400))){
                $('#sidebar .group-fixed').css('width', width_sidebar);
                $('#sidebar .group-fixed').addClass('fixed');
                if($('#sidebar .group-fixed').hasClass('fixed')){
                    //scroll to in scrollbar
                    var h_scrollTo = 0; 
                    var index = $('.table-list li a.active').closest('li').index() + 1;
                    $('.table-list li a').each(function(){ 
                        if($(this).hasClass('active'))
                            return false;
                        else
                            h_scrollTo += $(this).outerHeight();
                    });
                    $('.scrollbar-inner').animate({scrollTop: h_scrollTo}, 10); //console.log(index, h_scrollTo);
                }
                else{
                }
            } 
            else{
                $('#sidebar .group-fixed').removeClass('fixed');
            }
        });
    }
    if($('#market-guide #sidebar .group-fixed').length){
        var height_topHeader = $('header .top').outerHeight() + $('menu-top').outerHeight();
        var distance_arrow = $('.back-to-start').offset().top; 
        $(window).scroll(function(){
            distance_arrow = $('.back-to-start').offset().top; 
            var height_window = $(window).scrollTop();
            var width_sidebar = $('#sidebar .gr-not-fixed').outerWidth();
            var distance_sidebar = $('#sidebar .gr-not-fixed').offset().top;
            //var height_sidebar = $('#sidebar').outerHeight() - $('#sidebar .group-fixed').outerHeight();
            var height_sidebar = $('#sidebar .gr-not-fixed').outerHeight(); 
            //if have list heading
            if($('.table-heading').length){
                if(height_sidebar < $('.table-heading').offset().top + $('.table-heading').outerHeight())
                    height_sidebar = $('.table-heading').offset().top - distance_sidebar + height_topHeader;
            }
            if( (height_window > (distance_sidebar + height_sidebar)) && (height_window < (distance_arrow - height_topHeader - 400))){
                $('#market-guide #sidebar .group-fixed').css('width', width_sidebar);
                $('#market-guide #sidebar .group-fixed').addClass('fixed');
                if($('#market-guide #sidebar .group-fixed').hasClass('fixed')){
                    //scroll to in scrollbar
                    var h_scrollTo = 0; 
                    var index = $('.table-list li a.active').closest('li').index() + 1;
                    $('.table-list li a').each(function(){ 
                        if($(this).hasClass('active'))
                            return false;
                        else
                            h_scrollTo += $(this).outerHeight();
                    });
                    $('.scrollbar-inner').animate({scrollTop: h_scrollTo}, 10); //console.log(index, h_scrollTo);
                }
                else{
                }
            } 
            else{
                $('#market-guide #sidebar .group-fixed').removeClass('fixed');
            }
        });
    }
    //close table list sidebar
    $('#sidebar .group-fixed .table-list').on("click" , ".sb-title",function(e){
        e.preventDefault();
        $(this).parents('.table-content').find('.fix_content').toggleClass('active');
        $(this).toggleClass('active');
        //$('.single-tour #sidebar .personalize-tour').addClass('expand');
    });
    /*$('#sidebar .table-list .table-bar').click(function(){
        $(this).parents('.table-list').find('.table-content').removeClass('hide');
        $('.single-tour #sidebar .personalize-tour').removeClass('expand');
    });*/
    //check item schedule of tour is showing screen
    if($('.list-schedule').length){
        $(window).scroll(function(){
            $('.list-schedule .item').each(function(){ 
                /*if(isOnScreen($(this))){
                    var id = $(this).attr('id');
                    $('#sidebar .table-list .table-body li a').removeClass('active');
                    $('#sidebar .table-list .table-body li a[href=#'+ id +']').addClass('active');
                    console.log(id, $(this).outerHeight());
                }
                if(!isOnScreen($(this))){
                    var id = $(this).attr('id');
                    $('#sidebar .table-list .table-body li a[href=#'+ id +']').removeClass('active');
                    console.log(id, $(this).outerHeight());
                }*/
                var id = $(this).attr('id');
                if($(this).isInSchedule()){
                    $('#sidebar .table-list .table-body li a').removeClass('active');
                    $('#sidebar .table-list .table-body li a[href=#'+ id +']').addClass('active');
                }
                else{
                    $('#sidebar .table-list .table-body li a[href=#'+ id +']').removeClass('active');
                }
            });
        });
    }
    //check item schedule of tour is showing screen
    if($('.list-tb-content').length){
        $(window).scroll(function(){
            $('.list-tb-content .item-tb-content').each(function(){ 
                var id = $(this).attr('id'); 
                if($(this).isInSchedule()){
                    $('#sidebar .table-list .table-body li a, .plus-table-guide .table-body li a').removeClass('active');
                    $('#sidebar .table-list .table-body li a[href=#'+ id +'], .plus-table-guide .table-body li a[href=#'+ id +']').addClass('active');
                }
                else{
                    $('#sidebar .table-list .table-body li a[href=#'+ id +'], .plus-table-guide .table-body li a[href=#'+ id +']').removeClass('active');
                }
            });
        });
    }
    //event click scroll to table content item
    $('.list-heading li a, #sidebar .table-list .table-body li a, .plus-table-guide .table-body li a').click(function(e){
        e.preventDefault();
        var id = $(this).attr('href');
        $([document.documentElement, document.body]).animate({
            scrollTop: $(".list-tb-content "+ id).offset().top - 200
        }, 1000);
    });
    //show & hide table heading
    $('.table-heading .collapse-bar').click(function(e){
        e.preventDefault();
        $(this).addClass('hide');
        $(this).closest('.table-heading').find('.list-heading').addClass('hide');
        $(this).closest('.table-heading').find('.expand-bar').removeClass('hide');
    });
    $('.table-heading .expand-bar').click(function(e){
        e.preventDefault();
        $(this).addClass('hide');
        $(this).closest('.table-heading').find('.list-heading').removeClass('hide');
        $(this).closest('.table-heading').find('.collapse-bar').removeClass('hide');
    });
    /*
    * make fixed group button (After banner)
    */
    $(document).ready(function(){
        if($('.gr-btn-top').length){
            var distance_group_topTop = $(".gr-btn-top ").offset().top;
            $(window).scroll(function(){
                var height_scroll =  $(this).scrollTop();
                if(height_scroll > distance_group_topTop)
                    $(".gr-btn-top ").addClass('fixed');
                else
                    $(".gr-btn-top ").removeClass('fixed');
            });
        }
    });
    /*
    * .list-row-reverse
    */
    $('.list-row-reverse').on('click', '.read-more', function(e){
        e.preventDefault();
        $(this).closest('.item').find('.collapse-text').hide();
        $(this).closest('.item').find('.full-text').show();
    });
    $('.list-row-reverse').on('click', '.collapse', function(e){
        e.preventDefault();
        $(this).closest('.item').find('.full-text').hide();
        $(this).closest('.item').find('.collapse-text').show();
    });
    /*end .list-row-reverse*/
    /**********************************
    * ATTRACTION
    **********************************/
    //load more
    $('.attraction-sec').on('click', '.load-more', function(e){
        e.preventDefault();
        var country_id = $(this).closest('.attraction-sec').find('input[name=country_id]').val();
        var num_itemShowing = $(this).closest('.attraction-sec').find('.list-attraction .item').length;
        var icon_id = $(this).closest('.attraction-sec').find('input[name=icon_id]').val();
        var link = $(this).closest('.attraction-sec').find('input[name=loadmore_action]').val();
        var _token = $('input[name=_token').val();
        var listAppend = $(this).closest('.attraction-sec').find('.list-attraction');
        var loadmore_btn = $(this);
        $('#overlay').show();
        $('.loading').show();
        $.ajax({
            type:'POST',            
            url: link,
            cache: false,
            data:{
                '_token' : _token,
                'country_id': country_id,
                'num_itemShowing': num_itemShowing,
                'icon_id': icon_id,
            },
        }).done(function(data) { console.log(data.num_loadNext);
            $('#overlay').hide();
            $('.loading').hide();
            if(data.msg == 'success'){
                if(icon_id != '')
                    listAppend.html(data.html);
                else
                    listAppend.append(data.html);
                if(data.num_loadNext > 0)
                    loadmore_btn.find('small').text(data.num_loadNext);
                else
                    loadmore_btn.remove();
                $(".html5lightbox").html5lightbox();
            }
        });
    });  
    //filter by icon
    $('.attraction-sec').on('click', 'ul.list-icon li', function(){
        var icon_id = $(this).attr('data-id');
        $(this).closest('.attraction-sec').find('input[name=icon_id]').val(icon_id);
        var country_id = $(this).closest('.attraction-sec').find('input[name=country_id]').val();
        var num_itemShowing = $(this).closest('.attraction-sec').find('.list-attraction .item').length;
        var icon_id = $(this).closest('.attraction-sec').find('input[name=icon_id]').val();
        var link = $(this).closest('.attraction-sec').find('input[name=loadbyicon_action]').val();
        var _token = $('input[name=_token').val();
        var listAppend = $(this).closest('.attraction-sec').find('.list-attraction');
        $('#overlay').show();
        $('.loading').show();
        $.ajax({
            type:'POST',            
            url: link,
            cache: false,
            data:{
                '_token' : _token,
                'country_id': country_id,
                'num_itemShowing': num_itemShowing,
                'icon_id': icon_id,
            },
        }).done(function(data) { 
            $('#overlay').hide();
            $('.loading').hide();
            if(data.msg == 'success'){
                listAppend.html(data.html);
                $(".html5lightbox").html5lightbox();
            }
        });
    });
    /*END ATTRACTION*/
    /*
    * .list-row-reverse-2
    */
    if($('.list-row-reverse-2 .item').length){
        $('.list-row-reverse-2 .item').each(function(){
            var height_text = $(this).find('.desc .text').outerHeight(); 
            if(height_text > 340)
                $(this).find('.desc').addClass('collap');
            else{
                $(this).find('.collap-btn').hide();
            }
        });
        $('.list-row-reverse-2 .item .readmore').click(function(e){
            e.preventDefault();
            $(this).closest('.item').find('.desc').removeClass('collap');
        });
        $('.list-row-reverse-2 .item .collap-btn').click(function(e){
            e.preventDefault();
            $(this).closest('.item').find('.desc').addClass('collap');
        });
    }
    /*
    * .list-row-reverse-3
    */
    if($('.list-row-reverse-3 .item').length){
        $('.list-row-reverse-3 .item').each(function(){
            var height_text = $(this).find('.desc .text').outerHeight(); 
            if(height_text > 160)
                $(this).find('.desc').addClass('collap');
            else{
                $(this).find('.collap-btn').hide();
            }
        });
        $('.list-row-reverse-3 .item .readmore').click(function(e){
            e.preventDefault();
            $(this).closest('.item').find('.desc').removeClass('collap');
        });
        $('.list-row-reverse-3 .item .collap-btn').click(function(e){
            e.preventDefault();
            $(this).closest('.item').find('.desc').addClass('collap');
        });
    }
    /**
    * sb show all , collapse item filter
    */
    $('.sb-filter .view-all').click(function(e){
        e.preventDefault();
        parent = $(this).closest('.sb-filter');
        parent.find('.collap-item').removeClass('hidden');
        parent.find('.collap').removeClass('hidden');
        $(this).addClass('hidden');
    });
    $('.sb-filter .collap').click(function(e){
        e.preventDefault();
        parent = $(this).closest('.sb-filter');
        parent.find('.collap-item').addClass('hidden');
        parent.find('.view-all').removeClass('hidden');
        $(this).addClass('hidden');
    });
    /*checkbox-single*/
    $('#sidebar .checkbox-single .checkbox').click(function(e){
        parent = $(this).closest('.checkbox-single');
        //parent.find('.checkbox input').prop('checked', false);
        //$(this).find('input').prop('checked', true);
        if($(this).find('input').is(':checked')){
            parent.find('.checkbox input').prop('checked', false);
        }
        else{
            parent.find('.checkbox input').prop('checked', false);
            $(this).find('input').prop('checked', true);
        }
    });
    /**
     * .list-content-sec
     */
    if($('.list-content-sec').length){
        $('.list-content-sec').each(function(){ 
            var height_text = $(this).find('.list-content').outerHeight();  console.log(height_text);
            if(height_text > 580)
                $(this).addClass('collap');
            else{
                $(this).find('.collap-btn').hide();
            }
        });
        $('.list-content-sec .readmore').click(function(e){
            e.preventDefault();
            $(this).closest('.list-content-sec').removeClass('collap');
        });
        $('.list-content-sec .collap-btn').click(function(e){
            e.preventDefault();
            $(this).closest('.list-content-sec').addClass('collap');
        });
    }
    /**
     * event click document
     */
    $(document).click(function(e){
        var target = $( e.target );
        //gr-filter
        if(! target.hasClass('box-item') && (target.parents('.box-item').length == 0)){
            if($('.content-country-tour, #clients-review').length>0 && $( window ).width() <= 768){
                $('.content-country-tour .gr-filter .box-item ul').slideUp('fast');
                $('#clients-review .gr-filter .box-item ul').slideUp('fast');
            }
            $('.single-tour .gr-filter .box-item ul').slideUp('fast');
            $(".list-filter .box-item").each(function(){
                var box_item = $(this);
                if(box_item.find("li.active").size() > 0){
                    box_item.find("span.title").addClass("active");
                }else{
                    box_item.find("span.title").removeClass("active");
                }
            });
            setTimeout(function(){ 
                $('.gr-filter .box-item').removeClass('active');
            }, 200);
        }
        //end gr-filter
    });
    /**
     * .gr-filter
     */
    $('body').on('click', '.gr-filter .box-item',function(e){ 
        var target = $( e.target ); 
        if(target.hasClass('title') || target.hasClass('box-item')){
            var box_item = $(this);
            if($(this).hasClass('active')){
                $(this).find('ul').slideUp('fast');
                setTimeout(function(){ 
                    box_item.removeClass('active'); 
                }, 200);
            }else{
                $('.gr-filter .box-item ul').slideUp('fast');
                setTimeout(function(){ 
                    $('.gr-filter .box-item').removeClass('active');
                    box_item.addClass('active');
                    box_item.find('ul').slideDown('fast');
                }, 100);
            }
            $(".list-filter .box-item").each(function(){
                var box_item = $(this);
                if(box_item.find("li.active").size() > 0){
                    box_item.find("span.title").addClass("active");
                }else{
                    box_item.find("span.title").removeClass("active");
                }
            });
        }
    });
    //filter item in .gr-filter
    $('body').on('click', '.gr-filter .box-item ul li', function(){
        var parent = $(this).closest('.box-item');
        var number = $(this).parents('.wrap-filter').find('.has-select .value').attr('data-value'); 
        $(this).parents('.gr-filter').find('input.value-vp').val(number);
        if(parent.hasClass('single-value')){
            if($(this).hasClass('active')){
                parent.find('li').removeClass('active');
                parent.find('li input').prop('checked', false);
            }else{
                parent.find('li').removeClass('active');
                parent.find('li input').prop('checked', false);
                $(this).addClass('active');
                $(this).find('input').prop('checked', true);
            }
        }
        else{ 
            if($(this).hasClass('active')){
                $(this).removeClass('active');
                $(this).find('input').prop('checked', false);
            }
            else{ 
                $(this).addClass('active');
                $(this).find('input').prop('checked', true);
            }
        }
        if($(this).parents('.gr-filter').find("input:checked").size() > 0) {
            $(this).parents('.gr-filter').find('.btn-reset').addClass('pinkbg');
            $(this).parents('.gr-filter').find('.btn-reset .img_reset').html(imageWhite);
        }else{
            $(this).parents('.gr-filter').find('.btn-reset').removeClass('pinkbg');
            $(this).parents('.gr-filter').find('.btn-reset .img_reset').html(imageYellow);
        }
        //send ajax
        $('#overlay').show();
        $('.loading').show();
        console.log($(this).find('input').val());
        var wrap_filter = $(this).closest('.wrap-filter');
        var form = $(this).closest('form');
        var data_send = form.serialize();
        $.ajax({
            type:'POST',            
            url: form.attr('action'),
            cache: false,
            data: data_send,
        }).done(function(data) {
            $('#overlay').hide();
            $('.loading').hide();
            if(data.msg == 'success'){ 
                if(wrap_filter.find('.slide-style, .slide-tour-dost').length){
                    wrap_filter.find('.slide-style, .slide-tour-dost').trigger('destroy.owl.carousel').removeClass('owl-carousel owl-loaded');;
                    wrap_filter.find('.slide-style, .slide-tour-dost').html(data.html);
                    slideThreeItem(wrap_filter.find('.slide-style, .slide-tour-dost'));
                }else{
                    wrap_filter.find('.wrap-result .filter-nvp').html(data.html);
                    wrap_filter.find('.wrap-result .seeing .number').text(data.number);
                    wrap_filter.find('.filter-tour').html(data.filter);
                }
            }
        });
        return false;
    });
    //reset .gr-filter
    $('.gr-filter .btn-reset').click(function(e){
        e.preventDefault();
        $(this).removeClass('pinkbg');
        $(this).find('.img_reset').html(imageYellow);
        var number = $(this).parents('.wrap-filter').find('.has-select .value').attr('data-value');
        $(this).parents('.wrap-filter').find('.has-select .value').text(number);
        var wrap_filter = $(this).closest('.wrap-filter');
        wrap_filter.find('.box-item ul li').removeClass('active');
        wrap_filter.find('.box-item ul li input').prop('checked', false);
        //send ajax
        $('#overlay').show();
        $('.loading').show();
        var form = $(this).closest('form');
        var data_send = form.serialize() + '&type_filter=reset';
        $.ajax({
            type:'POST',            
            url: form.attr('action'),
            cache: false,
            data: data_send,
        }).done(function(data) {
            $('#overlay').hide();
            $('.loading').hide();
            if(data.msg == 'success'){
                if(wrap_filter.find('.slide-style, .slide-tour-dost').length){
                    wrap_filter.find('.slide-style, .slide-tour-dost').trigger('destroy.owl.carousel').removeClass('owl-carousel owl-loaded');
                    wrap_filter.find('.slide-style, .slide-tour-dost').html(data.html);
                    slideThreeItem(wrap_filter.find('.slide-style'));
                }else{
                    wrap_filter.find('.wrap-result .filter-nvp').html(data.html);
                    wrap_filter.find('.filter-tour').html(data.filter);
                    wrap_filter.find('.content-review .wrap-result').html(data.html);
                }
            }
        });
    });
    //paginate gr-filter
    /*$('.wrap-filter').on('click', 'a.page-link', function(e){
        e.preventDefault();
        var wrap_filter = $(this).closest('.wrap-filter');
        var form = wrap_filter.find('form');
        var page = 1;
        if($(this).hasClass('page-arrow')){
            var current_page = parseInt($(this).closest('.pagination').find('li.active .page-link').text());
            if($(this).hasClass('page-next'))
                page = current_page + 1;
            else
                page = current_page - 1;
        }else{
            page = $(this).text();
        }
        //send ajax
        $('#overlay').show();
        $('.loading').show();
        var data_send = form.serialize() + '&per_page=6&page=' + page;
        $.ajax({
            type:'POST',            
            url: form.attr('action'),
            cache: false,
            data: data_send,
        }).done(function(data) {
            $('#overlay').hide();
            $('.loading').hide();
            if(data.msg == 'success'){
                wrap_filter.find('.wrap-result').html(data.html);
            }
        });
    });*/
    //read-more gr-filter
    $('.content-review .wrap-filter').on('click', '.view-more', function(e){
        let wrap_filter = $(this).closest('.wrap-filter'); 
        let form = wrap_filter.find('form');
        let current_item = wrap_filter.find('.wrap-result .item').length;
        let data_send = form.serialize() + '&skip=' + current_item;
        $('#overlay').show();
        $('.loading').show();
        $.ajax({
            type:'POST',            
            url: form.attr('action'),
            cache: false,
            data: data_send,
        }).done(function(data) {
            $('#overlay').hide();
            $('.loading').hide();
            if(data.msg == 'success'){ 
                wrap_filter.find('.list-item.row').append(data.html);
                if(data.view_more == 'hide')
                    wrap_filter.find('.wrap-readmore').remove();
            }
        });
    });
    /**
     * slide category FAQ
     */
    $('.list-faq-mobi').owlCarousel({
        items:6,
        loop:false,
        margin:20,
        autoplay:false,
        nav:false,
        dots: false,
        navText:['<i class="gray fa fa-caret-left" aria-hidden="true"></i>','<i class="gray fa fa-caret-right" aria-hidden="true"></i>'],
        autoplayTimeout:1000,
        autoplayHoverPause:true,
        responsive : {
            320:{
                items:3,
                margin:10,
                dots: true
            },
            480:{
                items:3,
                dots: true
            },
            768:{
                dots: true,
                items:3,
            },  
            1024:{
                items:6
            },         
        }
    });
    $('.list-faq .title').click(function (){
        let item = $(this).closest('.item');
        if(item.hasClass('active')){
            item.removeClass('active');
            item.find('.desc').slideUp();
        }else{
            item.addClass('active');
            item.find('.desc').slideDown();
        }
    });
    $('.tabs-sec .list-cat-faq .item, .tabs-sec .list-faq-mobi .item').click(function(e){
        e.preventDefault();
        let id = $(this).attr('data-id');
        $('.tabs-sec .tab-content .tab-faq').hide();
        $('.tabs-sec .list-cat-faq .item, .tabs-sec .list-faq-mobi .item').removeClass('active');
        $(this).addClass('active');
        $('.tabs-sec .tab-content ' + id).fadeIn();
        $('.list-faq .item').removeClass('active');
        $('.list-faq .item .desc').hide();
    });
});
//validate email
function validateEmail($email) {
  var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
  return emailReg.test( $email );
}
$.fn.isInSchedule = function() {
      var elementTop = $(this).offset().top;
      var elementBottom = elementTop + $(this).outerHeight();
      var viewportTop = $(window).scrollTop();
      var viewportBottom = viewportTop + $(window).height();
      return elementBottom > viewportTop && elementTop < viewportBottom - $(window).height() + 300;
};
//slide function 
function slideThreeItem(element){
    element.owlCarousel({
        items:3,
        loop:false,
        margin:20,
        autoplay:false,
        nav:true,
        dots: false,
        navRewind: false,
        navText:['<i class="fa fa-angle-left" aria-hidden="true"></i>','<i class="fa fa-angle-right" aria-hidden="true"></i>'],
        autoplayTimeout:1000,
        autoplayHoverPause:true,
        responsive : {
            0:{
                items:0
            },
            320:{
                items:1
            },
            568:{
                items:2
            },
            768:{
                items:2
            },  
            1025:{
                items:3
            },         
        }
    });
}
