@php
	$meta_key = $country->title . ' culture guide';
	$meta_value = 'Want to reveal all the secret traditions & insight etiquette in '. $country->title .'? Check out the culture guide to dig in the local life and unforgettable experience';
	$seo_title =  $country->title . ' culture guide: reveal to all the secret traditions & insight etiquette';

	$bg_img = getImgUrl(getBannerPostByCountry('cultural', $country->id)); 
	$breadcrumb = Breadcrumbs::render('countryCultural', $country);
	$icon_top =  asset('public/images/icons/cultural/cultural-white.png');
	$title_top_h1 = $country->title.' Cultural insights';
	$post_type_active = 'cultural';
@endphp

@extends('templates.master')
@section('content')
@section('title', $seo_title)
@section('description', $meta_value)
@section('keywords', $meta_key)
@section('image_url', $bg_img)

<div class="country-cultural">
    @include('layouts.top_banner')
	@include('countries.groupTopButton')
	<div class="container">
		<p class="top-intro text-center font-semibold">
			Aiming to share our passion of Laos, we gather here general infomation and anecdotes for you to better understand the country's cultural, people and story.
		</p>
	</div>
	@if(count($guides)>0)
		@php
			$list_fourItem = $guides;
		@endphp
		<div class="section">
			<h2 class="title-page yellow text-center">
				<img src="{{ asset('public/images/icons/all/information-yellow.png') }}" alt="icon">
				<span>
					Essential Infomation for {{ $country->title }}					
				</span>
			</h2>
			<div class="has-bg-under">
				<div class="bg-under light-graybg yellow-right"></div>
				<div class="container">
					<div class="list-four-sec">
						@include('layouts.section-four-item')
					</div>
				</div>
			</div>
		</div>
	@endif

	@if(count($guides) > 4)
	<div class="section">
		<div class="container">
			<div class="more-travel-tips">
				<h2 class="title-page green text-center">
					<img src="{{asset('public/images/icons/cultural/cultural-blue.png')}}" alt="icon">
					<span>
						More {{ $country->title }} cultural guide					
					</span>
				</h2>
				<div class="group-more">
					<div class="row">
						@for($i=4; $i < count($guides); $i++)
							<div class="col-md-4">
								<div class="item font-semibold">
									<div class="icons">
										<img src="{{ getImgUrl($guides[$i]->gray_icon) }}" alt="icon" class="icon" />
										<img src="{{ getImgUrl($guides[$i]->green_icon) }}" alt="icon" class="icon hover" />
									</div>
									<h4 class="title"><a href="#">{{ $guides[$i]->short_title }}</a></h4>
								</div>
							</div>
						@endfor
					</div>
				</div>
			</div>
		</div>
	</div>
	@endif
	
	@if($related_articles)
		<div class="section related-tours">
			<div class="container">
				<h2 class="title-page pink text-center">
					<img src="{{asset('public/images/icons/all/blog-pink.png')}}" alt="icon">
					<span>
						{{ __('Our blog latest article about ') . $country->title }}					
					</span>
				</h2>

				<div class="slide-style list-blog pink">
					@foreach($related_articles as $item)
						@include('articles.item')
					@endforeach
				</div>
			</div>
		</div>
	@endif

	<div class="section related-tours">
		<div class="container">
			<h2 class="title-page yellow text-center">
				<img src="{{asset('public/images/icons/all/tour-yellow.png')}}" alt="icon">
				<span>
					{{ __('To discover ').$country->title }}					
				</span>
			</h2>
			@if($related_tours)
				<div class="list-related list-tour-1 yellow">
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
			@endif
			<div class="text-center">
				<a href="#" class="btn-page yellowbg">
					<span>View more</span>
				</a>
			</div>
		</div>
	</div>
</div>

@stop