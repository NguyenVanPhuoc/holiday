@php
    $bg_img = getImgUrl($page->image);
    $bg_looking= getImgUrl(getDsMetas(313));
    $bg_request= getImgUrl(getDsMetas(314)); 
    $breadcrumb = Breadcrumbs::render('aboutUsParent', $page);
    $title_top_h1 = 'WHAT OUR CLIENTS SAID...';
    $icon_top = asset('public/images/icons/feedback-white.png');
    $regions = getAllCountryByLevel(1);
    $durations = getListDuration();
    $styles = getAllCountryTourStyle();
@endphp
@extends('templates.master')
@section('content')
@section('title', $page->title)
@section('description',$seo->value)
@section('keywords', $seo->key)
@section('image_url', $bg_img)
<div id="clients-review" class="clients-review-page singe-post ">
    <div class="image-header" style="background-image: url(<?php echo $bg_img; ?>);">
        <div class="wrap bottom">
            <div class="container">
                @if(isset($breadcrumb))
                    {!! $breadcrumb !!}
                @endif
                <h1 class="title-banner-1">{{ $title_top_h1 }}</h1>
            </div>
        </div>
    </div>
    <div class="section">
        <div class="container">
            <div class="text-intro text-center desc_top_p">{!! $page->content !!}</div>
        </div>
    </div>  
    <div class="content-review light-graynvp">
         @desktop
        <div class="wrap-filter container">
            <div class="row">
                <div id="sidebar" class="col-md-3 np-tour-sec tour-desktop">
                    <div class="gr-filter">
                        <form action="{{ route('filterReviewer') }}" method="POST">
                            <input type="hidden" name="limit" value="{{ $limit }}">
                            {{ csrf_field() }}
                            <div class="filter-name graybg font-semibold">
                                <span class="icon"><img src="{{ asset('public/images/icons/filter/filter-yellow.png') }}" alt="icon-filter"></span>
                                Filter
                            </div>
                            <div class="list-filter light-graybg filter-tour">
                                <div class="check_item box-item country">
                                    <span class="title">Destinations</span>
                                    <ul class="list-unstyled">
                                        @foreach($list_destination as $item)
                                            <li>
                                                <label for="country-{{ $item->id }}">
                                                    <input type="checkbox" class="filter-value" id="country-{{ $item->id }}" name="array_country_id[]" value="{{ $item->id }}">
                                                    <h3 class="title_vp">{{ $item->title }} ({{ countReviewByCountryId($item->id) }})</h3>
                                                </label>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="check_item box-item group-type single-value">
                                    <span class="title">Group type</span>
                                    <ul class="list-unstyled">
                                        @foreach($list_group_type as $item)
                                            <li>
                                                <label for="group-type-{{ $item->id }}">
                                                    <input type="radio" class="filter-value" id="group-type-{{ $item->id }}" name="group_type_id" value="{{ $item->id }}">
                                                    <h3 class="title_vp">{{ $item->title }} ({{ countReviewByGroupTypeId($item->id) }})</h3>
                                                </label>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="check_item box-item tour-style">
                                    <span class="title">Tour style</span>
                                    <ul class="list-unstyled">
                                        @foreach($list_tour_style as $tour_style)
                                            @if(countReviewByStyleId($tour_style->id) > 0)
                                                <li>
                                                    <label for="tourstyle-{{ $tour_style->id }}">
                                                        <input type="checkbox" class="filter-value" id="tourstyle-{{ $tour_style->id }}" name="array_tourstyle_id[]" value="{{ $tour_style->id }}">
                                                        <h3 class="title_vp">{{ $tour_style->title }} ({{ countReviewByStyleId($tour_style->id) }})</h3>
                                                    </label>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <a href="#" class="btn-reset graybg">
                                <span class="img_reset"><img src="{{ asset('public/images/icons/filter/reset_yellow.png') }}" alt="icon-filter"></span>
                                Reset
                            </a>
                        </form>
                    </div>
                    <div class="content-guide">
                        <div class="sb-contact">
                            <a href="#" class="thumb"><img src="{{asset('public/images/request-free-sub.jpg')}}" alt="bigg_icon"></a>
                            <div class="desc-contact">
                                <span class="guaranteed">Got a review to<br> share?</span>
                                <a href="#" title="" class="btn btn-request">SHARE IT NOW</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="content" class="col-md-9">
                    <div class="wrap-result">
                        <div class="filter-nvp wrap_nvp">
                            @if(!empty($list_review))
                                <div class="list-item row">
                                    @foreach($list_review as $item)
                                        @include('reviewers.item')
                                    @endforeach
                                </div>
                            @endif
                            @if($count_review > $limit)
                                <div class="text-center wrap-readmore">
                                    <a href="javascript:void(0)" class="view-more"> <span>View more</span></a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @elsedesktop
         <div class="list-partner graybg text-center">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 experience">
                        <img src="{{asset('public/images/temp/step 2.png')}}" alt="image">
                        <h3 class="title yellow">{{ __('You are welcome to share your experience...')}}</h3>
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
        <div class="wrap-filter">
            <div class="np-tour-sec tour-mobile">
                <div class="sec-tour-mobi graybg text-center">
                    <span class="filter-sec">FILTER YOUR SEARCH</span>
                </div>
                <div class="gr-filter clearfix">
                    <form action="{{ route('filterReviewer') }}" method="POST">
                    {{ csrf_field() }}
                        <input type="hidden" name="value" value="6" class="value-vp">
                        <div class="list-filter light-graybg filter-tour">
                            <div class="check_item box-item region">
                                <h2 class="title">Country</h2>
                                <ul class="list-unstyled">
                                    @foreach($list_destination as $destination)
                                        <li>
                                            <label for="region-{{ $destination->id }}">
                                                <input type="checkbox" class="filter-value" id="region-{{ $destination->id }}" name="array_country_id[]" value="{{ $destination->id }}">
                                                <h3 class="title_vp">{{ $destination->title }} ({{ countReviewByCountryId($destination->id)}})</h3>
                                            </label>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            
                            <div class="check_item box-item group-type single-value">
                                    <span class="title">Group type</span>
                                    <ul class="list-unstyled">
                                        @foreach($list_group_type as $item)
                                            <li>
                                                <label for="group-type-{{ $item->id }}">
                                                    <input type="radio" class="filter-value" id="group-type-{{ $item->id }}" name="group_type_id" value="{{ $item->id }}" >
                                                    <h3 class="title_vp">{{ $item->title }} ({{ countReviewByGroupTypeId($item->id) }})</h3>
                                                </label>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            <div class="check_item box-item tour-style">
                                <h2 class="title">Tour style</h2>
                                <ul class="list-style list-unstyled">
                                    @foreach($list_tour_style as $tour_style)
                                        <li>
                                            <label for="tourstyle-{{ $tour_style->id }}">
                                                <input type="checkbox" class="filter-value" id="tourstyle-{{ $tour_style->id }}" name="array_tourstyle_id[]" value="{{ $tour_style->id }}" >
                                                <h3 class="title_vp">{{ $tour_style->title }} ({{ countReviewByStyleId($tour_style->id)}})</h3>
                                            </label>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <a href="#" class="btn-reset graybg">
                            <span><img src="{{ asset('public/images/icons/filter/reset_white.png') }}" alt="icon-filter"></span>
                            Reset
                        </a>
                    </form>
                </div>
            </div>
            <div class="wrap-result result-mobi">
                <div class="filter-nvp ">
                    @if(!empty($list_review))
                        <div class="list-item row">
                            @foreach($list_review as $item)
                                @include('reviewers.item')
                            @endforeach
                        </div>
                    @endif
                    @if($count_review > $limit)
                        <div class="text-center wrap-readmore">
                            <a href="javascript:void(0)" class="view-more"> <span>View more</span></a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        @enddesktop
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