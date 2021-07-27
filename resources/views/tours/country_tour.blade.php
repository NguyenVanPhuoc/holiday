@php
	$meta_key = $country->title . ' Tour Package';
	$meta_value = (isset($desc_tourCountry) && $desc_tourCountry->desc  != '' ) ? $desc_tourCountry->desc :  $country->title . ' Tour Package';
	$title_tag = (isset($desc_tourCountry) && $desc_tourCountry->title_tag  != '' ) ? $desc_tourCountry->title_tag : $country->title . ' Tour Package';
	$bg_img =  (isset($desc_tourCountry) && $desc_tourCountry->banner_country != '' ) ? getImgUrl($desc_tourCountry->banner_country) : getImgUrl(getBannerPostByCountry('tour', $country->id));
	$breadcrumb = Breadcrumbs::render('countryTour', $country);
	$title_top_h1 = (isset($desc_tourCountry) && $desc_tourCountry->title  != '' ) ? $desc_tourCountry->title : $country->title . ' Tour Packages';
	$bg_looking = (isset($desc_tourCountry) && $desc_tourCountry->banner != '' ) ? getImgUrl($desc_tourCountry->banner) : getImgUrl(getDsMetas(278));
	$bg_request = (isset($desc_tourCountry) && $desc_tourCountry->banner_plants != '' ) ? getImgUrl($desc_tourCountry->banner_plants) : getImgUrl(getDsMetas(259));
	$array_current = isset($_GET['child_cou']) && $_GET['child_cou'] != '' ? explode(',',$_GET['child_cou']) : [];
	$array_style = isset($_GET['cat_id']) && $_GET['cat_id'] != '' ? explode(',',$_GET['cat_id']) : [];
