@php
	$meta_key = ($seo && $seo->key != '') ? $seo->key : '';
	$meta_value = ($seo && $seo->value != '') ? $seo->value : '';

	$bg_img =  getImgUrl($tour->image) ; 
	$bg_looking = (isset($desc_tourCountry) && $desc_tourCountry->banner != '' ) ? getImgUrl($desc_tourCountry->banner) : getImgUrl(getDsMetas(278));
	$bg_request = (isset($desc_tourCountry) && $desc_tourCountry->banner_plants != '' ) ? getImgUrl($desc_tourCountry->banner_plants) : getImgUrl(getDsMetas(259)); 
	$countCountry = countDestinationsOfTour($tour->id);
	$breadcrumb = ($countCountry == 1) ? Breadcrumbs::render('detailTour', $country, $tour->title) : Breadcrumbs::render('detailAsiaTour', $tour->title) ;
	$title_h2 = ($countCountry == 1) ? '- '.($country->title).' tour packages -' : '- Asia tour packages -';
	$list_country = getAllMainCountry();
@endphp

@extends('templates.master')
@section('content')
@section('title', $tour->title_tag)
@section('description', $meta_value)
@section('keywords', $meta_key)
@section('image_url', $bg_img)

@php
	$durations = get_list_duration();
	$cats = get_categories_tour();
	$consultants = getConsultantsByCountry($country->id);
	$bg_img = getImgUrl($tour->image);
	$title_top_h1 = $tour->title;
	$banner_iconCats = getIconCatOftour($tour->id);
@endphp

