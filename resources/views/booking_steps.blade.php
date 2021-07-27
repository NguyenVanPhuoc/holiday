@php
 	$bg_img = getImgUrl($page->image); 
	$breadcrumb = Breadcrumbs::render('FAQs', $page->title );
	$bg_looking= getImgUrl(getDsMetas(324));
    $bg_request= getImgUrl(getDsMetas(325));
    $regions = getAllCountryByLevel(1);
    $durations = getListDuration();
    $styles = getAllCountryTourStyle();
    $site_title = $page->title .' | Sonasia Holiday';
@endphp
@extends('templates.master')
@section('title', $site_title)
@section('description', $seo->value)
@section('keywords', $seo->key)
@section('content')
<div id="term_of_use" class="page bg-gray page-one">
	<div class="image-header" style="background-image: url(<?php echo $bg_img; ?>);">
		<div class="wrap bottom">
			<div class="container">
				 @if(isset($breadcrumb))
                    {!! $breadcrumb !!}
                @endif
				<h1 class="title-banner-1">{{ $page->title }}</h1>
			</div>
		</div>	
	</div>
	<div class="container">
		<div class="indotruce text-center">
			{!! $page->content !!}
		</div>
		<div class="content_biig">
			<div class="list-works list-steps @desktop row @elsedesktop slide-dost @enddesktop ">
				<div class="col-md-4 col-book">
					<div class="item light-graybg">
						<div class="child">
							<h4 class="yellow"><span class="icon">Step 1</span></h4>
							<div class="desc">{!! getDsMetas(219) !!}</div>
						</div>
					</div>
					<a class="btn btn_yellow" href="{{ route('asiaTour') }}"><span>VIEW ALL TOURS</span> </a>
				</div>
				<div class="col-md-4 col-book">
					<div class="item light-graybg">
						<div class="child">
							<h4 class="yellow"><span class="icon">Step 2</span></h4>
							<div class="desc">{!! getDsMetas(220) !!}</div>
						</div>
					</div>
					<a class="btn btn_yellow" href="{{ route('createMyTrip') }}"><span>REQUEST A FREE QUOTE</span> </a>
				</div>
				<div class="col-md-4 col-book">
					<div class="item light-graybg">
						<div class="child">
							<h4 class="yellow"><span class="icon">Step 3</span></h4>
							<div class="desc">{!! getDsMetas(221) !!}</div>
						</div>
					</div>
					<a class="btn btn_yellow" href="{{ route('bookingConditions') }}"><span>BOOKING CONDITIONS</span> </a>
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