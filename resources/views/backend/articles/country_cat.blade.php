@php
	$country_id = isset($_GET['country_id']) ? $_GET['country_id'] : NULL;
	$cat_id = isset($_GET['cat_id']) ? $_GET['cat_id'] : NULL;

	if(isset($seo)){
		$meta_key = $seo->key;
		$meta_value = $seo->value;
	}else{
		$meta_key = $meta_value = '';
	}

	if(isset($countryCat)){
		$title_tag = $countryCat->title_tag;
		$desc = $countryCat->desc;
		$image = $countryCat->image;
		$image_looking = $countryCat->image_looking;
		$image_request = $countryCat->image_request;
	}else{
		$title_tag = $desc = $image = $image_looking = $image_request = '';
	}
@endphp

@extends('backend.layout.index')
@section('title','Country categories blog')
@section('content')
<div id="create-news" class="page news-page route">
	<div class="head">
		<h1 class="title">Country categories blog</h1>		
	</div>	
	<div class="main">
		@if((isset($_GET['country_id']) && $_GET['country_id'] == '') || (isset($_GET['cat_id']) && $_GET['cat_id'] == '' || count($errors) > 0))
			<div class="alert alert-danger">
				<ul>
					@if($_GET['country_id'] == '')
						<li>Please chose a country</li>
					@endif
					@if($_GET['cat_id'] == '')
						<li>Please chose a category</li>
					@endif

					@if(!empty($errors))
						@foreach($errors as $error)
							<li>{{ $error }}</li>
						@endforeach
					@endif
				</ul>
			</div>
		@endif
		<form action="{{ route('countryCatBlogAdmin') }}" class="frm-menu dev-form" method="GET" name="create_tour" role="form">
			<div class="row">
				<div class="col-md-3">
					<div class="form-group">
						<select name="country_id" class="form-control">
							<option value="">Select coutry</option>
							@if(!empty($list_country))
								@foreach ($list_country as $item)
									<option value="{{ $item->id }}" @if(!empty($country) && $item->id == $country->id) selected @endif>
										{{ $item->title }}
									</option>
								@endforeach
							@endif
						</select>
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<select name="cat_id" class="form-control">
							<option value="">Select category</option>
							@if(!empty($list_cat))
								@foreach ($list_cat as $item)
									<option value="{{ $item->id }}" @if(!empty($cat) && $item->id == $cat->id) selected @endif>
										{{ $item->title }}
									</option>
								@endforeach
							@endif
						</select>
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<button type="submit" class="btn btn-primary">Edit</button>
					</div>
				</div>
			</div>		
		</form>		

		@if(!empty($country) && !empty($cat))
		<form action="{{ route('saveCountryCatBlogAdmin') }}" class="frm-menu dev-form save-country-cat-blog" method="POST" name="save_country_cat_blog" role="form">
			{{ csrf_field() }}
			<input type="hidden" name="country_id" value="{{ $country_id }}" />
			<input type="hidden" name="cat_id" value="{{ $cat_id }}" />
			<div class="row">
				<div class="col-md-10 content">
					<div id="frm-title-tag" class="form-group">
						<label for="title_tag">Title tag (SEO title) 65-70 characters</label>
						<span class="count-characters">({{ strlen($title_tag) }} characters)</span>
						<input type="text" name="title_tag" class="form-control" placeholder="Title tag (SEO title) 65-70 characters" value="{{ $title_tag }}">
					</div>
					<div id="frm-metaKey" class="form-group">
						<label for="metakey">Keyword (SEO)</label>
						<input type="text" name="meta_key" class="form-control" placeholder="Input keyword (SEO)" class="frm-input" value="{{ $meta_key }}">
					</div>
					<div id="frm-metaValue" class="form-group">
						<label class="metaValue">Meta Description (SEO) 150-160 characters</label>
						<span class="count-characters">({{ strlen($meta_value) }} characters)</span>
						<textarea name="meta_value" placeholder="Input meta description (SEO) 150-160 characters" class="form-control">{{ $meta_value }}</textarea>
					</div>	
					<div id="frm-shortContent" class="form-group">
						<label class="short-content">Description</label>
						<textarea name="desc" placeholder="Input description" class="form-control">{{ $desc }}</textarea>
					</div>
				</div>
				<div class="col-md-2 sidebar">
					<div class="gr-not-fixed">
						<section id="sb-image" class="box-wrap">
							<h2 class="title">Image</h2>
							<div id="frm-image" class="desc img-upload">							
								<div class="image">
									<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
									{!!image( $image, 150,150, 'Image')!!}
									<input type="hidden" name="image" class="thumb-media" value="{{ $image }}" />
								</div>
							</div>
						</section>
						<section id="sb-image-looking" class="box-wrap">
							<h2 class="title">Image Looking</h2>
							<div id="frm-image-looking" class="desc img-upload">							
								<div class="image">
									<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
									{!!image($image_looking, 150,150, 'Image')!!}
									<input type="hidden" name="image_looking" class="thumb-media" value="{{ $image_looking }}" />
								</div>
							</div>
						</section>
						<section id="sb-image-request" class="box-wrap">
							<h2 class="title">Image Request</h2>
							<div id="frm-image-request" class="desc img-upload">							
								<div class="image">
									<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
									{!!image($image_request, 150,150, 'Image')!!}
									<input type="hidden" name="image_request" class="thumb-media" value="{{ $image_request }}" />
								</div>
							</div>
						</section>
					</div>
					<div class="group-fixed">
						<section id="sb-action">
							<div class="group-action">
								<button type="submit" name="submit" class="btn">Save</button>
								<a href="{{route('countryCatBlogAdmin')}}" class="btn btn-cancel">Cancel</a>
							</div>
						</section>
					</div>
				</div>
				
			</div>
		</form>	
		@endif
	</div>
</div>
@include('backend.media.library')
@if(session('success'))
<script type="text/javascript">
	$(function(){
		new PNotify({
		    title: 'Successfully',
		    text: 'Save successfull !',
		    type: 'success',
		    hide: true,
		    delay: 2000,
		});
	})
</script>
@endif
@stop