@php
/**
 * template search box of country tour style
 * @param $list_countryTourStyle
 */
@endphp
<div class="search-box pink">
	{!!csrf_field()!!}
	<input type="hidden" name="current_id" value="{{ $country_tourStyle->id }}">
	<input type="text" name="keyword" class="pink" placeholder="Search for another tour style in list" data-action="{{ route('loadTourStyleOfCountry', $country->slug) }}" />
	<div class="list-result list-place light-graybg ">
		<ul>
			@foreach($list_tour_style as $item)
				<li><a href="#">{{ $item->title }}</a></li>
			@endforeach
		</ul>
	</div>
</div>