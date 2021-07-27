@extends('templates.master')
@section('title', $page->title)
@section('description', $seo->value)
@section('keywords', $seo->key)
@section('content')

@php
	$categories = get_categories();
 	$list_tour_style = getListTourStyle(); 
 	$Countries=getCountriesfooter();
 	$list_reviewer = getListReviewer(NULL, NULL, 1);
 	$cat_guide = getListCatGuide();
 	$title=$objectMetas->title_preparing;
 	$desc= $objectMetas->desc_preparing;
@endphp
<div id="home" class="page">
	@php  
		$bg_img = getImgUrl($page->image); 
	@endphp
    <div id="home-slide">
    	<div class="wrap-slide">
    		<div class="item" style="background-image: url({{ $bg_img }});">
    			<div class="container">
    				<div class="wrap-item">
    					{!! $page->content !!}
    					<a href="{{route('aboutPage') }}" class="read-more">Read more</a>
    				</div>
    			</div>
    		</div>
    		@foreach($homeSlide as $item)
    			<div class="item" style="background-image: url({{getImgUrl($item->image)}});">
    				<div class="wrap-item">
    					<div class="container">
	    					<h2 class="title">{{ $item->title }}</h2>	
	    					<a href="{{ route('overviewCountry', ['slug_country'=>$item->slug]) }}" class="read-more">Read more</a>
	    				</div>
    				</div>
    			</div>
    		@endforeach
    	</div>
    	<ul id='carousel-custom-dots' class='list-unstyled owl-dots'>
    	@desktop
		    <li class='owl-dot favicon_slides'>
		    	<img src="public/images/icons/logo/favicon grey.png" alt="$item->title" class="icon icon-gray">
	    		<img src="public/images/icons/logo/favicon color.png" alt="$item->title" class="icon icon-active">
	    		<span class="dot-title">Sonasia</span>
		    </li>
		    @foreach($homeSlide as $item)
		    	<li class='owl-dot'>
		    		<img src="{{getImgUrl($item->icon_flag_gray)}}" alt="$item->title" class="icon icon-gray">
		    		<img src="{{getImgUrl($item->icon_flag)}}" alt="$item->title" class="icon icon-active">
		    		<span class="dot-title">{{ $item->title }}</span>
		    	</li>
		    @endforeach
		@enddesktop
		</ul>
    </div>

	<!--Destination Section-->
	<div class="destination-sec has-overlap imgbg imgbg-bottom-left">
		<div class="header-sec text-center">
			<div class="title-sec">
				<div class="container">
					<span class="title pink">{{$objectMetas->title_country}}</span>
				</div>	
			</div>
			<div class="container">
				<div class="desc_p">{{$objectMetas->desc_country}}</div>
			</div>
		</div>
		<div class="content-sec">
			<div class="container">
				@desktop
				<div class="row">
		            @if($destination)
		           		@if(isset($destination[0]))
			            	<div class="col-md-4 wrap-item">
	            				<div class="item">
	            					{!!image($destination[0]->image, 300, 550, $destination[0]->title)!!}
		            				<h7 class="title-country white">{{$destination[0]->title}}</h7>
		            				<a class="link" href="{{ route('overviewCountry', ['slug_country'=>$destination[0]->slug]) }}"></a>
		            				<div class="desc_hover"> 
	                                    <div class="text-center">
	                                        <img class="bee" src="{{asset('public/images/bee/bee-white.png')}}"> 
	                                        <h7 class="title_hover yellow">{{$destination[0]->title}}</h7>
	                                    </div>
	                                </div>
	            				</div>
	            			</div>
            			@endif
            			@if(isset($destination[1]) && isset($destination[3]))
			            	<div class="col-md-4 wrap-item">
			            		@if($destination[1])
	            					<div class="item">
	            						{!!image($destination[1]->image, 300, 380, $destination[1]->title)!!}
	            						<h7 class="title-country white">{{$destination[1]->title}}</h7>
	            						<a class="link" href="{{ route('overviewCountry', ['slug_country'=>$destination[1]->slug]) }}"></a>
			            				<div class="desc_hover"> 
		                                    <div class="text-center">
		                                        <img class="bee" src="{{asset('public/images/bee/bee-white.png')}}"> 
		                                        <h7 class="title_hover yellow">{{$destination[1]->title}}</h7>
		                                    </div>
		                                </div>
		                            </div>
		                         @endif
	            				@if($destination[3])
	            					<div class="item">
	            						{!!image($destination[3]->image, 300, 300, $destination[3]->title)!!}
	            						<h7 class="title-country white">{{$destination[3]->title}}</h7>
	            						<a class="link" href="{{ route('overviewCountry', ['slug_country'=>$destination[3]->slug]) }}"></a>
			            				<div class="desc_hover"> 
		                                    <div class="text-center">
		                                        <img class="bee" src="{{asset('public/images/bee/bee-white.png')}}"> 
		                                        <h7 class="title_hover yellow">{{$destination[3]->title}}</h7>
		                                    </div>
		                                </div>
		                            </div>
	            				@endif
	            			</div>
            			@endif
            			@if(isset($destination[2]) && isset($destination[4]))
			            	<div class="col-md-4 wrap-item">
			            		@if($destination[2])
	            					<div class="item">
	            						{!!image($destination[2]->image, 300, 300, $destination[2]->title)!!}
	            						<h7 class="title-country white">{{$destination[2]->title}}</h7>
	            						<a class="link" href="{{ route('overviewCountry', ['slug_country'=>$destination[2]->slug]) }}"></a>
			            				<div class="desc_hover"> 
		                                    <div class="text-center">
		                                        <img class="bee" src="{{asset('public/images/bee/bee-white.png')}}"> 
		                                        <h7 class="title_hover yellow">{{$destination[2]->title}}</h7>
		                                    </div>
		                                </div>
		                            </div>
		                         @endif
	            				@if($destination[4])
	            					<div class="item">
	            						{!!image($destination[4]->image, 300, 300, $destination[4]->title)!!}
	            						<h7 class="title-country white">{{$destination[4]->title}}</h7>
	            						<a class="link" href="{{ route('overviewCountry', ['slug_country'=>$destination[4]->slug]) }}"></a>
			            				<div class="desc_hover"> 
		                                    <div class="text-center">
		                                        <img class="bee" src="{{asset('public/images/bee/bee-white.png')}}"> 
		                                        <h7 class="title_hover yellow">{{$destination[4]->title}}</h7>
		                                    </div>
		                                </div>
		                            </div>
	            				@endif
	            			</div>
            			@endif
		            @endif
				</div>
				@elsedesktop
				<div class="slide-dost">
					@foreach($destination as $key => $item)
					<div class="wrapper-item">
        				<div class="item" style="background-image: url('{!! getImgUrl($item->image) !!}');">
            				<h7 class="title-country white">{{$item->title}}</h7>
            				<a class="link" href="{{ route('overviewCountry', ['slug_country'=>$item->slug]) }}"></a>
            				<div class="desc_hover"> 
                                <div class="text-center">
                                    <img class="bee" src="{{asset('public/images/bee/bee-white.png')}}"> 
                                    <h7 class="title_hover yellow">{{$item->title}}</h7>
                                </div>
                            </div>
        				</div>
        			</div>
					@endforeach
				</div>
				@enddesktop
			</div>
		</div>
	</div>
	<div class="request mar_nvp"  style="background-image: url('{!! getImgUrl($objectMetas->background_request) !!}');">
		<div class="container">
			<div class="list-request">
				<div class="row item-request">
					<div class="col-md-5 item left-item">
						{!! image($objectMetas->img_request,300,220,'image') !!}
					</div>
					<div class="col-md-7 text-center item">
						<span class="aplan yellow">24-hour response <br> guaranteed</span>
						<a class="btn btn-request" href="{{ route('createMyTrip') }}">REQUEST A FREE QUOTE</a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="traveling_experience">
		<div class="container">
			<div class="header-sec text-center">
				<div class="title-sec">
					<span class="title pink">{{$objectMetas->title_traveling}}</span>
				</div>
				<div class="desc_p">{{$objectMetas->desc_traveling}}</div>
			</div>
			<div class="iframe_video">
				{!!$objectMetas->iframe_video!!}
			</div>
		</div>
	</div>
	<div class="journey light-graynvp">
		<div class="container">
			<div class="header-sec text-center">
				<div class="title-sec">
					<span class="title pink">{{$objectMetas->title_journey}}</span>
				</div>
				<div class="desc_p">{{$objectMetas->desc_journey}}</div>
			</div>
			<div class="sec-content">
				@desktop
				<div class="row grid">
					<div class="col-md-4 grid-item">
						@php
						$str = getDsMetas(271);
						$test = array_filter(explode(';',$str));	
						@endphp
						@foreach($test as $item)
							@php
								$item = json_decode($item, true);
								$tourstyle = get_category_tour_by_slug($item['tour_style_slug']);
								$width = $item['width'];
								$height = $item['height'];
							@endphp
							@if($tourstyle)
							<div class="item_manso">
								{!! image($tourstyle->image,$width,$height,$tourstyle->title ) !!}
                                <h7 class="title-country white">
                                    {{$tourstyle->title}}
                                </h7>
                                <div class="desc_hover">
                                    <div class="text-center">
                                        <h7 class="title_hover yellow">
                                            {{$tourstyle->title}}
                                        </h7>
                                        <ul class="country_cat">
                                            @foreach($Countries as $country)
                                                <li>
                                                    <a href="{{ route('tour', ['slug_country'=>$country->slug,'slug'=>$tourstyle->slug ]) }}" class="thumb">
                                                        <img src="{{getImgUrl($country->icon_flag_gray)}}" alt="$item->title" class="icon icon-gray">
                                                        <img src="{{getImgUrl($country->icon_flag)}}" alt="$item->title" class="icon icon-active">
                                                    </a>
                                                    <p class="title_cou">{{($country->title)}}</p>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            @endif
						@endforeach
					</div>
					<div class="col-md-4 grid-item">
						@php
						$str = getDsMetas(272);
						$test = explode(';',$str);		
						@endphp
						@foreach($test as $item)
							@php
								$item = json_decode($item, true);
								$tourstyle = get_category_tour_by_slug($item['tour_style_slug']);
								$width = $item['width'];
								$height = $item['height'];
							@endphp
							@if($tourstyle)
							<div class="item_manso">
								{!! image($tourstyle->image,$width,$height,$tourstyle->title ) !!}
                                <h7 class="title-country white">
                                    <a href="#">{{$tourstyle->title}}</a>
                                </h7>
                                <div class="desc_hover">
                                    <div class="text-center">
                                        <h7 class="title_hover yellow">
                                            {{$tourstyle->title}}                                       
                                        </h7>
                                        <ul class="country_cat">
                                            @foreach($Countries as $country)
                                                <li>
                                                    <a href="{{ route('tour', ['slug_country'=>$country->slug,'slug'=>$tourstyle->slug ]) }}" class="thumb">
                                                        <img src="{{getImgUrl($country->icon_flag_gray)}}" alt="$item->title" class="icon icon-gray">
                                                        <img src="{{getImgUrl($country->icon_flag)}}" alt="$item->title" class="icon icon-active">
                                                    </a>
                                                    <p class="title_cou">{{($country->title)}}</p>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            @endif
						@endforeach
					</div>
					<div class="col-md-4 grid-item">
						@php
						$str = getDsMetas(273);
						$test = explode(';',$str);			
						@endphp
						@foreach($test as $item)
							@php
								$item = json_decode($item, true);
								$tourstyle = get_category_tour_by_slug($item['tour_style_slug']);
								$width = $item['width'];
								$height = $item['height'];
							@endphp
							@if($tourstyle)
								<div class="item_manso">
									{!! image($tourstyle->image,$width,$height,$tourstyle->title ) !!}
	                                <h7 class="title-country white">
	                                    {{$tourstyle->title}}
	                                </h7>
	                                <div class="desc_hover">
	                                    <div class="text-center">
	                                        <h7 class="title_hover yellow">
	                                            {{$tourstyle->title}}
	                                        </h7>
	                                        <ul class="country_cat">
	                                            @foreach($Countries as $country)
	                                                <li>
	                                                    <a href="{{ route('tour', ['slug_country'=>$country->slug,'slug'=>$tourstyle->slug ]) }}" class="thumb">
	                                                        <img src="{{getImgUrl($country->icon_flag_gray)}}" alt="$item->title" class="icon icon-gray">
	                                                        <img src="{{getImgUrl($country->icon_flag)}}" alt="$item->title" class="icon icon-active">
	                                                    </a>
	                                                    <p class="title_cou">{{($country->title)}}</p>
	                                                </li>
	                                            @endforeach
	                                        </ul>
	                                    </div>
	                                </div>
	                            </div>
	                        @endif    
						@endforeach
					</div>
				</div>
				@elsedesktop
				@php
				 	$list_tour_style = getListTourStyle();
				 	$destination = getListMainCountry();
				@endphp
				@if($list_tour_style)
					<div class="slide-dost list-style">
						@foreach($list_tour_style as $item)
				            <div class="wrapper-item">
				                <div class="item" style="background-image: url('{!! getImgUrl($item->image); !!}')">
				                    <img class="plus" src="{{asset('public/images/icons/Cross-White.png')}}" alt="Plus-white">
				                    <h7 class="title-country white">
				                        {{$item->title}}
				                    </h7>
				                    <div class="desc_hover">
				                        <div class="text-center">
				                        	<img class="cross" src="{{asset('public/images/icons/Cross_Yellow.png')}}" alt="Cross-white">
				                            <h7 class="title_hover yellow">{{$item->title}}</h7>
				                            <ul class="country_cat">
				                                @foreach($destination as $country)
				                                    <li>
				                                        <a href="{{ route('postTypeCountryTravel', ['slug_country'=>$country->slug , 'slug'=>$item->slug]) }}">{{($country->title)}}</a>
				                                    </li>
				                                @endforeach
				                            </ul>
				                        </div>
				                    </div>
				                </div>
				            </div>
						@endforeach
					</div>
				@endif
				@enddesktop
			</div>
		</div>
	</div>
	<div class="hand_craft slide_owl">
		<div class="container">
			<div class="header-sec text-center">
				<div class="title-sec">
					<span class="title pink">{{$objectMetas->title_hand_craft}}</span>
				</div>
				<div class="desc_p">{!! $objectMetas->desc_hand_craft !!}</div>
			</div>		
			@if($tour_hand_craft)
			@desktop 
				<div class="tour_craft slide-style">
					@foreach($tour_hand_craft as $item)
						@php
							$country_item = get_country_of_tour($item->id)[0];
							$tourstyle_item = get_category_tour($item->cat_id);
							$countCountry = countDestinationsOfTour($item->id);
						@endphp
						<div class="item">
							<div class="image">
								{!! image($item->image, 400, 270, $item->title) !!}
								<h7 class="title-tour white">{{$item->title}}</h7>
								<div class="hover_tour">
									@if($countCountry==1)
										<a class="link" href="{{ route('tour', ['slug_country'=>$country_item->slug , 'slug'=>$item->slug]) }}"></a>
										<p class="name white"> {{ $country_item->title }}</p>
									@else
										<a class="link" href="{{ route('tourMultiDes', ['slug'=>$item->slug]) }}"></a>
										<p class="name white"> - Asia - </p>
									@endif
									
									<h7  class="title-tour yellow" >{{$item->title}}</h7>
									<div class="cat">
										@if($tourstyle_item) 
										<span class="cate">{{ $tourstyle_item->title }}</span> 
										@endif
										<span class="day"> / {{ getDurationOfTour($item->id, false) }}</span>
										<span class="price">/ fr. ${{ number_format($item->price,0,",",",") }}</span> 
									</div>
								</div>
							</div>
							<div class="desc light-graynvp">
								<span class="black">{!! str_limit($item->content, 200) !!}</span>
								<a href="#">More</a>
							</div>
						</div>
					@endforeach
				</div>
			@elsedesktop 
				<div class="tour_craft slide-tour-dost">
					@foreach($tour_hand_craft as $item)
						@php
							$country_item = get_country_of_tour($item->id)[0];
							$tourstyle_item = get_category_tour($item->cat_id);
							$countCountry = countDestinationsOfTour($item->id);
						@endphp
						<div class="item">
							<div class="image">
								{!! image($item->image, 400, 270, $item->title) !!}
								@if($countCountry==1)
									<a class="link" href="{{ route('tour', ['slug_country'=>$country_item->slug , 'slug'=>$item->slug]) }}"></a>
									<p class="name white"> - {{ $country_item->title }} -</p>
								@else
									<a class="link" href="{{ route('tourMultiDes', ['slug'=>$item->slug]) }}"></a>
									<p class="name white"> - Asia - </p>
								@endif
								<h7 class="title-tour white">{{$item->title}}</h7>
								<div class="cat">
									@if($tourstyle_item) 
									<span class="cate">{{ $tourstyle_item->title }}</span> 
									@endif
									<span class="day"> / {{ getDurationOfTour($item->id, false) }}</span>
									<span class="price">/ fr. ${{ number_format($item->price,0,",",",") }}</span> 
								</div>
							</div>
							<div class="desc light-graynvp">
								<span class="black">{!! str_limit($item->content, 200) !!}</span>
								<a href="#">More</a>
							</div>
						</div>
					@endforeach
				</div>
			@enddesktop
			@endif
			<div class="bot-tour">
                <a href="{{ route('asiaTour') }}" class="btn btn-tour">All tour packages</a>
            </div>
		</div>
	</div>
	<div class="request back-none" style="background-image: url('{!! getImgUrl($objectMetas->background_request2) !!}');">
		@php
			$img_request = getDsMetas(260);
			$title_request = getDsMetas(301);
		@endphp
		@include('parts.request')
	</div>
	<div class="explore_asia light-graynvp">
		<div class="container">
			<div class="header-sec text-center">
				<div class="title-sec">
					<span class="title pink">{{$objectMetas->title_explore}}</span>
				</div>
				<div class="desc_p">{{$objectMetas->desc_explore}}</div>
			</div>
			<div class="sec-content">
				<div class="@desktop row @elsedesktop slide-dost @enddesktop">
					<div class="col-md-4 padding_auto">
						<div class="item_about_us" style="background-image: url('{!! getImgUrl(getDsMetas(276)) !!}');">
							<a class="link_about" href="{{ route('aboutPage') }}"></a>
							<h7 class="title white">{!! getDsMetas(277) !!}</h7>
						</div>
					</div>
					<div class="col-md-4 padding_auto">
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
									<h7 class="title_review"><a href="{{ route('detailClientReview',['slug'=>$list_reviewer[0]->slug]) }}">{{ $list_reviewer[0]->title }}</a></h7>
									<div class="desc">
									    {!! str_limit($list_reviewer[0]->content, 170) !!}
									    <a href="{{ route('detailClientReview',['slug'=>$list_reviewer[0]->slug]) }}">More</a>
									</div>
									<div class="rv_author">
										<a href="{{ route('detailClientReview',['slug'=>$list_reviewer[0]->slug]) }}" class="thumb">
											{!! image($list_reviewer[0]->image, 80, 80, $list_reviewer[0]->name) !!}
										<span class="name">{{ $list_reviewer[0]->name }}</span>
										</a>
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
					<div class="col-md-4 padding_auto">
						<div class="experience graybg">
							<div class="height_auto">
								<img src="{{asset('public/images/temp/step 2.png')}}" alt="image" class="thumb_img">
			            		<h7 class="yellow">{{ __('You are welcome to share your experience...')}}</h7>
			            		{!! social3() !!}
							</div>
						</div> 
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="responsible_travel slide_owl">
		<div class="container">
			<div class="header-sec text-center">
				<div class="title-sec">
					<span class="title pink">{{$objectMetas->title_responsible}}</span>
				</div>
				<div class="desc_p">{!! $objectMetas->desc_responsible !!}</div>
			</div>
			@if($list_sustai)
				@php 
					$list_respon = json_decode($list_sustai->meta_value);
				@endphp
				<div class="responsible">
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
				</div>
			@endif		
		</div>
	</div>
	<div class="preparing light-graynvp slide_owl">
		<div class="container">
			<div class="header-sec text-center">
				<div class="title-sec">
					<h2 class="title pink">{{ $title }}</h2>
				</div>
				<div class="desc_p">{!! $desc !!}</div>
			</div>
			@include('parts.list_nation')
		</div>
	</div>
	<!--Blog Section-->
	<div class="section-blog slide_owl">
		<div class="container">
			<div class="header-sec text-center">
				<div class="title-sec">
					<span class="title pink">{{$objectMetas->title_blog}}</span>
				</div>
				<div class="desc_p">{!! $objectMetas->desc_blog !!}</div>
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
	<!--End Blog Section-->
</div>
@stop