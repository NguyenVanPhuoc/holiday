@extends('backend.layout.index')
@section('title','Add Countries Blog')
@section('content')
<div id="create-country-blog" class="container page route">
	<div class="head">
		<a href="{{ route('countryBlogAdmin') }}" class="back-icon"><i class="fa fa-angle-left" aria-hidden="true"></i> Countries Blog</a>
		<h1 class="title">Add countries blog</h1>		
	</div>
	<div class="main">
		<form action="{{route('createCountryBlogAdmin')}}" class="frm-menu dev-form activity-form" method="POST" name="create_country_blog" role="form">
			{!!csrf_field()!!}
			<div class="row">
				<div class="col-md-9 content">
					<div id="frm-title" class="form-group">
						<label for="title">Title<small class="required">(*)</small></label>
						<input type="text" name="title" class="form-control" placeholder="Input title" class="frm-input">
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
					<div id="frm-content" class="form-group">
						<label for="desc">Description country</label>
						<textarea name="desc" id="editor"></textarea>
					</div>	
					<div id="frm-content-ready-yet" class="form-group">
						<label for="content_ready_yet">Content ready yet</label>
						<textarea name="content_ready_yet" id="editor1"></textarea>
					</div>	
					<div id="frm-content-tips" class="form-group">
						<label for="content_tips">Content tips & guide</label>
						<textarea name="content_tips" id="editor2"></textarea>
					</div>	
					
				</div>
				<div class="col-md-3 sidebar">
					<div class="gr-not-fixed">
						<section class="box-wrap">
							<h2 class="title">Choose country<small class="required">(*)</small></h2>
							<div class="form-group">
								<select name="country_id" class="form-control">
									<option value="">Select country</option>
									@if(!empty($list_country))
										@foreach ($list_country as $item)
											<option value="{{ $item->id }}" @if(!empty($country) && $item->id == $country->id) selected @endif>
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
									{!!image('', 150,150, 'Image')!!}
									<input type="hidden" name="banner_country" class="thumb-media" value="" />
								</div>
							</div>
						</section>
						<section id="sb-image" class="box-wrap">
							<h2 class="title">Banner looking tour</h2>
							<div id="frm-image" class="desc img-upload">							
								<div class="image">
									<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
									{!!image('', 150,150, 'Image')!!}
									<input type="hidden" name="banner" class="thumb-media" value="" />
								</div>
							</div>
						</section>
						<section id="sb-image-plants" class="box-wrap">
							<h2 class="title">Banner plants</h2>
							<div id="frm-image-plants" class="desc img-upload">							
								<div class="image">
									<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
									{!!image('', 150,150, 'Image')!!}
									<input type="hidden" name="banner_plants" class="thumb-media" value="" />
								</div>
							</div>
						</section>
						<section id="sb-image-plants" class="box-wrap">
							<h2 class="title">Image plants</h2>
							<div id="frm-img-plants" class="desc img-upload">							
								<div class="image">
									<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
									{!!image('', 150,150, 'Image')!!}
									<input type="hidden" name="img_plant" class="thumb-media" value="" />
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
	ckeditor("editor1");	
	ckeditor("editor2");	
</script>
@stop