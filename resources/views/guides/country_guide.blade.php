@php
	$meta_key = $seo->key;
	$meta_value = $seo->value;
	$title_tag = $desc_guideCountry->title_tag;
	$bg_img = getImgUrl($desc_guideCountry->banner_country); 
	$bg_looking = ($desc_guideCountry->banner != '' ) ? getImgUrl($desc_guideCountry->banner) : getImgUrl(getDsMetas(278));
	$bg_request = ($desc_guideCountry->banner_plants != '' ) ? getImgUrl($desc_guideCountry->banner_plants) : getImgUrl(getDsMetas(259));
	$breadcrumb = Breadcrumbs::render('countryGuide', $country);
	$icon_top =  asset('public/images/icons/tips/tips-white.png');
	$title_top_h1 = $desc_guideCountry->title;
	$regions = getAllCountryByLevel(1);
    $durations = getListDuration();
    $styles = getAllCountryTourStyle();
@endphp
@extends('templates.master')
@section('content')
@section('title',$title_tag)
@section('description', $meta_value)
@section('keywords', $meta_key)
@section('image_url', $bg_img)
<div id="country-tips" class="country-travel-tip singe-post">
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
	<div class="content-places content-sec padding-top-mobi">
		<div class="container">
			<div class="top-intro text-center">{!! $desc_guideCountry->desc !!}</div>
		</div>
		<div class="essential @handheld light-graynvp @endhandheld">
			<div class="padding_center">
				<div class="container">
					<div class="header-sec text-center">
						<div class="title-sec">
							<h2 class="title pink">ESSENTIAL {{ $country->title }} TIPS & GUIDE</h2>
						</div>
					</div>
					@desktop
					<div class="row">
						<div class="col-md-6">
							{!! image( $desc_guideCountry->img_plant,'480','550',$desc_guideCountry->title ) !!}
						</div>
						@if(count($guides)>0)
							<div class="col-md-6">
								@foreach($guides as $key => $item)
								<h3 class="title pink font-semibold">{{ $item->title }}</h3>
								<div class="desc">
									{!! str_limit($item->desc, 270) !!}
									<a href="{{ route('postTypeCountryTravel', ['slug_country' => $country->slug,'slug' => $item->slug]) }}" class="font-semibold">More</a>
								</div>
								@endforeach
							</div>
						@endif
					</div>
					@elsedesktop
					<div class="slide-dost list-guide">
						@foreach($guides as $key => $item)
			                <div class="wrapper-item">
			                    <div class="item" style="background-image: url('{!! getImgUrl($item->image); !!}')">
			                        <h7 class="title-country white">{{$item->title}}</h7>
			                        @handheld
				                     <a class="link" href="{{ route('postTypeCountryTravel', ['slug_country'=>$country->slug ,'slug'=>$item->slug ]) }}"  rel="nofollow"></a>
				                    @endhandheld
			                        <div class="desc_hover">
			                        	<a class="link_traveltips" href="{{ route('postTypeCountryTravel', ['slug_country'=>$country->slug ,'slug'=>$item->slug ]) }}"></a>
			                            <div class="desc">
			                                <img class="bee" src="{{asset('public/images/bee/bee-white.png')}}" alt="bee-white"> 
			                                <h7 class="title_hover yellow">
			                                    {{$item->title}}
			                                </h7>
			                            </div>
			                        </div>
			                    </div>
			                </div>
						@endforeach
					</div>
					@enddesktop
				</div>
			</div>
		</div>
		@if($guides_v1)
			<div class="all_cities light-graybg">
				<div class="container">
					<div class="header-sec text-center">
						<div class="title-sec">
							<span class="title pink">MORE? WE HAVE IT ALL!</span>
						</div>
					</div>
					<ul class="list-cities">
						@foreach($guides_v1 as $item)
							<li class="item_places">
								<h3><a href="{{ route('postTypeCountryTravel', ['slug_country' => $country->slug,'slug' => $item->slug]) }}">{{ $item->title }}</a></h3>
							</li>
						@endforeach
					</ul>
				</div>
			</div>
		@endif
		<div class="special light-graynvp">
			<div class="container">
				<div class="header-sec text-center">
					<div class="title-sec">
						<h2 class="title pink">SPECIAL {{ $country->title }} TIPS & TOURS </h2>
					</div>
	            	<div class="desc_p">
						{!! $desc_guideCountry->content_tips !!} 
					</div>
				</div>
				<div class="content-guide">
					<div class="search-box white">
			        	<form action="" method="get" id="search-city">
							{!!csrf_field()!!}
							<input type="text" name="keyword" class="white" placeholder="Search for your nationality" data-action="{{ route('searchNationality', $country->slug) }}" autocomplete="off"/>
							<button type="submit" class="submit_cities"><img src="{{ asset('public/images/icons/all/loupe-white.png') }}" alt="loupe-white"></button>
							<div class="list-result list-place">
								<ul>
									@include('form.nations_tips_guide')
								</ul>
							</div>
						</form>
					</div>
					@if($list_nation)
						@desktop
							<div class="row list_orv grid">
								@php $image = ""; @endphp
								@foreach($list_nation as $key => $item)
								@php 
									if($key==0)
										$image = image($item->feature_image, 300, 320, $item->title);
									elseif($key==1 || $key==3)
										$image = image($item->feature_image, 300, 400, $item->title);
									elseif($key==2)
										$image = image($item->feature_image, 300, 360, $item->title);
									elseif($key==4)
										$image = image($item->feature_image, 300, 370, $item->title);
									else
										$image = image($item->feature_image, 300, 350, $item->title);
								@endphp
								<div class="col-md-4 wrap-item grid-item {{ $key}}">
									<div class="item">
		            					{!! $image !!}
			            				<h3 class="title-country white">{{$item->title}}</h3>
			            				<a class="link" href="{{ route('postTypeCountryTravel', ['slug_country' => $country->slug,'slug' => $item->slug]) }}"></a>
			            				<div class="desc_hover"> 
		                                    <div class="text-center">
		                                        <img class="bee" src="{{asset('public/images/bee/bee-white.png')}}"> 
		                                        <h7 class="title_hover yellow">{{$item->title}}</h7>
		                                    </div>
		                                </div>
		            				</div>
		            			</div>
								@endforeach
							</div>
						@elsedesktop
							<div class="slide-dost list_orv">
								@foreach($list_nation as $key => $item)
									<div class="wrapper-item">
						                <div class="item" style="background-image: url('{!! getImgUrl($item->feature_image); !!}')">
						                	<a class="link" href="{{ route('postTypeCountryTravel', ['slug_country' => $country->slug,'slug' => $item->slug]) }}"></a>
						                    <h7 class="title-country white">{{$item->title}}</h7>
						                </div>
						            </div>
								@endforeach
							</div>
						@enddesktop
					@endif
				</div>
			</div>
		</div>
		@if($list_nation_v1)
			<div class="all_cities light-graybg">
				<div class="container">
					<div class="header-sec text-center">
						<div class="title-sec">
							<span class="title pink">OTHER NATIONALITIES</span>
						</div>
					</div>
						<ul class="list-cities">
							@foreach($list_nation_v1 as $item)
								<li class="item_places">
									<h3><a href="{{ route('postTypeCountryTravel', ['slug_country' => $country->slug,'slug' => $item->slug]) }}">{{ $item->title }}</a></h3>
								</li>
							@endforeach
						</ul>
				</div>
			</div>
		@endif
		<div class="looking looking-tour-mobile"  style="background-image: url('<?php echo $bg_looking; ?>');">
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
				@include('parts.countryTourDetails.places-country')
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