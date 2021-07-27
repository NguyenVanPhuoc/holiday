<div class="container">
	<span class="pink">{!! $title_durations !!}</span>
	@if($durations)
        <div class=" @desktop list-durations @elsedesktop slide-dost @enddesktop owl-carousel">
            @foreach($durations as $duration)
                <div class="wrapper-item">
                    <div class="item" >
                        <img src="{!! getImgUrl($duration->white_icon); !!}" alt="white-icon">
                        <h7 class="title-duration white">{{$duration->title}}</h7>
                        <div class="desc_hover">
                            <div class="text-center">
                                <h7 class="title_hover yellow">{{$duration->title}}</h7>
                                @if($destinations)
                                    <div class="list-durations-hover">
                                        @foreach($destinations as $desc)
                                          <a href="{{ route('tour', ['slug_country'=>$desc->slug, 'slug'=>$duration->slug]) }}" title="" class="item-country">{{$desc->title}}</a>  
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>