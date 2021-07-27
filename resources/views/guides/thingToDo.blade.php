@php
	$meta_key = ($seo && $seo->key != '') ? $seo->key : '';
	$meta_value = ($seo && $seo->value != '') ? $seo->value : '';
@endphp
@extends('templates.master')
@section('content')
@section('title', $guide->title_tag)
@section('description', $meta_key)
@section('keywords', $meta_value)
@section('image_url', getImgUrl($guide->image))
@php	
	$country = getCountryById($guide->country_id);
	$tableContent = getTableContent($guide->id, 'guide');
	$bg_img = getImgUrl($guide->image);
	//$icon_top = getImgUrl($guide->white_icon);
	$breadcrumb = Breadcrumbs::render('detailThingToDo', $country, $guide->short_title);
	$title_top_h1 = $guide->title;
	$post_type_active = 'thing_to_do';
	$include_searchBox = 'guides.searchbox_thingToDo';
@endphp
<div class="detail-travel-tip singe-post">
	@include('layouts.top_banner')
	@include('countries.groupTopButton')
	<div class="content-page">
		<div class="container">
			<div class="top-intro text-center font-semibold">{!! $guide->desc !!}</div>
		</div>

		@if($related_tours)
		<div class="section related-tours">
			<div class="container">
				<h2 class="title-page green text-center">
					<img src="{{asset('public/images/icons/all/tour-green.png')}}" alt="icon">
					<span>
						Our {{ $country->title }} tour packages including "{{ getCatGuide($guide->cat_id)->title }}"			
					</span>
				</h2>
				<div class="list-related list-tour-1 green">
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
					<a href="#" class="btn-page greenbg">
						<span>View all {{ $country->title }} tour packages</span>
					</a>
				</div>
			</div>
		</div>
		@endif

		@if($list_highlight)
		<div class="section">
			<div class="container">
				<h2 class="title-page pink text-center">
					<img src="{{ asset('public/images/icons/all/location2-pink.png') }}" alt="icon">
					<span>
						Where to find "{{ getCatGuide($guide->cat_id)->title }}" in {{ $country->title }} ?
					</span>
				</h2>
				<div class="slide-style list-highlight list-highlight-2 pink">
					@foreach($list_highlight as $item_city)
						@include('countries.highlights.highlight-thing-to-do-item')
					@endforeach
				</div>
			</div>
		</div>
		@endif

		@if($list_travelTip)
			@php
				$list_fourItem = $list_travelTip;
			@endphp
			<div class="section">
				<div class="container">
					<div class="title-sec text-center small-w">
						<h2 class="title-page pink text-center">
							<img src="{{ asset('public/images/icons/tips/tips-pink.png') }}" alt="icon" />
							<span>
								{{ $country->title }} travel tips & guide
							</span>
						</h2>
						<p>You would like to gain a deeper knowledge of {{ $country->title }} and its culture? Have a look at our cultural insight for your destination !</p>
					</div>
				</div>
				<div class="has-bg-under">
					<div class="bg-under light-graybg pink-right"></div>
					<div class="container">
						<div class="list-four-sec">
							@include('layouts.section-four-item')
						</div>
					</div>
				</div>
				<div class="container">
					<div class="text-center">
						<a href="#" class="btn-page pinkbg">
							<span>View all {{ $country->title }} tips & guide</span>
						</a>
					</div>
				</div>
			</div>
		@endif

		@if($list_ortherThingsToDo)
			<div class="section">
				<div class="container">
					<h2 class="title-page yellow text-center">
						<img src="{{ asset('public/images/icons/all/itinerary-yellow.png') }}" alt="icon">
						<span>
							Check out other things to do in {{ $country->title }}
						</span>
					</h2>
					<div class="more-travel-tips">
						<div class="group-more">
							<div class="row">
								@foreach($list_ortherThingsToDo as $item)
									<div class="col-md-4">
										<div class="item font-semibold">
											<div class="icons">
												<img src="{{ getImgUrl($item->gray_icon) }}" alt="icon" class="icon" />
												<img src="{{ getImgUrl($item->yellow_icon) }}" alt="icon" class="icon hover" />
											</div>
											<h4 class="title yellow">
												<a href="{{ $item->getPermalink() }}">
													{{ $item->short_title }}
												</a>
											</h4>
										</div>
									</div>
								@endforeach
							</div>
						</div>
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
</div>

@stop