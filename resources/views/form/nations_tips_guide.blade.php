@php
	$total_nation = getTotalNation();
    $main_nation = getListNation();
    $other_nation = getListNation(($total_nation - 6), 6);
@endphp
@if($main_nation)
    @foreach($main_nation as $nation)
        <li><a href="{{ route('postTypeCountryTravel', ['slug_country' => $country->slug,'slug' => $nation->slug]) }}" class="link_city">{{ $nation->title }}</a></li>
    @endforeach
@endif
<hr class="line">
@if($other_nation)
    @foreach($other_nation as $nation)
         <li><a href="{{ route('postTypeCountryTravel', ['slug_country' => $country->slug,'slug' => $nation->slug]) }}" class="link_city">{{ $nation->title }}</a></li>
    @endforeach
@endif