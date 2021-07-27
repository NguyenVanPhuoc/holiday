@php
    $bg_img = getImgUrl($country_cat->image);
    // $title_tag = ($cat->title_tag) ? $cat->title_tag : $cat->title;
    $title_tag = (isset($country_cat)) ? $country_cat->title_tag : $cat->title;
    $title_top_h1 = $cat->title;

    if(!$seo){
        $meta_key = $cat->title;
        $meta_value = $cat->title;
    }else{
        $meta_key = $seo->key;
        $meta_value = $seo->value;
    }
@endphp

@extends('templates.masterBlog')
@section('title', $title_tag)
@section('description', $meta_value)
@section('keywords', $meta_key)
@section('image_url', $bg_img)
@section('content')
<div id="cat-blog" class="page blog blog_nvp">
    <div class="container">
        @desktop
            {!! Breadcrumbs::render('countryCatBlog',$country, $cat->title) !!}
        @enddesktop
        <div class="main-top text-center">
            <div class="image-header" style="background-image: url('{{ $bg_img }}');">
                <div class="wrap bottom">
                    <div class="container">
                        <h1>
                            <h7 class="small-banner top">- {{ $country->title }} -</h7>
                            <p class="title-banner">{{ $title_top_h1 }}</p>
                        </h1>
                    </div>
                </div>  
            </div>
            @handheld
                {!! Breadcrumbs::render('countryCatBlog',$country, $cat->title) !!}
            @endhandheld
            <div class="excerpt">{!! (isset($country_cat) ? $country_cat->desc : $cat->content) !!}</div>
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
                                        @include('articles.item_v1')
                                    @endforeach
                                </div>
                                @if($total > 1)
                                    <div id="load-more">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="total" value="{{ $total }}">
                                        <input type="hidden" name="current" value="1">
                                        <a class="view-more" href="javascript:void(0)" data-href="{{ route('loadMoreBlogCountryCat', ['country_slug'=>$country->slug,'cate_slug'=>$cat->slug ]) }}">View more</a>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
                <div id="sidebar" class="col-md-3 blog_cate">@include('sidebars.blog_cat_country')</div>
            </div>
        </div>
         <div class="looking looking-tour-mobile"  style="background-image: url('{!! getImgUrl($country_cat->image_looking) !!}');">
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
            <div class="places-time-country slide_owl">
                <div class="container">
                    <h7 class="pink text-center">{{$country->title}} PLANS BY TIME FRAME</h7>
                    @include('parts.countryTourDetails.list_tour_duration')
                </div>
            </div>
            <div class="box-btn">
                <a class="view-tour bot-top" href="{{route('countryTour',['slug'=>$country->slug])}}" class="btn btn-tour">{{$country->title}} tour packages</a>
            </div>
            <div class="request back-none" style="background-image: url({!! getImgUrl($country_cat->image_request)!!});">
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
                    <div class="title-sec">
                        <h7 class="title pink text-center">CHECK OUT OTHER DESTINATIONS</h7>
                    </div>
                     @include('parts.countryTourDetails.another_country')
                </div>
            </div>
    </div>
</div>
@stop