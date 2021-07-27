<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="google-site-verification" content="nue2yPo8zEhxFTqyvWcherHQKvZKV0hwAS04gkFBN2g" />
    <meta name="robots" content="noindex" /> <!-- prevent google bot -->
    <title>@yield('title')</title>
    <meta http-equiv="Content-Language" content="vn"/>
    <meta name="description" content="@yield('description')"/>
    <meta name="keywords" content="@yield('keywords')"/><link rel="canonical" href="{{ URL::current() }}">

    <!-- Google / Search Engine Tags -->
    <meta itemprop="name" content="@yield('title')">
    <meta itemprop="description" content="@yield('description')">
    <meta itemprop="image" content="@yield('image_url')">

    <!-- Facebook Meta Tags -->
    <meta property="og:url" content="{{ URL::current() }}">
    <meta property="og:type" content="website">
    <meta property="og:title" content="@yield('title')">
    <meta property="og:description" content="@yield('description')">
    <meta property="og:image" content="@yield('image_url')">

    <!-- Twitter Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title')">
    <meta name="twitter:description" content="@yield('description')">
    <meta name="twitter:image" content="@yield('image_url')">
    
    <!-- Fonts -->                
    <link rel="shortcut icon" href="{{favicon()}}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    
    <link rel="stylesheet" href="{{asset('public/css/checkbox_radio.css')}}">          
    <link rel="stylesheet" href="{{asset('public/css/all.min.css')}}">          
    <link rel="stylesheet" href="{{asset('public/css/font-awesome.min.css')}}">          
    <link rel="stylesheet" href="{{asset('public/css/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{asset('public/css/pnotify.custom.min.css')}}">    
    <link rel="stylesheet" href="{{asset('public/css/jquery.datetimepicker.css')}}">  
    <link rel="stylesheet" href="{{asset('public/css/bootstrap-datetimepicker.min.css')}}">  
    <link rel="stylesheet" href="{{asset('public/css/select2.min.css')}}">  
    <link href="{{asset('public/css/scrollbar.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('public/style.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('public/css/plus.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('public/css/plus1.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('public/css/main.css')}}" rel="stylesheet" type="text/css">  
    <link href="{{asset('public/css/blog.css')}}" rel="stylesheet" type="text/css">  
    <script src="{{asset('public/js/jquery.min.js')}}" type="text/javascript"></script>    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jscroll/2.3.7/jquery.jscroll.js"></script>    
    <script src="{{asset('public/js/pnotify.custom.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('public/admin/js/popper.min.js')}}" type="text/javascript"></script>   
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="{{asset('public/js/jquery.datetimepicker.full.js')}}" type="text/javascript"></script> 
    <script src="{{asset('public/js/bootstrap-datepicker.js')}}" type="text/javascript"></script> 
    <script src="{{asset('public/js/jquery.scrollbar.js')}}" type="text/javascript"></script> 
    <script src="{{asset('public/js/select2.min.js')}}" type="text/javascript"></script> 
    <script src="{{asset('public/js/owl.carousel.min.js')}}" type="text/javascript"></script> 
    <script src="{{asset('public/js/validator.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('public/js/readmore.js')}}" type="text/javascript"></script> 
    <script src="{{asset('public/js/html5lightbox.js')}}" type="text/javascript"></script> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.lazyload/1.9.1/jquery.lazyload.min.js"></script>   
    <script src="{{asset('public/js/main.js')}}" type="text/javascript"></script>   
    <script src="{{asset('public/js/blog.js')}}" type="text/javascript"></script>   
    <script src="{{asset('public/js/plus.js')}}" type="text/javascript"></script> 
    <script src="{{asset('public/js/plus1.js')}}" type="text/javascript"></script>   
    <script src="{{asset('public/js/sliders.js')}}" type="text/javascript"></script>     
    <script src="{{asset('public/js/profile.js')}}" type="text/javascript"></script>   
    <script>
        var themeUrl = '<link href="{{ asset('public/css/plus1.css') }}" rel="stylesheet" type="text/css" crossorigin="anonymous">';
    </script>   
    @handheld
    <link rel="stylesheet" href="{{asset('public/css/responsive.css')}}">
    <script src="{{asset('public/js/responsive.js')}}" type="text/javascript"></script>
    @endhandheld

