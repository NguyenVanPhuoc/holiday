@extends('backend.layout.index')
@section('title','Add country tour style')
@section('content')

<div id="create-guide" class="page route">
	<div class="head">
		<a href="{{route('countryTourStylesAdmin')}}" class="back-icon"><i class="fa fa-angle-left" aria-hidden="true"></i> All country tour style</a>
		<h1 class="title">Add country tour style</h1>		
	</div>
	<div class="main">
		<form action="{{ route('createCountryTourStyleAdmin') }}" method="post" class="dev-form create-guide activity-form">
			{!!csrf_field()!!}
			<div class="row">
				<div class="col-md-10 content">
					<div class="form-group" id="frm-long-title">
						<label for="title">Title<small>(*)</small></label>
						<input type="text" name="title" class="form-control" placeholder="Input title" />
					</div>
					<div id="frm-title-tag" class="form-group">
							<label for="title_tag">Title tag (SEO title) 65-70 characters</label>
						<span class="count-characters"></span>
						<input type="text" name="title_tag" class="form-control" placeholder="Title tag (SEO title) 65-70 characters" class="frm-input">
					</div>
					<div id="frm-metaKey" class="form-group">
						<label for="metakey">Keyword (SEO)</label>
						<input type="text" name="meta_key" class="form-control" placeholder="Input keyword (SEO)" class="frm-input">
					</div>
					<div id="frm-metaValue" class="form-group">
						<label class="metaValue">Meta Description (SEO) 150-160 characters</label>
						<span class="count-characters"></span>
						<textarea name="meta_value" placeholder="Input meta description (SEO) 150-160 characters" class="form-control"></textarea>
					</div>
					<div id="frm-desc" class="form-group">
						<label for="content">Description</label>
						<textarea name="desc" id="editor"></textarea>
					</div>
					<div class="form-group">
						<label>Text 1</label>
						<textarea name="text_tour" class="form-control"></textarea>
					</div>
					<div class="form-group">
						<label>Text 2</label>
						<textarea name="text_city" class="form-control"></textarea>
					</div>
					<div class="form-group">
						<label>List places to visit</label>
						<select multiple name="city_id[]" class="select2">
							@foreach($list_city as $city)
								<option value="{{ $city->id }}">{{ $city->title }}</option>
							@endforeach
						</select>
					</div>
					<div class="form-group">
						<label>Text reviews</label>
						<textarea name="text_review" class="form-control"></textarea>
					</div>
	
					<div id="frm-tb-content" class="form-group just-level-1">
						<input type="hidden" class="string-value" name="list_content" value="">
						<label>Table content</label><br>
						<table class="field block-style">
							<tbody class="sortable"></tbody>
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
									<option value="{{ $country->id }}">{{ $country->title }}</option>
								@endforeach
							</select>	
						</section>
						<section id="sb-category" class="box-wrap">
							<h2 class="title">Category</h2>
							<select name="cat_id" class="select2">
								<option value="">Chose category</option>
								@if($list_cat)
									@foreach($list_cat as $cat)
										<option value="{{ $cat->id }}">{{ $cat->title }}</option>
									@endforeach
								@endif
							</select>
						</section>
						<!-- <section class="box-wrap">
							<h2 class="title">Image content</h2>
							<div id="frm-image-content" class="desc img-upload">							
								<div class="image">
									<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
									{!!image('', 150,150, 'Image')!!}
									<input type="hidden" name="image_content" class="thumb-media" value="" />
								</div>
							</div>
						</section> -->
						<section id="sb-image" class="box-wrap">
							<h2 class="title">Image</h2>
							<div id="frm-image" class="desc img-upload">							
								<div class="image">
									<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
									{!!image('', 150,150, 'Image')!!}
									<input type="hidden" name="image" class="thumb-media" value="" />
								</div>
							</div>
						</section>
						<section id="sb-image-looking" class="box-wrap">
							<h2 class="title">Image Looking</h2>
							<div id="frm-image-looking" class="desc img-upload">							
								<div class="image">
									<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
									{!!image('', 150,150, 'Image')!!}
									<input type="hidden" name="image_looking" class="thumb-media" value="" />
								</div>
							</div>
						</section>
						<section id="sb-image-request" class="box-wrap">
							<h2 class="title">Image Request</h2>
							<div id="frm-image-request" class="desc img-upload">							
								<div class="image">
									<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
									{!!image('', 150,150, 'Image')!!}
									<input type="hidden" name="image_request" class="thumb-media" value="" />
								</div>
							</div>
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
	$(function() {
       
   	});	
</script>
@stop