<div id="detail-tour" class="single-tour">
	@desktop
	<div class="menu-top-single">
		<div class="menu-modal">
			@include('parts.countryTourDetails.menu_tour_detail')
		</div>
	</div>
	@enddesktop
	<div class="image-header" style="background-image: url(<?php echo $bg_img; ?>);">
	    <div class="wrap">
	        <div class="container">
	        	@if(isset($breadcrumb))
	                {!! $breadcrumb !!}
	            @endif
	            <div class="title_nvp">
	            	@desktop
	            	@if(isset($title_h2))
		                <span class="title-banner-2">{{ $title_h2 }}</span>
		            @endif
		            @elsedesktop
		            	<span class="title-banner-2">Package code: {{ $tour->code }}</span>
		            @enddesktop
		            @if(isset($title_top_h1))
		                <h1 class="title-banner-1">{{ $title_top_h1 }}</h1>
		            @endif
	            </div>
	            
	        </div>
	    </div>
	</div>
	<div class="section sec-detail-tour">
		<div class="container">
			<div class="text-intro text-center desc_top_p">{!! $tour->content !!}</div>
		</div>
		@handheld
			<div class="graybg person">
				<div class="lize">
					<a href="{{ route('createPersonalize') }}" class=" btn_personalize">Personalize</a>
					<span>{{ $cates->title }} / </span>
					<span>{{ $tour->number }} days / </span>
					<span>{{ 'fr.$'.number_format($tour->price,0,".",",") }}</span>
					<span class="estimation">
						<img src="{{asset('/public/images/Info-price.png')}}" alt="icon"> 
					</span>
				</div>
			</div>
			<div class="price_estimation light-graynvp">
				<div class="wrapper_scroll yellow">
					<h7 class="title">PRICE ESTIMATION</h7>
					<span class="closes"><img src="{{asset('public/images/icons/close.png')}}" alt="closes"></span>
	      			<div class="list_desc_price">
	      				{!! $tour->desc_price !!}
	      				{!! getDsMetas(304) !!}
	      			</div>
	      		</div>
			</div>
			<div class="back-top"></div>
		@endhandheld
	</div>
	<div class="content-single content-places">
		@handheld
		<div class="tour-body light-graynvp">
			<div class="mobile-nav menu-content">
				<div class="menu-slider swiper-container">
				    <div class="swiper-wrapper">
				        <div class="swiper-slide"><h2><span data-scroll="must-see">Highlights</span></h2></div>
				        <div class="swiper-slide"><h2><span data-scroll="map-sec">Map</span></h2></div>
				        <div class="swiper-slide"><h2><span data-scroll="gallery-sec">Gallery</span></h2></div>
				        <div class="swiper-slide"><h2><span data-scroll="schedule_detail">Detailed schedule</span></h2></div>
				    </div>						    
				</div>
			    <div class="swiper-scrollbar"></div>
			</div>
			<div class="single-sec must-see">
				<div class="content-sec title-sec">
					<div class="list-must-see">
						<div class="item">
							<h3 class="title font-semibold">
								Various activities on sites									
							</h3>
							{!! $tour->must_see_2 !!}
						</div>
						<div class="item">
							<h3 class="title font-semibold">
								Unforgettable moments										
							</h3>
							{!! $tour->must_see_1 !!}
						</div>
						
						<div class="item">
							<h3 class="title font-semibold">
								Nature exploration										
							</h3>
							{!! $tour->must_see_3 !!}
						</div>
						<div class="item">
							<h3 class="title font-semibold">
								Culture experience										
							</h3>
							{!! $tour->must_see_4 !!}
						</div>
					</div>
				</div>
			</div>
			<div class="single-sec map-sec">
				<div class="maps title-sec">
					{!! $tour->map !!}
				</div>
			</div>
			<div class="single-sec gallery-sec">
				<div class="list_gallery title-sec">
					@if($tour->gallery)
						@php 
							$array_img = json_decode($tour->gallery); 
						@endphp
						@if(count($array_img) > 0)
						@foreach($array_img as $key => $img_id)
							@php
								$img = getMedia($img_id);
							@endphp
							@if($img)
								<div class="item" style="background-image: url('{{asset('/public/uploads/'.$img->image_path)}}');">
									<div class="title_image">{{$key + 1}}/{{count($array_img)}} {{$img->title}}</div>
								</div>
							@endif
						@endforeach
						@endif
					@endif
				</div>
			</div>
			<div class="single-sec schedule_detail">
				<div class="title-sec single-sec-tour">
					@if($list_schedule)
					 	@foreach($list_schedule as $key=>$schedule)
							@php
								$list_icons = json_decode($schedule->icon);
							@endphp
							<div id="day-{{$key+1}}" class="list-sec-schedule">
								<h3 class="title graybg yellow font-semibold">
									Day {{$key+1}} - 
									{{$schedule->title}}
								</h3>
								<div class="schedule-right text-center">
									<div class="meal-vp white">
										<img src="{{asset('/public/images/icons/tour-detail/Meal_icon.png')}}" alt="icon"> 
										{!! get_str_meal_tour($schedule->meal) !!}
									</div>
									@if($schedule->gallery)
										@php 
											$array_img = json_decode($schedule->gallery); 
										@endphp
										<div class="gallery-schedule">
											@foreach($array_img as $img_id)
												@php
													$img = getMedia($img_id);
												@endphp
												@if($img)
												<div class="item" style="background-image: url('{{asset('/public/uploads/'.$img->image_path)}}');">
												</div>	
												@endif
											@endforeach	
										</div>
									@endif
							 	</div>
								<div class="schedule-left">
									<div class="content-schedule">
										<div class="desc_schedule">
											{!! $schedule->content !!}
										</div>
										@if($schedule->notes != '')
											<div class="schedule_notes light-graybg">
												<span class="pink font-semibold">Notes</span>
												{!! $schedule->notes !!}
											</div>
										@endif
									</div>
								 </div>	
							</div>
					 	@endforeach
					@endif
				</div>
			</div>
			<div class="plus-detail-tour">
				<div class="transparent-open">
					<div class="plus-open">
						<img src="{{asset('public/images/icons/close.png')}}" alt="bigg_icon">
					</div>
				</div>
				<div class="list-brief">
					<span class="closes"><img src="{{asset('public/images/icons/close.png')}}" alt="bigg_icon"></span>
					@if($list_schedule)
			      		<div class="wrapper_scroll pink">
			      			<div class="item no_hover">
								<div class="days">
									<h7 class="title pink">DAY</h7>
								</div>
								<div class="description">
									<h7 class="title pink">SHORT DESCRIPTION</h7>
								</div>
							</div>
			      			<div class="list-itinerary">
								@foreach($list_schedule as $key=>$schedule)
									<div class="item show_{{ $key }}">
										<div class="days mar_day">
											{{$key+1}}
										</div>
										<div class="description">
											<a href="#day-{{$key+1}}" data-day="day-{{$key+1}}" class="scroll_day">
												{!! $schedule->title !!}
											</a>
										</div>
									</div>
								@endforeach
							</div>
			      		</div>
					@endif
				</div>
			</div>
			<div class="back-to-start"></div>
		</div>
		@endhandheld
		@desktop
		<div class="sec-01 light-graynvp padding-center">
			<div class="container">
				<div class="row">
					@desktop
					<div class="col-md-3" id="sidebar">
						<div class="gr-info">
							<div class="wrapper">
								<div class="item personalize">
									<a href="{{ route('createPersonalize') }}" class=" btn_personalize">Personalize</a>
								</div>
								<div class="item code">
									<span class="title">Package code</span>
									<p class="value">{{ $tour->code }}</p>
								</div>
								<div class="item duration">
									<span class="title">Theme</span>
									<p class="value">{{ $cates->title }}</p>
								</div>
								<div class="item duration">
									<span class="title">Duration</span>
									<p class="value">{{ $tour->number }} days</p>
								</div>
								<div class="item destination">
									<span class="title">Destination(s)</span>
									@if($countCountry==1)
										<p class="value">{{ getDestinationsOfTour($tour->id) }}</p>
									@else
										<p class="value"> Asia </p>
									@endif
									
								</div>
								<div class="item price hover_yellow"  data-toggle="modal" data-target="#description_price">
									<span class="title">Estimated price </span>
									<p class="value">{{ $tour->price != '' ? 'From $'.number_format($tour->price,0,".",",") :  'From: On Request'}}</p>
								</div>
								<div class="item itinerary">
									<a href="#" class="btn btn_itinerary" data-toggle="modal" data-target="#itinerary_brief">Itinerary brief</a>
								</div>
								<div class="item pdf hover_yellow" data-toggle="modal" data-target="#modalPDF">
									<span class="title">Read it later?</span>
									<p class="value">Download in PDF</p>
								</div>
								<div class="item booking_steps">
									<a href="{{ route('bookingSteps') }}" class="btn btn_booking_steps" target=”_blank”>3-C booking steps</a>
								</div>
							</div>
						</div>
					</div>
					@enddesktop
					<div class="col-md-9" id="content">
						<div class="single-sec must-see">
							<div class="title-sec yellow">
								<h2 class="title font-semibold">HIGHLIGHTS</h2>
							</div>
							<div class="content-sec">
								<div class="list-must-see">
									<div class="item">
										<h3 class="title font-semibold">
											Various activities on sites									
										</h3>
										{!! $tour->must_see_2 !!}
									</div>
									<div class="item">
										<h3 class="title font-semibold">
											Unforgettable moments										
										</h3>
										{!! $tour->must_see_1 !!}
									</div>
									
									<div class="item">
										<h3 class="title font-semibold">
											Nature exploration										
										</h3>
										{!! $tour->must_see_3 !!}
									</div>
									<div class="item">
										<h3 class="title font-semibold">
											Culture experience										
										</h3>
										{!! $tour->must_see_4 !!}
									</div>
								</div>
							</div>
						</div>
						
					</div>
				</div>
			</div>
		</div>
		<div class="maps">
			<h2 style="display: none;">Map</h2>
			{!! $tour->map !!}
		</div>
		<div class="single-sec gallery-sec">
			<h2 style="display: none;">Gallery</h2>
			<div class="content-sec container">
				<div class="list_gallery">
				@if($tour->gallery)
					@php 
						$array_img = json_decode($tour->gallery); 
					@endphp
					@if(count($array_img) > 0)
					@foreach($array_img as $key => $img_id)
						@php
							$img = getMedia($img_id);
						@endphp
						@if($img)
							<div class="item" style="background-image: url('{{asset('/public/uploads/'.$img->image_path)}}');">
								<div class="title_image">{{$key + 1}}/{{count($array_img)}} {{$img->title}}</div>
							</div>
						@endif
					@endforeach
					@endif
				@endif
				</div>
			</div>
		</div>
		<div class="single-sec-tour light-graynvp slide_owl">
			<h2 style="display: none;">Detailed schedule</h2>
			<div class="container">
				@if($list_schedule)
				 	@foreach($list_schedule as $key=>$schedule)
						@php
							$list_icons = json_decode($schedule->icon);
						@endphp
						<div id="day-{{$key+1}}" class="list-sec-schedule">
							<div class="schedule-left">
						 		<h3 class="title graybg yellow font-semibold">
									Day {{$key+1}} - 
									{{$schedule->title}}
								</h3>
								<div class="content-schedule">
									<div class="desc_schedule">
										{!! $schedule->content !!}
									</div>
									@if($schedule->notes != '')
										<div class="schedule_notes light-graybg">
											<span class="pink font-semibold">Notes</span>
											{!! $schedule->notes !!}
										</div>
										@endif
									</div>
							 </div>
						 	<div class="schedule-right text-center">
						 		<div class="meal graybg yellow">
									<img src="{{asset('/public/images/icons/tour-detail/Meal-icon-yellow.png')}}" alt="icon"> 
									{!! get_str_meal_tour($schedule->meal) !!}
								</div>
								@if($schedule->gallery)
									@php 
										$array_img = json_decode($schedule->gallery); 
									@endphp
									<div class="gallery-schedule">
										@foreach($array_img as $img_id)
											@php
												$img = getMedia($img_id);
											@endphp
											@if($img)
											<div class="item" style="background-image: url('{{asset('/public/uploads/'.$img->image_path)}}');">
												<a href="#" class="btn-show-gallery" data-modal="#gallery-schedule" data-key="{{ $key }}">
													<img src="{{asset('/public/images/icons/tour-detail/wide-screen.png')}}" alt="icon"> 
												</a>
												@if($list_icons)
													<ul class="list-icon-schedule">
														@foreach($list_icons as $icon_id)
															@php
																$icon = getIconScheduleByID($icon_id);
															@endphp
															<li>
																<a href="#">{!! imageAuto($icon->white_icon, $icon->title) !!}</a>
																<span class="name">{{$icon->title}}</span>
															</li>
														@endforeach
													</ul>
												@endif
											</div>	
											@endif
										@endforeach	
									</div>
								@endif
						 	</div>	
						</div>
					 	
				 	@endforeach
				@endif
			</div>
		</div>
		@enddesktop
		<div class="request mar_nvp" style="background-image: url('{{ getImgUrl($tour->image_personalize) }}')">
			<div class="container">
				<div class="list-request">
					<div class="row item-request">
						<div class="col-md-5 item left-item">
							{!! image(getDsMetas(260),300,220,'image') !!}
						</div>
						<div class="col-md-7 text-center item">
							<span class="aplan yellow">Does this tour inspire <br>you?</span>
							<a class="btn btn-request" href="{{ route('createPersonalize',['title'=>$tour->title]) }}" target="_blank">PERSONALIZE</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="hand_craft slide_owl">
			<div class="container">
				<div class="header-sec text-center">
					<div class="title-sec">
						<span class="title pink">SIMILAR TOUR PACKAGES</span>
					</div>
				</div>
				@if($countCountry==1)
					@include('parts.countryTourDetails.list_tour_country')
					<div class="bot-tour">
		                <a href="{{ route('countryTour', ['slug_country' => $country->slug]) }}" class="btn btn-tour">{{ $country->title }} tour packages</a>
		            </div>
				@else
					@include('parts.list_tour')
					<div class="bot-tour">
		                <a href="{{ route('asiaTour') }}" class="btn btn-tour">All tour packages</a>
		            </div>
				@endif		
				
			</div>
		</div>
		<div class="tready-yet light-graynvp">
			<div class="container">
				<div class="header-sec text-center">
					<div class="title-sec">
						<span class="title pink">NOT READY YET?</span>
					</div>
					@if($countCountry==1)
						@if(isset($desc_tourCountry))
			            	<div class="desc_p">
								{!! $desc_tourCountry->content_ready_yet !!}
							</div>
			            @endif
					@else
						<div class="desc_p">
							{!! getDsMetas(305) !!}
						</div>
					@endif	
				</div>
			</div>
		</div>
	@if($countCountry==1)
		<div class="places-to-visit light-graybg padding_center slide_owl">
			<div class="container">
				<div class="header-sec text-center">
					<div class="title-sec">
						<span class="title pink">PLACES TO VISIT IN {{ $country->title }}</span>
					</div>
				</div>
				@include('parts.countryTourDetails.list_places_to_visit')
			</div>
		</div>
		<div class="bot-tour top-bot light-graynvp">
		    <a href="{{ route('countryPlaceToVisit', ['slug_country' => $country->slug]) }}" class="btn btn-tour"> {{ $country->title }} DESTINATIONS</a>
		</div>
		<div class="plans-travels light-graybg padding_center">
			<div class="container">
				<div class="header-sec text-center">
					<div class="title-sec">
						<span class="title pink">{{ $country->title }} PLANS BY TRAVEL THEME</span>
					</div>
				</div>
				 @include('parts.countryTourDetails.list_tour_style')
			</div>
		</div>
		<div class="plans-time light-graynvp padding_center">
			<div class="container">
				<div class="header-sec text-center">
					<div class="title-sec">
						<span class="title pink">{{ $country->title }} PLANS BY TIME FRAME</span>
					</div>
				</div>
				@include('parts.countryTourDetails.list_tour_duration')
			</div>
		</div>
		<div class="bot-tour">
            <a href="{{ route('countryTour', ['slug_country' => $country->slug]) }}" class="btn btn-tour">{{ $country->title }} tour packages</a>
        </div>
        <div class="request back-none" style="background-image: url('{{ getImgUrl($tour->image_request) }}')">
			@php
				$img_request = getDsMetas(260);
				$title_request = getDsMetas(301);
			@endphp
			@include('parts.request')
		</div>
		<div class="preparing light-graybg slide_owl padding_center">
			<div class="container">
				<div class="header-sec text-center">
					<div class="title-sec">
						<span class="title pink">{{ $country->title }} TRAVEL TIPS & GUIDE</span>
					</div>
					@if(isset($desc_tourCountry))
		            	<div class="desc_p">
							{!! $desc_tourCountry->content_tips !!}
						</div>
		            @endif
				</div>
				@include('parts.countryTourDetails.travel_tips_guide')
			</div>
		</div>
		<div class="section-blog slide_owl light-graynvp padding_center">
			<div class="container">
				<div class="header-sec text-center">
					<div class="title-sec">
						<span class="title pink">{{ $country->title }} BLOG ARTICLES</span>
					</div>
				</div>
				@php
					$list_blog = allArticleByCountry($country->id);
				@endphp
				@if($list_blog)
					<div class="@desktop slide-style @elsedesktop slide-tour-dost @enddesktop list-blog">
						@foreach($list_blog as $key => $item)
							@php
								$countCountry  = getAllCountriesId($item->id);
							@endphp
	                        @include('articles.item')
						@endforeach
					</div>
				@endif
			</div>
		</div>
		<div class="another_country padding_center">
			<div class="container">
				<div class="header-sec text-center">
					<div class="title-sec">
						<span class="title pink">CHECK OUT OTHER DESTINATIONS</span>
					</div>
				</div>
				 @include('parts.countryTourDetails.another_country')
			</div>
		</div>
	@else
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
			<div class="container">
				<div class="header-sec text-center">
					<div class="title-sec">
						<span class="title pink">PLANS BY TIME FRAME</span>
					</div>
				</div>
				@include('parts.AsiaTourDetails.plans_time_frame')
				<div class="bot-tour top-bot">
	                <a href="{{ route('asiaTour') }}" class="btn btn-tour">All tour packages</a>
	            </div>
			</div>
		</div>
		<div class="request back-none" style="background-image: url('{{ getImgUrl($tour->image_request) }}')">
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
						<h7 class="title pink">TRAVEL TIPS & GUIDE</h7>
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
				@if($list_blog)
					<div class="@desktop slide-style @elsedesktop slide-tour-dost @enddesktop list-blog">
						@foreach($list_blog as $key => $item)
							@php
								$countCountry  = getAllCountriesId($item->id);
							@endphp
	                        @include('articles.item')
						@endforeach
					</div>
				@endif
			</div>
		</div>
	@endif	
	</div>
