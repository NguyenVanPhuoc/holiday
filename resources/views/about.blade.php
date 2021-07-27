 @php
	$bg_img = getImgUrl($page->image); 
	$bg_looking= getImgUrl(getDsMetas(171));
    $bg_request= getImgUrl(getDsMetas(172));
	$breadcrumb = Breadcrumbs::render('FAQs', $page->title ); 
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
<div id="about" class="page bg-gray page-only singe-post">
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
	<div class="founder light-graynvp ">
		<div class="container content_found">
			<div class="thumb_image">
				{!! image(getDsMetas(116),220,220,'Thai Huong Hoang') !!}
			</div>
			<div class="desc_founder">
				<h2 class="title_found pink">{!! getDsMetas(117) !!}</h2>
				<h3 class="name_found">{!! getDsMetas(118) !!}</h3>
				<div class="desc">
					<div class="desc_vp">
						{!! getDsMetas(119) !!}
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="life life-v1"  style="background-image: url('{!! getImgUrl(getDsMetas(120)) !!}');">
		<h2 class="title-life"><span>{!! getDsMetas(121) !!}</span></h2>
	</div>
	<div class="our_team founder light-graynvp">
		<div class="container content_team">
			<div class="thumb_image">
				{!! image(getDsMetas(125),220,220,'Our Team') !!}
			</div>
			<div class="desc_founder">
				<h2 class="title_found pink">{!! getDsMetas(126) !!}</h2>
				<div class="desc">
					{!! getDsMetas(127) !!}
				</div>
			</div>
		</div>
	</div>
	<div class="our_production light-graynvp">
		<div class="container">
			<div class="row item">
				<div class="col-md-6 image_left">
					{!! image(getDsMetas(128),480,515,'Our Team') !!}
				</div>
				<div class="col-md-6 desc">
					{!! getDsMetas(129) !!}
				</div>
			</div>
			<div class="row item item_mobile">
				<div class="col-md-6 desc">
					{!! getDsMetas(132) !!}
				</div>
				<div class="col-md-6 image_left">
					{!! image(getDsMetas(133),480,515,'Our Team') !!}
				</div>
			</div>
		</div>
	</div>
	<div class="life our_value"  style="background-image: url('{!! getImgUrl(getDsMetas(134)) !!}');">
		<h2 class="title-life">{!! getDsMetas(135) !!}</h2>
	</div>
