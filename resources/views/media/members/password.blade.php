@extends('templates.master')
@section('title','Đổi mật khẩu')
@section('content')
<div id="edit-password" class="page profile">
	<div class="container">
		<div class="pro-wrap">
			@include('members.profile_header')
			<div id="pro-main" class="row">			
				<div class="main col-md-10">
					<form action="{{ route('updatePassword') }}" method="post" name="updatePassword" class="dev-form">
						{!! csrf_field() !!}
						<div id="frm-oldPass" class="form-group">
							<label for="name">Mật khẩu cũ<small class="required">*</small></label>
							<input type="password" name="oldPass" placeholder="******" class="form-control" value="{{old('oldPass')}}"/>
						</div>
						<div id="frm-newPass" class="form-group">
							<label for="name">Mật khẩu mới<small class="required">*</small></label>
							<input type="password" name="newPass" class="form-control" value="{{old('newPass')}}"/>
						</div><div id="frm-confirmPass" class="form-group">
							<label for="confirmPass">Nhập lại mật khẩu<small class="required">*</small></label>
							<input type="password" name="confirmPass" class="form-control" value="{{old('confirmPass')}}"/>
						</div>
						<div class="group-action">
							<button type="submit" name="submit" class="btn">Sửa</button>
							<a href="{{ route('profile') }}" class="btn btn-cancel">Trở lại</a>
						</div>
					</form>
				</div>
				<div class="sidebar col-md-2">@include('sidebars.member')</div>
			</div>
		</div>
	</div>
</div>
</div>
@if(session('success'))
	<script type="text/javascript">
		$(document ).ready(function(){
			new PNotify({
		        title: 'Thành công',
		        text: '{{session("success")}}',
		        type: 'success',
		        hide: true,
		        delay: 2000,
		    });
		})
	</script>
@endif
@if(session('error'))
	<script type="text/javascript">
		$(document ).ready(function(){
			new PNotify({
		        title: 'Lỗi',
		        text: '{{session("success")}}',
		        type: 'error',
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
@stop