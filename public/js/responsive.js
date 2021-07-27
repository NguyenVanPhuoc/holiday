$(document).ready(function(){
	$("header").on('click', '#mobi-nav-icon', function(){
		$(".overlay").toggle(0);
		$("#mobi-nav").toggleClass("active");
	});
	
	$("body").on('click', '.overlay', function(){		
		$("#mobi-nav").toggleClass("active");
		$(this).hide();
	});
	$("#menu-mobi").find(".has-children").prepend('<i class="fa fa-chevron-down submenu-button" aria-hidden="true"></i>');
    $("#menu-mobi").find(".submenu-button").on('click', function() {
        $(this).toggleClass('submenu-opened');
        if ($(this).siblings('ul').hasClass('open')) {
            $(this).siblings('ul').removeClass('open');
        }
        else {
            $(this).siblings('ul').addClass('open');
        }
        $(this).siblings('ul').slideToggle();
    });
});