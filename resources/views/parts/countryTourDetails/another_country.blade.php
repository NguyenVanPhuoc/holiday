@php
    $another_country=getAnotherCountry($country->id);
@endphp
@if($another_country)
    <div class="@desktop slide-style @elsedesktop slide-dost @enddesktop list-styles-tour">
        @foreach($another_country as $item)
            <div class="wrapper-item">
                <div class="item" style="background-image: url('{!! getImgUrl($item->image); !!}')">
                    @handheld
                     <a class="link" href="{{ route('overviewCountry', ['slug_country'=>$item->slug]) }}"  rel="nofollow"></a>
                    @endhandheld
                    <h7 class="title-country white">{{$item->title}}</h7>
                    <div class="desc_hover">
                        <a class="link_traveltips" href="{{ route('overviewCountry', ['slug_country'=>$item->slug]) }}"  rel="nofollow"></a>
                        <div class="desc">
                            <img class="bee" src="{{asset('public/images/bee/bee-white.png')}}" alt="bee-white"> 
                            <h7 class="title_hover yellow">{{$item->title}}</h7>
                            <div class="white">{!! $item->short_desc !!}</div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif