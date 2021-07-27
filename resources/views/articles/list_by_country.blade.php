@php
    if(!$seo){
        $meta_key = $country->title;
        $meta_value = $country->title;
        $title_tag = $country->title_tag;
    }else{
        $meta_key = $seo->key;
        $meta_value = $seo->value;
        $title_tag = $list_country->title_tag;
    }
    // $meta_key = $country->title . ' blog';
    // $meta_value = $country->title . ' blog';
    // $title_tag = $country->title . ' blog';
    $bg_img = getImgUrl($list_country->banner_country); 
    $breadcrumb = Breadcrumbs::render('countryGuide', $country);
    $title_top_h1 = '#' . $country->title.' Blog';
    $post_type_active = 'article';
    $regions = getAllCountryByLevel(1);
    $list_regions = getListRegionInCountry($country->id);
    $durations = getListDuration();
    $styles = getAllCountryTourStyle();

@endphp

@extends('templates.masterBlog')
@section('title', $title_tag)
@section('description', $meta_value)
@section('keywords', $meta_key)
@section('image_url', $bg_img)
@section('content')
<div id="country-blog" class="page blog blog_nvp">
    <div class="container">
        @desktop
            {!! Breadcrumbs::render('countryBlog', $country->title) !!}
        @enddesktop
        <div class="main-top text-center">
            <div class="image-header" style="background-image: url('{{ $bg_img }}');">
                <div class="wrap bottom">
                    <div class="container">
                        <h7 class="small-banner top">- SonaBee Blog -</h7>
                        <h1 class="title-banner">{{$country->title}}</h1>
                    </div>
                </div>  
            </div>
            @handheld
                {!! Breadcrumbs::render('countryBlog', $country->title) !!}
            @endhandheld
            <div class="excerpt">{!!$list_country->desc!!}</div>
        </div>
        <div class="main-bottom">
            <div class="row">
                <div id="content" class="col-md-9">
                    <div class="description"> 
                        @if($list_blog)
                            <div class="list-blog">
                                <div class="row wrap">
                                    @foreach($list_blog as $item) 
                                        @php 
                                            $author = getUser($item->user_id); 
                                        @endphp
                                        @include('articles.item_v2')
                                    @endforeach
                                </div>
                                @if($total > 1)
                                    <div id="load-more">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="total" value="{{ $total }}">
                                        <input type="hidden" name="current" value="1">
                                        <a class="view-more" href="javascript:void(0)" data-href="{{ route('loadMoreBlogCountry', ['slug'=>$country->slug]) }}">View more</a>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
                <div id="sidebar" class="col-md-3">@include('sidebars.country_blog')</div>
            </div>
            <div class="looking looking-tour-mobile"  style="background-image: url('{!! getImgUrl($list_country->banner) !!}');">
                @include('parts.countryTourDetails.search-tour-details')
            </div>
            <div class="tready-yet">
                @php 
                    $pink_tready = getDsMetas(291);
                    $desc_tready = $list_country->content_ready_yet;
                @endphp
                @include('parts.tready-yet')
            </div>
            <div class="places-visit-country slide_owl">
                <div class="container">
                    <h7 class="pink text-center">places to visit in {{$country->title}}</h7>
                    @include('parts.countryTourDetails.places-country')
                </div>
            </div>
            <div class="box-btn">
                <a class="view-tour bot-top" href="{{route('countryPlaceToVisit',['slug'=>$country->slug])}}">{{$country->title}} DESTINATIONS</a>
            </div>
            <div class="places-travel-country slide_owl">
                <div class="container">
                    <h7 class="pink text-center">{{$country->title}} PLANS BY TRAVEL THEME</h7>
                    @include('parts.countryTourDetails.list_tour_style')
                </div>
            </div>
            <div class="places-time-country">
                <div class="container">
                    <h7 class="pink text-center">{{$country->title}} PLANS BY TIME FRAME</h7>
                    @include('parts.countryTourDetails.list_tour_duration')
                </div>
            </div>
            <div class="box-btn">
                <a class="view-tour bot-top" href="{{route('countryTour',['slug'=>$country->slug])}}" class="btn btn-tour">{{$country->title}} tour packages</a>
            </div>
            <div class="request back-none" style="background-image: url({!! getImgUrl($list_country->banner_plants)!!});">
                @php
                    $title_request = "Already got a plan?";
                    $img_request = $list_country->img_plant;
                @endphp
                @include('parts.request')
            </div>
            <div class="preparing slide_owl">
                <div class="container">
                    <h7 class="pink text-center">{{$country->title}} TRAVEL TIPS & GUIDE</h7>
                    <div class="desc_p">{!!$list_country->content_tips!!}</div>
                    @include('parts.countryTourDetails.travel_tips_guide')
                </div>
            </div>
            <div class="another_country slide_owl">
                <div class="container">
                    <h7 class="title pink text-center">CHECK OUT OTHER DESTINATIONS</h7>
                    @include('parts.countryTourDetails.another_country')
                </div>
            </div>
        </div>
    </div>
</div>
@stop