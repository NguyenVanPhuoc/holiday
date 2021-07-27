@extends('templates.master')
@section('title','Sửa file')
@section('content')
<div id="edit-media" class="page profile media">
	<div class="container">
		<div class="pro-wrap">
			@include('members.profile_header')			
			<div id="pro-main" class="row">				
				<div class="main col-md-10">					
					<ul class="nav">
						<li><a href="{{route('mediaProfile')}}">Tất cả</a></li>
						<li><a href="{{route('storeMediaProfile')}}">Thêm mới</a></li>
					</ul>
					<form action="{{route('updateMediaProfile',['id'=>$media->id])}}" class="frm-menu dev-form" method="POST" name="editmedia" role="form">
						{!!csrf_field()!!}
						<div id="frm-title" class="form-group">
							<label for="urlImg">Tên file</label>
							<input type="text" name="title" class="form-control" placeholder="Nhập tên file" class="frm-input" value="{{$media->title}}">
						</div>
						<div id="frm-url" class="form-group">
							<label for="urlImg">URL</label>
							<input type="text" name="urlImg" class="form-control" class="frm-input" value="<?php echo url('/public/uploads').'/'.$media->image_path;?>" readonly>
						</div>
						<div id="frm-image" class="desc box-wrap">{!!imageAuto($media->id, $media->title)!!}</div>
						<div class="group-action">
							<a href="{{ route('deleteMediaProfile',['slug'=>$media->id]) }}" class="btn btn-delete">Xóa</a>
							<button type="submit" name="submit" class="btn">Lưu</button>
							<a href="{{route('mediaProfile')}}" class="btn btn-cancel">Hủy</a>									
						</div>								
					</form>
				</div>
				<div class="sidebar col-md-2">@include('sidebars.member')</div>
			</div>
		</div>
	</div>
</div>
@if(session('success'))
	<script type="text/javascript">
		$(document ).ready(function(){
			new PNotify({
		        title: 'Thành công',
		        text: 'Cập nhật thành công.',
		        type: 'success',
		        hide: true,
		        delay: 2000,
		    });
		})
	</script>
@endif
@if(count($errors)>0)
	<div class="alert alert-danger"><ul>@foreach($errors->all() as $error)<li>{{$error}}</li>@endforeach</ul></div>
	<script type="text/javascript">
		$(document ).ready(function(){
			new PNotify({
		        title: 'Lỗi',
		        text: $('.alert-danger').html(),
		        type: 'error',
		        hide: true,
		        delay: 2000,
		    });
		})
	</script>
@endif
@endsection