 @php
	$bg_img = getImgUrl($page->image); 
	$bg_looking= getImgUrl(getDsMetas(343));
    $bg_request= getImgUrl(getDsMetas(344));
	$breadcrumb = Breadcrumbs::render('aboutUsParent', $page ); 
	$title_top_h1 = $page->title;
	$list_reviewer = getListReviewer(NULL, NULL, 3);
	$regions = getAllCountryByLevel(1);
	$durations = getListDuration();
	$styles = getAllCountryTourStyle();
	$list_country = getAllCountryByLevel(1);
	$site_title = $page->title .' | Sonasia Holiday';
@endphp
@extends('templates.master')
@section('title', $site_title)
@section('description', $seo->value)
@section('keywords', $seo->key)
@section('content')
<div id="term_of_use" class="page bg-gray singe-post responsible">
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
	<div class="container">
		<div class="top-intro text-center">
            {!! $page->content !!}
        </div>
	</div>
	<div class="page-content light-graynvp">
		<div class="container">
			<div class="content_biig">
				<div class="text-center icons_biig">
					<h3 class="title-h3 green">SUSTAINABILITY IN ACTION</h3>
					<div class="desc">{!! getDsMetas(199) !!}</div>
				</div>
				@if($list_sustai)
				@php 
					$list_respon = json_decode($list_sustai->meta_value);
				@endphp
					<div class="list-sustai">
						@foreach($list_respon as $item)
							<div class="item light-graybg">
								<div class="desc">
									<h3 class="green">{{ $item->title }}</h3>
									{!! $item->content !!}
								</div>
								<div class="thumb_img" style="background-image: url('{!!getImgUrl($item->image) !!}');"></div>
							</div>
						@endforeach
					</div>
				@endif
				@if($list_mutual)
				@php 
					$list_tourism = json_decode($list_mutual->meta_value);
				@endphp
				<div class="text-center icons_biig benefits">
					<h3 class="title-h3 green">A MUTUAL BENEFICIAL TOURISM</h3>
					<div class="desc">{!! getDsMetas(341) !!}</div>
					<div class="list-sustai">
						@foreach($list_tourism as $item)
							<div class="item light-graybg">
								<div class="desc">
									<h3 class="green">{{ $item->title }}</h3>
									{!! $item->content !!}
								</div>
								<div class="thumb_img" style="background-image: url('{!!getImgUrl($item->image) !!}');">
									{{-- <img src="{!! getImgUrl($item->image) !!}" alt="{{ $item->title }}"> --}}
								</div>
							</div>
						@endforeach
					</div>
				</div>
				@endif
				<div class="button_phone_tour text-center conditions">
					<img class="green" src="{{asset('public/images/icons/biig_club/pdf.png')}}" alt="image">
					<a href="{!! getDsMetas(345) !!}" class="set_phone" target="_blank">
						Sonasia Holiday sustainability policy
					</a>
				</div>

			</div>
		</div>
	</div>
	<div class="whatcan slide_owl padding_center blog_nvp_js">
		<div class="container">
			<div class="header-sec text-center">
				<div class="title-sec">
					<span class="title pink">WHAT CAN YOU DO?</span>
				</div>
				<div class="desc_p">{!! getDsMetas(342) !!}</div>
			</div>
			@if($list_support)
				@php 
					$list_item = json_decode($list_support->meta_value);
				@endphp
				<div class="@desktop slide-style @elsedesktop slide-dost @enddesktop">
		            @foreach($list_item as $item)
		                <div class="wrapper-item">
		                    <div class="item" style="background-image: url('{!! getImgUrl($item->image); !!}')">
		                    	@handheld
									<img class="plus" src="{{asset('public/images/icons/Cross-White.png')}}" alt="Plus-white">
								@endhandheld
		                        <h7 class="title-style-tour white">{{$item->title}}</h7>
		                        <div class="desc_hover">
		                        	@handheld
										<img class="cross" src="{{asset('public/images/icons/Cross-White.png')}}" alt="Cross-white">
									@endhandheld
		                            <div class="text-center">
		                                @desktop <img class="bee" src="{{asset('public/images/bee/bee-white.png')}}" alt="bee-white"> @enddesktop
		                                <h7 class="title_hover white">{{$item->title}}</h7>
		                                <div class="white">
		                                	{!! $item->content !!}
		                                </div>
		                            </div>
		                        </div>
		                    </div>
		                </div>
		            @endforeach
		        </div>
		      
			@endif
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
            <div class="bot-tour">
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