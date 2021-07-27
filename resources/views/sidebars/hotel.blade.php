@php
	/**
	 * sidebar detail acommodation
	 */
@endphp
<div class="gr-not-fixed" >
	<div class="wrapper has-top-icon sidebar-sec">
		<div class="icon-top">
			<img src="{{ asset('public/images/icons/all/quick-search-gray.png') }}" alt="icon">
		</div>
		<div class="top-title-sb graybg">Quick search</div>
		<form action="{{ route('quickSearchHotel', $country->slug) }}" method="GET" class="quick-search send-ajax">
			<div class="wrap-sb">
				@if(isset($list_main_city))
					<div class="box-item city-box sb-filter single-value">
						<p class="title">City</p>
						<ul>
							@foreach($list_main_city as $city)
								<li data-id={{$city->id}}>
									<input type="radio" name="city" value="{{ $city->id }}">{{$city->title}}
								</li>
							@endforeach
							@if($list_other_city && count($list_other_city) > 0)
								@foreach($list_other_city as $city)
									<li class="city-{{$city->id}} collap-item hidden">
										<input type="radio" name="city" value="{{ $city->id }}">{{$city->title}}
									</li>
								@endforeach
							@endif
						</ul>
						@if(isset($list_other_city) && count($list_other_city) > 0)
						<a href="#" class="view-all pink">View all cities</a>
						<a href="#" class="collap pink hidden">Collapse cities</a>
						@endif
					</div>
				@endif

				@if($list_star)
					<div class="box-item star-box sb-filter single-value">
						<p class="title">Star rating</p>
						<ul>
							@foreach($list_star as $star)
								<li data-id={{$star->id}}>
									<input type="radio" name="star" value="{{ $star->id }}">{{$star->title}}
								</li>
							@endforeach
						</ul>
					</div>
				@endif

				@if($list_location)
					<div class="box-item location-box sb-filter single-value">
						<p class="title">Location</p>
						<ul>
							@foreach($list_location as $location)
								<li data-id={{$location->id}}>
									<input type="radio" name="location" value="{{ $location->id }}">{{$location->title}}
								</li>
							@endforeach
						</ul>
					</div>
				@endif

				@if($list_special)
					<div class="box-item special-box sb-filter">
						<p class="title">Special</p>
						<ul>
							@foreach($list_special as $spec)
								<li data-id={{$spec->id}}>
									<input type="checkbox" name="special[]" value="{{ $spec->id }}">{{$spec->title}}
								</li>
							@endforeach
						</ul>
					</div>
				@endif
			</div>
			<div class="submit pinkbg">
				<a href="#" class="send-ajax"><i class="fa fa-search" aria-hidden="true"></i>Search</a>
			</div>
		</form>
	</div>
	@if($hotel->website_link != '' || $hotel->tripadvisor_code != '' || $hotel->tripadvisor_link != '' )
	<div class="gr-outsite light-graybg-2 text-center">
		<div class="hotel-website">
			<img src="{{ asset('public/images/bee/base_fill.png') }}" alt="icon-bee">
			<a href="{{ $hotel->website_link }}" class="btn-gray" rel="nofollow" target="_blank">Hotel website</a>
		</div>
		@if($hotel->tripadvisor_code != '')
			<div class="tripadvisor-code">
				{!! $hotel->tripadvisor_code !!}
			</div>
		@elseif($hotel->tripadvisor_link != '')
			<div class="tripadvisor-banner">
				<a href="{{ $hotel->tripadvisor_link }}" rel="nofollow" target="_blank">
					<img src="{{ asset('public/images/banners/trip-advisor-banner.jpg') }}" alt="tripadvisor-banner">
				</a>
			</div>
		@endif

	</div>
	@endif

	@if(isset($list_consultant))
		@php
			(count($list_consultant) > 1) ? $class = 'slide-consultants ' : $class = '';
		@endphp
		<div class="consultant-sec m-t-40">
			<div class="top-title light-graybg font-semibold">Our local expert</div>
			<div class="consultant-content  {{$class}}">
				@foreach($list_consultant as $item)
					<div class="item">
						<a class="name yellow font-semibold">{{ $item->title }}</a><br>
						<a href="#" class="avatar">
							{!! image($item->image, 100, 100, $item->title) !!}
						</a>
						<div class="desc text-center">{{ $item->short_desc }}</div>	
					</div>
				@endforeach
			</div>
			<a class="btn-bot btn" href="#">
				<i class="fa fa-suitcase" aria-hidden="true"></i>
				Create my trip
			</a>
		</div>
	@endif
</div>