</head>
<body>
    <div id="fb-root"></div>
    <script>(function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = 'https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.0&appId=1849189082054776&autoLogAppEvents=1';
      fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));</script>
  <div id="wrapper" class="page-blog">
    <?php 
        $destinations = getListMainCountry();
        $categories = get_categories();
     ?>
    <div class="box-page">
        <div class="container">
            <header class="header-blog"> 
                @desktop
                <div class="menu-top">
                    <div class="top">
                        <a href="{{route('blog')}}"><img src="{{asset('public/images/Logo_sonasia_blog.png')}}" alt=""></a>
                        <a href="{{route('home')}}" class="link_home"><img src="{{asset('public/images/Bee color small.png')}}" alt=""></a>
                        <a href="#" class="search" data-toggle="modal" data-target="#searchBlog"></a>
                    </div>
                    <div class="menu-blog">
                        <div class="container">
                            <div class="wrap">
                                <div class="main-menu">
                                    @php
                                        $countries = getAllMainCountry();
                                        $country_slug = (empty($country) || (isset($countCountry) && $countCountry != 1)) ? '' : $country->slug;
                                    @endphp
                                    @if($countries)
                                        <nav class="main-nav contact-nav">
                                            <ul>
                                            @foreach($countries as $item)
                                                @if ($item->parent_id == 0)
                                                    <li @if ($country_slug == $item->slug) class="active" @endif>
                                                        <a href="{{route('blogCall',$item->slug)}}">{!!$item->title!!}</a>
                                                    </li>
                                                @endif
                                            @endforeach
                                            </ul>
                                        </nav>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @elsedesktop
                <div class="mobile-menu light-graynvp">
                    <div class="container">
                        <h1 id="logo-mobile">
                            <a href="{{route('blog')}}">{!! getLogoSonabee() !!}</a>
                        </h1>
                        <div class="right-mobile">
                            <span class="icon-phone icon"><i class="fa fa-phone"></i></span>
                            <span class="icon-menu icon"><i class="fa fa-bars"></i></span>
                        </div>
                    </div>
                </div>
                @enddesktop
            </header>
            <main>
                @yield('content')            
            </main>
            <footer class="footer-blog">
                 <!--Subcribe news-->
                <div class="subcribe-news light-graybg text-center">
                    <div class="container">
                        <div class="sec-title">
                            <span class="pink">Stay updated</span>
                            <p>Get the latest news, inspiring blog articles, or promotion</p>
                        </div>
                        <div class="content-sec">
                            <!-- Begin MailChimp Signup Form -->
                            <link href="//cdn-images.mailchimp.com/embedcode/classic-10_7.css" rel="stylesheet" type="text/css">
                            <div id="mc_embed_signup">
                            <form action="https://developworld.us17.list-manage.com/subscribe/post?u=c95898232bc32d5dd0f89a68d&amp;id=9a245e47b6" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
                                <div id="mc_embed_signup_scroll">
                                    <div class="mc-field-group email-wrap">
                                        <input type="email" value="" name="EMAIL" class="required email" id="mce-EMAIL" placeholder="Email address" />
                                    </div>
                                    <div class="clear submit-wrap"><input type="submit" value="Sign me in" name="subscribe" id="mc-embedded-subscribe" class="button"></div>
                                </div>
                            </form>
                            </div>
                            {{-- <script type='text/javascript' src='//s3.amazonaws.com/downloads.mailchimp.com/js/mc-validate.js'></script><script type='text/javascript'>(function($) {window.fnames = new Array(); window.ftypes = new Array();fnames[0]='EMAIL';ftypes[0]='email';fnames[1]='FNAME';ftypes[1]='text';fnames[2]='LNAME';ftypes[2]='text';fnames[3]='ADDRESS';ftypes[3]='address';fnames[4]='PHONE';ftypes[4]='phone';}(jQuery));var $mcj = jQuery.noConflict(true);</script> --}}
                            <!--End mc_embed_signup-->
                        </div>
                    </div>
                </div>
                <!--End Subcribe news-->

                <!--List partner-->
                <div class="list-partner graybg text-center">
                    <div class="container">
                        {!! social2() !!}
                    </div>
                </div>
                <!--End List partner-->
               
                 <?php 
                $company_parent = get_parentMenu(9); $company_menu = get_menu(31);    
                $help_parent = get_parentMenu(28); $help_menu = get_menu(28);
                $menu_footer_mobile_blog = get_parentMenu(30); $menu_footer_mobile_blog = get_menu(30);?>
                @desktop
                <div class="info-ft">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-4 menu-ft">
                                @if(!$company_menu->isEmpty())
                                <span class="title">{{$company_parent->title}}</span>
                                <div class="desc">
                                    <ul class="discover font-semibold">
                                        @foreach($company_menu as $menu)
                                            <?php $children_menu = get_childrenMenu($menu->id); $url = get_link($menu->id);?>
                                            <li <?php if(count($children_menu)>0) echo ' class="has-children"';?>>
                                                <a href="{{get_link($menu->id)}}"<?php if(URL::current()==$url) echo ' class="active"';?><?php if($menu->target!="_self") echo ' target="'.$menu->target.'"'?>>@if($menu->type=="home")<i class="fa fa-home" aria-hidden="true"></i>@endif{{$menu->title}}</a>
                                                @if(!$children_menu->isEmpty())
                                                <ul class="sub-menu">
                                                    @foreach($children_menu as $item)
                                                    <li><a href="{{get_link($item->id)}}"<?php if($item->target!="_self") echo 'target="'.$item->target.'"'?>>{{$item->title}}</a></li>
                                                    @endforeach
                                                </ul>
                                                @endif
                                            </li>    
                                        @endforeach
                                    </ul>
                                </div>
                                @endif 
                            </div>
                            <div class="col-md-4 find-us">
                                <span class="title">Our destinations</span>
                                <ul class="country">
                                    @php
                                        $Countries=getCountriesfooter();
                                    @endphp
                                    @foreach($Countries as $item)
                                        <li>
                                            <a href="{{ route('overviewCountry', ['slug_country'=>$item->slug]) }}" class="thumb">
                                                <img src="{{getImgUrl($item->icon_flag_gray)}}" alt="$item->title" class="icon icon-gray">
                                                <img src="{{getImgUrl($item->icon_flag)}}" alt="$item->title" class="icon icon-active">
                                                <span>{{($item->title)}}</span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>  
                            <div class="col-md-4 contact-us">
                                <span class="title">Contact us</span>
                                <ul class="contact-info no-list-style">
                                    <li><a href="mailto:{{mailSystem()}}"><i class="fas fa-envelope"></i>{{mailSystem()}}</a></li>
                                    <li><a href="tel:{{phone()}}"><i class="fas fa-phone"></i>{{phone()}}</a></li>
                                    <li><i class="fas fa-map-marker-alt"></i>{{address()}}</li>
                                </ul> 
                            </div> 
                        </div>
                    </div>
                </div>
                <div class="social-sec light-graybg text-center">
                    <div class="container">
                        {!! social() !!}
                    </div>
                </div>
                <div class="menu-ft-2 graybg text-center">
                    <div class="container">
                        @if(!$help_menu->isEmpty())
                            <ul class="no-list-style">
                                @foreach($help_menu as $menu)
                                <?php $children_menu = get_childrenMenu($menu->id); $url = get_link($menu->id);?>
                                <li <?php if(count($children_menu)>0) echo ' class="has-children"';?>>
                                    <a href="{{get_link($menu->id)}}"<?php if(URL::current()==$url) echo ' class="active"';?><?php if($menu->target!="_self") echo ' target="'.$menu->target.'"'?>>@if($menu->type=="home")<i class="fa fa-home" aria-hidden="true"></i>@endif{{$menu->title}}</a>
                                    @if(!$children_menu->isEmpty())
                                    <ul class="sub-menu">
                                        @foreach($children_menu as $item)
                                        <li><a href="{{get_link($item->id)}}"<?php if($item->target!="_self") echo 'target="'.$item->target.'"'?>>{{$item->title}}</a></li>
                                        @endforeach
                                    </ul>
                                    @endif
                                </li>    
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
               {{--  <section class="copyright"><div class="container">{!! copyright() !!}</div></section> --}}
                @elsedesktop
                <div class="social-sec text-center">
                    <div class="container">
                        @desktop
                        {!! socialBlog() !!}
                        @elsedesktop
                        {!! social() !!}
                        @enddesktop
                    </div>
                </div>
                <div class="menu-ft-mobi light-graybg">
                    <div class="container">
                        @if(!$menu_footer_mobile_blog->isEmpty())
                            <ul class="list-style-mobi">
                                @foreach($menu_footer_mobile_blog as $menu)
                                <?php $children_menu = get_childrenMenu($menu->id); $url = get_link($menu->id);?>
                                <li <?php if(count($children_menu)>0) echo ' class="has-children"';?>>
                                    <a href="{{get_link($menu->id)}}"<?php if(URL::current()==$url) echo ' class="active"';?><?php if($menu->target!="_self") echo ' target="'.$menu->target.'"'?>>@if($menu->type=="home")<i class="fa fa-home" aria-hidden="true"></i>@endif{{$menu->title}}</a>
                                    @if(!$children_menu->isEmpty())
                                    <ul class="sub-menu">
                                        @foreach($children_menu as $item)
                                        <li><a href="{{get_link($item->id)}}"<?php if($item->target!="_self") echo 'target="'.$item->target.'"'?>>{{$item->title}}</a></li>
                                        @endforeach
                                    </ul>
                                    @endif
                                </li>    
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
                <section class="copyright graybg"><div class="container">{!! copyright() !!}</div></section>
                @enddesktop 
            </footer>
        </div>
    </div>
