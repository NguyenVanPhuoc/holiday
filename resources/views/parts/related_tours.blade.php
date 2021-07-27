@if($related_tours)
	@php 
	    $list_tours = explode(',',$related_tours->list_tour);
	@endphp
	@desktop
	<div class="tour_craft slide-style">
		@foreach($list_tours as $value)
			@php
				$item=getAllTours($value)
			@endphp
			@if($item)
				@php
					$country_item = get_country_of_tour($item->id)[0];
					$tourstyle_item = get_category_tour($item->cat_id);
					$countCountry = countDestinationsOfTour($item->id);
				@endphp
				<div class="item">
					<div class="image">
						{!! image($item->image, 400, 270, $item->title) !!}
						<h7 class="title-tour white">{{$item->title}}</h7>
						<div class="hover_tour">
							@if($countCountry==1)
								<a class="link" href="{{ route('tour', ['slug_country'=>$country_item->slug, 'slug'=>$item->slug]) }}" rel="nofollow"></a>
								<p class="name white"> - {{ $country_item->title }} -</p>
							@else
								<a class="link" href="{{ route('tourMultiDes', ['slug'=>$item->slug]) }}"></a>
								<p class="name white"> - Asia - </p>
							@endif
							<h7  class="title-tour yellow" >{{$item->title}}</h7>
							<div class="cat">
								@if($tourstyle_item) 
								<span class="cate">{{ $tourstyle_item->title }}</span> 
								@endif
								<span class="day"> / {{ getDurationOfTour($item->id, false) }}</span>
								<span class="price">/ fr. ${{ number_format($item->price,0,".",",") }}</span> 
							</div>
						</div>
					</div>
					<div class="desc light-graynvp">
						<span class="black">{!! str_limit($item->content, 200) !!}</span>
						<a href="#">More</a>
					</div>
				</div>
			@endif
		@endforeach
	</div>
	@elsedesktop
	<div class="tour_craft slide-tour-dost">
		@foreach($list_tours as $value)
			@php
				$item=getAllTours($value)
			@endphp
			@if($item)
				@php
					$country_item = get_country_of_tour($item->id)[0];
					$tourstyle_item = get_category_tour($item->cat_id);
					$countCountry = countDestinationsOfTour($item->id);
				@endphp
				<div class="item">
					<div class="image">
						{!! image($item->image, 400, 270, $item->title) !!}
						<h3 class="title-tour white">{{$item->title}}</h3>
						@if($countCountry==1)
							<a class="link" href="{{ route('tour', ['slug_country'=>$country_item->slug, 'slug'=>$item->slug]) }}" rel="nofollow"></a>
							<p class="name white"> - {{ $country_item->title }} -</p>
						@else
							<a class="link" href="{{ route('tourMultiDes', ['slug'=>$item->slug]) }}"></a>
							<p class="name white"> - Asia - </p>
						@endif
						<div class="cat">
							@if($tourstyle_item) 
							<span class="cate">{{ $tourstyle_item->title }}</span> 
							@endif
							<span class="day"> / {{ getDurationOfTour($item->id, false) }}</span>
							<span class="price">/ fr. ${{ number_format($item->price,0,".",",") }}</span> 
						</div>
					</div>
					<div class="desc light-graynvp">
						<span class="black">{!! str_limit($item->content, 200) !!}</span>
						<a href="#">More</a>
					</div>
				</div>
			@endif
		@endforeach
	</div>
	@enddesktop
@endif