@php
    $durations = getListDuration();
@endphp
@desktop 
@if($durations)
    <div class="list-durations row">
        @foreach($durations as $duration)
            <div class="wrapper-item @desktop col-sm-3 @enddesktop">
                <div class="item" >
                    <img src="{!! getImgUrl($duration->white_icon); !!}" alt="white-icon">
                    <h7 class="title-duration white">{{$duration->title}}</h7>
                    <div class="desc_hover">
                        <a class="link_traveltips" href="{{ route('tour', ['slug_country'=>$country->slug,'slug'=>$duration->slug ]) }}"></a>
                        <div class="text-center">
                            <img src="{!! getImgUrl($duration->yellow_icon); !!}" alt="yellow-icon">
                            <h7 class="title_hover yellow">{{$duration->title}}</h7>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif
@elsedesktop 
@if($durations)
    <div class="list-durations slide-dost-duration">
        @foreach($durations as $duration)
            <div class="wrapper-item @desktop col-sm-3 @enddesktop">
                <div class="item" >
                    <a class="link" href="{{ route('tour', ['slug_country'=>$country->slug,'slug'=>$duration->slug ]) }}"></a>
                    <img src="{!! getImgUrl($duration->yellow_icon); !!}" alt="white-icon">
                    <h7 class="title-duration yellow">{{$duration->title}}</h7>
                </div>
            </div>
        @endforeach
    </div>
@endif
@enddesktop