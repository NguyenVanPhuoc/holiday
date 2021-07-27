@php
	$meta_key = ($seo && $seo->key != '') ? $seo->key : '';
	$meta_value = ($seo && $seo->value != '') ? $seo->value : '';
@endphp
@extends('templates.master')
@section('content')
@section('title', $guide->title_tag)
@section('description', $meta_key)
@section('keywords', $meta_value)
@php	
	$country = getCountryById($guide->country_id);
	$tableContent = getTableContent($guide->id, 'guide');
	$bg_img = getImgUrl($guide->image);
	//$icon_top = getImgUrl($guide->white_icon);
	$breadcrumb = Breadcrumbs::render('detailCultural', $country, $guide->short_title);
	$title_top_h1 = $guide->title;
	$post_type_active = 'cultural';
@endphp
<div class="detail-travel-tip singe-post">
	@include('layouts.top_banner')
	@include('countries.groupTopButton')
	<div class="content-page">
		<div class="container">
			<div class="row">
				<div id="content" class="col-md-8">
					<div class="wr-content p-r-50">
						<!-- <div class="featured-img">{!! imageAuto($guide->image, $guide->title) !!}</div> -->
						<div class="desc-content">{!! $guide->desc !!}</div>
						<div class="table-heading">
							<div class="text-center header-heading">
								<h4 class="font-semibold">{{ __('Table of content') }}</h4>
								<span class="bar-heading">
									[
									<a href="#" class="collapse-bar pink">{{ __('Hide') }}</a>
									<a href="#" class="expand-bar hide pink">{{ __('Show') }}</a>
									]
								</span>
							</div>
							<div class="list-heading">
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
						<div class="list-tb-content">
							@if($tableContent)
								@php
									$tableLevel1s = getTableDetailLevel1($tableContent->id); 
								@endphp
								@if($tableLevel1s) <!--Level 1-->
									@foreach($tableLevel1s as $key => $level1)
										{!! getContentTbContent($level1->id) !!}
									@endforeach
								@endif
							@endif
						</div>

						<div class="back-to-start"></div>

						@if($list_consultants)
							@php
								(count($list_consultants) > 1) ? $class_consultant = 'slide-consultants ' : $class_consultant = '';
							@endphp
							<div class="consultants-country consultants counsultant-at-bot flex-list center-item light-graybg m-t-40">
								<div class="title font-semibold text-center">
									Meet our {{ $country->title }} travels consultants
								</div>
								<div class="consultant-content {{ $class_consultant }}">
									@foreach($list_consultants as $item)
										<div class="item flex-list center-item">
											<a href="javascript:void(0)" class="thumb avatar">
												{!! image($item->image, 150, 150, $item->title) !!}
											</a>
											<div class="desc">
												<p class="title yellow font-semibold">{{ $item->title }}</p>
												<p class="text m-0">{{ $item->short_desc }}</p>
											</div>
										</div>
									@endforeach
								</div>
								<a class="button flex-list center-item graybg" href="#">
									{!! imageAuto($country->icon, $country->title) !!}
									<span>View {{ $country->title }} tours</span>
								</a>
							</div>
						@endif
					</div>
				</div>
				<div id="sidebar" class="col-md-4">
					<div class="gr-not-fixed" >
						@if($related_guides)
							<div class="related-travel-tip more-travel-tips sidebar-sec">
								<div class="group-more">
								@foreach ($related_guides as $item)
									@php
										$addClass = '';
										if($item->id == $guide->category->id) $addClass = 'active';
									@endphp
									<div class="item font-semibold {{$addClass}}">
										<div class="icons">
											<img src="{{ getImgUrl($item->gray_icon) }}" alt="icon" class="icon" />
											<img src="{{ getImgUrl($item->green_icon) }}" alt="icon" class="icon hover" />
										</div>
										<h4 class="title green">
											@if($item->id == $guide->category->id)
												{{ $item->title }}
											@else
												<a href="{{ $item->getPermalink() }}">{{ $item->title }}</a>
											@endif
										</h4>
									</div>
								@endforeach
								</div>
							</div>
						@endif
					</div>
					<div class="group-fixed">
						<div class="table-list table-list-schedule ">
							<div class="table-content">
								<div class="table-header">
									<span class="icon">
										<img src="{{asset('/public/images/icons/icon-table-list.png')}}" alt="icon">
									</span>
									<h5 class="table-title">{{ __('Table of content') }}</h5>
									<span class="close">
										<i class="fa fa-times"></i>
									</span>
								</div>
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
							<a href="javascript:void(0)" class="table-bar"><img src="{{asset('/public/images/icons/icon-table-list.png')}}" alt="icon"></a>
						</div>
					</div>
				</div>
			</div>

			<div class="section related-tours">
				<h3 class="title-page pink text-center">
					<img src="{{asset('public/images/icons/tour/tour-pink.png')}}" alt="icon">
					<span>
						{{ __('To discover ').$country->title }}					
					</span>
				</h3>
				@if($related_tours)
					<div class="list-related list-tour-1">
						@foreach($related_tours as $tour)
							@php
								$slug_country = get_slug_country_of_tour($tour->id);
							@endphp
							<div class="item octagonal">
								<div class="wrap-octagonal">
									<a href="{{route('tour', ['slug_country'=>$slug_country,'slug'=>$tour->slug])}}" class="thumb">
										{!! image($tour->image, 410, 250, $tour->title) !!}
									</a>
									<h4>
										<a href="{{route('tour', ['slug_country'=>$slug_country,'slug'=>$tour->slug])}}">{{$tour->title}}</a>
									</h4>
								</div>
							</div>
						@endforeach
					</div>
				@endif
				<div class="text-center">
					<a href="#" class="btn-page pinkbg">
						<span>View more</span>
					</a>
				</div>
			</div>
		</div>
	</div>
</div>

@stop