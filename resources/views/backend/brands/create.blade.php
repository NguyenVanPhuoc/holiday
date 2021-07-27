@extends('backend.layout.index')
@section('title','Thêm đối tác')
@section('content')
<div id="create-brand" class="container page tour-page route">
	<div class="head">
		<a href="{{route('brandsAdmin')}}" class="back-icon"><i class="fa fa-angle-left" aria-hidden="true"></i> Đối tác</a>
		<h1 class="title">Thêm đối tác</h1>		
	</div>
	<div class="main">
		<form id="add-brand" action="#" method="post" name="addBrand" class="frm-menu dev-form">
			<input type="hidden" name="_token" value="{{csrf_token()}}"/>
					<div id="frm-title" class="form-group section">
						<label for="title">Tiêu đề<small>(*)</small></label>
						<input type="text" name="title" class="form-control"/>
					</div>
					<div id="frm-link" class="form-group section">
						<label for="title">Liên kết<small>(*)</small></label>
						<input type="text" name="link" class="form-control"/>
					</div>
					<div id="frm-image" class="form-group img-upload">							
						<div class="image">
							<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
							{!!image('', 150,150, 'Ảnh đại diện')!!}
							<input type="hidden" name="image" class="thumb-media" value="" />
						</div>
					</div>
			<div class="group-action">
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
		$("#create-brand").on('click','form .group-action button',function(){
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
					url:'{{ route("createBrandAdmin") }}',
					cache: false,
					data:{
						'_token': _token,
						'title': title,
						'link': link,
						'image': image,
					},
				}).done(function(data) {
					if(data=="success"){
						$("#frm-title input").val("");
						$("#frm-link input").val("");
						var img_url = location.protocol + "//" + location.host+'/image/noimage.png/150/150';
						$("#frm-image img").attr("src",img_url);
						$("#sb-routes .list .item input").prop('checked', false);
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