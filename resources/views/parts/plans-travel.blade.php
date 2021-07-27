<div class="container">
	<span class="pink">{!! $title_plans !!}</span>
	@if($styles)
    @desktop
        <div class="list-styles-tour owl-carousel">
            @foreach($styles as $style)
                <div class="wrapper-item">
                    <div class="item" style="background-image: url('{!! getImgUrl($style->image); !!}')">
                        <h7 class="title-style-tour white">{{$style->title}}</h7>
                        <div class="desc_hover">
                            <div class="text-center">
                                <img class="bee" src="{{asset('public/images/bee/bee-white.png')}}" alt="bee-white"> 
                                <h7 class="title_hover yellow">{{$style->title}}</h7>
                                @if($destinations)
                                    <div class="list-country-hover">
                                        @foreach($destinations as $desc)
                                         <a href="{{ route('postTypeCountryTravel', ['slug_country'=>$desc->slug , 'slug'=>$style->slug]) }}">{{($desc->title)}}</a>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @elsedesktop
        <div class="slide-dost list-style">
            @foreach($styles as $item)
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
                                    @foreach($destinations as $country)
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
    @enddesktop
    @endif
</div>
