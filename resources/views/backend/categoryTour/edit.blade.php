@extends('backend.layout.index')
@section('title','Sửa danh mục')
@section('content')
<div id="edit-category" class="container page route">
	<div class="head">
		<a href="{{route('catTourAdmin')}}" class="back-icon"><i class="fa fa-angle-left" aria-hidden="true"></i> Danh mục</a>
		<h1 class="title">Edit tour style</h1>		
	</div>
	<div class="main">
		<div class="row">			
			<form action="{{ route('updateCatTourAdmin', $cat->slug) }}" class="frm-menu dev-form activity-form" method="POST" role="form">
				{!!csrf_field()!!}
				<div class="col-md-9">
					<div id="frm-title" class="form-group">
						<label for="title">Title<small class="required">(*)</small></label>
						<input type="text" name="title" class="form-control" value="{{$cat->title}}" placeholder="Input title" class="frm-input">
					</div>
					<div id="frm-slug" class="form-group">
						<label for="slug">Slug<small class="required">(*)</small></label>
						<div class="wrap">
							<span>{{$cat->slug}}</span>
							<input type="text" name="slug" value="{{ $cat->slug }}" class="form-control hide" />
							<a href="#" class="edit-slug">Edit</a>
							<a href="#" class="btn save-slug hide">OK</a>
							<a href="#" class="cancel hide">Cancel</a>
						</div>
					</div>
					<div id="frm-content" class="form-group">
						<label for="content">Description</label>
						<textarea name="desc" id="editor">{{$cat->desc}}</textarea>
					</div>	
					<div class="row">
						<div class="col-md-3">
							<div id="frm-white-icon" class="form-group img-upload">
								<label>White Icon</label>
								<div class="image">
									<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
									{!!image($cat->white_icon, 150,150, $cat->title)!!}
									<input type="hidden" name="white_icon" class="thumb-media" value="{{ $cat->white_icon }}" />
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<div id="frm-pink-icon" class="form-group img-upload">
								<label>Pink Icon</label>
								<div class="image">
									<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
									{!!image($cat->pink_icon, 150,150, $cat->title)!!}
									<input type="hidden" name="pink_icon" class="thumb-media" value="{{ $cat->pink_icon }}" />
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<div id="frm-gray-icon" class="form-group img-upload">
								<label>Gray Icon</label>
								<div class="image">
									<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
									{!!image($cat->gray_icon, 150,150, $cat->title)!!}
									<input type="hidden" name="gray_icon" class="thumb-media" value="{{ $cat->gray_icon }}" />
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<div id="frm-green-icon" class="form-group img-upload">
								<label>Green Icon</label>
								<div class="image">
									<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
									{!!image($cat->green_icon, 150,150, $cat->title)!!}
									<input type="hidden" name="green_icon" class="thumb-media" value="{{ $cat->green_icon }}" />
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-3 sidebar">
					<div class="gr-not-fixed">
						<div class="box-wrap">
							<div id="frm-image" class="form-group img-upload">
								<label>Image</label>
								<div class="image">
									<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
									{!!image($cat->image, 150,150, $cat->title)!!}
									<input type="hidden" name="image" class="thumb-media" value="{{ $cat->image }}" />
								</div>
							</div>
						</div>
						<section class="sb-time-info">
							<ul class="list-unstyled">
								<li><strong>Created at:</strong> {{ date('d M Y H:i', strtotime($cat->created_at)) }}</li>
								<li><strong>Updated at:</strong> {{ date('d M Y H:i', strtotime($cat->updated_at)) }}</li>
							</ul>
						</section>
					</div>
					<div class="group-fixed">
						<div class="group-action">
							<a href="{{ route('deleteCatTourAdmin', $cat->id) }}" class="btn btn-delete">Delete</a>
							<button type="submit" name="submit" class="btn">Save</button>
							<a href="{{route('catTourAdmin')}}" class="btn btn-cancel">Cancel</a>							
						</div>
					</div>
				</div>
			</form>

		</div>				
	</div>
</div>
@include('backend.media.library')
<script type="text/javascript">
	ckeditor("editor");
	/*$(function() {
		$("#edit-category").on('click','form .group-action button',function(){
			var _token = $("form input[name='_token']").val();
			var title = $("#frm-title input").val();
			var desc = CKEDITOR.instances['editor'].getData();
			var image = $("#frm-image input").val();
			var white_icon = $("#frm-white-icon input").val();
			var pink_icon = $("#frm-pink-icon input").val();
			var gray_icon = $("#frm-gray-icon input").val();
			if(title==""){
				new PNotify({
					title: 'Lỗi',
					text: 'Vui lòng nhập tên danh mục!.',
					hide: true,
					delay: 2000,
				});
			}else{
				$.ajax({
					type:'POST',            
					url:'{{ route("updateCatTourAdmin", ["slug"=>$cat->slug]) }}',
					cache: false,
					data:{
						'_token': _token,
						'title': title,
						'desc': desc,
						'image': image,
						'white_icon': white_icon,
						'pink_icon': pink_icon,
						'gray_icon': gray_icon,
					},
				}).done(function(data) {
					if(data=="success"){
						new PNotify({
							title: 'Thành công',
							text: 'Thêm danh mục thành công.',
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

		//delete location
      	$(".dev-form .btn-delete").click(function(){
      		var href = $(this).attr("href");
      		(new PNotify({
			    title: 'Xóa',
			    text: 'Bạn muốn xóa tin này?',
			    icon: 'glyphicon glyphicon-question-sign',
			    type: 'error',
			    hide: false,
			    confirm: {
			        confirm: true
			    },
			    buttons: {
			        closer: false,
			        sticker: false
			    },
			    history: {
			        history: false
			    }
			})).get().on('pnotify.confirm', function() {			    
			    window.location.href = href;
			});
			return false;
      	});
	});	*/
</script>
@stop