<div class="image-header" style="background-image: url(<?php echo $bg_img; ?>);">
    <div class="wrap">
        <div class="container">
        	@if(isset($icon_top))
            	<img src="{{ $icon_top }}" alt="icon">
            @endif

            @if(isset($title_top_h1))
                <h1 class="title-banner-1">{{ $title_top_h1 }}</h1>
            @elseif(isset($title_top_1))
                <h5 class="title-banner-1">{{ $title_top_1 }}</h5>
            @endif

            @if(isset($sub_title_top))
                <h2 class="sub-title-top">{{ $sub_title_top }}</h2>
            @endif

            <!-- @if(isset($breadcrumb))
                {!! $breadcrumb !!}
            @endif -->

            @if(isset($banner_iconCats) && $banner_iconCats != '')
                {!! $banner_iconCats !!}
            @endif
            
            {{--list things to do--}}
            @if(isset($list_thingToDo) && count($list_thingToDo) > 0 && isset($highlight))
                <ul class="list-unstyled things-to-do">
                    @foreach($list_thingToDo as $item)
                    <li>
                        <a href="{{ $item->getPermalink() }}">
                            <img src="{{ getImgUrl($item->gray_icon) }}" alt="icon">
                            <img src="{{ getImgUrl($item->yellow_icon) }}" alt="icon-active" class="icon-active">
                            <span>{{ $item->title }}</span>
                        </a>
                    </li>
                    @endforeach
                </ul>
            @endif
            {{--end list things to do--}}

            {{--include search box--}}
            @if(isset($include_searchBox))
                <div class="m-t-40 search-highlights text-center">
                    @include($include_searchBox)
                </div>
            @endif
            {{--end include search box--}}

            {{-- if is detail hotel --}}
            @if(isset($post_type_active) && $post_type_active == 'hotel' && isset($hotel))
                <span class="star">{!! getStarOfHotelHtml($hotel->id) !!}</span>
            @endif
            {{-- end if is detail hotel --}}
        </div>
    </div>
</div>