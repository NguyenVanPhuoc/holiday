@extends('backend.layout.index')
@section('title','Sửa ảnh')
@section('content')
<div id="edit-media" class="container page route">
	<div class="head">
		<a href="{{route('media')}}" class="back-icon"><i class="fa fa-angle-left" aria-hidden="true"></i> Danh mục</a>
		<h1 class="title">{{$media->image_path}}</h1>		
	</div>
	<div class="main">
		<form action="{{route('updateMedia',['id'=>$media->id])}}" class="frm-menu dev-form" method="POST" name="editmedia" role="form">
			{!!csrf_field()!!}
			<div class="row">
				<div class="col-md-9 content">
					<div id="frm-title" class="form-group">
						<label for="title">Tên file</label>
						<input type="text" name="title" class="form-control frm-input" placeholder="Nhập tiêu đề" value="{{$media->title}}">
					</div>
					<div id="frm-url" class="form-group">
						<label for="url">URL</label>
						<input type="text" name="url" class="form-control frm-input" value="<?php echo url('/public/uploads').'/'.$media->image_path;?>" readonly>
					</div>
					@if(checkImage($media->type)==1)
					<div id="frm-attributes" class="row">
						<div id="frm-width" class="col-md-6 form-group">
							<label for="width">Width</label>
							<input type="text" name="width" class="form-control" class="frm-input" value="{{$media->width}}px" readonly>	
						</div>
						<div id="frm-height" class="col-md-6 form-group">
							<label for="height">Height</label>
							<input type="text" name="height" class="form-control" class="frm-input" value="{{$media->height}}px" readonly>	
						</div>
					</div>							
					@endif
					<div id="frm-size" class="form-group">
						<label for="size">Size</label>
						<input type="text" name="size" class="form-control" class="frm-input" value="{{formatSizeUnits($media->size)}}" readonly>
					</div>
					<div id="frm-caption" class="form-group">
						<label for="caption">Caption</label>
						<textarea name="caption" class="form-control" placeholder="Nhập caption" rows="3">{{$media->caption}}</textarea>
					</div>
					<div id="frm-alt" class="form-group">
						<label for="alt">Alt</label>
						<input type="text" name="alt" class="form-control frm-input" placeholder="Nhập alt" class="frm-input" value="{{$media->alt}}">
					</div>
					<div id="frm-desc" class="form-group">
						<label for="desc">Description</label>
						<textarea name="desc" class="form-control" placeholder="Nhập description" rows="3">{{$media->description}}</textarea>						
					</div>					
					<div id="frm-image" class="desc box-wrap">{!!imageAuto($media->id, $media->alt)!!}</div>
				</div>
				<div class="col-md-3 sidebar">					
					@if($mediaCat)
					<?php $catIds = explode(',',$media->cat_ids);?>
					<section id="sb-categories" class="box-wrap">
						<h2 class="title">Danh mục</h2>
						<div class="desc list">
							@foreach($mediaCat as $item)
								<div class="checkbox checkbox-success item">
									<input id="cat-{{$item->id}}" type="checkbox" name="medias[]" value="{{$item->id}}"<?php if(in_array($item->id,$catIds)) echo 'checked';?>>
									<label for="cat-{{$item->id}}">{{$item->title}}</label>
								</div>
							@endforeach
						</div>						
					</section>
					@endif					
				</div>
				<div class="col-md-9">
					<div class="group-action">
						<a href="{{ route('deleteMedia',['slug'=>$media->id]) }}" class="btn btn-delete">Xóa</a>
						<button type="submit" name="submit" class="btn">Lưu</button>
						<a href="{{route('media')}}" class="btn btn-cancel">Hủy</a>									
					</div>
				</div>
			</div>			
		</form>			
	</div>
</div>
<script type="text/javascript">
	$(function() {
		$("#edit-media").on('click','form .group-action button',function(){
			var _token = $("form input[name='_token']").val();
			var categories = new Array();
	       	var errors = new Array();
	       	var error_count = 0;
	       	$("#sb-categories .list .item").each(function(){
	       		if($(this).find("input").is(':checked')){
	       			categories.push($(this).find("input").val());
	       		}
	       	});
			if(categories.length==0){
				new PNotify({
					title: 'Lỗi',
					text: 'Vui lòng nhập danh mục!.',
					hide: true,
					delay: 2000,
				});
			}else{
				$.ajax({
					type:'POST',            
					url:'{{ route("updateMedia",["id"=>$media->id]) }}',
					cache: false,
					data:{
						'_token': _token,
						'title': $("#frm-title input").val(),
						'alt': $("#frm-alt input").val(),
						'caption': $("#frm-caption textarea").val(),
						'desc': $("#frm-desc textarea").val(),
						'categories': JSON.stringify(categories)
					},
				}).done(function(data) {
					if(data=="success"){
						new PNotify({
							title: 'Thành công',
							text: 'Cập nhật thành công.',
							type: 'success',
							hide: true,
							delay: 2000,
						});	
						location.reload();
					}           		
				});
			}       	
			return false;
		});
		//delete location
      	$(".btn-delete").click(function(){
      		var href = $(this).attr("href");
      		(new PNotify({
			    title: 'Xóa',
			    text: 'Bạn muốn danh mục này?',
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
      	})
	});	
</script>
@stop