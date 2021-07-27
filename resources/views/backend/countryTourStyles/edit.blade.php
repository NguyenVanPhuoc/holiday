@php
	$meta_key = $meta_value = '';
	$seo = $seo = get_seo($country_tourStyle->id,'country_tour_style');
	if($seo){
		$meta_key = $seo->key;
		$meta_value = $seo->value;
	}
	$list_content = json_decode($country_tourStyle->list_content);
	$array_cityID = ($country_tourStyle->list_city != NULL) ? explode(",", $country_tourStyle->list_city) : []; 
	$arrayEditor = [];
	$slug_style= getSlugTourStyleById($country_tourStyle->cat_id);
	$slug_country= getSlugCountryById($country_tourStyle->country_id);
@endphp

@extends('backend.layout.index')
@section('title','Edit country tour style')
@section('content')

<div id="create-guide" class="page route">
	<div class="head">
		<a href="{{route('countryTourStylesAdmin')}}" class="back-icon"><i class="fa fa-angle-left" aria-hidden="true"></i> All country tour style</a>
		<a href="{{route('tour', ['slug_country'=>$slug_country->slug,'slug'=>$slug_style->slug])}}" target="_blank" class="view-fast"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> View style</a>
		<h1 class="title">Edit country tour style</h1>		
	</div>
	<div class="main">
		<form action="{{ route('updateCountryTourStyleAdmin', $country_tourStyle->id) }}" method="post" class="dev-form create-guide activity-form">
			{!!csrf_field()!!}
			<div class="row">
				<div class="col-md-10 content">
					<div class="form-group" id="frm-long-title">
						<label for="title">Title<small>(*)</small></label>
						<input type="text" name="title" class="form-control" placeholder="Input title" value="{{ $country_tourStyle->title }}" />
					</div>
					<!-- <div id="frm-slug" class="form-group">
						<label for="slug">Slug<small class="required">(*)</small></label>
						<div class="wrap">
							<span>{{$country_tourStyle->slug}}</span>
							<input type="text" name="slug" value="{{$country_tourStyle->slug}}" class="form-control hide" />
							<a href="#" class="edit-slug">Edit</a>
							<a href="#" class="btn save-slug hide">OK</a>
							<a href="#" class="cancel hide">Cancel</a>
						</div>
					</div> -->
					<div id="frm-title-tag" class="form-group">
						<label for="title_tag">Title tag (SEO title) 65-70 characters</label>
						<span class="count-characters">({{ strlen($country_tourStyle->title_tag) }} characters)</span>
						<input type="text" name="title_tag" class="form-control" placeholder="Title tag (SEO title) 65-70 characters" class="frm-input" value="{{ $country_tourStyle->title_tag }}">
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
					<div id="frm-desc" class="form-group">
						<label for="content">Description</label>
						<textarea name="desc" id="editor">{!! $country_tourStyle->desc !!}</textarea>
					</div>
					<div class="form-group">
						<label>Text 1</label>
						<textarea name="text_tour" class="form-control">{{ $country_tourStyle->text_tour }}</textarea>
					</div>
					<div class="form-group">
						<label>Text 2</label>
						<textarea name="text_city" class="form-control">{{ $country_tourStyle->text_city }}</textarea>
					</div>
					<div class="form-group">
						<label>List places to visit</label>
						<select multiple name="city_id[]" class="select2" data-order="{{ $country_tourStyle->list_city }}">
							@foreach($list_city as $city)
								<option value="{{ $city->id }}" @if(in_array($city->id, $array_cityID)) selected @endif>{{ $city->title }}</option>
							@endforeach
						</select>
					</div>
					<div class="form-group">
						<label>Text reviews</label>
						<textarea name="text_review" class="form-control">{{ $country_tourStyle->text_review }}</textarea>
					</div>
	
					<div id="frm-tb-content" class="form-group just-level-1">
						<input type="hidden" class="string-value" name="list_content" value="">
						<label>Table content</label><br>
						<table class="field block-style">
							<tbody class="sortable">
								@foreach($list_content as $key => $item)
									@php
										$arrayEditor[] = 'list-content-'. ($key+1);
										$num_row = $key+1;
										$row_title = $item->title;
										$row_idEditor = 'list-content-'. ($key+1);
										$row_content = $item->content;
									@endphp
									@include('backend.templates.item-single-tb-content')
								@endforeach
							</tbody>
						</table>
						<a href="javascript:void(0)" class="btn add-row m-t-10">Add row</a>
					</div>	
				</div>
				<div class="col-md-2 sidebar">
					<div class="gr-not-fixed">
						<section id="sb-country" class="box-wrap">
							<h2 class="title">Country</h2>
							<select name="country_id">
								<option value="">Chose country</option>
								@foreach($list_country as $country)
									<option value="{{ $country->id }}" @if($country->id == $country_tourStyle->country_id) selected @endif >{{ $country->title }}</option>
								@endforeach
							</select>	
						</section>
						<section id="sb-category" class="box-wrap">
							<h2 class="title">Category</h2>
							<select name="cat_id" class="select2">
								<option value="">Chose category</option>
								@if($list_cat)
									@foreach($list_cat as $cat)
										<option value="{{ $cat->id }}" @if($cat->id == $country_tourStyle->cat_id) selected @endif >{{ $cat->title }}</option>
									@endforeach
								@endif
							</select>
						</section>
						<!-- <section class="box-wrap">
							<h2 class="title">Image content</h2>
							<div id="frm-image-content" class="desc img-upload">							
								<div class="image">
									<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
									{!!image( $country_tourStyle->image_content, 150,150, 'Image')!!}
									<input type="hidden" name="image_content" class="thumb-media" value="{{ $country_tourStyle->image_content }}" />
								</div>
							</div>
						</section> -->
						<section id="sb-image" class="box-wrap">
							<h2 class="title">Image</h2>
							<div id="frm-image" class="desc img-upload">							
								<div class="image">
									<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
									{!!image( $country_tourStyle->image, 150,150, 'Image')!!}
									<input type="hidden" name="image" class="thumb-media" value="{{ $country_tourStyle->image }}" />
								</div>
							</div>
						</section>
						<section id="sb-image-looking" class="box-wrap">
							<h2 class="title">Image Looking</h2>
							<div id="frm-image-looking" class="desc img-upload">							
								<div class="image">
									<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
									{!!image($country_tourStyle->image_looking, 150,150, $country_tourStyle->title)!!}
									<input type="hidden" name="image_looking" class="thumb-media" value="{{$country_tourStyle->image_looking}}" />
								</div>
							</div>
						</section>
						<section id="sb-image-request" class="box-wrap">
							<h2 class="title">Image Request</h2>
							<div id="frm-image-request" class="desc img-upload">							
								<div class="image">
									<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
									{!!image($country_tourStyle->image_request, 150,150, $country_tourStyle->title)!!}
									<input type="hidden" name="image_request" class="thumb-media" value="{{$country_tourStyle->image_request}}" />
								</div>
							</div>
						</section>
						<section class="sb-time-info">
							<ul class="list-unstyled">
								<li><strong>Created at:</strong> {{ date('d M Y H:i', strtotime($country_tourStyle->created_at)) }}</li>
								<li><strong>Updated at:</strong> {{ date('d M Y H:i', strtotime($country_tourStyle->updated_at)) }}</li>
							</ul>
						</section>
					</div>
					<div class="group-fixed">
						<section id="sb-action">
							<div class="group-action">
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
	@php
		if($arrayEditor){
			foreach ($arrayEditor as $key => $value) {
				@endphp
					ckeditor('{{$value}}');
				@php
			}
		}
	@endphp	
</script>
@stop