</div>
<div id="gallery-schedule"  class="modal fade" role="dialog">
	<div class="menu-modal">
		@include('parts.countryTourDetails.menu_tour_detail')
	</div>
	<div class="modal_gall_top container">
  		@if($list_schedule)
      		@foreach($list_schedule as $key=>$schedule)
			<div class="list_gallery gallery__{{ $key }}">
				@if($schedule->gallery)
					@php 
						$array_img = json_decode($schedule->gallery); 
					@endphp
					@if(count($array_img) > 0)
					@foreach($array_img as $key => $img_id)
						@php
							$img = getMedia($img_id);
						@endphp
						@if($img)
							<div class="item" style="background-image: url('{{asset('/public/uploads/'.$img->image_path)}}');">
								<div class="title_image">{{$key + 1}}/{{count($array_img)}} {{$img->title}}</div>
							</div>
						@endif
					@endforeach
					@endif
				@endif
			</div>
			@endforeach
		@endif
	</div>	
</div>
<div id="itinerary_brief"  class="modal fade" role="dialog">
	<div class="menu-modal">
		@include('parts.countryTourDetails.menu_tour_detail')
	</div>
	<div class="modal-dialog">
	    <!-- Modal content-->
	    <div class="modal-content">
	      	<div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal"><img src="{{asset('/public/images/close.png')}}" alt="icon" class="img_close"></button>
		        <p class="modal-title">Itinerary brief</p>
	      	</div>
	      	<div class="modal-body">
	      		@if($list_schedule)
	      		<div class="wrapper_scroll yellow">
	      			<div class="list-itinerary">
						<div class="item no_hover">
							<div class="days">
								<h7 class="title yellow">DAY</h7>
							</div>
							<div class="description">
								<h7 class="title yellow">SHORT DESCRIPTION</h7>
							</div>
							<div class="meal">
								<h7 class="title yellow">MEAL</h7>
							</div>
						</div>
						@foreach($list_schedule as $key=>$schedule)
							<div class="item show_{{ $key }}">
								<div class="days mar_day">
									{{$key+1}}
								</div>
								<div class="description">
									<a href="#day-{{$key+1}}" data-day="day-{{$key+1}}" class="scroll_day">
										{!! $schedule->title !!}
									</a>
								</div>
								<div class="meal">
									{!! get_str_meal_tour($schedule->meal) !!}
								</div>
							</div>
						@endforeach
					</div>
	      		</div>
				@endif
	      	</div>
	    </div>
	 </div>
