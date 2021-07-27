@php
    $meta_key = ($seo && $seo->key != '') ? $seo->key : $review->name;
    $meta_value = ($seo && $seo->value != '') ? $seo->value : $review->name; 
    $title_tag = ($review->title_tag != '') ? $review->title_tag : $review->name;

    $bg_img = getImgUrl($review->banner, $review->name); 
    $bg_looking= getImgUrl($review->image_looking);
    $bg_request= getImgUrl($review->image_request);
    $breadcrumb = Breadcrumbs::render('detailReview', $review->name);
    $title_top_h1 = $review->name;
    $sub_title_top = 'Clients feedback';
    $from_date = date('d M. Y', strtotime($review->from_date));
    $to_date = date('d M. Y', strtotime($review->to_date));
    $destinations = getListDestinationOfReview($review->id, 'title');
    $regions = getAllCountryByLevel(1);
    $durations = getListDuration();
    $styles = getAllCountryTourStyle();
@endphp

@extends('templates.master')
@section('content')
@section('title', $title_tag)
@section('description', $meta_value)
@section('keywords', $meta_key)
@section('image_url', $bg_img)

<div id="detail-review" class="singe-post detail-review">
    @desktop
    <div class="image-header" style="background-image: url(<?php echo $bg_img; ?>);">
    @elsedesktop
    <div class="image-header" style="background-image: url('{{ getImgUrl($review->image,$review->title) }}');">
    @enddesktop
        <div class="wrap bottom">
            <div class="container">
                @if(isset($breadcrumb))
                    {!! $breadcrumb !!}
                @endif
                <h1 class="title-banner-1">{{ $title_top_h1 }}</h1>
            </div>
        </div>
    </div>
    <div class=" light-graynvp"> 
        @desktop
        <div class="avatar">   
            {!! image($review->image, '230','230', $review->title) !!}
        </div>
        @enddesktop
        <div class="couple graybg">
            <div class="container">
                <ul class="list-cmd">
                    <li class="first">
                        <span class="icon"><img src="{{ asset('public/images/Group type.png') }}" alt="icon-filter"></span>
                        <span class="font-semibold">{{ $review->group_type->title }}</span>
                    </li>
                    <li class="center">
                        <span class="icon"><img src="{{ asset('public/images/Tour style - star.png') }}" alt="icon-filter"></span>
                        @foreach($list_title_style as $key => $item)
                            <span  class="font-semibold">{{ $item->title }} {{ $key != count($list_title_style)-1 ? ', ' : ''}}</span>
                        @endforeach
                    </li>
                    <li class="last">
                        <span class="icon"><img src="{{ asset('public/images/Calendar.png') }}" alt="icon-filter"></span>
                        <span class="date font-semibold">{{ $from_date }} - {{ $to_date }}</span>
                    </li>
                </ul>
                 @if($list_city)
                    <ul class="list-itinerary list-unstyled text-center">
                        <span class="white font-semibold">Itinerary in brief:</span>
                        @foreach($list_city as $key => $item)
                        @php
                            $country_v1=getSlugCountryById($item->parent_id);
                            $country=getSlugCountryById($country_v1->parent_id);
                        @endphp
                            <li>
                                @if($key > 0)
                                    <span>-</span>
                                @endif
                                <a href="{{ route('postTypeCountryTravel', ['slug_country'=>$country->slug,'slug'=>$item->slug ]) }}" target="_blank">{{ $item->title }}</a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
        @handheld
            <div class="light-graynvp since-mobi">
                <span class="title">{!! $review->title !!}</span>
            </div>
        @endhandheld
        <div class="gall_conte graybg">
            <div class="container">
                <div class="row reversed">
                    <div class="col-md-6 col col-dnmb">
                        <div class="desc_vp white">
                            <div class="desc">
                                {!! $review->content !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col">
                        <div class="@desktop slide-one-item @elsedesktop slide-tour-dost @enddesktop">
                            @if($review->gallery)
                                @php 
                                    $array_img = json_decode($review->gallery); 
                                @endphp
                                @if(count($array_img) > 0)
                                @foreach($array_img as $key => $img_id)
                                    @php
                                        $img = getMedia($img_id);
                                    @endphp
                                    @if($img)
                                        <div class="item" style="background-image: url('{{asset('/public/uploads/'.$img->image_path)}}');"></div>
                                    @endif
                                @endforeach
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @desktop
        <div class="list-partner graybg text-center">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 experience">
                        <img src="{{asset('public/images/temp/step 2.png')}}" alt="image">
                        <h3 class="title">{{ __('You are welcome to share your experience...')}}</h3>
                    </div>
                    <div class="col-md-8 list_exper">
                        <div class="item">
                            <a href="#" target="_blank">
                                <img src="{{asset('public/images/temp/Tripadvisor-grey.png')}}" alt="image">
                            </a>
                        </div>
                        <div class="item size_fit">
                            <a href="#" target="_blank">
                                <img src="{{asset('public/images/temp/Petit fute.png')}}" alt="image">
                            </a>
                        </div>
                        <div class="item size_thumb">
                            <a href="#" target="_blank">
                                <img src="{{asset('public/images/temp/facebook.png')}}" alt="image">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @enddesktop
        <div class="explore_asia ">
            <div class="container">
                <div class="header-sec text-center">
                    <div class="title-sec">
                        <span class="title pink">OTHER RECENT REVIEWS</span>
                    </div>
                </div>
                <div class="sec-content">
                    <div class=" @desktop row @elsedesktop slide-dost @enddesktop">
                        @if($list_otherReviews)
                            @foreach($list_otherReviews as $item)
                                <div class="col-md-4 padding_auto">
                                    @php
                                        $From_date = new DateTime($item->from_date);
                                        $To_date = new DateTime($item->to_date);
                                        $days  = $To_date->diff($From_date)->format('%a');
                                        $to_date = date('F Y', strtotime($item->to_date));
                                        $tourstyle_ids = array_filter(explode(',', $item->list_tour_style));
                                        if($tourstyle_ids) {
                                            $tourstyle_text = '';
                                            $tour_title = get_title_category_tour($tourstyle_ids[0]);
                                            if($tour_title) $tourstyle_text .= $tour_title->title;
                                        }else $tourstyle_text = false;
                                    @endphp 
                                    <div class="wrap_review graybg">
                                        <div class="item">
                                            <h7 class="title_review"><a href="{{ route('detailClientReview',['slug'=>$item->slug]) }}">{{ $item->title }}</a></h7>
                                            <div class="desc">
                                                {!! str_limit($item->content, 210) !!}
                                                <a href="{{ route('detailClientReview',['slug'=>$item->slug]) }}">More</a>
                                            </div>
                                            <div class="rv_author">
                                                <a href="{{ route('detailClientReview',['slug'=>$item->slug]) }}" class="thumb">
                                                    {!! image($item->image, 80, 80, $item->name) !!}
                                                </a>
                                                <span class="name">{{ $item->name }}</span>
                                                <span class="day">{{ $to_date }}</span>
                                            </div>
                                            <div>
                                                <span>{{getTitleOfGroupType($item->group_type_id)}} / </span>
                                                <span>{{ $days + 1 }} days</span> 
                                                <span> / {{ $tour_title->title }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
            <div class="bot-tour top-bot">
                <a href="{{ route('clientsReview') }}" class="btn btn-tour">CHECK ALL REVIEWS</a>
            </div>
        </div>
    </div>
    <div class="content-places">
        <div class="looking looking-tour-mobile"  style="background-image: url('{{ $bg_looking }}');">
            @include('parts.looking-tour')
        </div>
        <div class="tready-yet light-graynvp">
            <div class="container">
                <div class="header-sec text-center">
                    <div class="title-sec">
                        <span class="title pink">NOT READY YET?</span>
                    </div>
                    <div class="desc_p">
                        {!! getDsMetas(305) !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="our_destinations padding_center light-graybg asia_our">
            <div class="container">
                <div class="header-sec text-center">
                    <div class="title-sec">
                        <span class="title pink">OUR DESTINATIONS</span>
                    </div>
                </div>
                 @include('parts.AsiaTourDetails.our_destinations')
            </div>
        </div>
        <div class="plans-travels light-graybg padding_center slide_owl">
            <div class="container">
                <div class="header-sec text-center">
                    <div class="title-sec">
                        <span class="title pink">PLANS BY TRAVEL THEME</span>
                    </div>
                </div>
                 @include('parts.AsiaTourDetails.plans_travel_theme')
            </div>
        </div>
        <div class="plans-time light-graynvp">
            <div class="padding_center">
                <div class="container">
                    <div class="header-sec text-center">
                        <div class="title-sec">
                            <span class="title pink">PLANS BY TIME FRAME</span>
                        </div>
                    </div>
                    @include('parts.AsiaTourDetails.plans_time_frame')
                </div>
            </div>
        </div>
        <div class="bot-tour top-bot">
            <a href="{{ route('asiaTour') }}" class="btn btn-tour">All tour packages</a>
        </div>
        <div class="request back-none" style="background-image: url('{{ $bg_request }}')">
            @php
                $img_request = getDsMetas(260);
                $title_request = getDsMetas(301);
            @endphp
            @include('parts.request')
        </div>
        <div class="preparing light-graynvp slide_owl asia_guide">
            <div class="container">
                <div class="header-sec text-center">
                    <div class="title-sec">
                        <span class="title pink">TRAVEL TIPS & GUIDE</span>
                    </div>
                    <div class="desc_p">{!! getDsMetas(290) !!}</div>
                </div>
                @include('parts.list_nation')
            </div>
        </div>
        <div class="section-blog slide_owl">
            <div class="container">
                <div class="header-sec text-center">
                    <div class="title-sec">
                        <span class="title pink">{!! getDsMetas(293) !!}</span>
                    </div>
                </div>
                @include('parts.list_blog')
            </div>
        </div>
    </div>
</div>

@endsection