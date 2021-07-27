@extends('backend.layout.index')
@section('title','Add Blogger')
@section('content')

@php
	$listBlogs = getAticlesOrderByTitle();
	$listHotels = getHotelsOrderByTitle();
@endphp

<div id="create-blogger" class="container page route padding-bottom-200">
	<div class="head">
		<a href="{{route('bloggersAdmin')}}" class="back-icon"><i class="fa fa-angle-left" aria-hidden="true"></i> All bloggers</a>
		<h1 class="title">Add Blogger</h1>		

	</div>
	<div class="main">
		<form action="{{ route('createBloggerAdmin') }}" method="post" class="dev-form activity-form">
			{!!csrf_field()!!}
			<div class="row">
				<div class="col-md-9 content">
					<div class="form-group" id="frm-title">
						<label for="title">Name<small>(*)</small></label>
						<input type="text" name="title" placeholder="Input name" class="form-control" />
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
						<label for="desc">Description</label>
						<textarea name="desc" id="editor"></textarea>
					</div>
					<!-- <div id="frm-short-desc" class="form-group">
						<label for="short_desc">Slogan</label>
						<textarea name="short_desc" id="short_desc" class="form-control"></textarea>
					</div> -->
					<div id="frm-social" class="form-group frm-add-row">
						<label for="metakey">Social</label>
						<input type="hidden" class="json-value json-add" name="social_icon">
						<table class="field block-style">
							<tbody class="sortable"></tbody>
						</table>
						<a href="#" class="btn btn-default add-row">Add row</a>
						<div class="group-row-add hidden">
							<div class="field-row">
								<div class="row-left">
									<label>Title</label>
								</div>
								<div class="row-right"><input type="text" class="form-control field-item" data-name="title" /></div>
							</div>
							<div class="field-row">
								<div class="row-left">
									<label>Image</label>
								</div>
								<div class="row-right">
									<div id="image-book-1" class="desc img-upload" data-id-name="image-book">
										<div class="image">
											<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
											{!!image('', 150,150, 'Image')!!}
											<input type="hidden" class="thumb-media field-item" data-name="image" value="" />
										</div>
									</div>
								</div>
							</div>
							<div class="field-row">
								<div class="row-left">
									<label>Link</label>
								</div>
								<div class="row-right"><input type="text" class="form-control field-item" data-name="link" /></div>
							</div>
						</div>
					</div>
					<div id="frm-favourite-blog" class="form-group">
						<label for="favourite-tour">Favourite Articles</label>
						<select multiple class="select2" name="article[]">
							@foreach($list_article as $item)
								<option value="{{ $item->id }}">{{ $item->title }}</option>
							@endforeach
						</select>
					</div>

					<div id="frm-favourite-country" class="form-group">
						<label for="favourite-country">Favourite places to visit</label>
						<select multiple class="select2" name="highlight[]">
							@foreach($list_highlight as $item)
								<option value="{{ $item->id }}">{{ $item->country->title }}</option>
							@endforeach
						</select>
					</div>

					<!-- <div id="frm-favourite-books" class="form-group table-sortable">
						<label for="favourite-tour">Favourite Books</label><br>
						<table class="field block-style">
							<tbody class="sortable ui-sortable"></tbody>
						</table>
						<a href="javascript:void(0)" class="btn add-row">Add row</a>
					</div> -->

					<div id="frm-book" class="form-group frm-add-row">
						<label for="metakey">Favourite Books</label>
						<input type="hidden" class="json-value json-add" name="favourite_books">
						<table class="field block-style">
							<tbody class="sortable"></tbody>
						</table>
						<a href="#" class="btn btn-default add-row">Add row</a>
						<div class="group-row-add hidden">
							<div class="field-row">
								<div class="row-left">
									<label>Image</label>
								</div>
								<div class="row-right">
									<div id="image-book-1" class="desc img-upload" data-id-name="image-book">
										<div class="image">
											<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
											{!!image('', 150,150, 'Image')!!}
											<input type="hidden" class="thumb-media field-item" data-name="image" value="" />
										</div>
									</div>
								</div>
							</div>
							<div class="field-row">
								<div class="row-left">
									<label>Title</label>
								</div>
								<div class="row-right"><input type="text" class="form-control field-item" data-name="title" /></div>
							</div>
							<div class="field-row">
								<div class="row-left">
									<label>Link</label>
								</div>
								<div class="row-right"><input type="text" class="form-control field-item" data-name="link" /></div>
							</div>
						</div>
					</div>

				</div>
				<div class="col-md-3 sidebar">
					<div class="gr-not-fixed">
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
						<section id="sb-banner" class="box-wrap">
							<h2 class="title">Banner</h2>
							<div id="frm-banner" class="desc img-upload">							
								<div class="image">
									<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
									{!!image('', 150,150, 'Image')!!}
									<input type="hidden" name="banner" class="thumb-media" value="" />
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
	/*$(function() {
       $("#create-blogger").on('click','form .group-action button',function(){
	       	var _token = $("form input[name='_token']").val();
	       	var title = $("#frm-title input").val();
	       	var image = $("#frm-image input").val();
	       	var desc = CKEDITOR.instances['editor'].getData();
	       	var short_desc = $('#frm-short-desc textarea').val();
	       	var text_blog = $('#frm-text-blog textarea').val();
	       	var text_book = $('#frm-text-book textarea').val();
	       	var text_country = $('#frm-text-country textarea').val();
	       	var favourite_blogs = new Array();
	       	var favourite_countries = new Array();
	       	var favourite_books = new Array();
	       	var errors = new Array();
	       	var error_count = 0;

	       	$('#frm-favourite-blog .box-selected .item-selected').each(function(){
	       		var ob = {};
	       		ob.id = $(this).attr('data-id');
	       		ob.position = $(this).attr('data-position');
	       		favourite_blogs.push(ob);
	       	});

	       	$('#frm-favourite-country .box-selected .item-selected').each(function(){
	       		var ob = {};
	       		ob.id = $(this).attr('data-id');
	       		ob.position = $(this).attr('data-position');
	       		favourite_countries.push(ob);
	       	});

	       	$('#frm-favourite-books tbody tr').each(function(){
	       		var ob = {};
	       		ob.title = $(this).find('.tb-title input').val();
	       		ob.link = $(this).find('.tb-link input').val();
	       		favourite_books.push(ob);
	       	});

	       	if(title==""){
	       		errors.push("Please input title");
	       	}
	       	var i;
	   		var html = "<ul>";
	       	for(i = 0; i < errors.length; i++){
	       		if(errors[i] != ""){
	       			html +='<li>'+errors[i]+'</li>';
	       			error_count += 1;
	       		}
	       	}   
	       	html += "</ul>";
	       	if(error_count>0){
		       	new PNotify({
					title: 'Error ('+error_count+')',
					text: html,						    
					hide: true,
					delay: 6000,
				});
	       	}else{
	       		$('#overlay').show();
	       		$('.loading').show();
				$.ajax({
					type:'POST',            
					url:'{{ route("createBloggerAdmin") }}',
					cache: false,
					data:{
						'_token': _token,
						'title': title,
						'image': image,
						'desc': desc,
						'short_desc': short_desc,
						'text_blog': text_blog,
						'text_book': text_book,
						'text_country': text_country,
						'favourite_blogs': JSON.stringify(favourite_blogs),
						'favourite_countries': JSON.stringify(favourite_countries),
						'favourite_books': JSON.stringify(favourite_books),
						'type' : 'blogger',
					},
				}).done(function(data) {
					if(data=="success"){				       					       	
						new PNotify({
							title: 'Successfully',
							text: 'Add to success.',
							type: 'success',
							hide: true,
							delay: 2000,
						});	
						location.reload();				
					}else{
						new PNotify({
							title: 'Error',
							text: 'The system is busy. Please try again. ',					    
							hide: true,
							delay: 2000,
						});
					}	           		
				});
			}       	
       	return false;
       });
   	});*/	
</script>
@stop