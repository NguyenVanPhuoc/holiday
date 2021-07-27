@extends('templates.master')
@section('title','Tài khoản')
@section('content')
<div id="profile" class="page profile">
	<div class="container">
		<div class="pro-wrap">
			@include('members.profile_header')
			<div id="pro-main" class="row">			
				<div class="main col-md-10">
					Chưa có bài viết nào!
				</div>
				<div class="sidebar col-md-2">@include('sidebars.member')</div>
			</div>
		</div>
	</div>
</div>
@endsection