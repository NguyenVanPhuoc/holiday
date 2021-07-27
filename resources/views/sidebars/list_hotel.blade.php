@php
/**
 * template sidebar list hotel
 */
$current_country = $country;
if(isset($region)) $current_country = $region;
if(isset($city)) $current_country = $city;
@endphp
<div class="top-title-sb text-center pinkbg">Filter your search</div>
<div class="wrap-sb light-graybg">
	<form action="">
	@if(isset($list_main_city))
		<div class="sb-region sb-filter">
			<h3 class="sb-title has-icon pink">City</h3>
			<div class="list-filter-hotel list-country">
				<ul class="no-list-style checkbox-single">	
					@if(isset($city_id))
						@foreach($list_main_city as $city)
							<li class="city-{{$city->id}}">
								<label class="checkbox">
			                        <input type="checkbox" name="city" value="{{$city->id}}" @if($city->id == $city_id) checked @endif>
			                        <span class="checkmark"></span>
			                        {{$city->title}}
			                        <span class="count-post">
			                        	({{ $array_countCity[$city->id] }})
			                        </span>
			                    </label>
							</li>
						@endforeach
						@if($other_city && count($other_city) > 0)
							@foreach($other_city as $city)
								<li class="city-{{$city->id}} collap-item hidden">
									<label class="checkbox">
				                        <input type="checkbox" name="city" value="{{$city->id}}" @if($city->id == $city_id) checked @endif>
				                        <span class="checkmark"></span>
				                        {{$city->title}}
				                        <span class="count-post">
				                        	({{ $array_countCity[$city->id] }})
				                        </span>
				                    </label>
								</li>
							@endforeach
						@endif
					@else
						@foreach($list_main_city as $city)
							<li class="city-{{$city->id}}">
								<label class="checkbox">
			                        <input type="checkbox" name="city" value="{{$city->id}}" >
			                        <span class="checkmark"></span>
			                        {{$city->title}}
			                        <span class="count-post">
			                        	({{ countHotelInCity($city->id) }})
			                        </span>
			                    </label>
							</li>
						@endforeach
						@if($other_city && count($other_city) > 0)
							@foreach($other_city as $city)
								<li class="city-{{$city->id}} collap-item hidden">
									<label class="checkbox">
				                        <input type="checkbox" name="city" value="{{$city->id}}">
				                        <span class="checkmark"></span>
				                        {{$city->title}}
				                        <span class="count-post">
				                        	({{ countHotelInCity($city->id) }})
				                        </span>
				                    </label>
								</li>
							@endforeach
						@endif
					@endif
				</ul>
				@if($other_city && count($other_city) > 0)
				<a href="#" class="view-all pink">View all cities</a>
				<a href="#" class="collap pink hidden">Collapse cities</a>
				@endif
			</div>
		</div>
	@endif

	@if($list_star)
		<div class="sb-star">
			<h3 class="sb-title has-icon pink">Star rating</h3>
			<div class="list-filter-hotel list-star">
				<ul class="no-list-style checkbox-single">
					@if(isset($star_id))
						@foreach($list_star as $star)
							<li class="star-{{$star->id}}">
								<label class="checkbox">
			                        <input type="checkbox" name="star" value="{{$star->id}}" @if($star->id == $star_id) checked @endif>
			                        <span class="checkmark"></span>
			                        {{$star->title}}
			                        <span class="count-post">({{ $array_countStar[$star->id] }})</span>
			                    </label>
							</li>
						@endforeach
					@else
						@foreach($list_star as $star)
							<li class="star-{{$star->id}}">
								<label class="checkbox">
			                        <input type="checkbox" name="star" value="{{$star->id}}" >
			                        <span class="checkmark"></span>
			                        {{$star->title}}
			                        <span class="count-post">({{ countHotelInStar($star->id, $current_country->id) }})</span>
			                    </label>
							</li>
						@endforeach
					@endif
				</ul>
			</div>
		</div>
	@endif

	@if($list_location)
		<div class="sb-location">
			<h3 class="sb-title has-icon pink">Location</h3>
			<div class="list-filter-hotel list-location">
				<ul class="no-list-style checkbox-single">
					@if(isset($location_id))
						@foreach($list_location as $location)
							<li class="location-{{$location->id}}">
								<label class="checkbox">
			                        <input type="checkbox" name="location" value="{{$location->id}}" @if($location->id == $location_id) checked @endif>
			                        <span class="checkmark"></span>
			                        {{$location->title}}
			                        <span class="count-post">({{ $array_countLotion[$location->id] }})</span>
			                    </label>
							</li>
						@endforeach
					@else
						@foreach($list_location as $location)
							<li class="location-{{$location->id}}">
								<label class="checkbox">
			                        <input type="checkbox" name="location" value="{{$location->id}}">
			                        <span class="checkmark"></span>
			                        {{$location->title}}
			                        <span class="count-post">({{ countHotelInLocation($location->id, $current_country->id) }})</span>
			                    </label>
							</li>
						@endforeach
					@endif
				</ul>
			</div>
		</div>
	@endif

	@if($list_special)
		<div class="sb-special">
			<h3 class="sb-title has-icon pink">Special</h3>
			<div class="list-filter-hotel list-location">
				<ul class="no-list-style">
					@if(isset($array_IdSplecial))
						@foreach($list_special as $spec)
							<li class="special-{{$spec->id}}">
								<label class="checkbox">
			                        <input type="checkbox" name="special[]" value="{{$spec->id}}" @if(in_array($spec->id, $array_IdSplecial)) checked @endif>
			                        <span class="checkmark"></span>
			                        {{ $spec->title }}
			                        <span class="count-post">({{ $array_countSpecial[$spec->id] }})</span>
			                    </label>
							</li>
						@endforeach
					@else
						@foreach($list_special as $spec)
							<li class="special-{{$spec->id}}">
								<label class="checkbox">
			                        <input type="checkbox" name="special[]" value="{{$spec->id}}" >
			                        <span class="checkmark"></span>
			                        {{ $spec->title }}
			                        <span class="count-post">({{ countHotelInSpecial($spec->id, $current_country->id) }})</span>
			                    </label>
							</li>
						@endforeach
					@endif
				</ul>
			</div>
		</div>
	@endif
	</form>
</div>
<div class="bot-title-sb text-center graybg"><a href="#">Reset all filters<i class="fas fa-undo-alt"></i></a></div>

@if(isset($list_consultant))
	@php
		(count($list_consultant) > 1) ? $class = 'slide-consultants ' : $class = '';
	@endphp
	<div class="consultant-sec m-t-40">
		<div class="top-title light-graybg font-semibold">Our local expert</div>
		<div class="consultant-content  {{$class}}">
			@foreach($list_consultant as $item)
				<div class="item">
					<a class="name yellow font-semibold">{{ $item->title }}</a><br>
					<a href="#" class="avatar">
						{!! image($item->image, 100, 100, $item->title) !!}
					</a>
					<div class="desc text-center">{{ $item->short_desc }}</div>	
				</div>
			@endforeach
		</div>
		<a class="btn-bot btn" href="#">
			<i class="fa fa-suitcase" aria-hidden="true"></i>
			Create my trip
		</a>
	</div>
@endif