<div class="our_team founder light-graynvp value-padd">
		<div class="container">
			<div class="content_team padding-mobile">
				<div class="thumb_image">
					{!! image(getDsMetas(136),220,220,'Our Team') !!}
				</div>
				<div class="desc_founder">
					<h2 class="title_found pink">{!! getDsMetas(138) !!}</h2>
					<div class="desc">
						{!! getDsMetas(139) !!}
					</div>
				</div>
			</div>
			<div class="environment light-graynvp">
				<div class=" @desktop row @elsedesktop slide-dost @enddesktop list-environment">
					<div class="col-md-4 item">
						<div class="item-bgr light-graybg">
							<div class="crop_img">
								<img class="thumb_img" src="{{asset('/public/images/about/sustainability-red.png')}}"/>
								<img class="thumb_yellow" src="{{asset('/public/images/about/sustainability.png')}}"/>
							</div>
							<h3 class="pink"><span>Sustainability</span></h3>
							{!! getDsMetas(140) !!}
						</div>
					</div>
					<div class="col-md-4 item">
						<div class="item-bgr light-graybg">
							<div class="crop_img">
								<img class="thumb_img" src="{{asset('/public/images/about/trust-red.png')}}"/>
								<img class="thumb_yellow" src="{{asset('/public/images/about/trust.png')}}"/>
							</div>
							<h3 class="pink"><span>Trust</span></h3>
							{!! getDsMetas(141) !!}
						</div>
					</div>
					<div class="col-md-4 item">
						<div class="item-bgr light-graybg">
							<div class="crop_img">
								<img class="thumb_img" src="{{asset('/public/images/about/genuineness-red.png')}}"/>
								<img class="thumb_yellow" src="{{asset('/public/images/about/genuineness.png')}}"/>
							</div>
							<h3 class="pink"><span>Genuineness</span></h3>
							{!! getDsMetas(142) !!}
						</div>
					</div>
					<div class="col-md-4 item">
						<div class="item-bgr light-graybg">
							<div class="crop_img">
								<img class="thumb_img" src="{{asset('/public/images/about/passion-red.png')}}"/>
								<img class="thumb_yellow" src="{{asset('/public/images/about/passion.png')}}"/>
							</div>
							<h3 class="pink"><span>Passion</span></h3>
							{!! getDsMetas(143) !!}
						</div>
					</div>
					<div class="col-md-4 item">
						<div class="item-bgr light-graybg">
							<div class="crop_img">
								<img class="thumb_img" src="{{asset('/public/images/about/communication-red.png')}}"/>
								<img class="thumb_yellow" src="{{asset('/public/images/about/communication.png')}}"/>
							</div>
							<h3 class="pink"><span>Communication</span></h3>
							{!! getDsMetas(144) !!}
						</div>
					</div>
					<div class="col-md-4 item">
						<div class="item-bgr light-graybg">
							<div class="crop_img">
								<img class="thumb_img" src="{{asset('/public/images/about/involvement-red.png')}}"/>
								<img class="thumb_yellow" src="{{asset('/public/images/about/involvement.png')}}"/>
							</div>
							<h3 class="pink"><span>Involvement</span></h3>
							{!! getDsMetas(145) !!}
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="life life-respon"  style="background-image: url('{!! getImgUrl(getDsMetas(146)) !!}');">
		<h2 class="title-life"><span>{!! getDsMetas(147) !!}</span></h2>
	</div>
	<div class="our_team founder light-graynvp">
		<div class="container">
			<div class="content_team padding-mobile">
				<div class="thumb_image">
					{!! image(getDsMetas(148),220,220,'Our Team') !!}
				</div>
				<div class="desc_founder">
					<h2 class="title_found pink">{!! getDsMetas(149) !!}</h2>
					<div class="desc">
						{!! getDsMetas(150) !!}
					</div>
				</div>
			</div>
			<div class="responsible_travel slide_owl">
				@if($list_sustai)
					@php 
						$list_respon = json_decode($list_sustai->meta_value);
					@endphp
					<div class="@desktop slide-style @elsedesktop slide-dost @enddesktop list-respon">
						@foreach($list_respon as $key => $item)
						<div class="wrapper-item">
							<div class="item" style="background-image: url('{!! getImgUrl($item->image) !!}');">
								@handheld
									<img class="plus" src="{{asset('public/images/icons/Cross-White.png')}}" alt="Plus-white">
								@endhandheld
								<h3 class="title">{{ $item->title }}</h3>
								<div class="desc_hover">
										@handheld
											<img class="cross" src="{{asset('public/images/icons/Cross_Yellow.png')}}" alt="Cross-white">
										@endhandheld
									<div class="desc">
										<h3 class="title_hover yellow">{{ $item->title }}</h3>
										{!! $item->content !!}
									</div>
								</div>
							</div>
						</div>
						@endforeach
					</div>
				<div class="bot-tour">
	                <a href="{{ route('responsibleTravel') }}" class="btn btn-tour">{{ __('Discover more')}}</a>
	            </div>
				@endif	
			</div>
		</div>
	</div>
	<div class="life finding"  style="background-image: url('{!! getImgUrl(getDsMetas(155)) !!}');">
		<h2 class="title-life"><span>{!! getDsMetas(156) !!}</span></h2>
	</div>
	<div class="our_team founder light-graynvp explore_asia">
		<div class="container">
			<div class="content_team padding-mobile">
				<div class="thumb_image">
					{!! image(getDsMetas(157),220,220,'Our Team') !!}
				</div>
				<div class="desc_founder">
					<h2 class="title_found pink">{!! getDsMetas(158) !!}</h2>
					<div class="desc">
						{!! getDsMetas(159) !!}
					</div>
				</div>
			</div>
			<div class="@desktop row @elsedesktop slide-dost @enddesktop ">
                @if($list_reviewer)
                    @foreach($list_reviewer as $item)
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
            <div class="bot-tour">
                <a href="{{ route('clientsReview') }}" class="btn btn-tour">{{ __('CHECK ALL REVIEWS')}}</a>
            </div>
		</div>
	</div>
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
    <div class="life only"  style="background-image: url('{!! getImgUrl(getDsMetas(161)) !!}');">
		<h2 class="title-life"><span>{!! getDsMetas(162) !!}</span></h2>
	</div>
	<div class="our_team founder light-graynvp">
		<div class="container">
			<div class="content_team padding-mobile">
				<div class="thumb_image">
					{!! image(getDsMetas(163),220,220,'Our Team') !!}
				</div>
				<div class="desc_founder">
					<h2 class="title_found pink">{!! getDsMetas(164) !!}</h2>
					<div class="desc">
						{!! getDsMetas(165) !!}
					</div>
				</div>
				@desktop
				<div class="only_travel light-graybg">
					<a class="btn_contact" href="{{ route('contact') }}">{{ __('CONTACT US NOW')}}</a>
					<ul class="contact-info no-list-style">
	                   <li><a href="tel:{{phone()}}"><img class="icon" src="{{asset('public/images/WhatsApp.png')}}" alt="bee-white"> {{phone()}}</a></li>
                        <li><a href="mailto:{{mailSystem()}}"><img class="icon" src="{{asset('public/images/Mailicon.png')}}" alt="bee-white"> {{mailSystem()}}</a></li>
	                </ul>
				</div>
				@enddesktop
			</div>
		</div>
		@handheld
			<div class="only_travel light-graybg">
				<a class="btn_contact" href="{{ route('contact') }}">{{ __('CONTACT US NOW')}}</a>
				<ul class="contact-info no-list-style">
	               <li><a href="tel:{{phone()}}"><img class="icon" src="{{asset('public/images/WhatsApp.png')}}" alt="bee-white"> {{phone()}}</a></li>
	                <li><a href="mailto:{{mailSystem()}}"><img class="icon" src="{{asset('public/images/Mailicon.png')}}" alt="bee-white"> {{mailSystem()}}</a></li>
	            </ul>
			</div>
		@endhandheld
	</div>
	<div class="googlemap">
		{!! getDsMetas(167) !!}
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
            <div class="bot-tour light-graybg">
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