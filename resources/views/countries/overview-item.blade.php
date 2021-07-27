@php
	/*
	* template item overview
	* param request : $overview
	*/
@endphp
<div class="item">
	{!! image($overview->image, 400, 270, $overview->title) !!}
	<a class="title" href="{{ route('overviewCountry', $overview->slug) }}" rel="nofollow">
		{{ $overview->title }}
	</a>
</div>