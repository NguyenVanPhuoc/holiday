@php
    $list_tour_style=getListTourStyleByCountryV1($tour_style->id);
    //dd($list_tour_style);
@endphp
@if($list_tour_style)
    <div class="slide-style list-styles-tour">
        @foreach($list_tour_style as $style)
            <div class="wrapper-item">
                <div class="item" style="background-image: url('{!! getImgUrl($style->image); !!}')">
                    <h7 class="title-country white">{{$style->title}}</h7>
                    <div class="desc_hover">
                        <a class="link_traveltips" href="{{ route('tour', ['slug_country'=>$country->slug,'slug'=>$style->slug ]) }}"></a>
                        <div class="desc">
                            <img class="bee" src="{{asset('public/images/bee/bee-white.png')}}" alt="bee-white"> 
                            <h7 class="title_hover yellow">{{$style->title}}</h7>
                            <div class="white">{!! $style->desc !!}</div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif