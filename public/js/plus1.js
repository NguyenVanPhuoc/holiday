
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
    // Thêm class 'lazy' vào tất cả hình ảnh trên website
    $('img').each(function () {
        $(this).addClass("lazy");
    }); 
    // Gọi hàm lazy load
    $(function () {
        $("img").lazyload();
    });
    if($('.what_style , .special , .community').length){
        $(window).load(function(){
            $('.grid').masonry({
                itemSelector: '.grid-item',
            });
        });
        }
});
$(document).ready(function() {
  
    // Configure/customize these variables.
    var showChar = 406;
    var ellipsestext = "...";
    var moretext = "More";
    //var lesstext = "Less";
    $('.author_comment .text').each(function() {
        var content = $(this).html();
        if(content.length > showChar) {
            var c = content.substr(0, showChar);
            var h = content.substr(showChar, content.length - showChar);
            var html = c + '<span class="moreellipses">' + ellipsestext+ '</span><span class="morecontent">' + h + '</span><span class="morelink">'+ moretext +'</span>';
            $(this).html(html);
        }
    });
    $(".morelink").click(function(e){
        e.preventDefault();
        if($(this).hasClass("less")) {
            $(this).removeClass("less");
            $(this).html(moretext);
        } else {
            $(this).addClass("less");
            $(this).hide();
        }
        $(this).parents('.text').find('.morecontent').addClass('active');
        $(this).parents('.text').find('.moreellipses').hide();
        return false;
    });
});
$(document ).ready(function(){
    
    $('.maps')
    .click(function(){
        $(this).find('iframe').addClass('clicked')})
    .mouseleave(function(){
        $(this).find('iframe').removeClass('clicked')});
    
    //Scroll menu
    var didScroll;
    var lastScrollTop = 0;
    var delta = 5;
    var navbarHeight = $('header.head-sonasia').outerHeight();
    $(window).scroll(function(event){
        didScroll = true;
    });
    setInterval(function() {
        if (didScroll) {
            hasScrolled();
            didScroll = false;
        }
    }, 250);
    function hasScrolled() {
        var st = $(this).scrollTop();
        if(Math.abs(lastScrollTop - st) <= delta)
            return;
        if (/*st > $(window).height() && */st > lastScrollTop && st > navbarHeight){
            $('header.head-sonasia').removeClass('nav-down').addClass('nav-up');
            $('.menu-top-single').removeClass('nav-down').addClass('nav-up');
            $('.nav-resquest').removeClass('nav-down').addClass('nav-up');
            $('#backtotop').removeClass('nav-down').addClass('nav-up');
        } else {
            if(st + $(window).height() < $(document).height() && /*st > $(window).height()*/st > navbarHeight) {
                $('header.head-sonasia').removeClass('nav-up').addClass('nav-down');
                $('.nav-resquest').removeClass('nav-up').addClass('nav-down');
            }else{
                $('header.head-sonasia').removeClass('nav-up').removeClass('nav-down');
                $('.nav-resquest').removeClass('nav-up').removeClass('nav-down');
            }
            if(st + $(window).height() < $(document).height() && st > $(window).height()) {
                $('.menu-top-single').removeClass('nav-up').addClass('nav-down');
                $('#backtotop').removeClass('nav-up').addClass('nav-down');
            }else{
                $('.menu-top-single').removeClass('nav-up').removeClass('nav-down');
                $('#backtotop').removeClass('nav-up').removeClass('nav-down');
            }
        }
        lastScrollTop = st;
    }
    $(".modal_itinerary").on('click', function(e) {
        e.preventDefault();
        $("#gallery-schedule").modal("hide");
        $("#description_price").modal("hide");
        setTimeout(function(){
            $("#itinerary_brief").modal("show");
        },500);
    });
    $(".modal_price").on('click', function(e) {
        e.preventDefault();
        $("#itinerary_brief").modal("hide");
        $("#gallery-schedule").modal("hide");
        setTimeout(function(){$("#description_price").modal("show");},500);
    });
    $(document).keydown(function(e) { 
      if (e.keyCode == 27) { 
        $('#itinerary_brief').modal("hide");
        $("#gallery-schedule").modal("hide");
        $("#description_price").modal("hide");
        $("#gallery-style").modal("hide");
        $("#detail-style").modal("hide");
        $("#mySeachTour").modal("hide");
      }
    });
    $("#search-top .icon-search").on("click",function(e){
        e.preventDefault();
        $("#mySeachTour").modal();
    });
   
    $('.content-guide').on('click', '.box-item1.single-value li', function(event) {
        event.preventDefault();
        var $value = $(this).find('label input[name=nationality_id]').val();
        var $text = $(this).find('label span.title_nation').text();
        $(this).parents('.box-item1.single-value.nationality').attr("data-link",$value);
        $(this).parents('.box-item1.single-value').find('input[name=key_nation]').val($text);
        $(this).parents('.box-item1.single-value').find('input[name=key_nation]').addClass('open');
        $(this).parent('.list-unstyled').hide();
        $(this).parents('.box-item1.single-value').removeClass('active');
    });
    $('.form-show').on('click','input.open', function(e){ 
        e.preventDefault();
        $text = '';
        $(this).val($text);
           href = $('.form-show').attr('data-href');
            var ajaxUrl = $('#search-res').attr('data-href'),              
                _token = $("form input[name='_token']").val();
            $.ajax({
                type:'POST',            
                url: ajaxUrl,
                cache: false,
                data:{
                    'keyword': '',
                    '_token': _token,
                },
                beforeSend: function() {
                    $('.form-show .nationality ul.list-unstyled').html('');
                },
                success:function(data){
                    if(data.count != 0) {
                        $('.form-show .nationality ul.list-unstyled').html(data.html);                                  
                        $('.form-show .nationality ul.list-unstyled').show();                        
                    }else{
                        $('.form-show .nationality ul.list-unstyled').html('');
                    }
                }
            });
    });
    $(".select_sear").select2({
      placeholder: 'Your nationality',
      allowClear: true
    });
    $(".select_des").select2({
      placeholder: 'Destinations',
      allowClear: true
    });
    $('.select_des').on('select2:opening select2:closing', function( event ) {
        var $searchfield = $(this).parent().find('.select2-search__field');
        $searchfield.prop('disabled', true);
    });
    $(".banner_nvp .top-desc .name a").on("click",function(e){
        e.preventDefault();
        var element = $(this).attr('href');
        var height = $(element).offset().top - 120;
        $("html, body").animate({scrollTop : height},550);       
    });
    $('.blog .related_post').on('click', ".sb-title", function(event) {
        event.preventDefault();
        $(this).toggleClass('active');
        $(this).siblings('.desc').toggleClass('active');
        $(this).parents('.group-fixed-table').find('.fix_content').removeClass('active');
        $(this).parents('.group-fixed-table').find('.table-list .sb-title').removeClass('active');
    });
    $('.blog .group-fixed-table .table-list').on("click" , ".sb-title",function(e){
        e.preventDefault();
        $(this).parents('.table-content').find('.fix_content').toggleClass('active');
        $(this).toggleClass('active');
        $(this).parents('.group-fixed-table').find('.related_post .desc').removeClass('active');
        $(this).parents('.group-fixed-table').find('.related_post .sb-title').removeClass('active');
    });
    //fixed group group-fixed-table sidebar when scroll page blog detail
    if($('#sidebar .group-fixed-table').length){
        var height_topHeader = $('menu-top').outerHeight();
        var distance_arrow = $('.back-to-start').offset().top; 
        $(window).scroll(function(){
            distance_arrow = $('.back-to-start').offset().top; 
            var height_window = $(window).scrollTop();
            var item_h = $(".gr-fixed-nvp").offset().top + $(".gr-fixed-nvp").height() + 20;   
            if( (height_window > item_h) && (height_window < (distance_arrow - height_topHeader - 400))){
                $('#sidebar .group-fixed-table').addClass('fixed');
                if($('#sidebar .group-fixed-table').hasClass('fixed')){
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
                else{}  
            } 
            else{
                $('#sidebar .group-fixed-table').removeClass('fixed');
            }
        });
    }
    //fixed sidebar sb-contact booking-comnditions
    if($('.one-page .sb-contact').length){
        var height_topHeader = $('menu-top').outerHeight();
        var distance_arrow = $('.back-to-start').offset().top; 
        $(window).scroll(function(){
            distance_arrow = $('.back-to-start').offset().top; 
            var height_window = $(window).scrollTop();
            var item_h = $(".padding_auto").offset().top + $(".padding_auto").height() + 20;   
            if( (height_window > item_h) && (height_window < (distance_arrow - height_topHeader - 600))){
                $('.one-page .sb-contact').addClass('fixed');
                if($('.one-page .sb-contact').hasClass('fixed')){
                    var h_scrollTo = 0; 
                    $('.scrollbar-inner').animate({scrollTop: h_scrollTo}, 10); //console.log(index, h_scrollTo);
                }
                else{}  
            } 
            else{
                $('.one-page .sb-contact').removeClass('fixed');
            }
        });
    }
    $(".item-tb-content .text img").each(function(){
        var alt = $(this).attr("alt");
        if(alt != ''){
            $(this).parent().addClass('name_nvp');
            $(this).after('<span class="title_alt">'+alt+'</span>');
        }
    })
    if($('.city_guide').length){
         $('.list_best .item:first-child').addClass('current');
        $('.tabs-dis .link_tab:first-child').addClass('current');
    }
    $('.tabs-dis .link_tab').on('click', function(e){
        e.preventDefault();
        var tab_id = $(this).attr('data-href');
        var height_topHeader = $('header .top').outerHeight() + $('menu-top').outerHeight();
        var item_top = $('.city_guide').offset().top;
        $('.tabs-dis .link_tab').removeClass('current');
        $('.list_best .item').removeClass('current');
        $(this).addClass('current');
        $("#"+tab_id).addClass('current');
        $("html, body").animate({ scrollTop: item_top - height_topHeader - 50 }, 300);
    })
     $('#sidebar .fixel_discover .table-list').on("click" , ".sb-title",function(e){
        e.preventDefault();
        $(this).parents('.table-content').find('.fix_content').toggleClass('active');
        $(this).toggleClass('active');
    });
    //fixed discover sidebar when scroll
        if($('#sidebar .fixel_discover').length > 0 && $( window ).width() > 1024){
            var height_topHeader = $('header .top').outerHeight() + $('menu-top').outerHeight();
            var distance_arrow = $('.back-to-start').offset().top;             
            $(window).scroll(function(){
                distance_arrow = $('.back-to-start').offset().top; 
                var height_window = $(window).scrollTop();
                var item_h = $(".gallery-sec").offset().top + $(".gallery-sec").height() + 300;
                if((height_window > item_h ) && (height_window < (distance_arrow - height_topHeader - 350))){
                    $('#sidebar .fixel_discover').addClass('fixed');  
                } 
                else{
                    $('#sidebar .fixel_discover').removeClass('fixed');
                }
            });
        }
        if($('.plus-table').length > 0 && $( window ).width() <= 1024){
            var height_topHeader = $('header .top').outerHeight() + $('menu-top').outerHeight();
            var distance_arrow = $('.back-to-start').offset().top;             
            $(window).scroll(function(){
                distance_arrow = $('.back-to-start').offset().top; 
                var height_window = $(window).scrollTop();
                var item_h = $(".fixel_discover").offset().top + $(".fixel_discover").height() - 50;
                if((height_window > item_h ) && (height_window < (distance_arrow - height_topHeader - 350))){
                    $('.plus-table').addClass('current');  
                } 
                else{
                    $('.plus-table').removeClass('current');
                }
            });
            $('.plus-table').on('click', '.plus-open', function(e){
                e.preventDefault();
                $(this).parents('.plus-table').find('.list-visit').slideDown();
                $(this).parent().hide();
            });
            $('.plus-table').on('click', '.closes', function(e){
                e.preventDefault();
                $(this).parents('.list-visit').slideUp();
                $(this).parents('.plus-table').find('.transparent-open').show();
            });
        }
    //end fixed
    $('.form-show input[name=key_nation]').on('input', function(){        
        var keyword = this.value,
            href = $('.form-show').attr('data-href');
            var ajaxUrl = $('#search-res').attr('data-href'),              
                _token = $("form input[name='_token']").val();
            $.ajax({
                type:'POST',            
                url: ajaxUrl,
                cache: false,
                data:{
                    'keyword': keyword,
                    '_token': _token,
                },
                beforeSend: function() {
                    $('.form-show .nationality ul.list-unstyled').html('');
                },
                success:function(data){
                    if(data.count != 0) {
                        $('.form-show .nationality ul.list-unstyled').html(data.html);                                  
                        $('.form-show .nationality ul.list-unstyled').show();                        
                    }else{
                        $('.form-show .nationality ul.list-unstyled').html('');
                    }
                }
            });
    });
    /******************
    * search box
    ******************/
    $('.search-box .list-result ul').scrollbar();
    $('.searchArticle .result-search').scrollbar();
    $('.menu-mobi .mid .sub-collection ul.list-style-cat').scrollbar();
    $('.menu-mobi .mid .search-country-guide .nationality ul.list-unstyled').scrollbar();
    $('.list-orther .other-mobi ul').scrollbar();
    $('.nationality ul.list-hightlight').scrollbar();
    $('.wrapper_scroll .list-itinerary').scrollbar();
    $('.wrapper_scroll .list_desc_price').scrollbar();
    $('.wrapper_scroll .desc_vp').scrollbar();
    $('.search-box input').focus(function(){
        $('.search-box .list-result').show();
    });
    $('.search-box input').focusout(function(){
        $(document).click(function(e){
            var element = e.target; 
            if($(element).hasClass('list-result') || $(element).is('input') || $(element).hasClass('scroll-bar')){
                $('.search-box .list-result').show();
            }
            else{
                $('.search-box .list-result').hide();
            }
        });
    });
    //input ajax
    $('.search-box input').on('input', function(){
        clearTimeout(this.delay);
        this.delay = setTimeout(function(){
            /* call ajax request here */
            var keyword = $(this).val(); 
            var link = $(this).attr('data-action');
            var _token = $('input[name=_token]').val();
            var country = $('input[name=country]').val();
            var cat_guide = $('input[name=cat_guide]').val();
            var parent = $(this).closest('.search-box');
            var current_id = '';
            if(parent.find('[name=current_id]').val() != undefined)
                current_id = parent.find('[name=current_id]').val();
            parent.addClass('loading');
            $.ajax({
                type:'POST',            
                url: link,
                cache: false,
                data:{
                    '_token' : _token,
                    'country' : country,
                    'cat_guide' : cat_guide,
                    'keyword': keyword,
                    'current_id': current_id
                },
            }).done(function(data) {
                parent.removeClass('loading');
                if(data.msg == 'success'){
                    parent.find('ul').html(data.html);
                }
            });
        }.bind(this), 1000);
    });
    /*$('.search-box').on('click', '.list-result li', function(e) {
        e.preventDefault();
        var $text = $(this).find('a.link_city').text();
        var $link = $(this).find('a.link_city').attr("href");
        $(this).parents("form").attr("action",$link);
        $(this).addClass('active');
        $(this).parents('.search-box').find('input[name=keyword]').val($text);
        $(this).parents('.search-box').find('input[name=keyword]').addClass('open');
        $(this).parent('.list-result').hide();
    });*/
    /*$('.search-box').on('click','input.open', function(e){ 
        e.preventDefault();
        $text = '';
        $(this).val($text);
            var link = $(this).attr('data-action');
            var _token = $('input[name=_token]').val();
            var parent = $(this).closest('.search-box');
            var current_id = '';
            if(parent.find('[name=current_id]').val() != undefined)
                current_id = parent.find('[name=current_id]').val();
            parent.addClass('loading');
            $.ajax({
                type:'POST',            
                url: link,
                cache: false,
                data:{
                    '_token' : _token,
                    'keyword': '',
                    'current_id': current_id
                },
            }).done(function(data) {
                parent.removeClass('loading');
                if(data.msg == 'success'){
                    parent.find('ul').html(data.html);
                }
            });
    });*/
    /*end search box*/
    $(".main-menu li ").mouseover(function(e){
        e.preventDefault();
        $('.overlay_nvp').addClass('active');
    });
    $(".main-menu li ").mouseout(function(e){
        e.preventDefault();
        $('.overlay_nvp').removeClass('active');
    });
    $(".menu-mobi .mid .main-nav-mobile li a .destinations").append('<i class="fa fa-angle-right" aria-hidden="true"></i>');
    $(".menu-mobi .mid .main-nav-mobile li a > .destinations").on('click',function(e){
        e.preventDefault();
        $(this).parents('li').find(".sub-destination").show();
        $(this).parents('li').addClass('active');
    });
    $(".menu-mobi .mid .main-nav-mobile li a .tour-style").append('<i class="fa fa-angle-right" aria-hidden="true"></i>');
    $(".menu-mobi .mid .main-nav-mobile li a > .tour-style").on('click',function(e){
        e.preventDefault();
        $(this).parents('li').find(".sub-tour-style").show();
        $(this).parents('li').addClass('active');
    });
    $(".menu-mobi .mid .main-nav-mobile li a .tips_guide").append('<i class="fa fa-angle-right" aria-hidden="true"></i>');
    $(".menu-mobi .mid .main-nav-mobile li a > .tips_guide").on('click',function(e){
        e.preventDefault();
        $(this).parents('li').find(".sub-tips_guide").show();
        $(this).parents('li').addClass('active');
    });
    $(".menu-mobi .mid .main-nav-mobile li a .country_guide").append('<i class="fa fa-angle-right" aria-hidden="true"></i>');
    $(".menu-mobi .mid .main-nav-mobile li a > .country_guide").on('click',function(e){
        e.preventDefault();
        $(this).parents('li').find(".sub-search-guide").show();
        $(this).parents('li').addClass('active');
    });
    $('.main-nav-mobile > ul > li a .destinations').parents('li').mouseover(function(){
        if($('.mid .sub-destination .item').length){
            var h_img = $('.mid .sub-destination .wrap-item:first-child .item').outerHeight(); 
            $('.mid .sub-destination .wrap-item:last-child .thumb > img').css('min-height', h_img).css('width', 'auto');
        }
    });
    $(".menu-mobi .sub-destination").detach().appendTo($(".mid .main-menu .destinations").parents('li'));
    $(".menu-mobi .sub-tour-style").detach().appendTo($(".mid .main-menu .tour-style").parents('li'));
    $(".menu-mobi .sub-tips_guide").detach().appendTo($(".mid .main-menu .tips_guide").parents('li'));
    $(".menu-mobi .sub-search-guide").detach().appendTo($(".mid .main-menu .country_guide").parents('li'));
    $("header .mobile-menu .icon").on("click",function(e){
        e.preventDefault();
        $(".menu-mobi").addClass('active');
    });
    $("header .icon-menu").on("click",function(e){
        e.preventDefault();
        $(this).addClass('open');
        $(".menu-mobi .mid .main-menu").show();
        $(".menu-mobi .mid .contact-mobi").hide();
        $("header .icon-phone").removeClass('open');
    });
    $("header .icon-phone").on("click",function(e){
        e.preventDefault();
        $(this).addClass('open');
        $(".menu-mobi .mid .contact-mobi").show();
        $(".menu-mobi .mid .main-menu").hide();
        $("header .icon-menu").removeClass('open');
    });
    $(".menu-mobi .top-mobi .close-mobi , .menu-mobi .top-mobi .back_nvp").on('click',function(e){
        e.preventDefault();
        $('.menu-mobi').removeClass('active');
        $(".menu-mobi .mid .menu li .sub-destination").hide();
        $(".menu-mobi .mid .menu li ").removeClass('active');
        $("header .icon").removeClass('open');
    });
    $(".menu-mobi .mid .main-nav-mobile li a .angle-right").append('<i class="fa fa-angle-right" aria-hidden="true"></i>');
    $(".menu-mobi .mid .main-nav-mobile li a > .angle-right ").on('click',function(e){
        e.preventDefault();
        $(this).parents('li').addClass('active');
    });
    /*$(".menu-mobi .mid .main-nav-mobile ul.list-style-cat li > a ").on('click',function(e){
        e.preventDefault();
        $(this).parents('ul.list-style-cat li').find(".country_cat").slideToggle();
        $(this).parents('li').toggleClass('current');
        $(this).find('.angle-right i').toggleClass('open');
    });*/
    $(".menu-mobi .top-mobi .back").on('click',function(e){
        e.preventDefault();
        $(this).closest("li").removeClass('active'); 
    });
    $(".menu-mobi .mid .search_tour").on('click',function(e){
        e.preventDefault();
        $('.search_mobile').addClass('active');
    });
    $(".menu-mobi .mid .back_search").on('click',function(e){
        e.preventDefault();
        $(this).parents('.search_mobile').removeClass('active');
    });
    $(".menu-mobi .mid .search_with_code").on('click',function(e){
        e.preventDefault();
        $(this).parent('.form-search').siblings('.looking').slideToggle();
    });
    //Menu mobi blog
    $(".menu-blog-mobi .mid .main-nav-mobile li a .discover > i").on('click',function(e){
        e.preventDefault();
        $(this).parents('li').addClass('active');
    });
    $(".menu-blog-mobi .mid .main-nav-mobile li a .topics > i").on('click',function(e){
        e.preventDefault();
        $(this).parents('li').addClass('active');
    });
    $(".menu-blog-mobi .mid .main-nav-mobile li a.search_tour").on('click',function(e){
        e.preventDefault();
        $(this).parents('li').addClass('active');
    });
    $(".scroll_day").on("click",function(e){
        e.preventDefault();
        $("#itinerary_brief").modal("hide");
        var element = $(this).attr('href');
        var height = $(element).offset().top - 100;
        $("html, body").animate({scrollTop : height},550);         
    });
    $('.content-single .content-schedule').readmore({speed: 500});
    // scroll active highlight
    if($('.list-sec-schedule').length){
        var items = [];
        var isOnDiv = false;
        var  current_value = "";
        function ScrollToActiveTab(){
            $(".list-sec-schedule").each(function(){
                var id = $(this).attr("id");
                var item = {
                    'id' : id,
                    'offset' : $(this).offset().top + $(window).height(),
                    'height' : $(this).height(),
                } 
                items.push(item);
            });
        }
        setTimeout(function(){
            ScrollToActiveTab();
        },500);
        $(window).on("scroll",function(){
                var current_offset = $(document).scrollTop() + $(window).height() + 400;
                var total = items.length - 1;
                for (var i = total; i >= 0; i--) {
                    if(current_offset > items[i].offset && current_offset < (items[i].offset + items[i].height)){
                        $(".list-itinerary .item a[href=#"+items[i].id+"]").parents(".item").addClass("active").siblings(".item").removeClass("active");
                        current_value = items[i].id;
                        if(i == total && current_offset > (items[i].offset + items[i].height)){
                            $(".list-itinerary .item").removeClass("active");
                            current_value = "";
                        }
                        return false;
                    }
                }
        });
        $('#itinerary_brief').on('shown.bs.modal', function (e) {
          if(current_value != ""){
              $('.list-itinerary.scroll-content').animate({scrollTop:$(".list-itinerary .item a[href='#"+current_value+"']").parents(".item").position().top},500);
          }
        })
    }
   
    $(".btn-show-gallery").on("click",function(e){
        e.preventDefault();
        var id = $(this).attr("data-modal");
        var key = $(this).attr("data-key");
        $("#gallery-schedule").find('.list_gallery').not($('.gallery__'+key)).addClass('hidden');
        $("#gallery-schedule").find('.list_gallery.gallery__'+key).removeClass('hidden');
        $(id).modal("show");
        $("#itinerary_brief").find('.show_'+key).addClass('active');
        $("#itinerary_brief").find('.item').not($('.show_'+key)).removeClass('active');
        setTimeout(function(){
            $("#gallery-schedule").find('.list_gallery').trigger('destroy.owl.carousel').removeClass('owl-carousel owl-loaded');
            $('#gallery-schedule .list_gallery').find('.owl-stage-outer').children().unwrap();
            $("#gallery-schedule").find('.list_gallery.gallery__'+key).owlCarousel({
                items:1,
                loop:true,
                margin:30,
                autoplay:false,
                nav:true,
                dots: false,
                lazyLoad:true,
                navRewind: false,
                navText:['<i class="fa fa-angle-left" aria-hidden="true"></i>','<i class="fa fa-angle-right" aria-hidden="true"></i>'],
            });
        },200);
    })
    $(".btn-gallery").on("click",function(e){
        e.preventDefault();
        var id = $(this).attr("data-modal");
        var key = $(this).attr("data-key");
        $("#gallery-style").find('.list_st').not($('.gallery__'+key)).addClass('hidden');
        $("#gallery-style").find('.list_st.gallery__'+key).removeClass('hidden');
        $("#gallery-style").find('.desc_vp').not($('.desc__'+key)).addClass('hidden');
        $("#gallery-style").find('.desc_vp.desc__'+key).removeClass('hidden');
        $(id).modal("show");
        setTimeout(function(){
            $("#gallery-style").find('.list_st').trigger('destroy.owl.carousel').removeClass('owl-carousel owl-loaded');
            $('#gallery-style .list_st').find('.owl-stage-outer').children().unwrap();
            $("#gallery-style").find('.list_st.gallery__'+key).owlCarousel({
                items:1,
                loop:false,
                margin:30,
                autoplay:false,
                nav:true,
                dots: false,
                lazyLoad:true,
                navRewind: false,
                navText:['<i class="fa fa-angle-left" aria-hidden="true"></i>','<i class="fa fa-angle-right" aria-hidden="true"></i>'],
            });
        },200);
    })
    $(".view-detail").on("click",function(e){
        e.preventDefault();
        var id = $(this).attr("data-modal");
        var key = $(this).attr("data-key");
        $("#detail-style").find('.list_map').not($('.map__'+key)).addClass('hidden');
        $("#detail-style").find('.list_map.map__'+key).removeClass('hidden');
        $("#detail-style").find('.desc_vp').not($('.desc__'+key)).addClass('hidden');
        $("#detail-style").find('.desc_vp.desc__'+key).removeClass('hidden');
        $(id).modal("show"); 
    })

    $("#market-guide .dropdown .drop_show").on("click",function(e){
        e.preventDefault();
        if($(this).hasClass('active')){
            $(this).removeClass('active');
            $(this).siblings('.list-result').slideUp();
        }else{
            $(this).addClass('active');
            $(this).siblings('.list-result').slideDown();
        }
    });
    
    $(document).mouseup(function(e) {
        var container = $("#market-guide .dropdown");
        if (!container.is(e.target) && container.has(e.target).length === 0 && $("#market-guide .dropdown .list-result").is(":visible")) 
        {    
            $("#market-guide .dropdown .drop_show").removeClass("active")
            $("#market-guide .dropdown .list-result").hide();
        }
    });

    $("body").on("click",".has-bg-unde .view-more", function(e) {
        e.preventDefault();
        var current = parseInt($('input[name="current"]').val()),
            total = parseInt($('#load-more input[name="total"]').val()),
            _token = $('input[name="_token"]').val(),
            action = $('#load-more').attr('data-href');
            value = $('.list-per-page').find('.value').attr('data-value'); 
            var array_country_id = "",array_tourstyle_id = "", array_duration_id ="";
            $(".check_item.region input").each(function(){
                if($(this).is(":checked")){
                    if(array_country_id == ""){
                        array_country_id += $(this).val();
                    }else{
                        array_country_id += ","+$(this).val();
                    }
                }
            });
            $(".check_item.tour-style input").each(function(){
                if($(this).is(":checked")){
                    if(array_tourstyle_id == ""){
                        array_tourstyle_id += $(this).val();
                    }else{
                        array_tourstyle_id += ","+$(this).val();
                    }
                }
            });
            $(".check_item.duration input").each(function(){
                if($(this).is(":checked")){
                    if(array_duration_id == ""){
                        array_duration_id += $(this).val();
                    }else{
                        array_duration_id += ","+$(this).val();
                    }
                }
            });
            $('input[name="current"]').val(current+1);
            if (current < total) {
                current++;
                $.ajax({
                    type:'POST',            
                    url: action,
                    data:{
                        'current' : current,
                        'total' : total,
                        'value' : value,
                        'array_country_id' : array_country_id,
                        'array_tourstyle_id' : array_tourstyle_id,
                        'array_duration_id' : array_duration_id,
                        '_token': _token,
                    },
                    beforeSend: function( xhr ){
                        $('#loadMore').removeClass('hidden');
                        $('#overlay').show();
                        $('.loading').show();
                    },
                    success:function(data) {
                        $('#overlay').hide();
                        $('.loading').hide();
                        if (data.check != 0) {
                            $('.has-bg-unde .list-result .row').append(data.html);
                            $('.wrap-result').find('.seeing .number').text(data.all);
                            if (data.all >= total) 
                                $('#load-more').addClass('hidden');
                        }
                        else{
                           return false;
                        }
                    }
                });
            
            }
    });

    $('#content').on('click', '.wrap-result .popup-filter li',function(e){ 
        e.preventDefault();
        var value = $(this).attr('data-value'); 
        var text = $(this).text();
        var _token = $('input[name="_token"]').val(),
            total = parseInt($('#load-more input[name="total"]').val()),
            action = $(this).parents('.has-select').find('.value').attr('data-href');
        $(this).parents('.has-select').find('.value').attr('data-value', value);
        $(this).parents('.has-select').find('.value').text(text);
            var array_country_id = "",array_tourstyle_id = "", array_duration_id ="";
            $(".check_item.region input").each(function(){
                if($(this).is(":checked")){
                    if(array_country_id == ""){
                        array_country_id += $(this).val();
                    }else{
                        array_country_id += ","+$(this).val();
                    }
                }
            });
            $(".check_item.tour-style input").each(function(){
                if($(this).is(":checked")){
                    if(array_tourstyle_id == ""){
                        array_tourstyle_id += $(this).val();
                    }else{
                        array_tourstyle_id += ","+$(this).val();
                    }
                }
            });
            $(".check_item.duration input").each(function(){
                if($(this).is(":checked")){
                    if(array_duration_id == ""){
                        array_duration_id += $(this).val();
                    }else{
                        array_duration_id += ","+$(this).val();
                    }
                }
            });
            if (value) {
                $.ajax({
                    type:'POST',            
                    url: action,
                    data:{
                        'value' : value,
                        'total' : total,
                        'array_country_id' : array_country_id,
                        'array_tourstyle_id' : array_tourstyle_id,
                        'array_duration_id' : array_duration_id,
                        '_token': _token,
                    },
                    beforeSend: function( xhr ){
                        $('#overlay').show();
                        $('.loading').show();
                    },
                    success:function(data) {
                        if (data.check != 0) {
                            $('.has-bg-unde .list-result .row').html(data.html);
                            $('.wrap-result').find('.seeing .number').text(data.all);
                            $('#overlay').hide();
                            $('.loading').hide();
                            if (data.all >= total) 
                                $('#load-more').addClass('hidden');
                        }
                        else{
                           return false;
                        }
                    }
                });
            }
    });
    $('form.frm-market-nvp').on('submit', function(e){ 
        e.preventDefault();
        var base_url = window.location.origin;
        var action = $(this).attr('action'); 
        var slug_country = $(this).find('li.active input[name=destination_id]').val();
        var nationality = $(this).find('.nationality').attr('data-link'); 
        var _token = $('input[name="_token"]').val();
        window.location.href = base_url+'/'+slug_country+'-travel/'+nationality;
    });
    $('.gall_conte .desc').readmore({
        speed: 500,
        collapsedHeight: 315,
        heightMargin: 10,
        moreLink: '<a href="#" class="ctn-lm font-semibold">More</a>',
        lessLink: '<a href="#" class="ctn-lm font-semibold">Less</a>',
        embedCSS: true,
        blockCSS: 'display: block; width: 100%;',
        startOpen: false,
    });
    if($('.form form input.numberphone').length > 0) {
      var input = document.querySelector(".form form input.numberphone");
        window.intlTelInput(input, {
          separateDialCode: true,
        });
    } 
    $('body').on('click', '.check-req', function(){
        var count = 0;
        $(this).parents("#frm-tourType .custom-checkbox").find("input").each(function(){
            if($(this).is(":checked")){count++;}
        });
        if(count >= 3 && !$(this).hasClass('active')){
            return false;
        }
        if($(this).hasClass('active')){
            $(this).removeClass('active');
            $(this).find('input').attr('checked', false);
        }else{ 
            $(this).addClass('active');
            $(this).find('input').attr('checked', true);
        }
    });
    $('#frm-destination , #frm-about-us').on('click', '.open_orther', function(e){
        e.preventDefault();
        $(this).toggleClass('active');
        $(this).parents('#frm-destination').find('#frm-explainTrip').slideToggle();
        $(this).parents('#frm-about-us').find('#frm-specify').slideToggle();
    });
    
    $("#budgetPerson").on("keyup",function(){
        var value = $("#budgetPerson").val(),
            adult = parseInt($('select[name="numAdult"]').val()),
            teenager = parseInt($('select[name="numTeenager"]').val()),
            child = parseInt($('select[name="numChild"]').val()),
            baby = parseInt($('select[name="numBaby"]').val()),
            currency = $("#currencyPerson").val();
            total = (adult + child + teenager + baby)*value;
        $(this).parents('#frm-budgetPerson').find(".pink").text(currency+' '+addCommas(total));
    });
    $("#currencyPerson").on("change",function(){
        var value = $("#budgetPerson").val(),
            adult = parseInt($('select[name="numAdult"]').val()),
            teenager = parseInt($('select[name="numTeenager"]').val()),
            child = parseInt($('select[name="numChild"]').val()),
            baby = parseInt($('select[name="numBaby"]').val()),
            currency = $("#currencyPerson").val();
            total = (adult + child + teenager + baby)*value;
        $(this).parents('#frm-budgetPerson').find(".pink").text(currency+' '+addCommas(total));
    });
    function addCommas(nStr)
    {
        nStr += '';
        x = nStr.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }
        return x1 + x2;
    }
    $('input.onlynumber').keyup(function(event) {
        if(event.which >= 37 && event.which <= 40) return;
        $(this).val(function(index, value) {
             return value
             .replace(/\D/g, "");
        });
    });
    $("body").on("click",".upload-pictures",function(){
        $(".dz-hidden-input").trigger("click");
    });
    $('#frm-feedback-rpt').on('click', '.add-guide', function(e){
        e.preventDefault();
        var html = '';
        var number_item = $('#frm-feedback-rpt .guide-number').length + 1;
        html += '<div class="zxc guide-number">';
          html += '<hr class="hr-line">';
            html += '<div class="row">';
                html += '<div class="col-md-6 has-feedback guide-1">';
                    html += '<div id="frm-guide" class="form-group">';
                        html += '<input type="text" class="form-control" name="guide" id="guide" placeholder="Guide name*">';
                    html += '</div>';
                    html += '<div id="frm-places" class="form-group">';
                        html += '<input type="text" class="form-control" name="places" id="places" placeholder="Places to visit">';
                    html += '</div>';
                html += '</div>';
                html += '<div class="col-md-6 has-feedback date-1">';
                    html += '<div id="frm-GuideDate">';
                        html += '<div class="input-group date form-group">';
                            html += '<input type="text" class="form-control" name="fromGuideDate" id="fromGuideDate" placeholder="From" data-error="Not a valid arrival date!" required>';
                            html += '<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>';
                        html += '</div>';
                        html += '<div class="input-group date form-group">';
                            html += '<input type="text" class="form-control" name="toGuideDate" id="toGuideDate" placeholder="To" data-error="Not a valid arrival date!" required>';
                            html += '<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>';
                        html += '</div>';
                        html += '<div class="help-block with-errors"></div>';
                    html += '</div>';
                html += '</div>';
            html += '</div>';
            html += '<div class="row row-mobi">';
                html += '<div class="col-md-3 text-center raty-1">';
                    html += '<p>Language</p>';
                    html += '<div class="rate-cs" id="language'+ number_item +'" data-rate="3"></div>';
                html += '</div>';
                html += '<div class="col-md-3 text-center raty-2">';
                    html += '<p>Knowledge</p>';
                    html += '<div class="rate-cs" id="knowlg'+ number_item +'" data-rate="3"></div>';
                html += '</div>';
                html += '<div class="col-md-3 text-center raty-3">';
                    html += '<p>Explanation</p>';
                    html += '<div class="rate-cs" id="explanation'+ number_item +'" data-rate="3"></div>';
                html += '</div>';
                html += '<div class="col-md-3 text-center raty-4">';
                    html += '<p>Attitude</p>';
                    html += '<div class="rate-cs" id="attitude'+ number_item +'" data-rate="3"></div>';
                html += '</div>';
            html += '</div>';
        html += '</div>';
        $('#frm-feedback-rpt .sortable').append(html);
        $('input[name=score]').each(function(){
            $(this).attr("name", $(this).attr("id"));
        });
        $(".zxc .rate-cs").raty({
            half: true,
            start: parseFloat($('.rate-cs').attr('data-rate')),
            hintList: ['Poor', 'Average', 'Good', 'Very good', 'Excellent'],
            path: 'public/images',
            width: '100%',
            
        });
        $('.zxc #frm-GuideDate .input-group.date').datepicker({
            format: "DD, dd/mm/yyyy",
            startDate: new Date(),
            autoclose: true,
        });
        if( $('[name=fromPeriodDate]').val() != ""){
            $('.zxc #frm-GuideDate .input-group.date').datepicker('setStartDate',$('#fromPeriodDate').datepicker('getDate'));
            $('.zxc #frm-AccomDate .input-group.date').datepicker('setStartDate',$('#fromPeriodDate').datepicker('getDate'));
        }
        if( $('[name=toPeriodDate]').val() != ""){
            $('.zxc #frm-GuideDate .input-group.date').datepicker('setEndDate',$('#toPeriodDate').datepicker('getDate'));
            $('.zxc #frm-AccomDate .input-group.date').datepicker('setEndDate',$('#toPeriodDate').datepicker('getDate'));
        }
        $(".guide-number").removeClass("zxc");
    });
    $('#frm-hottel-rpt').on('click', '.add-hottel', function(e){
        e.preventDefault();
        var html = '';
        var number_item = $('#frm-hottel-rpt .hottel-number').length + 1;
        html += '<div class="zxc hottel-number">';
         html += '<hr class="hr-line">';
            html += '<div class="row">';
                html += '<div class="col-md-6 has-feedback accommos-1">';
                    html += '<div id="frm-accommos" class="form-group">';
                        html += '<input type="text" class="form-control" name="accommodation" id="accommodation" placeholder="Accommodation name">';
                    html += '</div>';
                    html += '<div id="frm-city" class="form-group">';
                        html += '<input type="text" class="form-control" name="city" id="city" placeholder="City">';
                    html += '</div>';
                html += '</div>';
                html += '<div class="col-md-6 has-feedback accomDate-1">';
                    html += '<div id="frm-AccomDate">';
                        html += '<div class="input-group date form-group">';
                            html += '<input type="text" class="form-control" name="fromAccomDate" id="fromAccomDate" placeholder="From" data-error="Not a valid arrival date!" required>';
                            html += '<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>';
                        html += '</div>';
                        html += '<div class="input-group date form-group">';
                            html += '<input type="text" class="form-control" name="toAccomDate" id="toAccomDate" placeholder="To" data-error="Not a valid arrival date!" required>';
                            html += '<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>';
                        html += '</div>';
                        html += '<div class="help-block with-errors"></div>';
                    html += '</div>';
                html += '</div>';
            html += '</div>';
            html += '<div class="row row-mobi">';
                html += '<div class="col-md-4 text-center review-1">';
                    html += '<p>Comfort</p>';
                    html += '<div class="rate-cs" id="comfort'+ number_item +'" data-rate="3"></div>';
                html += '</div>';
                html += '<div class="col-md-4 text-center review-2">';
                    html += '<p>Location</p>';
                    html += '<div class="rate-cs" id="location'+ number_item +'" data-rate="3"></div>';
                html += '</div>';
                html += '<div class="col-md-4 text-center review-3">';
                    html += '<p>Cleanliness</p>';
                    html += '<div class="rate-cs" id="cleanliness'+ number_item +'" data-rate="3"></div>';
                html += '</div>';
            html += '</div>';
            html += '<div class="row row-mobi">';
                html += '<div class="col-md-4 text-center review-4">';
                    html += '<p>Facilities</p>';
                    html += '<div class="rate-cs" id="facilities'+ number_item +'" data-rate="3"></div>';
                html += '</div>';
                html += '<div class="col-md-4 text-center review-5">';
                    html += '<p>Staffs</p>';
                    html += '<div class="rate-cs" id="staffs'+ number_item +'" data-rate="3"></div>';
                html += '</div>';
                html += '<div class="col-md-4 text-center review-6">';
                    html += '<p>Breakfast</p>';
                    html += '<div class="rate-cs" id="breakfast'+ number_item +'" data-rate="3"></div>';
                html += '</div>';
            html += '</div>';
        html += '</div>';
        $('#frm-hottel-rpt .sortable').append(html);
        $('input[name=score]').each(function(){
            $(this).attr("name", $(this).attr("id"));
        });
        $(".zxc .rate-cs").raty({
            half: true,
            start: parseFloat($('.rate-cs').attr('data-rate')),
            hintList: ['Poor', 'Average', 'Good', 'Very good', 'Excellent'],
            path: 'public/images',
            width: '100%',
           
        });
        $('.zxc #frm-AccomDate .input-group.date').datepicker({
            format: "DD, dd/mm/yyyy",
            startDate: new Date(),
            autoclose: true,
        });
        if( $('[name=fromPeriodDate]').val() != ""){
            $('.zxc #frm-AccomDate .input-group.date').datepicker('setStartDate',$('#fromPeriodDate').datepicker('getDate'));
        }
        if( $('[name=toPeriodDate]').val() != ""){
            $('.zxc #frm-AccomDate .input-group.date').datepicker('setEndDate',$('#toPeriodDate').datepicker('getDate'));
        }
        $(".hottel-number").removeClass("zxc");
    });
    $('input[name=score]').each(function(){
        $(this).attr("name", $(this).attr("id"));
    });
    if($('.rate-cs').length >0) {
        if($('.rate-cs.disabled').length >0) {
            $('.rate-cs').raty({
                readOnly: true,
                start: parseFloat($('.rate-cs').attr('data-rate')),
                half: true,
                hintList: ['Poor', 'Average', 'Good', 'Very good', 'Excellent'],
                path: 'public/images',
                width: '100%',
                score: function() {
                      return $(this).attr('data-rate');
                     }
            });
        }else{
            $('.rate-cs').raty({
                half: true,
                start: parseFloat($('.rate-cs').attr('data-rate')),
                hintList: ['Poor', 'Average', 'Good', 'Very good', 'Excellent'],
                path: 'public/images',
                width: '100%',
                
            });
        }
    };
    $('.search-tour .without').on('click', '.btn-search', function(e){
        e.preventDefault();
        $(this).siblings('.list-search').slideDown();
        $('.frm-search').hide();
        $('.list-search').before('<span class="open">Search With Code</span>');
        $(this).parent('.without').addClass('current');
        $(this).hide();

    });
    $('.search-tour .without').on('click', '.open', function(e){
        e.preventDefault();
        $(this).siblings('.list-search').slideUp();
        $('.frm-search').show();
        $(this).siblings('.btn-search').show();
        $(this).parent('.without').removeClass('current');
        $(this).remove();
       
    });
    $('.search-tour .frm-search').on('click','.btn-outline', function(e){
        e.preventDefault();
        $("#mySeachTour .error").remove();
        var link = $(this).parents('.frm-search').attr('action');
        var keyword = $(this).parents('.frm-search').find('input[name=keyword]').val();
        var _token = $(this).parents('.frm-search').find('input[name=_token]').val();
        $.ajax({
            type:'POST',            
            url: link,
            cache: false,
            data:{
                '_token' : _token,
                'keyword': keyword
            },
            
        }).done(function(data) {
            if(data.msg == 'success'){
                window.location.href = data.link;
            }else{
                $(".search-modal .search-tour").before('<div class="error">'+data.html+'</div>');
                $(".search-modal .modal-title").remove();
            }
        });
    });

    $('#frm-search-tour input[type="submit"]').on('click', function(e){ 
        e.preventDefault();
        var link = $(this).parents('#frm-search-tour').attr('action');
        var duration_id = $(this).parents('#frm-search-tour').find('li.active input[name="duration_id"]').length > 0 ? $(this).parents('#frm-search-tour').find('li.active input[name="duration_id"]').val() : '';
        var array_destinationID = "",
            array_catID = "";
            $(".region input").each(function(){
                if($(this).is(":checked")){
                    if(array_destinationID == ""){
                        array_destinationID += $(this).val();
                    }else{
                        array_destinationID += ","+$(this).val();
                        console.log(array_destinationID);
                    }
                }
            });
            $(".tour-style input").each(function(){
                if($(this).is(":checked")){
                    if(array_catID == ""){
                        array_catID += $(this).val();
                    }else{
                        array_catID += ","+$(this).val();
                    }
                }
            });
        window.location.href = link + '?destination_id='+array_destinationID+'&cat_id='+array_catID+'&duration_id='+duration_id; 
    });
    $('#frm-search-country input[type="submit"]').on('click', function(e){ 
        e.preventDefault();
        var link = $(this).parents('#frm-search-country').attr('action');
        var duration_id = $(this).parents('#frm-search-country').find('li.active input[name="duration_id"]').length > 0 ? $(this).parents('#frm-search-country').find('li.active input[name="duration_id"]').val() : '';
        var array_destinationID = "",
            array_catID = "";
            $(".region input").each(function(){
                if($(this).is(":checked")){
                    if(array_destinationID == ""){
                        array_destinationID += $(this).val();
                    }else{
                        array_destinationID += ","+$(this).val();
                        console.log(array_destinationID);
                    }
                }
            });
            $(".tour-style input").each(function(){
                if($(this).is(":checked")){
                    if(array_catID == ""){
                        array_catID += $(this).val();
                    }else{
                        array_catID += ","+$(this).val();
                    }
                }
            });
        window.location.href = link + '?child_cou='+array_destinationID+'&cat_id='+array_catID+'&duration_id='+duration_id; 
    });
    ///////////////////////////////////////////////////////////////////////////////////////////
    if($('.journey .list-style, .responsible_travel .list-respon, .home .preparing .list-guide , .plans-travels .list-travel-nvp, .blog_nvp_js .item').length > 0 && $( window ).width() <= 1024) {
         $(".list-style .wrapper-item .item, .list-respon .wrapper-item .item, .list-guide .wrapper-item .item,  .plans-travels .list-travel-nvp .item, .blog_nvp_js .item").on('click',function(e){
            e.preventDefault();
            var remove = $(this).find(".cross");
            // if the target of the click isn't the remove nor a descendant of the remove
            if (!remove.is(e.target) && remove.has(e.target).length === 0) 
            {
                $(this).addClass('current');
            }else{
                $(this).removeClass('current');
            }
        });
       
     }
    /////////////////////////////////////////////////////////////////////////////////////////////
    $(".plus-desc").on("click",function(e){
        e.preventDefault();
        var key = $(this).find('.pluss').attr("data-key");
        $('.attraction').slideUp();
        $('.desc-style').slideDown();
        $(".desc-style").find('.cross-mobi').not($('.cross__'+key)).addClass('hidden');
        $(".desc-style").find('.cross-mobi.cross__'+key).removeClass('hidden');
        $(".desc-style").find('.desc_vp').not($('.desc__'+key)).addClass('hidden');
        $(".desc-style").find('.desc_vp.desc__'+key).removeClass('hidden');
        $(".desc-style").find('.button-mobile').not($('.button__'+key)).addClass('hidden');
        $(".desc-style").find('.button-mobile.button__'+key).removeClass('hidden');
    })
    $(".cross-mobi").on("click",function(e){
        e.preventDefault();
        $('.desc-style').slideUp();
        $('.attraction').slideDown();
    });
    $(".cross-gallery").on("click",function(e){
        e.preventDefault();
        $('.gallery-style-mobi').slideUp();
        $('.desc-style').slideDown();
    });
    $(".btn-gallery-mobi").on("click",function(e){
        e.preventDefault();
        var key = $(this).attr("href-key");
        $('.desc-style').slideUp();
        $('.gallery-style-mobi').slideDown();
        $(".gallery-style-mobi").find('.list_st_mobi').not($('.gallery__'+key)).addClass('hidden');
        $(".gallery-style-mobi").find('.list_st_mobi.gallery__'+key).removeClass('hidden');
        setTimeout(function(){
            $(".gallery-style-mobi").find('.list_st_mobi').trigger('destroy.owl.carousel').removeClass('owl-carousel owl-loaded');
            $('.gallery-style-mobi .list_st_mobi').find('.owl-stage-outer').children().unwrap();
            $(".gallery-style-mobi").find('.list_st_mobi.gallery__'+key).owlCarousel({
                items:1,
                loop:false,
                margin:30,
                autoplay:false,
                nav:false,
                dots: true,
                lazyLoad:true,
                navRewind: false,
                navText:['<i class="fa fa-angle-left" aria-hidden="true"></i>','<i class="fa fa-angle-right" aria-hidden="true"></i>'],
            });
        },200);
    });
    if($('.tour-body').length>0 && $( window ).width() <= 1024){
        var menuSwiper = new Swiper('.menu-slider', {
            slidesPerView: 'auto',
            centeredSlides: false,
            spaceBetween: 0,
            grabCursor: true,
            initialSlide: 0,
        });

        if($('.single-tour .menu-slider').length>0 && $( window ).width() <= 1024){
            $('.single-tour .menu-slider .swiper-slide span').off().click(function() {
                var id = '.single-sec.' + $(this).data('scroll');
                var index = $(this).parent().index();
                var top = $(id).children('.title-sec').offset().top - 150;
                $('.menu-slider .swiper-slide').removeClass('active');
                $(this).parent().addClass('active');
                $('html, body').animate({
                    scrollTop: top
                }, 200);
                menuSwiper.slideTo(index);
            })
        }
        var ScrollTop = 0;
        scrollMenu();
        var tourContent = [];

        function scrollMenu() {
            $(window).on('scroll', function() {
                var st = $(this).scrollTop();
                if($('.tour-body').length > 0){
                    var menuTop = $('.tour-body').offset().top;
                    var distance_arrow = $('.back-to-start').offset().top;      
                        if (st > ScrollTop) {
                            if (st > (menuTop + 20)) {
                                $('.tour-body .menu-content').addClass('ui-header-fixed').attr('data-position', 'fixed');
                            }
                        }
                        if (st > (distance_arrow) || st < (menuTop + 20) ) {
                            $('.tour-body .menu-content').removeClass('ui-header-fixed').attr('data-position', '');
                        }
                    $('.tour-body .single-sec').each(function() {
                        tourContent[$('.tour-body .single-sec').index(this)] = $(this).children('.title-sec').offset().top - 160;
                    })
                    if (st < tourContent[1]) {
                        menuSwiper.slideTo(0);
                        $('.tour-body .menu-slider .swiper-slide').removeClass('active');
                        $('.tour-body .menu-slider .swiper-slide:eq(0)').addClass('active');
                    } else if (st >= tourContent[1] && st < tourContent[2]) {
                        menuSwiper.slideTo(1);
                        $('.tour-body .menu-slider .swiper-slide').removeClass('active');
                        $('.tour-body .menu-slider .swiper-slide:eq(1)').addClass('active');
                    } else if (st >= tourContent[2] && st < tourContent[3]) {
                        menuSwiper.slideTo(2);
                        $('.tour-body .menu-slider .swiper-slide').removeClass('active');
                        $('.tour-body .menu-slider .swiper-slide:eq(2)').addClass('active');
                    }else if (st > tourContent[3]) {
                        menuSwiper.slideTo(3);
                        $('.tour-body .menu-slider .swiper-slide').removeClass('active');
                        $('.tour-body .menu-slider .swiper-slide:eq(3)').addClass('active');
                    }
                    
                }
                ScrollTop = st;
            });
        }
    }
    if($('.sec-detail-tour').length>0 && $( window ).width() <= 1024){
        $(".estimation").on("click",function(e){
            e.preventDefault();
            $('.price_estimation').slideDown();
        });
        $(".closes").on("click",function(e){
            e.preventDefault();
            $('.price_estimation').slideUp();
        });
    }
    if($('#detail-tour .plus-detail-tour').length > 0 && $( window ).width() <= 1024){            
        var distance_arrow = $('.back-to-start').offset().top;             
        $(window).scroll(function(){
            distance_arrow = $('.back-to-start').offset().top; 
            var height_window = $(window).scrollTop();
            var item_h = $(".back-top").offset().top;
            if((height_window > item_h ) && (height_window < (distance_arrow - 200))){
                $('.plus-detail-tour').addClass('current');  
            } 
            else{
                $('.plus-detail-tour').removeClass('current');
            }
        });
        $('.plus-detail-tour').on('click', '.plus-open', function(e){
            e.preventDefault();
            $(this).parent().hide();
            $(this).parents('.plus-detail-tour').find('.list-brief').slideDown();
            $(this).parents('.plus-detail-tour').find('.closes').show();
        });
        $('.plus-detail-tour').on('click', '.closes', function(e){
            e.preventDefault();
            $(this).hide();
            $(this).parents('.list-brief').slideUp();
            $(this).parents('.plus-detail-tour').find('.transparent-open').show();
        });
        $('.list-brief').on('click', '.item', function(e){
            e.preventDefault();
            $(this).parents('.list-brief').slideUp();
            $(this).parents('.plus-detail-tour').find('.transparent-open').show();
        });
    }
    
    $(".plus-duration").on("click",function(e){
        e.preventDefault();
        var key = $(this).find('.pluss').attr("data-key");
        $('.duration_nvp').slideUp();
        $('.desc-style').slideDown();
        $(".desc-style").find('.cross-mobi').not($('.cross__'+key)).addClass('hidden');
        $(".desc-style").find('.cross-mobi.cross__'+key).removeClass('hidden');
        $(".desc-style").find('.desc_vp').not($('.desc__'+key)).addClass('hidden');
        $(".desc-style").find('.desc_vp.desc__'+key).removeClass('hidden');
        $(".desc-style").find('.button-mobile').not($('.button__'+key)).addClass('hidden');
        $(".desc-style").find('.button-mobile.button__'+key).removeClass('hidden');
    })
    $(".cross-mobi").on("click",function(e){
        e.preventDefault();
        $('.desc-style').slideUp();
        $('.duration_nvp').slideDown();
    });
    $(".cross-gallery").on("click",function(e){
        e.preventDefault();
        $('.map-duration-mobi').slideUp();
        $('.desc-style').slideDown();
    });
    $(".btn-map-mobi").on("click",function(e){
        e.preventDefault();
        var key = $(this).attr("href-key");
        $('.desc-style').slideUp();
        $('.map-duration-mobi').slideDown();
        $(".map-duration-mobi").find('.list_map').not($('.map__'+key)).addClass('hidden');
        $(".map-duration-mobi").find('.list_map.map__'+key).removeClass('hidden');
    });
    $(".tour-mobile").on("click",'.filter-sec',function(e){
        e.preventDefault();
        $('.gr-filter').slideToggle();
    });
/*-------------------------------------- detail guide ------------------------------------------------*/
    $(".list-orther").on("click",'.open-orther',function(e){
        e.preventDefault();
        $(this).toggleClass('active');
        $('.other-mobi').slideToggle();
    });
    $(document).mouseup(function(e) {
        var container = $(".list-orther");
        if (!container.is(e.target) && container.has(e.target).length === 0 && $(".other-mobi").is(":visible")) 
        {    
            $(".list-orther .open-orther").removeClass("active")
            $(".list-orther .other-mobi").hide();
        }
    });
    if($('.guide-mobi .plus-table-guide').length > 0 && $( window ).width() <= 1024){            
        var distance_arrow = $('.back-to-start').offset().top;             
        $(window).scroll(function(){
            distance_arrow = $('.back-to-start').offset().top; 
            var height_window = $(window).scrollTop();
            var item_h = $(".list-tb-content").offset().top - 100;
            if((height_window > item_h ) && (height_window < (distance_arrow - 200))){
                $('.plus-table-guide').addClass('current'); 
                if($('.plus-table-guide').hasClass('current')){
                    //scroll to in scrollbar
                    var h_scrollTo = 0; 
                    var index = $('.table-body li a.active').closest('li').index() + 1;
                    $('.table-body li a').each(function(){ 
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
                $('.plus-table-guide').removeClass('current');
            }
        });
        $('.plus-table-guide').on('click', '.plus-open', function(e){
            e.preventDefault();
            $(this).parent().hide();
            $(this).parents('.plus-table-guide').find('.list-guide-mobi').slideDown();
            $(this).parents('.plus-table-guide').find('.closes').show();
        });
        $('.plus-table-guide').on('click', '.closes', function(e){
            e.preventDefault();
            $(this).hide();
            $(this).parents('.list-guide-mobi').slideUp();
            $(this).parents('.plus-table-guide').find('.transparent-open').show();
        });
        $('.list-guide-mobi').on('click', 'li', function(e){
            e.preventDefault();
            $(this).parents('.list-guide-mobi').slideUp();
            $(this).parents('.plus-table-guide').find('.transparent-open').show();
        });
    }

    if($('#blog-detail .plus-table-guide').length > 0 && $( window ).width() <= 1024){            
        var distance_arrow = $('.back-to-start').offset().top;             
        $(window).scroll(function(){
            distance_arrow = $('.back-to-start').offset().top; 
            var height_window = $(window).scrollTop();
            var item_h = $(".list-tb-content").offset().top - 100;
            if((height_window > item_h ) && (height_window < (distance_arrow - 250))){
                $('.plus-table-guide').addClass('current'); 
                if($('.plus-table-guide').hasClass('current')){
                    //scroll to in scrollbar
                    var h_scrollTo = 0; 
                    var index = $('.table-body li a.active').closest('li').index() + 1;
                    $('.table-body li a').each(function(){ 
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
                $('.plus-table-guide').removeClass('current');
            }
        });
        $('.plus-table-guide').on('click', '.plus-open', function(e){
            e.preventDefault();
            $(this).hide();
            $(this).siblings('.table_related').slideDown();
            $(this).parent().addClass('open');
        });
        $('.plus-table-guide').on('click', '.table_related .closes', function(e){
            e.preventDefault();
            $(this).parent().hide();
            $(this).parents('.transparent-open').find('.plus-open').show();
            $(this).parents('.transparent-open').removeClass('open');
        });
        $('.plus-table-guide').on('click', '.table_related .table_open', function(e){
            e.preventDefault();
            $(this).parent().hide();
            $(this).parents('.plus-table-guide').find('.table-blog-mobi').slideDown();
            $(this).parents('.plus-table-guide').find('.table-blog-mobi .close_tab').show();
        });
        $('.plus-table-guide').on('click', '.table_related .related_post', function(e){
            e.preventDefault();
            $(this).parent().hide();
            $(this).parents('.plus-table-guide').find('.related-mobi').slideDown();
            $(this).parents('.plus-table-guide').find('.related-mobi .close_tab').show();
        });
        $('.plus-table-guide').on('click', '.close_tab', function(e){
            e.preventDefault();
            $(this).parent().hide();
            $(this).parents('.plus-table-guide').find('.table_related').slideDown();
        });
        $('.table-blog-mobi').on('click', 'li', function(e){
            e.preventDefault();
            $(this).parents('.table-blog-mobi').find('.close_tab').hide();
            $(this).parents('.table-blog-mobi').slideUp();
            $(this).parents('.plus-table-guide').find('.table_related').slideDown();
        });
    }
})