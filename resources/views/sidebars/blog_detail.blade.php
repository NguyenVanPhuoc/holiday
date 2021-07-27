@php 
    $categories = get_categories();
    $cat_slug = empty($cat)? '' : $cat->slug;
    $countries = getAllMainCountry();
    $country_slug = empty($country) ? '' : $country->slug;  
    $name = ($countCountry == 1) ? $country->title : 'Asia';
@endphp
@desktop
@if($categories)
<aside id="sb-categories">
    <h7 class="sb-title">Explore {{$name}}</h7>
    <div class="desc">
        <ul class="list-cat no-list-style">
            @foreach($categories as $item)
            <li <?php if($cat_slug == $item->slug) echo ' class="active"';?>>
                @if($countCountry==1)
                    <a href="{{ route('blogCountryCate', ['country_slug'=>$country->slug, 'cat_slug'=> $item->slug]) }}"<?php if($item->slug == $cat_slug) echo ' class="active"';?>>{{$item->title}}</a>
                @else
                    <a href="{{ route('blogCall', ['slug'=> $item->slug]) }}"<?php if($item->slug == $cat_slug) echo ' class="active"';?>>{{$item->title}}</a>
                @endif
            </li>
            @endforeach
        </ul>
    </div>
</aside>
@endif
@if($topBlog)
<aside id="sb-view">
    <h7 class="sb-title">TOP POSTS</h7>
    <div class="desc">
        <ul class="list no-list-style">
            @foreach($topBlog as $item)
            <li class="flex content-between">
                <a class="thumb" href="{{ $item->getPermalink() }}">{!!image($item->image,60,60,$item->title)!!}</a>
                <h7 class="title"><a href="{{ $item->getPermalink() }}">{{str_limit($item->title, 80,'')}}</a></h7>
            </li>
            @endforeach
        </ul>
    </div>
</aside>
@endif
<aside id="sb-social">
    <h7 class="sb-title">Socials</h7>
    <div class="desc">
        <ul class="list no-list-style">
            {!! socialBlog() !!}
        </ul>
    </div>
</aside>

<aside id="sb-contact" class="gr-fixed-nvp">
    <a href="#" class="thumb"><img src="{{asset('public/images/request-free-sub.jpg')}}" alt="bigg_icon"></a>
    <div class="desc-contact">
        <h7 class="title">24-hour response guaranteed</h7>
        <a href="{{ route('createMyTrip') }}" title="" class="btn btn-request">request a free quote</a>
    </div>
</aside>

<div class="group-fixed-table">
    @if($relatedBlog)
        @php 
            $list_blog = explode(',',$relatedBlog->list_blog);
        @endphp
        <div class="related_post">
            <h7 class="sb-title">RELATED POSTS</h7>
            <div class="desc">
                <ul class="list no-list-style">
                    @foreach($list_blog as $item)
                    @php 
                        $style = getArticle($item);
                    @endphp
                    @if($style != '')
                    <li class="flex content-between">
                        <a class="thumb" href="{{ $style->getPermalink() }}">{!!image($style->image,60,60,$style->title)!!}</a>
                        <h7 class="title"><a href="{{ $style->getPermalink() }}">{{str_limit($style->title, 80,'')}}</a></h7>
                    </li>
                    @endif
                    @endforeach
                </ul>
            </div>
        </div>
    @endif
    <div class="table-list table-list-schedule">
        <div class="table-content">
            <h7 class="sb-title">TABLE OF CONTENT</h7>
            <div class="fix_content">
                <div class="table-body scrollbar-inner">
                    <div class="wrap-body">
                        @if($tableContent)
                            <ol>
                            @php
                                $tableLevel1s = getTableDetailLevel1($tableContent->id); 
                            @endphp
                            @if($tableLevel1s) <!--Level 1-->
                                @foreach($tableLevel1s as $key => $level1)
                                    {!! getHeadingTbContent($level1->id) !!}
                                @endforeach
                            @endif
                        </ol>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@elsedesktop
@php
    $another_country=getAnotherCountry($country->id);
@endphp
@if($categories)
    <div class="mobi-discover light-graynvp blog_topics">
        <h7 class="title-menu pink text-center">EXPLORE {{ $country->title }}</h7>
        <div class="row">
            @foreach($categories as $item)
                <div class="col-sm-6 col-xs-6 item text-center">
                    <a class="thumb_img" href="{{ route('blogCountryCate', ['country_slug'=>$country->slug, 'cat_slug'=> $item->slug]) }}">
                        {!!image($item->image,120,120,$item->title)!!}
                        <h3 class="title">{!!$item->title!!}</h3>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@endif
@if($another_country)
    <div class="mobi-discover light-graynvp">
        <h7 class="title-menu pink text-center">DISCOVER</h7>
        <div class="row">
            @foreach($another_country as $item)
                <div class="col-sm-6 col-xs-6 item text-center">
                    <a class="thumb_img" href="{{route('blogCall',$item->slug)}}">
                        {!!image($item->image,120,120,$item->title)!!}
                        <h3 class="title">{!!$item->title!!}</h3>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@endif
@enddesktop


