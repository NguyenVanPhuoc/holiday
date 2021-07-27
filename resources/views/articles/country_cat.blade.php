@php
    if($countryCat){
        $title_tag = $countryCat->title_tag;
        $bg_img = getImgUrl($countryCat->image);
        $desc = $countryCat->desc;
    }else{
        $title_tag = $country->title . ' ' . $cat->title . ' blog';
        $bg_img = getImgUrl(getBannerPostByCountry('article', $country->id));
        $desc = '';
    }

    if(!$seo){
        $meta_key = $country->title . ' ' . $cat->title . ' blog';
        $meta_value = $country->title . ' ' . $cat->title . ' blog';
    }else{
        $meta_key = $seo->key;
        $meta_value = $seo->value;
    }
    
    
    $breadcrumb = Breadcrumbs::render('countryGuide', $country);
    $title_top_h1 = '#' . $country->title.' Blog' . ' #' . $cat->title;
    $post_type_active = 'article';
@endphp

@extends('templates.masterBlog')
@section('title', $title_tag)
@section('description', $meta_value)
@section('keywords', $meta_key)
@section('image_url', $bg_img)
@section('content')
<div id="country-cat-blog" class="page blog">
    <div class="container">
        {!! Breadcrumbs::render('countryCatBlog', $country, $cat->title) !!}
        <div class="main-top text-center">
            <div class="banner flex item-center content-center" style="background-image: url('{{$bg_img}}')">
                <h1 class="title">{{ $title_top_h1 }}</h1>
            </div>
            <div class="excerpt">{!! $desc !!}</div>
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
                                            $slugCountry = '#';
                                        @endphp
                                        <div class="col-md-6 inner-wrap">
                                            @include('articles.item')
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            {!! $list_blog->render('custom_view') !!}
                        @endif
                    </div>
                </div>
                <div id="sidebar" class="col-md-3">@include('sidebars.blog')</div>
            </div>
        </div>
    </div>
</div>
@stop