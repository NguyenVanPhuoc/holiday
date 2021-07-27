@extends('backend.layout.index')
@section('title',$brand->title)
@section('content')
<div id="edit-brand" class="container page brands-page route">
	<div class="head">
		<a href="{{route('brandsAdmin')}}" class="back-icon"><i class="fa fa-angle-left" aria-hidden="true"></i> Đối tác</a>
		<h1 class="title">{{$brand->title}}</h1>		
	</div>
	<div class="main">
		<form id="edit-brand" action="#" method="post" name="editBrand" class="frm-menu dev-form">
			<input type="hidden" name="_token" value="{{csrf_token()}}"/>
					<div id="frm-title" class="form-group section">
						<label for="title">Tiêu đề<small>(*)</small></label>
						<input type="text" name="title" class="form-control" value="{{$brand->title}}" />
					</div>
					<div id="frm-link" class="form-group section">
						<label for="title">Liên kết<small>(*)</small></label>
						<input type="text" name="link" class="form-control" value="{{$brand->link}}" />
					</div>
					<div id="frm-image" class="form-group img-upload">							
						<div class="image">
							<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
							{!!image($brand->image, 150,150, $brand->title)!!}
							<input type="hidden" name="image" class="thumb-media" value="" />
						</div>
					</div>
			<div class="group-action">
				<a href="{{route('deleteBrandAdmin',['id'=>$brand->id])}}" class="btn btn-delete">Xóa</a>
				<a href="{{route('brandsAdmin')}}" class="btn btn-cancel">Hủy</a>
				<button type="submit" name="submit" class="btn">Lưu</button>			
			</div>
		</form>
	</div>
</div>
<div id="library-op" class="modal single" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">			
			<form action="{{ route('deleteMediaSingle')}}" name="media" method="post">
				{!! csrf_field() !!}
				<div class="modal-header">
					<h5 class="modal-title">Mời chọn file</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div id="files" class="col-md-10"></div>
						<div id="file-detail" class="col-md-2"></div>
					</div>
				</div>
				<div class="modal-footer">
					<span class="library-notify"></span>      	
					<a href="#" class="btn btn-primary">Đồng ý</a>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
				</div>
			</form>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(function() {
		$("#edit-brand").on('click','form .group-action button',function(){
			var _token = $("form input[name='_token']").val();
			var title = $("#frm-title input").val();
			var link = $("#frm-link input").val();
			var image = $("#frm-image input").val();
			var errors = new Array();
			var error_count = 0;
			if(title==""){
				errors[0] = "Vui lòng nhập tiêu đề";
			}else{
				errors[0] = "";
			}
			if(image==""){
				errors[1] = "Vui lòng chọn ảnh đối tác";
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
					url:'{{ route("editBrandAdmin",["slug"=>$brand->id]) }}',
					cache: false,
					data:{
						'_token': _token,
						'title': title,
						'link': link,
						'image': image,
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
      	$("#edit-brand .btn-delete").click(function(){
      		var href = $(this).attr("href");
      		(new PNotify({
			    title: 'Xóa',
			    text: 'Bạn muốn đối tác này?',
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