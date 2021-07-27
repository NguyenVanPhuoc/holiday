 @php
	$bg_img = getImgUrl($page->image); 
	$bg_looking= getImgUrl(getDsMetas(368));
    $bg_request= getImgUrl(getDsMetas(369));
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
<div id="term_of_use" class="page bg-gray singe-post biigclub">
	<div class="image-header" style="background-image: url(<?php echo $bg_img; ?>);">
        <div class="wrap bottom">
            <div class="container">
                @if(isset($breadcrumb))
                    {!! $breadcrumb !!}
                @endif
                <h1 class="title-banner-1">JOIN SONASIA CLUB</h1>
            </div>
        </div>
    </div>
    <div class="container">
		<div class="top-intro text-center">
            {!! $page->content !!}
        </div>
	</div>
	<div class="light-graynvp">
		<div class="work padding_center blog_nvp_js">
			<div class="container">
				<div class="header-sec text-center">
					<div class="title-sec">
						<span class="title pink">HOW DOES IT WORK?</span>
					</div>
					<div class="desc_p">{!! getDsMetas(187) !!}</div>
				</div>
				<div class=" @desktop row @elsedesktop slide-dost @enddesktop list-work">
					<div class="col-md-4 col">
						<div class="wrapper-item">
		                    <div class="item" style="background-image: url('{!! getImgUrl(getDsMetas(347)); !!}')">
		                    	@handheld
									<img class="plus" src="{{asset('public/images/icons/Cross-White.png')}}" alt="Plus-white">
								@endhandheld
		                        <h7 class="title-style-tour white">{{getDsMetas(346)}}</h7>
		                        <div class="desc_hover">
		                        	@handheld
										<img class="cross" src="{{asset('public/images/icons/Cross-White.png')}}" alt="Cross-white">
									@endhandheld
		                            <div class="text-center">
		                                @desktop <img class="bee" src="{{asset('public/images/bee/bee-white.png')}}" alt="bee-white"> @enddesktop 
		                                <h7 class="title_hover white">{{getDsMetas(346)}}</h7>
		                                <div class="white">
		                                	{!! getDsMetas(348) !!}
		                                </div>
		                            </div>
		                        </div>
		                    </div>
		                </div>
					</div>
					<div class="col-md-4 col">
						<div class="wrapper-item">
		                    <div class="item" style="background-image: url('{!! getImgUrl(getDsMetas(350)); !!}')">
		                    	@handheld
									<img class="plus" src="{{asset('public/images/icons/Cross-White.png')}}" alt="Plus-white">
								@endhandheld
		                        <h7 class="title-style-tour white">{{getDsMetas(349)}}</h7>
		                        <div class="desc_hover">
		                        	@handheld
										<img class="cross" src="{{asset('public/images/icons/Cross-White.png')}}" alt="Cross-white">
									@endhandheld
		                            <div class="text-center">
		                                @desktop <img class="bee" src="{{asset('public/images/bee/bee-white.png')}}" alt="bee-white"> @enddesktop 
		                                <h7 class="title_hover white">{{getDsMetas(349)}}</h7>
		                                <div class="white">
		                                	{!! getDsMetas(351) !!}
		                                </div>
		                            </div>
		                        </div>
		                    </div>
		                </div>
					</div>
					<div class="col-md-4 col">
						<div class="wrapper-item">
		                    <div class="item" style="background-image: url('{!! getImgUrl(getDsMetas(353)); !!}')">
		                    	@handheld
									<img class="plus" src="{{asset('public/images/icons/Cross-White.png')}}" alt="Plus-white">
								@endhandheld
		                        <h7 class="title-style-tour white">{{getDsMetas(352)}}</h7>
		                        <div class="desc_hover">
		                        	@handheld
										<img class="cross" src="{{asset('public/images/icons/Cross-White.png')}}" alt="Cross-white">
									@endhandheld
		                            <div class="text-center">
		                                @desktop <img class="bee" src="{{asset('public/images/bee/bee-white.png')}}" alt="bee-white"> @enddesktop 
		                                <h7 class="title_hover white">{{getDsMetas(352)}}</h7>
		                                <div class="white">
		                                	{!! getDsMetas(354) !!}
		                                </div>
		                            </div>
		                        </div>
		                    </div>
		                </div>
					</div>
				</div>
			</div>
		</div>
		<div class="work padding_center blog_nvp_js">
			<div class="container">
				<div class="header-sec text-center">
					<div class="title-sec">
						<span class="title pink">BENEFITS</span>
					</div>
					<div class="desc_p">{!! getDsMetas(355) !!}</div>
				</div>
				<div class="@desktop row @elsedesktop slide-dost @enddesktop list-work">
					<div class="col-md-4 col">
						<div class="wrapper-item">
		                    <div class="item" style="background-image: url('{!! getImgUrl(getDsMetas(357)); !!}')">
		                    	@handheld
									<img class="plus" src="{{asset('public/images/icons/Cross-White.png')}}" alt="Plus-white">
								@endhandheld
		                        <h7 class="title-style-tour white">{{getDsMetas(356)}}</h7>
		                        <div class="desc_hover">
		                        	@handheld
										<img class="cross" src="{{asset('public/images/icons/Cross-White.png')}}" alt="Cross-white">
									@endhandheld
		                            <div class="text-center">
		                                @desktop <img class="bee" src="{{asset('public/images/bee/bee-white.png')}}" alt="bee-white"> @enddesktop  
		                                <h7 class="title_hover white">{{getDsMetas(356)}}</h7>
		                                <div class="white">
		                                	{!! getDsMetas(358) !!}
		                                </div>
		                            </div>
		                        </div>
		                    </div>
		                </div>
					</div>
					<div class="col-md-4 col">
						<div class="wrapper-item">
		                    <div class="item" style="background-image: url('{!! getImgUrl(getDsMetas(360)); !!}')">
		                    	@handheld
									<img class="plus" src="{{asset('public/images/icons/Cross-White.png')}}" alt="Plus-white">
								@endhandheld
		                        <h7 class="title-style-tour white">{{getDsMetas(359)}}</h7>
		                        <div class="desc_hover">
		                        	@handheld
										<img class="cross" src="{{asset('public/images/icons/Cross-White.png')}}" alt="Cross-white">
									@endhandheld
		                            <div class="text-center">
		                                @desktop <img class="bee" src="{{asset('public/images/bee/bee-white.png')}}" alt="bee-white"> @enddesktop  
		                                <h7 class="title_hover white">{{getDsMetas(359)}}</h7>
		                                <div class="white">
		                                	{!! getDsMetas(361) !!}
		                                </div>
		                            </div>
		                        </div>
		                    </div>
		                </div>
					</div>
					<div class="col-md-4 col">
						<div class="wrapper-item">
		                    <div class="item" style="background-image: url('{!! getImgUrl(getDsMetas(363)); !!}')">
		                    	@handheld
									<img class="plus" src="{{asset('public/images/icons/Cross-White.png')}}" alt="Plus-white">
								@endhandheld
		                        <h7 class="title-style-tour white">{{getDsMetas(362)}}</h7>
		                        <div class="desc_hover">
		                        	@handheld
										<img class="cross" src="{{asset('public/images/icons/Cross-White.png')}}" alt="Cross-white">
									@endhandheld
		                            <div class="text-center">
		                                @desktop <img class="bee" src="{{asset('public/images/bee/bee-white.png')}}" alt="bee-white"> @enddesktop  
		                                <h7 class="title_hover white">{{getDsMetas(362)}}</h7>
		                                <div class="white">
		                                	{!! getDsMetas(364) !!}
		                                </div>
		                            </div>
		                        </div>
		                    </div>
		                </div>
					</div>
				</div>
			</div>
		</div>
		<div class="button_phone_tour text-center conditions">
			<img class="green" src="{{asset('public/images/icons/biig_club/pdf.png')}}" alt="image">
			<a href="{!! getDsMetas(365) !!}" class="set_phone" target="_blank">
				Sonasia Club applicable conditions
			</a>
		</div>
	</div>
	<div class="community padding_center">
		<div class="container">
			<div class="header-sec text-center">
				<div class="title-sec">
					<span class="title pink">JOIN OUR COMMUNITY</span>
				</div>
				<div class="desc_p">{!! getDsMetas(366) !!}</div>
			</div>
			@if($gallery)
				@php 
					$array_img = json_decode($gallery->gallery); 
				@endphp
				@if(count($array_img) > 0)
				@php $image = ""; @endphp
				@desktop
					<div class="row list_orv grid">
						@foreach($array_img as $key => $img_id)
							@php 
								if($key==0)
									$image = image($img_id, 300, 320, 'image');
								elseif($key==1 || $key==3)
									$image = image($img_id, 300, 400, 'image');
								elseif($key==2)
									$image = image($img_id, 300, 360, 'image');
								elseif($key==4)
									$image = image($img_id, 300, 370, 'image');
								else
									$image = image($img_id, 300, 350, 'image');
							@endphp
							<div class="col-md-4 grid-item item">
								{!! $image !!}
							</div>
						@endforeach
					</div>
				@elsedesktop
					<div class="slide-dost list_orv">
						@foreach($array_img as $key => $img_id)
						<div class="wrapper-item">
		                    <div class="item" style="background-image: url('{!! getImgUrl($img_id); !!}')">
		                    </div>
		                </div>
		                @endforeach
					</div>
				@enddesktop
				@endif
			@endif
		<div class="bot-tour top-bot">
			@php 
				$facebook = $options->social_media; 
				$items = explode(';',$facebook);
				$zzz= json_decode($items[0]);
			@endphp
            <a href="{{ $zzz->link }}" class="btn btn-tour" target="_blank">JOIN US ON FACEBOOK</a>
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