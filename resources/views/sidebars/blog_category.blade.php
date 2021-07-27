<?php $categories = get_categories();
	$views = get_blogByView(2);
	$cat_slug = empty($cat)? '' : $cat->slug;	
?>
@if($categories)
<aside id="sb-categories">
	<h3 class="sb-title white">Discover</h3>
	<div class="desc">
		<ul class="list-cat no-list-style text-center">
			@foreach($categories as $item)
			<li<?php if($cat_slug == $item->slug) echo ' class="active"';?>><a href="{{route('blogCat',['slug_cat'=>$item->slug])}}"<?php if($item->slug == $cat_slug) echo ' class="active"';?>>{{$item->title}}</a></li>
			@endforeach
		</ul>
	</div>
</aside>
@endif
@if($views)
<aside id="sb-view">
	<h3 class="sb-title white">Most popular</h3>
	<div class="desc">
		<ul class="list no-list-style">
			@foreach($views as $item)
			@php
				$slugCountry = getSlugCountryOfBlog($item->id);
			@endphp
			<li class="flex content-between">
				<a class="thumb" href="{{route('blogDetail',['slug_country'=>$slugCountry,'slug'=>$item->slug])}}">{!!image($item->image,60,60,$item->title)!!}</a>
				<h4><a href="{{route('blogDetail',['slug_country'=>$slugCountry,'slug'=>$item->slug])}}">{{str_limit($item->title, 35,'')}}</a></h4>
			</li>
			@endforeach
		</ul>
	</div>
</aside>
@endif
<aside id="sb-contact">
	<div class="language-title right">
		<h5>Get in touch & create your dream trip</h5>
	</div>
	<a href="#" class="thumb"><img src="{{asset('public/images/temp/base_fill_flip.png')}}" alt="bigg_icon"></a>
</aside>
<aside id="sb-fanpage">
	<div class="fanpage-inner">
		<iframe src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2Fbiigholiday%2F&tabs=timeline&width=275&height=180&small_header=false&adapt_container_width=true&hide_cover=false&show_facepile=true&appId=221875208535777" width="275" height="200" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true" allow="encrypted-media"></iframe>
	</div>
</aside>