@endphp
@extends('templates.master')
@section('content')
@section('title', $title_tag)
@section('description', $meta_value)
@section('keywords', $meta_key)
@section('image_url', $bg_img)
<div class="package-tours singe-post" id="country_tour">
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
	<div class="section padding-top-mobi">
		<div class="container">
			<div class="text-intro text-center desc_top_p">{!! $desc_tourCountry->desc !!}</div>
		</div>
	</div>
	@if(isset($list_tour))
	<div class="content-country-tour gr-tour-sec light-graynvp">
		@desktop
		<div class="container wrap-filter">
			<div class="row">
				<div id="sidebar" class="col-md-3">
					<div class="np-tour-sec tour-desktop">
						<div class="gr-filter">
							<form action="{{ route('filterTour2') }}" method="POST">
							{{ csrf_field() }}
								<input type="hidden" name="current_country_id" value="{{ $country->id }}">
								<input type="hidden" name="value" value="6" class="value-vp">
								<div class="filter-name graybg font-semibold">
									<span class="icon"><img src="{{ asset('public/images/icons/filter/filter-yellow.png') }}" alt="icon-filter"></span>
									Filter
								</div>
								<div class="list-filter light-graybg filter-tour">
									<div class="check_item box-item region">
										<h2 class="title">Region</h2>
										<ul class="list-region list-unstyled">
											@foreach($list_region as $region)
												<li {{ $array_current && in_array($region->id, $array_current) ? ' class=active' : '' }}>
													<label for="region-{{ $region->id }}">
														<input type="checkbox" class="filter-value" id="region-{{ $region->id }}" name="array_country_id[]" value="{{ $region->id }}" @if(in_array($region->id, $array_current)) checked @endif>
														<h3 class="title_vp">{{ $region->title }} ({{ countTourByCountryId($region->id) }})</h3>
													</label>
												</li>
											@endforeach
										</ul>
									</div>
									<div class="check_item box-item duration single-value">
										<h2 class="title">Duration</h2>
										<ul class="list-duration list-unstyled">
											@foreach($list_duration as $duration)
												<li {{ isset($_GET['duration_id']) && ($duration->id == $_GET['duration_id']) ? ' class=active' : '' }}>
													<label for="duration-{{ $duration->id }}">
														<input type="radio" class="filter-value" id="duration-{{ $duration->id }}" name="duration_id" value="{{ $duration->id }}" {{ isset($_GET['duration_id']) && ($duration->id == $_GET['duration_id']) ? 'checked' : '' }}  >
														<h3 class="title_vp">{{ $duration->title }} ({{ countTourByDurationId($duration->id, $country->id)}})</h3>
													</label>
												</li>
											@endforeach
										</ul>
									</div>
									<div class="check_item box-item tour-style">
										<h2 class="title">Tour style</h2>
										<ul class="list-style list-unstyled">
											@foreach($list_tour_style as $tour_style)
												<li {{ $array_style && in_array($tour_style->id, $array_style) ? ' class=active' : '' }}>
													<label for="tourstyle-{{ $tour_style->id }}">
														<input type="checkbox" class="filter-value" id="tourstyle-{{ $tour_style->id }}" name="array_tourstyle_id[]" value="{{ $tour_style->id }}" @if(in_array($tour_style->id, $array_style)) checked @endif>
														<h3 class="title_vp">{{ $tour_style->title }} ({{ countTourByCatId($tour_style->id, $country->id)}})</h3>
													</label>
												</li>
											@endforeach
										</ul>
									</div>
								</div>
								<a href="#" class="btn-reset graybg">
									<span class="img_reset"><img src="{{ asset('public/images/icons/filter/reset_yellow.png') }}" alt="icon-filter"></span>
									Reset
								</a>
							</form>
						</div>
					</div>
					<div class="content-guide">
						<div class="sb-contact">
							<a href="#" class="thumb"><img src="{{asset('public/images/request-free-sub.jpg')}}" alt="bigg_icon"></a>
							<div class="desc-contact">
								<span class="guaranteed">24-hour response guaranteed</span>
								<a href="{{ route('createMyTrip') }}" title="" class="btn btn-request">request a free quote</a>
							</div>
						</div>
					</div>
				</div>
				<div id="content" class="col-md-9">
					<div class="wrap-result">
						<div class="per-page-vp has-select graybg">
							{{ csrf_field() }}
							View
							<div class="list-per-page">
							<span class="value chose-value" data-value="6" data-href="{{ route('loadMoreTourCountry',['slug'=>$country->slug]) }}">6</span>
							per page
								<ul name="per-page" class="popup-filter">
									<li data-value="6">6</li>
									<li data-value="12">12</li>
									<li data-value="24">24</li>
									<li data-value="48">48</li>
								</ul>
							</div>
							<input type="hidden" name="total" value="{{ $total }}">
						</div>
						<div class="filter-nvp">
							@include('tours.list-result')
						</div>
					</div>
				</div>
			</div>
		</div>
		@elsedesktop
		<div class="wrap-filter">
			<div class="np-tour-sec tour-mobile">
				<div class="sec-tour-mobi graybg text-center">
					<span class="filter-sec">FILTER YOUR SEARCH</span>
				</div>
				<div class="gr-filter clearfix">
					<form action="{{ route('filterTour2') }}" method="POST">
					{{ csrf_field() }}
						<input type="hidden" name="current_country_id" value="{{ $country->id }}">
						<input type="hidden" name="value" value="6" class="value-vp">
						<div class="list-filter light-graybg filter-tour">
							<div class="check_item box-item region">
								<h2 class="title">Region</h2>
								<ul class="list-region list-unstyled">
									@foreach($list_region as $region)
										<li {{ $array_current && in_array($region->id, $array_current) ? ' class=active' : '' }}>
											<label for="region-{{ $region->id }}">
												<input type="checkbox" class="filter-value" id="region-{{ $region->id }}" name="array_country_id[]" value="{{ $region->id }}" @if(in_array($region->id, $array_current)) checked @endif>
												<h3 class="title_vp">{{ $region->title }} ({{ countTourByCountryId($region->id) }})</h3>
											</label>
										</li>
									@endforeach
								</ul>
							</div>
							<div class="check_item box-item duration single-value">
								<h2 class="title">Duration</h2>
								<ul class="list-duration list-unstyled">
									@foreach($list_duration as $duration)
										<li {{ isset($_GET['duration_id']) && ($duration->id == $_GET['duration_id']) ? ' class=active' : '' }}>
											<label for="duration-{{ $duration->id }}">
												<input type="radio" class="filter-value" id="duration-{{ $duration->id }}" name="duration_id" value="{{ $duration->id }}" {{ isset($_GET['duration_id']) && ($duration->id == $_GET['duration_id']) ? 'checked' : '' }}  >
												<h3 class="title_vp">{{ $duration->title }} ({{ countTourByDurationId($duration->id, $country->id)}})</h3>
											</label>
										</li>
									@endforeach
								</ul>
							</div>
							<div class="check_item box-item tour-style">
								<h2 class="title">Tour style</h2>
								<ul class="list-style list-unstyled">
									@foreach($list_tour_style as $tour_style)
										<li {{ $array_style && in_array($tour_style->id, $array_style) ? ' class=active' : '' }}>
											<label for="tourstyle-{{ $tour_style->id }}">
												<input type="checkbox" class="filter-value" id="tourstyle-{{ $tour_style->id }}" name="array_tourstyle_id[]" value="{{ $tour_style->id }}" @if(in_array($tour_style->id, $array_style)) checked @endif>
												<h3 class="title_vp">{{ $tour_style->title }} ({{ countTourByCatId($tour_style->id, $country->id)}})</h3>
											</label>
										</li>
									@endforeach
								</ul>
							</div>
						</div>
						<a href="#" class="btn-reset graybg">
							<span><img src="{{ asset('public/images/icons/filter/reset_white.png') }}" alt="icon-filter"></span>
							Reset
						</a>
					</form>
				</div>
			</div>
			<div class="wrap-result result-mobi">
				<div class="filter-nvp">
					@include('tours.list-result')
				</div>
			</div>
		</div>
		@enddesktop
	</div>
	@endif
	<div class="content-single content-places">
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
				@if(isset($desc_tourCountry))
            	<div class="desc_p">
					{!! $desc_tourCountry->content_ready_yet !!}
				</div>
	            @endif
			</div>
		</div>
	</div>
	<div class="places-to-visit light-graybg padding_center slide_owl">
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
				@if(isset($desc_tourCountry))
	            	<div class="desc_p">
						{!! $desc_tourCountry->content_tips !!}
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
	<div class="another_country">
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
@endsection