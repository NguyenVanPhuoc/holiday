@extends('templates.master')
@section('title','Thêm tin')
@section('content')
<div id="create-news" class="container page news-page route">
	<div class="head">
		<a href="{{route('blogAdmin')}}" class="back-icon"><i class="fa fa-angle-left" aria-hidden="true"></i> Tất cả</a>
		<h1 class="title">Thêm tin</h1>		
	</div>	
	<div class="main">
		<form action="{{route('createBlogAdmin')}}" class="frm-menu dev-form" method="POST" name="create_tour" role="form">
			{!!csrf_field()!!}
			<div class="row">
				<div class="col-md-9 content">
					<div id="frm-title" class="form-group">
						<label for="title">Tiêu đề<small class="required">(*)</small></label>
						<input type="text" name="title" class="form-control" placeholder="Nhập tiêu đề" class="frm-input">
					</div>
					<div id="frm-content" class="form-group">
						<label for="content">Nội dung</label>
						<textarea name="content" id="editor"></textarea>
					</div>
					<div id="frm-shortContent" class="form-group">
						<label class="short-content">Mô tả ngắn</label>
						<textarea name="shortContent" placeholder="Nhập nội mô tả" class="form-control"></textarea>
					</div>
					<div id="frm-metaKey" class="form-group">
						<label for="metakey">Từ khóa</label>
						<input type="text" name="metakey" class="form-control" placeholder="Nhập từ khóa SEO" class="frm-input">
					</div>
					<div id="frm-metaValue" class="form-group">
						<label class="metaValue">Nội dung SEO</label>
						<textarea name="metaValue" placeholder="Nhập nội dung SEO" class="form-control"></textarea>
					</div>					
				</div>
				<div class="col-md-3 sidebar">
					<?php $categories = get_categories();?>
					@if(!$categories->isEmpty())
					<section id="sb-categories" class="box-wrap">
						<h2 class="title">Danh mục</h2>
						<div class="desc list">
							@foreach($categories as $item)
								<div class="checkbox checkbox-success item">
									<input id="category-{{$item->id}}" type="checkbox" name="routes[]" value="{{$item->id}}">
									<label for="category-{{$item->id}}">{{$item->title}}</label>
								</div>
							@endforeach
						</div>						
					</section>
					@endif
					<section id="sb-image" class="box-wrap">
						<h2 class="title">Ảnh đại diện</h2>
						<div id="frm-image" class="desc img-upload">							
							<div class="image">
								<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
								{!!image('', 150,150, 'Ảnh đại diện')!!}
								<input type="hidden" name="image" class="thumb-media" value="" />
							</div>
						</div>
					</section>
					<section id="sb-status" class="box-wrap">
						<h2 class="title">Trạng thái</h2>
						<div class="desc list dropdown local-dropdown">{!!getStatusHtml('b-status','')!!}</div>
					</section>
				</div>
				<div class="col-md-9">
					<div class="group-action">
						<button type="submit" name="submit" class="btn">Lưu</button>
						<a href="{{route('blogAdmin')}}" class="btn btn-cancel">Hủy</a>									
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
	       	var content = CKEDITOR.instances['editor'].getData();
	       	var shortContent = $("#frm-shortContent textarea").val();
	       	var metaKey = $("#frm-metaKey input").val();
	       	var metaValue = $("#frm-metaValue textarea").val();
	       	var image = $("#frm-image input").val();
	       	var status = $("#sb-status .dropdown-toggle").attr('data-value');
	       	var categories = new Array();
	       	var errors = new Array();
	       	var error_count = 0;
	       	$("#sb-categories .list .item").each(function(){
	       		if($(this).find("input").is(':checked')){
	       			categories.push($(this).find("input").val());
	       		}
	       	});
	       	if(title==""){
	       		errors[0] = "Vui lòng nhập tiêu đề";
	       	}else{
				errors[0] = "";
	       	}
	       	if(categories.length==0){
	       		errors[1] = "Vui lòng chọn danh mục";
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
					title: 'Lỗi dữ liệu ('+error_count+')',
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
						'content': content,
						'shortContent': shortContent,
						'metaKey': metaKey,
						'metaValue': metaValue,
						'image': image,
						'status': status,
						'categories': JSON.stringify(categories)
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
						$("#sb-categories .list .item input").prop('checked', false);
						$("#sb-status .dropdown-toggle").text('Đã duyệt');
						$("#sb-status .dropdown-toggle").attr('data-value',2);
						categories = [];
				       	errors = [];
				       	error_count = 0;				       					       	
						new PNotify({
							title: 'Thành công',
							text: 'Thêm thành công.',
							type: 'success',
							hide: true,
							delay: 2000,
						});						
					}else{
						new PNotify({
							title: 'Lỗi',
							text: 'Trình duyệt không hỗ trợ javascript.',						    
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