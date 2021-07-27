<div class="container">
	<span class="pink">{!! $title_our_destinations !!}</span>
	@if($destinations)
    @desktop
        <div class="list-country owl-carousel">
            @foreach($destinations as $des)
                <div class="wrapper-item">
                    <div class="item" style="background-image: url('{!! getImgUrl($des->image); !!}')">
                        <h7 class="title-country white"><a href="{{ route('overviewCountry', ['slug_country'=>$des->slug]) }}">{{$des->title}}</a></h7>
                        <div class="desc_hover">
                            <div class="text-center">
                                <img class="bee" src="{{asset('public/images/bee/bee-white.png')}}" alt="bee-white"> 
                                <h7 class="title_hover yellow"><a href="{{ route('overviewCountry', ['slug_country'=>$des->slug]) }}">{{$des->title}}</a></h7>
                                <p class="short_desc">{{$des->short_desc}}</p>
                            </div>
                            <a href="{{ route('overviewCountry', ['slug_country'=>$des->slug]) }}"></a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @elsedesktop
        <div class="slide-dost owl-carousel">
            @foreach($destinations as $des)
                <div class="wrapper-item">
                    <div class="item" style="background-image: url('{!! getImgUrl($des->image); !!}')">
                        <h7 class="title-country white">{{$des->title}}</h7>
                        <a class="link" href="{{ route('overviewCountry', ['slug_country'=>$des->slug]) }}"></a> 
                    </div>
                </div>
            @endforeach
        </div>
    @enddesktop
    @endif
</div>
