$(document ).ready(function(){
    /*
    * Home slide
    */
    if($('#home-slide').length){
        $('#home-slide .wrap-slide').owlCarousel({
            items:1,
            loop:true,
            autoplay:true,
            autoplayHoverPause:true,
            dotsContainer: '#carousel-custom-dots'
        });
        $('.owl-dot').click(function () { console.log('sdsda');
            $('#home-slide .wrap-slide').trigger('to.owl.carousel', [$(this).index(), 300]);
        });
    }

    //slide style (3 item)
    $('.slide-style').owlCarousel({
        items:3,
        loop:false,
        margin:20,
        autoplay:false,
        nav:true,
        dots: true,
        navRewind: false,
        navText:['<i class="fa fa-angle-left" aria-hidden="true"></i>','<i class="fa fa-angle-right" aria-hidden="true"></i>'],
        autoplayTimeout:1000,
        autoplayHoverPause:true,
        responsive : {
            0:{
                margin:20,
                items:0
            },
            320:{
                stagePadding: 30,
                margin:20,
                nav:false,
                items:1
            },
            568:{
                nav:false,
                margin:20,
                items:1

            },
            601:{
                nav:false,
                margin:20,
                items:2
            },  
            1025:{
                items:3
            },         
        }
    });
    $('.slide-dost').owlCarousel({
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
                margin:15,
                nav:false,
                items:1
            },
            375:{
                loop:true,
                stagePadding: 35,
                margin:15,
                nav:false,
                items:1
            },
            414:{
                loop:true,
                stagePadding: 40,
                margin:15,
                nav:false,
                items:1
            },
            480:{
                loop:true,
                stagePadding: 60,
                margin:20,
                nav:false,
                items:1
            },
            568:{
                loop:true,
                stagePadding: 70,
                margin:20,
                nav:false,
                items:1
            },
            601:{
                margin:20,
                nav:false,
                items:2
            },  
            1024:{
                margin:20,
                nav:false,
                items:3
            },         
        }
    });
    $('.slide-tour-dost').owlCarousel({
        items:3,
        loop:false,
        margin:20,
        autoplay:false,
        nav:true,
        dots: true,
        navRewind: false,
        navText:['<i class="fa fa-angle-left" aria-hidden="true"></i>','<i class="fa fa-angle-right" aria-hidden="true"></i>'],
        autoplayTimeout:1000,
        autoplayHoverPause:true,
        responsive : {
            320:{
                nav:false,
                margin:20,
                nav:false,
                items:1
            },
            568:{
                nav:false,
                margin:20,
                items:1
            },
            601:{
                nav:false,
                margin:20,
                items:2
            },  
            1024:{
                nav:false,
                margin:20,
                items:3
            },         
        }
    });
    $('.slide-dost-duration').owlCarousel({
        items:3,
        loop:false,
        margin:20,
        autoplay:false,
        nav:true,
        dots: true,
        navRewind: false,
        navText:['<i class="fa fa-angle-left" aria-hidden="true"></i>','<i class="fa fa-angle-right" aria-hidden="true"></i>'],
        autoplayTimeout:1000,
        autoplayHoverPause:true,
        responsive : {
            320:{
                nav:false,
                margin:10,
                items:1
            },
            375:{
                nav:false,
                margin:10,
                items:2
            },
            1024:{
                nav:false,
                margin:20,
                items:3
            },         
        }
    });

    $('.slide-two-item').owlCarousel({
        items:2,
        loop:true,
        margin:60,
        autoplay:false,
        nav:true,
        dots: false,
        navText:['<i class="gray fa fa-caret-left" aria-hidden="true"></i>','<i class="gray fa fa-caret-right" aria-hidden="true"></i>'],
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
                items:2
            },         
        }
    });

    $('.slide-one-item').owlCarousel({
        items:1,
        loop:false,
        margin:60,
        autoplay:false,
        nav:true,
        dots: false,
        navText:['<i class="fa fa-angle-left" aria-hidden="true"></i>','<i class="fa fa-angle-right" aria-hidden="true"></i>'],
        autoplayTimeout:1000,
        autoplayHoverPause:true,
    });

    //list related
    $('.list-related').owlCarousel({
        items:3,
        loop:true,
        margin:30,
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

    //slide gallery schedule tour
    /*$('.gallery-schedule').owlCarousel({
        items:1,
        loop:false,
        margin:30,
        autoplay:false,
        nav:true,
        dots: false,
        navText:['<i class="fa fa-caret-left" aria-hidden="true"></i>','<i class="fa fa-caret-right" aria-hidden="true"></i>'],
        autoplayTimeout:1000,
        autoplayHoverPause:true
    });
*/
    //consultants slide
    $('.slide-consultants').owlCarousel({
        items:1,
        loop:true,
        margin:30,
        autoplay: true,
        nav:false,
        dots: false,
        navText:['<i class="fa fa-caret-left" aria-hidden="true"></i>','<i class="fa fa-caret-right" aria-hidden="true"></i>'],
        autoplayTimeout:3000,
        autoplayHoverPause:true
    });

    $('#home-slide .list').owlCarousel({
        items:1,
        loop:true,
        margin:0,
        autoplay:true,
        nav:false, 
        autoplayTimeout:2000,
        autoplayHoverPause:true,
        responsive : {
            0:{
                items:1
            },
            320:{
                items:1
            },
            414:{
                items:1
            },
            480:{
                items:1
            },
            568:{
                items:1
            },
            667:{
                items:1
            },
            736:{
                items:1
            },
            768:{
                items:1
            }, 
            1920:{
                item:1
            }
        }
	});

	//home news vip    
    $('#sec-news-vip .list').owlCarousel({
        items:3,
        loop:true,
        margin:100,
        autoplay:true,
        nav:true,
        navText:['<i class="fa fa-chevron-left" aria-hidden="true"></i>','<i class="fa fa-chevron-right" aria-hidden="true"></i>'],
        autoplayTimeout:2000,
        autoplayHoverPause:true,
        responsive : {
            0:{
                items:1
            },
            320:{
                items:1
            },
            480:{
                items:2,
                margin:20,
            },
            1024:{
                items:3,
                margin:30,

            }, 
            1920:{
                item:3
            }
        } 
	});
    $('#news-vip .list').owlCarousel({
        items:5,
        loop:true,
        margin:15,
        autoplay:false,
        nav:true,
        navText:['<i class="fa fa-chevron-left" aria-hidden="true"></i>','<i class="fa fa-chevron-right" aria-hidden="true"></i>'],
        autoplayTimeout:2000,
        autoplayHoverPause:true,
        lazyLoad:true,
        slideBy:5,
        lazyLoadEager:5,
        responsive : {
            0:{
                items:1
            },
            320:{
                items:2
            },
            480:{
                items:3,
                margin:20,
            },
            1024:{
                items:4,
                margin:30,

            }, 
            1920:{
                item:5
            }
        } 
    });
    //banner blog
    $('#blog-slide .list').owlCarousel({
        items:1,
        loop:true,
        margin:0,
        autoplay:true,
        nav:true, 
        autoplayTimeout:2000,
        autoplayHoverPause:true,
        navText:["<div class='arrow arrow-left'></div>","<div class='arrow arrow-right'></div>"],
        responsive : {
            0:{
                items:1
            },
            320:{
                items:1
            },
            414:{
                items:1
            },
            480:{
                items:1
            },
            568:{
                items:1
            },
            667:{
                items:1
            },
            736:{
                items:1
            },
            768:{
                items:1
            }, 
            1920:{
                item:1
            }
        }
	});

    //our destination blog
    $('.our-destinations .list-country').owlCarousel({
        items:3,
        loop:false,
        margin:20,
        navRewind: false,
        nav:true, 
        navText:["<i class='fa fa-angle-left' aria-hidden='true'></i>","<i class='fa fa-angle-right' aria-hidden='true'></i>"],
        responsive : {
            0:{
                items:1,
            },
            414:{
                items:2,
            },
            667:{
                items:3,
            },
            
        }
    });

    //plans-travel blog
    $('.plans-travel .list-styles-tour').owlCarousel({
        items:3,
        loop:false,
        margin:20,
        navRewind: false,
        nav:true, 
        navText:["<i class='fa fa-angle-left' aria-hidden='true'></i>","<i class='fa fa-angle-right' aria-hidden='true'></i>"],
        responsive : {
            0:{
                items:1,
            },
            414:{
                items:2,
            },
            667:{
                items:3,
            },
            
        }
    });

    //plans time blog
    $('.blog .plans-time .list-durations').owlCarousel({
        items:3,
        loop:false,
        margin:20,
        nav:true, 
        navRewind: false,
        navText:["<i class='fa fa-angle-left' aria-hidden='true'></i>","<i class='fa fa-angle-right' aria-hidden='true'></i>"],
        responsive : {
            0:{
                items:1,
            },
            414:{
                items:2,
            },
            667:{
                items:3,
            },
            
        }
    });

    //places to visit country blog
    $('.blog_nvp .places-visit-country .list-places').owlCarousel({
        items:3,
        loop:false,
        margin:20,
        nav:true, 
        navRewind: false,
        navText:["<i class='fa fa-angle-left' aria-hidden='true'></i>","<i class='fa fa-angle-right' aria-hidden='true'></i>"],
        responsive : {
            0:{
                items:1,
            },
            414:{
                items:2,
            },
            667:{
                items:3,
            },
            
        }
    });
    
    //TRAVEL TIPS & GUIDE country blog
    $('#country-blog .list-guide').owlCarousel({
        items:3,
        loop:false,
        margin:20,
        nav:true, 
        navRewind: false,
        navText:["<i class='fa fa-angle-left' aria-hidden='true'></i>","<i class='fa fa-angle-right' aria-hidden='true'></i>"],
        responsive : {
            0:{
                items:1,
            },
            414:{
                items:2,
            },
            667:{
                items:3,
            },
            
        }
    });
     ///////////////////////////////////////////////////////////////////////////////////////////
    if($('#about .responsible .list-respon').length > 0 && $( window ).width() <= 768) {
         $(".list-respon .wrapper-item .item").on('click',function(e){
            e.preventDefault();
            var remove = $(this).find(".remove");
            // if the target of the click isn't the remove nor a descendant of the remove
            if (!remove.is(e.target) && remove.has(e.target).length === 0) 
            {
                $(this).addClass('current');
            }else{
                $(this).removeClass('current');
            }
        });
     }
     $('header .sub-menu .list-country').owlCarousel({
        items:3,
        loop:false,
        margin:20,
        autoplay:false,
        nav:true,
        dots: false,
        lazyLoad:true,
        navRewind: false,
        navText:['<i class="fa fa-angle-left" aria-hidden="true"></i>','<i class="fa fa-angle-right" aria-hidden="true"></i>'],
    });
    if($('.page .environment .list-environment').length > 0 && $( window ).width() <= 768) {
          $('.page .environment .list-environment').owlCarousel({
            items:2,
            loop:false,
            margin:20,
            autoplay:false,
            nav:false,
            dots: true,
            navText:['<i class="gray fa fa-caret-left" aria-hidden="true"></i>','<i class="gray fa fa-caret-right" aria-hidden="true"></i>'],
            autoplayTimeout:1000,
            autoplayHoverPause:true,
            responsive : {
                320:{
                    items:1
                },
                600:{
                    items:2
                },  
            }
        });
     }
     if($('.page .responsible .list-respon').length > 0 && $( window ).width() <= 768) {
          $('.page .responsible .list-respon').owlCarousel({
            items:2,
            loop:false,
            margin:20,
            autoplay:false,
            nav:false,
            dots: false,
            responsive : {
                320:{
                    stagePadding: 30,
                    items:1
                },
                480:{
                    stagePadding: 50,
                    items:1
                },
                736:{
                    items:2
                },  
            }
        });
     }
    if($('.page .review .list_review').length > 0 && $( window ).width() <= 768) {
          $('.page .review .list_review').owlCarousel({
            items:2,
            loop:false,
            margin:20,
            autoplay:false,
            nav:false,
            dots: false,
            responsive : {
                320:{
                    stagePadding: 30,
                    items:1
                },
                480:{
                    stagePadding: 50,
                    items:1
                },
                736:{
                    items:2
                },  
            }
        });
    }
    if($('.blog_articles .list-blog .wrap').length > 0 && $( window ).width() <= 768) {
          $('.blog_articles .list-blog .wrap').owlCarousel({
            items:2,
            loop:false,
            margin:20,
            autoplay:false,
            nav:false,
            dots: true,
            responsive : {
                320:{
                    items:1
                },
                568:{
                    items:1
                },
                736:{
                    items:2
                },  
            }
        });
    }
    if($('.content_biig .list-steps').length > 0 && $( window ).width() <= 768) {
          $('.content_biig .list-steps').owlCarousel({
            items:2,
            loop:false,
            margin:20,
            autoplay:false,
            nav:false,
            dots: true,
            responsive : {
                320:{
                    items:1
                },
                568:{
                    items:1
                },
                736:{
                    items:2
                },  
            }
        });
    }
    $('.list_gallery').owlCarousel({
        items:1,
        loop:true,
        margin:30,
        autoplay:false,
        nav:true,
        dots: false,
        lazyLoad:true,
        navRewind: false,
        navText:['<i class="fa fa-angle-left" aria-hidden="true"></i>','<i class="fa fa-angle-right" aria-hidden="true"></i>'],
        responsive : {
            320:{
                dots: true,
                items:1,
                nav:false
            }, 
            768:{
                items:1
            },  
        }
    });
    $('.list_st').owlCarousel({
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
    $('.single-sec-tour .gallery-schedule').owlCarousel({
        items:1,
        loop:true,
        margin:30,
        autoplay:false,
        nav:true,
        dots: false,
        lazyLoad:true,
        navRewind: false,
        navText:['<i class="fa fa-angle-left" aria-hidden="true"></i>','<i class="fa fa-angle-right" aria-hidden="true"></i>'],
        responsive : {
            320:{
                nav:false,
                dots: true,
            },
            1024:{
                nav:true,
                dots: false,
            }, 
        }
    });
    
});