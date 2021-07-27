@php
/*
* template item slide of coutry tour style
* @param $tourStyle
*/
@endphp
<div class="item">
	{!! image($tourStyle->image, 400, 250, $tourStyle->title) !!}
	<div class="desc">
		<img src="{{ getImgUrl($tourStyle->white_icon, $tourStyle->title) }}" alt="{{ $tourStyle->title }}" class="icon">
		<h3 class="title">{{ $tourStyle->title }}</h3>
	</div>
	<a href="#" class="wrap-link"></a>
</div>