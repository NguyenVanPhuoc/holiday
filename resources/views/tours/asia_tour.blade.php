@php
	$bg_img =  asset('public/images/banners/top-image-all-tours.png') ; 
	$breadcrumb = Breadcrumbs::render('asiaTour');
	$title_top_h1 = 'Asia tour packages';
	$list_country = getAllMainCountry();
@endphp

@extends('templates.master')
@section('content')
@section('title', $page->title)
@section('description',$seo->value)
@section('keywords', $seo->key)
@section('image_url', $bg_img)
<div class="singe-post" id="asia-tour">
	<div class="image-header" style="background-image: url({{ getImgUrl($page->image) }});">
        <div class="wrap bottom">
            <div class="container">
            	@if(isset($breadcrumb))
	                {!! $breadcrumb !!}
	            @endif
                <h1 class="title-banner-1">{{ $title_top_h1 }}</h1>
            </div>
        </div>
    </div>
    <div class="section padding-top-mobi">
		<div class="container">
			<div class="text-intro text-center desc_top_p">
				{!! $page->content!!}
			</div>
		</div>
	</div>
	@if(isset($list_tour))
	<div class="content-country-tour light-graynvp gr-tour-sec">
		@desktop
		<div class="container wrap-filter">
			<div class="row">
				<div id="sidebar" class="col-md-3">
					<div class="np-tour-sec tour-desktop">
						<div class="gr-filter">
							<form action="{{ route('filterTourAsia') }}" method="POST">
								{{ csrf_field() }}
								<input type="hidden" name="array_id[]" value="{{ json_encode($array_ids) }}">
								<input type="hidden" name="value" value="6" class="value-vp">
								<div class="filter-name graybg font-semibold">
									<span class="icon"><img src="{{ asset('public/images/icons/filter/filter-yellow.png') }}" alt="icon-filter"></span>
									Filter
								</div>
							<div class="list-filter light-graybg filter-tour">
								<div class="check_item box-item region">
									<h2 class="title">Country</h2>
									<ul class="list-unstyled">
										@foreach($list_destination as $destination)
											<li>
												<label for="region-{{ $destination->id }}">
													<input type="checkbox" class="filter-value" id="region-{{ $destination->id }}" name="array_country_id[]" value="{{ $destination->id }}" @if(in_array($destination->id, $array_destinationID)) checked @endif>
													<h3 class="title_vp">{{ $destination->title }} ({{ countTourByCountryId($destination->id)}})</h3>
												</label>
											</li>
										@endforeach
									</ul>
								</div>
								<div class="check_item box-item duration single-value">
									<h2 class="title">Duration</h2>
									<ul class="list-unstyled">
										@foreach($list_duration as $duration)
											<li>
												<label for="duration-{{ $duration->id }}">
													<input type="radio" class="filter-value" id="duration-{{ $duration->id }}" name="duration_id" value="{{ $duration->id }}" @if($duration->id == $duration_id) checked @endif>
													<h3 class="title_vp">{{ $duration->title }} ({{ countTourByDurationIdAsia($duration->id)}})</h3>
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
													<input type="checkbox" class="filter-value" id="tourstyle-{{ $tour_style->id }}" name="array_tourstyle_id[]" value="{{ $tour_style->id }}" @if(in_array($tour_style->id, $array_catID)) checked @endif >
													<h3 class="title_vp">{{ $tour_style->title }} ({{ countTourByCatIdAsia($tour_style->id)}})</h3>
												</label>
											</li>
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
					</div>
				</div>
				<div id="content" class="col-md-9">
					<div class="wrap-result">
						<div class="per-page-vp has-select graybg">
							{{ csrf_field() }}
							View
							<div class="list-per-page">
							<span class="value chose-value" data-value="6" data-href="{{ route('loadMoreTourAsia') }}">6</span>
							per page
								<ul name="per-page" class="popup-filter">
									<li data-value="6">6</li>
									<li data-value="12">12</li>
									<li data-value="24">24</li>
									<li data-value="48">48</li>
								</ul>
							</div>
							<input type="hidden" name="total" value="{{ $total }}">
						</div>
						<div class="filter-nvp">
							@include('tours.list-result-asia')
						</div>
					</div>
				</div>
			</div>
		</div>
		@elsedesktop
		<div class="wrap-filter">
			<div class="np-tour-sec tour-mobile">
				<div class="sec-tour-mobi graybg text-center">
					<span class="filter-sec">FILTER YOUR SEARCH</span>
				</div>
				<div class="gr-filter clearfix">
					<form action="{{ route('filterTourAsia') }}" method="POST">
					{{ csrf_field() }}
						<input type="hidden" name="array_id[]" value="{{ json_encode($array_ids) }}">
						<input type="hidden" name="value" value="6" class="value-vp">
						<div class="list-filter light-graybg filter-tour">
							<div class="check_item box-item region">
								<h2 class="title">Country</h2>
								<ul class="list-unstyled">
									@foreach($list_destination as $destination)
										<li>
											<label for="region-{{ $destination->id }}">
												<input type="checkbox" class="filter-value" id="region-{{ $destination->id }}" name="array_country_id[]" value="{{ $destination->id }}" @if(in_array($destination->id, $array_destinationID)) checked @endif>
												<h3 class="title_vp">{{ $destination->title }} ({{ countTourByCountryId($destination->id)}})</h3>
											</label>
										</li>
									@endforeach
								</ul>
							</div>
							<div class="check_item box-item duration single-value">
								<h2 class="title">Duration</h2>
								<ul class="list-unstyled">
									@foreach($list_duration as $duration)
										<li>
											<label for="duration-{{ $duration->id }}">
												<input type="radio" class="filter-value" id="duration-{{ $duration->id }}" name="duration_id" value="{{ $duration->id }}" @if($duration->id == $duration_id) checked @endif>
												<h3 class="title_vp">{{ $duration->title }} ({{ countTourByDurationIdAsia($duration->id)}})</h3>
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
												<input type="checkbox" class="filter-value" id="tourstyle-{{ $tour_style->id }}" name="array_tourstyle_id[]" value="{{ $tour_style->id }}" @if(in_array($tour_style->id, $array_catID)) checked @endif >
												<h3 class="title_vp">{{ $tour_style->title }} ({{ countTourByCatIdAsia($tour_style->id)}})</h3>
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
				<div class="filter-nvp">
					@include('tours.list-result-asia')
				</div>
			</div>
		</div>
		@enddesktop
	</div>
	@endif
	<div class="content-places">
		<div class="request mar_nvp" style="background-image: url('{{ getImgUrl(getDsMetas(307)) }}')">
			<div class="container">
				<div class="list-request">
					<div class="row item-request">
						<div class="col-md-5 item left-item">
							{!! image(getDsMetas(260),300,220,'image') !!}
						</div>
						<div class="col-md-7 text-center item">
							<span class="aplan yellow">24-hour response<br>guaranteed!</span>
							<a class="btn btn-request" href="{{ route('createMyTrip') }}">REQUEST A FREE QUOTE</a>
						</div>
					</div>
				</div>
			</div>
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
		<div class="request back-none" style="background-image: url('{{ getImgUrl(getDsMetas(308)) }}')">
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
		
	</div>
	<div class="section-blog slide_owl">
		<div class="container">
			<div class="header-sec text-center">
				<div class="title-sec">
					<span class="title pink">{!! getDsMetas(293) !!}</span>
				</div>
			</div>
			@if($list_blog)
				<div class="@desktop slide-style @elsedesktop slide-tour-dost @enddesktop list-blog">
					@foreach($list_blog as $key => $item)
                        @include('articles.item')
					@endforeach
				</div>
			@endif
		</div>
	</div>
</div>

@stop