@php
/*
* template item slide of coutry tour style
* @param $tourStyle
*/
@endphp
<div class="item">
	{!! image($tourDuration->image, 400, 250, $tourDuration->title) !!}
	<div class="desc">
		<img src="{{ getImgUrl($tourDuration->duration->white_icon, $tourDuration->title) }}" alt="{{ $tourDuration->duration->title }}" class="icon">
		<h3 class="title">{{ $tourDuration->duration->title }}</h3>
	</div>
	<a href="#" class="wrap-link"></a>
</div>