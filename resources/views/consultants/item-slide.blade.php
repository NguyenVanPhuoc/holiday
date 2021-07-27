@php
/**
 * template item slide consultant
 * @param $item
 */
@endphp
<div class="item flex-list center-item">
	<a href="javascript:void(0)" class="thumb avatar">
		{!! image($item->image, 100, 100, $item->title) !!}
	</a>
	<div class="desc">
		<p class="title yellow font-semibold">{{ $item->title }}</p>
		<p class="text m-0">{{ $item->short_desc }}</p>
	</div>
</div>