<?php
/*
* template attraction item
* @param request: $attraction
*/
?>
@php
	$list_icon = getListIconAttractionByID($attraction->id);
	$gallery_attraction = json_decode($attraction->gallery); 
@endphp
<div class="item">
	<div class="wrap-item">
		<div class="thumb hexagonImg hexagonImg1">
			<div class="wrap hexagon-in1">
				<a style="background-image: url({{getImgUrl($attraction->image)}});" href="{{getImgUrl($attraction->image)}}" id="gallery-{{$attraction->id}}" class="hexagonImg-in2 html5lightbox" data-group="gallery-{{$attraction->id}}"></a>
				<div class="hide">
					@if(!empty($gallery_attraction))
						@foreach($gallery_attraction as $image_id)
							
								<a class="thumb html5lightbox" href="{{ getImgUrl($image_id) }}" data-group="gallery-{{$attraction->id}}"></a>
							
						@endforeach
					@endif
				</div>
			</div>
		</div>
		<div class="desc">
			<h3 class="title"><a href="#" class="pink font-semibold">{{ $attraction->title }}</a></h3>
			@if($list_icon)
				<ul class="list-icon list-icon-attraction list-unstyled">
					@foreach($list_icon as $icon)
					<li data-id="{{ $icon->id }}">
						{!! imageAuto($icon->pink_icon, $icon->title) !!}
						<span class="title-icon pink">{{ $icon->title }}</span>
					</li>
					@endforeach
				</ul>
			@endif
			<div class="collapse-text">
				{!! str_limit($attraction->desc, 250) !!}
				<a href="#" class="read-more pink font-semibold">Read more</a>
			</div>
			<div class="full-text">
				{!! $attraction->desc . '<a href="#" class="collapse pink font-semibold">Collapse</a>' !!}
				
			</div>
		</div>
		
	</div>
</div>