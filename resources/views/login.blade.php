@extends('templates.auth')
@section('title','Login | Biigholiday')
@section('content')
<div id="login-page" class="page">
	<div class="container">
		<div id="login-from" class="box">			
			<h1 id="logo"><a href="{{route('home')}}">{!! getLogo() !!}</a></h1>
			<p class="well-txt">Chào mừng bạn trở lại!</p>
			<form action="{{ route('postLogin') }}" method="post" name="login" role="form" class="login-form">
				<input type="hidden" name="_token" value="{{csrf_token()}}">
				<div class="form-group" id="frm-email"><input type="email" placeholder="Email của bạn" name="phone" class="txt"/></div>
				<div class="form-group" id="frm-pass"><input type="password" placeholder="Mật khẩu của bạn" name="password" class="txt"></div>
				<div class="form-group" id="frm-submit"><input type="submit" name="submit" value="Đăng nhập" class="btn"></div>
			</form>
			<ul class="login-social">
				<li><a href="#" class="fbook"><i class="fab fa-facebook-square"></i>Đăng nhập với Facebook</a></li>
				<li><a href="#" class="google"><i class="fab fa-google-plus-square"></i>Đăng nhập Google+</a></li>
			</ul>
			<div class="bottom">
				<p class="question-txt">Bạn quên mật khẩu? <a href="#">Phục hồi</a></p>
				<p class="regis-txt">Bạn chưa có tài khoản? <a href="{{route('register')}}">Đăng ký ngay</a></p>
			</div>
		</div>
	</div>
</div>
@endsection