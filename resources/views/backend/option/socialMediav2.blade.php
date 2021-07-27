@extends('backend.layout.index')
@section('title','Socical Media')
@section('content')
<div id="system" class="container page">
	<div class="head"><h1 class="title">Socical Media</h1></div>
	@if(count($errors)>0)
	<div class="alert alert-danger">
		<ul>
			@foreach($errors->all() as $error)
			<li>{{$error}}</li>	
			@endforeach
		</ul>
	</div>
	@endif
	@php 
	$str  = $option->social_media;
	$items = explode(';',$str);
	@endphp
	<div class="notify"></div>
	<form id="{{ $option->id }}" action="{{ route('editSocialv2') }}" method="post" name="option" class="option dev-form activity-form" enctype="multipart/form-data">
		{!!csrf_field()!!}
		@foreach($items as $item)
		@php
			$item = json_decode($item, true);
			$name = $item['name'];
			$link = $item['link'];
			$image = $item['image'];
		@endphp
			<div class="row">
				<div class="col-md-2 form-group">
					<label class="title">Image {{ $name }}</label>
					<div class="desc img-upload" id="{{ $name }}-img">							
						<div class="image">
							<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
							{!!image($image, 100,100, 'Image')!!}
							<input type="hidden" name="{{ $name }}_img" class="thumb-media" value="{{ $image }}" />
						</div>
					</div>
				</div>
				<div id="{{ $name }}" class="form-group col-md-10 padding">
					<label for="name">Link {{ $name }}</label>
					<input type="text" name="{{ $name }}" class="form-control" value="{{ $link }}" />
				</div>
			</div>
		@endforeach									
		<div class="group-action">
			<button type="submit" class="btn">Sửa</button>
		</div>
	</form>
</div>
@include('backend.media.library')
@stop