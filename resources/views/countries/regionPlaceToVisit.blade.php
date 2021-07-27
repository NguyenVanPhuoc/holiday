@php
	$seo = get_seo($region->id, 'country');
	$meta_value = ($seo && $seo->value != null) ? $seo->value : '';	
@endphp

@extends('templates.master')
@section('content')
@section('title', $region->title . ' travel guide - Best time to visit - Things to do')
@section('description', $meta_value)
<div class="region-places-to-visit">
	@php 
		$bg_img = getImgUrl($region->image); 
		$breadcrumb = Breadcrumbs::render('regionPlaceToVisit', $country, $region->title);
		$icon_top = getImgUrl($region->icon);
		$title_top_h1 = $region->title . ' Travel Guide';
		$post_type_active = 'highlight';
		$list_bestTimeToVisit = json_decode($region->best_time_to_visit);
		$list_howToGet = json_decode($region->how_to_get);
		$list_whatToEat = json_decode($region->what_to_eat);
	@endphp
    @include('layouts.top_banner')
	@include('countries.groupTopButton')
	<div class="container">
		<p class="top-intro text-center font-semibold">{{ $region->desc }}</p>
	</div>

	<div class="map m-b-40">
		<div class="container">
			<h2 class="title-page pink text-center">
				<img src="{{ asset('public/images/icons/all/location2-pink.png') }}" alt="icon">
				<span>
					Map of {{ $region->title }}	
				</span>
			</h2>
			{!! $region->map !!}
		</div>
	</div>
	
	@if($list_bestTimeToVisit)
	<div class="section">
		<div class="container">
			<div class="p-x-100">
				<h2 class="title-page green text-center">
					<img src="{{ asset('public/images/icons/all/weather-green.png') }}" alt="icon">
					<span>
						Best time to visit "{{ $region->title }}"
					</span>
				</h2>
			</div>
			<div class="list-row-reverse-3">
				@foreach($list_bestTimeToVisit as $item)
					<div class="item">
						<div class="thumb">
							{!! image($item->image, 350, 250, $item->title) !!}
						</div>
						<div class="desc">
							<h3 class="title green">{{ $item->title }}</h3>
							<div class="text">{!! $item->content !!}</div>
							<a href="javascript:void(0)" class="readmore font-semibold green">Read more</a>
							<a href="javascript:void(0)" class="collap-btn font-semibold green">Collapse</a>
						</div>
					</div>
				@endforeach
			</div>
		</div>
	</div>
	@endif

	@if($list_howToGet)
	<div class="section">
		<div class="container">
			<div class="p-x-100">
				<h2 class="title-page yellow text-center">
					<img src="{{ asset('public/images/icons/all/car-yellow.png') }}" alt="icon">
					<span>
						How to get to {{ $region->title }}
					</span>
				</h2>
			</div>
			<div class="list-row-reverse-3">
				@foreach($list_howToGet as $item)
					<div class="item">
						<div class="thumb">
							{!! image($item->image, 350, 250, $item->title) !!}
						</div>
						<div class="desc">
							<h3 class="title yellow">{{ $item->title }}</h3>
							<div class="text">{!! $item->content !!}</div>
							<a href="javascript:void(0)" class="readmore font-semibold yellow">Read more</a>
							<a href="javascript:void(0)" class="collap-btn font-semibold yellow">Collapse</a>
						</div>
					</div>
				@endforeach
			</div>
		</div>
	</div>
	@endif

	@if($top_highlight && count($top_highlight) > 0)
	<div class="top-highligts has-bg-under m-b-50">
		<h2 class="title-page pink text-center">
			<img src="{{ asset('public/images/icons/all/highlights-pink.png') }}" alt="icon">
			<span>
				Places to visit	in {{ $region->title }}	
			</span>
		</h2>
		<div class="bg-under light-graybg pink-right"></div>
		<div class="container">
			<div class="list-four-sec">
				<div class="row">
					<div class="col-md-4">
						@if($top_highlight[0])
							<div class="item">
								<a class="thumb">
									{!! image($top_highlight[0]->image, 350, 650, $top_highlight[0]->title) !!}
								</a>
								<a href="#" class="title">
									{{$top_highlight[0]->title}}								
								</a>
							</div>
						@endif
					</div>
					<div class="col-md-8">
						<div class="row">
							@for($i = 1; $i < 3; $i++)
								@if($top_highlight[$i])
									<div class="col-md-6">
										<div class="item">
											<a class="thumb">
												{!! image($top_highlight[$i]->image, 350, 320, $top_highlight[$i]->title) !!}
											</a>
											<a href="#" class="title">
												{{$top_highlight[$i]->title}}								
											</a>
										</div>
									</div>
								@endif
							@endfor

							@if(isset($top_highlight[3]))
								<div class="col-md-12">
									<div class="item">
										<a class="thumb">
											{!! image($top_highlight[3]->image, 710, 320, $top_highlight[3]->title) !!}
										</a>
										<a href="#" class="title">
											{{$top_highlight[3]->title}}								
										</a>
									</div>
								</div>
							@endif
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	@endif
	
	@if($list_highlight && count($list_highlight) > 0)
	<div class="list-highlight section">
		<div class="container">
			<div class="wrap-content">
				<div class="content-sec light-graybg p-40">
					<ul class="list-unstyled">
						@foreach ($list_highlight as $item)
							<li><a href="#" class="pink font-semibold">{{ $item->title }}</a></li>
						@endforeach
					</ul>
				</div>
			</div>
		</div>
	</div>
	@endif

	@if($list_whatToEat)
	<div class="section">
		<div class="container">
			<div class="p-x-100">
				<h2 class="title-page yellow text-center">
					<img src="{{ asset('public/images/icons/all/eat-yellow.png') }}" alt="icon">
					<span>
						What to eat in {{ $region->title }}
					</span>
				</h2>
			</div>
			<div class="list-row-reverse-3">
				@foreach($list_whatToEat as $item)
					<div class="item">
						<div class="thumb">
							{!! image($item->image, 350, 250, $item->title) !!}
						</div>
						<div class="desc">
							<h3 class="title yellow">{{ $item->title }}</h3>
							<div class="text">{!! $item->content !!}</div>
							<a href="javascript:void(0)" class="readmore font-semibold yellow">Read more</a>
							<a href="javascript:void(0)" class="collap-btn font-semibold yellow">Collapse</a>
						</div>
					</div>
				@endforeach
			</div>
		</div>
	</div>
	@endif	
	
	@if($related_tours)
		<div class="section related-tours">
			<div class="container">
				<h2 class="title-page green text-center">
					<img src="{{asset('public/images/icons/all/tour-green.png')}}" alt="icon">
					<span>
						Our tour selection in {{ $region->title }}				
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
			</div>
		</div>
	@endif

	@if($related_hotels)
		<!-- <div class="section related-hotels list-hotel">
			<div class="container">
				<h2 class="title-page yellow text-center">
					<img src="{{asset('public/images/icons/all/stay-yellow.png')}}" alt="icon">
					<span>
						Where to stay in {{ $region->title }}					
					</span>
				</h2>
				<div class="slide-style list-blog yellow">
					@foreach($related_hotels as $hotel)
						@include('hotels.item')
					@endforeach
				</div>
			</div>
		</div> -->
	@endif

	@if($list_highlight && count($list_highlight) > 0)
		<div class="section">
			<div class="container">
				<div class="title-sec text-center">
					<h2 class="title-page yellow text-center">
						<img src="{{asset('public/images/icons/all/stay-yellow.png')}}" alt="icon">
						<span>
							Where to stay in {{ $region->title }} ?					
						</span>
					</h2>
					<p>Disover our featured accommodation in {{ $region->title }} providing the best services and facilities for you to enjoy a great trip !</p>
				</div>
				<div class="p-15 m-y-50 graybg search-highlights text-center">
					<div class="search-box yellow">
						{!!csrf_field()!!}
						<input type="text" name="keyword" class="yellow" placeholder="Type in a destination name in {{ $region->title }}" data-action="{{ route('loadHighlightHotel', $country->slug) }}" />
						<div class="list-result list-place light-graybg ">
							<ul>
								@foreach($list_highlight as $item)
									<li><a href="#">{{ $item->title }}</a></li>
								@endforeach
							</ul>
						</div>
					</div>
				</div>
				<div class="slide-style list-highlight yellow">
					@foreach($list_highlight as $city)
						@include('countries.highlights.highlight-hotel-item')
					@endforeach
				</div>
				<div class="text-center">
					<a href="#" class="btn-page yellowbg">
						<span>View all accommodation in {{ $region->title }}</span>
					</a>
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
						Our blog articles about {{ $region->title }}				
					</span>
				</h2>
				<div class="slide-style list-blog pink">
					@foreach($related_articles as $article)
						@include('articles.item')
					@endforeach
				</div>
			</div>
		</div>
	@endif

	
	
</div>

@stop