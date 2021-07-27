@php
	$type_country = isset($country) ? '' : 'multi'; 
	$country_id = isset($country) ? $country->id : ''; 
@endphp
<div class="top-title-sb text-center pinkbg">Filter your search</div>
<div class="wrap-sb light-graybg">
	@if($regions)
		<div class="sb-region">
			<h3 class="sb-title has-icon pink">Region</h3>
			<div class="list-filter-tour list-country">
				<ul class="no-list-style">
					@foreach($regions as $region)
						@php
							$addClass = $check = '';
							if(isset($region_select)){
								foreach($region_select as $value){
									if($region->slug == $value){
										$check = 'checked';
										$addClass = 'active';
										break;
									} 
								}
							}
							$countTour = countTourInCountry($region->id, $type_country);
							if(isset($count_region)) {//multi params of tours in page
								$countTour = $count_region[$region->id];
							}
						@endphp
						<li class="region-{{$region->id}} {{$addClass}}">
							<label class="checkbox">
		                        <input type="checkbox" value="{{$region->id}}" {{$check}}>
		                        <span class="checkmark"></span>
		                        {{$region->title}}
		                        <span class="count-post">({{$countTour}})</span>
		                    </label>
						</li>
					@endforeach
				</ul>
			</div>
		</div>
	@endif

	@if($durations)
		<div class="sb-duration">
			<h3 class="sb-title has-icon pink">Duration</h3>
			<div class="list-filter-tour list-duration">
				<ul class="no-list-style">
					@foreach($durations as $duration)
						@php
							$addClass = $check = '';
							if(isset($duration_select) && $duration->slug == $duration_select){
								$check = 'checked';
								$addClass = 'active';
							}
							$countTour = countTourInDurationByCountry($duration->id, $country_id, $type_country);
							if(isset($count_duration))
								$countTour = $count_duration[$duration->id];
						@endphp
						<li class="duration-{{$duration->id}}" {{$addClass}}>
							<label class="checkbox">
		                        <input type="checkbox" value="{{$duration->id}}" {{$check}}>
		                        <span class="checkmark"></span>
		                        {{$duration->title}}
		                        <span class="count-post">({{ $countTour }})</span>
		                    </label>
						</li>
					@endforeach
				</ul>
			</div>
		</div>
	@endif

	@if($cats)
		<div class="sb-cat">
			<h3 class="sb-title has-icon pink">Tour Style</h3>
			<div class="list-filter-tour list-cat">
				<ul class="no-list-style">
					@php $temp = 1;  @endphp
					@foreach($cats as $cat)
						@php
							$addClass = $check = '';
							if(isset($cat_select)){
								foreach($cat_select as $value){
									if($cat->slug == $value){
										$check = 'checked';
										$addClass = 'active';
										break;
									} 
								}
							}
							$countTour = countTourInCatByCountry($cat->id, $country_id, $type_country);
							if(isset($count_cat))
								$countTour = $count_cat[$cat->id];

							//country category if it has
							$temp = 1;
							if(isset($countryCat)){
								foreach($countryCat as $value){
								
									if($cat->id == $value->cat_id){
										$temp = 0; break;
									}
									else
										$temp = 1;
								}
							}
						@endphp

					 	@if($temp == 1)
							<li class="cat-{{$cat->id}} {{$addClass}}">
								<label class="checkbox">
			                        <input type="checkbox" value="{{$cat->id}}" {{$check}}>
			                        <span class="checkmark"></span>
			                        {{$cat->title}}
			                        <span class="count-post">({{ $countTour }})</span>
			                    </label>
							</li>
					 	@endif
					@endforeach
				</ul>
			</div>
		</div>
	@endif
</div>
<div class="bot-title-sb text-center graybg"><a href="#">Reset all filters<i class="fas fa-undo-alt"></i></a></div>