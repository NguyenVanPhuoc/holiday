@php
	$seo = get_seo($country->id, 'country');
	$meta_key = ($seo && $seo->value != null) ? $seo->key : '';
	$meta_value = ($seo && $seo->value != null) ? $seo->value : '';	
	$bg_img = getImgUrl($country->image); 
	$icon_top = getImgUrl($country->icon);
	$breadcrumb = Breadcrumbs::render('overviewCountry', $country->title);
	$title_top_h1 = $country->title .' travel';
	$post_type_active = 'overview';
	$bg_looking = (isset($highlight) && $highlight->image_request_one != '' ) ? getImgUrl($highlight->image_request_one) : getImgUrl(getDsMetas(278));
	$bg_request = (isset($highlight) && $highlight->image_request_two != '' ) ? getImgUrl($highlight->image_request_two) : getImgUrl(getDsMetas(259));
@endphp

@extends('templates.master')
@section('content')
@section('title', $country->title_tag)
@section('description', $meta_value)
@section('keywords', $meta_key)
@section('image_url', $bg_img)

<div id="overview" class="overview-page singe-post">
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
    <div class="content-places content-sec">
		<div class="container">
			<div class="top-intro text-center">{!! $country->desc !!}</div>
		</div>
		<div class="maps">
			{!! $country->map !!}
		</div>
		<div class="going light-graynvp">
			<div class="container">
				<div class="header-sec text-center">
					<div class="title-sec">
						<h2 class="title pink">WHERE TO GO IN {{ $country->title }} ?</h2>
					</div>
	            	<div class="desc_p">
						{{ $country->text_where_to_go }} 
					</div>
				</div>
				<div class="search-box white serch-cities">
	            	<form action="" method="get" id="search-city">
						{!!csrf_field()!!}
						<input type="text" name="keyword" class="white" placeholder="Search for a destination" data-action="{{ route('loadCities', $country->slug) }}" autocomplete="off" />
						<button type="submit" class="submit_cities"><img src="{{ asset('public/images/icons/all/loupe-white.png') }}"></button>
						<div class="list-result list-place">
							<ul>
								@foreach($list_city as $item)
									<li><a href="{{ route('postTypeCountryTravel', ['slug_country' => $country->slug,'slug' => $item->slug]) }}" class="link_city">{{ $item->title }}</a></li>
								@endforeach
							</ul>
						</div>
					</form>
				</div>
				@php 
					$main_city = explode(',',$list_main_city->list_main_city);
					$item = array();
				@endphp
				@desktop
				@foreach($main_city as $key => $items)
					@php 
						$city_objs = getCountry($items);
						$item[] = $city_objs;
					@endphp
				@endforeach
					<div class="row list_orv">
		           		@if(isset($item[0]) && isset($item[1]))
			            	<div class="col-md-4 wrap-item">
			            		@if($item[0])
		            				<div class="item">
		            					{!!image($item[0]->image, 300, 300, $item[0]->title)!!}
			            				<h3 class="title-country white">{{$item[0]->title}}</h3>
			            				<a class="link" href="{{ route('postTypeCountryTravel', ['slug_country' => $country->slug,'slug' => $item[0]->slug]) }}"></a>
			            				<div class="desc_hover"> 
		                                    <div class="text-center">
		                                        <img class="bee" src="{{asset('public/images/bee/bee-white.png')}}"> 
		                                        <h7 class="title_hover yellow">{{$item[0]->title}}</h7>
		                                        <p class="white">{{$item[0]->short_desc}}</p>
		                                    </div>
		                                </div>
		            				</div>
	            				@endif
	            				@if($item[1])
		            				<div class="item">
		            					{!!image($item[1]->image, 300, 350, $item[1]->title)!!}
			            				<h3 class="title-country white">{{$item[1]->title}}</h3>
			            				<a class="link" href="{{ route('postTypeCountryTravel', ['slug_country' => $country->slug,'slug' => $item[1]->slug]) }}"></a>
			            				<div class="desc_hover"> 
		                                    <div class="text-center">
		                                        <img class="bee" src="{{asset('public/images/bee/bee-white.png')}}"> 
		                                        <h7 class="title_hover yellow">{{$item[1]->title}}</h7>
		                                        <p class="white">{{$item[1]->short_desc}}</p>
		                                    </div>
		                                </div>
		            				</div>
	            				@endif
	            			</div>
	        			@endif
	        			@if(isset($item[2]) && isset($item[3]))
			            	<div class="col-md-4 wrap-item">
			            		@if($item[2])
	            					<div class="item">
	            						{!!image($item[2]->image, 300, 350, $item[2]->title)!!}
	            						<h3 class="title-country white">{{$item[2]->title}}</h3>
	            						<a class="link" href="{{ route('postTypeCountryTravel', ['slug_country' => $country->slug,'slug' => $item[2]->slug]) }}"></a>
			            				<div class="desc_hover"> 
		                                    <div class="text-center">
		                                        <img class="bee" src="{{asset('public/images/bee/bee-white.png')}}"> 
		                                        <h7 class="title_hover yellow">{{$item[2]->title}}</h7>
		                                        <p class="white">{{$item[2]->short_desc}}</p>
		                                    </div>
		                                </div>
		                            </div>
		                         @endif
	            				@if($item[3])
	            					<div class="item">
	            						{!!image($item[3]->image, 300, 350, $item[3]->title)!!}
	            						<h3 class="title-country white">{{$item[3]->title}}</h3>
	            						<a class="link" href="{{ route('postTypeCountryTravel', ['slug_country' => $country->slug,'slug' => $item[3]->slug]) }}"></a>
			            				<div class="desc_hover"> 
		                                    <div class="text-center">
		                                        <img class="bee" src="{{asset('public/images/bee/bee-white.png')}}"> 
		                                        <h7 class="title_hover yellow">{{$item[3]->title}}</h7>
		                                        <p class="white">{{$item[3]->short_desc}}</p>
		                                    </div>
		                                </div>
		                            </div>
	            				@endif
	            			</div>
	        			@endif
	        			@if(isset($item[4]) && isset($item[5]))
			            	<div class="col-md-4 wrap-item">
	            				@if($item[4])
	            					<div class="item">
	            						{!!image($item[4]->image, 300, 280, $item[4]->title)!!}
	            						<h3 class="title-country white">{{$item[4]->title}}</h3>
	            						<a class="link" href="{{ route('postTypeCountryTravel', ['slug_country' => $country->slug,'slug' => $item[4]->slug]) }}"></a>
			            				<div class="desc_hover"> 
		                                    <div class="text-center">
		                                        <img class="bee" src="{{asset('public/images/bee/bee-white.png')}}"> 
		                                        <h7 class="title_hover yellow">{{$item[4]->title}}</h7>
		                                        <p class="white">{{$item[4]->short_desc}}</p>
		                                    </div>
		                                </div>
		                            </div>
	            				@endif
	            				@if($item[5])
	            					<div class="item">
	            						{!!image($item[5]->image, 300, 350, $item[5]->title)!!}
	            						<h3 class="title-country white">{{$item[5]->title}}</h3>
	            						<a class="link" href="{{ route('postTypeCountryTravel', ['slug_country' => $country->slug,'slug' => $item[5]->slug]) }}"></a>
			            				<div class="desc_hover"> 
		                                    <div class="text-center">
		                                        <img class="bee" src="{{asset('public/images/bee/bee-white.png')}}"> 
		                                        <h7 class="title_hover yellow">{{$item[5]->title}}</h7>
		                                        <p class="white">{{$item[5]->short_desc}}</p>
		                                    </div>
		                                </div>
		                            </div>
		                         @endif
	            			</div>
	        			@endif
					</div>
				@elsedesktop
					<div class="slide-dost list_orv">
						@foreach($main_city as $key => $items)
							@php 
								$city_objs = getCountry($items);
								$style = $city_objs;
							@endphp
							<div class="wrapper-item">
				                <div class="item" style="background-image: url('{!! getImgUrl($style->image); !!}')">
				                	@handheld
				                	<a class="link" href="{{ route('postTypeCountryTravel', ['slug_country' => $country->slug,'slug' => $style->slug]) }}" rel="dofollow"></a>
				                	@endhandheld
				                    <h7 class="title-country white">{{$style->title}}</h7>
				                    <div class="desc_hover">
				                        <a class="link_traveltips" href="{{ route('postTypeCountryTravel', ['slug_country' => $country->slug,'slug' => $style->slug]) }}"></a>
				                        <div class="desc">
				                            <img class="bee" src="{{asset('public/images/bee/bee-white.png')}}"> 
				                            <h7 class="title_hover yellow">{{$style->title}}</h7>
				                            <p class="white">{!! $style->short_desc !!}</p>
				                        </div>
				                    </div>
				                </div>
				            </div>
						@endforeach
					</div>
				@enddesktop
				<div class="bot-tour">
				    <a href="{{ route('countryPlaceToVisit', ['slug_country' => $country->slug]) }}" class="btn btn-tour">{{ $country->title }} DESTINATIONS</a>
				</div>
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
		<div class="what_style">
			<div class="container">
				<div class="header-sec text-center">
					<div class="title-sec">
						<h2 class="title pink">WHAT TO DO & SEE IN {{ $country->title }} ?</h2>
					</div>
	            	<div class="desc_p">
						{{ $country->text_what_to_do }} 
					</div>
				</div>
				@if($list_tourStyle)
					@desktop
						<div class="row list_orv grid">
							@php $image = ""; @endphp
							@foreach($list_tourStyle as $key => $item)
							@php 
								if($key==0)
									$image = image($item->image, 300, 310, $item->title);
								elseif($key==1)
									$image = image($item->image, 300, 330, $item->title);
								elseif($key==2)
									$image = image($item->image, 300, 420, $item->title);
								elseif($key==3)
									$image = image($item->image, 300, 340, $item->title);
								elseif($key==4)
									$image = image($item->image, 300, 340, $item->title);
								elseif($key==5)
									$image = image($item->image, 300, 420, $item->title);
								elseif($key==6)
									$image = image($item->image, 300, 370, $item->title);
								elseif($key==8)
									$image = image($item->image, 300, 250, $item->title);
								else
									$image = image($item->image, 300, 380, $item->title);
							@endphp
								@include('parts.overviews_style')
							@endforeach
						</div>
					@elsedesktop
						<div class="slide-dost list_orv">
							@foreach($list_tourStyle as $key => $item)
								<div class="wrapper-item">
									<div class="item" style="background-image: url('{!! getImgUrl($item->image); !!}')">
										<h3 class="title-country white">{{$item->title}}</h3>
										<a class="link" href="{{ route('tour', ['slug_country'=>$country->slug,'slug'=>$item->slug ]) }}"></a>
										<div class="desc_hover"> 
								            <div class="text-center">
								                <h7 class="title_hover yellow">{{$item->title}}</h7>
								                <div class="white">{!! $item->desc !!}</div>
								            </div>
								        </div>
									</div>
								</div>
							@endforeach
						</div>
					@enddesktop
				@endif
			</div>
		</div>
		<div class="request mar_nvp" style="background-image: url('<?php echo $bg_request; ?>')">
			<div class="container">
				<div class="list-request">
					<div class="row item-request">
						<div class="col-md-5 item left-item">
							{!! image(getDsMetas(260),300,220,'image') !!}
						</div>
						<div class="col-md-7 text-center item">
							<span class="aplan yellow top">Get inspired?</span>
							<a class="btn btn-request" href="{{ route('createMyTrip') }}">REQUEST A FREE QUOTE</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="inspiration">
			<div class="padding_center">
				<div class="container">
					<div class="header-sec text-center">
						<div class="title-sec">
							<h2 class="title pink">MORE INSPIRATION</h2>
						</div>
		            	<div class="desc_p">
							{{ $country->text_more_inspiration }} 
						</div>
					</div>
					@desktop
					<div class="iframe_video">
						@if($highlight_ct)
							{!! $highlight_ct->video !!}
						@endif
					</div>
					@enddesktop
				</div>
				@handheld
				<div class="iframe_video">
					@if($highlight_ct)
						{!! $highlight_ct->video !!}
					@endif
				</div>
				@endhandheld
			</div>
		</div>
		<div class="exclusive light-graynvp slide_owl">
			<div class="padding_center">
				<div class="container">
					<div class="header-sec text-center">
						<div class="title-sec">
							<h2 class="title pink">{{ $country->title }} EXCLUSIVE EXPERIENCE</h2>
						</div>
		            	<div class="desc_p">
							{{ $country->text_exclusive }} 
						</div>
					</div>
					@if($activities)
						<div class="attraction @desktop slide-style @elsedesktop slide-dost @enddesktop">
							@foreach($activities as $key => $item)
								@include('parts.list_attraction_v1')
							@endforeach
						</div>
					@endif
				</div>
				@handheld
				<div class="desc-style">
			  		@if($activities)
			      		@foreach($activities as $key =>$item)
			      		<div class="desc-content">
		      				<div class="graybg wrapper_scroll">
		      					<img class="cross-mobi cross__{{ $key }}" src="{{asset('public/images/icons/Cross_Yellow.png')}}" alt="Cross-white">
		      					<div class="desc_vp desc__{{ $key }}">
		      						<div class="padding_croll ">
		      							<h7 class="title yellow">{!! $item->title !!}</h7>
						      			{!! $item->desc !!}
						      		</div>
					      		</div>
					      		<div class="button-mobile button__{{ $key }}">	
					      			<a class="btn btn-gallery-mobi" href-key="{{ $key }}">VIEW GALLERY</a>
					      		</div>
		      				</div>
			      		</div>
						@endforeach
					@endif
				</div>
				<div class="gallery-style-mobi">
			  		@if($activities)
			      		@foreach($activities as $key =>$item)
			      		<div class="desc-content">
		      				<div class="list_st_mobi gallery__{{ $key }}">
								@if($item->gallery)
									@php 
										$array_img = json_decode($item->gallery); 
									@endphp
									@if(count($array_img) > 0)
									@foreach($array_img as $key => $img_id)
										@php
											$img = getMedia($img_id);
										@endphp
										@if($img)
											<div class="item" style="background-image: url('{{asset('/public/uploads/'.$img->image_path)}}');">
												<img class="cross-gallery" src="{{asset('public/images/icons/Cross_Yellow.png')}}" alt="Cross-white">
												<div class="title_image">{{$key + 1}}/{{count($array_img)}} {{$img->title}}</div>
											</div>
										@endif
									@endforeach
									@endif
								@endif
							</div>
			      		</div>
						@endforeach
					@endif
				</div>
				@endhandheld
			</div>
		</div>
		<div class="hand_craft slide_owl">
			<div class="padding_center">
				<div class="container">
					<div class="header-sec text-center">
						<div class="title-sec">
							<h2 class="title pink">HAND-CRAFTED {{ $country->title }} TOUR PACKAGES </h2>
						</div>
		            	<div class="desc_p">
							{!! $country->text_hand_crafted !!} 
						</div>
					</div>
					@include('parts.countryTourDetails.list_tour_country_v1')
				</div>
			</div>
		</div>
		<div class="preparing light-graybg slide_owl padding_center">
			<div class="container">
				<div class="header-sec text-center">
					<div class="title-sec">
						<h2 class="title pink">PREPARING YOUR TRIP TO {{ $country->title }}</h2>
					</div>
	            	<div class="desc_p">
						{!! $country->text_preparing !!}
					</div>
				</div>
				@include('parts.countryTourDetails.travel_tips_guide_v1')
			</div>
		</div>
		<!--Blog Section-->
		<div class="section-blog slide_owl light-graynvp padding_center">
			<div class="container">
				<div class="header-sec text-center">
					<div class="title-sec">
						<h2 class="title pink">{{ $country->title }} BLOG ARTICLES</h2>
					</div>
				</div>
				@php
					$list_blog = getListArticleByCountry($country->id,6);
				@endphp
				@if($list_blog)
					<div class="@desktop slide-style @elsedesktop slide-tour-dost @enddesktop list-blog">
						@foreach($list_blog as $key => $item)
	                        @include('articles.item')
						@endforeach
					</div>
				@endif
			</div>
		</div>
		<!--End Blog Section-->
		<div class="another_country">
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
<div id="gallery-style" class="modal fade" role="dialog">
	<div class="modal_gall_top">
  		@if($activities)
      		@foreach($activities as $key =>$item)
      		<div class="row">
      			<div class="col-md-5 col">
      				<div class="graybg wrapper_scroll yellow">
      					<div class="desc_vp desc__{{ $key }}">
      						<div class="padding_croll">
      							<h7 class="title yellow">{!! $item->title !!}</h7>
				      			{!! $item->desc !!}
				      		</div>
			      		</div>
      				</div>
      			</div>
      			<div class="col-md-7 col">
      				<div class="list_st gallery__{{ $key }}">
						@if($item->gallery)
							@php 
								$array_img = json_decode($item->gallery); 
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
			@endforeach
		@endif
	</div>	
</div>
@endsection
