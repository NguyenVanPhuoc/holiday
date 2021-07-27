@extends('backend.layout.index')
@section('title','Edit Things to do')
@section('content')

@php
	$countries = getCountryLevel1();
	$seo = get_seo($guide->id,'guide');
	if($seo){ 
		$meta_key = $seo->key; 
		$meta_value = $seo->value;
	}else{
		$meta_key = "";
		$meta_value = "";
	}

	$tableContent = getTableContent($guide->id, 'guide');
	$arrayEditor = array();
@endphp

<div id="edit-thing-to-do" class="page route">
	<div class="head">
		<a href="{{route('thingsToDoAdmin')}}" class="back-icon"><i class="fa fa-angle-left" aria-hidden="true"></i> All Things to do</a>
		<h1 class="title">Edit Things to do</h1>		
	</div>
	<div class="main">
		<form action="{{ route('updateThingToDoAdmin', $guide->id) }}" method="post" class="dev-form activity-form">
			{!!csrf_field()!!}
			<div class="row">
				<div class="col-md-10 content">
					<div class="form-group" id="frm-long-title">
						<label for="title">Title<small>(*)</small></label>
						<input type="text" name="title" class="form-control" placeholder="Input long title" value="{{$guide->title}}" />
					</div>
					<div class="form-group">
						<label for="title">Permalink</label>
						<a href="{{route('postTypeCountryTravel', ['slug_country'=>$country->slug,'slug'=>$cat->slug])}}" class="permalink" target="_blank">
							{{route('postTypeCountryTravel', ['slug_country'=>$country->slug,'slug'=>$cat->slug])}}
						</a>
					</div>
					<!-- <div id="frm-slug" class="form-group">
						<label for="slug">Slug<small class="required">(*)</small></label>
						<div class="wrap">
							<span>{{$guide->slug}}</span>
							<input type="text" name="slug" value="{{$guide->slug}}" class="form-control hide" />
							<a href="#" class="edit-slug">Edit</a>
							<a href="#" class="btn save-slug hide">OK</a>
							<a href="#" class="cancel hide">Cancel</a>
						</div>
					</div> -->
					<div id="frm-title-tag" class="form-group">
						<label for="title_tag">Title tag (SEO title) 65-70 characters</label>
						<span class="count-characters">( {{strlen($guide->title_tag)}} characters )</span>
						<input type="text" name="title_tag" class="form-control" placeholder="Title tag (SEO title) 65-70 characters" class="frm-input" value="{{$guide->title_tag}}">
					</div>
					<div id="frm-metaKey" class="form-group">
						<label for="metakey">Keyword (SEO)</label>
						<input type="text" name="meta_key" class="form-control" placeholder="Input keyword (SEO)" class="frm-input" value="{{$meta_key}}">
					</div>
					<div id="frm-metaValue" class="form-group">
						<label class="metaValue">Meta Description (SEO) 150-160 characters</label>
						<span class="count-characters">( {{strlen($meta_value)}} characters )</span>
						<textarea name="meta_value" placeholder="Input meta description (SEO) 150-160 characters" class="form-control">{{$meta_value}}</textarea>
					</div>
					<div id="frm-desc" class="form-group">
						<label for="content">Description</label>
						<textarea name="desc" id="editor">{{$guide->desc}}</textarea>
					</div>
				</div>
				<div class="col-md-2 sidebar">
					<div class="gr-not-fixed">
						<section id="sb-country" class="box-wrap">
							<h2 class="title">Country</h2>
							<select name="country_id">
								<option value="">Chose country</option>
								@foreach($countries as $country)
									<option value="{{ $country->id }}" @if($country->id == $guide->country_id) selected @endif>{{ $country->title }}</option>
								@endforeach
							</select>	
						</section>
						<section id="sb-category" class="box-wrap">
							<h2 class="title">Category</h2>
							<select name="cat_id" class="select2">
								<option value="">Chose category</option>
								@if($list_cat)
									@foreach($list_cat as $cat)
										<option value="{{ $cat->id }}" @if($cat->id == $guide->cat_id) selected @endif>{{ $cat->title }}</option>
									@endforeach
								@endif
							</select>
						</section>
						<section id="sb-image" class="box-wrap">
							<h2 class="title">Image</h2>
							<div id="frm-image" class="desc img-upload">							
								<div class="image">
									<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
									{!!image($guide->image, 150,150, $guide->title)!!}
									<input type="hidden" name="image" class="thumb-media" value="{{$guide->image}}" />
								</div>
							</div>
						</section>
						<section class="sb-time-info">
							<ul class="list-unstyled">
								<li><strong>Created at:</strong> {{ date('d M Y H:i', strtotime($guide->created_at)) }}</li>
								<li><strong>Updated at:</strong> {{ date('d M Y H:i', strtotime($guide->updated_at)) }}</li>
							</ul>
						</section>
					</div>
					<div class="group-fixed">
						<section id="sb-action">
							<div class="group-action">
								<a href="{{ route('deleteGuideAdmin', ['id'=>$guide->id]) }}" class="btn btn-delete delete-item">Delete</a>
								<button type="submit" name="submit" class="btn">Save</button>
								<a href="#" class="btn btn-cancel">Cancel</a>									
							</div>
						</section>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
@include('backend.media.library')
<script type="text/javascript">
	ckeditor("editor");
</script>
@stop