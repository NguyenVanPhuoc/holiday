@php
    $bg_img = getImgUrl($blogger->image);
    $bg_banner = getImgUrl($blogger->banner);
    $title_tag = ($blogger->title_tag != '') ? $blogger->title_tag : $blogger->title;
    $meta_key = (!empty($seo) && $seo->key != '') ? $seo->key : $blogger->title;
    $meta_value = (!empty($seo) && $seo->value != '') ? $seo->value : $blogger->title;

    $array_articleID = ($blogger->favourite_article != '') ? explode(",", $blogger->favourite_article) : [];
    $array_highlightID = ($blogger->favourite_highlight != '') ? explode(",", $blogger->favourite_highlight) : [];

    $list_favouriteBooks = ($blogger->favourite_books != '') ? json_decode($blogger->favourite_books ) : [];
    $list_favouriteArticles = getArticlesByArrayId($array_articleID);
    $list_highlight = getPlacesToVisitByArrayID($array_highlightID);

@endphp

@extends('templates.masterBlog')
@section('title',  $title_tag)
@section('description', $meta_value)
@section('keywords', $meta_key)
@section('content')
<div id="blogger" class="page blog">
    <div class="container">
        {!! Breadcrumbs::render('blogger', $blogger->title) !!}
        <div class="main-top text-center">
            <div class="banner flex item-center" style="background-image: url('{{$bg_banner}}')">
                <h1 class="title">{{ $blogger->title }}</h1>
                <h2 class="sub-title">Blog writer</h2>
                <div class="thumb">
                    <div class="hexagonImg hexagonImg1">
                        <div class="wrap hexagonImg-in1">
                            <a style="background-image: url({{$bg_img}});" data-group="gallery" class="hexagonImg-in2" >
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="main-bottom">
            <div class="row">
                <div id="content" class="col-md-9">             
                    <div class="wrap-content">
                        <div class="desc section">
                            <div class="top-title">
                                <h3 class="title-sec">My biography</h3>
                                <ul class="list-unstyled socials">
                                    <li class="facebook">
                                        <a href="{{ $blogger->facebook }}" target="_blank">
                                            <i class="fa fa-facebook" aria-hidden="true"></i>
                                        </a>
                                    </li>
                                    <li class="twitter">
                                        <a href="{{ $blogger->twitter }}" target="_blank">
                                            <i class="fa fa-twitter" aria-hidden="true"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="content-desc">{!! $blogger->desc !!}</div>
                            @if($blogger->short_desc != '')
                                <p class="slogan">
                                    <span class="pink">Favourite travel quote : </span>
                                    <span>"{{ $blogger->short_desc }}"</span>
                                </p>
                            @endif
                        </div>

                        @if(!empty($list_favouriteArticles))
                        <div class="section favourite-books-sec">
                            <h3 class="title-sec">My favourite books</h3>
                            <div class="slide-two-item list-blog">
                                @foreach($list_favouriteArticles as $item)
                                    @include('articles.item')
                                @endforeach
                            </div>
                        </div>
                        @endif
                        
                        @if(!empty($list_favouriteBooks))
                        <div class="section favourite-article-sec">
                            <h3 class="title-sec">My favourite books</h3>
                            <div class="slide-style list-favourite-book">
                                @foreach($list_favouriteBooks as $item)
                                    @php
                                        $img_url = getImgUrl($item->image);
                                    @endphp
                                    <div class="item text-center">
                                        <a href="{{ $item->link }}" class="thumb" rel="nofollow">
                                            <!-- <img src="{{ $img_url }}" alt="{{ $item->title }}"> -->
                                            {!! image($item->image, 120, 160, $item->title) !!}
                                        </a>
                                        <p class="title">
                                            <a href="{{ $item->link }}" rel="nofollow">{{ $item->title }}</a>
                                        </p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        @if(!empty($list_highlight))
                        <div class="section">
                            <h3 class="title-sec">My favourite places to visit</h3>
                            <div class="slide-style list-highlight">
                                @foreach ($list_highlight as $item)
                                <div class="item">
                                    {!! image($item->image, 400, 270, $item->title) !!}
                                    <a href="#" class="title">{{ $item->title }}</a>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        @if(!empty($list_blogger))
                        <div class="section">
                            <h3 class="title-sec">Discover more blog writers</h3>
                            <div class="slide-style list-blogger">
                                @foreach ($list_blogger as $item)
                                <div class="item text-center">
                                    <a href="{{ route('postType', $item->slug) }}" class="thumb" style="background-image: url({{ $bg_img = getImgUrl($item->image) }});">
                                    </a>
                                    <a href="{{ route('postType', $item->slug) }}" class="title">{{ $item->title }}</a>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                <div id="sidebar" class="col-md-3">@include('sidebars.blog')</div>
            </div>
        </div>
    </div>

</div>

@stop