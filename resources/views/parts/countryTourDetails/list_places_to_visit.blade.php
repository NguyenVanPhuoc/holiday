@php 
    $main_city = explode(',',$list_main_city->list_main_city);
@endphp
<div class="@desktop slide-style @elsedesktop slide-dost @enddesktop list-places">
    @foreach($main_city as $items)
        @php 
            $city_objs = getCountry($items);
            $style = $city_objs;
        @endphp
            <div class="wrapper-item">
                <div class="item" style="background-image: url('{!! getImgUrl($style->image); !!}')">
                    @handheld
                    <a class="link" href="{{ route('postTypeCountryTravel', ['slug_country' => $country->slug,'slug' => $style->slug]) }}"></a>
                    @endhandheld
                    <h7 class="title-country white">{{$style->title}}</h7>
                    <div class="desc_hover">
                        <a class="link_traveltips" href="{{ route('postTypeCountryTravel', ['slug_country' => $country->slug,'slug' => $style->slug]) }}"></a>
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