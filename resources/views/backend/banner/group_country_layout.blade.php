<div class="row">
	<input type="hidden" name="post_type" value="{{ $post_type }}">
	@foreach($list_country as $country)
		@php
			$image_id = getBannerPostByCountry($post_type, $country->id);
		@endphp
		<div class="col-md-2">
			<label>{{ $country->title }}</label>
			<div id="frm-image-{{ $country->id }}" class="desc img-upload">							
				<div class="image">
					<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
					{!!image($image_id, 150,150, 'banner')!!}
					<input type="hidden" name="image[{{ $country->id }}]" class="thumb-media" value="{{ $image_id }}" />
				</div>
			</div>
		</div>
	@endforeach
</div>