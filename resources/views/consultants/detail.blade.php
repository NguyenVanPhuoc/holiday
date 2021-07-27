@php
    $meta_key = ($seo && $seo->value != null) ? $seo->key : $consultant->title;
    $meta_value = ($seo && $seo->value != null) ? $seo->value : $consultant->title; 
    $title_tag = ($consultant->title_tag != null) ? $seo->title_tag : $consultant->title; 

    $bg_img = getImgUrl($consultant->banner); 
    $breadcrumb = Breadcrumbs::render('blogger', $consultant->title);
    $title_top_h1 = $consultant->title;
    $sub_title_top = $consultant->country->title;
    if($consultant == 'consultant')
        $sub_title_top .=' travel consultant';
    else
        $sub_title_top .=' travel tour guide';
@endphp

@extends('templates.master')
@section('content')
@section('title', $title_tag)
@section('description', $meta_value)
@section('keywords', $meta_key)
@section('image_url', $bg_img)

<div id="consultant" class="consultant-page">
    @include('layouts.top_banner')
    <div class="container">
        <div class="avatar">
            {!! image($consultant->image, 200, 200, $consultant->title) !!}
        </div>
        <div class="section description text-center">
            <div class="box-lightgray">{!! $consultant->desc !!}</div>
        </div>
        
    </div>
    
    @if(!empty($list_tour))
    <div class="section">
        <div class="container">
            <h2 class="title-page green text-center">
                <img src="{{ asset('/public/images/icons/all/tour-green.png') }}" alt="icon">
                <span>
                    Favourite tours                
                </span>
            </h2>
            <div class="box-lightgray">
                <div class="box-desc">{!! $consultant->text_tour !!}</div>
                <div class="slide-style list-tour-2 yellow">
                    @foreach($list_tour as $tour)
                        @include('tours.related_item')
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @endif

    @if(!empty($list_highlight))
    <div class="section">
        <div class="container">
            <h2 class="title-page pink text-center">
                <img src="{{ asset('/public/images/icons/all/highlights-pink.png') }}" alt="icon">
                <span>
                    Favourite places to visit                
                </span>
            </h2>
            <div class="box-lightgray">
                <div class="box-desc">{!! $consultant->text_highlight !!}</div>
                <div class="slide-style list-highlight yellow">
                    @foreach($list_highlight as $item)
                        <div class="item">
                            {!! image($item->image, 400, 270, $item->title) !!}
                            <a class="title" href="#">{{ $item->title }}</a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @endif

    @if(!empty($list_hotel))
    <div class="section">
        <div class="container">
            <h2 class="title-page yellow text-center">
                <img src="{{ asset('/public/images/icons/all/stay-yellow.png') }}" alt="icon">
                <span>
                    Favourite accommodation              
                </span>
            </h2>
            <div class="box-lightgray">
                <div class="box-desc">{!! $consultant->text_hotel !!}</div>
                <div class="slide-style list-hotel yellow">
                    @foreach($list_hotel as $hotel)
                        @include('hotels.item')
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @endif
    
</div>

@endsection