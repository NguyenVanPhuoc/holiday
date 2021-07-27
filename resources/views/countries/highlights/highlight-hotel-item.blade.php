@php
	/*
	* template item highlight hotel
	* param request : $city
	*/
@endphp
<div class="item">
	{!! image($city->image, 400, 270, $city->title) !!}
	<a class="title" href="#">
		{{ $city->title }}
	</a>
</div>