@php
if(!$seo){
        $meta_key = $country->title . ' places to visit; Laos tourist destinations';
		$meta_value = 'All '. $country->title .' places to visit and must-see top tourist destinations that you do not want to miss. Recommended by our local travel experts, come and check it out!';
    }else{
        $meta_key = $seo->key;
        $meta_value = $seo->value;
    }
	$title_tag = (isset($country_place)) ? $country_place->title_tag : $country->title . ' best places to visit and must-see top tourist destinations';
	$bg_img = (isset($country_place) && $country_place->banner_country != '' ) ? getImgUrl($country_place->banner_country) : getImgUrl(getBannerPostByCountry('highlight', $country->id));
	$bg_looking = (isset($country_place) && $country_place->banner != '' ) ? getImgUrl($country_place->banner) : getImgUrl(getDsMetas(278));
	$bg_request = (isset($country_place) && $country_place->banner_plants != '' ) ? getImgUrl($country_place->banner_plants) : getImgUrl(getDsMetas(299)); 
	$breadcrumb = Breadcrumbs::render('countryPlaceToVisit', $country);
	$title_top_h1 = $country->title.' places to visit';
	$post_type_active = 'highlight';
@endphp
@extends('templates.master')
@section('content')
@section('title', $title_tag)
@section('description', $meta_value)
@section('keywords', $meta_key)
@section('image_url', $bg_img)

