@php
    $bg_img = getImgUrl($cat->image);
    $bg_looking= getImgUrl($cat->image_looking);
    $bg_request= getImgUrl($cat->image_request);
    $title_tag =$cat->title_tag;
    $title_top_h1 = $cat->title;
    $meta_key = ($seo && $seo->key != '') ? $seo->key : '';
    $meta_value = ($seo && $seo->value != '') ? $seo->value : '';
    $regions = getAllCountryByLevel(1);
    $durations = getListDuration();
    $styles = getAllCountryTourStyle();
    $list_country = getAllCountryByLevel(1);
    $destinations = getListMainCountry();
@endphp

@extends('templates.masterBlog')
@section('title', $title_tag)
@section('description', $meta_value)
@section('keywords', $meta_key)
@section('image_url', $bg_img)
@section('content')
<div id="cat-blog" class="page blog">
    <div class="container">
        @desktop
        {!! Breadcrumbs::render('categoryBlog', $title_top_h1) !!}
        @enddesktop
        <div class="main-top text-center">
            <div class="image-header" style="background-image: url('{{ $bg_img }}');">
                <div class="wrap bottom">
                    <div class="container">
                        <h3 class="small-banner top">- SonaBee Blog -</h3>
                        <h1 class="title-banner">ASIA {{ $title_top_h1 }}</h1>
                    </div>
                </div>  
            </div>
            @handheld
                {!! Breadcrumbs::render('categoryBlog', $title_top_h1) !!}
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
                                        <a class="view-more" href="javascript:void(0)" data-href="{{ route('loadMoreCat', ['slug_cat'=>$cat->slug ]) }}">View more</a>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
                <div id="sidebar" class="col-md-3">@include('sidebars.blog_cat')</div>
            </div>
        </div>
    </div>
    <div class="looking looking-tour-mobile"  style="background-image: url('{{ $bg_looking }}');">
        @include('parts.looking-tour')
    </div>
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
    <a class="view-tour bot-top" href="{{ route('asiaTour')}}">All tour packages</a>
    <div class="request back-none" style="background-image: url('{{ $bg_request }}')">
        @php
            $img_request = getDsMetas(300);
            $title_request = getDsMetas(301);
        @endphp
        @include('parts.request')
    </div>
    <div class="preparing light-graynvp slide_owl">
        @php
            $title = getDsMetas(302);
            $desc = getDsMetas(303);
        @endphp
        <div class="header-sec text-center">
            <div class="title-sec">
                <h7 class="title pink">{{ $title }}</h7>
            </div>
            <div class="desc_p">{!! $desc !!}</div>
        </div>
        <div class="container">
            @include('parts.list_nation')
        </div>
    </div>
</div>
@stop