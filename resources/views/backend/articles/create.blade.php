@extends('backend.layout.index')
@section('title','Add blog')
@section('content')
<div id="create-news" class="page news-page route">
	<div class="head">
		<a href="{{route('blogAdmin')}}" class="back-icon"><i class="fa fa-angle-left" aria-hidden="true"></i> All blog</a>
		<h1 class="title">Add blog</h1>		
	</div>	
	<div class="main">
		<form action="{{route('createBlogAdmin')}}" class="frm-menu dev-form" method="POST" name="create_tour" role="form">
			{!!csrf_field()!!}
			<div class="row">
				<div class="col-md-10 content">
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
						<input type="text" name="metakey" class="form-control" placeholder="Input keyword (SEO)" class="frm-input">
					</div>
					<div id="frm-metaValue" class="form-group">
						<label class="metaValue">Meta Description (SEO) 150-160 characters</label>
						<span class="count-characters"></span>
						<textarea name="metaValue" placeholder="Input meta description (SEO) 150-160 characters" class="form-control"></textarea>
					</div>	
					<div id="frm-content" class="form-group">
						<label for="content">Content</label>
						<textarea name="content" id="editor"></textarea>
					</div>
					<!-- <div id="frm-shortContent" class="form-group">
						<label class="short-content">Description</label>
						<textarea name="shortContent" placeholder="Input description" class="form-control"></textarea>
					</div> -->
					<div id="frm-tb-content" class="form-group">
						<label>Table content</label><br>
						<table class="field block-style">
							<tbody class="sortable"></tbody>
						</table>
						<a href="javascript:void(0)" class="btn add-row">Add row</a>
					</div>
					<div id="frm-list-blog" class="form-group">
						<label for="title">Related Posts</label>
						<select multiple="multiple" name="list_blog[]" class="form-control select2">
                            @foreach ($list_blog as $item)
                                <option value="{{ $item->id }}"> {{ $item->title }} </option>
                            @endforeach
                        </select>
					</div>	
				</div>
				<div class="col-md-2 sidebar">
					<div class="gr-not-fixed">
						<section id="sb-country" class="box-wrap">
							<h2 class="title">Country</h2>
							<div class="desc list">
	                            <ul class="no-list-style list-item scrollbar-inner">
	                                {!! getListCheckParentCountry() !!}
	                            </ul>						
							</div>		
						</section>
						<?php $categories = get_categories();?>
						@if(!$categories->isEmpty())
						<section id="sb-categories" class="box-wrap">
							<h2 class="title">Category</h2>
							<div class="desc list">
								<div class="dropdown vs-drop">
		                            <a class="dropdown-toggle" href="#" role="button" id="dropdown-cat" data-toggle="dropdown">Category</a>
		                            @if($categories)
		                            <div class="dropdown-menu" aria-labelledby="dropdown-cat">
		                                <ul class="list-item">
		                                    @foreach($categories as $item)
		                                    <li><a href="#{{$item->slug}}" data-value="{{$item->id}}">{{$item->title}}</a></li>
		                                    @endforeach
		                                </ul>
		                            </div>
		                            @endif
		                        </div>							
							</div>						
						</section>
						@endif

						@if($list_blogger)
						<section id="sb-blogger" class="box-wrap">
							<h2 class="title">Blogger</h2>
							<select class="select2" name="blogger_id">
								<option value="">Choose blogger</option>
								@foreach($list_blogger as $item)
									<option value="{{ $item->id }}">{{ $item->title }}</option>
								@endforeach
							</select>				
						</section>
						@endif

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
						<section id="sb-image" class="box-wrap">
							<h2 class="title">Request one</h2>
							<div id="frm-image-request1" class="desc img-upload">							
								<div class="image">
									<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
									{!!image('', 150,150, 'Image')!!}
									<input type="hidden" name="image_request1" class="thumb-media" value="" />
								</div>
							</div>
						</section>
						<section id="sb-image" class="box-wrap">
							<h2 class="title">Looking</h2>
							<div id="frm-image-looking" class="desc img-upload">							
								<div class="image">
									<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
									{!!image('', 150,150, 'Image')!!}
									<input type="hidden" name="image_looking" class="thumb-media" value="" />
								</div>
							</div>
						</section>
						<section id="sb-image" class="box-wrap">
							<h2 class="title">Request Two</h2>
							<div id="frm-image-request2" class="desc img-upload">							
								<div class="image">
									<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
									{!!image('', 150,150, 'Image')!!}
									<input type="hidden" name="image_request2" class="thumb-media" value="" />
								</div>
							</div>
						</section>
						<section id="sb-status" class="box-wrap">
							<h2 class="title">Status</h2>
							<select name="status">
								<option value="1">Active</option>
								<option value="0">Inactive</option>
							</select>
						</section>
					</div>
					<div class="group-fixed">
						<section id="sb-action">
							<div class="group-action">
								<button type="submit" name="submit" class="btn">Save</button>
								<a href="{{route('blogAdmin')}}" class="btn btn-cancel">Cancel</a>									
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
       $("#create-news").on('click','form .group-action button',function(){
	       	var _token = $("form input[name='_token']").val();
	       	var title = $("#frm-title input").val();
	       	var title_tag = $("form #frm-title-tag input").val();
	       	var content = CKEDITOR.instances['editor'].getData();
	       	var shortContent = $("#frm-shortContent textarea").val(); 
	       	var metaKey = $("#frm-metaKey input").val();
	       	var metaValue = $("#frm-metaValue textarea").val();
	       	var image = $("#frm-image input").val();
	       	var image_request1 = $("#frm-image-request1 input").val();
	       	var image_looking = $("#frm-image-looking input").val();
	       	var image_request2 = $("#frm-image-request2 input").val();
	       	var status = $("#sb-status select").val();
	       	var catId = $("#sb-categories .dropdown-toggle").attr("data-value");
	       	var blogger_id = $('#sb-blogger select').val();
	       	var countries = new Array();
	       	var tableContent = new Array();
	       	var errors = new Array();
	       	var error_count = 0;
	       	var list_blog = $('#frm-list-blog select').val();
	       	$("#sb-categories .list .item").each(function(){
	       		if($(this).find("input").is(':checked')){
	       			categories.push($(this).find("input").val());
	       		}
	       	});
	       	$("#sb-country .list-item li").each(function(){
	       		if($(this).find("input").is(':checked')){
	       			countries.push($(this).find("input").val());
	       		}
	       	});

	       	//get data table content
	       	$('#frm-tb-content > table > tbody > tr').each(function(key){ 
	       		var ob_lv1 = {};
	       		var title_lv1 = $(this).find('> td:nth-child(2) > .tb-title input').val();
	       		var id_content_lv1 = $(this).find('> td:nth-child(2) > .tb-content textarea').attr('id');
	       		var content_lv1 = CKEDITOR.instances[id_content_lv1].getData(); 
	       		var position_lv1 = $(this).attr('data-position');
	       		var arr_child_lv1 = new Array();
	       		//get array child lv 2
	       		if($(this).find('.sortable-lv-2 > tr').length){
	       			$(this).find('.sortable-lv-2 > tr').each(function(){
	       				var ob_lv2 = {};
	       				var title_lv2 = $(this).find('> td:nth-child(2) > .tb-title input').val();
	       				var id_content_lv2 = $(this).find('> td:nth-child(2) > .tb-content textarea').attr('id');
	       				var content_lv2 = CKEDITOR.instances[id_content_lv2].getData();
	       				var position_lv2 = $(this).attr('data-position');
	       				var arr_child_lv2 = new Array(); 
	       				//get array child lv 3
			       		if($(this).find('.sortable-lv-3 > tr').length){
			       			$(this).find('.sortable-lv-3 > tr').each(function(){
			       				var ob_lv3 = {};
			       				var title_lv3 = $(this).find('> td:nth-child(2) > .tb-title input').val();
			       				var id_content_lv3 = $(this).find('> td:nth-child(2) > .tb-content textarea').attr('id');
	       						var content_lv3 = CKEDITOR.instances[id_content_lv3].getData();
			       				var position_lv3 = $(this).attr('data-position');
			       				ob_lv3.title = title_lv3;
			       				ob_lv3.content = content_lv3;
			       				ob_lv3.position = position_lv3;
			       				arr_child_lv2.push(ob_lv3);
			       			});
			       		}
			       		ob_lv2.title = title_lv2;
	       				ob_lv2.content = content_lv2;
	       				ob_lv2.position = position_lv2;
	       				ob_lv2.child = arr_child_lv2;
	       				arr_child_lv1.push(ob_lv2);
	       			});
	       		}
	       		ob_lv1.title = title_lv1;
   				ob_lv1.content = content_lv1;
   				ob_lv1.position = position_lv1;
   				ob_lv1.child = arr_child_lv1;
   				tableContent.push(ob_lv1);
	       	});

	       	if(title==""){
	       		errors[0] = "Please input title";
	       	}else{
				errors[0] = "";
	       	}
	       	if(catId==""){
	       		errors[1] = "Please choose category";
	       	}else{
				errors[1] = "";
	       	}
	       	var i;
	   		var html = "<ul>";
	       	for(i = 0; i < errors.length; i++){
	       		if(errors[i] != ""){
	       			html +='<li>'+errors[i]+'</li>';
	       			error_count += 1;
	       		}
	       	}   
	       	if(error_count>0){
		       	html += "</ul>";	       	
		       	new PNotify({
					title: 'Error ('+error_count+')',
					text: html,						    
					hide: true,
					delay: 6000,
				});
	       	}else{
				$.ajax({
					type:'POST',            
					url:'{{ route("createBlogAdmin") }}',
					cache: false,
					data:{
						'_token': _token,
						'title': title,
						'title_tag': title_tag,
						'content': content,
						'shortContent': shortContent,
						'metaKey': metaKey,
						'metaValue': metaValue,
						'image': image,
						'image_request1': image_request1,
						'image_looking': image_looking,
						'image_request2': image_request2,
						'status': status,
						'catId': catId,
						'blogger_id': blogger_id,
						'list_blog': list_blog,
						'countries': countries,
						'tableContent': JSON.stringify(tableContent)
					},
				}).done(function(data) {
					if(data=="success"){
						$("#frm-title input").val("");
						CKEDITOR.instances['editor'].setData("");
						$("#frm-shortContent textarea").val("");
						$("#frm-content textarea").val("");
						$("#frm-metaKey input").val("");
						$("#frm-metaValue textarea").val("");
						var img_url = location.protocol + "//" + location.host+'/image/noimage.png/150/150';
						$("#frm-image img").attr("src",img_url);
						$("#sb-categories .dropdown-toggle").attr("data-value","");
						$("#sb-categories .dropdown-toggle").text("Thể loại");
						$("#sb-country .dropdown-toggle").attr("data-value","");
						$("#sb-country .dropdown-toggle").text("Country");
						$("#sb-status .dropdown-toggle").text('Đã duyệt');
						$("#sb-status .dropdown-toggle").attr('data-value',2);
						categories = [];
				       	errors = [];
				       	error_count = 0;				       					       	
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
   });	
</script>
@stop