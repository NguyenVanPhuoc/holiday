@php
/**
 * template section four item 
 * @param array object $list_fourItem 
 */
@endphp
<div class="row">
	<div class="col-md-8">
		@if($list_fourItem[0])
		<div class="item">
			<a class="thumb">
				{!! image($list_fourItem[0]->image, 710, 440, $list_fourItem[0]->title) !!}
			</a>
			<a href="{{ route('postTypeCountryTravel', ['slug_country' => $country->slug,'slug' => $list_fourItem[0]->slug]) }}" class="title has-icon">
				{!! imageAuto($list_fourItem[0]->white_icon, $list_fourItem[0]->title) !!}
				{{$list_fourItem[0]->title}}								
			</a>
		</div>
		@endif

		@if(isset($list_fourItem[1]))
		<div class="item">
			<a class="thumb">
				{!! image($list_fourItem[1]->image, 710, 230, $list_fourItem[1]->title) !!}
			</a>
			<a href="{{ route('postTypeCountryTravel', ['slug_country' => $country->slug,'slug' => $list_fourItem[1]->slug]) }}" class="title has-icon">
				{!! imageAuto($list_fourItem[1]->white_icon, $list_fourItem[1]->title) !!}
				{{$list_fourItem[1]->title}}								
			</a>
		</div>
		@endif
	</div>
	<div class="col-md-4">
		@if(isset($list_fourItem[2]))
		<div class="item">
			<a class="thumb">
				{!! image($list_fourItem[2]->image, 350, 230, $list_fourItem[2]->title) !!}
			</a>
			<a href="{{ route('postTypeCountryTravel', ['slug_country' => $country->slug,'slug' => $list_fourItem[2]->slug]) }}" class="title has-icon">
				{!! imageAuto($list_fourItem[2]->white_icon, $list_fourItem[2]->title) !!}
				{{$list_fourItem[2]->title}}								
			</a>
		</div>
		@endif

		@if(isset($list_fourItem[3]))
		<div class="item">
			<a class="thumb">
				{!! image($list_fourItem[3]->image, 350, 440, $list_fourItem[3]->title) !!}
			</a>
			<a href="{{ route('postTypeCountryTravel', ['slug_country' => $country->slug,'slug' => $list_fourItem[3]->slug]) }}" class="title has-icon">
				{!! imageAuto($list_fourItem[3]->white_icon, $list_fourItem[3]->title) !!}
				{{$list_fourItem[3]->title}}								
			</a>
		</div>
		@endif
	</div>
</div>