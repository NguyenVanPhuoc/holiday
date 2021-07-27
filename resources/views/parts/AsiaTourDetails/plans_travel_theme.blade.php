@php
 	$list_tour_style = getListTourStyle();
 	$destination = getListMainCountry();
@endphp
@desktop
@if($list_tour_style)
	<div class="slide-style list-guide">
		@foreach($list_tour_style as $item)
            <div class="wrapper-item">
                <div class="item" style="background-image: url('{!! getImgUrl($item->image); !!}')">
                    <h7 class="title-country white">
                        {{$item->title}}
                    </h7>
                    <div class="desc_hover">
                        <div class="text-center">
                            <img class="bee" src="{{asset('public/images/bee/bee-white.png')}}" alt="bee-white"> 
                            <h7 class="title_hover yellow">
                                {{$item->title}}
                            </h7>
                            <ul class="country_cat">
                                @foreach($destination as $country)
                                    <li>
                                        <a href="{{ route('postTypeCountryTravel', ['slug_country'=>$country->slug , 'slug'=>$item->slug]) }}">{{($country->title)}}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
		@endforeach
	</div>
@endif
@elsedesktop
@if($list_tour_style)
    <div class="slide-dost list-style list-travel-nvp">
        @foreach($list_tour_style as $item)
            <div class="wrapper-item">
                <div class="item" style="background-image: url('{!! getImgUrl($item->image); !!}')">
                    <img class="plus" src="{{asset('public/images/icons/Cross-White.png')}}" alt="Plus-white">
                    <h7 class="title-country white">
                        {{$item->title}}
                    </h7>
                    <div class="desc_hover">
                        <div class="text-center">
                            <img class="cross" src="{{asset('public/images/icons/Cross_Yellow.png')}}" alt="Cross-white">
                            <h7 class="title_hover yellow">{{$item->title}}</h7>
                            <ul class="country_cat">
                                @foreach($destination as $country)
                                    <li>
                                        <a href="{{ route('postTypeCountryTravel', ['slug_country'=>$country->slug , 'slug'=>$item->slug]) }}">{{($country->title)}}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif
@enddesktop