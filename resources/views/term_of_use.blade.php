@php 
    $bg_img = getImgUrl($page->image); 
    $breadcrumb = Breadcrumbs::render('FAQs', $page->title );
    $title_top_h1 = $page->title;
    $bg_looking= getImgUrl(getDsMetas(331));
    $bg_request= getImgUrl(getDsMetas(332));
    $regions = getAllCountryByLevel(1);
    $durations = getListDuration();
    $styles = getAllCountryTourStyle();
    $site_title = $page->title .' | Sonasia Holiday';
@endphp
@extends('templates.master')
@section('title', $site_title)
@section('description', $seo->value)
@section('keywords', $seo->key)
@section('content')
<div id="term_of_use" class="page bg-gray singe-post privacy_policy one-page">
    <div class="image-header" style="background-image: url(<?php echo $bg_img; ?>);">
        <div class="wrap bottom">
            <div class="container">
                @if(isset($breadcrumb))
                    {!! $breadcrumb !!}
                @endif
                <h1 class="title-banner-1">{{$title_top_h1}}</h1>
            </div>
        </div>
    </div>
    @desktop
        <a href="{!! getDsMetas(178) !!}" download class="download"><img src="{{asset('public/images/icons/biig_club/pdf.png')}}" alt="image">&nbsp;Download in PDF</a>
    @enddesktop
        <div class="container">
            <div class="top-intro text-center">{!! getDsMetas(174) !!}</div>
        </div>
    <div class="page-content light-graynvp">
        <div class="container">
            <div class="row">
                @desktop
                <div class="col-md-3 content-guide" id="sidebar">
                    @php
                    $list_reviewer = getListReviewer(NULL, NULL, 1);
                    @endphp
                    <div class="padding_auto">
                        @if(isset($list_reviewer))
                            @php
                                $From_date = new DateTime($list_reviewer[0]->from_date);
                                $To_date = new DateTime($list_reviewer[0]->to_date);
                                $days  = $To_date->diff($From_date)->format('%a');
                                $to_date = date('F y', strtotime($list_reviewer[0]->to_date));
                                $tourstyle_ids = array_filter(explode(',', $list_reviewer[0]->list_tour_style));
                                if($tourstyle_ids) {
                                    $tourstyle_text = '';
                                    $tour_title = get_title_category_tour($tourstyle_ids[0]);
                                    if($tour_title) $tourstyle_text .= $tour_title->title;
                                }else $tourstyle_text = false;
                            @endphp 
                            <div class="wrap_review graybg">
                                <div class="item">
                                    <h7 class="title_review"><a href="{{ route('detailClientReview',['slug'=>$list_reviewer[0]->slug]) }}" target="_blank">{{ $list_reviewer[0]->title }}</a></h7>
                                    <div class="desc">
                                        {!! str_limit($list_reviewer[0]->content, 170) !!}
                                        <a href="{{ route('detailClientReview',['slug'=>$list_reviewer[0]->slug]) }}" target="_blank">More</a>
                                    </div>
                                    <div class="rv_author">
                                        <a href="{{ route('detailClientReview',['slug'=>$list_reviewer[0]->slug]) }}" class="thumb" target="_blank">
                                            {!! image($list_reviewer[0]->image, 80, 80, $list_reviewer[0]->name) !!}
                                        </a>
                                        <span class="name">{{ $list_reviewer[0]->name }}</span>
                                        <span class="day">{{ $to_date }}</span>
                                    </div>
                                    <div>
                                        <span>{{getTitleOfGroupType($list_reviewer[0]->group_type_id)}} / </span>
                                        <span>{{ $days + 1}} days</span> 
                                        <span> / {{ $tour_title->title }}</span>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="sb-contact">
                        <a href="#" class="thumb"><img src="{{asset('public/images/request-free-sub.jpg')}}" alt="bigg_icon"></a>
                        <div class="desc-contact">
                            <span class="guaranteed">24-hour response guaranteed</span>
                            <a href="{{ route('createMyTrip') }}" title="" class="btn btn-request">request a free quote</a>
                        </div>
                    </div>
                </div>
                 @enddesktop
                <div class="col-md-9" id="content">
                    <div class="booking_con">
                        {!! $page->content !!}
                        <div class="back-to-start"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="content-places content-nvp">
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
            <div class="plans-travels light-graynvp padding_center slide_owl">
                <div class="container">
                    <div class="header-sec text-center">
                        <div class="title-sec">
                            <span class="title pink">PLANS BY TRAVEL THEME</span>
                        </div>
                    </div>
                     @include('parts.AsiaTourDetails.plans_travel_theme')
                </div>
            </div>
            <div class="plans-time light-graybg">
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
            <div class="bot-tour light-graybg top-bot">
                <a href="{{ route('asiaTour') }}" class="btn btn-tour">All tour packages</a>
            </div>
            <div class="request back-none" style="background-image: url('{{ $bg_request }}')">
                @php
                    $img_request = getDsMetas(260);
                    $title_request = getDsMetas(301);
                @endphp
                @include('parts.request')
            </div>
            <div class="preparing light-graybg slide_owl asia_guide">
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
@stop