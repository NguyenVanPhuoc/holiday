@php
$list_main_city = getListCityInCountry($country->id);
$main_city = explode(',',$list_main_city->list_main_city);
@endphp
@desktop
<div class="slide-style list-places">
    @foreach($main_city as $items)
        @php 
            $city_objs = getCountry($items);
            $style = $city_objs;
        @endphp
            <div class="wrapper-item">
                <div class="item" style="background-image: url('{!! getImgUrl($style->image); !!}')">
                    <h7 class="title-country white">{{$style->title}}</h7>
                    <div class="desc_hover">
                        <a class="link_traveltips" href="{{ route('countryPlaceToVisit', ['slug_country'=>$country->slug,'slug'=>$style->slug ]) }}"></a>
                        <div class="desc">
                            <img class="bee" src="{{asset('public/images/bee/bee-white.png')}}" alt="bee-white"> 
                            <h7 class="title_hover yellow">{{$style->title}}</h7>
                            <p class="white">{!! $style->short_desc !!}</p>
                        </div>
                    </div>
                </div>
            </div>
    @endforeach
</div>
@elsedesktop
<div class="slide-dost list-places">
    @foreach($main_city as $items)
        @php 
            $city_objs = getCountry($items);
            $style = $city_objs;
        @endphp
            <div class="wrapper-item">
                <div class="item" style="background-image: url('{!! getImgUrl($style->image); !!}')">
                    <a class="link" href="{{ route('countryPlaceToVisit', ['slug_country'=>$country->slug,'slug'=>$style->slug ]) }}"></a>
                    <h7 class="title-country white">{{$style->title}}</h7>
                </div>
            </div>
    @endforeach
</div>
@enddesktop