</div>
<div class="menu-mobi">
    <div class="mid light-graynvp">
        <div class="main-menu">
            <div class="top-mobi">
                <span class="back_nvp"><i class="fa fa-angle-left"></i></span>
                <h7 class="title-menu">MENU</h7>
                <span class="close-mobi"><img src="{{ asset('public/images/close.png') }}"></span>
            </div>
            @php $main_nav = get_menu(32); @endphp
            @if($main_nav)
                <nav class="main-nav-mobile contact-nav">
                    <ul>
                    @foreach($main_nav as $item)
                        @php
                            $children_menu = get_childrenMenu($item->id); 
                            $url = get_link($item->id);
                        @endphp
                        <li>
                            <a href="{{$url}}">{!!$item->title!!}</a>
                            @if(!$children_menu->isEmpty())
                            <ul class="sub-menu">
                                @foreach($children_menu as $sub)
                                <li><a href="{{get_link($sub->id)}}">{!!$sub->title!!}</a></li>
                                @endforeach
                            </ul>
                            @endif
                        </li>
                    @endforeach
                        <li>
                            <a href="javascript:void(0)" class="search_tour">Search</a>
                        </li>
                        <li>
                            <a href="{{ route('home') }}" class="biig_blog">Sonasia Holiday</a>
                        </li>
                    </ul>
                </nav>
                <div class="search_mobile light-graynvp search-modal">
                    <div class="top-mobi">
                        <span class="back back_search"><i class="fa fa-angle-left"></i></span>
                        <h7 class="title-menu for_tour">SEARCH FOR AN ARTICLE</h7>
                        <span class="close-mobi"><img src="{{ asset('public/images/close.png') }}"></span>
                    </div>
                    <div class="search-tour form-search searchArticle">
                        <div class="body-sear-blog">
                            {!!csrf_field()!!}
                            <input type="text" id="titleSearch" class="form-control clearfix" name="s" value="" placeholder="Enter keyword(s)"  data-action="{{ route('blogSearch') }}" >
                            @php
                                $list_blog=getAticlesOrderByTitle();
                            @endphp
                            <div class="result-search">
                                <ul class="highlight-key">
                                    @foreach($list_blog as $item)
                                        <li><a href="{{ route('blogCall', ['slug' => $item->slug]) }}" class="link_city">{{ $item->title }}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        <div class="sub-destination light-graynvp sub-mobile-nvp">
            <div class="top-mobi">
                <span class="back"><i class="fa fa-angle-left"></i></span>
                <h7 class="title-menu">DISCOVER</h7>
                <span class="close-mobi"><img src="{{ asset('public/images/close.png') }}"></span>
            </div>
            @if($destinations)
                <ul class="sub-country light-graynvp">
                    @foreach($destinations as $des)
                        <li>
                            <a href="{{ route('blogCall', ['slug'=>$des->slug]) }}">
                                {{$des->title}}
                            </a>
                        </li>
                    @endforeach
                </ul> 
            @endif
        </div>
         <div class="sub-tour-style light-graynvp sub-mobile-nvp">
            <div class="top-mobi">
                <span class="back"><i class="fa fa-angle-left"></i></span>
                <h7 class="title-menu">TOPICS</h7>
                <span class="close-mobi"><img src="{{ asset('public/images/close.png') }}"></span>
            </div>
            @if($categories)
                <ul class="light-graynvp">
                    @foreach($categories as $item)
                        <li>
                           <a href="{{ route('blogCall',['slug'=>$item->slug ]) }}">{{$item->title}}</a>
                        </li>
                    @endforeach
                </ul> 
            @endif
        </div>
        <div class="contact-mobi">
            <div class="top-mobi">
                <span class="back_nvp"><i class="fa fa-angle-left"></i></span>
                <span class="title-menu">Contact</span>
                <span class="close-mobi"><img src="{{ asset('public/images/close.png') }}"></span>
            </div>
            <form action="#" method="GET" class="form-contact-mobi">
                <div class="clients">
                    <h7 class="title">Who we are</h7>
                    <h7 class="title">What our clients said...</h7>
                </div>
                <ul class="contact-info no-list-style">
                    <li><i class="fas fa-map-marker-alt"></i>{{address()}}</li>
                    <li><a href="tel:{{phone()}}"><i class="fas fa-phone"></i>{{phone()}}</a></li>
                    <li><a href="mailto:{{mailSystem()}}"><i class="fas fa-envelope"></i>{{mailSystem()}}</a></li>
                </ul>
                <input class="btn btn-contact" type="submit" name="submit" value="Contact us">
            </form>
        </div>
        <div class="bee">
            <img src="{{asset('public/images/Bee.png')}}">
        </div>
    </div>
</div>
<div id="overlay"></div>
<img class="loading" src="{{ asset('public/images/icons/Loading icon.gif') }}" alt="loading"></img>
<div id="backtotop"><img class="img_bktop" src="{{ asset('public/images/Arrow back top - 100px.png') }}" alt="back top"></div>
<div class="modal fade" id="searchBlog" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content searchArticle">
      <div class="modal-header">
        <span class="modal-title" id="exampleModalLongTitle">SEARCH FOR A BLOG ARTICLE</span>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true"></span>
        </button>
      </div>
      <div class="modal-body">
        {!!csrf_field()!!}
        <input type="text" id="titleSearch" class="form-control" name="s" value="" placeholder="Enter your search"  data-action="{{ route('blogSearch') }}" >
        @php
            $list_blog=getAticlesOrderByTitle();
        @endphp
        <div class="result-search">
            <ul class="highlight-key">
                @foreach($list_blog as $item)
                    <li><a href="{{ route('blogCall', ['slug' => $item->slug]) }}" class="link_city">{{ $item->title }}</a></li>
                @endforeach
            </ul>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>