@php
	/*
	* template item hotel
	* param request : $hotel
	*/
@endphp
<div class="item octagonal">
	<div class="wrap-octagonal">
		<div href="#" class="thumb">
			{!! image($hotel->image, 470, 290, $hotel->title) !!}
		</div>
		<a href="{{ $hotel->getPermalink() }}" class="gr flex-list center-item">
			<h5 class="title">{{ $hotel->title }}</h5>
			<span class="star">{!! getStarOfHotelHtml($hotel->id) !!}</span>
			<span class="view-more">View accommodation</span>
		</a>
	</div>
</div>