@php
	$meta_key = ($seo && $seo->key != '') ? $seo->key : '';
	$meta_value = ($seo && $seo->value != '') ? $seo->value : '';
@endphp
@extends('templates.master')
@section('content')
@section('title', $guide->title_tag)
@section('description', $meta_value)
@section('keywords', $meta_key)
@section('image_url', getImgUrl($guide->image))
@php	
	$country = getCountryById($guide->country_id);
	$tableContent = getTableContent($guide->id, 'guide');
	$bg_img = getImgUrl($guide->image);
	$bg_looking = ($guide->image_looking != '' ) ? getImgUrl($guide->image_looking) : getImgUrl(getDsMetas(278));
	$bg_request = ($guide->image_request != '' ) ? getImgUrl($guide->image_request) : getImgUrl(getDsMetas(259)); 
	//$icon_top = getImgUrl($guide->white_icon);
	$breadcrumb = Breadcrumbs::render('detailTravelTip', $country, $guide->short_title);
	$title_h2 = ' - Travel Tips & Guide - ';
	$title_top_h1 = $guide->title;
	$post_type_active = 'travel_tip';
@endphp
<div class="detail-travel-tip singe-post guide-mobi" id="detail-guide-mb">
	<div class="image-header" style="background-image: url(<?php echo $bg_img; ?>);">
	    <div class="wrap">
	        <div class="container">
	        	@if(isset($breadcrumb))
	                {!! $breadcrumb !!}
	            @endif
	            @desktop
	            @if(isset($title_h2))
	                <span class="title-banner-2">{{ $title_h2 }}</span>
	            @endif
	            @enddesktop
	            @if(isset($title_top_h1))
	                <h1 class="title-banner-1">{{ $title_top_h1 }}</h1>
	            @endif
	            @handheld
	            <div class="graybg list-orther">
	            	<span class="open-orther">OTHER GUIDES</span>
	            	<div class="other-mobi">
		            	<ul>
		            		@foreach ($related_guides as $item)
								@php
									$addClass = '';
									if($item->id == $guide->id) $addClass = 'yellow';
								@endphp
								<li class="{{$addClass}}">
									@if($item->id == $guide->id)
										{{ $item->short_title }}
									@else
										<a href="{{ route('postTypeCountryTravel', ['slug_country' => $country->slug,'slug' => $item->slug]) }}">
											{{ $item->short_title }}
										</a>
									@endif
								</li>
							@endforeach
		            	</ul>
		            </div>
	            </div>
	            @endhandheld
	        </div>
	    </div>
	</div>
	<div class="content-page content-guide content-places" >
		<div class="container">
			<div class="row">
				@desktop
				<div id="sidebar" class="col-md-3">
					<div class="gr-not-fixed sb-categories" >
						<h7 class="sb-title">OTHER GUIDES</h7>
						@if($related_guides)
						<div class="desc">
							<ul class="list-cat no-list-style">
								@foreach ($related_guides as $item)
								@php
									$addClass = '';
									if($item->id == $guide->id) $addClass = 'active';
								@endphp
								<li class="{{$addClass}}">
									@if($item->id == $guide->id)
										{{ $item->short_title }}
									@else
										<a href="{{ route('postTypeCountryTravel', ['slug_country' => $country->slug,'slug' => $item->slug]) }}">
											{{ $item->short_title }}
										</a>
									@endif
								</li>
								@endforeach
							</ul>
						</div>
						@endif
					</div>
					<div class="sb-contact">
						<a href="#" class="thumb"><img src="{{asset('public/images/request-free-sub.jpg')}}" alt="bigg_icon"></a>
						<div class="desc-contact">
							<span class="guaranteed">24-hour response guaranteed</span>
							<a href="{{ route('createMyTrip') }}" title="" class="btn btn-request">request a free quote</a>
						</div>
					</div>
					<div class="group-fixed">
						<div class="table-list table-list-schedule">
							<div class="table-content">
								<h7 class="sb-title">TABLE OF CONTENT</h7>
								<div class="fix_content">
									<div class="table-body scrollbar-inner">
										<div class="wrap-body">
											@if($tableContent)
												<ol>
												@php
													$tableLevel1s = getTableDetailLevel1($tableContent->id); 
												@endphp
												@if($tableLevel1s) <!--Level 1-->
													@foreach($tableLevel1s as $key => $level1)
														{!! getHeadingTbContent($level1->id) !!}
													@endforeach
												@endif
											</ol>
											@endif
										</div>
									</div>
								</div>
							</div>
							
						</div>
					</div>
				</div>
				@enddesktop
				<div id="content" class="col-md-9">
					<div class="wr-content">
						<div class="desc-content">{!! $guide->desc !!}</div>
						<div class="table-heading">
							<div class="header-heading font-semibold">
								<h7 class=" title_h7">{{ __('Table of content') }}</h7>
								<span class="bar-heading">
									[
									<a href="#" class="collapse-bar pink">{{ __('Hide') }}</a>
									<a href="#" class="expand-bar hide pink">{{ __('Show') }}</a>
									]
								</span>
							</div>
							<div class="list-heading">
								@if($tableContent)
								<ol>
									@php
										$tableLevel1s = getTableDetailLevel1($tableContent->id); 
									@endphp
									@if($tableLevel1s) <!--Level 1-->
										@foreach($tableLevel1s as $key => $level1)
											{!! getHeadingTbContent($level1->id) !!}
										@endforeach
									@endif
								</ol>
								@endif
							</div>
						</div>
						<div class="list-tb-content">
							@if($tableContent)
								@php
									$tableLevel1s = getTableDetailLevel1($tableContent->id); 
								@endphp
								@if($tableLevel1s) <!--Level 1-->
									@foreach($tableLevel1s as $key => $level1)
										{!! getContentTbContent($level1->id) !!}
									@endforeach
								@endif
							@endif
						</div>

						<div class="back-to-start"></div>
					</div>
				</div>
				@handheld
				<div class="plus-table-guide">
					<div class="transparent-open">
						<div class="plus-open">
							<img src="{{asset('public/images/icons/close.png')}}" alt="bigg_icon">
						</div>
					</div>
					<div class="list-guide-mobi">
						<h7 class="title">TABLE OF CONTENT</h7>
						<span class="closes"><img src="{{asset('public/images/icons/close.png')}}" alt="closes"></span>
						<div class="table-body scrollbar-inner">
							<div class="wrap-body">
								@if($tableContent)
									<ol>
									@php
										$tableLevel1s = getTableDetailLevel1($tableContent->id); 
									@endphp
									@if($tableLevel1s) <!--Level 1-->
										@foreach($tableLevel1s as $key => $level1)
											{!! getHeadingTbContent($level1->id) !!}
										@endforeach
									@endif
								</ol>
								@endif
							</div>
						</div>
					</div>
				</div>
				@endhandheld
			</div>
			<div class="back-to-start"></div>
		</div>
		<div class="looking looking-tour-mobile" style="background-image: url(<?php echo $bg_looking; ?>);">
            @include('parts.countryTourDetails.search-tour-details')
        </div>
        <div class="tready-yet light-graynvp">
			<div class="container">
				<div class="header-sec text-center">
					<div class="title-sec">
						<span class="title pink">NOT READY YET?</span>
					</div>
					@if($desc_guideCountry)
		            	<div class="desc_p">
							{!! $desc_guideCountry->content_ready_yet!!}
						</div>
					@endif
				</div>
			</div>
		</div>
		<div class="places-to-visit light-graybg padding_center slide_owl mar-top">
			<div class="container">
				<div class="header-sec text-center">
					<div class="title-sec">
						<span class="title pink">PLACES TO VISIT IN {{ $country->title }}</span>
					</div>
				</div>
				@include('parts.countryTourDetails.list_places_to_visit')
			</div>
		</div>
		<div class="bot-tour light-graynvp top-bot">
		    <a href="{{ route('countryPlaceToVisit', ['slug_country' => $country->slug]) }}" class="btn btn-tour">{{ $country->title }} DESTINATIONS</a>
		</div>
		<div class="plans-travels light-graybg padding_center">
			<div class="container">
				<div class="header-sec text-center">
					<div class="title-sec">
						<span class="title pink">{{ $country->title }} PLANS BY TRAVEL THEME</span>
					</div>
				</div>
				 @include('parts.countryTourDetails.list_tour_style')
			</div>
		</div>
		<div class="plans-time light-graynvp padding_center">
			<div class="container">
				<div class="header-sec text-center">
					<div class="title-sec">
						<span class="title pink">{{ $country->title }} PLANS BY TIME FRAME</span>
					</div>
				</div>
				@include('parts.countryTourDetails.list_tour_duration')
			</div>
		</div>
		<div class="bot-tour top-bot">
            <a href="{{ route('countryTour', ['slug_country' => $country->slug]) }}" class="btn btn-tour">{{ $country->title }} tour packages</a>
        </div>
        <div class="request back-none" style="background-image: url(<?php echo $bg_request; ?>);">
			@php
				$img_request = getDsMetas(260);
				$title_request = getDsMetas(301);
			@endphp
			@include('parts.request')
		</div>
		<div class="preparing light-graybg slide_owl padding_center">
			<div class="container">
				<div class="header-sec text-center">
					<div class="title-sec">
						<span class="title pink">SPECIAL {{ $country->title }} TIPS & TOURS</span>
					</div>
					@if(isset($desc_guideCountry))
		            	<div class="desc_p">
							{!! $desc_guideCountry->content_tips !!}
						</div>
		            @endif
				</div>
				@include('parts.countryTourDetails.list_nation_guide')
			</div>
		</div>
		<div class="section-blog slide_owl light-graynvp padding_center">
			<div class="container">
				<div class="header-sec text-center">
					<div class="title-sec">
						<span class="title pink">{{ $country->title }} BLOG ARTICLES</span>
					</div>
				</div>
				@php
					$list_blog = allArticleByCountryV1($country->id);
				@endphp
				@if($list_blog)
					<div class="@desktop slide-style @elsedesktop slide-tour-dost @enddesktop list-blog">
						@foreach($list_blog as $key => $item)
	                        @include('articles.item')
						@endforeach
					</div>
				@endif
			</div>
		</div>
		<div class="another_country padding_center">
			<div class="container">
				<div class="header-sec text-center">
					<div class="title-sec">
						<span class="title pink">CHECK OUT OTHER DESTINATIONS</span>
					</div>
				</div>
				 @include('parts.countryTourDetails.another_country')
			</div>
		</div>
	</div>
</div>

@stop