<div id="country-places-to-visit" class="singe-places">
    <div class="image-header" style="background-image: url(<?php echo $bg_img; ?>);">
	    <div class="wrap">
	        <div class="container">
	        	@if(isset($breadcrumb))
	                {!! $breadcrumb !!}
	            @endif
	            @if(isset($country_place))
	            	<h1 class="title-banner-1">{!! $country_place->title !!}</h1>
	            @else
	                <h1 class="title-banner-1">{{ $title_top_h1 }}</h1>
	            @endif
	            <div class="search-box white serch-cities">
	            	<form action="" method="get" id="search-city">
						{!!csrf_field()!!}
						<input type="text" name="keyword" class="white" placeholder="Search for a destination" data-action="{{ route('loadCities', $country->slug) }}" autocomplete="off"/>
						<button type="submit" class="submit_cities"><img src="{{ asset('public/images/icons/all/loupe-white.png') }}"></button>
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
	<div class="content-places content-sec">
		<div class="container">
			<div class="top-intro text-center">
				@if(isset($country_place))
	            	{!! $country_place->desc !!}
	            @endif
			</div>
		</div>
		<div class="maps">
			{!! $country->map !!}
		</div>
		<div class="popular_dest">
			<div class="container">
				<div class="header-sec text-center">
					<div class="title-sec">
						<span class="title pink">POPULAR DESTINATIONS</span>
					</div>
				</div>
				@php 
					$main_city = explode(',',$list_main_city->list_main_city);
					$item = array();
				@endphp
				@desktop
					@foreach($main_city as $key => $items)
						@php 
							$city_objs = getCountry($items);
							$item[] = $city_objs;
						@endphp
					@endforeach
					<div class="row">
		           		@if(isset($item[0]) && isset($item[1]))
			            	<div class="col-md-4 wrap-item">
			            		@if($item[0])
		            				<div class="item">
		            					{!!image($item[0]->image, 300, 300, $item[0]->title)!!}
			            				<h7 class="title-country white">{{$item[0]->title}}</h7>
			            				<a class="link" href="{{ route('postTypeCountryTravel', ['slug_country' => $country->slug,'slug' => $item[0]->slug]) }}"></a>
			            				<div class="desc_hover"> 
		                                    <div class="text-center">
		                                        <img class="bee" src="{{asset('public/images/bee/bee-white.png')}}"> 
		                                        <h7 class="title_hover yellow">{{$item[0]->title}}</h7>
		                                        <p class="white">{{$item[0]->short_desc}}</p>
		                                    </div>
		                                </div>
		            				</div>
	            				@endif
	            				@if($item[1])
		            				<div class="item">
		            					{!!image($item[1]->image, 300, 350, $item[1]->title)!!}
			            				<h7 class="title-country white">{{$item[1]->title}}</h7>
			            				<a class="link" href="{{ route('postTypeCountryTravel', ['slug_country' => $country->slug,'slug' => $item[1]->slug]) }}"></a>
			            				<div class="desc_hover"> 
		                                    <div class="text-center">
		                                        <img class="bee" src="{{asset('public/images/bee/bee-white.png')}}"> 
		                                        <h7 class="title_hover yellow">{{$item[1]->title}}</h7>
		                                        <p class="white">{{$item[1]->short_desc}}</p>
		                                    </div>
		                                </div>
		            				</div>
	            				@endif
	            			</div>
	        			@endif
	        			@if(isset($item[2]) && isset($item[3]))
			            	<div class="col-md-4 wrap-item">
			            		@if($item[2])
	            					<div class="item">
	            						{!!image($item[2]->image, 300, 350, $item[2]->title)!!}
	            						<h7 class="title-country white">{{$item[2]->title}}</h7>
	            						<a class="link" href="{{ route('postTypeCountryTravel', ['slug_country' => $country->slug,'slug' => $item[2]->slug]) }}"></a>
			            				<div class="desc_hover"> 
		                                    <div class="text-center">
		                                        <img class="bee" src="{{asset('public/images/bee/bee-white.png')}}"> 
		                                        <h7 class="title_hover yellow">{{$item[2]->title}}</h7>
		                                        <p class="white">{{$item[2]->short_desc}}</p>
		                                    </div>
		                                </div>
		                            </div>
		                         @endif
	            				@if($item[3])
	            					<div class="item">
	            						{!!image($item[3]->image, 300, 350, $item[3]->title)!!}
	            						<h7 class="title-country white">{{$item[3]->title}}</h7>
	            						<a class="link" href="{{ route('postTypeCountryTravel', ['slug_country' => $country->slug,'slug' => $item[3]->slug]) }}"></a>
			            				<div class="desc_hover"> 
		                                    <div class="text-center">
		                                        <img class="bee" src="{{asset('public/images/bee/bee-white.png')}}"> 
		                                        <h7 class="title_hover yellow">{{$item[3]->title}}</h7>
		                                        <p class="white">{{$item[3]->short_desc}}</p>
		                                    </div>
		                                </div>
		                            </div>
	            				@endif
	            			</div>
	        			@endif
	        			@if(isset($item[4]) && isset($item[5]))
			            	<div class="col-md-4 wrap-item">
	            				@if($item[4])
	            					<div class="item">
	            						{!!image($item[4]->image, 300, 280, $item[4]->title)!!}
	            						<h7 class="title-country white">{{$item[4]->title}}</h7>
	            						<a class="link" href="{{ route('postTypeCountryTravel', ['slug_country' => $country->slug,'slug' => $item[4]->slug]) }}"></a>
			            				<div class="desc_hover"> 
		                                    <div class="text-center">
		                                        <img class="bee" src="{{asset('public/images/bee/bee-white.png')}}"> 
		                                        <h7 class="title_hover yellow">{{$item[4]->title}}</h7>
		                                        <p class="white">{{$item[4]->short_desc}}</p>
		                                    </div>
		                                </div>
		                            </div>
	            				@endif
	            				@if($item[5])
	            					<div class="item">
	            						{!!image($item[5]->image, 300, 350, $item[5]->title)!!}
	            						<h7 class="title-country white">{{$item[5]->title}}</h7>
	            						<a class="link" href="{{ route('postTypeCountryTravel', ['slug_country' => $country->slug,'slug' => $item[5]->slug]) }}"></a>
			            				<div class="desc_hover"> 
		                                    <div class="text-center">
		                                        <img class="bee" src="{{asset('public/images/bee/bee-white.png')}}"> 
		                                        <h7 class="title_hover yellow">{{$item[5]->title}}</h7>
		                                        <p class="white">{{$item[5]->short_desc}}</p>
		                                    </div>
		                                </div>
		                            </div>
		                         @endif
	            			</div>
	        			@endif
					</div>
				@elsedesktop
					<div class="slide-dost list-places">
						@foreach($main_city as $key => $items)
							@php 
								$city_objs = getCountry($items);
								$style = $city_objs;
							@endphp
							<div class="wrapper-item">
				                <div class="item" style="background-image: url('{!! getImgUrl($style->image); !!}')">
				                	@handheld
				                	<a class="link" href="{{ route('postTypeCountryTravel', ['slug_country' => $country->slug,'slug' => $style->slug]) }}"></a>
				                	@endhandheld
				                    <h7 class="title-country white">{{$style->title}}</h7>
				                    <div class="desc_hover">
				                        <a class="link_traveltips" href="{{ route('postTypeCountryTravel', ['slug_country' => $country->slug,'slug' => $style->slug]) }}"></a>
				                        <div class="desc">
				                            <img class="bee" src="{{asset('public/images/bee/bee-white.png')}}"> 
				                            <h7 class="title_hover yellow">{{$style->title}}</h7>
				                            <p class="white">{!! $style->short_desc !!}</p>
				                        </div>
				                    </div>
				                </div>
				            </div>
						@endforeach
					</div>
				@enddesktop
			</div>
		</div>
		<div class="all_cities light-graybg">
			<div class="container">
				<div class="header-sec text-center">
					<div class="title-sec">
						<span class="title pink">MORE? WE HAVE IT ALL!</span>
					</div>
				</div>
				@if($list_city_alphabet)
				<ul class="list-cities">
					@foreach($list_city_alphabet as $item)
						<li class="item_places">
							<a href="{{ route('postTypeCountryTravel', ['slug_country' => $country->slug,'slug' => $item->slug]) }}">{{ $item->title }}</a>
						</li>
					@endforeach
				</ul>
				@endif
			</div>
		</div>
		<div class="looking looking-tour-mobile"  style="background-image: url('<?php echo $bg_looking; ?>');">
            @include('parts.countryTourDetails.search-tour-details')
        </div>
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
		<div class="plans-travels light-graybg padding_center">
			<div class="container">
				<div class="header-sec text-center">
					<div class="title-sec">
						<h2 class="title pink">{{ $country->title }} PLANS BY TRAVEL THEME</h2>
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
		<div class="request back-none" style="background-image: url('<?php echo $bg_request; ?>')">
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
		<!--Blog Section-->
		<div class="section-blog slide_owl light-graynvp padding_center">
			<div class="container">
				<div class="header-sec text-center">
					<div class="title-sec">
						<span class="title pink">{{ $country->title }} BLOG ARTICLES</span>
					</div>
				</div>
				@php
					$list_blog = getListArticleByCountry($country->id,6);
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
		<!--End Blog Section-->
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