@php
	if($page):
	    $bg_img = getImgUrl($page->image);
	    $title_tag = ($page->title_tag != '') ? $page->title_tag : $page->title;
	    $meta_key = (!empty($seo) && $seo->key != '') ? $seo->key : $page->title;
	    $meta_value = (!empty($seo) && $seo->value != '') ? $seo->value : $page->title;
	else:
		$bg_img = asset('public/images/temp/nature and adventure.jpg');
		$title_tag = 'Blog BiiG Holiday';
		$meta_key = 'Blog BiiG Holiday';
		$meta_value = 'Blog BiiG Holiday';
	endif;
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
@section('content')
<div id="blog" class="page blog">
	<div class="image-header" style="background-image: url('{{ $bg_img }}');">
		<div class="wrap bottom">
			<div class="container">
				<h7 class="small-banner top">- Sonasia Holiday -</h7>
				<h1 class="title-banner mid">SONABEE BLOG</h1>
			</div>
		</div>	
	</div>
	<div class="container">
		<div class="main-top">
			<div class="slogan text-center">{!! $page ? $page->content : '' !!}</div>
		</div>
		<div class="main-bottom">
			<div class="row">
				<div id="content" class="col-md-9">
					<div class="description">
						@if($list_blog)
							<div class="list-blog">
								<div class="row wrap">
									@foreach($list_blog as $key => $item)
										@php
											$slugCountry = getSlugCountryOfBlog($item->id);
										@endphp
                                        @include('articles.item_v2')
									@endforeach
								</div>
								@if($total > 1)
									<div id="load-more">
										{{ csrf_field() }}
										<input type="hidden" name="total" value="{{ $total }}">
										<input type="hidden" name="current" value="1">
										<a class="view-more" href="javascript:void(0)" data-href="{{ route('loadMoreBlog') }}">View more</a>
									</div>
								@endif
							</div>
						@endif
					</div>
				</div>
				<div id="sidebar" class="col-md-3">@include('sidebars.blog')</div>
			</div>
		</div>
	</div>
	<div class="looking looking-tour-mobile"  style="background-image: url('{!! getImgUrl(getDsMetas(278)) !!}');">
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
	<div class="plans-travel">
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
	<a class="view-tour bot-top" href="{{ route('asiaTour')}}">View all tours</a>
	<div class="request back-none" style="background-image: url('{!! getImgUrl(getDsMetas(299)) !!}')">
		@php
			$img_request = getDsMetas(300);
			$title_request = getDsMetas(301);
		@endphp
		@include('parts.request')
	</div>
	<div class="preparing light-graynvp slide_owl blog_nvp_js">
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