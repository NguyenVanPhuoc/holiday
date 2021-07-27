@php
	$bg_img = asset('public/images/search-results.jpg');
@endphp

@extends('templates.masterBlog')
@section('title', 'Search blog')
@section('description', 'Search blog')
@section('keywords', 'Search blog')
@section('image_url', $bg_img)
@section('content')
<div id="search-blog" class="page blog imgbg imgbg-bottom-left">
	<div class="container">
		{!! Breadcrumbs::render('searchBlog') !!}
		<div class="main-top text-center">
			<div class="banner flex flex-col item-center content-center" style="background-image: url({{ $bg_img }})">
				<h3 class="title title-search">{{$countResult}} result with the keyword "{{$s}}"</h3>
			</div>				
		</div>
		<div class="main-bottom">
			<div class="row">
				<div id="content" class="col-md-9">
					<div class="description">
						@if($list_blog)
							<div class="list-blog">
								<div class="row wrap">
									@php $count = 0; @endphp
									@foreach($list_blog as $item)
										@php
											$count ++;
											$author = getUser($item->user_id); 
											$slugCountry = getSlugCountryOfBlog($item->id);
										@endphp
											<div class="col-md-6 inner-wrap">
												@include('articles.item')
											</div>
									@endforeach
								</div>
							</div>
						@endif
					</div>
					@if(isset($s))                
						{{$list_blog->appends(['s'=>$s])->render('custom_view')}}
					@else
						{{$list_blog->render('custom_view')}}
					@endif
				</div>
				<div id="sidebar" class="col-md-3">@include('sidebars.blog')</div>
			</div>
		</div>
	</div>
</div>
@stop