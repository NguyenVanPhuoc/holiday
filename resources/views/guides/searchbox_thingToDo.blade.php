<div class="search-box pink">
	{!!csrf_field()!!}
	<input type="text" name="keyword" class="pink" placeholder="Search for another activity in list" data-action="{{ route('loadThingToDo', $country->slug) }}" />
	@if($guide)
	<input type="hidden" name="current_id" value="{{ $guide->id }}">
	@endif
	<div class="list-result list-place light-graybg ">
		<ul>
			@foreach($list_loadThingToDo as $item)
				<li><a href="#">{{ $item->short_title }}</a></li>
			@endforeach
		</ul>
	</div>
</div>