@php 
    $bg_img = getImgUrl($page->image); 
    $bg_looking= getImgUrl(getDsMetas(339));
    $bg_request= getImgUrl(getDsMetas(340));
    $regions = getAllCountryByLevel(1);
    $durations = getListDuration();
    $styles = getAllCountryTourStyle();
@endphp
@extends('templates.master')
@section('title', $page->title)
@section('description',$seo->value)
@section('keywords', $seo->key)
@section('content')
<div id="error">
	<div class="background-404" style="background-image: url(<?php echo $bg_img; ?>);">
		<div class="container">
		    <div class="content_error text-center">
		    	<h1 class="title pink">{!! $page->title !!}</h1>
			    @desktop
			    <div class="desc">
			    	{!! $page->content !!}
			    </div>
			    @elsedesktop
			    <div class="desc">
			    	Oops! It seems that the page you are
					searching for is on vacation.
					You can check the other pages that are
					still working or contact us for the page
					you need, we call it back to work again.
			    </div>
			    @enddesktop 
			    <div>
			    	<div class="button_link text-center">
						<a href="{{route('home')}}" class="home_page"><img src="{{asset('public/images/home-white.png')}}" alt="image">Homepage</a>
						<a href="{{ route('contact') }}" class="contact-us"><img src="{{asset('public/images/Mailicon.png')}}" alt="image">Contact us</a>
					</div>
			    </div>
				<div class="banner_footer_404 text-center">
					<ul class="contact-info no-list-style">
		                <li><a href="tel:{{phone()}}"><i class="fas fa-phone"></i>{{phone()}}</a></li>   
		                <li><a href="mailto:{{mailSystem()}}"><i class="fas fa-envelope"></i>{{mailSystem()}}</a></li>          
		            </ul>
				</div>
			</div>
		</div>
	</div>
	<div class="content-places">
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
            <div class="preparing light-graybg slide_owl asia_guide">
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
@stop