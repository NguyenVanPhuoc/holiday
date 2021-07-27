@if(isset($list_destination))
	<div class="check_item box-item country">
	    <span class="title">Destinations</span>
	    <ul class="list-unstyled">
	        @foreach($list_destination as $item)
	            <li {{ isset($array_destinationID) && in_array($item->id,$array_destinationID) ? ' class=active' : '' }}>
	                <label for="country-{{ $item->id }}">
	                    <input type="checkbox" class="filter-value" id="country-{{ $item->id }}" name="array_country_id[]" value="{{ $item->id }}" {{ isset($array_destinationID) && in_array($item->id,$array_destinationID) ? 'checked' : '' }}  >
	                    <h3 class="title_vp">{{ $item->title }} ({{ countReviewByCountryId($item->id) }})</h3>
	                </label>
	            </li>
	        @endforeach
	    </ul>
	</div>
@endif
@if(isset($list_group_type))
	<div class="check_item box-item group-type single-value">
        <span class="title">Group type</span>
        <ul class="list-unstyled">
            @foreach($list_group_type as $item)
                <li @if($item->id == $group_type_checked) class="active" @endif>
                    <label for="group-type-{{ $item->id }}">
                        <input type="radio" class="filter-value" id="group-type-{{ $item->id }}" name="group_type_id" value="{{ $item->id }}" @if($item->id == $group_type_checked) checked @endif>
                        <h3 class="title_vp">{{ $item->title }} ({{ countReviewByGroupTypeId($item->id) }})</h3>
                    </label>
                </li>
            @endforeach
        </ul>
    </div>
@endif
@if(isset($list_tour_style))
	<div class="check_item box-item tour-style">
        <span class="title">Tour style</span>
        <ul class="list-unstyled">
            @foreach($list_tour_style as $tour_style)
                <li {{ isset($tourstyle_checked) && in_array($tour_style->id,$tourstyle_checked) ? ' class=active' : '' }}>
                    <label for="tourstyle-{{ $tour_style->id }}">
                        <input type="checkbox" class="filter-value" id="tourstyle-{{ $tour_style->id }}" name="array_tourstyle_id[]" value="{{ $tour_style->id }}" {{ isset($tourstyle_checked) && in_array($tour_style->id,$tourstyle_checked) ? 'checked' : '' }} >
                        <h3 class="title_vp">{{ $tour_style->title }} ({{ countReviewByStyleId($tour_style->id) }})</h3>
                    </label>
                </li>
            @endforeach
        </ul>
    </div>
@endif