<div class="search-box pink">
	{!!csrf_field()!!}
	<input type="text" name="keyword" class="pink" placeholder="Search for another place to visit in {{ $country->title }}" data-action="{{ route('loadHighlight', $country->slug) }}" />
	<div class="list-result list-place light-graybg ">
		<ul>
			@foreach($list_highlight as $item)
				<li><a href="#">{{ $item->title }}</a></li>
			@endforeach
		</ul>
	</div>
</div>