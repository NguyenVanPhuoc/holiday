@php
	$meta_key = $country->title . ' accommodation';
	$meta_value = 'The collection of ' . $country->title . ' accommodation including hotels, guesthouse, B&Bs, Lodges, or homestay. Filter for your favorite location or facilities of your stay';
	$title_tag = $country->title . ' accommodation: hotels, guesthouses, B&Bs, Lodges, or homestay';	

	$bg_img = getImgUrl(getBannerPostByCountry('hotel', $country->id)); 
	$icon_top = asset('public/images/icons/all/hotel2-white.png');
	$breadcrumb = Breadcrumbs::render('countryHotel', $country);
	$title_top_h1 = $country->title . ' accommodation';
	$post_type_active = 'hotel';
@endphp

@extends('templates.master')
@section('js')
	<script src="{{ asset('/public/js/hotel.js') }}"  type="text/javascript"></script>
@endsection
@section('content')
@section('title', $title_tag)
@section('description', $meta_value)
@section('keywords', $meta_key)
@section('image_url', $bg_img)

<div class="country-hotel hotels">
    @include('layouts.top_banner')
	@include('countries.groupTopButton')
	<div class="container">
		<p class="top-intro text-center font-semibold">
			Get the fundamental practical information about weather, visa or transports to ensure you will spenda calm and stress-free trip
		</p>
	</div>
	<div class="section">
		<div class="container">
			<div class="hotel-content wrap-result">
				{!!csrf_field()!!}
				<input type="hidden" name="current_country" value="{{ $country->id }}">
				<input type="hidden" name="filter_hotel" value="{{ route('filterHotel') }}">
				<div class="row">
					<div class="col-md-3" id="sidebar">
						@include('sidebars.list_hotel')
					</div>
					<div class="col-md-9" id="content">
						<div class="filter-top pink font-semibold text-center">
							<div class="row">
								<div class="col-md-6">
									<div class="result">
										<img src="{{ asset('public/images/icons/filter/results-found-pink.png') }}" alt="icon">
										Result(s) found: 
										<span class="gray value">{{ $list_hotel->total() }}</span>
									</div>
								</div>
								<div class="col-md-6">
									<div class="per-page has-select">
										<img src="{{ asset('public/images/icons/filter/view-pink.png') }}" alt="icon">
										View
										<span class="gray value chose-value" data-value="8">8</span>
										per page
										<ul name="per-page" class="no-list-style gray popup-filter">
											<li data-value="8">8</li>
											<li data-value="16">16</li>
											<li data-value="24">24</li>
											<li data-value="32">32</li>
											<li data-value="40">40</li>
										</ul>
									</div>
								</div>
							</div>
						</div>
						@if($list_hotel)
							<div class="content-list-hotel">
								@include('hotels.content-list-hotel')
							</div>
						@endif
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-3 sidebar"></div>
				<div class="col-md-9 content">
					<!--Section Bottom-->
	        		<div class="sec-bottom light-graybg text-center imgbg imgbg-top-right-2">
	        			<div class="title">
	        				<span>Looking for more</span>
	        			</div>
	        			<div class="content-bot">
	        				<div class="icon">
	        					<img src="{{ asset('public/images/icons/all/easy-booking-steps-white.png') }}" alt="icon">
	        				</div>
	        				<p>Looking for a {{ $country->title }} tour package? We have it all for you</p>
	        				<a href="#" class="btn-page greenbg">
	        					<span>View all {{ $country->title }} tour package</span>
	        				</a>
	        			</div>
	        		</div>
	        		<!--End Section Bottom-->
				</div>
			</div>
		</div>
	</div>
</div>

@stop