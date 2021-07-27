@extends('backend.layout.index')
@section('title','System')
@section('content')
<div id="system" class="container page">
	<div class="head"><h1 class="title">System</h1></div>
	@if(count($errors)>0)
	<div class="alert alert-danger">
		<ul>
			@foreach($errors->all() as $error)
			<li>{{$error}}</li>	
			@endforeach
		</ul>
	</div>
	@endif
	@if(session('success'))<div class="alert alert-success">{{session('success')}}</div>@endif
	<form action="{{ route('editSytem') }}" method="post" name="option" class="dev-form edit-post" enctype="multipart/form-data">
		{!! csrf_field() !!}
		<div class="row">
			<div class="col-md-3">
				<div id="logo" class="form-group img-upload">
					<label for="name">Logo</label>
					<div class="image">
						<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
						@if($option!=null && $option->logo!=null)
							{!!imageAuto($option->logo,'Logo')!!}
							<input type="hidden" name="logo" class="thumb-media" value="{{$option->logo }}" />
						@else
							{!!image('', 150,150, 'Logo')!!}
							<input type="hidden" name="logo" class="thumb-media" value="" />
						@endif
					</div>
				</div>
			</div>
			<div class="col-md-3">
				<div id="logo-colorful" class="form-group img-upload">
					<label for="name">Logo colorful</label>
					<div class="image">
						<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
						@if($option!=null && $option->logo_colorful!=null)
							{!!imageAuto($option->logo_colorful,'Logo colorful')!!}
							<input type="hidden" name="logo_colorful" class="thumb-media" value="{{$option->logo_colorful }}" />
						@else
							{!!image('', 150,150, 'Logo')!!}
							<input type="hidden" name="logo_colorful" class="thumb-media" value="" />
						@endif
					</div>
				</div>
			</div>
			<div class="col-md-3">
				<div id="favicon" class="form-group img-upload">
					<label for="name">Favicon</label>
					<div class="image">
						<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
						@if($option!=null && $option->favicon)
							{!!imageAuto($option->favicon, 'Logo')!!}
							<input type="hidden" name="favicon" class="thumb-media" value="{{$option->favicon }}" />
						@else
							{!!image('', 150,150, 'Logo')!!}
							<input type="hidden" name="favicon" class="thumb-media" value="" />
						@endif
					</div>
				</div>
			</div>
			<div class="col-md-3">
				<div id="sonabee" class="form-group img-upload">
					<label for="name">Logo Sonabee</label>
					<div class="image">
						<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
						@if($option!=null && $option->logo_sonabee)
							{!!imageAuto($option->logo_sonabee, 'Logo')!!}
							<input type="hidden" name="logo_sonabee" class="thumb-media" value="{{$option->logo_sonabee }}" />
						@else
							{!!image('', 150,150, 'Logo')!!}
							<input type="hidden" name="logo_sonabee" class="thumb-media" value="" />
						@endif
					</div>
				</div>
			</div>
		</div>	
		<div id="post-title" class="form-group">
			<label for="title">Tên website</label>
			@if($option!=null)
				<input type="text" name="title" class="form-control" value="{{ $option->title }}"/>
			@else				
				<input type="text" name="title" class="form-control"/>
			@endif			
		</div>
		<div id="phone" class="form-group">
			<label for="name">Điện thoại</label>
			@if($option!=null)
				<input type="text" name="phone" class="form-control" value="{{ $option->phone }}"/>
			@else				
				<input type="text" name="phone" class="form-control"/>
			@endif			
		</div>
		<div id="email" class="form-group">
			<label for="name">Email</label>
			@if($option!=null)
				<input type="email" name="email" class="form-control" value="{{ $option->email }}"/>
			@else				
				<input type="text" name="email" class="form-control"/>
			@endif			
		</div>
		<div id="address" class="form-group">
			<label for="name">Địa chỉ</label>
			@if($option!=null)
				<textarea name="address"  class="form-control">{{ $option->address }}</textarea>
			@else				
				<textarea name="address"  class="form-control"></textarea>
			@endif			
		</div>	
		<div id="copyright" class="form-group">
			<label for="name">Copyright</label>
			@if($option!=null)
				<textarea type="text" name="copyright" class="form-control"/>{{ $option->copyright}}</textarea>
			@else				
				<textarea type="text" name="copyright" class="form-control"/></textarea>
			@endif			
		</div>
		<div id="sb-pages" class="form-group">
			<label for="name">{{ __('Choose pages repeater') }}</label>
			<div class="form-group">
				<select name="page_id[]" class="form-control select2 multiple" multiple required>
					{!! display_pages_option(json_decode($option->page_id)) !!}
				</select>
			</div>
		</div>
		<div id="sb-gallery" class="form-group">
			<label for="name">{{ __('Choose pages gallery') }}</label>
			<div class="form-group">
				<select name="show_gallery[]" class="form-control select2 multiple" multiple required>
					{!! display_pages_option(json_decode($option->show_gallery)) !!}
				</select>
			</div>
		</div>
		<div class="group-action">
			<button type="submit" class="btn">Sửa</button>
		</div>
	</form>
</div>
@include('backend.media.library')
@stop