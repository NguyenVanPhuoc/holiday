@if(isset($list_region))
	<div class="check_item box-item region">
		<p class="title">Region</p>
		<ul class="list-region list-unstyled">
			@foreach($list_region as $region)
				<li{{ isset($region_checked) && in_array($region->id,$region_checked) ? ' class=active' : '' }}>
					<label for="region-{{ $region->id }}">
						<input type="checkbox" class="filter-value" id="region-{{ $region->id }}" name="array_country_id[]" value="{{ $region->id }}" {{ isset($region_checked) && in_array($region->id,$region_checked) ? 'checked' : '' }}  >
						<h3 class="title_vp">{{ $region->title }} ({{ $region->count }})</h3>
					</label>
				</li>
			@endforeach
		</ul>
	</div>
@endif
@if(isset($list_duration))
	<div class="check_item box-item duration single-value">
		<p class="title">Duration</p>
		<ul class="list-duration list-unstyled">
			@foreach($list_duration as $duration)
				<li{{ isset($duration_checked) && ($duration->id == $duration_checked) ? ' class=active' : '' }}>
					<label for="duration-{{ $duration->id }}">
						<input type="radio" class="filter-value" id="duration-{{ $duration->id }}" name="duration_id" value="{{ $duration->id }}" {{ isset($duration_checked) && ($duration->id == $duration_checked) ? 'checked' : '' }}  >
						<h3 class="title_vp">{{ $duration->title }} ({{ $duration->count }})</h3>
					</label>
				</li>
			@endforeach
		</ul>
	</div>
@endif
@if(isset($list_tour_style))
	<div class="check_item box-item tour-style">
		<p class="title">Tour style</p>
		<ul class="list-style list-unstyled">
			@foreach($list_tour_style as $tour_style)
				<li{{ isset($tourstyle_checked) && in_array($tour_style->id,$tourstyle_checked) ? ' class=active' : '' }}>
					<label for="tourstyle-{{ $tour_style->id }}">
						<input type="checkbox" class="filter-value" id="tourstyle-{{ $tour_style->id }}" name="array_tourstyle_id[]" value="{{ $tour_style->id }}"{{ isset($tourstyle_checked) && in_array($tour_style->id,$tourstyle_checked) ? 'checked' : '' }}  >
						<h3 class="title_vp">{{ $tour_style->title }} ({{ $tour_style->count }})</h3>
					</label>
				</li>
			@endforeach
		</ul>
	</div>
@endif