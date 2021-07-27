@php
	$title_tag = ($city->title_tag != null) ? $city->title_tag : '';
	$seo = get_seo($city->id, 'country');
	$meta_key = ($seo && $seo->value != null) ? $seo->key : '';
	$meta_value = ($seo && $seo->value != null) ? $seo->value : '';		

	$list_bestTimeToVisit = json_decode($city->best_time_to_visit);
	$list_howToGet = json_decode($city->how_to_get);
	$list_whatToEat = json_decode($city->what_to_eat);
	$list_thingToDo = $city->catGuideSelect('thing_to_do'); //dd($list_thingToDo);
	$bg_img = getImgUrl($city->image);
	$breadcrumb = Breadcrumbs::render('placeToVisit', $country, $region , $city->title);
	$title_h2 = ' - Destination Guide - ';
	$title_top_h1 = $city->title . ' Travel';
	$post_type_active = 'highlight';
	$include_searchBox = 'countries.highlights.search-box';
@endphp

@extends('templates.master')
@section('content')
@section('title', $title_tag)
@section('description', $meta_value)
@section('keywords', $meta_key)
@section('image_url', $bg_img)
<div class="place-to-visit singe-places">
    <div class="image-header" style="background-image: url(<?php echo $bg_img; ?>);">
	    <div class="wrap">
	        <div class="container">
	        	@if(isset($breadcrumb))
	                {!! $breadcrumb !!}
	            @endif
	            @if(isset($title_h2))
	                <span class="title-banner-2">{{ $title_h2 }}</span>
	            @endif
	            @if(isset($title_top_h1))
	                <h1 class="title-banner-1">{{ $title_top_h1 }}</h1>
	            @endif
	            <div class="search-box white serch-cities">
	            	<form action="" method="get" id="search-city">
						{!!csrf_field()!!}
						<input type="text" name="keyword" class="white" placeholder="Search for a destination" data-action="{{ route('loadCities', $country->slug) }}" autocomplete="off"/>
						<button type="submit" class="submit_cities"><img src="{{ asset('public/images/icons/all/loupe-white.png') }}" alt="loupe-white"></button>
						<div class="list-result list-place">
							<ul>
								@foreach($list_city as $item)
									<li><a href="{{ route('postTypeCountryTravel', ['slug_country' => $country->slug,'slug' => $item->slug]) }}" class="link_city">{{ $item->title }}</a></li>
								@endforeach
							</ul>
						</div>
						
					</form>
				</div>
	        </div>
	    </div>
	</div>
	<div class="content-page content-places ">
		<div class="container">
			<div class="top-intro text-center">
	            	{!! $city->desc !!}
			</div>
		</div>
		<div class="maps">
			{!! $city->map !!}
		</div>
		@desktop
		@if($highlight->video)
			<div class="video_places light-graynvp">
				<div class="container">
					<div class="header-sec text-center">
						<div class="title-sec">
							<span class="title pink">{{ $highlight->title_video }}</span>
						</div>
						<div class="desc_p">{{ $highlight->desc_video }}</div>
					</div>

					<div class="iframe_video">
						{!! $highlight->video !!}
					</div>
				</div>
			</div>
		@endif
		@enddesktop
	</div>
	<!--Gallery-->
	<div class="single-sec gallery-sec">
		<div class="content-sec container">
			<div class="list_gallery">
			@if($gallery && count($gallery) > 0)
				@foreach($gallery as $key => $img_id)
					@php
						$img = getMedia($img_id);
					@endphp
					@if($img)
						<div class="item" style="background-image: url('{{asset('/public/uploads/'.$img->image_path)}}');">
							<div class="title_image">{{$key + 1}}/{{count($gallery)}} {{$img->title}}</div>
						</div>
					@endif
				@endforeach
			@endif
			</div>
		</div>
	</div>
	<!--End Gallery-->
	<div class="container content-guide">
		@if($list_bestTimeToVisit)
		@php $content = "";
		$title = ""; @endphp
			@foreach($list_bestTimeToVisit as $key => $item)
				@php 
					$content .='<div class="item" id="tab_'.($key + 1).'">
									<div class="desc">
										<div class="text">'.$item->content.'</div>
									</div>
								</div>
								';
					$title .= '<li class="link_tab" data-href="tab_'.($key + 1).'"><h2>'.$item->title.'</h2></li>';
				@endphp
			@endforeach
			<div class="row city_guide">
				<div id="content" class="col-md-9">		
					<div class="list_best">
						{!! $content !!} 
					</div>
					<div class="back-to-start"></div>
				</div>
				<div id="sidebar" class="col-md-3">
					<div class="fixel_discover">
						<div class="sb-categories" >
							<span class="sb-title">DISCOVER</span>
							<div class="desc">
								<ul class="list-cat no-list-style tabs-dis">
									{!! $title !!} 
								</ul>
							</div>
						</div>
					</div>
					@desktop
					<div class="sb-contact">
						<a href="#" class="thumb"><img src="{{asset('public/images/request-free-sub.jpg')}}" alt="bigg_icon"></a>
						<div class="desc-contact">
							<span class="guaranteed">24-hour response guaranteed</span>
							<a href="{{ route('createMyTrip') }}" title="" class="btn btn-request">request a free quote</a>
						</div>
					</div>
					@enddesktop
				</div>
				@handheld
				<div class="plus-table">
					<div class="transparent-open">
						<div class="plus-open">
							<img src="{{asset('public/images/icons/close.png')}}" alt="bigg_icon">
						</div>
					</div>
					<div class="list-visit">
						<span class="sb-title">DISCOVER <span class="closes"><img src="{{asset('public/images/icons/close.png')}}" alt="bigg_icon"></span></span>
						<div class="desc">
							<ul class="list-cat no-list-style tabs-dis">
								{!! $title !!} 
							</ul>
						</div>
					</div>
				</div>
				@endhandheld
			</div>
		@endif
	</div>
	<div class="content-places">
		@if($list_tour_byCountry && count($list_tour_byCountry) > 0)
			<div class="hand_craft slide_owl light-graynvp">
				<div class="container">
					<div class="header-sec text-center">
						<div class="title-sec">
							<h2 class="title pink">TOUR PACKAGES INCLUDING "{{ $city->title }}"</h2>
						</div>
					</div>
					@include('parts.countryTourDetails.list_tour_country')
				</div>
			</div>
		@endif
		@handheld
			@php
				$regions = getAllCountryByLevel(1);
			    $list_regions = getListRegionInCountry($country->id);
			    $durations = getListDuration();
			    $styles = getAllCountryTourStyle();
			@endphp
			<div class="looking looking-tour-mobile"  style="background-image: url('{{ getImgUrl($highlight->image_request_one) }}');">
	            @include('parts.countryTourDetails.search-tour-details')
	        </div>
        @endhandheld
		<div class="places-to-visit light-graybg padding_center slide_owl">
			<div class="container">
				<div class="header-sec text-center">
					<div class="title-sec">
						<span class="title pink">OTHER PLACES TO VISIT IN {{ $country->title }}</span>
					</div>
				</div>
				@php 
					$main_city = explode(',',$list_main_city->list_main_city);
				@endphp
				<div class="@desktop slide-style @elsedesktop slide-dost @enddesktop list-places">
				    @foreach($main_city as $items)
				        @if($items != $city->id)
				        @php 
				            $city_objs = getCountry($items);
				            $style = $city_objs;
				        @endphp
				            <div class="wrapper-item">
				                <div class="item" style="background-image: url('{!! getImgUrl($style->image); !!}')">
				                	@handheld
				                	<a class="link" href="{{ route('postTypeCountryTravel', ['slug_country'=>$country->slug,'slug'=>$style->slug ]) }}"></a>
				                	@endhandheld
				                    <h7 class="title-country white">{{$style->title}}</h7>
				                    <div class="desc_hover">
				                        <a class="link_traveltips" href="{{ route('postTypeCountryTravel', ['slug_country'=>$country->slug,'slug'=>$style->slug ]) }}"></a>
				                        <div class="desc">
				                            <img class="bee" src="{{asset('public/images/bee/bee-white.png')}}"> 
				                            <h7 class="title_hover yellow">{{$style->title}}</h7>
				                            <p class="white">{!! $style->short_desc !!}</p>
				                        </div>
				                    </div>
				                </div>
				            </div>
				        @endif
				    @endforeach
				</div>
			</div>
		</div>
		<div class="bot-tour">
		    <a href="{{ route('countryPlaceToVisit', ['slug_country' => $country->slug]) }}" class="btn btn-tour"> {{ $country->title }} DESTINATIONS</a>
		</div>
		@desktop
		<div class="request mar_nvp" style="background-image: url('{{ getImgUrl($highlight->image_request_one) }}')">
			<div class="container">
				<div class="list-request">
					<div class="row item-request">
						<div class="col-md-5 col-sm-6 item">
							{!! image(getDsMetas(260),300,220,'image') !!}
						</div>
						<div class="col-md-7 col-sm-6 text-center item">
							<span class="aplan yellow">24-hour response<br>guaranteed!</span>
							<a class="btn btn-request" href="{{ route('createMyTrip') }}">REQUEST A FREE QUOTE</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		@enddesktop
		<div class="tready-yet light-graynvp">
			<div class="container">
				<div class="header-sec text-center">
					<div class="title-sec">
						<span class="title pink">NOT READY YET?</span>
					</div>
					@if(isset($country_place))
		            	<div class="desc_p">
							{!! $country_place->content_ready_yet !!}
						</div>
		            @endif
				</div>
			</div>
		</div>
		<div class="plans-travels light-graybg padding_center slide_owl">
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
		<div class="bot-tour">
            <a href="{{ route('countryTour', ['slug_country' => $country->slug]) }}" class="btn btn-tour">{{ $country->title }} tour packages</a>
        </div>
        <div class="request back-none" style="background-image: url('{{ getImgUrl($highlight->image_request_two) }}')">
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
						<span class="title pink">{{ $country->title }} TRAVEL TIPS & GUIDE</span>
					</div>
					@if(isset($country_place))
		            	<div class="desc_p">
							{!! $country_place->content_tips !!}
						</div>
		            @endif
				</div>
				@include('parts.countryTourDetails.travel_tips_guide')
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
					$list_blog = allArticleByCountry($country->id);
				@endphp
				@if($list_blog)
					<div class="@desktop slide-style @elsedesktop slide-tour-dost @enddesktop list-blog">
						@foreach($list_blog as $key => $item)
							@php
								$countCountry  = getAllCountriesId($item->id);
							@endphp
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