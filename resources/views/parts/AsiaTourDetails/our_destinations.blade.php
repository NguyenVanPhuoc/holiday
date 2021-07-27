@php
    $destinations=getAllMainCountry();
@endphp
@if($destinations)
    <div class="@desktop slide-style @elsedesktop slide-dost @enddesktop list-styles-tour">
        @foreach($destinations as $item)
            <div class="wrapper-item">
                <div class="item" style="background-image: url('{!! getImgUrl($item->image); !!}')">
                    <a href="{{ route('overviewCountry', ['slug_country'=>$item->slug]) }}" class="link"></a>
                    <h7 class="title-country white">{{$item->title}}</h7>
                    <div class="desc_hover">
                        <a class="link_traveltips" href="{{ route('overviewCountry', ['slug_country'=>$item->slug]) }}"  rel="nofollow"></a>
                        <div class="text-center">
                            <img class="bee" src="{{asset('public/images/bee/bee-white.png')}}" alt="bee-white"> 
                            <h7 class="title_hover yellow">{{$item->title}}</h7>
                            <p class="white">{!! $item->short_desc !!}</p>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif