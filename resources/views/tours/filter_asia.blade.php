@if(isset($list_destination))
	<div class="check_item box-item region">
		<p class="title">Country</p>
		<ul class="list-unstyled">
			@foreach($list_destination as $destination)
				<li {{ isset($array_destinationID) && in_array($destination->id,$array_destinationID) ? ' class=active' : '' }}>
					<label for="region-{{ $destination->id }}">
						<input type="checkbox" class="filter-value" id="region-{{ $destination->id }}" name="array_country_id[]" value="{{ $destination->id }}" {{ isset($array_destinationID) && in_array($destination->id,$array_destinationID) ? 'checked' : '' }}  >
						<h3 class="title_vp">{{ $destination->title }} ({{ $destination->count }})</h3>
					</label>
				</li>
			@endforeach
		</ul>
	</div>
@endif
@if(isset($list_duration))
	<div class="check_item box-item duration single-value">
		<p class="title">Duration</p>
		<ul class="list-unstyled">
			@foreach($list_duration as $duration)
				<li @if($duration->id == $duration_checked) class="active" @endif>
					<label for="duration-{{ $duration->id }}">
						<input type="radio" class="filter-value" id="duration-{{ $duration->id }}" name="duration_id" value="{{ $duration->id }}" @if($duration->id == $duration_checked) checked @endif>
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
		<ul class="list-unstyled">
			@foreach($list_tour_style as $tour_style)
				<li {{ isset($tourstyle_checked) && in_array($tour_style->id,$tourstyle_checked) ? ' class=active' : '' }}>
					<label for="tourstyle-{{ $tour_style->id }}">
						<input type="checkbox" class="filter-value" id="tourstyle-{{ $tour_style->id }}" name="array_tourstyle_id[]" value="{{ $tour_style->id }}" {{ isset($tourstyle_checked) && in_array($tour_style->id,$tourstyle_checked) ? 'checked' : '' }}  >
						<h3 class="title_vp">{{ $tour_style->title }} ({{ $tour_style->count }})</h3>
					</label>
				</li>
			@endforeach
		</ul>
	</div>
@endif