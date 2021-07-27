@php
	$list_city = getListCitiesInCountry($country->id);
@endphp
@if($list_city)
    @foreach($list_city as $item)
        <li><a href="#">{{ $item->title }}</a></li>
    @endforeach
@endif
