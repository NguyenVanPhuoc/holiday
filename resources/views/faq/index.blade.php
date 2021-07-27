@php 
    $bg_img = getImgUrl($page->image); 
    $bg_looking= getImgUrl(getDsMetas(309));
    $bg_request= getImgUrl(getDsMetas(310));
    $breadcrumb = Breadcrumbs::render('FAQs', 'FAQ');
    $icon_top =  asset('public/images/icons/faq-white.png');
    $title_top_h1 = 'FAQs';
    $regions = getAllCountryByLevel(1);
    $durations = getListDuration();
    $styles = getAllCountryTourStyle();
@endphp
@extends('templates.master')
@section('title', $page->title)
@section('description',$seo->value)
@section('keywords', $seo->key)
@section('content')
<div id="faq-page" class="page singe-post">
    <div class="image-header" style="background-image: url(<?php echo $bg_img; ?>);">
        <div class="wrap bottom">
            <div class="container">
                @if(isset($breadcrumb))
                    {!! $breadcrumb !!}
                @endif
                <h1 class="title-banner-1">{{ $title_top_h1 }}</h1>
            </div>
        </div>
    </div>
    <div class="content-places">
        <div class="light-graynvp content-sec">
            <div class="container">
                <div class="top-intro text-center">{!! $page->content !!}</div>
                <div class="search-sec">
                    <div class="light-graybg search-faq text-center">
                        @desktop<p class="either">You can either search for the question below or navigate via the topic bar in the left.</p>@enddesktop
                        <div class="search-box white">
                            {!!csrf_field()!!}
                            <input type="text" name="keyword" class="white" placeholder="Type in keyword or question" data-action="{{ route('searchFaqs') }}" autocomplete="off" />
                            <button type="submit" class="submit_cities"><img src="{{ asset('public/images/icons/all/loupe-white.png') }}" alt="loupe-white"></button>
                            <div class="list-result list-place">
                                <ul>
                                    @foreach($list_faq as $item)
                                        <li><a href="#faq-{{ $item->id }}" data-cat-id="#cat-{{ $item->category->id }}">{{ $item->title }}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="faqs-sec">
                    <div class="tabs-sec row">
                        <div id="sidebar" class="col-md-3">
                            @desktop
                            <h7 class="title-topic yellow">TOPIC LIST</h7>
                            <div class="list-cat-faq">
                                <div class="item active" data-id="#cat_asked">
                                    <div class="icons">
                                        <img src="{{ asset('public/images/icons/clock-white.png') }}" alt="white-icon" class="icon">
                                        <img src="{{ asset('public/images/icons/clock-yellow.png') }}" alt="white-icon" class="icon icon-active">
                                    </div>  
                                    <h2 class="title">
                                        <a href="#cat-asked">Most asked</a>
                                    </h2>
                                </div>
                                @foreach($list_cat as $key => $item)
                                    @php
                                        $white_icon = getImgUrl($item->white_icon);
                                        $yellow_icon = getImgUrl($item->yellow_icon);
                                    @endphp
                                    <div class="item" data-id="#cat-{{ $item->id }}">
                                        <div class="icons">
                                            <img src="{{ $white_icon }}" alt="white-icon" class="icon">
                                            <img src="{{ $yellow_icon }}" alt="white-icon" class="icon icon-active">
                                        </div>
                                        <h2 class="title">
                                            <a href="#cat-{{ $item->id }}">{{ $item->title }}</a>
                                        </h2>
                                    </div>
                                @endforeach
                            </div>
                            @elsedesktop
                            <div class="list-faq-mobi graybg">
                                <div class="item active" data-id="#cat_asked">
                                    <div class="icons">
                                        <img src="{{ asset('public/images/icons/clock-white.png') }}" alt="white-icon" class="icon">
                                        <img src="{{ asset('public/images/icons/clock-yellow.png') }}" alt="white-icon" class="icon icon-active">
                                    </div>  
                                    <h2 class="title">
                                        <a href="#cat-asked">Most asked</a>
                                    </h2>
                                </div>
                                @foreach($list_cat as $key => $item)
                                    @php
                                        $white_icon = getImgUrl($item->white_icon);
                                        $yellow_icon = getImgUrl($item->yellow_icon);
                                    @endphp
                                    <div class="item" data-id="#cat-{{ $item->id }}">
                                        <div class="icons">
                                            <img src="{{ $white_icon }}" alt="white-icon" class="icon">
                                            <img src="{{ $yellow_icon }}" alt="white-icon" class="icon icon-active">
                                        </div>
                                        <h2 class="title">
                                            <a href="#cat-{{ $item->id }}">{{ $item->title }}</a>
                                        </h2>
                                    </div>
                                @endforeach
                            </div>
                            @enddesktop
                        </div>
                        <div id="content" class="tab-content col-md-9">
                            @foreach($list_asked as $abc => $item)
                                <div id="cat_asked" class="tab-faq active ">
                                    <div class="list-faq">
                                        <div id="faq-{{ $item->id }}" class="item">
                                            <h3 class="title">{{ $abc + 1 }}. {{ $item->title }}</h3>
                                            <div class="desc">{!! $item->content !!}</div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            @foreach($list_cat as $key => $item)
                                @php
                                    $faqs = $item->faqs()->get();
                                @endphp
                                <div id="cat-{{ $item->id }}" class="tab-faq">
                                    @if($faqs)
                                    <div class="list-faq">
                                        @foreach($faqs as $number => $faq)
                                            <div id="faq-{{ $faq->id }}" class="item">
                                                <h3 class="title">{{ $number + 1 }}. {{ $faq->title }}</h3>
                                                <div class="desc">{!! $faq->content !!}</div>
                                            </div>
                                        @endforeach
                                    </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="looking looking-tour-mobile"  style="background-image: url('{{ $bg_looking }}');">
            @include('parts.looking-tour')
        </div>
        <div class="tready-yet light-graynvp">
            <div class="container">
                <div class="header-sec text-center">
                    <div class="title-sec">
                        <span class="title pink">NOT READY YET?</span>
                    </div>
                    <div class="desc_p">
                        {!! getDsMetas(305) !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="our_destinations padding_center light-graybg asia_our">
            <div class="container">
                <div class="header-sec text-center">
                    <div class="title-sec">
                        <span class="title pink">OUR DESTINATIONS</span>
                    </div>
                </div>
                 @include('parts.AsiaTourDetails.our_destinations')
            </div>
        </div>
        <div class="plans-travels light-graybg padding_center slide_owl">
            <div class="container">
                <div class="header-sec text-center">
                    <div class="title-sec">
                        <span class="title pink">PLANS BY TRAVEL THEME</span>
                    </div>
                </div>
                 @include('parts.AsiaTourDetails.plans_travel_theme')
            </div>
        </div>
        <div class="plans-time light-graynvp">
            <div class="padding_center">
                <div class="container">
                    <div class="header-sec text-center">
                        <div class="title-sec">
                            <span class="title pink">PLANS BY TIME FRAME</span>
                        </div>
                    </div>
                    @include('parts.AsiaTourDetails.plans_time_frame')
                </div>
            </div>
        </div>
        <div class="bot-tour top-bot">
            <a href="{{ route('asiaTour') }}" class="btn btn-tour">All tour packages</a>
        </div>
        <div class="request back-none" style="background-image: url('{{ $bg_request }}')">
            @php
                $img_request = getDsMetas(260);
                $title_request = getDsMetas(301);
            @endphp
            @include('parts.request')
        </div>
        <div class="preparing light-graynvp slide_owl asia_guide">
            <div class="container">
                <div class="header-sec text-center">
                    <div class="title-sec">
                        <span class="title pink">TRAVEL TIPS & GUIDE</span>
                    </div>
                    <div class="desc_p">{!! getDsMetas(290) !!}</div>
                </div>
                @include('parts.list_nation')
            </div>
        </div>
        <div class="section-blog slide_owl">
            <div class="container">
                <div class="header-sec text-center">
                    <div class="title-sec">
                        <span class="title pink">{!! getDsMetas(293) !!}</span>
                    </div>
                </div>
                @include('parts.list_blog')
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function() {
        $('.search-sec').on('click', '.list-result li a', function(e){
            e.preventDefault();
            let faq_id = $(this).attr('href');
            let cat_id = $(this).attr('data-cat-id');
            $('.tabs-sec .list-cat-faq .item').removeClass('active');
            $('.tabs-sec .list-cat-faq .item[data-id=' + cat_id + ']').addClass('active');
            $('.tabs-sec .tab-content .tab-faq').hide();
            $('.tabs-sec .tab-content ' + cat_id).fadeIn();
            $('.list-faq .item').removeClass('active');
            $('.list-faq .item .desc').hide();
            $('.list-faq ' + faq_id).addClass('active');
            $('.list-faq ' + faq_id + ' .desc').slideDown();
            $('html, body').animate(
                {
                  scrollTop: $($('.list-faq ' + faq_id)).offset().top,
                },
                500,
                'linear'
            );
        });
    });
</script>
@stop