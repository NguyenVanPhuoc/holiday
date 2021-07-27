@php
 	$list_duration = getListDuration();
 	$destination = getListMainCountry();
@endphp
@if($list_duration)
    <div class="list-durations @desktop slide-style @elsedesktop slide-dost @enddesktop asia_duration">
        @foreach($list_duration as $duration)
            <div class="wrapper-item">
                <div class="item" >
                    <img src="{!! getImgUrl($duration->white_icon); !!}" alt="white-icon">
                    <h7 class="title-duration white">{{$duration->title}}</h7>
                    <div class="desc_hover">
                        <h7 class="title_hover yellow">{{$duration->title}}</h7>
                        @if($destination)
                            <div class="list-durations-hover">
                                @foreach($destination as $desc)
                                  <a href="{{ route('tour', ['slug_country'=>$desc->slug, 'slug'=>$duration->slug]) }}" title="" class="item-country">{{$desc->title}}</a>  
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif
