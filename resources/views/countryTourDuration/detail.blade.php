@php
	$meta_key = $meta_value = '';
	$seo = $seo = get_seo($country_tourDuration->id,'country_tour_duration');
	if($seo){
		$meta_key = $seo->key;
		$meta_value = $seo->value;
	}	
	//dd($seo); 
	$bg_img =  getImgUrl($country_tourDuration->image); 
	$icon_top = getImgUrl($country_tourDuration->duration->white_icon);
	$breadcrumb = Breadcrumbs::render('countryTourDuration', $country, $duration->title);
	$title_top_h1 = $country_tourDuration->title;
	$post_type_active = 'tour';
	$list_content = json_decode($country_tourDuration->list_content);
	$bg_looking = ($country_tourDuration->image_looking != '' ) ? getImgUrl($country_tourDuration->image_looking) : getImgUrl(getDsMetas(278));
	$bg_request = ($country_tourDuration->image_request != '' ) ? getImgUrl($country_tourDuration->image_request) : getImgUrl(getDsMetas(259));
@endphp

@extends('templates.master')
@section('content')
@section('title', $country_tourDuration->title_tag)
@section('description', $meta_value)
@section('keywords', $meta_key)
@section('image_url', $bg_img)

<div id="country-tour-duration" class="single-tour style-duration">
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
            {!! $country_tourDuration->desc !!}
		</div>
	</div>
	@if(isset($list_tour) && count($list_tour) > 0)
	<div class="filter-tour-style light-graynvp slide_owl">
		<div class="container">
			<div class="header-sec text-center">
				<div class="title-sec">
					<h2 class="title pink">{{ $country->title }} TOUR PLANS IN {{ $duration->title }}</h2>
				</div>
			</div>
			<div class="wrap-filter">
				@desktop
				<div class="gr-filter">
					<form action="{{ route('filterTour2') }}" method="POST">
					{{ csrf_field() }}
					<input type="hidden" name="current_country_id" value="{{ $country->id }}">
					<input type="hidden" name="duration_id" value="{{ $country_tourDuration->duration_id }}">
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
						<div class="box-item tour-style">
							<span class="title">Tour style</span>
							<ul class="list-unstyled">
								@foreach($list_tourstyle as $tour_style)
									<li>
										<label for="duration-{{ $tour_style->id }}">
											<input type="radio" class="filter-value" id="duration-{{ $tour_style->id }}" name="array_tourstyle_id[]" value="{{ $tour_style->id }}">
											{{ $tour_style->title }}
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
					<form action="{{ route('filterTour2') }}" method="POST"  class="nvp-mobi-form">
					{{ csrf_field() }}
					<input type="hidden" name="current_country_id" value="{{ $country->id }}">
					<input type="hidden" name="duration_id" value="{{ $country_tourDuration->duration_id }}">
					<input type="hidden" name="type_result" value="slide">
					
					<span class="filter-title graybg">						
						<img src="{{ asset('public/images/icons/filter/filter-white.png') }}" alt="icon-filter">Filter
					</span>
					<a href="#" class="btn-reset graybg">
						<span class="img_reset"><img src="{{ asset('public/images/icons/filter/reset_white.png') }}" alt="icon-filter"></span>
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
						<div class="box-item tour-style graybg">
							<span class="title">Tour style</span>
							<ul class="list-unstyled">
								@foreach($list_tourstyle as $tour_style)
									<li>
										<label for="duration-{{ $tour_style->id }}">
											<input type="radio" class="filter-value" id="duration-{{ $tour_style->id }}" name="array_tourstyle_id[]" value="{{ $tour_style->id }}">
											{{ $tour_style->title }}
										</label>
									</li>
								@endforeach
							</ul>
						</div>
					</div>
					
					</form>
				</div>
				@enddesktop
				
				<div class="tour_craft @desktop slide-style @elsedesktop slide-tour-dost @enddesktop">
					@foreach($list_tour as $tour)
						@include('tours.related_item')
					@endforeach
				</div>
			</div>
			<div class="bot-tour">
                <a href="{{ route('countryTour', ['slug_country' => $country->slug]) }}" class="btn btn-tour">{{ $country->title }} tour packages</a>
            </div>
		</div>
	</div>
	@endif
	<div class="content-places">
		<div class="recommendec slide_owl padding_center">
			<div class="container">
				<div class="header-sec text-center">
					<div class="title-sec">
						<h2 class="title pink">RECOMMENDED ROUTES TO VISIT {{ $country->title }} IN <br>{{ $duration->title }}</h2>
					</div>
					<div class="desc_p">
						{{ $country_tourDuration->text_list_content }}
					</div>
				</div>
				@if($list_content)
					<div class="duration_nvp @desktop slide-style @elsedesktop slide-dost @enddesktop">
						@foreach($list_content as $number => $item)
							@include('parts.table-content-duration')
						@endforeach
					</div>
					@handheld
						<div class="desc-style">
					  		@if($list_content)
					      		@foreach($list_content as $number =>$item)
					      		<div class="desc-content">
						      		<div class="graybg wrapper_scroll">
						      			<img class="cross-mobi cross__{{ $number }}" src="{{asset('public/images/icons/Cross_Yellow.png')}}" alt="Cross-white">
				      					<div class="desc_vp desc__{{ $number }}">
				      						<div class="padding_croll">
				      							<h7 class="title yellow">{!! $item->title !!}</h7>
				      							<div class="desc">
				      								{!! $item->content !!}
				      							</div>
								      			<div class="list_city_n1">
								      				@php
								      					$router = $item->list_city;
								      				@endphp
								      				<span class="font-semibold yellow">Route:</span>
								      				@if($router)
									      				@foreach($router as $key => $route)
									      					@php 
									      						$abc ='>>';
									      						$list_router= getCountryV1($route);
									      					@endphp
									      						<a href="{{ route('postTypeCountryTravel', ['slug_country'=>$country->slug,'slug'=>$list_router->slug ]) }}">{{ $list_router->title }} {{($key!=count($router)-1) ? $abc : '' }}</a>
									      				@endforeach
									      			@endif
								      			</div>
								      			<div class="list_style_n1">
								      				@php
								      					$styles = $item->list_style;
								      				@endphp
								      				<span class="font-semibold yellow">Experience:</span>
								      				@if($styles)
									      				@foreach($styles as $key => $style)
									      					@php 
									      						$abc ='/';
									      						$list_style= getTourStyleId($style);
									      					@endphp
									      						<a href="{{ route('tour', ['slug_country'=>$country->slug,'slug'=>$list_style->slug ]) }}">{{ $list_style->title }} {{($key!=count($styles)-1) ? $abc : '' }}</a>
									      				@endforeach
								      				@endif
								      			</div>
								      			<div class="list_tour_n1">
								      				@php
								      					$tours = $item->list_tour;
								      				@endphp
								      				<span class="font-semibold  yellow">Sample tour packages:</span>
								      				@if($tours)
									      				@foreach($tours as $key => $tour)
									      					@php 
									      						$abc ='/';
									      						$list_tour= getTourByID($tour);
									      					@endphp
									      						<a href="{{ route('tour', ['slug_country'=>$country->slug , 'slug'=>$list_tour->slug]) }}">{{ $list_tour->title }} {{($key!=count($tours)-1) ? $abc : '' }}</a>
									      				@endforeach
								      				@endif
								      			</div>
								      		</div>
							      		</div>
							      		<div class="button-mobile button__{{ $number }}">	
							      			<a class="btn btn-map-mobi" href-key="{{ $number }}">VIEW MAP</a>
							      		</div>
				      				</div>
				      			</div>
								@endforeach
							@endif
						</div>
						<div class="map-duration-mobi">
					  		@if($list_content)
					      		@foreach($list_content as $number =>$item)
					      		<div class="desc-content">
				      				<div class="list_map map__{{ $number }}">
				      					<img class="cross-gallery" src="{{asset('public/images/icons/Cross_Yellow.png')}}" alt="Cross-white">
										{!! $item->map !!}
									</div>
					      		</div>
								@endforeach
							@endif
						</div>
					@endhandheld
				@endif
			</div>
		</div>
		<div class="request mar_nvp" style="background-image: url('<?php echo $bg_looking; ?>')">
			<div class="container">
				<div class="list-request">
					<div class="row item-request">
						<div class="col-md-5 left-item item">
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
					@if(isset($desc_tourCountry))
		            	<div class="desc_p">
							{!! $desc_tourCountry->content_ready_yet !!}
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
		<div class="bot-tour top-bot light-graynvp">
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
						<span class="title pink">{{ $country->title }} Plans by OTHER Time Frames</span>
					</div>
				</div>
				@include('parts.countryTourDetails.list_duration')
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
<div id="detail-style" class="modal fade" role="dialog">
	<div class="modal_gall_top">
  		@if($list_content)
      		@foreach($list_content as $number =>$item)
      		<div class="row">
      			<div class="col-md-5 col">
      				<div class="graybg wrapper_scroll white">
      					<div class="desc_vp desc__{{ $number }}">
      						<div class="padding_croll">
      							<h7 class="title yellow">{!! $item->title !!}</h7>
      							<div class="desc">
      								{!! $item->content !!}
      							</div>
				      			<div class="list_city_n1">
				      				@php
				      					$router = $item->list_city;
				      				@endphp
				      				<span class="font-semibold yellow">Route:</span>
				      				@if($router)
					      				@foreach($router as $key => $route)
					      					@php 
					      						$abc ='>>';
					      						$list_router= getCountryV1($route);
					      					@endphp
					      						<a href="{{ route('postTypeCountryTravel', ['slug_country'=>$country->slug,'slug'=>$list_router->slug ]) }}">{{ $list_router->title }} {{($key!=count($router)-1) ? $abc : '' }}</a>
					      				@endforeach
					      			@endif
				      			</div>
				      			<div class="list_style_n1">
				      				@php
				      					$styles = $item->list_style;
				      				@endphp
				      				<span class="font-semibold yellow">Experience:</span>
				      				@if($styles)
					      				@foreach($styles as $key => $style)
					      					@php 
					      						$abc ='/';
					      						$list_style= getTourStyleId($style);
					      					@endphp
					      						<a href="{{ route('tour', ['slug_country'=>$country->slug,'slug'=>$list_style->slug ]) }}">{{ $list_style->title }} {{($key!=count($styles)-1) ? $abc : '' }}</a>
					      				@endforeach
				      				@endif
				      			</div>
				      			<div class="list_tour_n1">
				      				@php
				      					$tours = $item->list_tour;
				      				@endphp
				      				<span class="font-semibold  yellow">Sample tour packages:</span>
				      				@if($tours)
					      				@foreach($tours as $key => $tour)
					      					@php 
					      						$abc ='/';
					      						$list_tour= getTourByID($tour);
					      					@endphp
					      						<a href="{{ route('tour', ['slug_country'=>$country->slug , 'slug'=>$list_tour->slug]) }}">{{ $list_tour->title }} {{($key!=count($tours)-1) ? $abc : '' }}</a>
					      				@endforeach
				      				@endif
				      			</div>
				      		</div>
			      		</div>
      				</div>
      			</div>
      			<div class="col-md-7 col">
      				<div class="list_map map__{{ $number }}">
						{!! $item->map !!}
					</div>
      			</div>
      		</div>
			@endforeach
		@endif
	</div>	
</div>
@endsection

