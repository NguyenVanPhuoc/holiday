@extends('backend.layout.index')
@section('title','Add Things to do')
@section('content')
@php
	$countries = getCountryLevel1();
@endphp
<div id="create-thing-to-do" class="page route">
	<div class="head">
		<a href="{{route('thingsToDoAdmin')}}" class="back-icon"><i class="fa fa-angle-left" aria-hidden="true"></i> All Things to do</a>
		<h1 class="title">Add Things to do</h1>		
	</div>
	<div class="main">
		<form action="{{ route('createThingToDoAdmin') }}" method="POST" class="dev-form activity-form">
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
				</div>
				<div class="col-md-2 sidebar">
					<div class="gr-not-fixed">
						<section id="sb-country" class="box-wrap">
							<h2 class="title">Country</h2>
							<select name="country_id">
								<option value="">Chose country</option>
								@foreach($countries as $country)
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
</script>
@stop