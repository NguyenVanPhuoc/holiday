@php
    //$slug_country = get_slug_country_of_tour($tour->id);
    $tourstyle_item = get_category_tour($tour->cat_id);
    $country_item = get_country_of_tour($tour->id)[0];
    $countCountry = countDestinationsOfTour($tour->id);
@endphp
@desktop
<div class="item">
    <div class="image">
        {!! image($tour->image, 400, 270, $tour->title) !!}
        <h4 class="title-tour white">{{$tour->title}}</h4>
        <div class="hover_tour">
            @if($countCountry==1)
                <a class="link" href="{{ route('tour', ['slug_country'=>$country_item->slug , 'slug'=>$tour->slug]) }}"></a>
                <p class="name white"> - {{ $country_item->title }} -</p>
            @else
                <a class="link" href="{{ route('tourMultiDes', ['slug'=>$tour->slug]) }}"></a>
                <p class="name white"> - Asia - </p>
            @endif
            <h7  class="title-tour yellow" >{{$tour->title}}</h7>
            <div class="cat">
                @if($tourstyle_item) 
                <span class="cate">{{ $tourstyle_item->title }}</span> 
                @endif
                <span class="day"> / {{ getDurationOfTour($tour->id, false) }}</span>
                <span class="price">/ fr. ${{ number_format($tour->price,0,".",",") }}</span> 
            </div>
        </div>
    </div>
    <div class="desc light-graybg">
        <span class="black">{!! str_limit($tour->content, 200) !!}</span>
        <a href="{{ route('tour', ['slug_country'=>$country_item->slug , 'slug'=>$tour->slug]) }}">More</a>
    </div>
</div>
@elsedesktop
<div class="item">
    <div class="image">
        {!! image($tour->image, 400, 270, $tour->title) !!}
        @if($countCountry==1)
            <a class="link" href="{{ route('tour', ['slug_country'=>$country_item->slug , 'slug'=>$tour->slug]) }}"></a>
            <p class="name white"> - {{ $country_item->title }} -</p>
        @else
            <a class="link" href="{{ route('tourMultiDes', ['slug'=>$tour->slug]) }}"></a>
            <p class="name white"> - Asia - </p>
        @endif
        <h7  class="title-tour white" >{{$tour->title}}</h7>
        <div class="cat">
            @if($tourstyle_item) 
            <span class="cate">{{ $tourstyle_item->title }}</span> 
            @endif
            <span class="day"> / {{ getDurationOfTour($tour->id, false) }}</span>
            <span class="price">/ fr. ${{ number_format($tour->price,0,".",",") }}</span> 
        </div>
    </div>
    <div class="desc light-graybg">
        <span class="black">{!! str_limit($tour->content, 250) !!}</span>
        <a href="{{ route('tour', ['slug_country'=>$country_item->slug , 'slug'=>$tour->slug]) }}">More</a>
    </div>
</div>
@enddesktop