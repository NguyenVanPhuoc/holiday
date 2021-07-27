@php
	$meta_key = $meta_value = '';
	$seo = $seo = get_seo($country_tourStyle->id,'country_tour_style');
	if($seo){
		$meta_key = $seo->key;
		$meta_value = $seo->value;
	}	

	$bg_img =  getImgUrl($country_tourStyle->image); 
	$icon_top = getImgUrl($tour_style->white_icon);
	$breadcrumb = Breadcrumbs::render('countryTourStyle', $country, $tour_style->title);
	$include_searchBox = 'countryTourStyles.search-box';
	$list_content = json_decode($country_tourStyle->list_content);
	$title_top_h1 = $country_tourStyle->title;
	$bg_looking = ($country_tourStyle->image_looking != '' ) ? getImgUrl($country_tourStyle->image_looking) : getImgUrl(getDsMetas(278));
	$bg_request = ($country_tourStyle->image_request != '' ) ? getImgUrl($country_tourStyle->image_request) : getImgUrl(getDsMetas(259)); 
@endphp

@extends('templates.master')
@section('content')
@section('title', $country_tourStyle->title_tag)
@section('description', $meta_value)
@section('keywords', $meta_key)
@section('image_url', $bg_img)
<div class="country-tour-style single-tour style-duration" id="tour-style">
    <div class="image-header" style="background-image: url(<?php echo $bg_img; ?>);">
	    <div class="wrap">
	        <div class="container">
	        	@if(isset($breadcrumb))
	                {!! $breadcrumb !!}
	            @endif
	            <div class="title_nvp">
		            <span class="title-banner-2">- {{ $country->title }} Tour Plan -</span>
		            @if(isset($title_top_h1))
		                <h1 class="title-banner-1">{{ $title_top_h1 }}</h1>
		            @endif
	            </div>
	            
	        </div>
	    </div>
	</div>
	<div class="container sec-desc">
		<div class="top-intro text-center">
            {!! $country_tourStyle->desc !!}
		</div>
	</div>
	@if(isset($list_tour) && count($list_tour) > 0)
	<div class="filter-tour-style light-graynvp slide_owl">
		<div class="container">
			<div class="header-sec text-center">
				<div class="title-sec">
					<h2 class="title pink">{{ $country->title }} "{{$tour_style->title}} Tours" COLLECTION</h2>
				</div>
			</div>
			
			<div class="wrap-filter">
				@desktop
				<div class="gr-filter">
					<form action="{{ route('filterTour2') }}" method="POST">
					{{ csrf_field() }}
					<input type="hidden" name="current_country_id" value="{{ $country->id }}">
					<input type="hidden" name="current_tourstyle_id" value="{{ $tour_style->id }}">
					<input type="hidden" name="type_result" value="slide">
					<span class="filter-title graybg">						
						<img src="{{ asset('public/images/icons/filter/filter-yellow.png') }}" alt="icon-filter">Filter
					</span>
					<div class="list-filter light-graybg">
						<div class="box-item region">
							<span class="title">Region</span>
							<ul class="list-unstyled">
								@foreach($list_region as $region)
									<li>
										<label for="region-{{ $region->id }}">
											<input type="checkbox" class="filter-value" id="region-{{ $region->id }}" name="array_country_id[]" value="{{ $region->id }}">
											{{ $region->title }}
										</label>
									</li>
								@endforeach
							</ul>
						</div>
						<div class="box-item duration single-value">
							<span class="title">Duration</span>
							<ul class="list-unstyled">
								@foreach($list_duration as $duration)
									<li>
										<label for="duration-{{ $duration->id }}">
											<input type="radio" class="filter-value" id="duration-{{ $duration->id }}" name="duration_id" value="{{ $duration->id }}">
											{{ $duration->title }}
										</label>
									</li>
								@endforeach
							</ul>
						</div>
					</div>
					<a href="#" class="btn-reset graybg">
						Reset
						<span class="img_reset"><img src="{{ asset('public/images/icons/filter/reset_yellow.png') }}" alt="icon-filter"></span>
					</a>
					</form>
				</div>
				@elsedesktop
				<div class="gr-filter">
					<form action="{{ route('filterTour2') }}" method="POST" class="nvp-mobi-form">
					{{ csrf_field() }}
					<input type="hidden" name="current_country_id" value="{{ $country->id }}">
					<input type="hidden" name="current_tourstyle_id" value="{{ $tour_style->id }}">
					<input type="hidden" name="type_result" value="slide">
					<span class="filter-title graybg">						
						<img src="{{ asset('public/images/icons/filter/filter-white.png') }}" alt="icon-filter">Filter
					</span>
					<a href="#" class="btn-reset graybg">
						<span class="img"><img src="{{ asset('public/images/icons/filter/reset_white.png') }}" alt="icon-filter"></span>
						Reset
					</a>
					<div class="list-filter">
						<div class="box-item region graybg">
							<span class="title">Region</span>
							<ul class="list-unstyled">
								@foreach($list_region as $region)
									<li>
										<label for="region-{{ $region->id }}">
											<input type="checkbox" class="filter-value" id="region-{{ $region->id }}" name="array_country_id[]" value="{{ $region->id }}">
											{{ $region->title }}
										</label>
									</li>
								@endforeach
							</ul>
						</div>
						<div class="box-item duration single-value graybg">
							<span class="title">Duration</span>
							<ul class="list-unstyled">
								@foreach($list_duration as $duration)
									<li>
										<label for="duration-{{ $duration->id }}">
											<input type="radio" class="filter-value" id="duration-{{ $duration->id }}" name="duration_id" value="{{ $duration->id }}">
											{{ $duration->title }}
										</label>
									</li>
								@endforeach
							</ul>
						</div>
					</div>
					</form>
				</div>
				@enddesktop
				@if($list_tour)
    				<div class="tour_craft @desktop slide-style @elsedesktop slide-tour-dost @enddesktop">
						@foreach($list_tour as $tour)
							@include('tours.related_item')
						@endforeach
					</div>
				@endif
			</div>
			<div class="bot-tour">
	            <a href="{{ route('countryTour', ['slug_country' => $country->slug]) }}" class="btn btn-tour">{{ $country->title }} tour packages</a>
	        </div>
		</div>
	</div>
	@endif
	<div class="content-single content-places slide_owl">
		<div class="activi padding_center">
			<div class="container">
				<div class="header-sec text-center">
					<div class="title-sec">
						<h2 class="title pink">ACTIVITIES FOR "{{$tour_style->title}} Tours" IN {{ $country->title }}</h2>
					</div>
					<div class="desc_p">
						{{$country_tourStyle->text_tour}}
					</div>
				</div>
				@if($list_attraction)
					<div class="attraction @desktop slide-style @elsedesktop slide-dost list-style @enddesktop">
						@foreach($list_attraction as $key => $item)
							@include('parts.list_attraction')
						@endforeach
					</div>
					@handheld
						<div class="desc-style">
					  		@if($list_attraction)
					      		@foreach($list_attraction as $key =>$item)
					      		<div class="desc-content">
				      				<div class="graybg wrapper_scroll">
				      					<img class="cross-mobi cross__{{ $key }}" src="{{asset('public/images/icons/Cross_Yellow.png')}}" alt="Cross-white">
				      					<div class="desc_vp desc__{{ $key }}">
				      						<div class="padding_croll ">
				      							<h7 class="title yellow">{!! $item->title !!}</h7>
								      			{!! $item->desc !!}
								      		</div>
							      		</div>
							      		<div class="button-mobile button__{{ $key }}">	
							      			<a class="btn btn-gallery-mobi" href-key="{{ $key }}">VIEW GALLERY</a>
							      		</div>
				      				</div>
					      		</div>
								@endforeach
							@endif
						</div>
						<div class="gallery-style-mobi">
					  		@if($list_attraction)
					      		@foreach($list_attraction as $key =>$item)
					      		<div class="desc-content">
				      				<div class="list_st_mobi gallery__{{ $key }}">
										@if($item->gallery)
											@php 
												$array_img = json_decode($item->gallery); 
											@endphp
											@if(count($array_img) > 0)
											@foreach($array_img as $key => $img_id)
												@php
													$img = getMedia($img_id);
												@endphp
												@if($img)
													<div class="item" style="background-image: url('{{asset('/public/uploads/'.$img->image_path)}}');">
														<img class="cross-gallery" src="{{asset('public/images/icons/Cross_Yellow.png')}}" alt="Cross-white">
														<div class="title_image">{{$key + 1}}/{{count($array_img)}} {{$img->title}}</div>
													</div>
												@endif
											@endforeach
											@endif
										@endif
									</div>
					      		</div>
								@endforeach
							@endif
						</div>
					@endhandheld
				@endif
			</div>
		</div>
		
		@if(isset($list_topCity))
			<div class="places-to-visit light-graynvp padding_center slide_owl">
				<div class="container">
					<div class="header-sec text-center">
						<div class="title-sec">
							<h2 class="title pink">WHERE FOR "{{$tour_style->title}} Tours" IN {{ $country->title }}</h2>
						</div>
						<div class="desc_p">
							{{$country_tourStyle->text_city}}
						</div>
					</div>
					<div class="@desktop slide-style @elsedesktop slide-dost @enddesktop list-places">
					    @foreach($list_topCity as $items)
				            <div class="wrapper-item">
				                <div class="item" style="background-image: url('{!! getImgUrl($items->image); !!}')">
				                    <h7 class="title-country white">{{$items->title}}</h7>
				                    <div class="desc_hover">
				                        <a class="link_traveltips" href="{{ route('postTypeCountryTravel', ['slug_country'=>$country->slug,'slug'=>$items->slug ]) }}"></a>
				                        <div class="desc">
				                            <img class="bee" src="{{asset('public/images/bee/bee-white.png')}}"> 
				                            <h3 class="title_hover yellow">{{$items->title}}</h3>
				                            <p class="white">{!! $items->short_desc !!}</p>
				                        </div>
				                    </div>
				                </div>
				            </div>
					    @endforeach
					</div>
				</div>
			</div>
			<div class="bot-tour top-bot">
		    <a href="{{ route('countryPlaceToVisit', ['slug_country' => $country->slug]) }}" class="btn btn-tour">{{ $country->title }} DESTINATIONS</a>
		</div>
		@endif
		<div class="request mar_nvp" style="background-image: url('<?php echo $bg_looking; ?>')">
			<div class="container">
				<div class="list-request">
					<div class="row item-request">
						<div class="col-md-5 item left-item">
							{!! image(getDsMetas(260),300,220,'image') !!}
						</div>
						<div class="col-md-7 text-center item">
							<span class="aplan yellow">24-hour response<br>guaranteed!</span>
							<a class="btn btn-request" href="{{ route('createMyTrip') }}">REQUEST A FREE QUOTE</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="tready-yet light-graynvp">
			<div class="container">
				<div class="header-sec text-center">
					<div class="title-sec">
						<span class="title pink">NOT READY YET?</span>
					</div>
	            	<div class="desc_p">
						Check below our detailed recommendation for other {{ $country->title }} travel themes and<br>
							what you can do based on the time frame you have
					</div>
				</div>
			</div>
		</div>
		<div class="plans-travels light-graybg padding_center">
			<div class="container">
				<div class="header-sec text-center">
					<div class="title-sec">
						<span class="title pink">{{ $country->title }} PLANS BY OTHER TRAVEL THEMES</span>
					</div>
				</div>
				@include('parts.countryTourDetails.list_tour_style_v2')
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
        <div class="request back-none" style="background-image: url('<?php echo $bg_request; ?>')">
			@php
				$img_request = getDsMetas(260);
				$title_request = getDsMetas(301);
			@endphp
			@include('parts.request')
		</div>
		<div class="preparing light-graynvp slide_owl padding_center">
			<div class="container">
				<div class="header-sec text-center">
					<div class="title-sec">
						<span class="title pink">{{ $country->title }} TRAVEL TIPS & GUIDE</span>
					</div>
					@if(isset($desc_tourCountry))
		            	<div class="desc_p">
							{!! $desc_tourCountry->content_tips !!}
						</div>
		            @endif
				</div>
				@include('parts.countryTourDetails.travel_tips_guide')
			</div>
		</div>
		<div class="section-blog slide_owl padding_center">
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
		<div class="another_country padding_center light-graynvp">
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
<div id="gallery-style" class="modal fade" role="dialog">
	<div class="modal_gall_top">
  		@if($list_attraction)
      		@foreach($list_attraction as $key =>$item)
      		<div class="row">
      			<div class="col-md-5 col">
      				<div class="graybg wrapper_scroll yellow">
      					<div class="desc_vp desc__{{ $key }}">
      						<div class="padding_croll">
      							<h7 class="title yellow">{!! $item->title !!}</h7>
				      			{!! $item->desc !!}
				      		</div>
			      		</div>
      				</div>
      			</div>
      			<div class="col-md-7 col">
      				<div class="list_st gallery__{{ $key }}">
						@if($item->gallery)
							@php 
								$array_img = json_decode($item->gallery); 
							@endphp
							@if(count($array_img) > 0)
							@foreach($array_img as $key => $img_id)
								@php
									$img = getMedia($img_id);
								@endphp
								@if($img)
									<div class="item" style="background-image: url('{{asset('/public/uploads/'.$img->image_path)}}');">
										<div class="title_image">{{$key + 1}}/{{count($array_img)}} {{$img->title}}</div>
									</div>
								@endif
							@endforeach
							@endif
						@endif
					</div>
      			</div>
      		</div>
			@endforeach
		@endif
	</div>	
</div>

@stop