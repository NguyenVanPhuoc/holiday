@php
	/*
	* template item article
	* param : $item
	*/
	$country = getCountryOfArticle($item->id);
	$category = get_category($item->cat_id);
	$countCountry = getAllCountriesId($item->id);
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
				<h3 class="text">{{$item->title}}</h3>
				<div class="title_country">
					@if($category && $country)
					@if($countCountry == 1)
						<span class="name"> - {!! $country->title !!}</span>
					@else
						<span class="name"> - Asia </span>
					@endif	
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
				<div class="white"><div class="content_height">{!! ($item->content) !!}</div><a href="{{ route('blogCall',['slug'=>$item->slug]) }}" class="btn-page-2 more"><span>...</span><?php echo __('more'); ?></a></div>
				
			</div>
		</div>
	</div>
@elsedesktop
<div class="item octagonal">
	<div class="image">
		<div class="wrap-image">
		<a href="{{ route('blogCall',['slug'=>$item->slug]) }}" class="thumb link">
			{!! image($item->image, 310, 200, $item->title) !!}
		</a>
		</div>
		<a href="{{ route('blogCall',['slug'=>$item->slug]) }}" class="title font-semibold" >{{$item->title}}</a>
		<div class="title_country">
			@if($category && $country)
			@if($countCountry == 1)
				<span class="name"> - {!! $country->title !!}</span>
			@else
				<span class="name"> - Asia </span>
			@endif	
				<span class="cate"> / {{ $category->title }} - </span> 
			@elseif($country)
				<span class="name"> - {!! $country->title !!} -</span>
			@elseif($category) 
				<span class="cate"> - {{ $category->title }} - </span> 
			@endif
		</div>
	</div>
	<div class="desc">
		<div class="content-desc text-center">
			<div class="white"><div class="content_height">{!! ($item->content) !!}</div><a href="{{ route('blogCall',['slug'=>$item->slug]) }}" class="btn-page-2 more"><span>...</span><?php echo __('more'); ?></a></div>
		</div>
	</div>
</div>
@enddesktop