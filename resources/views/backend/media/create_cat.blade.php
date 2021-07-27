@extends('backend.layout.index')
@section('title','Thêm danh mục')
@section('content')
<div id="create-category" class="container page route">
	<div class="head">
		<a href="{{route('mediaCat')}}" class="back-icon"><i class="fa fa-angle-left" aria-hidden="true"></i> Danh mục</a>
		<h1 class="title">Thêm danh mục</h1>		
	</div>
	<div class="main">
		<form action="{{route('createMediaCat')}}" class="frm-menu dev-form" method="POST" name="createMediaCat" role="form">
			{!!csrf_field()!!}
			<div id="frm-title" class="form-group">
				<label for="title">Tên danh mục<small class="required">(*)</small></label>
				<input type="text" name="title" class="form-control" placeholder="Nhập danh mục" class="frm-input">
			</div>
			<div class="group-action">
				<button type="submit" name="submit" class="btn">Lưu</button>
				<a href="{{route('mediaCat')}}" class="btn btn-cancel">Hủy</a>							
			</div>
		</form>				
	</div>
</div>
<script type="text/javascript">
	$(function() {
		$("#create-category").on('click','form .group-action button',function(){
			var _token = $("form input[name='_token']").val();
			var title = $("#frm-title input").val();			
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
					url:'{{ route("createMediaCat") }}',
					cache: false,
					data:{
						'_token': _token,
						'title': title
					},
				}).done(function(data) {
					if(data=="success"){						
						$("#frm-title input").val("");						
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
	});	
</script>
@stop