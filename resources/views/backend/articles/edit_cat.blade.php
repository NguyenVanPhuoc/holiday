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
@section('title','Edit category')
@section('content')
<div id="edit-category" class="container page route">
	<div class="head">
		<a href="{{route('categoriesAdmin')}}" class="back-icon"><i class="fa fa-angle-left" aria-hidden="true"></i> Catergories Blog</a>
		<h1 class="title">Edit Category</h1>		
	</div>
	<div class="main">
		<form action="{{route('updateCategoryAdmin', $category->id)}}" class="frm-menu dev-form activity-form" method="POST" name="create_category" role="form">
			{!!csrf_field()!!}
			<div class="row">
				<div class="col-md-9 content">
					<div id="frm-title" class="form-group">
						<label for="title">Title<small class="required">(*)</small></label>
						<input type="text" name="title" class="form-control" placeholder="Input title" class="frm-input" value="{{$category->title}}">
					</div>
					<div id="frm-title-tag" class="form-group">
							<label for="title_tag">Title tag (SEO title) 65-70 characters</label>
						<span class="count-characters">({{ strlen($category->title_tag) }} characters)</span>
						<input type="text" name="title_tag" class="form-control" placeholder="Title tag (SEO title) 65-70 characters" class="frm-input" value="{{ $category->title_tag }}">
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
						<label for="content">Description</label>
						<textarea name="content" id="editor">{!!$category->content!!}</textarea>
					</div>	
				</div>
				<div class="col-md-3 sidebar">
					<div class="gr-not-fixed">
						<section id="sb-image" class="box-wrap">
							<h2 class="title">Image</h2>
							<div id="frm-image" class="desc img-upload">						
								<div class="image">
									<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
									{!!image($category->image, 243,138, $category->title)!!}
									<input type="hidden" name="image" class="thumb-media" value="{{$category->image}}">
								</div>
							</div>
						</section>
						<section id="sb-image-looking" class="box-wrap">
							<h2 class="title">Image Looking</h2>
							<div id="frm-image-looking" class="desc img-upload">							
								<div class="image">
									<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
									{!!image($category->image_looking, 150,150, 'Image')!!}
									<input type="hidden" name="image_looking" class="thumb-media" value="{{ $category->image_looking }}" />
								</div>
							</div>
						</section>
						<section id="sb-image-request" class="box-wrap">
							<h2 class="title">Image Request</h2>
							<div id="frm-image-request" class="desc img-upload">							
								<div class="image">
									<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
									{!!image($category->image_request, 150,150, 'Image')!!}
									<input type="hidden" name="image_request" class="thumb-media" value="{{ $category->image_request }}" />
								</div>
							</div>
						</section>
						<section class="sb-time-info">
							<ul class="list-unstyled">
								<li><strong>Created at:</strong> {{ date('d M Y H:i', strtotime($category->created_at)) }}</li>
								<li><strong>Updated at:</strong> {{ date('d M Y H:i', strtotime($category->updated_at)) }}</li>
							</ul>
						</section>
					</div>
					<div class="group-fixed">
						<div class="group-action">
							<a href="{{route('deleteCategoryAdmin', $category->id)}}" class="btn btn-delete">Delete</a>
							<button type="submit" name="submit" class="btn">Save</button>
							<a href="{{route('categoriesAdmin')}}" class="btn btn-cancel">Cancel</a>							
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
</script>
@stop