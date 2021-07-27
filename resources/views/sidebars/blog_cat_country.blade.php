@php 
	$categories = get_categories();
	$cat_slug = empty($cat) ? '' : $cat->slug;
	$countries = getAllMainCountry();
    $country_slug = empty($country) ? '' : $country->slug;	
@endphp
@desktop
@if($categories)
<aside id="sb-categories">
	<h7 class="sb-title">EXPLORE {{ $country->title }}</h7>
	<div class="desc">
		<ul class="list-cat no-list-style">
			@foreach($categories as $item)
			<li <?php if($cat_slug == $item->slug) echo ' class="active"';?>><a href="{{ route('blogCountryCate',['country_slug'=>$country_slug,'cate_slug'=>$item->slug ]) }}"<?php if($item->slug == $cat_slug) echo ' class="active"';?>>{{$item->title}}</a></li>
			@endforeach
		</ul>
	</div>
</aside>
@endif
@if($articleMostView)
<aside id="sb-view">
	<h7 class="sb-title">TOP POSTS</h7>
	<div class="desc">
		<ul class="list no-list-style">
			@foreach($articleMostView as $item)
			<li class="flex content-between">
				<a class="thumb" href="{{ $item->getPermalink() }}">{!!image($item->image,60,60,$item->title)!!}</a>
				<h7 class='title'><a href="{{ $item->getPermalink() }}">{{str_limit($item->title, 80,'')}}</a></h7>
			</li>
			@endforeach
		</ul>
	</div>
</aside>
@endif
{{-- @if($articleMostView) --}}
<aside id="sb-social">
	<h7 class="sb-title">Socials</h7>
	<div class="desc">
		<ul class="list no-list-style">
			{!! socialBlog() !!}
		</ul>
	</div>
</aside>
{{-- @endif --}}
<aside id="sb-contact">
	<a href="#" class="thumb"><img src="{{asset('public/images/request-free-sub.jpg')}}" alt="bigg_icon"></a>
	<div class="desc-contact">
		<h7 class="title">24-hour response guaranteed</h7>
		<a href="{{ route('createMyTrip') }}" title="" class="btn btn-request">request a free quote</a>
	</div>
</aside>
@elsedesktop
@php
    $another_country=getAnotherCountry($country->id);
    $category=getAnotherAticleCat($cat->id)
@endphp
@if($category)
    <div class="mobi-discover light-graybg">
        <h7 class="title-menu pink text-center">EXPLORE {{ $country->title }}</h7>
        <div class="row">
            @foreach($category as $item)
                <div class="col-sm-6 item text-center">
                    <a class="thumb_img" href="{{route('blogCall',$item->slug)}}">
                    	{!!image($item->image,120,120,$item->title)!!}
                    	<h3 class="title">{!!$item->title!!}</h3>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@endif
@if($another_country)
    <div class="mobi-discover light-graybg blog_topics">
        <h7 class="title-menu pink text-center">DISCOVER</h7>
        <div class="row">
            @foreach($another_country as $item)
                <div class="col-sm-6 item text-center">
                    <a class="thumb_img" href="{{route('blogCall',$item->slug)}}">
                    	{!!image($item->image,120,120,$item->title)!!}
                    	<h3 class="title">{!!$item->title!!}</h3>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@endif
@enddesktop



