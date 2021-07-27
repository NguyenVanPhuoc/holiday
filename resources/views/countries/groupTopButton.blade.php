<div class="gr-btn-top light-graybg text-center">
	<div class="container">
		<a href="#" class="btn-page-2 @if(isset($post_type_active) && $post_type_active == 'overview') active @endif">
			<i class="fa fa-eye" aria-hidden="true"></i>{{ __('Overview') }}
		</a>
		<a href="#" class="btn-page-2 @if(isset($post_type_active) && $post_type_active == 'tour') active @endif ">
			<i class="fa fa-map-marker" aria-hidden="true"></i>
			{{ __('Tours') }}
		</a>
		<a href="#" class="btn-page-2 @if(isset($post_type_active) && $post_type_active == 'highlight') active @endif">
			<i class="fa fa-star-o" aria-hidden="true"></i>
			{{ __('Places to visit') }}</a>
		<a href="#" class="btn-page-2 @if(isset($post_type_active) && $post_type_active == 'travel_tip') active @endif">
			<i class="fa fa-lightbulb-o" aria-hidden="true"></i>
			{{ __('Tips & Guide') }}
		</a>
		<a href="#" class="btn-page-2 @if(isset($post_type_active) && $post_type_active == 'thing_to_do') active @endif">
			<i class="fa fa-check-circle-o" aria-hidden="true"></i>{{ __('Things to do') }}
		</a>
		<a href="#" class="btn-page-2 @if(isset($post_type_active) && $post_type_active == 'hotel') active @endif">
			<i class="fa fa-bed" aria-hidden="true"></i>{{ __('Accommodation') }}
		</a>
		<a href="#" class="btn-page-2 @if(isset($post_type_active) && $post_type_active == 'cultural') active @endif">
			<i class="fa fa-map" aria-hidden="true"></i>{{ __('Cultural insight') }}
		</a>
	</div>
</div>