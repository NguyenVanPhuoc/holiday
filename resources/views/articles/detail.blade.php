@php
    $bg_img = getImgUrl($blog->image);
    $title_tag = ($blog->title_tag != '') ? $blog->title_tag : $blog->title;
    $meta_key = (!empty($seo) && $seo->key != '') ? $seo->key : $blog->title;
    $meta_value = (!empty($seo) && $seo->value != '') ? $seo->value : $blog->title;
@endphp

@extends('templates.masterBlog')
@section('title', $title_tag)
@section('description', $meta_value)
@section('keywords', $meta_key)
@section('content')
@php
    set_view($blog->id);
    $slugCountry = getSlugCountryOfBlog($blog->id);
    $tableContent = getTableContent($blog->id, 'article');
    $destinations = getListMainCountry();
    $styles = getAllCountryTourStyle();
    $regions = getAllCountryByLevel(1);
    $durations = getListDuration();
    //dd($blog->updated_at);
@endphp
<div id="blog-detail" class="page blog-single blog">
    <div class="main-bottom">
        @desktop
        {!! Breadcrumbs::render('blogDetail', $country, $blog) !!}
        @enddesktop
        <div class="container">
            <div class="row">
                <div id="content" class="col-md-9 clearfix">
                    <figure class="banner banner_nvp" >
                        <img src="{{ getImgUrl($blog->image) }}" class="banner_img">
                            <div class="flex item-center flex-col">
                                @if($countCountry==1)
                                <span class="white text-center">- {{ $country->title}} / {{ $cates->title}} -</span>
                                @else
                                <span class="white text-center">- Asia / {{ $cates->title}} -</span>
                                @endif
                                <h1 class="title">{{$blog->title}}</h1>
                            </div>
                        @desktop
                            <div class="top-desc text-center">
                                @if($blog->blogger_id != '')
                                <span class="name"><img src="{{ asset('public/images/icons/blog/Writer - 100px.png') }}" alt="Writer"><a href="#scroll_name">{{ $blog->blogger->title }}</a></span>
                                @endif
                                <span class="date" data-toggle="tooltip" data-placement="top" title="Last updated"><img src="{{ asset('public/images/icons/blog/date icon - 100px.png') }}" alt="Date icon">{{dateShow($blog->updated_at)}}</span>
                            </div>
                            <aside id="sb-share">
                                <h7 class="sb-title">SHARE</h7>
                                <div class="desc">
                                    <ul class="list no-list-style">
                                        {!! socialBlog() !!}
                                    </ul>
                                </div>
                            </aside>
                        @enddesktop
                    </figure>
                    @handheld
                        {!! Breadcrumbs::render('blogDetail', $country, $blog) !!}
                    
                    <div class="blogger_mobi">
                        <div class="top-desc">
                            @if($blog->blogger_id != '')
                            <p class="name"><img src="{{ asset('public/images/icons/blog/Writer - 100px.png') }}" alt="Writer"><a href="#scroll_name">{{ $blog->blogger->title }}</a></p>
                            @endif
                            <p class="date" data-toggle="tooltip" data-placement="top" title="Last updated"><img src="{{ asset('public/images/icons/blog/date icon - 100px.png') }}" alt="Date icon"><span>{{dateShow($blog->updated_at)}}</span></p>
                        </div>
                        <aside id="sb-share">
                                <h7 class="sb-title">SHARE</h7>
                                <div class="desc">
                                    <ul class="list no-list-style">
                                        {!! socialBlog() !!}
                                    </ul>
                                </div>
                            </aside>
                    </div>
                    @endhandheld
                    <div class="content_blog">
                        @if ($blog->content)
                            <div class="excerpt">{!! $blog->content !!}</div>
                        @endif
                        
                        <div class="table-heading">
                            <div class="header-heading font-semibold">
                                <h7 class=" title_span">{{ __('Table of content') }}</h7>
                                <span class="bar-heading">
                                    [
                                    <a href="#" class="collapse-bar yellow">{{ __('Hide') }}</a>
                                    <a href="#" class="expand-bar hide yellow">{{ __('Show') }}</a>
                                    ]
                                </span>
                            </div>
                            <div class="list-heading">
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
                        <div class="list-tb-content">
                            @if($tableContent)
                                @php
                                    $tableLevel1s = getTableDetailLevel1($tableContent->id); 
                                @endphp
                                @if($tableLevel1s) <!--Level 1-->
                                    @foreach($tableLevel1s as $key => $level1)
                                        {!! getContentTbContent($level1->id) !!}
                                    @endforeach
                                @endif
                            @endif
                        </div>
                        @handheld
                        <div class="plus-table-guide">
                            <div class="transparent-open">
                                <div class="plus-open">
                                    <img src="{{asset('public/images/icons/close.png')}}" alt="bigg_icon">
                                </div>
                                <div class="table_related">
                                    <p class="table_open">TABLE OF CONTENT</p>
                                    <p class="related_post">RELATED POSTS</p>
                                    <span class="closes"><img src="{{asset('public/images/icons/close.png')}}" alt="closes"></span>
                                </div>
                            </div>
                            <div class="list-guide-mobi table-blog-mobi">
                                <h7 class="title">TABLE OF CONTENT</h7>
                                <span class="closes close_tab"><img src="{{asset('public/images/icons/close.png')}}" alt="closes"></span>
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
                            @if($relatedBlog)
                                @php 
                                    $list_related = explode(',',$relatedBlog->list_blog);
                                @endphp
                                <div class="list-guide-mobi related-mobi">
                                    <h7 class="title">RELATED POSTS</h7>
                                    <span class="closes close_tab"><img src="{{asset('public/images/icons/close.png')}}" alt="closes"></span>
                                    <div class="related-body scrollbar-inner">
                                        <ul>
                                            @foreach($list_related as $item)
                                            @php 
                                                $style = getArticle($item);
                                            @endphp
                                            @if($style != '')
                                            <li>
                                                <a href="{{ $style->getPermalink() }}">{{ $style->title }}</a>
                                            </li>
                                            @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            @endif
                        </div>
                        @endhandheld
                        <div class="back-to-start"></div>
                    </div>
                </div>
                @handheld
                    @if(count($list_blog) > 0)
                        <div class="section-blog slide_owl light-graynvp">
                            <div class="container">
                                <div class="header-sec text-left">
                                    <div class="title-sec">
                                        <span class="title pink">SIMILAR BLOG ARTICLES</span>
                                    </div>
                                </div>
                                <div class="slide-tour-dost list-blog">
                                    @foreach($list_blog as $key => $item)
                                        @include('articles.item')
                                    @endforeach
                                    @if($list_blog_v1)
                                        @foreach($list_blog_v1 as $key => $item)
                                            @include('articles.item')
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                @endhandheld
                <div id="sidebar" class="col-md-3 content-guide">@include('sidebars.blog_detail')</div>
            </div>
        </div>
        @desktop
        <div class="request mar_nvp" style="background-image: url('{!! getImgUrl($blog->image_request1) !!}')">
            @php
                $img_request = getDsMetas(300);
                $title_request = '24-hour response <br> guaranteed!';
            @endphp
            @include('parts.request')
        </div>
        <div class="author_comment">
            @if($blog->blogger_id != '')
                @php
                    $author_img = getImgUrl($blog->blogger->image);
                    $list_social = ($blog->blogger->social_icon != '') ? json_decode($blog->blogger->social_icon ) : [];
                @endphp
                <div class="author" id="scroll_name">
                    <div class="desc">
                        <div class="top-title">
                            <ul class="list-unstyled socials">
                                @foreach($list_social as $item)
                                    <li class="facebook"><a href="{{ $item->link }}" rel="nofollow" target="_bank">{!! image($item->image, 32, 32, $item->title) !!}</a></li>
                                @endforeach
                            </ul>
                            <span class="title">
                                <a href="#">{{ $blog->blogger->title }}</a>
                            </span>
                        </div>
                        <div class="text">{!! $blog->blogger->desc !!}</div>
                    </div>
                    <a class="thumb" href="#" style="background-image: url({{ $author_img }});"></a>
                </div>
            @endif
            <span class="pink comments">Comments</span>
            <div class="comment-face">
                <div class="fb-comments" data-href="{{ $blog->getPermalink() }}" data-width="100%" data-height="100px" data-numposts="5"></div>
            </div>
        </div>
        @if(count($list_blog) > 0)
            <div class="section-blog slide_owl light-graynvp">
                <div class="container">
                    <div class="header-sec text-left">
                        <div class="title-sec">
                            <span class="title pink">SIMILAR BLOG ARTICLES</span>
                        </div>
                    </div>
                    <div class="slide-style list-blog">
                        @foreach($list_blog as $key => $item)
                            @include('articles.item')
                        @endforeach
                        @if($list_blog_v1)
                            @foreach($list_blog_v1 as $key => $item)
                                @include('articles.item')
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        @endif
        @enddesktop 
        <div class="looking looking-tour-mobile"  style="background-image: url('{!! getImgUrl($blog->image_looking) !!}');">
            @include('parts.looking-tour')
        </div>
        <div id="country-blog">
            @if($countCountry==1)
            <div class="tready-yet">
                @php 
                    $pink_tready = getDsMetas(291);
                    $desc_tready = $list_country->content_ready_yet;
                @endphp
                @include('parts.tready-yet')
            </div>
            <div class="places-visit-country slide_owl">
                <div class="container">
                    <span class="pink text-center">places to visit in {{$country->title}}</span>
                    @include('parts.countryTourDetails.list_places_to_visit')
                </div>
            </div>
            <div class="box-btn">
                <a class="view-tour bot-top" href="{{route('countryPlaceToVisit',['slug'=>$country->slug])}}">{{$country->title}} DESTINATIONS</a>
            </div>
            <div class="places-travel-country">
                <div class="container">
                    <span class="pink text-center">{{$country->title}} PLANS BY TRAVEL THEME</span>
                    @include('parts.countryTourDetails.list_tour_style')
                </div>
            </div>
            <div class="places-time-country">
                <div class="container">
                    <span class="pink text-center">{{$country->title}} PLANS BY TIME FRAME</span>
                    @include('parts.countryTourDetails.list_tour_duration')
                </div>
            </div>
            <div class="box-btn">
                <a class="view-tour bot-top" href="{{route('countryTour',['slug'=>$country->slug])}}" class="btn btn-tour">{{$country->title}} tour packages</a>
            </div>
            <div class="request back-none" style="background-image: url({!! getImgUrl($blog->image_request2) !!});">
                @php
                    $title_request = "Already got a plan?";
                    $img_request = $list_country->img_plant;
                @endphp
                @include('parts.request')
            </div>
            <div class="preparing all-detail slide_owl">
                <div class="container">
                    <span class="pink text-center">{{$country->title}} TRAVEL TIPS & GUIDE</span>
                    <div class="desc_p">{!!$list_country->content_tips!!}</div>
                    @include('parts.countryTourDetails.travel_tips_guide')
                </div>
            </div>
            <div class="another_country">
                <div class="container">
                    <span class="title pink text-center">CHECK OUT OTHER DESTINATIONS</span>
                    @include('parts.countryTourDetails.another_country')
                </div>
            </div>
        </div>
            @else
        <div id="blog">
                <div class="tready-yet">
                    @php 
                        $pink_tready = getDsMetas(291);
                        $desc_tready = getDsMetas(292);
                    @endphp
                    @include('parts.tready-yet')
                </div>
                <div class="our-destinations">
                    @php 
                        $title_our_destinations = getDsMetas(295);
                    @endphp
                    @include('parts.our-destinations')
                </div>
                <div class="plans-travel blog_nvp_js">
                    @php
                        $title_plans = getDsMetas(296);
                    @endphp
                    @include('parts.plans-travel')
                </div>
                <div class="plans-time">
                    @php
                        $title_durations = getDsMetas(298);
                    @endphp
                    @include('parts.plans-time')
                </div>
                <div class="box-btn">
                    <a class="view-tour bot-top" href="{{ route('asiaTour')}}">View all tours</a>
                </div>
                <div class="request back-none" style="background-image: url({!! getImgUrl($blog->image_request2) !!});">
                    @php
                        $img_request = getDsMetas(300);
                        $title_request = getDsMetas(301);
                    @endphp
                    @include('parts.request')
                </div>
                <div class="preparing light-graynvp slide_owl ">
                    @php
                        $title = getDsMetas(302);
                        $desc = getDsMetas(303);
                    @endphp
                    <div class="container">
                        <div class="header-sec text-center">
                            <div class="title-sec">
                                <span class="title pink">{{ $title }}</span>
                            </div>
                            <div class="desc_p">{!! $desc !!}</div>
                        </div>
                        @include('parts.list_nation')
                    </div>
                </div>
            @endif
        </div>
</div>
<script type="text/javascript">
    $('ul.pagination').hide();
    $(function() {
        $('.infinite-scroll').jscroll({
            autoTrigger: true,
            loadingHtml: '<img class="center-block" src="/public/images/loading_red.gif" alt="Loading..." />',
            padding: 0,
            nextSelector: '.pagination li.active + li a',
            contentSelector: 'div.infinite-scroll',
            callback: function() {
                $('ul.pagination').remove();
            }
        });
    });
</script>
@stop