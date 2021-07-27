@php
	$meta_key = ($seo && $seo->key != '') ? $seo->key : '';
	$meta_value = ($seo && $seo->value != '') ? $seo->value : '';
@endphp
@extends('templates.master')
@section('content')
@section('title', $guide->title_tag)
@section('keywords', $meta_key)
@section('description', $meta_value)
@php	
	$country = getCountryById($guide->country_id);
	$tableContent = getTableContent($guide->id, 'market');
	$bg_img = getImgUrl($guide->image);
	$bg_looking = ($guide->image_looking != '' ) ? getImgUrl($guide->image_looking) : getImgUrl(getDsMetas(278));
	$bg_request = ($guide->image_request != '' ) ? getImgUrl($guide->image_request) : getImgUrl(getDsMetas(259)); 
	$breadcrumb = Breadcrumbs::render('detailTravelTip', $country, $guide->short_title);
	$title_h2 = ' Special Tips & Tours - ';
	$title_top_h1 = $guide->title;
	$post_type_active = 'market';
	//dd(route('postTypeCountryTravel', ['slug_country' => $country->slug, 'slug'=> $slug]));
@endphp
<div class="detail-travel-tip singe-post singe-places guide-mobi" id="market-guide">
	<div class="image-header" style="background-image: url(<?php echo $bg_img; ?>);">
	    <div class="wrap">
	        <div class="container">
	        	@if(isset($breadcrumb))
	                {!! $breadcrumb !!}
	            @endif
	                <h1 class="title-banner-1">
	                	<span class="title_sp">- {{ $country->title }}{{ $title_h2 }}</span>
		                <p>{{ $title_top_h1 }}</p>
		            </h1>
		        @desktop
		        @if($related_guides)
					<div class="search-box white serch-cities">
						{!!csrf_field()!!}
						<input type="text" name="keyword" class="white" placeholder="Other Countries of Origin ?" data-action="{{ route('searchCatMarketGuide', $country->slug) }}" autocomplete="off" />
						<button type="submit" class="submit_cities"><img src="{{ asset('public/images/icons/all/loupe-white.png') }}" alt="loupe-white"></button>
						<input type="hidden" name="country" value="{{$country->slug}}">
						<input type="hidden" name="cat_guide" value="{{$guide->cat_id}}">
						<div class="list-result list-place">
							<ul>
								@foreach($related_guides as $item)
   									<li>
   										<a class="link_country" href="{{ route('postTypeCountryTravel', ['slug_country' => $country->slug,'slug' => $item->slug]) }}">
   											{{ $item->short_title }}
   										</a>
   									</li>
   								@endforeach
							</ul>
						</div>
					</div>
				@endif
				@elsedesktop
				<div class="graybg list-orther">
	            	<span class="open-orther">Other Destination?</span>
	            	<div class="other-mobi">
		            	<ul>
		            		@foreach ($another_country as $item)
								@php
									$addClass = '';
									if($item->title == $country->title) $addClass = 'yellow';
								@endphp
								<li class="{{$addClass}}">
									@if($item->title == $country->title)
										{{ $item->title }}
									@else
										<a href="{{ route('postTypeCountryTravel', ['slug_country' => $item->slug, 'slug'=> $slug]) }}" rel="nofollow">
											{{ $item->title }}
										</a>
									@endif
								</li>
							@endforeach
		            	</ul>
		            </div>
	            </div>
				@enddesktop
	        </div>
	    </div>
	</div>
	<div class="container padding-top-mobi">
		<div class="top-intro text-center">
            	{!! $guide->desc !!}
		</div>
	</div>
	<div class="content-guide content-places">
		<div class="content-page light-graynvp">
			<div class="container">
				<div class="row">
					@desktop
					<div id="sidebar" class="col-md-3">
						<div class="gr-not-fixed sb-categories" >
							<h7 class="sb-title">DESTINATIONS</h7>
							@if($another_country)
							<div class="desc">
								<ul class="list-cat no-list-style">
									
									@foreach ($another_country as $item)
										@php
											$addClass = '';
											if($item->title == $country->title) $addClass = 'active';
											//dd($item);
										@endphp
										<li class="{{$addClass}}">
											@if($item->title == $country->title)
												{{ $item->title }}
											@else
												<a href="{{ route('postTypeCountryTravel', ['slug_country' => $item->slug, 'slug'=> $slug]) }}" rel="nofollow">
												{{ $item->title }}
												</a>
											@endif
										</li>
									@endforeach
								</ul>
							</div>
							@endif
						</div>
						<div class="group-fixed">
							<div class="table-list table-list-schedule ">
								<div class="table-content">
									<h7 class="sb-title">TABLE OF CONTENT</h7>
									<div class="fix_content">
										<div class="table-body scrollbar-inner">
											<div class="wrap-body">
												@if($tableContent)
													<ol>
													@php
														$tableLevel1s = getTableDetailLevel1($tableContent->id); 
													@endphp
													@if($tableLevel1s) <!--Level 1-->
														@foreach($tableLevel1s as $key => $level1)
															{!! getHeadingTbContent($level1->id) !!}
														@endforeach
													@endif
												</ol>
												@endif
											</div>
										</div>
									</div>
								</div>
								
							</div>
						</div>
					</div>
					@enddesktop
					<div id="content" class="col-md-9">
						<div class="wr-content">
							<div class="citizens-sec">
								<h2 class="title pink">{{ $country->title }} TRAVEL TIPS FOR "{{ $title_top_h1 }}"</h2>
							</div>
							<div class="list-tb-content">
								@if($tableContent)
									@php
										$tableLevel1s = getTableDetailLevel1($tableContent->id); 
										//dd($tableLevel1s );
									@endphp
									@if($tableLevel1s) <!--Level 1-->
										@foreach($tableLevel1s as $key => $level1)
											{!! getContentTbContentMarket($level1->id) !!}
										@endforeach
									@endif
								@endif
							</div>
							<div class="back-to-start"></div>
						</div>
					</div>
					@handheld
					<div class="plus-table-guide">
						<div class="transparent-open">
							<div class="plus-open">
								<img src="{{asset('public/images/icons/close.png')}}" alt="bigg_icon">
							</div>
						</div>
						<div class="list-guide-mobi">
							<h7 class="title">TABLE OF CONTENT</h7>
							<span class="closes"><img src="{{asset('public/images/icons/close.png')}}" alt="closes"></span>
							<div class="table-body scrollbar-inner">
								<div class="wrap-body">
									@if($tableContent)
										<ol>
										@php
											$tableLevel1s = getTableDetailLevel1($tableContent->id); 
										@endphp
										@if($tableLevel1s) <!--Level 1-->
											@foreach($tableLevel1s as $key => $level1)
												{!! getHeadingTbContent($level1->id) !!}
											@endforeach
										@endif
									</ol>
									@endif
								</div>
							</div>
						</div>
					</div>
					@endhandheld
				</div>
			</div>
		</div>
		<div class="hand_craft slide_owl">
			<div class="container">
				<div class="header-sec text-center">
					<div class="title-sec">
						<h2 class="title pink title-citizens">{{ $country->title }} TOUR PACKAGES FOR "{{ $title_top_h1 }}"</h2>
					</div>
				</div>
				@include('parts.related_tours')
			</div>
		</div>
		<div class="request mar_nvp" style="background-image: url('<?php echo $bg_looking; ?>')">
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
					@if($desc_guideCountry)
		            	<div class="desc_p">
							{!! $desc_guideCountry->content_ready_yet!!}
						</div>
					@endif
				</div>
			</div>
		</div>
		<div class="places-to-visit light-graybg padding_center slide_owl mar-top">
			<div class="container">
				<div class="header-sec text-center">
					<div class="title-sec">
						<span class="title pink">PLACES TO VISIT IN {{ $country->title }}</span>
					</div>
				</div>
				@include('parts.countryTourDetails.list_places_to_visit')
			</div>
		</div>
		<div class="bot-tour light-graynvp top-bot">
		    <a href="{{ route('countryPlaceToVisit', ['slug_country' => $country->slug]) }}" class="btn btn-tour">{{ $country->title }} DESTINATIONS</a>
		</div>
		<div class="plans-travels light-graybg padding_center slide_owl">
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
		<div class="bot-tour top-bot">
	        <a href="{{ route('countryTour', ['slug_country' => $country->slug]) }}" class="btn btn-tour">{{ $country->title }} tour packages</a>
	    </div>
	    <div class="request back-none" style="background-image: url('<?php echo $bg_request; ?>')">
			@php
				$img_request = getDsMetas(260);
				$title_request = getDsMetas(301);
			@endphp
			@include('parts.request')
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
	</div>
</div>

@stop