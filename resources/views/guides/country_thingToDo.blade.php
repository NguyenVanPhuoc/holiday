@php 
	$meta_key = 'things to do in ' . $country->title;	
	$meta_value = 'The complete guide about things to do in '. $country->title .' from family fun to local immersion; from couple romantic to the amazing exploration; and more that you can expect';	
	$seo_title = 'Best things to do in ' . $country->title . ' - the top guide of what you can expect';

	$bg_img = getImgUrl(getBannerPostByCountry('thing_to_do', $country->id)); 
	$breadcrumb = Breadcrumbs::render('countryThingsToDo', $country);
	$icon_top =  asset('public/images/icons/things-to-do/things-to-do-white.png');
	$title_top_h1 = 'Things to do in ' . $country->title;
	$post_type_active = 'thing_to_do';
@endphp
@extends('templates.master')
@section('content')
@section('title', $seo_title)
@section('description', $meta_value)
@section('keywords', $meta_key)
@section('image_url', $bg_img)

<div class="country-things-to-do">
    @include('layouts.top_banner')
	@include('countries.groupTopButton')

	<div class="container">
		<p class="top-intro text-center font-semibold">
			Despite being not as known as its neighboring countries, {{ $country->title }} offers an incredible diversity of attractions and activities for everyone! Read more below and make a cross on every activity you would like to do !
		</p>
	</div>
	@if(count($guides)>0)
		@php
			$list_fourItem2 = $guides;
		@endphp
		<div class="section">
			<div class="container">
				<h2 class="title-page pink text-center">
					<img src="{{ asset('public/images/icons/all/number-one-pink.png') }}" alt="icon">
					<span>
						Top things to do in {{ $country->title }}					
					</span>
				</h2>
			</div>
			<div class="has-bg-under">
				<div class="bg-under light-graybg pink-right"></div>
				<div class="container">
					<div class="list-four-sec">
						@include('layouts.section-four-item-2')
					</div>
				</div>
			</div>
		</div>
	@endif

	@if(count($guides) > 4)
	<div class="section">
		<div class="container">
			<h2 class="title-page yellow text-center">
				<img src="{{asset('public/images/icons/all/what-to-do-yellow.png')}}" alt="icon">
				<span>
					More things to do in {{ $country->title }}					
				</span>
			</h2>
			<div class="more-travel-tips">
				<div class="group-more">
					<div class="row">
						@for($i=4; $i < count($guides); $i++)
							<div class="col-md-4">
								<div class="item font-semibold">
									<div class="icons">
										<img src="{{ getImgUrl($guides[$i]->gray_icon) }}" alt="icon" class="icon" />
										<img src="{{ getImgUrl($guides[$i]->yellow_icon) }}" alt="icon" class="icon hover" />
									</div>
									<h4 class="title">
										<a href="{{ route('postTypeCountryTravel', ['slug_country' => $country->slug,'slug' => $guides[$i]->slug]) }}">
											{{ $guides[$i]->short_title }}
										</a>
									</h4>
								</div>
							</div>
						@endfor
					</div>
				</div>
			</div>
		</div>
	</div>
	@endif

	@if(count($list_travelTip)>0)
		@php
			$list_fourItem = $list_travelTip;
		@endphp
		<div class="section">
			<div class="container">
				<div class="title-sec text-center small-w">
					<h2 class="title-page green text-center">
						<img src="{{ asset('public/images/icons/tips/tips-green.png') }}" alt="icon" />
						<span>
							Tips & guide in {{ $country->title }}
						</span>
					</h2>
					<p>{{ $country->text_quick_info }}</p>
				</div>
			</div>
			<div class="has-bg-under">
				<div class="bg-under light-graybg green-right"></div>
				<div class="container">
					<div class="list-four-sec">
						@include('layouts.section-four-item')
					</div>
				</div>
			</div>
		</div>
	@endif	

	@if($related_tours)
	<div class="section related-tours">
		<div class="container">
			<h2 class="title-page pink text-center">
				<img src="{{asset('public/images/icons/all/tour-pink.png')}}" alt="icon">
				<span>
					{{ $country->title }} tour packages				
				</span>
			</h2>
			
			<div class="list-related list-tour-1 pink">
				@foreach($related_tours as $tour)
					@php
						$slug_country = get_slug_country_of_tour($tour->id);
					@endphp
					<div class="item octagonal">
						<div class="wrap-octagonal">
							<a href="{{route('tour', ['slug_country'=>$slug_country,'slug'=>$tour->slug])}}" class="thumb">
								{!! image($tour->image, 410, 250, $tour->title) !!}
							</a>
							<h4>
								<a href="{{route('tour', ['slug_country'=>$slug_country,'slug'=>$tour->slug])}}">{{$tour->title}}</a>
							</h4>
						</div>
					</div>
				@endforeach
			</div>
			
			<div class="text-center">
				<a href="#" class="btn-page pinkbg">
					<span>View all {{ $country->title }} tour packages</span>
				</a>
			</div>
		</div>
	</div>
	@endif
	

	@if($list_consultants)
		<div class="section">
			<div class="container">
			@php
				(count($list_consultants) > 1) ? $class_consultant = 'slide-consultants ' : $class_consultant = '';
			@endphp
				<div class="p-x-100">
					<div class="consultants-country consultants counsultant-at-bot flex-list center-item light-graybg m-t-40">
						<div class="title font-semibold text-center">
							Meet our <br> {{ $country->title }} travel <br> consultants
						</div>
						<div class="consultant-content {{ $class_consultant }}">
							@foreach($list_consultants as $item)
								@include('consultants.item-slide')
							@endforeach
						</div>
						<a class="button flex-list center-item graybg" href="#">
							{!! imageAuto($country->icon, $country->title) !!}
							<span>View {{ $country->title }} tours</span>
						</a>
					</div>
				</div>
			</div>
		</div>
	@endif

</div>

@stop