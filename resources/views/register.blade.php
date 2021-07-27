@extends('templates.auth')
@section('title','Đăng ký | Biigholiday')
@section('content')
<div id="login-page" class="page p-register">
	<div class="container">
		<div id="login-from" class="box">			
			<h1 id="logo"><a href="{{route('home')}}">{!! getLogo() !!}</a></h1>
			<p class="well-txt">Tạo tài khoản thật dễ dàng!</p>						
			<div class="alert alert-danger print-error-msg" style="display:none">
        	<ul></ul></div>
			<form action="{{ route('postRegister') }}" method="post" name="register" role="form" class="register-frm">
			{!! csrf_field() !!}
				<div id="frm-name" class="form-group">
					<input type="text" placeholder="Họ và tên" name="name" class="txt"/>						
				</div>
				<div id="frm-email" class="form-group"><input type="email" placeholder="Email" name="email" class="txt"/></div>
				<div id="frm-pass" class="form-group"><input type="password" placeholder="Mật khẩu" name="password" class="txt"/></div>
				<div id="frm-passConfirm" class="form-group"><input type="password" placeholder="Nhập lại mật khẩu" name="passConfirm" class="txt"/></div>
				<div id="frm-captcha" class="form-group">
					<div class="input-group">
						<input type="text" name="captcha" class="form-control" placeholder="Vui lòng nhập captcha">
						<div class="input-group-addon">{!!captcha_img()!!}<i class="fas fa-sync-alt"></i></div>
					</div>												
				</div>
				<div id="frm-submit" class="form-group">
					<input type="submit" name="submit" value="Đăng ký" class="btn">
				</div>
			</form>
			<div class="bottom">
				<p class="login-txt">Bạn đã có tài khoản? <a href="{{ route('login') }}">Đăng nhập ngay</a></p>
				<p class="note">Chọn đăng ký là bạn đã đồng ý với <a href="#">Điều khoản & dịch vụ của của chúng tôi</a>.</p>
			</div>
		</div>
	</div>
</div>
@endsection