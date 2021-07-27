@php
/**
 * template item highlight (have things to do)
 * @param request $item_city
 */
	$list_catThingToDo = getListCatGuideByListId($item_city->things_to_do);
@endphp
<div class="item">
	<div class="thumb">
		{!! image($item_city->image, 400, 270, $item_city->title) !!}
		<a class="title" href="#">
			{{ $item_city->title }}
		</a>
	</div>
	@if($list_catThingToDo)
	<ul class="list-unstyled">
		@foreach($list_catThingToDo as $cat_thingToDo)
			<li><a href="#">{{ $cat_thingToDo->title }}</a></li>
		@endforeach
	</ul>
	@endif
</div>