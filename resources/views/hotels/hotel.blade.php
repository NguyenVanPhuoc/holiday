@php
	$meta_key = ($seo && $seo->key != '') ? $seo->key : '';
	$meta_value = ($seo && $seo->value != '') ? $seo->value : '';
	$title_tag = $hotel->title_tag;	

	$bg_img = getImgUrl($hotel->image, $hotel->title); 
	$breadcrumb = Breadcrumbs::render('detailHotel', $country, $region, $city, $hotel->title);
	$title_top_h1 = $hotel->title;
	$post_type_active = 'hotel';
@endphp

@extends('templates.master')
@section('content')
@section('title', $title_tag)
@section('description', $meta_value)
@section('keywords', $meta_key)
@section('image_url', $bg_img)

<div class="detail-hotel">
    @include('layouts.top_banner')
    @include('countries.groupTopButton')
	<div class="container">
		<div class="top-intro text-center font-semibold">
			{!! $hotel->desc !!}
		</div>
		<div class="row">
			<div class="col-md-3" id="sidebar">
				@include('sidebars.hotel')
			</div>
			<div class="col-md-9" id="content">
				<div class=" single-sec map-sec">
					<div class="title-sec pink">
						<img src="{{ asset('public/images/icons/all/location2-pink.png') }}" alt="icon">
						<h2 class="title">Location</h2>
					</div>
					<div class="content-sec">
						{!! $hotel->map !!}
					</div>
				</div>
				<div class=" single-sec gallery-sec">
					<div class="title-sec yellow">
						<img src="{{ asset('public/images/icons/all/gallery-yellow.png') }}" alt="icon">
						<h2 class="title">Gallery</h2>
					</div>
					<div class="content-sec">
						<div class="list-image">
							@if($hotel->gallery)
							@php $array_img = json_decode($hotel->gallery); @endphp
							@if(count($array_img) > 0)
							@foreach($array_img as $key=>$img_id)
								@php
									if($key < 5) $add_class = '';
									else $add_class = 'hide';
									$img = getMedia($img_id);
								@endphp
								@if($img)
								<div class="item hexagonImg hexagonImg1 {{$add_class}}">
									<div class="wrap hexagonImg-in1">
										<a style="background-image: url({{asset('/public/uploads/'.$img->image_path)}});" href="{{asset('/public/uploads/'.$img->image_path)}}"  data-group="gallery" class="html5lightbox hexagonImg-in2" title="{{$img->title}}" >
										</a>
									</div>
								</div>
								@endif
							@endforeach
							@endif
							@endif
						</div>
					</div>
				</div>
				
				@if($list_facility)
				<div class="facilities single-sec">
					<div class="title-sec green">
						<img src="{{ asset('public/images/icons/all/stay-green.png') }}" alt="icon">
						<h2 class="title">Facilities and amenities</h2>
					</div>
					<div class="content-sec">
						<div class="box">
							<ul class="list-unstyled">
								@foreach($list_facility as $fa)
									<li>
										{!! imageAuto($fa->gray_icon, $fa->title) !!}
										{{ $fa->title }}
									</li>
								@endforeach
							</ul>
						</div>
					</div>
				</div>
				@endif

				<div class="nearby-sec single-sec">
					<div class="title-sec pink">
						<img src="{{ asset('public/images/icons/hotels/nearby-pink.png') }}" alt="icon">
						<h2 class="title">What is nearby</h2>
					</div>
					<div class="content-sec">
						<div class="list-nearby">
							<div class="row">
								@foreach($list_attraction as $att)
									@php
										$galleryAttr = ($att->gallery != '') ? json_decode($att->gallery) : []; 
									@endphp
									<div class="col-md-6">
										<div class="item">
											{!! image($att->image, 455, 280, $att->title) !!}
											<a href="{{ getImgUrl($att->image) }}" id="attraction-{{ $att->id }}" data-group="attraction-{{ $att->id }}" class="gr html5lightbox flex-list center-item" title="{{ $att->title }}" >
												<span class="title">
													{{ $att->title }}
													-
													{{ $att->distance }} km
												</span>
												<span class="btn btn-white-br">View gallery</span>
											</a>
											<div class="data-group">
												@foreach($galleryAttr as $img_id)
													<a href="{{ getImgUrl($img_id) }}"  data-group="attraction-{{ $att->id }}" class="html5lightbox" title="{{ $att->title }}"></a>
												@endforeach
											</div>
										</div>
									</div>
								@endforeach
							</div>
						</div>
					</div>
				</div>
				
				@if($list_similar_hotel)
				<div class="tour-sec single-sec">
					<div class="title-sec green">
						<img src="{{ asset('public/images/icons/all/tour-green.png') }}" alt="icon">
						<h2 class="title">Similar accommodation</h2>
					</div>
					<div class="content-sec">
						<div class="list-hotel slide-two-item green">
							@foreach($list_similar_hotel as $hotel)
								@include('hotels.item')
							@endforeach
						</div>
					</div>
				</div>
				@endif
				<div class="tour-sec single-sec">
					<div class="content-sec">
						<!--Section Bottom-->
		        		<div class="sec-bottom light-graybg text-center imgbg imgbg-top-right-2">
		        			<div class="title">
		        				<span>Looking for more</span>
		        			</div>
		        			<div class="content-bot">
		        				<div class="icon">
		        					<img src="{{ asset('public/images/icons/all/easy-booking-steps-white.png') }}" alt="icon">
		        				</div>
		        				<p>Looking for a {{ $country->title }} tour package? We have it all for you</p>
		        				<a href="#" class="btn-page greenbg">
		        					<span>View all {{ $country->title }} tour package</span>
		        				</a>
		        			</div>
		        		</div>
		        		<!--End Section Bottom-->
		        	</div>
	        	</div>
			</div>
		</div>
	</div>
</div>

@stop