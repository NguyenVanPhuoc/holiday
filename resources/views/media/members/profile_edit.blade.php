@extends('templates.master')
@section('title','Tài khoản')
@section('content')
<?php $userMeta = getUserMeta($user->id);?>
<div id="edit-profile" class="page profile">
	<div class="container">
		<div class="pro-wrap">
			@include('members.profile_header')
			<div id="pro-main" class="row">			
				<div class="main col-md-10">
					<form action="{{ route('updateProfile') }}" method="post" name="editProfile" class="dev-form">
						{!! csrf_field() !!}
						<div id="frm-name" class="form-group">
							<label for="name">Họ & tên<small class="required">*</small></label>
							<input type="text" name="name" class="form-control" value="{{ $user->name }}"/>
						</div>									
						<div id="frm-about" class="form-group">
							<label for="about">Giới thiệu</label>
							<textarea name="about" class="form-control" rows="3">@if($userMeta){{ $userMeta->about }}@endif</textarea>
						</div>
						<div id="frm-address" class="form-group">
							<label for="address">Địa chỉ</label>
							<textarea name="address" class="form-control" rows="3">{{ $user->address }}</textarea>
						</div>
						<div id="frm-phone" class="form-group">
							<label for="phone">Điện thoại</label>
							<input type="text" name="phone" class="form-control" value="{{ $user->phone }}"/>
						</div>
						<div class="form-group custom-controls-stacked d-block my-3" id="sex">
							<label for="sex" class="lb-sex">Giới tính</label>
							<div class="radio radio-success radio-inline">
								<input name="sex" type="radio" id="sex-nam" class="custom-control-input" value="Nam" @if($user->sex == 'Nam') {{ "checked" }} @endif>
								<label for="sex-nam">Nam</label>
							</div>
							<div class="radio radio-success radio-inline">
								<input name="sex" type="radio" id="sex-nu" class="custom-control-input" value="Nữ" @if($user->sex == 'Nữ') {{ "checked" }} @endif>        
								<label for="sex-nu">Nữ</label>
							</div>										
						</div>									
						<div class="group-action">
							<button type="submit" name="submit" class="btn">Sửa</button>
							<a href="{{ route('newsProfile') }}" class="btn btn-cancel">Trở lại</a>
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