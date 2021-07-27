@php
    $array_destinationID = (isset($request->destination_id) && $request->destination_id != '') ? explode(",", $request->destination_id) : []; 
    $duration_id = (isset($request->duration_id) && $request->duration_id != '') ? $request->duration_id : false;
    $array_catID = (isset($request->style_id) && $request->style_id != '') ? explode(",", $request->style_id) : [];
    $list_regions = getListRegionAlphabetInCountry($country->id);
    $durations = getListDuration();
    $styles = getListTourStyleAlphabetByCountry($country->id);
@endphp
<div class="container">
    <div class="list-search">
        <div class="filter-about gr-filter">
            <h7 class="title-header">LOOKING FOR A TOUR PLAN?</h7>
            <form action="{{ route('countryTour', ['slug_country'=>$country->slug]) }}" method="GET" id="frm-search-country">
            <div class="list-filter">
                <div class="box-item1 region multi-value" data-title="Region">
                    <span class="title">Region</span>
                    <ul class="list-unstyled">
                        @foreach($list_regions as $region)
                            <li @if(in_array($region->id, $array_destinationID)) class="active" @endif>
                                <label for="region-{{ $region->id }}">
                                    <input type="checkbox" class="filter-value" id="region-{{ $region->id }}" name="array_country_id[]" value="{{ $region->id }}">
                                    {{ $region->title }}
                                </label>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="box-item1 duration single-value" data-title="Duration">
                    <span class="title">Duration</span>
                    <ul class="list-unstyled">
                        @foreach($durations as $duration)
                            <li @if($duration->id == $duration_id) class="active" @endif>
                                <label for="duration-{{ $duration->id }}">
                                    <input type="radio" class="filter-value" id="duration-{{ $duration->id }}" name="duration_id" value="{{ $duration->id }}" @if($duration->id == $duration_id) checked @endif>
                                    {{ $duration->title }}
                                </label>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="box-item1 tour-style  multi-value" data-title="Tour style">
                    <span class="title">Tour style</span>
                    <ul class="list-unstyled">
                        @foreach($styles as $style)
                            <li @if(in_array($style->id, $array_catID)) class="active" @endif>
                                <label for="tourstyle-{{ $style->id }}">
                                    <input type="checkbox" class="filter-value" id="tourstyle-{{ $style->id }}" name="array_tourstyle_id[]" value="{{ $style->id }}" @if(in_array($style->id, $array_catID)) checked @endif>
                                    {{ $style->title }}
                                </label>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="submit_search">
                    <input type="submit" class="search" value="Search">
                    <img src="{{asset('public/images/loupe search.png')}}" alt="image">
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
