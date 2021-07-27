@php
	/*
	* template item article
	* param : $item
	*/
	$country = getCountryOfArticle($item->id);
	$category = get_category($item->cat_id);
@endphp
@desktop
	<div class="item octagonal">
		<div class="image">
			<div class="wrap-image"></div>
			<a href="{{ route('blogCall',['slug'=>$item->slug]) }}" class="thumb">
				{!! image($item->image, 310, 200, $item->title) !!}
			</a>
			<a href="{{ route('blogCall',['slug'=>$item->slug]) }}" class="title font-semibold" >{{$item->title}}</a>
			@desktop
			<a  href="{{ route('blogCall',['slug'=>$item->slug]) }}" class="covid_hover">
				<img src="{{asset('public/images/Logo Sonabee Blog.png')}}" alt="image">
				<div class="text">{{$item->title}}</div>
				<div class="title_country">
					@if($category && $country)
						<span class="name"> - {!! $country->title !!}</span>
						<span class="cate"> / {{ $category->title }} - </span> 
					@elseif($country)
						<span class="name"> - {!! $country->title !!} -</span>
					@elseif($category) 
						<span class="cate"> - {{ $category->title }} - </span> 
					@endif
				</div>
			</a>
			@enddesktop
		</div>
		<div class="desc">
			<div class="content-desc text-center">
				<p class="white">{!! str_limit($item->content, 185) !!}<a href="{{ route('blogCall',['slug'=>$item->slug]) }}" class="btn-page-2 more"><?php echo __('more'); ?></a></p>
				
			</div>
		</div>
	</div>
@elsedesktop
<div class="item">
	<div class="image">
		<div class="wrap-image"></div>
		<a href="{{ route('blogCall',['slug'=>$item->slug]) }}" class="thumb">
			{!! image($item->image, 400, 220, $item->title) !!}
		</a>
		<a href="{{ route('blogCall',['slug'=>$item->slug]) }}" class="title-mobi font-semibold" >{{$item->title}}</a>
		<div class="title_heder_mobi">
			@if($country)
				<span class="name"> - {!! $country->title !!} / </span>
			@endif
			@if($category) 
				<span class="cate"> / {{ $category->title }}</span> 
			@endif
		</div>
	</div>
	<div class="desc">
		<div class="content-desc-mobi text-center">
			<span class="black">{!! str_limit($item->desc, 200) !!}</span>
			<a href="{{ route('blogCall',['slug'=>$item->slug]) }}">More</a>
		</div>
	</div>
</div>
@enddesktop