@extends('templates.master')
@section('title','Thêm file')
@section('content')
<div id="create-media" class="page profile">
	<div class="container">
		<div class="pro-wrap">
			@include('members.profile_header')			
			<div id="pro-main" class="row">				
				<div class="main col-md-10">					
					<ul class="nav">
						<li><a href="{{route('mediaProfile')}}">Tất cả</a></li>
						<li class="active"><a href="{{route('storeMediaProfile')}}">Thêm mới</a></li>
					</ul>
					<div id="dropzone">
						<form action="{{ route('createMediaProfile') }}" class="dropzone dev-form" id="my-awesome-dropzone">
							{!! csrf_field() !!}							
						</form>
						<div class="group-action">							
							<a href="{{route('mediaProfile')}}" class="btn btn-cancel">Hủy</a>									
						</div>
					</div>
				</div>
				<div class="sidebar col-md-2">@include('sidebars.member')</div>
			</div>
		</div>
	</div>
</div>
<link href="{{asset('public/css/dropzone.css')}}" rel="stylesheet">
<script src="{{asset('public/js/dropzone.js')}}" type="text/javascript"></script>
@endsection