@php 
if($seo){
	$meta_key = $seo->key;
	$meta_value = $seo->value;
}else{
	$meta_key = "";
	$meta_value = "";
}
@endphp

@extends('backend.layout.index')
@section('title','Edit Country Places to visit')
@section('content')
<div id="edit-countries-blog" class="container page route">
	<div class="head">
		<a href="{{route('countryPlacesAdmin')}}" class="back-icon"><i class="fa fa-angle-left" aria-hidden="true"></i> Countries Places to visit</a>
		<h1 class="title">Edit Countries Places to visit</h1>		
	</div>
	<div class="main">
		<form action="{{route('updateCountryPlacesAdmin', $countries->id)}}" class="frm-menu dev-form activity-form" method="POST" name="create_country_places" role="form">
			{!!csrf_field()!!}
			<div class="row">
				<div class="col-md-9 content">
					<div id="frm-title" class="form-group">
						<label for="title">Title<small class="required">(*)</small></label>
						<input type="text" name="title" class="form-control" placeholder="Input title" class="frm-input" value="{{$countries->title}}">
					</div>
					<div id="frm-title-tag" class="form-group">
							<label for="title_tag">Title tag (SEO title) 65-70 characters</label>
						<span class="count-characters">({{ strlen($countries->title_tag) }} characters)</span>
						<input type="text" name="title_tag" class="form-control" placeholder="Title tag (SEO title) 65-70 characters" class="frm-input" value="{{ $countries->title_tag }}">
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
					<div id="frm-content" class="form-group">
						<label for="desc">Description country</label>
						<textarea name="desc" id="editor">{!!$countries->desc!!}</textarea>
					</div>	
					<div id="frm-content-ready-yet" class="form-group">
						<label for="content_ready_yet">Content ready yet</label>
						<textarea name="content_ready_yet" id="editor1">{!!$countries->content_ready_yet!!}</textarea>
					</div>	
					<div id="frm-content-tips" class="form-group">
						<label for="content_tips">Content tips & guide</label>
						<textarea name="content_tips" id="editor2">{!!$countries->content_tips!!}</textarea>
					</div>	
				</div>
				<div class="col-md-3 sidebar">
					<div class="gr-not-fixed">
						<section class="box-wrap">
							<h2 class="title">Choose country<small class="required">(*)</small></h2>
							<div class="form-group">
								<select name="country_id" class="form-control" disabled>
									<option value="">Select country</option>
									@if($list_country)
										@foreach ($list_country as $item)
											<option value="{{ $item->id }}" @if($item->id == $countries->country_id) selected @endif>
												{{ $item->title }}
											</option>
										@endforeach
									@endif
								</select>
							</div>
						</section>
						<section id="sb-image" class="box-wrap">
							<h2 class="title">Banner country</h2>
							<div id="frm-image-country" class="desc img-upload">							
								<div class="image">
									<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
									{!!image($countries->banner_country, 150,150, 'Image')!!}
									<input type="hidden" name="banner_country" class="thumb-media" value="{{$countries->banner_country}}" />
								</div>
							</div>
						</section>
						<section id="sb-image" class="box-wrap">
							<h2 class="title">Banner looking tour</h2>
							<div id="frm-image" class="desc img-upload">							
								<div class="image">
									<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
									{!!image($countries->banner, 243,138, $countries->title)!!}
									<input type="hidden" name="banner" class="thumb-media" value="{{$countries->banner}}" />
								</div>
							</div>
						</section>
						<section id="sb-image-plants" class="box-wrap">
							<h2 class="title">Banner plants</h2>
							<div id="frm-image-plants" class="desc img-upload">							
								<div class="image">
									<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
									{!!image($countries->banner_plants,243,138, $countries->title)!!}
									<input type="hidden" name="banner_plants" class="thumb-media" value="{{$countries->banner_plants}}" />
								</div>
							</div>
						</section>
						<section class="sb-time-info">
							<ul class="list-unstyled">
								<li><strong>Created at:</strong> {{ date('d M Y H:i', strtotime($countries->created_at)) }}</li>
								<li><strong>Updated at:</strong> {{ date('d M Y H:i', strtotime($countries->updated_at)) }}</li>
							</ul>
						</section>
					</div>
					<div class="group-fixed">
						<div class="group-action">
							<a href="{{route('deleteCountryPlacesAdmin', $countries->id)}}" class="btn btn-delete">Delete</a>
							<button type="submit" name="submit" class="btn">Save</button>
							<a href="{{route('countryPlacesAdmin')}}" class="btn btn-cancel">Cancel</a>							
						</div>
					</div>
				</div>
			</div>	
		</form>				
	</div>
</div>
@include('backend.media.library')
<script type="text/javascript">
	ckeditor("editor");
	ckeditor("editor1");
	ckeditor("editor2");
</script>
@stop