</div>
<div id="description_price"  class="modal fade" role="dialog">
	<div class="menu-modal">
		@include('parts.countryTourDetails.menu_tour_detail')
	</div>
	<div class="modal-dialog">
	    <!-- Modal content-->
	    <div class="modal-content">
	    	<div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal"><img src="{{asset('/public/images/close.png')}}" alt="icon" class="img_close"></button>
	      	</div>
	      	<div class="modal-body">
	      		<div class="wrapper_scroll yellow">
	      			<div class="list_desc_price">
	      				{!! $tour->desc_price !!}
	      				{!! getDsMetas(304) !!}
	      			</div>
	      		</div>
	      	</div>
	    </div>
	 </div>
</div>
<div id="map-and-plan" class="modal fade" role="dialog">
 	<div class="modal-dialog">
	    <!-- Modal content-->
	    <div class="modal-content">
	      	<div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal">&times;</button>
		        <p class="modal-title">Map & plan</p>
	      	</div>
	      	<div class="modal-body">
		        <div class="wrap-content">
		        	<div class="row">
		        		<div class="col-md-6">
		        			<div class="plan light-graybg-2">
		        				<div class="wrap-table scrollbar-inner">
			        				<table>
			        					<thead>
			        						<tr>
			        							<td class="day">Day</td>
			        							<td class="route">Route</td>
			        							<td class="meal">Meal</td>
			        						</tr>
			        					</thead>
			        					<tbody>
			        						@foreach($list_schedule as $key=>$schedule)
			        							@php
			        								$array_meal = json_decode($schedule->meal);			     
			        							@endphp
												<tr>
													<td class="day">Day {{$key+1}}</td>
													<td class="route">
														<a href="#day-{{$key+1}}" data-day="day-{{$key+1}}">
															{!! $schedule->title !!}
														</a>
													</td>
													<td class="meal">
														@if($array_meal)
															<span class="meal uppercase">{{ implode("", $array_meal) }}</span>
														@else
															None
														@endif
													</td>
												</tr>
											@endforeach
			        					</tbody>
			        				</table>
		        				</div>
		        			</div>
		        		</div>
		        		<div class="col-md-6">
		        			<div class="map">
		        				{!! $tour->map !!}
		        			</div>
		        		</div>
		        	</div>
		        </div>
      		</div>
	    </div>
  	</div>
</div>
<!-- Modal PDF -->
<div id="modalPDF" class="modal fade" role="dialog">
	<div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      	<div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal">&times;</button>
	        <p class="modal-title">Download in PDF</p>
      	</div>
      	<div class="modal-body">
      		<div class="text-center">
		        <p>Thank you! Your PDF file is now available for download</p>
		        <a href="{{ $tour->pdf}}" class="btn-page-2 pinkbg btn-download" download>Download</a>
	        </div>
  		</div>
    </div>
	</div>
</div>
@stop